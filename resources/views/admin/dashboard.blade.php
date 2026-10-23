@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    {{-- WELCOME & QUICK ACTION BANNER --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-stone-200">
        <div class="mb-5">
            <h1 class="text-xl sm:text-2xl font-black text-stone-900 font-serif">
                Selamat Datang, {{ Auth::user()->name ?? 'Owner Yan\'s Food' }}!
            </h1>
            <p class="text-xs sm:text-sm text-stone-500 mt-1">
                Panel kendali utama sistem kasir POS &amp; manajemen produk Yan's Food.
            </p>
        </div>

        {{-- 4 QUICK SHORTCUTS --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4">
            <a href="{{ route('admin.pos.index') }}" class="group block p-4 rounded-xl bg-gradient-to-br from-amber-500 to-[#C1440E] text-white shadow-sm hover:shadow-md hover:scale-[1.02] transition duration-200">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-2xl">🛒</span>
                    <span class="text-[10px] font-black bg-white/20 px-2 py-0.5 rounded-full">KASIR</span>
                </div>
                <h4 class="font-bold text-sm sm:text-base leading-tight">Buka Kasir POS</h4>
                <p class="text-[11px] text-white/80 mt-1 line-clamp-1">Transaksi cepat &amp; cetak struk</p>
            </a>

            <a href="{{ route('admin.products.index') }}" class="group block p-4 rounded-xl bg-gradient-to-br from-indigo-600 to-indigo-800 text-white shadow-sm hover:shadow-md hover:scale-[1.02] transition duration-200">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-2xl">🍗</span>
                    <span class="text-[10px] font-black bg-white/20 px-2 py-0.5 rounded-full">KATALOG</span>
                </div>
                <h4 class="font-bold text-sm sm:text-base leading-tight">Kelola Produk</h4>
                <p class="text-[11px] text-white/80 mt-1 line-clamp-1">Harga, foto, &amp; stok menu</p>
            </a>

            <a href="{{ route('admin.expenses.create') }}" class="group block p-4 rounded-xl bg-gradient-to-br from-rose-500 to-rose-700 text-white shadow-sm hover:shadow-md hover:scale-[1.02] transition duration-200">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-2xl">💸</span>
                    <span class="text-[10px] font-black bg-white/20 px-2 py-0.5 rounded-full">BIAYA</span>
                </div>
                <h4 class="font-bold text-sm sm:text-base leading-tight">Catat Pengeluaran</h4>
                <p class="text-[11px] text-white/80 mt-1 line-clamp-1">Belanja bahan &amp; gas dapur</p>
            </a>

            <a href="{{ route('admin.reports.index') }}" class="group block p-4 rounded-xl bg-gradient-to-br from-emerald-600 to-teal-700 text-white shadow-sm hover:shadow-md hover:scale-[1.02] transition duration-200">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-2xl">📊</span>
                    <span class="text-[10px] font-black bg-white/20 px-2 py-0.5 rounded-full">REKAP</span>
                </div>
                <h4 class="font-bold text-sm sm:text-base leading-tight">Laporan &amp; Ekspor</h4>
                <p class="text-[11px] text-white/80 mt-1 line-clamp-1">Laba rugi &amp; unduh CSV</p>
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

        <!-- 2. TRANSAKSI HARI INI -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-200 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold text-stone-500 uppercase tracking-wider">Total Transaksi (Hari Ini)</span>
                    <h3 class="text-2xl font-black text-indigo-600 mt-1">{{ $kpis['transactions_today'] }} Struk</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                    🧾
                </div>
            </div>
            <p class="text-[11px] text-stone-400 mt-2 font-medium">Pelayanan kasir luring di kasir</p>
        </div>

        <!-- 3. PENGELUARAN HARI INI -->
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
            <p class="text-[11px] text-stone-400 mt-2 font-medium">Bahan baku &amp; operasional disetujui</p>
        </div>

        <!-- 4. LABA BERSIH HARI INI -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-200 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold text-stone-500 uppercase tracking-wider">Laba Bersih Kasir (Hari Ini)</span>
                    <h3 class="text-2xl font-black {{ $kpis['simple_net_profit_today'] >= 0 ? 'text-emerald-600' : 'text-rose-600' }} mt-1">
                        Rp {{ number_format($kpis['simple_net_profit_today'], 0, ',', '.') }}
                    </h3>
                </div>
                <div class="w-10 h-10 rounded-xl {{ $kpis['simple_net_profit_today'] >= 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }} flex items-center justify-center text-xl">
                    ⚖️
                </div>
            </div>
            <p class="text-[11px] text-stone-400 mt-2 font-medium">Omset Kasir POS - Pengeluaran</p>
        </div>

        <!-- 5. TOTAL PRODUK -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-200 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold text-stone-500 uppercase tracking-wider">Total Menu &amp; Produk</span>
                    <h3 class="text-2xl font-black text-sky-700 mt-1">{{ $kpis['total_products'] }} Item</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-xl">
                    🍗
                </div>
            </div>
            <p class="text-[11px] text-stone-400 mt-2 font-medium">Menu aktif di kasir &amp; katalog online</p>
        </div>

        <!-- 6. PERINGATAN STOK MENIPIS -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-200 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold text-stone-500 uppercase tracking-wider">Peringatan Stok Rendah</span>
                    <h3 class="text-2xl font-black {{ $kpis['low_stock_count'] > 0 ? 'text-amber-600' : 'text-emerald-600' }} mt-1">
                        {{ $kpis['low_stock_count'] }} Item
                    </h3>
                </div>
                <div class="w-10 h-10 rounded-xl {{ $kpis['low_stock_count'] > 0 ? 'bg-amber-50 text-amber-600' : 'bg-emerald-50 text-emerald-600' }} flex items-center justify-center text-xl">
                    ⚠️
                </div>
            </div>
            <p class="text-[11px] text-stone-400 mt-2 font-medium">Produk dengan stok &le; 10 porsi</p>
        </div>
    </div>

    {{-- SIDE-BY-SIDE TABLES: LOW STOCK PRODUCTS & LATEST TRANSACTIONS --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- LOW STOCK PRODUCTS -->
        <div class="bg-white rounded-2xl shadow-sm border border-stone-200 overflow-hidden">
            <div class="p-4 border-b border-stone-200 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-lg">📦</span>
                    <h4 class="font-bold text-stone-900 text-sm">Status Stok Produk (Perhatian)</h4>
                </div>
                <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-[#C1440E] hover:underline">
                    Lihat Semua Produk →
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-stone-50 text-stone-600 font-bold border-b border-stone-200 uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="py-2.5 px-4">Nama Produk</th>
                            <th class="py-2.5 px-4">Harga</th>
                            <th class="py-2.5 px-4 text-center">Stok</th>
                            <th class="py-2.5 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse($lowStockProducts as $prod)
                            <tr class="hover:bg-stone-50 transition">
                                <td class="py-3 px-4">
                                    <div class="font-bold text-stone-900">{{ $prod->name }}</div>
                                    <div class="text-[11px] text-stone-400">{{ $prod->category->name ?? 'Kategori Umum' }}</div>
                                </td>
                                <td class="py-3 px-4 font-mono text-stone-800">
                                    Rp {{ number_format($prod->price, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="px-2 py-0.5 rounded text-[11px] font-bold {{ $prod->stock <= 5 ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800' }}">
                                        {{ $prod->stock }} {{ $prod->unit ?? 'pcs' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <a href="{{ route('admin.products.edit', $prod->id) }}" class="text-indigo-600 hover:text-indigo-800 font-bold text-xs">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-stone-400 text-xs">
                                    Semua stok produk dalam kondisi aman (&gt; 10 porsi).
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
