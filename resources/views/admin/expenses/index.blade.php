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
        <form action="{{ route('admin.expenses.index') }}" method="GET" class="pt-3 border-t border-stone-100 flex flex-wrap items-center gap-3 text-xs">
            <div class="flex-1 min-w-[200px]">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari deskripsi / no. EXP..." 
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

            {{-- FILTER TANGGAL (DARI TANGGAL & SAMPAI TANGGAL) --}}
            <div class="flex items-center gap-1.5 bg-stone-50 p-1 rounded-xl border border-stone-200">
                <span class="text-[10px] text-stone-400 font-bold px-1 uppercase">Dari</span>
                <input 
                    type="date" 
                    name="start_date" 
                    value="{{ request('start_date') }}" 
                    class="px-2 py-1 rounded-lg border border-stone-300 bg-white text-xs focus:ring-1 focus:ring-[#C1440E]"
                    title="Dari Tanggal"
                >
                <span class="text-[10px] text-stone-400 font-bold px-1 uppercase">S/D</span>
                <input 
                    type="date" 
                    name="end_date" 
                    value="{{ request('end_date') }}" 
                    class="px-2 py-1 rounded-lg border border-stone-300 bg-white text-xs focus:ring-1 focus:ring-[#C1440E]"
                    title="Sampai Tanggal"
                >
            </div>

            <button type="submit" class="px-4 py-2 bg-stone-800 text-white rounded-xl font-bold hover:bg-stone-900 transition">
                Filter
            </button>

            @if(request()->hasAny(['search', 'category', 'start_date', 'end_date', 'date', 'month']))
                <a href="{{ route('admin.expenses.index') }}" class="px-3 py-2 text-stone-500 hover:text-stone-800 font-bold transition">
                    Reset
                </a>
            @endif
        </form>

        {{-- QUICK MONTH NAVIGATION PILLS --}}
        @if($availableMonths->count() > 0)
            <div class="pt-2 flex items-center gap-1.5 overflow-x-auto pb-1 text-xs">
                <span class="text-[11px] font-bold text-stone-400 uppercase tracking-wider mr-1">Pilih Bulan:</span>
                <a 
                    href="{{ route('admin.expenses.index', array_merge(request()->except('month'), ['month' => 'all'])) }}"
                    class="px-3 py-1 rounded-lg font-bold text-xs transition {{ (!request('month') || request('month') === 'all') ? 'bg-stone-900 text-white shadow-xs' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}"
                >
                    Semua Bulan
                </a>
                @foreach($availableMonths as $m)
                    <a 
                        href="{{ route('admin.expenses.index', array_merge(request()->except('month'), ['month' => $m['key']])) }}"
                        class="px-3 py-1 rounded-lg font-bold text-xs transition flex items-center gap-1.5 {{ request('month') === $m['key'] ? 'bg-[#C1440E] text-white shadow-xs' : 'bg-stone-100 text-stone-700 hover:bg-stone-200' }}"
                    >
                        <span>{{ $m['label'] }}</span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    {{-- TOTAL EXPENSE BANNER --}}
    <div class="bg-gradient-to-r from-rose-600 to-red-700 text-white p-5 rounded-2xl shadow-sm flex items-center justify-between">
        <div>
            <span class="text-xs uppercase font-bold tracking-wider opacity-85">
                Total Pengeluaran Sesuai Filter
                @if(request('month') && request('month') !== 'all')
                    ({{ \Carbon\Carbon::createFromFormat('Y-m', request('month'))->translatedFormat('F Y') }})
                @endif
            </span>
            <h2 class="text-2xl font-black mt-1 font-mono">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</h2>
        </div>
        <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center text-2xl">
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
            <div class="p-4 sm:p-5 bg-gradient-to-r from-stone-50 via-rose-50/20 to-white border-b border-stone-200 flex flex-col lg:flex-row lg:items-center justify-between gap-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl {{ $isCurrentMonth ? 'bg-rose-600 text-white' : 'bg-stone-200 text-stone-700' }} flex items-center justify-center font-bold text-sm shadow-xs">
                        🗓️
                    </div>
                    <div>
                        <h2 class="text-base font-black text-stone-900 font-serif">
                            Pengeluaran Dapur: {{ $monthTitle }}
                        </h2>
                        <p class="text-[11px] text-stone-500 mt-0.5">Seluruh catatan belanja &amp; biaya dapur pada bulan {{ $monthTitle }}</p>
                    </div>
                </div>

                {{-- MONTH KPI SUMMARY CHIPS --}}
                <div class="flex flex-wrap items-center gap-2 text-xs">
                    <span class="px-2.5 py-1 bg-stone-100 text-stone-700 rounded-lg font-bold">
                        {{ $monthExpCount }} Catatan Belanja
                    </span>
                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-lg font-bold font-mono">
                        Cash: Rp {{ number_format($cashTotal, 0, ',', '.') }}
                    </span>
                    <span class="px-2.5 py-1 bg-sky-50 text-sky-800 border border-sky-200 rounded-lg font-bold font-mono">
                        Transfer: Rp {{ number_format($transferTotal, 0, ',', '.') }}
                    </span>
                    <span class="px-3 py-1 bg-stone-900 text-white rounded-lg font-black font-mono">
                        Total: Rp {{ number_format($monthTotal, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- EXPENSES TABLE UNTUK BULAN INI --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-stone-50/75 text-stone-600 font-bold border-b border-stone-200 uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="py-3 px-4">No. Pengeluaran</th>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Nama Pengeluaran</th>
                            <th class="py-3 px-4">Kategori</th>
                            <th class="py-3 px-4 text-center">Metode</th>
                            <th class="py-3 px-4 text-right">Nominal</th>
                            <th class="py-3 px-4 text-center">Bukti Nota</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach($monthItems as $exp)
                            <tr class="hover:bg-amber-50/30 transition">
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
                                    @if($exp->receipt_image)
                                        <a href="{{ asset('storage/' . $exp->receipt_image) }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] text-[#C1440E] font-bold hover:underline">
                                            <span>🧾</span>
                                            <span>Lihat</span>
                                        </a>
                                    @else
                                        <span class="text-stone-300">-</span>
                                    @endif
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

    {{-- PAGINATION --}}
    @if($expenses->hasPages())
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-stone-200">
            {{ $expenses->links() }}
        </div>
    @endif
</div>
@endsection
