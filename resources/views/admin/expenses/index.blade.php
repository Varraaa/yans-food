@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-200 space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-stone-900 flex items-center gap-2">
                    <span>💸</span>
                    <span>Pencatatan Biaya & Pengeluaran Dapur</span>
                </h1>
                <p class="text-xs text-stone-500 mt-0.5">Kelola belanja bahan baku, gas, kemasan, dan operasional dapur.</p>
            </div>
            <a href="{{ route('admin.expenses.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#C1440E] hover:bg-[#a3380b] text-white rounded-xl font-bold text-xs shadow-sm transition">
                <span>+ Catat Pengeluaran Baru</span>
            </a>
        </div>

        <form action="{{ route('admin.expenses.index') }}" method="GET" class="pt-3 border-t border-stone-100 flex flex-wrap items-center gap-3 text-xs">
            <div class="flex-1 min-w-[200px]">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari deskripsi belanja..." 
                    class="w-full px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]"
                >
            </div>

            <div>
                <select name="category" class="px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                    <option value="all">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <input 
                    type="month" 
                    name="month" 
                    value="{{ request('month') }}" 
                    class="px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]"
                >
            </div>

            <button type="submit" class="px-4 py-2 bg-stone-800 text-white rounded-xl font-bold hover:bg-stone-900 transition">
                Filter
            </button>
        </form>
    </div>

    {{-- TOTAL EXPENSE BANNER --}}
    <div class="bg-gradient-to-r from-rose-600 to-red-700 text-white p-5 rounded-2xl shadow-sm flex items-center justify-between">
        <div>
            <span class="text-xs uppercase font-bold tracking-wider opacity-80">Total Pengeluaran Sesuai Filter</span>
            <h2 class="text-2xl font-black mt-1">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</h2>
        </div>
        <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center text-2xl">
            💸
        </div>
    </div>

    {{-- EXPENSES TABLE --}}
    <div class="bg-white rounded-2xl shadow-sm border border-stone-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-stone-50 text-stone-600 font-bold border-b border-stone-200 uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3 px-4">No. Pengeluaran</th>
                        <th class="py-3 px-4">Tanggal</th>
                        <th class="py-3 px-4">Nama Pengeluaran</th>
                        <th class="py-3 px-4">Kategori</th>
                        <th class="py-3 px-4 text-center">Metode</th>
                        <th class="py-3 px-4 text-right">Nominal</th>
                        <th class="py-3 px-4 text-center">Bukti Nota</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($expenses as $exp)
                        <tr class="hover:bg-amber-50/30 transition">
                            <td class="py-3.5 px-4 font-mono font-bold text-stone-800">{{ $exp->expense_number }}</td>
                            <td class="py-3.5 px-4 font-mono text-stone-600">{{ \Carbon\Carbon::parse($exp->expense_date)->format('d M Y') }}</td>
                            <td class="py-3.5 px-4 font-bold text-stone-900">
                                <div>{{ $exp->name }}</div>
                                @if($exp->description)
                                    <div class="text-[11px] text-stone-500 font-normal mt-0.5">{{ $exp->description }}</div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-stone-100 text-stone-700">
                                    {{ $exp->category }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center font-semibold text-stone-600">{{ $exp->payment_method }}</td>
                            <td class="py-3.5 px-4 text-right font-black text-rose-600 text-sm">
                                Rp {{ number_format($exp->amount, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($exp->receipt_image)
                                    <a href="{{ asset('storage/' . $exp->receipt_image) }}" target="_blank" class="text-xs text-[#C1440E] font-bold hover:underline">
                                        Lihat Nota
                                    </a>
                                @else
                                    <span class="text-stone-300">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-stone-400">
                                <div class="text-3xl mb-1">💸</div>
                                Belum ada catatan pengeluaran dapur.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-stone-200">
            {{ $expenses->links() }}
        </div>
    </div>
</div>
@endsection
