<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::query()->orderBy('expense_date', 'desc');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('expense_number', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        if ($request->filled('month')) {
            $query->where('expense_date', 'like', $request->month . '%');
        }

        $totalExpenses = (float) (clone $query)->where('status', 'APPROVED')->sum('amount');
        $expenses = $query->with('category')->paginate(15)->withQueryString();

        $categories = \App\Models\ExpenseCategory::orderBy('name')->pluck('name')->toArray();
        if (empty($categories)) {
            $categories = [
                'Bahan Baku',
                'Gas',
                'Listrik',
                'Air',
                'Kemasan',
                'Transportasi',
                'Peralatan',
                'Maintenance',
                'Lain-lain',
            ];
        }

        return view('admin.expenses.index', compact('expenses', 'totalExpenses', 'categories'));
    }

    public function create()
    {
        $categories = \App\Models\ExpenseCategory::orderBy('name')->pluck('name')->toArray();
        if (empty($categories)) {
            $categories = [
                'Bahan Baku',
                'Gas',
                'Listrik',
                'Air',
                'Kemasan',
                'Transportasi',
                'Peralatan',
                'Maintenance',
                'Lain-lain',
            ];
        }

        return view('admin.expenses.create', compact('categories'));
    }

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

        $category = \App\Models\ExpenseCategory::firstOrCreate(['name' => $validated['category']]);
        $validated['category_id'] = $category->id;
        unset($validated['category']);

        $validated['expense_number'] = 'EXP-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
        $validated['status'] = 'APPROVED';
        $validated['created_by'] = Auth::id() ?? 1;

        Expense::create($validated);

        return redirect()->route('admin.expenses.index')
            ->with('success', 'Catatan pengeluaran dapur berhasil disimpan!');
    }
}
