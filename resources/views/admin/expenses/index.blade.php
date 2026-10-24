@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-200 space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-stone-900 font-serif flex items-center gap-2">
                    <span>💸</span>
                    <span>Pencatatan Biaya &amp; Pengeluaran Dapur</span>
                </h1>
                <p class="text-xs text-stone-500 mt-0.5">Kelola belanja bahan baku, gas, kemasan, dan operasional dapur yang dikelompokkan secara terstruktur per bulan.</p>
            </div>
            <a href="{{ route('admin.expenses.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#C1440E] hover:bg-[#a3380b] text-white rounded-xl font-bold text-xs shadow-sm transition">
                <span>+ Catat Pengeluaran Baru</span>
            </a>
        </div>

        {{-- FILTER BAR DENGAN FILTERISASI TANGGAL & BULAN --}}
        <form action="{{ route('admin.expenses.index') }}" method="GET" id="admin-expense-form" class="pt-3 border-t border-stone-100 flex flex-col sm:flex-row flex-wrap items-stretch sm:items-center gap-2.5 sm:gap-3 text-xs">
            <div class="w-full sm:flex-1 sm:min-w-[200px] relative">
                <span class="material-symbols-outlined absolute left-3 top-2.5 text-stone-400 text-[18px]">search</span>
                <input 
                    type="text" 
                    id="admin-expense-search"
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Ketik untuk mencari deskripsi / no. EXP..." 
                    autocomplete="off"
                    class="w-full pl-9 pr-8 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E] focus:bg-white transition"
                >
                <button type="button" id="admin-expense-clear-btn" class="hidden absolute right-2.5 top-2.5 text-stone-400 hover:text-stone-600">
                    <span class="material-symbols-outlined text-[16px]">close</span>
                </button>
            </div>

            <div class="w-full sm:w-auto">
                <select name="category" onchange="this.form.submit()" class="w-full sm:w-auto px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E] cursor-pointer">
                    <option value="all">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
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

            {{-- FILTER TANGGAL (DARI TANGGAL & SAMPAI TANGGAL) --}}
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-1.5 bg-stone-50 p-1.5 sm:p-1 rounded-xl border border-stone-200 w-full sm:w-auto">
                <div class="flex items-center gap-1">
                    <span class="text-[10px] text-stone-400 font-bold px-1 uppercase shrink-0">Dari</span>
                    <input 
                        type="date" 
                        name="start_date" 
                        value="{{ request('start_date') }}" 
                        onchange="this.form.submit()"
                        class="w-full sm:w-auto px-2 py-1 rounded-lg border border-stone-300 bg-white text-xs focus:ring-1 focus:ring-[#C1440E]"
                        title="Dari Tanggal"
                    >
                </div>
                <div class="flex items-center gap-1">
                    <span class="text-[10px] text-stone-400 font-bold px-1 uppercase shrink-0">S/D</span>
                    <input 
                        type="date" 
                        name="end_date" 
                        value="{{ request('end_date') }}" 
                        onchange="this.form.submit()"
                        class="w-full sm:w-auto px-2 py-1 rounded-lg border border-stone-300 bg-white text-xs focus:ring-1 focus:ring-[#C1440E]"
                        title="Sampai Tanggal"
                    >
                </div>
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <a href="{{ route('admin.expenses.index') }}" id="btn-refresh-expenses" class="flex-1 sm:flex-none px-3.5 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-xl font-bold transition flex items-center justify-center gap-1.5 cursor-pointer text-xs" title="Segarkan dan reset filter">
                    <span class="material-symbols-outlined text-[16px]">refresh</span>
                    <span>Refresh</span>
                </a>
            </div>
        </form>

        {{-- QUICK MONTH NAVIGATION PILLS --}}
        @if($availableMonths->count() > 0)
            <div class="pt-2 flex items-center gap-1.5 overflow-x-auto pb-1 text-xs no-scrollbar">
                <span class="text-[11px] font-bold text-stone-400 uppercase tracking-wider mr-1 shrink-0">Pilih Bulan:</span>
                <a 
                    href="{{ route('admin.expenses.index', array_merge(request()->except('month'), ['month' => 'all'])) }}"
                    class="px-3 py-1 rounded-lg font-bold text-xs transition shrink-0 {{ (!request('month') || request('month') === 'all') ? 'bg-stone-900 text-white shadow-xs' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}"
                >
                    Semua Bulan
                </a>
                @foreach($availableMonths as $m)
                    <a 
                        href="{{ route('admin.expenses.index', array_merge(request()->except('month'), ['month' => $m['key']])) }}"
                        class="px-3 py-1 rounded-lg font-bold text-xs transition flex items-center gap-1.5 shrink-0 {{ request('month') === $m['key'] ? 'bg-[#C1440E] text-white shadow-xs' : 'bg-stone-100 text-stone-700 hover:bg-stone-200' }}"
                    >
                        <span>{{ $m['label'] }}</span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    {{-- TOTAL EXPENSE BANNER --}}
    <div class="bg-gradient-to-r from-rose-600 to-red-700 text-white p-4 sm:p-5 rounded-2xl shadow-sm flex items-center justify-between gap-3">
        <div>
            <span class="text-[11px] sm:text-xs uppercase font-bold tracking-wider opacity-85 block">
                Total Pengeluaran
                @if(request('month') && request('month') !== 'all')
                    ({{ \Carbon\Carbon::createFromFormat('Y-m', request('month'))->translatedFormat('F Y') }})
                @endif
            </span>
            <h2 class="text-xl sm:text-2xl font-black mt-1 font-mono">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</h2>
        </div>
        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-white/20 flex items-center justify-center text-xl sm:text-2xl shrink-0">
            💸
        </div>
    </div>

    {{-- EXPENSES SECTIONS PER BULAN --}}
    @forelse($groupedExpenses as $monthKey => $monthItems)
        @php
            try {
                $monthDate = \Carbon\Carbon::createFromFormat('Y-m', $monthKey);
                $monthTitle = $monthDate->translatedFormat('F Y');
            } catch (\Throwable $e) {
                $monthTitle = $monthKey;
            }

            $isCurrentMonth = ($monthKey === $currentMonthKey);
            $monthExpCount = $monthItems->where('status', 'APPROVED')->count();
            $monthTotal = $monthItems->where('status', 'APPROVED')->sum('amount');
            $cashTotal = $monthItems->where('status', 'APPROVED')->where('payment_method', 'CASH')->sum('amount');
            $transferTotal = $monthItems->where('status', 'APPROVED')->where('payment_method', 'TRANSFER')->sum('amount');
        @endphp

        <div class="bg-white rounded-2xl shadow-sm border border-stone-200 overflow-hidden space-y-0">
            {{-- MONTH SECTION HEADER --}}
            <div class="p-4 sm:p-5 bg-gradient-to-r from-stone-50 via-rose-50/20 to-white border-b border-stone-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl {{ $isCurrentMonth ? 'bg-rose-600 text-white' : 'bg-stone-200 text-stone-700' }} flex items-center justify-center font-bold text-sm shadow-xs shrink-0">
                        🗓️
                    </div>
                    <div>
                        <h2 class="text-sm sm:text-base font-black text-stone-900 font-serif">
                            Pengeluaran Dapur: {{ $monthTitle }}
                        </h2>
                        <p class="text-[11px] text-stone-500 mt-0.5">Seluruh catatan belanja &amp; biaya dapur pada bulan {{ $monthTitle }}</p>
                    </div>
                </div>

                {{-- MONTH KPI SUMMARY CHIPS --}}
                <div class="flex flex-wrap items-center gap-1.5 sm:gap-2 text-xs">
                    <span class="px-2.5 py-1 bg-stone-100 text-stone-700 rounded-lg font-bold text-[11px] sm:text-xs">
                        {{ $monthExpCount }} Catatan Belanja
                    </span>
                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-lg font-bold font-mono text-[11px] sm:text-xs">
                        Cash: Rp {{ number_format($cashTotal, 0, ',', '.') }}
                    </span>
                    <span class="px-2.5 py-1 bg-sky-50 text-sky-800 border border-sky-200 rounded-lg font-bold font-mono text-[11px] sm:text-xs">
                        Transfer: Rp {{ number_format($transferTotal, 0, ',', '.') }}
                    </span>
                    <span class="px-2.5 sm:px-3 py-1 bg-stone-900 text-white rounded-lg font-black font-mono text-[11px] sm:text-xs">
                        Total: Rp {{ number_format($monthTotal, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- EXPENSES TABLE UNTUK BULAN INI --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs whitespace-nowrap min-w-[620px]">
                    <thead class="bg-stone-50/75 text-stone-600 font-bold border-b border-stone-200 uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="py-3 px-4">No. Pengeluaran</th>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Nama Pengeluaran</th>
                            <th class="py-3 px-4">Kategori</th>
                            <th class="py-3 px-4 text-center">Metode</th>
                            <th class="py-3 px-4 text-right">Nominal</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach($monthItems as $exp)
                            <tr class="expense-row-item hover:bg-amber-50/30 transition"
                                data-number="{{ strtolower($exp->expense_number) }}"
                                data-name="{{ strtolower($exp->name) }}"
                                data-desc="{{ strtolower($exp->description ?? '') }}"
                                data-cat="{{ strtolower($exp->category?->name ?? '') }}">
                                <td class="py-3.5 px-4 font-mono font-bold text-stone-800">
                                    <a href="{{ route('admin.expenses.show', $exp->id) }}" class="hover:text-[#C1440E] hover:underline">
                                        {{ $exp->expense_number }}
                                    </a>
                                </td>
                                <td class="py-3.5 px-4 font-mono text-stone-600">
                                    {{ \Carbon\Carbon::parse($exp->expense_date)->format('d M Y') }}
                                </td>
                                <td class="py-3.5 px-4 font-bold text-stone-900">
                                    <div>{{ $exp->name }}</div>
                                    @if($exp->description)
                                        <div class="text-[11px] text-stone-500 font-normal mt-0.5 line-clamp-1">{{ $exp->description }}</div>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-stone-100 text-stone-700">
                                        {{ $exp->category?->name ?? 'Operasional' }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center font-semibold text-stone-600">{{ $exp->payment_method }}</td>
                                <td class="py-3.5 px-4 text-right font-black text-rose-600 text-sm font-mono">
                                    Rp {{ number_format($exp->amount, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="inline-flex items-center justify-center gap-1.5">
                                        {{-- DETAIL --}}
                                        <a href="{{ route('admin.expenses.show', $exp->id) }}" class="p-1.5 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-lg text-xs transition" title="Lihat Detail">
                                            👁️
                                        </a>
                                        {{-- EDIT --}}
                                        <a href="{{ route('admin.expenses.edit', $exp->id) }}" class="p-1.5 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-lg text-xs transition" title="Ubah Pengeluaran">
                                            ✏️
                                        </a>
                                        {{-- DELETE --}}
                                        <form action="{{ route('admin.expenses.destroy', $exp->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan pengeluaran {{ $exp->expense_number }}?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-xs transition" title="Hapus Pengeluaran">
                                                🗑️
                                            </button>
                                        </form>
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
            <div class="text-4xl">💸</div>
            <h3 class="text-stone-700 font-bold text-sm">Tidak ada catatan pengeluaran</h3>
            <p class="text-xs text-stone-400">Belum ada catatan pengeluaran dapur yang sesuai dengan filter atau periode yang Anda pilih.</p>
        </div>
    @endforelse

    {{-- CLIENT SIDE EMPTY STATE FOR INSTANT SEARCH --}}
    <div id="admin-expense-empty" class="hidden py-16 text-center bg-white rounded-2xl border border-dashed border-stone-300 space-y-3">
        <span class="material-symbols-outlined text-4xl text-stone-300">search_off</span>
        <div>
            <p class="text-stone-700 text-sm font-bold">Pengeluaran tidak ditemukan</p>
            <p class="text-stone-500 text-xs mt-0.5">Tidak ada catatan pengeluaran dapur yang cocok dengan kata kunci Anda.</p>
        </div>
        <button type="button" onclick="window.clearExpenseSearch()" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-xl text-xs font-bold transition">
            <span class="material-symbols-outlined text-[16px]">refresh</span>
            <span>Reset Pencarian</span>
        </button>
    </div>

    {{-- PAGINATION --}}
    @if($expenses->hasPages())
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-stone-200">
            {{ $expenses->links() }}
        </div>
    @endif

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('admin-expense-search');
        const clearBtn = document.getElementById('admin-expense-clear-btn');
        const rows = document.querySelectorAll('.expense-row-item');
        const emptyState = document.getElementById('admin-expense-empty');

        function doInstantExpenseFilter() {
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
                const name = row.dataset.name || '';
                const desc = row.dataset.desc || '';
                const cat = row.dataset.cat || '';

                if (!query || number.includes(query) || name.includes(query) || desc.includes(query) || cat.includes(query)) {
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
            searchInput.addEventListener('input', doInstantExpenseFilter);
        }

        window.clearExpenseSearch = function() {
            if (searchInput) {
                searchInput.value = '';
                doInstantExpenseFilter();
                searchInput.focus();
            }
        };

        if (clearBtn) {
            clearBtn.addEventListener('click', window.clearExpenseSearch);
        }
    });
    </script>
</div>
@endsection
