@extends('layouts.admin')

@php
    $title = "Riwayat — Yan's Food";
@endphp

@section('content')
<div class="space-y-6">
    {{-- HEADER & FILTERS --}}
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-200 space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-stone-900 font-serif flex items-center gap-2">
                    <span>🧾</span>
                    <span>Riwayat Transaksi</span>
                </h1>
                <p class="text-xs text-stone-500 mt-0.5">Daftar riwayat transaksi dan struk kasir yang dikelompokkan secara terstruktur per bulan.</p>
            </div>
            <a href="{{ route('admin.pos.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#C1440E] hover:bg-[#a3380b] text-white rounded-xl font-bold text-xs shadow-sm transition">
                <span>+ Buka Kasir</span>
            </a>
        </div>

        <form action="{{ route('admin.transactions.index') }}" method="GET" class="pt-3 border-t border-stone-100 flex flex-wrap items-center gap-3 text-xs">
            <div class="flex-1 min-w-[200px]">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari nomor transaksi / nama pelanggan..." 
                    class="w-full px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]"
                >
            </div>

            {{-- FILTER BULAN --}}
            <div>
                <select name="month" class="px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                    <option value="all">Semua Bulan</option>
                    @foreach($availableMonths as $m)
                        <option value="{{ $m['key'] }}" {{ request('month') === $m['key'] ? 'selected' : '' }}>
                            {{ $m['label'] }} {{ $m['is_current'] ? '(Bulan Ini)' : '' }} ({{ $m['count'] }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <input 
                    type="date" 
                    name="date" 
                    value="{{ request('date') }}" 
                    class="px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]"
                    title="Filter Tanggal Spesifik"
                >
            </div>

            <div>
                <select name="method" class="px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                    <option value="all">Semua Metode</option>
                    <option value="CASH" {{ strtoupper(request('method')) === 'CASH' ? 'selected' : '' }}>Tunai (Cash)</option>
                    <option value="QRIS" {{ strtoupper(request('method')) === 'QRIS' ? 'selected' : '' }}>QRIS</option>
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-stone-800 text-white rounded-xl font-bold hover:bg-stone-900 transition">
                Filter
            </button>

            @if(request()->hasAny(['search', 'date', 'month', 'method']))
                <a href="{{ route('admin.transactions.index') }}" class="px-3 py-2 text-stone-500 hover:text-stone-800 font-bold transition">
                    Reset
                </a>
            @endif
        </form>

        {{-- QUICK MONTH NAVIGATION PILLS --}}
        @if($availableMonths->count() > 0)
            <div class="pt-2 flex items-center gap-1.5 overflow-x-auto pb-1 text-xs">
                <span class="text-[11px] font-bold text-stone-400 uppercase tracking-wider mr-1">Pilih Bulan:</span>
                <a 
                    href="{{ route('admin.transactions.index', array_merge(request()->except('month'), ['month' => 'all'])) }}"
                    class="px-3 py-1 rounded-lg font-bold text-xs transition {{ (!request('month') || request('month') === 'all') ? 'bg-stone-900 text-white shadow-xs' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}"
                >
                    Semua Bulan
                </a>
                @foreach($availableMonths as $m)
                    <a 
                        href="{{ route('admin.transactions.index', array_merge(request()->except('month'), ['month' => $m['key']])) }}"
                        class="px-3 py-1 rounded-lg font-bold text-xs transition flex items-center gap-1.5 {{ request('month') === $m['key'] ? 'bg-[#C1440E] text-white shadow-xs' : 'bg-stone-100 text-stone-700 hover:bg-stone-200' }}"
                    >
                        <span>{{ $m['label'] }}</span>
                        @if($m['is_current'])
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse" title="Bulan Berjalan"></span>
                        @endif
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ request('month') === $m['key'] ? 'bg-white/20 text-white' : 'bg-stone-200 text-stone-600' }}">
                            {{ $m['count'] }}
                        </span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    {{-- TOTAL BANNER --}}
    <div class="bg-gradient-to-r from-amber-600 to-[#C1440E] text-white p-5 rounded-2xl shadow-sm flex items-center justify-between">
        <div>
            <span class="text-xs uppercase font-bold tracking-wider opacity-85">
                Total Omset Transaksi Sesuai Filter
                @if(request('month') && request('month') !== 'all')
                    ({{ \Carbon\Carbon::createFromFormat('Y-m', request('month'))->translatedFormat('F Y') }})
                @endif
            </span>
            <h2 class="text-2xl font-black mt-1 font-mono">Rp {{ number_format($totalFilteredAmount, 0, ',', '.') }}</h2>
        </div>
        <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center text-2xl">
            🧾
        </div>
    </div>

    {{-- TRANSACTIONS SECTIONS PER BULAN --}}
    @forelse($groupedTransactions as $monthKey => $monthItems)
        @php
            try {
                $monthDate = \Carbon\Carbon::createFromFormat('Y-m', $monthKey);
                $monthTitle = $monthDate->translatedFormat('F Y');
            } catch (\Throwable $e) {
                $monthTitle = $monthKey;
            }

            $isCurrentMonth = ($monthKey === $currentMonthKey);
            $monthTxCount = $monthItems->where('status', 'completed')->count();
            $monthTotal = $monthItems->where('status', 'completed')->sum('total');
            $cashTotal = $monthItems->where('status', 'completed')->where('payment_method.value', 'CASH')->sum('total');
            if ($cashTotal == 0) {
                $cashTotal = $monthItems->where('status', 'completed')->where('payment_method', 'CASH')->sum('total');
            }
            $qrisTotal = $monthItems->where('status', 'completed')->where('payment_method.value', 'QRIS')->sum('total');
            if ($qrisTotal == 0) {
                $qrisTotal = $monthItems->where('status', 'completed')->where('payment_method', 'QRIS')->sum('total');
            }
        @endphp

        <div class="bg-white rounded-2xl shadow-sm border border-stone-200 overflow-hidden space-y-0">
            {{-- MONTH SECTION HEADER --}}
            <div class="p-4 sm:p-5 bg-gradient-to-r from-stone-50 via-amber-50/20 to-white border-b border-stone-200 flex flex-col lg:flex-row lg:items-center justify-between gap-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl {{ $isCurrentMonth ? 'bg-[#C1440E] text-white' : 'bg-stone-200 text-stone-700' }} flex items-center justify-center font-bold text-sm shadow-xs">
                        🗓️
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-base font-black text-stone-900 font-serif">
                                Riwayat Transaksi: {{ $monthTitle }}
                            </h2>
                            @if($isCurrentMonth)
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                                    <span>Bulan Berjalan (Real-time)</span>
                                </span>
                            @else
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-stone-100 text-stone-600 border border-stone-200">
                                    Arsip Riwayat
                                </span>
                            @endif
                        </div>
                        <p class="text-[11px] text-stone-500 mt-0.5">Seluruh transaksi penjualan kasir pada bulan {{ $monthTitle }}</p>
                    </div>
                </div>

                {{-- MONTH KPI SUMMARY CHIPS --}}
                <div class="flex flex-wrap items-center gap-2 text-xs">
                    <span class="px-2.5 py-1 bg-stone-100 text-stone-700 rounded-lg font-bold">
                        {{ $monthTxCount }} Transaksi
                    </span>
                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-lg font-bold font-mono">
                        Cash: Rp {{ number_format($cashTotal, 0, ',', '.') }}
                    </span>
                    <span class="px-2.5 py-1 bg-sky-50 text-sky-800 border border-sky-200 rounded-lg font-bold font-mono">
                        QRIS: Rp {{ number_format($qrisTotal, 0, ',', '.') }}
                    </span>
                    <span class="px-3 py-1 bg-stone-900 text-white rounded-lg font-black font-mono">
                        Total: Rp {{ number_format($monthTotal, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- TRANSACTIONS TABLE UNTUK BULAN INI --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-stone-50/75 text-stone-600 font-bold border-b border-stone-200 uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="py-3 px-4">No. Transaksi</th>
                            <th class="py-3 px-4">Tanggal &amp; Jam</th>
                            <th class="py-3 px-4">Pelanggan</th>
                            <th class="py-3 px-4">Kasir</th>
                            <th class="py-3 px-4 text-center">Metode</th>
                            <th class="py-3 px-4 text-right">Subtotal</th>
                            <th class="py-3 px-4 text-right">Total</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach($monthItems as $tx)
                            @php
                                $methodVal = $tx->payment_method instanceof \App\Enums\PaymentMethod 
                                    ? $tx->payment_method->value 
                                    : (string) $tx->payment_method;
                            @endphp
                            <tr class="hover:bg-amber-50/30 transition">
                                <td class="py-3.5 px-4 font-mono font-bold text-stone-900">
                                    <a href="{{ route('admin.transactions.show', $tx->id) }}" class="hover:text-[#C1440E] hover:underline">
                                        {{ $tx->transaction_number }}
                                    </a>
                                </td>
                                <td class="py-3.5 px-4 font-mono text-stone-600">
                                    {{ \Carbon\Carbon::parse($tx->transaction_date)->format('d M Y') }} 
                                    <span class="text-stone-400 font-semibold text-[11px]">{{ substr($tx->transaction_time, 0, 5) }} WIB</span>
                                </td>
                                <td class="py-3.5 px-4 font-bold text-stone-900">
                                    {{ $tx->customer_name ?: '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-stone-700">
                                    {{ $tx->cashier?->name ?? 'Kasir' }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    @if(strtoupper($methodVal) === 'QRIS')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full font-bold text-[10px] bg-sky-50 text-sky-700 border border-sky-200">
                                            <span class="material-symbols-outlined text-[13px]">qr_code_2</span>
                                            <span>QRIS</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full font-bold text-[10px] bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="material-symbols-outlined text-[13px]">payments</span>
                                            <span>CASH</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-right font-medium text-stone-600 font-mono">
                                    Rp {{ number_format($tx->subtotal, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4 text-right font-black text-sm text-[#C1440E] font-mono">
                                    Rp {{ number_format($tx->total, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase {{ $tx->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                        {{ $tx->status === 'completed' ? 'Selesai' : 'Batal' }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="inline-flex items-center gap-1.5">
                                        <a href="{{ route('admin.transactions.receipt', $tx->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1 bg-stone-900 hover:bg-black text-white rounded-lg font-bold text-[11px] transition shadow-xs" title="Cetak / Buka Struk">
                                            <span class="material-symbols-outlined text-[13px]">receipt</span>
                                            <span>Struk</span>
                                        </a>
                                        <a href="{{ route('admin.transactions.show', $tx->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-lg font-bold text-[11px] transition" title="Lihat Rincian Item">
                                            <span>Detail</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-2xl shadow-sm border border-stone-200 p-12 text-center text-stone-400 space-y-2">
            <div class="text-4xl">📭</div>
            <h3 class="text-stone-700 font-bold text-sm">Tidak ada transaksi ditemukan</h3>
            <p class="text-xs text-stone-400">Tidak ada catatan transaksi yang sesuai dengan filter atau periode yang Anda pilih.</p>
        </div>
    @endforelse

    {{-- PAGINATION --}}
    @if($transactions->hasPages())
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-stone-200">
            {{ $transactions->links() }}
        </div>
    @endif
</div>
@endsection
