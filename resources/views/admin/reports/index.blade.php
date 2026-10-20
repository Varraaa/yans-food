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
        <div class="space-y-6">
            {{-- 4 FINANCIAL METRIC CARDS --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- TOTAL PENDAPATAN KOTOR --}}
                <div class="bg-gradient-to-br from-[#C1440E] to-amber-600 text-white p-5 rounded-2xl shadow-sm">
                    <span class="text-[11px] uppercase tracking-wider font-bold opacity-80">Total Kas Masuk (Gross)</span>
                    <h3 class="text-2xl font-black mt-1">Rp {{ number_format($financialData['total_gross_income'], 0, ',', '.') }}</h3>
                    <p class="text-[11px] opacity-80 mt-2 font-medium">Omset Penjualan Kasir POS</p>
                </div>

                {{-- TOTAL BIAYA DAPUR --}}
                <div class="bg-gradient-to-br from-rose-600 to-red-700 text-white p-5 rounded-2xl shadow-sm">
                    <span class="text-[11px] uppercase tracking-wider font-bold opacity-80">Total Biaya &amp; Pengeluaran</span>
                    <h3 class="text-2xl font-black mt-1">Rp {{ number_format($financialData['total_expenses'], 0, ',', '.') }}</h3>
                    <p class="text-[11px] opacity-80 mt-2 font-medium">Bahan baku, operasional, &amp; gas</p>
                </div>

                {{-- LABA BERSIH OPERASIONAL --}}
                <div class="p-5 rounded-2xl shadow-sm text-white {{ $financialData['net_profit'] >= 0 ? 'bg-gradient-to-br from-emerald-600 to-teal-700' : 'bg-gradient-to-br from-red-600 to-rose-700' }}">
                    <span class="text-[11px] uppercase tracking-wider font-bold opacity-80">Laba Bersih Operasional</span>
                    <h3 class="text-2xl font-black mt-1">Rp {{ number_format($financialData['net_profit'], 0, ',', '.') }}</h3>
                    <p class="text-[11px] opacity-80 mt-2 font-medium">Keuntungan bersih setelah biaya dapur</p>
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

            {{-- REVENUE COMPARISON & EXPENSES BREAKDOWN --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- REVENUE SOURCE BREAKDOWN --}}
                <div class="bg-white rounded-2xl p-5 border border-stone-200 shadow-sm space-y-4">
                    <h4 class="font-bold text-stone-900 text-sm">Sumber Kas Masuk</h4>
                    <div class="space-y-3">
                        <div class="p-4 rounded-xl bg-amber-50/50 border border-amber-200 flex justify-between items-center">
                            <div>
                                <div class="font-bold text-stone-800 text-sm">🍔 Penjualan Kasir POS</div>
                                <div class="text-xs text-stone-500 mt-0.5">{{ $financialData['pos_count'] }} transaksi kasir</div>
                            </div>
                            <span class="font-black text-base text-[#C1440E]">
                                Rp {{ number_format($financialData['pos_revenue'], 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- EXPENSES BY CATEGORY --}}
                <div class="bg-white rounded-2xl p-5 border border-stone-200 shadow-sm space-y-4">
                    <div class="flex justify-between items-center">
                        <h4 class="font-bold text-stone-900 text-sm">Rincian Pengeluaran Dapur per Kategori</h4>
                        <span class="text-xs text-stone-500 font-medium">{{ $financialData['expense_count'] }} Catatan</span>
                    </div>

                    <div class="space-y-2.5">
                        @forelse($financialData['expenses_by_category'] as $cat)
                            <div class="flex items-center justify-between p-3 rounded-xl bg-stone-50 text-xs">
                                <div class="font-semibold text-stone-800">
                                    {{ $cat->category_name ?? $cat->category ?? 'Operasional' }} <span class="text-stone-400 font-normal">({{ $cat->count }}x)</span>
                                </div>
                                <span class="font-bold text-rose-600">
                                    Rp {{ number_format($cat->total_amount, 0, ',', '.') }}
                                </span>
                            </div>
                        @empty
                            <div class="py-6 text-center text-stone-400 text-xs">
                                Belum ada pengeluaran dapur yang disetujui pada periode ini.
                            </div>
                        @endforelse
                    </div>
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
                                    <td class="py-3 px-4 text-center font-semibold text-stone-600">{{ $tx->payment_method }}</td>
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
