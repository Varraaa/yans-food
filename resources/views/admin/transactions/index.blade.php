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

        <form action="{{ route('admin.transactions.index') }}" method="GET" id="admin-tx-form" class="pt-3 border-t border-stone-100 flex flex-col sm:flex-row flex-wrap items-stretch sm:items-center gap-2.5 sm:gap-3 text-xs">
            <div class="w-full sm:flex-1 sm:min-w-[200px] relative">
                <span class="material-symbols-outlined absolute left-3 top-2.5 text-stone-400 text-[18px]">search</span>
                <input 
                    type="text" 
                    id="admin-tx-search"
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Ketik untuk mencari nomor transaksi / pelanggan..." 
                    autocomplete="off"
                    class="w-full pl-9 pr-8 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E] focus:bg-white transition"
                >
                <button type="button" id="admin-tx-clear-btn" class="hidden absolute right-2.5 top-2.5 text-stone-400 hover:text-stone-600">
                    <span class="material-symbols-outlined text-[16px]">close</span>
                </button>
            </div>

            {{-- FILTER BULAN --}}
            <div class="w-full sm:w-auto">
                <select name="month" onchange="this.form.submit()" class="w-full sm:w-auto px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E] cursor-pointer">
                    <option value="all">Semua Bulan</option>
                    @foreach($availableMonths as $m)
                        <option value="{{ $m['key'] }}" {{ request('month') === $m['key'] ? 'selected' : '' }}>
                            {{ $m['label'] }} {{ $m['is_current'] ? '(Bulan Ini)' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="w-full sm:w-auto">
                <input 
                    type="date" 
                    name="date" 
                    value="{{ request('date') }}" 
                    onchange="this.form.submit()"
                    class="w-full sm:w-auto px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]"
                    title="Filter Tanggal Spesifik"
                >
            </div>

            <div class="w-full sm:w-auto">
                <select name="method" onchange="this.form.submit()" class="w-full sm:w-auto px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E] cursor-pointer">
                    <option value="all">Semua Metode</option>
                    <option value="CASH" {{ strtoupper(request('method')) === 'CASH' ? 'selected' : '' }}>Tunai (Cash)</option>
                    <option value="QRIS" {{ strtoupper(request('method')) === 'QRIS' ? 'selected' : '' }}>QRIS</option>
                </select>
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <a href="{{ route('admin.transactions.index') }}" id="btn-refresh-tx" class="flex-1 sm:flex-none px-3.5 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-xl font-bold transition flex items-center justify-center gap-1.5 cursor-pointer text-xs" title="Segarkan dan reset filter">
                    <span class="material-symbols-outlined text-[16px]">refresh</span>
                    <span>Refresh</span>
                </a>
            </div>
        </form>

        {{-- QUICK MONTH NAVIGATION PILLS --}}
        @if($availableMonths->count() > 0)
            <div class="pt-3 border-t border-stone-100 mt-2.5 flex items-center gap-2 overflow-x-auto pb-3.5 sm:pb-2.5 text-xs admin-filter-scroll">
                <span class="text-[11px] font-bold text-stone-400 uppercase tracking-wider mr-1 shrink-0">Pilih Bulan:</span>
                <a 
                    href="{{ route('admin.transactions.index', array_merge(request()->except('month'), ['month' => 'all'])) }}"
                    class="px-3 py-1.5 rounded-lg font-bold text-xs transition shrink-0 {{ (!request('month') || request('month') === 'all') ? 'bg-stone-900 text-white shadow-xs' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}"
                >
                    Semua Bulan
                </a>
                @foreach($availableMonths as $m)
                    <a 
                        href="{{ route('admin.transactions.index', array_merge(request()->except('month'), ['month' => $m['key']])) }}"
                        class="px-3 py-1.5 rounded-lg font-bold text-xs transition flex items-center gap-1.5 shrink-0 {{ request('month') === $m['key'] ? 'bg-[#C1440E] text-white shadow-xs' : 'bg-stone-100 text-stone-700 hover:bg-stone-200' }}"
                    >
                        <span>{{ $m['label'] }}</span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    {{-- TOTAL BANNER --}}
    <div class="bg-gradient-to-r from-amber-600 to-[#C1440E] text-white p-4 sm:p-5 rounded-2xl shadow-sm flex items-center justify-between gap-3">
        <div>
            <span class="text-[11px] sm:text-xs uppercase font-bold tracking-wider opacity-85 block">
                Total Omset Transaksi
                @if(request('month') && request('month') !== 'all')
                    ({{ \Carbon\Carbon::createFromFormat('Y-m', request('month'))->translatedFormat('F Y') }})
                @endif
            </span>
            <h2 class="text-xl sm:text-2xl font-black mt-1 font-mono">Rp {{ number_format($totalFilteredAmount, 0, ',', '.') }}</h2>
        </div>
        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-white/20 flex items-center justify-center text-xl sm:text-2xl shrink-0">
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
            <div class="p-4 sm:p-5 bg-gradient-to-r from-stone-50 via-amber-50/20 to-white border-b border-stone-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl {{ $isCurrentMonth ? 'bg-[#C1440E] text-white' : 'bg-stone-200 text-stone-700' }} flex items-center justify-center font-bold text-sm shadow-xs shrink-0">
                        🗓️
                    </div>
                    <div>
                        <h2 class="text-sm sm:text-base font-black text-stone-900 font-serif">
                            Riwayat Transaksi: {{ $monthTitle }}
                        </h2>
                        <p class="text-[11px] text-stone-500 mt-0.5">Seluruh transaksi penjualan kasir pada bulan {{ $monthTitle }}</p>
                    </div>
                </div>

                {{-- MONTH KPI SUMMARY CHIPS --}}
                <div class="flex flex-wrap items-center gap-1.5 sm:gap-2 text-xs">
                    <span class="px-2.5 py-1 bg-stone-100 text-stone-700 rounded-lg font-bold text-[11px] sm:text-xs">
                        {{ $monthTxCount }} Transaksi
                    </span>
                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-lg font-bold font-mono text-[11px] sm:text-xs">
                        Cash: Rp {{ number_format($cashTotal, 0, ',', '.') }}
                    </span>
                    <span class="px-2.5 py-1 bg-sky-50 text-sky-800 border border-sky-200 rounded-lg font-bold font-mono text-[11px] sm:text-xs">
                        QRIS: Rp {{ number_format($qrisTotal, 0, ',', '.') }}
                    </span>
                    <span class="px-2.5 sm:px-3 py-1 bg-stone-900 text-white rounded-lg font-black font-mono text-[11px] sm:text-xs">
                        Total: Rp {{ number_format($monthTotal, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- TRANSACTIONS TABLE UNTUK BULAN INI --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs whitespace-nowrap min-w-[720px]">
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
                            <tr class="transaction-row-item hover:bg-amber-50/30 transition"
                                data-number="{{ strtolower($tx->transaction_number) }}"
                                data-customer="{{ strtolower($tx->customer_name ?? '') }}"
                                data-cashier="{{ strtolower($tx->cashier?->name ?? '') }}"
                                data-method="{{ strtolower($methodVal) }}">
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

    {{-- CLIENT SIDE EMPTY STATE FOR INSTANT SEARCH --}}
    <div id="admin-tx-empty" class="hidden py-16 text-center bg-white rounded-2xl border border-dashed border-stone-300 space-y-3">
        <span class="material-symbols-outlined text-4xl text-stone-300">search_off</span>
        <div>
            <p class="text-stone-700 text-sm font-bold">Transaksi tidak ditemukan</p>
            <p class="text-stone-500 text-xs mt-0.5">Tidak ada riwayat transaksi yang cocok dengan kata kunci pencarian Anda.</p>
        </div>
        <button type="button" onclick="window.clearTxSearch()" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-xl text-xs font-bold transition">
            <span class="material-symbols-outlined text-[16px]">refresh</span>
            <span>Reset Pencarian</span>
        </button>
    </div>

    {{-- PAGINATION --}}
    @if($transactions->hasPages())
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-stone-200">
            {{ $transactions->links() }}
        </div>
    @endif

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('admin-tx-search');
        const clearBtn = document.getElementById('admin-tx-clear-btn');
        const rows = document.querySelectorAll('.transaction-row-item');
        const emptyState = document.getElementById('admin-tx-empty');

        function doInstantTxFilter() {
            const query = (searchInput.value || '').trim().toLowerCase();
            let visibleCount = 0;

            if (clearBtn) {
                if (query.length > 0) {
                    clearBtn.classList.remove('hidden');
                } else {
                    clearBtn.classList.add('hidden');
                }
            }

            rows.forEach(row => {
                const number = row.dataset.number || '';
                const customer = row.dataset.customer || '';
                const cashier = row.dataset.cashier || '';
                const method = row.dataset.method || '';

                if (!query || number.includes(query) || customer.includes(query) || cashier.includes(query) || method.includes(query)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (emptyState) {
                if (visibleCount === 0 && rows.length > 0) {
                    emptyState.classList.remove('hidden');
                } else {
                    emptyState.classList.add('hidden');
                }
            }
        }

        if (searchInput) {
            searchInput.addEventListener('input', doInstantTxFilter);
        }

        window.clearTxSearch = function() {
            if (searchInput) {
                searchInput.value = '';
                doInstantTxFilter();
                searchInput.focus();
            }
        };

        if (clearBtn) {
            clearBtn.addEventListener('click', window.clearTxSearch);
        }
    });
    </script>
</div>
@endsection
