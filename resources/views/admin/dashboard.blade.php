@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    {{-- WELCOME & QUICK ACTION BANNER --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-stone-200">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-5">
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-stone-900 font-serif flex items-center gap-2">
                    <span>Selamat Datang, {{ Auth::user()->name ?? 'Owner Yan\'s Food' }}!</span>
                    <span class="text-xl">👋</span>
                </h1>
                <p class="text-xs sm:text-sm text-stone-500 mt-1">
                    Panel kendali utama bisnis kuliner & katering rumahan Yan's Food.
                </p>
            </div>
            <div class="flex items-center gap-2 text-xs font-semibold px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 w-fit">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Sistem Operasional Aktif</span>
            </div>
        </div>

        {{-- 4 QUICK SHORTCUTS --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4">
            <a href="{{ route('admin.pos.index') }}" class="group block p-4 rounded-xl bg-gradient-to-br from-amber-500 to-[#C1440E] text-white shadow-sm hover:shadow-md hover:scale-[1.02] transition duration-200">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-2xl">🛒</span>
                    <span class="text-[10px] font-black bg-white/20 px-2 py-0.5 rounded-full">KASIR</span>
                </div>
                <h4 class="font-bold text-sm sm:text-base leading-tight">Buka Kasir POS</h4>
                <p class="text-[11px] text-white/80 mt-1 line-clamp-1">Transaksi cepat & cetak struk</p>
            </a>

            <a href="{{ route('admin.catering.orders.index') }}" class="group block p-4 rounded-xl bg-gradient-to-br from-indigo-600 to-indigo-800 text-white shadow-sm hover:shadow-md hover:scale-[1.02] transition duration-200">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-2xl">🍱</span>
                    <span class="text-[10px] font-black bg-white/20 px-2 py-0.5 rounded-full">ACARA</span>
                </div>
                <h4 class="font-bold text-sm sm:text-base leading-tight">Pesanan Catering</h4>
                <p class="text-[11px] text-white/80 mt-1 line-clamp-1">Kelola pesanan & jadwal acara</p>
            </a>

            <a href="{{ route('admin.expenses.create') }}" class="group block p-4 rounded-xl bg-gradient-to-br from-rose-500 to-rose-700 text-white shadow-sm hover:shadow-md hover:scale-[1.02] transition duration-200">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-2xl">💸</span>
                    <span class="text-[10px] font-black bg-white/20 px-2 py-0.5 rounded-full">BIAYA</span>
                </div>
                <h4 class="font-bold text-sm sm:text-base leading-tight">Catat Pengeluaran</h4>
                <p class="text-[11px] text-white/80 mt-1 line-clamp-1">Belanja bahan & gas dapur</p>
            </a>

            <a href="{{ route('admin.reports.index') }}" class="group block p-4 rounded-xl bg-gradient-to-br from-emerald-600 to-teal-700 text-white shadow-sm hover:shadow-md hover:scale-[1.02] transition duration-200">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-2xl">📊</span>
                    <span class="text-[10px] font-black bg-white/20 px-2 py-0.5 rounded-full">REKAP</span>
                </div>
                <h4 class="font-bold text-sm sm:text-base leading-tight">Laporan & Ekspor</h4>
                <p class="text-[11px] text-white/80 mt-1 line-clamp-1">Laba rugi & unduh CSV</p>
            </a>
        </div>
    </div>

    {{-- 6 SUMMARY KPI CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- 1. PENDAPATAN POS HARI INI -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-200 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold text-stone-500 uppercase tracking-wider">Omset Kasir POS (Hari Ini)</span>
                    <h3 class="text-2xl font-black text-stone-900 mt-1">Rp {{ number_format($kpis['revenue_today'], 0, ',', '.') }}</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                    🍔
                </div>
            </div>
            <p class="text-[11px] text-stone-400 mt-2 font-medium">{{ $kpis['transactions_today'] }} transaksi selesai hari ini</p>
        </div>

        <!-- 2. PENGELUARAN HARI INI -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-200 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold text-stone-500 uppercase tracking-wider">Pengeluaran Dapur (Hari Ini)</span>
                    <h3 class="text-2xl font-black text-rose-600 mt-1">Rp {{ number_format($kpis['expenses_today'], 0, ',', '.') }}</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl">
                    💸
                </div>
            </div>
            <p class="text-[11px] text-stone-400 mt-2 font-medium">Bahan baku & operasional disetujui</p>
        </div>

        <!-- 3. LABA BERSIH HARI INI -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-200 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold text-stone-500 uppercase tracking-wider">Laba Bersih Sederhana</span>
                    <h3 class="text-2xl font-black {{ $kpis['simple_net_profit_today'] >= 0 ? 'text-emerald-600' : 'text-rose-600' }} mt-1">
                        Rp {{ number_format($kpis['simple_net_profit_today'], 0, ',', '.') }}
                    </h3>
                </div>
                <div class="w-10 h-10 rounded-xl {{ $kpis['simple_net_profit_today'] >= 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }} flex items-center justify-center text-xl">
                    ⚖️
                </div>
            </div>
            <p class="text-[11px] text-stone-400 mt-2 font-medium">(Omset POS + Uang Catering) - Pengeluaran</p>
        </div>

        <!-- 4. UANG MASUK CATERING HARI INI -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-200 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold text-stone-500 uppercase tracking-wider">Uang Masuk Catering (Hari Ini)</span>
                    <h3 class="text-2xl font-black text-sky-700 mt-1">Rp {{ number_format($kpis['catering_income_today'], 0, ',', '.') }}</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-xl">
                    📥
                </div>
            </div>
            <p class="text-[11px] text-stone-400 mt-2 font-medium">Realisasi kas dari DP & pelunasan catering</p>
        </div>

        <!-- 5. CATERING BELUM LUNAS -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-200 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold text-stone-500 uppercase tracking-wider">Catering Belum Lunas</span>
                    <h3 class="text-2xl font-black text-amber-600 mt-1">{{ $kpis['catering_unpaid_count'] }} Order</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                    ⏳
                </div>
            </div>
            <p class="text-[11px] text-stone-400 mt-2 font-medium">Status pembayaran UNPAID / DP</p>
        </div>

        <!-- 6. CATERING SELESAI -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-200 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold text-stone-500 uppercase tracking-wider">Catering Selesai</span>
                    <h3 class="text-2xl font-black text-stone-800 mt-1">{{ $kpis['catering_completed_count'] }} Acara</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-stone-100 text-stone-600 flex items-center justify-center text-xl">
                    ✅
                </div>
            </div>
            <p class="text-[11px] text-stone-400 mt-2 font-medium">Total seluruh pesanan acara beres</p>
        </div>
    </div>

    {{-- SIDE-BY-SIDE TABLES: UPCOMING CATERING & LATEST TRANSACTIONS --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- UPCOMING CATERING ORDERS -->
        <div class="bg-white rounded-2xl shadow-sm border border-stone-200 overflow-hidden">
            <div class="p-4 border-b border-stone-200 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-lg">🍱</span>
                    <h4 class="font-bold text-stone-900 text-sm">Agenda Pesanan Catering Aktif</h4>
                </div>
                <a href="{{ route('admin.catering.orders.index') }}" class="text-xs font-bold text-[#C1440E] hover:underline">
                    Lihat Semua →
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-stone-50 text-stone-600 font-bold border-b border-stone-200 uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="py-2.5 px-4">Pemesan</th>
                            <th class="py-2.5 px-4">Tgl. Acara</th>
                            <th class="py-2.5 px-4 text-right">Nilai</th>
                            <th class="py-2.5 px-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse($upcomingCatering as $catering)
                            <tr class="hover:bg-stone-50 transition">
                                <td class="py-3 px-4">
                                    <div class="font-bold text-stone-900">{{ $catering->customer_name }}</div>
                                    <div class="text-[11px] text-stone-400 font-mono">{{ $catering->order_number }}</div>
                                </td>
                                <td class="py-3 px-4 font-mono">
                                    <div class="font-bold text-stone-800">{{ \Carbon\Carbon::parse($catering->event_date)->format('d M Y') }}</div>
                                    <div class="text-[11px] text-stone-500">{{ $catering->event_time }} WIB</div>
                                </td>
                                <td class="py-3 px-4 text-right font-black text-stone-900">
                                    Rp {{ number_format($catering->total, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800">
                                        {{ $catering->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-stone-400 text-xs">
                                    Tidak ada agenda pesanan catering aktif saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- LATEST POS TRANSACTIONS -->
        <div class="bg-white rounded-2xl shadow-sm border border-stone-200 overflow-hidden">
            <div class="p-4 border-b border-stone-200 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-lg">🛒</span>
                    <h4 class="font-bold text-stone-900 text-sm">Transaksi Kasir Terakhir</h4>
                </div>
                <a href="{{ route('admin.transactions.index') }}" class="text-xs font-bold text-[#C1440E] hover:underline">
                    Lihat Semua →
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-stone-50 text-stone-600 font-bold border-b border-stone-200 uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="py-2.5 px-4">No. Transaksi</th>
                            <th class="py-2.5 px-4">Waktu</th>
                            <th class="py-2.5 px-4 text-center">Metode</th>
                            <th class="py-2.5 px-4 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse($latestTransactions as $tx)
                            <tr class="hover:bg-stone-50 transition">
                                <td class="py-3 px-4 font-mono font-bold text-stone-800">
                                    {{ $tx->transaction_number }}
                                </td>
                                <td class="py-3 px-4 font-mono text-stone-500">
                                    {{ \Carbon\Carbon::parse($tx->transaction_date)->format('d M') }} {{ $tx->transaction_time }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-stone-100 text-stone-700">
                                        {{ $tx->payment_method }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-right font-black text-[#C1440E]">
                                    Rp {{ number_format($tx->total, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-stone-400 text-xs">
                                    Belum ada transaksi kasir hari ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
