<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    /**
     * Menampilkan daftar pengeluaran dengan filter pencarian, kategori, dan tanggal
     */
    public function index(Request $request)
    {
        $query = Expense::query()->orderBy('expense_date', 'desc')->orderBy('id', 'desc');

        // Filter Pencarian Teks (Nama atau Nomor Pengeluaran)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('expense_number', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Filter Kategori
        if ($request->filled('category') && $request->category !== 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        // Filter Tanggal Spesifik (Single Date)
        if ($request->filled('date')) {
            $query->whereDate('expense_date', $request->date);
        }

        // Filter Rentang Tanggal (Start Date & End Date)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('expense_date', [$request->start_date, $request->end_date]);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('expense_date', '>=', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->whereDate('expense_date', '<=', $request->end_date);
        }

        // Filter Bulan (opsional jika dikirim)
        if ($request->filled('month') && $request->month !== 'all') {
            $query->where('expense_date', 'like', $request->month . '%');
        }

        // Daftar riwayat bulan yang tersedia untuk pengeluaran
        $currentMonthKey = now()->format('Y-m');
        $availableMonths = Expense::where('status', 'APPROVED')
            ->selectRaw("
                DATE_FORMAT(expense_date, '%Y-%m') as month_key,
                COUNT(*) as exp_count,
                COALESCE(SUM(amount), 0) as total_amount
            ")
            ->groupBy('month_key')
            ->orderByDesc('month_key')
            ->get()
            ->map(function ($item) use ($currentMonthKey) {
                try {
                    $date = \Carbon\Carbon::createFromFormat('Y-m', $item->month_key);
                    $label = $date->translatedFormat('F Y');
                    $short = $date->translatedFormat('M Y');
                } catch (\Throwable $e) {
                    $label = $item->month_key;
                    $short = $item->month_key;
                }
                return [
                    'key' => $item->month_key,
                    'label' => $label,
                    'short_label' => $short,
                    'count' => (int) $item->exp_count,
                    'total' => (float) $item->total_amount,
                    'is_current' => $item->month_key === $currentMonthKey,
                ];
            });

        $totalExpenses = (float) (clone $query)->where('status', 'APPROVED')->sum('amount');
        $expenses = $query->with(['category', 'creator'])->paginate(50)->withQueryString();

        // Kelompokkan data pengeluaran per bulan untuk dijadikan section per bulan
        $groupedExpenses = $expenses->getCollection()->groupBy(function ($exp) {
            return \Carbon\Carbon::parse($exp->expense_date)->format('Y-m');
        });

        $categories = ExpenseCategory::whereNotIn('name', ['Maintenance', 'Transportasi', 'maintenance', 'transportasi'])
            ->orderBy('name')
            ->pluck('name')
            ->toArray();
        if (empty($categories)) {
            $categories = [
                'Bahan Baku',
                'Gas',
                'Listrik',
                'Air',
                'Kemasan',
                'Peralatan',
                'Lain-lain',
            ];
        }

        return view('admin.expenses.index', compact(
            'expenses',
            'groupedExpenses',
            'availableMonths',
            'currentMonthKey',
            'totalExpenses',
            'categories'
        ));
    }

    /**
     * Halaman form tambah pengeluaran baru
     */
    public function create()
    {
        $categories = ExpenseCategory::whereNotIn('name', ['Maintenance', 'Transportasi', 'maintenance', 'transportasi'])
            ->orderBy('name')
            ->pluck('name')
            ->toArray();
        if (empty($categories)) {
            $categories = [
                'Bahan Baku',
                'Gas',
                'Listrik',
                'Air',
                'Kemasan',
                'Peralatan',
                'Lain-lain',
            ];
        }

        return view('admin.expenses.create', compact('categories'));
    }

    /**
     * Menyimpan data pengeluaran baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'amount' => ['required', 'numeric', 'min:1'],
            'expense_date' => ['required', 'date'],
            'payment_method' => ['required', 'in:CASH,TRANSFER'],
            'description' => ['nullable', 'string'],
            'receipt_image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('receipt_image')) {
            $validated['receipt_image'] = $request->file('receipt_image')->store('expenses', 'public');
        }

        $category = ExpenseCategory::firstOrCreate(['name' => $validated['category']]);
        $validated['category_id'] = $category->id;
        unset($validated['category']);

        $validated['expense_number'] = 'EXP-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
        $validated['status'] = 'APPROVED';
        $validated['created_by'] = Auth::id() ?? 1;

        Expense::create($validated);

        return redirect()->route('admin.expenses.index')
            ->with('success', 'Catatan pengeluaran dapur berhasil disimpan!');
    }

    /**
     * Menampilkan detail informasi pengeluaran
     */
    public function show(Expense $expense)
    {
        $expense->load(['category', 'creator']);
        return view('admin.expenses.show', compact('expense'));
    }

    /**
     * Halaman form edit pengeluaran
     */
    public function edit(Expense $expense)
    {
        $categories = ExpenseCategory::whereNotIn('name', ['Maintenance', 'Transportasi', 'maintenance', 'transportasi'])
            ->orderBy('name')
            ->pluck('name')
            ->toArray();
        if (empty($categories)) {
            $categories = [
                'Bahan Baku',
                'Gas',
                'Listrik',
                'Air',
                'Kemasan',
                'Peralatan',
                'Lain-lain',
            ];
        }

        $expense->load('category');

        return view('admin.expenses.edit', compact('expense', 'categories'));
    }

    /**
     * Memperbarui data pengeluaran yang sudah ada
     */
    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'amount' => ['required', 'numeric', 'min:1'],
            'expense_date' => ['required', 'date'],
            'payment_method' => ['required', 'in:CASH,TRANSFER'],
            'description' => ['nullable', 'string'],
            'receipt_image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('receipt_image')) {
            // Hapus file nota lama jika ada
            if ($expense->receipt_image && Storage::disk('public')->exists($expense->receipt_image)) {
                Storage::disk('public')->delete($expense->receipt_image);
            }
            $validated['receipt_image'] = $request->file('receipt_image')->store('expenses', 'public');
        }

        $category = ExpenseCategory::firstOrCreate(['name' => $validated['category']]);
        $validated['category_id'] = $category->id;
        unset($validated['category']);

        $expense->update($validated);

        return redirect()->route('admin.expenses.index')
            ->with('success', 'Catatan pengeluaran berhasil diperbarui!');
    }

    /**
     * Menghapus catatan pengeluaran
     */
    public function destroy(Expense $expense)
    {
        // Hapus file nota jika ada
        if ($expense->receipt_image && Storage::disk('public')->exists($expense->receipt_image)) {
            Storage::disk('public')->delete($expense->receipt_image);
        }

        $expense->delete();

        return redirect()->route('admin.expenses.index')
            ->with('success', 'Catatan pengeluaran berhasil dihapus!');
    }
}
