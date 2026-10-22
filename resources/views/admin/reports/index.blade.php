@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    {{-- TOP NAVIGATION: TABS & EXPORT BUTTON --}}
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-stone-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-2 overflow-x-auto text-xs pb-1 md:pb-0">
            <a 
                href="{{ route('admin.reports.index', array_merge(request()->query(), ['tab' => 'financial'])) }}"
                class="px-4 py-2.5 rounded-xl font-bold whitespace-nowrap transition flex items-center gap-2 {{ $activeTab === 'financial' ? 'bg-[#C1440E] text-white shadow' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}"
            >
                <span>⚖️</span>
                <span>Laba Rugi &amp; Arus Kas</span>
            </a>
            <a 
                href="{{ route('admin.reports.index', array_merge(request()->query(), ['tab' => 'pos'])) }}"
                class="px-4 py-2.5 rounded-xl font-bold whitespace-nowrap transition flex items-center gap-2 {{ $activeTab === 'pos' ? 'bg-[#C1440E] text-white shadow' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}"
            >
                <span>🍔</span>
                <span>Penjualan Kasir POS</span>
            </a>
        </div>

        <a 
            href="{{ route('admin.reports.export', request()->query()) }}"
            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs shadow-sm transition active:scale-[0.98]"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span>Export {{ $activeTab === 'financial' ? 'Laba Rugi' : 'Data POS' }} (CSV)</span>
        </a>
    </div>

    {{-- FILTER BAR: PERIOD SHORTCUTS & CUSTOM DATES --}}
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-stone-200 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-1.5 overflow-x-auto text-xs pb-1">
            @foreach([
                'today' => 'Hari Ini',
                'this_week' => 'Minggu Ini',
                'this_month' => 'Bulan Ini',
                'this_year' => 'Tahun Ini',
                'all' => 'Semua Waktu',
                'custom' => 'Custom Tanggal'
            ] as $key => $label)
                <a 
                    href="{{ route('admin.reports.index', array_merge(request()->query(), ['period' => $key])) }}"
                    class="px-3.5 py-1.5 rounded-lg font-bold transition {{ $period === $key ? 'bg-stone-900 text-white shadow-sm' : 'bg-stone-100 text-stone-700 hover:bg-stone-200' }}"
                >
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <form action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-wrap items-center gap-3 text-xs">
            <input type="hidden" name="tab" value="{{ $activeTab }}">
            <input type="hidden" name="period" value="{{ $period }}">

            @if($activeTab === 'pos')
                <div class="flex items-center gap-2">
                    <label class="text-stone-500 font-semibold">Produk:</label>
                    <select name="product_id" onchange="this.form.submit()" class="py-1.5 px-3 rounded-lg border border-stone-300 bg-stone-50 text-xs text-stone-800 focus:ring-1 focus:ring-[#C1440E]">
                        <option value="">Semua Menu Produk</option>
                        @foreach($products as $prod)
                            <option value="{{ $prod->id }}" {{ $productId == $prod->id ? 'selected' : '' }}>{{ $prod->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if($period === 'custom')
                <div class="flex items-center gap-2">
                    <input type="date" name="start_date" value="{{ $startDate }}" class="py-1.5 px-3 rounded-lg border border-stone-300 bg-white text-xs text-stone-800">
                    <span class="text-stone-400">s/d</span>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="py-1.5 px-3 rounded-lg border border-stone-300 bg-white text-xs text-stone-800">
                    <button type="submit" class="px-3 py-1.5 bg-stone-800 text-white font-bold rounded-lg text-xs">Terapkan</button>
                </div>
            @endif
        </form>
    </div>

    {{-- TAB 1: FINANCIAL / LABA RUGI --}}
    @if($activeTab === 'financial')
        @php
            $paySummary = $financialData['payment_summary'] ?? [
                'cash_count' => 0,
                'cash_total' => 0,
                'cash_percent' => 0,
                'qris_count' => 0,
                'qris_total' => 0,
                'qris_percent' => 0,
                'combined_count' => 0,
                'combined_total' => 0,
                'daily_breakdown' => [],
            ];
        @endphp

        <div class="space-y-6">
            {{-- 3 SUMMARY CARDS FOR PAYMENT METHODS (§12.2) --}}
            <div>
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h3 class="text-sm font-black text-stone-900 uppercase tracking-wider">3 Catatan Ringkasan Pembayaran POS</h3>
                        <p class="text-xs text-stone-500">Pemisahan arus kas riil antara tunai fisik dan non-tunai QRIS</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {{-- CATATAN 1: CASH --}}
                    <div class="bg-white border-2 border-emerald-500/40 rounded-2xl p-5 shadow-sm relative overflow-hidden">
                        <div class="flex items-center justify-between mb-2">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-black uppercase bg-emerald-100 text-emerald-800 tracking-wider">
                                <span>💵</span> Catatan 1: Cash (Tunai)
                            </span>
                            <span class="text-xs font-black text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200">
                                {{ $paySummary['cash_percent'] }}%
                            </span>
                        </div>
                        <div class="text-2xl font-black text-stone-900 mt-2">
                            Rp {{ number_format($paySummary['cash_total'], 0, ',', '.') }}
                        </div>
                        <div class="flex items-center justify-between mt-3 pt-3 border-t border-stone-100 text-xs text-stone-500">
                            <span>Jumlah Transaksi</span>
                            <span class="font-black text-stone-800">{{ number_format($paySummary['cash_count']) }} struk</span>
                        </div>
                    </div>

                    {{-- CATATAN 2: QRIS --}}
                    <div class="bg-white border-2 border-purple-500/40 rounded-2xl p-5 shadow-sm relative overflow-hidden">
                        <div class="flex items-center justify-between mb-2">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-black uppercase bg-purple-100 text-purple-800 tracking-wider">
                                <span>📱</span> Catatan 2: QRIS
                            </span>
                            <span class="text-xs font-black text-purple-600 bg-purple-50 px-2 py-0.5 rounded-md border border-purple-200">
                                {{ $paySummary['qris_percent'] }}%
                            </span>
                        </div>
                        <div class="text-2xl font-black text-stone-900 mt-2">
                            Rp {{ number_format($paySummary['qris_total'], 0, ',', '.') }}
                        </div>
                        <div class="flex items-center justify-between mt-3 pt-3 border-t border-stone-100 text-xs text-stone-500">
                            <span>Jumlah Transaksi</span>
                            <span class="font-black text-stone-800">{{ number_format($paySummary['qris_count']) }} struk</span>
                        </div>
                    </div>

                    {{-- CATATAN 3: TOTAL GABUNGAN --}}
                    <div class="bg-gradient-to-br from-stone-900 to-stone-800 text-white rounded-2xl p-5 shadow-sm relative overflow-hidden">
                        <div class="flex items-center justify-between mb-2">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-black uppercase bg-white/10 text-white tracking-wider border border-white/20">
                                <span>∑</span> Catatan 3: Total Gabungan
                            </span>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-amber-300">
                                Basis Laba Bersih
                            </span>
                        </div>
                        <div class="text-2xl font-black text-amber-400 mt-2">
                            Rp {{ number_format($paySummary['combined_total'], 0, ',', '.') }}
                        </div>
                        <div class="flex items-center justify-between mt-3 pt-3 border-t border-white/10 text-xs text-stone-300">
                            <span>Total Seluruh Transaksi</span>
                            <span class="font-black text-white">{{ number_format($paySummary['combined_count']) }} struk</span>
                        </div>
                    </div>
                </div>

                {{-- TWO-SEGMENT PROPORTION BAR --}}
                <div class="mt-4 bg-white p-4 rounded-2xl border border-stone-200 shadow-sm space-y-2">
                    <div class="flex items-center justify-between text-xs font-bold text-stone-600">
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded-full bg-emerald-500 inline-block"></span>
                            Cash: Rp {{ number_format($paySummary['cash_total'], 0, ',', '.') }} ({{ $paySummary['cash_percent'] }}%)
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded-full bg-purple-600 inline-block"></span>
                            QRIS: Rp {{ number_format($paySummary['qris_total'], 0, ',', '.') }} ({{ $paySummary['qris_percent'] }}%)
                        </span>
                    </div>
                    <div class="w-full h-3.5 bg-stone-100 rounded-full overflow-hidden flex shadow-inner">
                        <div 
                            class="bg-emerald-500 h-full transition-all duration-500" 
                            style="width: {{ $paySummary['combined_total'] > 0 ? $paySummary['cash_percent'] : 50 }}%"
                            title="Cash {{ $paySummary['cash_percent'] }}%"
                        ></div>
                        <div 
                            class="bg-purple-600 h-full transition-all duration-500" 
                            style="width: {{ $paySummary['combined_total'] > 0 ? $paySummary['qris_percent'] : 50 }}%"
                            title="QRIS {{ $paySummary['qris_percent'] }}%"
                        ></div>
                    </div>
                </div>
            </div>

            {{-- 4 FINANCIAL METRIC CARDS --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- TOTAL PENDAPATAN KOTOR --}}
                <div class="bg-gradient-to-br from-[#C1440E] to-amber-600 text-white p-5 rounded-2xl shadow-sm">
                    <span class="text-[11px] uppercase tracking-wider font-bold opacity-80">Total Kas Masuk (Gross)</span>
                    <h3 class="text-2xl font-black mt-1">Rp {{ number_format($financialData['total_gross_income'], 0, ',', '.') }}</h3>
                    <p class="text-[11px] opacity-80 mt-2 font-medium">Omset Penjualan POS (Cash + QRIS)</p>
                </div>

                {{-- TOTAL BIAYA DAPUR --}}
                <div class="bg-gradient-to-br from-rose-600 to-red-700 text-white p-5 rounded-2xl shadow-sm">
                    <span class="text-[11px] uppercase tracking-wider font-bold opacity-80">Total Biaya &amp; Pengeluaran</span>
                    <h3 class="text-2xl font-black mt-1">Rp {{ number_format($financialData['total_expenses'], 0, ',', '.') }}</h3>
                    <p class="text-[11px] opacity-80 mt-2 font-medium">Bahan baku, operasional, &amp; gas (Disetujui)</p>
                </div>

                {{-- LABA BERSIH OPERASIONAL --}}
                <div class="p-5 rounded-2xl shadow-sm text-white {{ $financialData['net_profit'] >= 0 ? 'bg-gradient-to-br from-emerald-600 to-teal-700' : 'bg-gradient-to-br from-red-600 to-rose-700' }}">
                    <span class="text-[11px] uppercase tracking-wider font-bold opacity-80">Laba Bersih Operasional</span>
                    <h3 class="text-2xl font-black mt-1">Rp {{ number_format($financialData['net_profit'], 0, ',', '.') }}</h3>
                    <p class="text-[11px] opacity-80 mt-2 font-medium">Pendapatan POS dikurangi Biaya Dapur</p>
                </div>

                {{-- MARGIN KEUNTUNGAN --}}
                <div class="bg-white border border-stone-200 p-5 rounded-2xl shadow-sm flex flex-col justify-between">
                    <div>
                        <span class="text-[11px] uppercase tracking-wider font-bold text-stone-500">Margin Profit Bersih</span>
                        <h3 class="text-2xl font-black text-stone-900 mt-1">{{ $financialData['profit_margin'] }}%</h3>
                    </div>
                    <div class="w-full bg-stone-100 h-2 rounded-full overflow-hidden mt-3">
                        <div class="bg-emerald-500 h-full rounded-full" style="width: {{ min(100, max(0, $financialData['profit_margin'])) }}%"></div>
                    </div>
                </div>
            </div>

            {{-- EXPLICIT NET PROFIT FORMULA BOX (§12.2) --}}
            <div class="bg-gradient-to-r from-stone-900 via-stone-800 to-stone-900 text-white p-5 rounded-2xl border border-stone-700 shadow-md">
                <div class="text-[11px] font-bold text-amber-400 uppercase tracking-widest mb-2">
                    Rumus Perhitungan Laba Bersih Transparan
                </div>
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 text-xs">
                    <div class="flex flex-wrap items-center gap-2 font-mono">
                        <div class="bg-white/10 px-3 py-2 rounded-xl border border-white/15">
                            <span class="text-stone-400 block text-[10px] uppercase">Pendapatan POS (Cash + QRIS)</span>
                            <span class="font-bold text-emerald-400 text-sm">Rp {{ number_format($financialData['total_gross_income'], 0, ',', '.') }}</span>
                        </div>
                        <span class="text-xl font-black text-rose-400">−</span>
                        <div class="bg-white/10 px-3 py-2 rounded-xl border border-white/15">
                            <span class="text-stone-400 block text-[10px] uppercase">Pengeluaran Dapur (Approved)</span>
                            <span class="font-bold text-rose-400 text-sm">Rp {{ number_format($financialData['total_expenses'], 0, ',', '.') }}</span>
                        </div>
                        <span class="text-xl font-black text-stone-400">=</span>
                        <div class="bg-white/15 px-3 py-2 rounded-xl border border-amber-400/50">
                            <span class="text-amber-300 block text-[10px] uppercase">Laba Bersih Riil</span>
                            <span class="font-black text-white text-sm">Rp {{ number_format($financialData['net_profit'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <div class="text-stone-300 text-xs max-w-sm">
                        Basis kas masuk murni berasal dari transaksi kasir POS (Cash dan QRIS). Tidak ada transaksi transfer maupun pos pendapatan fiktif lainnya.
                    </div>
                </div>
            </div>

            {{-- DAILY BREAKDOWN TABLE (§12.3) --}}
            <div class="bg-white rounded-2xl shadow-sm border border-stone-200 overflow-hidden">
                <div class="p-4 border-b border-stone-200 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <h4 class="font-bold text-stone-900 text-sm">Rincian Arus Kas Harian (Cash vs QRIS)</h4>
                        <p class="text-xs text-stone-500">Breakdown harian transaksi kasir POS berdasarkan metode pembayaran</p>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-1 bg-stone-100 text-stone-600 rounded-lg self-start sm:self-auto">
                        {{ count($financialData['daily_breakdown'] ?? []) }} Hari Tercatat
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-stone-50 text-stone-600 font-bold border-b border-stone-200 uppercase tracking-wider text-[10px]">
                            <tr>
                                <th class="py-3 px-4">Tanggal</th>
                                <th class="py-3 px-4 text-center">Trx Cash</th>
                                <th class="py-3 px-4 text-right">Total Cash</th>
                                <th class="py-3 px-4 text-center">Trx QRIS</th>
                                <th class="py-3 px-4 text-right">Total QRIS</th>
                                <th class="py-3 px-4 text-right">Total Gabungan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100 font-mono">
                            @forelse($financialData['daily_breakdown'] as $day)
                                <tr class="hover:bg-stone-50">
                                    <td class="py-3 px-4 font-bold text-stone-800 font-sans">
                                        {{ \Carbon\Carbon::parse($day->date)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="py-3 px-4 text-center font-bold text-emerald-700">
                                        {{ number_format($day->cash_count) }}
                                    </td>
                                    <td class="py-3 px-4 text-right font-bold text-emerald-700">
                                        Rp {{ number_format($day->cash_total, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4 text-center font-bold text-purple-700">
                                        {{ number_format($day->qris_count) }}
                                    </td>
                                    <td class="py-3 px-4 text-right font-bold text-purple-700">
                                        Rp {{ number_format($day->qris_total, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4 text-right font-black text-stone-900">
                                        Rp {{ number_format($day->combined_total, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-10 text-center text-stone-400 text-xs font-sans">
                                        Tidak ada catatan transaksi kasir pada rentang waktu ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if(count($financialData['daily_breakdown']) > 0)
                            <tfoot class="bg-stone-100 font-mono text-stone-900 font-black border-t-2 border-stone-300">
                                <tr>
                                    <td class="py-3 px-4 font-sans text-xs uppercase tracking-wider">TOTAL</td>
                                    <td class="py-3 px-4 text-center text-emerald-800">
                                        {{ number_format($paySummary['cash_count']) }}
                                    </td>
                                    <td class="py-3 px-4 text-right text-emerald-800">
                                        Rp {{ number_format($paySummary['cash_total'], 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4 text-center text-purple-800">
                                        {{ number_format($paySummary['qris_count']) }}
                                    </td>
                                    <td class="py-3 px-4 text-right text-purple-800">
                                        Rp {{ number_format($paySummary['qris_total'], 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4 text-right text-stone-900 font-extrabold text-sm">
                                        Rp {{ number_format($paySummary['combined_total'], 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>

            {{-- EXPENSES BY CATEGORY --}}
            <div class="bg-white rounded-2xl p-5 border border-stone-200 shadow-sm space-y-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h4 class="font-bold text-stone-900 text-sm">Rincian Pengeluaran Dapur per Kategori</h4>
                        <p class="text-xs text-stone-500">Biaya yang telah disetujui (Approved) dan memotong laba</p>
                    </div>
                    <span class="text-xs text-stone-500 font-medium">{{ $financialData['expense_count'] }} Catatan</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @forelse($financialData['expenses_by_category'] as $cat)
                        <div class="flex items-center justify-between p-3.5 rounded-xl bg-stone-50 border border-stone-200/60 text-xs">
                            <div class="font-semibold text-stone-800">
                                {{ $cat->category_name ?? $cat->category ?? 'Operasional' }} <span class="text-stone-400 font-normal">({{ $cat->count }}x)</span>
                            </div>
                            <span class="font-bold text-rose-600">
                                Rp {{ number_format($cat->total_amount, 0, ',', '.') }}
                            </span>
                        </div>
                    @empty
                        <div class="col-span-full py-6 text-center text-stone-400 text-xs">
                            Belum ada pengeluaran dapur yang disetujui pada periode ini.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    {{-- TAB 2: POS REPORT --}}
    @else
        <div class="space-y-6">
            {{-- POS SUMMARY CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gradient-to-br from-amber-500 to-[#C1440E] text-white p-5 rounded-2xl shadow-sm">
                    <span class="text-xs uppercase tracking-wider font-bold opacity-80">Total Pendapatan Kasir</span>
                    <h3 class="text-2xl font-black mt-1">Rp {{ number_format($salesData['summary']['total_revenue'] ?? 0, 0, ',', '.') }}</h3>
                    <p class="text-[11px] opacity-80 mt-1 font-medium">Omset penjualan POS reguler</p>
                </div>

                <div class="bg-white border border-stone-200 p-5 rounded-2xl shadow-sm">
                    <span class="text-xs uppercase tracking-wider font-bold text-stone-500">Jumlah Transaksi</span>
                    <h3 class="text-2xl font-black text-stone-900 mt-1">{{ number_format($salesData['summary']['transaction_count'] ?? 0) }} struk</h3>
                    <p class="text-[11px] text-stone-400 mt-1 font-medium">Transaksi terselesaikan dengan sukses</p>
                </div>

                <div class="bg-white border border-stone-200 p-5 rounded-2xl shadow-sm">
                    <span class="text-xs uppercase tracking-wider font-bold text-stone-500">Rata-Rata per Transaksi</span>
                    <h3 class="text-2xl font-black text-stone-900 mt-1">Rp {{ number_format($salesData['summary']['average_transaction'] ?? 0, 0, ',', '.') }}</h3>
                    <p class="text-[11px] text-stone-400 mt-1 font-medium">Average Order Value (AOV)</p>
                </div>
            </div>

            {{-- TOP SELLING PRODUCTS TABLE --}}
            @if(empty($productId) && count($salesData['product_sales'] ?? []) > 0)
                <div class="bg-white rounded-2xl shadow-sm border border-stone-200 p-5 space-y-3">
                    <h4 class="font-bold text-stone-900 text-sm">🏆 Menu Paling Laris &amp; Terpopuler</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-stone-50 text-stone-600 font-bold border-b border-stone-200 uppercase tracking-wider text-[10px]">
                                <tr>
                                    <th class="py-2.5 px-4">Nama Menu</th>
                                    <th class="py-2.5 px-4 text-center">Porsi Terjual</th>
                                    <th class="py-2.5 px-4 text-center">Frekuensi Pesanan</th>
                                    <th class="py-2.5 px-4 text-right">Total Penjualan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-stone-100">
                                @foreach($salesData['product_sales'] as $item)
                                    <tr class="hover:bg-stone-50">
                                        <td class="py-2.5 px-4 font-bold text-stone-800">{{ $item->product_name }}</td>
                                        <td class="py-2.5 px-4 text-center font-black text-stone-900">{{ $item->total_quantity }}</td>
                                        <td class="py-2.5 px-4 text-center text-stone-500">{{ $item->transaction_count }} kali</td>
                                        <td class="py-2.5 px-4 text-right font-black text-[#C1440E]">Rp {{ number_format($item->total_sales, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- TRANSACTION HISTORY TABLE --}}
            <div class="bg-white rounded-2xl shadow-sm border border-stone-200 overflow-hidden">
                <div class="p-4 border-b border-stone-200">
                    <h4 class="font-bold text-stone-900 text-sm">Daftar Transaksi Kasir POS</h4>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-stone-50 text-stone-600 font-bold border-b border-stone-200 uppercase tracking-wider text-[10px]">
                            <tr>
                                <th class="py-3 px-4">No. Transaksi</th>
                                <th class="py-3 px-4">Tanggal &amp; Jam</th>
                                <th class="py-3 px-4">Kasir</th>
                                <th class="py-3 px-4 text-center">Metode</th>
                                <th class="py-3 px-4 text-right">Total</th>
                                <th class="py-3 px-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @forelse($salesData['transactions'] as $tx)
                                <tr class="hover:bg-stone-50">
                                    <td class="py-3 px-4 font-mono font-bold text-stone-800">{{ $tx->transaction_number }}</td>
                                    <td class="py-3 px-4 font-mono text-stone-500">{{ \Carbon\Carbon::parse($tx->transaction_date)->format('d M Y') }} {{ $tx->transaction_time }}</td>
                                    <td class="py-3 px-4 font-medium">{{ $tx->cashier?->name ?? 'Kasir' }}</td>
                                    <td class="py-3 px-4 text-center">
                                        @php
                                            $method = $tx->payment_method instanceof \App\Enums\PaymentMethod 
                                                ? $tx->payment_method 
                                                : \App\Enums\PaymentMethod::tryFrom((string)$tx->payment_method);
                                        @endphp
                                        @if($method)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-black {{ $method->badgeClass() }}">
                                                <span>{{ $method->icon() }}</span>
                                                <span>{{ $method->label() }}</span>
                                            </span>
                                        @else
                                            <span class="text-stone-500 font-semibold">{{ $tx->payment_method }}</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-right font-black text-stone-900">Rp {{ number_format($tx->total, 0, ',', '.') }}</td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase {{ $tx->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                            {{ $tx->status === 'completed' ? 'Selesai' : 'Batal' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-10 text-center text-stone-400 text-xs">
                                        Tidak ada transaksi kasir tercatat pada periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
