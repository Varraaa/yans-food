@extends('layouts.admin')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
    {{-- TOP BAR: HEADER WITH LOGO, TABS & EXPORT --}}
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-200/80 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div class="flex items-center gap-3.5">
            {{-- BRAND LOGO BADGE --}}
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#D6A253] via-[#C1440E] to-[#8F3209] p-[2px] shadow-sm shrink-0">
                <div class="w-full h-full rounded-[14px] bg-[#FBF6EE] flex items-center justify-center relative overflow-hidden">
                    <svg class="w-7 h-7 text-[#C1440E]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C11.5 3 13 4 12 5" stroke="#D6A253" stroke-width="2" stroke-linecap="round"/>
                        <path d="M8 3.5C7.5 4.5 9 5.5 8 6.5" stroke="#C1440E" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M16 3.5C15.5 4.5 17 5.5 16 6.5" stroke="#C1440E" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M4 11C4 16 7.5 18 12 18C16.5 18 20 16 20 11H4Z" fill="#C1440E"/>
                        <line x1="2.5" y1="11" x2="21.5" y2="11" stroke="#26201B" stroke-width="2" stroke-linecap="round"/>
                        <circle cx="12" cy="19.5" r="1.5" fill="#D6A253"/>
                    </svg>
                </div>
            </div>
            <div>
                <h1 class="text-xl font-black text-stone-900 tracking-tight font-serif">Laporan &amp; Keuangan</h1>
                <p class="text-xs text-stone-500 mt-0.5">Analisis arus kas kasir POS, performa menu, dan laba rugi operasional</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2.5 sm:gap-3 w-full lg:w-auto">
            {{-- TABS --}}
            <div class="bg-stone-100 p-1 rounded-xl flex items-center gap-1 border border-stone-200 w-full sm:w-auto overflow-x-auto">
                <a 
                    href="{{ route('admin.reports.index', array_merge(request()->query(), ['tab' => 'financial'])) }}"
                    class="flex-1 sm:flex-initial px-3 sm:px-4 py-2 rounded-lg font-bold text-xs transition flex items-center justify-center gap-1.5 sm:gap-2 {{ $activeTab === 'financial' ? 'bg-white text-stone-900 shadow-sm' : 'text-stone-600 hover:text-stone-900' }}"
                >
                    <span class="material-symbols-outlined text-[16px] text-amber-600">balance</span>
                    <span class="whitespace-nowrap">Laba Rugi &amp; Arus Kas</span>
                </a>
                <a 
                    href="{{ route('admin.reports.index', array_merge(request()->query(), ['tab' => 'pos'])) }}"
                    class="flex-1 sm:flex-initial px-3 sm:px-4 py-2 rounded-lg font-bold text-xs transition flex items-center justify-center gap-1.5 sm:gap-2 {{ $activeTab === 'pos' ? 'bg-white text-stone-900 shadow-sm' : 'text-stone-600 hover:text-stone-900' }}"
                >
                    <span class="material-symbols-outlined text-[16px] text-emerald-600">point_of_sale</span>
                    <span class="whitespace-nowrap">Penjualan Kasir</span>
                </a>
            </div>

            {{-- EXPORT BUTTON --}}
            <a 
                href="{{ route('admin.reports.export', request()->query()) }}"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs shadow-sm transition active:scale-[0.98]"
            >
                <span class="material-symbols-outlined text-[16px]">download</span>
                <span>Export CSV</span>
            </a>
        </div>
    </div>

    {{-- FILTER BAR: PERIOD SHORTCUTS & CUSTOM DATES --}}
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-stone-200/80 flex flex-col md:flex-row md:items-center justify-between gap-3 sm:gap-4">
        <div class="flex items-center gap-1.5 overflow-x-auto text-xs pb-1 sm:pb-0 no-scrollbar w-full md:w-auto">
            @foreach([
                'today' => 'Hari Ini',
                'this_week' => 'Minggu Ini',
                'this_month' => 'Bulan Ini',
                'this_year' => 'Tahun Ini',
                'all' => 'Semua Waktu',
                'custom' => 'Custom'
            ] as $key => $label)
                <a 
                    href="{{ route('admin.reports.index', array_merge(request()->query(), ['period' => $key])) }}"
                    class="px-3.5 py-1.5 rounded-lg font-bold text-xs transition shrink-0 {{ $period === $key ? 'bg-stone-900 text-white shadow-sm' : 'bg-stone-100 text-stone-600 hover:bg-stone-200 hover:text-stone-900' }}"
                >
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <form action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-wrap items-center gap-2 text-xs w-full md:w-auto">
            <input type="hidden" name="tab" value="{{ $activeTab }}">
            <input type="hidden" name="period" value="{{ $period }}">

            @if($activeTab === 'pos')
                <div class="flex items-center gap-1.5 w-full sm:w-auto">
                    <span class="text-stone-500 font-medium shrink-0">Filter Menu:</span>
                    <select name="product_id" onchange="this.form.submit()" class="py-1.5 px-3 rounded-lg border border-stone-300 bg-stone-50 text-xs text-stone-800 focus:ring-1 focus:ring-stone-400 w-full sm:w-auto">
                        <option value="">Semua Menu</option>
                        @foreach($products as $prod)
                            <option value="{{ $prod->id }}" {{ $productId == $prod->id ? 'selected' : '' }}>{{ $prod->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if($period === 'custom')
                <div class="flex flex-wrap sm:flex-nowrap items-center gap-2 w-full sm:w-auto">
                    <input type="date" name="start_date" value="{{ $startDate }}" class="py-1.5 px-3 rounded-lg border border-stone-300 bg-white text-xs text-stone-800 w-full sm:w-auto">
                    <span class="text-stone-400 font-bold hidden sm:inline">-</span>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="py-1.5 px-3 rounded-lg border border-stone-300 bg-white text-xs text-stone-800 w-full sm:w-auto">
                    <button type="submit" class="px-3.5 py-1.5 bg-stone-900 hover:bg-stone-800 text-white font-bold rounded-lg text-xs transition w-full sm:w-auto">Terapkan</button>
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
            {{-- 4 MAIN KPI CARDS --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- KAS MASUK (GROSS) --}}
                <div class="bg-white p-5 rounded-2xl border border-stone-200/90 shadow-sm relative overflow-hidden">
                    <div class="flex items-center justify-between text-stone-500 mb-2">
                        <span class="text-xs font-semibold uppercase tracking-wider">Total Kas Masuk</span>
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm">
                            <span class="material-symbols-outlined text-[20px]">payments</span>
                        </div>
                    </div>
                    <div class="text-2xl font-extrabold text-stone-900">
                        Rp {{ number_format($financialData['total_gross_income'], 0, ',', '.') }}
                    </div>
                    <p class="text-[11px] text-stone-400 mt-1">Omset POS riil (Cash + QRIS)</p>
                </div>

                {{-- BIAYA & PENGELUARAN --}}
                <div class="bg-white p-5 rounded-2xl border border-stone-200/90 shadow-sm relative overflow-hidden">
                    <div class="flex items-center justify-between text-stone-500 mb-2">
                        <span class="text-xs font-semibold uppercase tracking-wider">Biaya &amp; Pengeluaran</span>
                        <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center text-sm">
                            <span class="material-symbols-outlined text-[20px]">trending_down</span>
                        </div>
                    </div>
                    <div class="text-2xl font-extrabold text-stone-900">
                        Rp {{ number_format($financialData['total_expenses'], 0, ',', '.') }}
                    </div>
                    <p class="text-[11px] text-stone-400 mt-1">Biaya dapur &amp; operasional disetujui</p>
                </div>

                {{-- LABA BERSIH OPERASIONAL --}}
                <div class="p-5 rounded-2xl border shadow-sm relative overflow-hidden {{ $financialData['net_profit'] >= 0 ? 'bg-emerald-50/70 border-emerald-200' : 'bg-rose-50/70 border-rose-200' }}">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold uppercase tracking-wider {{ $financialData['net_profit'] >= 0 ? 'text-emerald-700' : 'text-rose-700' }}">Laba Bersih Riil</span>
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm {{ $financialData['net_profit'] >= 0 ? 'bg-emerald-600 text-white' : 'bg-rose-600 text-white' }}">
                            <span class="material-symbols-outlined text-[20px]">account_balance_wallet</span>
                        </div>
                    </div>
                    <div class="text-2xl font-black {{ $financialData['net_profit'] >= 0 ? 'text-emerald-800' : 'text-rose-800' }}">
                        Rp {{ number_format($financialData['net_profit'], 0, ',', '.') }}
                    </div>
                    <p class="text-[11px] mt-1 font-medium {{ $financialData['net_profit'] >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                        Kas Masuk dikurangi Pengeluaran
                    </p>
                </div>

                {{-- MARGIN PROFIT --}}
                <div class="bg-white p-5 rounded-2xl border border-stone-200/90 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between text-stone-500 mb-2">
                            <span class="text-xs font-semibold uppercase tracking-wider">Margin Profit</span>
                            <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-sm">
                                <span class="material-symbols-outlined text-[20px]">percent</span>
                            </div>
                        </div>
                        <div class="text-2xl font-extrabold text-stone-900">
                            {{ $financialData['profit_margin'] }}%
                        </div>
                    </div>
                    <div class="w-full bg-stone-100 h-2 rounded-full overflow-hidden mt-3">
                        <div class="bg-emerald-500 h-full rounded-full transition-all duration-500" style="width: {{ min(100, max(0, $financialData['profit_margin'])) }}%"></div>
                    </div>
                </div>
            </div>

            {{-- ARUS KAS PEMBAYARAN: CASH VS QRIS --}}
            <div class="bg-white p-6 rounded-2xl border border-stone-200/90 shadow-sm space-y-5">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-stone-100 pb-4">
                    <div>
                        <h2 class="text-sm font-bold text-stone-900 uppercase tracking-wider flex items-center gap-2">
                            <span class="material-symbols-outlined text-stone-500 text-[18px]">sync_alt</span>
                            <span>Ringkasan Arus Kas Masuk (Tunai vs QRIS)</span>
                        </h2>
                        <p class="text-xs text-stone-500 mt-0.5">Pemisahan fisik kas tunai di laci dan saldo digital QRIS</p>
                    </div>
                    <span class="text-xs font-semibold px-3 py-1 bg-stone-100 text-stone-700 rounded-full self-start sm:self-auto">
                        Total: {{ number_format($paySummary['combined_count']) }} Struk
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {{-- CARD 1: CASH --}}
                    <div class="p-4 rounded-xl bg-stone-50 border border-stone-200 hover:border-emerald-300 transition">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm">
                                    <span class="material-symbols-outlined text-[20px]">payments</span>
                                </div>
                                <div>
                                    <h3 class="text-xs font-bold text-stone-800">Cash (Tunai)</h3>
                                    <p class="text-[10px] text-stone-400">Fisik di kasir</p>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 rounded-md text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                {{ $paySummary['cash_percent'] }}%
                            </span>
                        </div>
                        <div class="text-xl font-extrabold text-stone-900 mt-3 font-mono">
                            Rp {{ number_format($paySummary['cash_total'], 0, ',', '.') }}
                        </div>
                        <div class="text-[11px] text-stone-500 mt-1">
                            {{ number_format($paySummary['cash_count']) }} transaksi
                        </div>
                    </div>

                    {{-- CARD 2: QRIS --}}
                    <div class="p-4 rounded-xl bg-stone-50 border border-stone-200 hover:border-sky-300 transition">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-sky-100 text-sky-700 flex items-center justify-center text-sm">
                                    <span class="material-symbols-outlined text-[20px]">qr_code_2</span>
                                </div>
                                <div>
                                    <h3 class="text-xs font-bold text-stone-800">QRIS (Non-Tunai)</h3>
                                    <p class="text-[10px] text-stone-400">Rekening digital</p>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 rounded-md text-[11px] font-bold bg-sky-100 text-sky-800">
                                {{ $paySummary['qris_percent'] }}%
                            </span>
                        </div>
                        <div class="text-xl font-extrabold text-stone-900 mt-3 font-mono">
                            Rp {{ number_format($paySummary['qris_total'], 0, ',', '.') }}
                        </div>
                        <div class="text-[11px] text-stone-500 mt-1">
                            {{ number_format($paySummary['qris_count']) }} transaksi
                        </div>
                    </div>

                    {{-- CARD 3: TOTAL GABUNGAN --}}
                    <div class="p-4 rounded-xl bg-stone-900 text-white border border-stone-800">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-white/10 text-amber-400 flex items-center justify-center text-sm">
                                    <span class="material-symbols-outlined text-[20px]">calculate</span>
                                </div>
                                <div>
                                    <h3 class="text-xs font-bold text-stone-100">Total Kas Masuk</h3>
                                    <p class="text-[10px] text-stone-400">Cash + QRIS</p>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-amber-300">
                                Basis Omset
                            </span>
                        </div>
                        <div class="text-xl font-extrabold text-amber-400 mt-3 font-mono">
                            Rp {{ number_format($paySummary['combined_total'], 0, ',', '.') }}
                        </div>
                        <div class="text-[11px] text-stone-300 mt-1">
                            {{ number_format($paySummary['combined_count']) }} transaksi total
                        </div>
                    </div>
                </div>

                {{-- VISUAL PROPORTION BAR --}}
                <div class="pt-2 space-y-2">
                    <div class="flex items-center justify-between text-xs font-medium text-stone-600">
                        <span class="inline-flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block"></span>
                            Cash: Rp {{ number_format($paySummary['cash_total'], 0, ',', '.') }} ({{ $paySummary['cash_percent'] }}%)
                        </span>
                        <span class="inline-flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-sky-500 inline-block"></span>
                            QRIS: Rp {{ number_format($paySummary['qris_total'], 0, ',', '.') }} ({{ $paySummary['qris_percent'] }}%)
                        </span>
                    </div>
                    <div class="w-full h-3 bg-stone-100 rounded-full overflow-hidden flex">
                        <div 
                            class="bg-emerald-500 h-full transition-all duration-500" 
                            style="width: {{ $paySummary['combined_total'] > 0 ? $paySummary['cash_percent'] : 50 }}%"
                        ></div>
                        <div 
                            class="bg-sky-500 h-full transition-all duration-500" 
                            style="width: {{ $paySummary['combined_total'] > 0 ? $paySummary['qris_percent'] : 50 }}%"
                        ></div>
                    </div>
                </div>
            </div>

            {{-- DAILY BREAKDOWN TABLE --}}
            <div class="bg-white rounded-2xl shadow-sm border border-stone-200/90 overflow-hidden">
                <div class="p-4 border-b border-stone-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <h2 class="font-bold text-stone-900 text-sm">Rincian Arus Kas Harian</h2>
                        <p class="text-xs text-stone-500">Histori harian omset kasir dipisahkan berdasarkan metode pembayaran</p>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-1 bg-stone-100 text-stone-600 rounded-lg self-start sm:self-auto">
                        {{ count($financialData['daily_breakdown'] ?? []) }} Hari
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs whitespace-nowrap min-w-[620px]">
                        <thead class="bg-stone-50 text-stone-600 font-bold border-b border-stone-200 uppercase tracking-wider text-[11px]">
                            <tr>
                                <th class="py-3 px-4">Tanggal</th>
                                <th class="py-3 px-4 text-center">Trx Cash</th>
                                <th class="py-3 px-4 text-right">Total Cash</th>
                                <th class="py-3 px-4 text-center">Trx QRIS</th>
                                <th class="py-3 px-4 text-right">Total QRIS</th>
                                <th class="py-3 px-4 text-right">Total Harian</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100 font-mono">
                            @forelse($financialData['daily_breakdown'] as $day)
                                <tr class="hover:bg-stone-50/80 transition-colors">
                                    <td class="py-3 px-4 font-semibold text-stone-800 font-sans">
                                        {{ \Carbon\Carbon::parse($day->date ?? $day->transaction_date)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="py-3 px-4 text-center text-stone-700">
                                        {{ number_format($day->cash_count) }}
                                    </td>
                                    <td class="py-3 px-4 text-right font-medium text-emerald-700">
                                        Rp {{ number_format($day->cash_total, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4 text-center text-stone-700">
                                        {{ number_format($day->qris_count) }}
                                    </td>
                                    <td class="py-3 px-4 text-right font-medium text-sky-700">
                                        Rp {{ number_format($day->qris_total, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4 text-right font-bold text-stone-900">
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
                            <tfoot class="bg-stone-50 font-mono text-stone-900 font-bold border-t-2 border-stone-200">
                                <tr>
                                    <td class="py-3 px-4 font-sans text-xs uppercase tracking-wider">TOTAL</td>
                                    <td class="py-3 px-4 text-center">
                                        {{ number_format($paySummary['cash_count']) }}
                                    </td>
                                    <td class="py-3 px-4 text-right text-emerald-700">
                                        Rp {{ number_format($paySummary['cash_total'], 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        {{ number_format($paySummary['qris_count']) }}
                                    </td>
                                    <td class="py-3 px-4 text-right text-sky-700">
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

            @php
                $periodBadgeLabels = [
                    'today' => 'Hari Ini',
                    'this_week' => 'Minggu Ini',
                    'this_month' => 'Bulan Ini (' . now()->translatedFormat('F Y') . ')',
                    'this_year' => 'Tahun Ini (' . now()->format('Y') . ')',
                    'all' => 'Semua Waktu',
                    'custom' => 'Rentang Kustom',
                ];
                $activePeriodText = $periodBadgeLabels[$period] ?? 'Periode Ini';
            @endphp

            {{-- EXPENSES BY CATEGORY (MENYESUAIKAN FILTER BULAN INI / TAHUN INI / SEMUA WAKTU) --}}
            <div class="bg-white rounded-2xl p-5 border border-stone-200/90 shadow-sm space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-stone-100 pb-3">
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="font-bold text-stone-900 text-sm">Pengeluaran Dapur per Kategori</h2>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-stone-100 text-stone-700 border border-stone-200">
                                {{ $activePeriodText }}
                            </span>
                        </div>
                        <p class="text-xs text-stone-500 mt-0.5">Rincian alokasi biaya belanja &amp; operasional dapur yang telah disetujui pada periode ini.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-stone-500 font-semibold px-2.5 py-1 bg-stone-100 rounded-lg">
                            {{ $financialData['expense_count'] }} Catatan
                        </span>
                        <span class="text-xs text-rose-700 font-black px-2.5 py-1 bg-rose-50 border border-rose-200 rounded-lg font-mono">
                            Total: Rp {{ number_format($financialData['total_expenses'], 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @forelse($financialData['expenses_by_category'] as $cat)
                        <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200/70 text-xs space-y-2">
                            <div class="flex items-center justify-between">
                                <div class="font-bold text-stone-800">
                                    {{ $cat->category_name ?? $cat->category ?? 'Operasional' }} 
                                    <span class="text-stone-400 font-normal">({{ $cat->count }}x)</span>
                                </div>
                                <span class="font-black text-rose-600 font-mono text-sm">
                                    Rp {{ number_format($cat->total_amount, 0, ',', '.') }}
                                </span>
                            </div>
                            <div>
                                <div class="flex items-center justify-between text-[11px] text-stone-500 mb-1">
                                    <span>Porsi Biaya:</span>
                                    <span class="font-bold text-stone-700">{{ $cat->percent ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-stone-200 h-1.5 rounded-full overflow-hidden">
                                    <div class="bg-rose-500 h-full rounded-full transition-all" style="width: {{ min(100, $cat->percent ?? 0) }}%"></div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-6 text-center text-stone-400 text-xs">
                            Belum ada pengeluaran dapur yang disetujui pada periode {{ $activePeriodText }}.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- SECTION HASIL UANG BERSIH PER BULAN DAN PER TAHUN --}}
            <div class="bg-white rounded-2xl p-5 border border-stone-200/90 shadow-sm space-y-5">
                {{-- HEADER SECTION --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-stone-100 pb-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="font-black text-stone-900 text-base font-serif flex items-center gap-2">
                                <span>💰</span>
                                <span>Hasil Uang Bersih (Laba Bersih Operasional)</span>
                            </h2>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold {{ $financialData['net_profit'] >= 0 ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-rose-100 text-rose-800 border border-rose-200' }}">
                                {{ $financialData['net_profit'] >= 0 ? 'Surplus Laba' : 'Defisit' }}
                            </span>
                        </div>
                        <p class="text-xs text-stone-500 mt-0.5">Hasil bersih dari Total Omset Kasir dikurangi Seluruh Beban Pengeluaran Dapur, disajikan dinamis per bulan dan per tahun.</p>
                    </div>

                    {{-- CURRENT FILTER HIGHLIGHT CARD --}}
                    <div class="p-3 bg-gradient-to-r {{ $financialData['net_profit'] >= 0 ? 'from-emerald-50 to-emerald-100/50 border-emerald-200 text-emerald-900' : 'from-rose-50 to-rose-100/50 border-rose-200 text-rose-900' }} border rounded-xl text-right">
                        <span class="text-[10px] font-bold uppercase tracking-wider block opacity-75">Uang Bersih ({{ $activePeriodText }})</span>
                        <div class="text-xl font-black font-mono">
                            Rp {{ number_format($financialData['net_profit'], 0, ',', '.') }}
                        </div>
                        <span class="text-[10px] font-semibold opacity-80 block">Margin: {{ $financialData['profit_margin'] }}%</span>
                    </div>
                </div>

                {{-- SUBSECTION 1: RINCIAN UANG BERSIH PER BULAN --}}
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xs font-bold text-stone-900 uppercase tracking-wider flex items-center gap-1.5">
                            <span>📅</span>
                            <span>Rincian Hasil Uang Bersih per Bulan</span>
                        </h3>
                        <span class="text-[11px] text-stone-500 font-medium">
                            {{ count($financialData['monthly_breakdown'] ?? []) }} Periode Bulan Tercatat
                        </span>
                    </div>

                    <div class="overflow-x-auto rounded-xl border border-stone-200">
                        <table class="w-full text-left text-xs whitespace-nowrap min-w-[680px]">
                            <thead class="bg-stone-50 text-stone-600 font-bold border-b border-stone-200 uppercase tracking-wider text-[10px]">
                                <tr>
                                    <th class="py-3 px-4">Bulan &amp; Tahun</th>
                                    <th class="py-3 px-4 text-center">Transaksi</th>
                                    <th class="py-3 px-4 text-right">Pendapatan Kasir</th>
                                    <th class="py-3 px-4 text-right">Pengeluaran Dapur</th>
                                    <th class="py-3 px-4 text-right">Hasil Uang Bersih</th>
                                    <th class="py-3 px-4 text-center">Margin</th>
                                    <th class="py-3 px-4 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-stone-100 font-mono">
                                @forelse($financialData['monthly_breakdown'] ?? [] as $m)
                                    <tr class="hover:bg-stone-50/80 transition-colors {{ $m->month_key === now()->format('Y-m') ? 'bg-amber-50/20' : '' }}">
                                        <td class="py-3 px-4 font-sans font-bold text-stone-900">
                                            {{ $m->month_label }}
                                            @if($m->month_key === now()->format('Y-m'))
                                                <span class="ml-1.5 px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-emerald-100 text-emerald-800">
                                                    Bulan Ini
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-center font-sans text-stone-600">
                                            {{ $m->tx_count }}x
                                        </td>
                                        <td class="py-3 px-4 text-right text-stone-900 font-medium">
                                            Rp {{ number_format($m->revenue, 0, ',', '.') }}
                                        </td>
                                        <td class="py-3 px-4 text-right text-rose-600 font-medium">
                                            Rp {{ number_format($m->expenses, 0, ',', '.') }}
                                        </td>
                                        <td class="py-3 px-4 text-right font-black text-sm {{ $m->net_profit >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                            Rp {{ number_format($m->net_profit, 0, ',', '.') }}
                                        </td>
                                        <td class="py-3 px-4 text-center font-bold {{ $m->net_profit >= 0 ? 'text-emerald-700' : 'text-rose-700' }}">
                                            {{ $m->profit_margin }}%
                                        </td>
                                        <td class="py-3 px-4 text-center font-sans">
                                            @if($m->is_surplus)
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                    <span>Untung</span>
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                                    <span>Defisit</span>
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-8 text-center text-stone-400 font-sans">
                                            Belum ada catatan keuangan bulanan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- SUBSECTION 2: RINCIAN UANG BERSIH PER TAHUN --}}
                <div class="space-y-3 pt-3 border-t border-stone-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xs font-bold text-stone-900 uppercase tracking-wider flex items-center gap-1.5">
                            <span>📈</span>
                            <span>Rincian Hasil Uang Bersih per Tahun</span>
                        </h3>
                        <span class="text-[11px] text-stone-500 font-medium">
                            Rekapitulasi Tahunan Historis
                        </span>
                    </div>

                    <div class="overflow-x-auto rounded-xl border border-stone-200">
                        <table class="w-full text-left text-xs whitespace-nowrap min-w-[600px]">
                            <thead class="bg-stone-50 text-stone-600 font-bold border-b border-stone-200 uppercase tracking-wider text-[10px]">
                                <tr>
                                    <th class="py-3 px-4">Tahun</th>
                                    <th class="py-3 px-4 text-center">Total Transaksi</th>
                                    <th class="py-3 px-4 text-right">Total Pendapatan Kasir</th>
                                    <th class="py-3 px-4 text-right">Total Beban Pengeluaran</th>
                                    <th class="py-3 px-4 text-right">Hasil Uang Bersih Tahunan</th>
                                    <th class="py-3 px-4 text-center">Margin Laba</th>
                                    <th class="py-3 px-4 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-stone-100 font-mono">
                                @forelse($financialData['yearly_breakdown'] ?? [] as $y)
                                    <tr class="hover:bg-stone-50/80 transition-colors {{ $y->year === now()->format('Y') ? 'bg-amber-50/20' : '' }}">
                                        <td class="py-3 px-4 font-sans font-black text-stone-900 text-sm">
                                            Tahun {{ $y->year }}
                                            @if($y->year === now()->format('Y'))
                                                <span class="ml-1.5 px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-emerald-100 text-emerald-800">
                                                    Tahun Ini
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-center font-sans text-stone-600">
                                            {{ $y->tx_count }} Transaksi
                                        </td>
                                        <td class="py-3 px-4 text-right text-stone-900 font-semibold">
                                            Rp {{ number_format($y->revenue, 0, ',', '.') }}
                                        </td>
                                        <td class="py-3 px-4 text-right text-rose-600 font-semibold">
                                            Rp {{ number_format($y->expenses, 0, ',', '.') }}
                                        </td>
                                        <td class="py-3 px-4 text-right font-black text-base {{ $y->net_profit >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                            Rp {{ number_format($y->net_profit, 0, ',', '.') }}
                                        </td>
                                        <td class="py-3 px-4 text-center font-bold {{ $y->net_profit >= 0 ? 'text-emerald-700' : 'text-rose-700' }}">
                                            {{ $y->profit_margin }}%
                                        </td>
                                        <td class="py-3 px-4 text-center font-sans">
                                            @if($y->is_surplus)
                                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                    <span>Surplus Laba</span>
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                                    <span>Defisit</span>
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-8 text-center text-stone-400 font-sans">
                                            Belum ada catatan tahunan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    {{-- TAB 2: POS REPORT --}}
    @else
        <div class="space-y-6">
            {{-- POS SUMMARY CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white border border-stone-200/90 p-5 rounded-2xl shadow-sm">
                    <div class="flex items-center justify-between text-stone-500 mb-2">
                        <span class="text-xs uppercase tracking-wider font-semibold">Total Pendapatan Kasir</span>
                        <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-sm">
                            <span class="material-symbols-outlined text-[20px]">monetization_on</span>
                        </div>
                    </div>
                    <div class="text-2xl font-extrabold text-stone-900">
                        Rp {{ number_format($salesData['summary']['total_revenue'] ?? 0, 0, ',', '.') }}
                    </div>
                    <p class="text-[11px] text-stone-400 mt-1">Omset penjualan POS</p>
                </div>

                <div class="bg-white border border-stone-200/90 p-5 rounded-2xl shadow-sm">
                    <div class="flex items-center justify-between text-stone-500 mb-2">
                        <span class="text-xs uppercase tracking-wider font-semibold">Jumlah Transaksi</span>
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm">
                            <span class="material-symbols-outlined text-[20px]">receipt_long</span>
                        </div>
                    </div>
                    <div class="text-2xl font-extrabold text-stone-900">
                        {{ number_format($salesData['summary']['transaction_count'] ?? 0) }}
                    </div>
                    <p class="text-[11px] text-stone-400 mt-1">Struk berhasil diselesaikan</p>
                </div>

                <div class="bg-white border border-stone-200/90 p-5 rounded-2xl shadow-sm">
                    <div class="flex items-center justify-between text-stone-500 mb-2">
                        <span class="text-xs uppercase tracking-wider font-semibold">Rata-Rata per Transaksi</span>
                        <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center text-sm">
                            <span class="material-symbols-outlined text-[20px]">trending_up</span>
                        </div>
                    </div>
                    <div class="text-2xl font-extrabold text-stone-900">
                        Rp {{ number_format($salesData['summary']['average_transaction'] ?? 0, 0, ',', '.') }}
                    </div>
                    <p class="text-[11px] text-stone-400 mt-1">Average Order Value (AOV)</p>
                </div>
            </div>

            {{-- TOP SELLING PRODUCTS TABLE --}}
            @if(empty($productId) && count($salesData['product_sales'] ?? []) > 0)
                <div class="bg-white rounded-2xl shadow-sm border border-stone-200/90 p-5 space-y-3">
                    <div class="flex items-center justify-between border-b border-stone-100 pb-3">
                        <div>
                            <h2 class="font-bold text-stone-900 text-sm">Menu Terlaris &amp; Terpopuler</h2>
                            <p class="text-xs text-stone-500">Peringkat menu dengan volume penjualan tertinggi</p>
                        </div>
                        <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 bg-amber-50 text-amber-700 rounded-lg border border-amber-200/60">
                            <span class="material-symbols-outlined text-[15px] text-amber-500">star</span>
                            <span>Top Menu</span>
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs whitespace-nowrap min-w-[500px]">
                            <thead class="bg-stone-50 text-stone-600 font-bold border-b border-stone-200 uppercase tracking-wider text-[11px]">
                                <tr>
                                    <th class="py-2.5 px-4">Nama Menu</th>
                                    <th class="py-2.5 px-4 text-center">Porsi Terjual</th>
                                    <th class="py-2.5 px-4 text-center">Frekuensi</th>
                                    <th class="py-2.5 px-4 text-right">Total Omset</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-stone-100">
                                @foreach($salesData['product_sales'] as $item)
                                    <tr class="hover:bg-stone-50/80 transition-colors">
                                        <td class="py-2.5 px-4 font-bold text-stone-800">{{ $item->product_name }}</td>
                                        <td class="py-2.5 px-4 text-center font-bold text-stone-900">{{ $item->total_quantity }}</td>
                                        <td class="py-2.5 px-4 text-center text-stone-500">{{ $item->transaction_count }}x</td>
                                        <td class="py-2.5 px-4 text-right font-bold text-stone-900 font-mono">Rp {{ number_format($item->total_sales, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            @php
                $periodDescriptor = match($period) {
                    'today' => 'Hari Ini (' . \Carbon\Carbon::now()->translatedFormat('d M Y') . ')',
                    'this_week' => 'Minggu Ini (' . \Carbon\Carbon::now()->startOfWeek()->translatedFormat('d M') . ' - ' . \Carbon\Carbon::now()->endOfWeek()->translatedFormat('d M Y') . ')',
                    'this_month' => 'Bulan Ini (' . \Carbon\Carbon::now()->translatedFormat('F Y') . ')',
                    'this_year' => 'Tahun Ini (' . \Carbon\Carbon::now()->format('Y') . ')',
                    'custom' => ($startDate && $endDate) 
                        ? '(' . \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y') . ' s/d ' . \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y') . ')'
                        : '(Periode Kustom)',
                    'all' => 'Semua Waktu',
                    default => 'Bulan Ini (' . \Carbon\Carbon::now()->translatedFormat('F Y') . ')'
                };
            @endphp

            {{-- TRANSACTION HISTORY TABLE --}}
            <div class="bg-white rounded-2xl shadow-sm border border-stone-200/90 overflow-hidden">
                <div class="p-4 border-b border-stone-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <h2 class="font-bold text-stone-900 text-sm">
                            Daftar Transaksi Penjualan Kasir ({{ $periodDescriptor }})
                        </h2>
                        <p class="text-xs text-stone-500">Histori struk transaksi kasir periode {{ strtolower($periodDescriptor) }}</p>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-1 bg-stone-100 text-stone-600 rounded-lg self-start sm:self-auto">
                        {{ count($salesData['transactions'] ?? []) }} Transaksi
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs whitespace-nowrap min-w-[650px]">
                        <thead class="bg-stone-50 text-stone-600 font-bold border-b border-stone-200 uppercase tracking-wider text-[11px]">
                            <tr>
                                <th class="py-3 px-4">No. Transaksi</th>
                                <th class="py-3 px-4">Waktu</th>
                                <th class="py-3 px-4">Pelanggan</th>
                                <th class="py-3 px-4">Kasir</th>
                                <th class="py-3 px-4 text-center">Metode</th>
                                <th class="py-3 px-4 text-right">Total</th>
                                <th class="py-3 px-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @forelse($salesData['transactions'] as $tx)
                                <tr class="hover:bg-stone-50/80 transition-colors">
                                    <td class="py-3 px-4 font-mono font-bold text-stone-800">{{ $tx->transaction_number }}</td>
                                    <td class="py-3 px-4 font-mono text-stone-500">
                                        {{ \Carbon\Carbon::parse($tx->transaction_date)->format('d M Y') }} {{ $tx->transaction_time }}
                                    </td>
                                    <td class="py-3 px-4 font-bold text-stone-900">
                                        {{ $tx->customer_name ?: '-' }}
                                    </td>
                                    <td class="py-3 px-4 font-medium text-stone-700">{{ $tx->cashier?->name ?? 'Kasir' }}</td>
                                    <td class="py-3 px-4 text-center">
                                        @php
                                            $methodVal = $tx->payment_method instanceof \BackedEnum ? $tx->payment_method->value : (string) $tx->payment_method;
                                        @endphp
                                        @if(strtoupper($methodVal) === 'QRIS')
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-sky-50 text-sky-700 border border-sky-200">
                                                <span class="material-symbols-outlined text-[12px]">qr_code_2</span>
                                                <span>QRIS</span>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <span class="material-symbols-outlined text-[12px]">payments</span>
                                                <span>CASH</span>
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-right font-bold text-stone-900 font-mono">
                                        Rp {{ number_format($tx->total, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $tx->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                            {{ $tx->status === 'completed' ? 'Selesai' : 'Batal' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-10 text-center text-stone-400 text-xs">
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
