<x-filament-panels::page>
    <div class="space-y-6">
        {{-- TAB SWITCHER --}}
        <div class="flex items-center justify-between border-b border-stone-200 dark:border-stone-800 pb-3">
            <div class="flex items-center gap-2">
                <button 
                    type="button" 
                    wire:click="$set('activeTab', 'pos')"
                    class="px-4 py-2 rounded-xl font-bold text-sm transition {{ $activeTab === 'pos' ? 'bg-[#C1440E] text-white shadow' : 'bg-stone-100 dark:bg-stone-800 text-stone-600 dark:text-stone-300 hover:bg-stone-200' }}"
                >
                    🍔 Penjualan POS Reguler
                </button>
                <button 
                    type="button" 
                    wire:click="$set('activeTab', 'catering')"
                    class="px-4 py-2 rounded-xl font-bold text-sm transition {{ $activeTab === 'catering' ? 'bg-[#C1440E] text-white shadow' : 'bg-stone-100 dark:bg-stone-800 text-stone-600 dark:text-stone-300 hover:bg-stone-200' }}"
                >
                    🍱 Laporan Catering & Acara
                </button>
            </div>

            <button 
                type="button" 
                wire:click="exportCsv"
                class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold text-xs flex items-center gap-2 shadow-sm transition"
            >
                📥 Export CSV
            </button>
        </div>

        {{-- FILTER BAR --}}
        <div class="bg-white dark:bg-stone-900 p-4 rounded-2xl shadow-sm border border-stone-200 dark:border-stone-800 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-2 overflow-x-auto text-xs">
                @foreach([
                    'today' => 'Hari Ini',
                    'this_week' => 'Minggu Ini',
                    'this_month' => 'Bulan Ini',
                    'all' => 'Keseluruhan',
                    'custom' => 'Custom Tanggal'
                ] as $key => $label)
                    <button 
                        type="button" 
                        wire:click="$set('period', '{{ $key }}')"
                        class="px-3.5 py-2 rounded-xl font-semibold transition {{ $period === $key ? 'bg-stone-900 text-white dark:bg-stone-100 dark:text-stone-900 shadow-sm' : 'bg-stone-100 dark:bg-stone-800 text-stone-700 dark:text-stone-300 hover:bg-stone-200 dark:hover:bg-stone-700' }}"
                    >
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            <div class="flex flex-wrap items-center gap-3 text-xs">
                @if($activeTab === 'pos')
                    <div class="flex items-center gap-1.5">
                        <label class="text-stone-500 font-semibold">Filter Produk:</label>
                        <select wire:model.live="selectedProductId" class="py-1.5 px-3 rounded-lg border border-stone-300 dark:border-stone-700 bg-white dark:bg-stone-800 text-xs">
                            <option value="">Semua Produk</option>
                            @foreach($products as $prod)
                                <option value="{{ $prod->id }}">{{ $prod->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                @if($period === 'custom')
                    <div class="flex items-center gap-2">
                        <input type="date" wire:model.live="startDate" class="py-1.5 px-3 rounded-lg border border-stone-300 dark:border-stone-700 bg-white dark:bg-stone-800 text-xs text-stone-800 dark:text-stone-200">
                        <span class="text-stone-500">s/d</span>
                        <input type="date" wire:model.live="endDate" class="py-1.5 px-3 rounded-lg border border-stone-300 dark:border-stone-700 bg-white dark:bg-stone-800 text-xs text-stone-800 dark:text-stone-200">
                    </div>
                @endif
            </div>
        </div>

        @if($activeTab === 'pos')
            {{-- POS SUMMARY CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gradient-to-br from-amber-500 to-[#C1440E] text-white p-5 rounded-2xl shadow-sm">
                    <span class="text-xs uppercase tracking-wider font-semibold opacity-90">Total Pendapatan POS</span>
                    <h3 class="text-2xl font-black mt-1">Rp {{ number_format($summary['total_revenue'] ?? 0, 0, ',', '.') }}</h3>
                    <p class="text-[11px] opacity-80 mt-1">Total omset penjualan kasir pada periode ini</p>
                </div>

                <div class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 p-5 rounded-2xl shadow-sm">
                    <span class="text-xs uppercase tracking-wider font-semibold text-stone-500">Jumlah Transaksi</span>
                    <h3 class="text-2xl font-black text-stone-900 dark:text-stone-100 mt-1">{{ number_format($summary['transaction_count'] ?? 0) }} struk</h3>
                    <p class="text-[11px] text-stone-400 mt-1">Transaksi sukses diselesaikan</p>
                </div>

                <div class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 p-5 rounded-2xl shadow-sm">
                    <span class="text-xs uppercase tracking-wider font-semibold text-stone-500">Rata-Rata per Transaksi</span>
                    <h3 class="text-2xl font-black text-stone-900 dark:text-stone-100 mt-1">Rp {{ number_format($summary['average_transaction'] ?? 0, 0, ',', '.') }}</h3>
                    <p class="text-[11px] text-stone-400 mt-1">Average order value (AOV)</p>
                </div>
            </div>

            {{-- PRODUCT SALES RANKING (JIKA TANPA FILTER PRODUK TUNGGAL) --}}
            @if(empty($selectedProductId) && count($productSales) > 0)
                <div class="bg-white dark:bg-stone-900 rounded-2xl shadow-sm border border-stone-200 dark:border-stone-800 p-5 space-y-3">
                    <h4 class="font-bold text-stone-900 dark:text-stone-100 text-sm">🏆 Performa Penjualan Per Produk</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-stone-50 dark:bg-stone-800/50 text-stone-600 dark:text-stone-400 font-semibold border-b border-stone-200 dark:border-stone-800">
                                <tr>
                                    <th class="py-2.5 px-4">Nama Produk</th>
                                    <th class="py-2.5 px-4 text-center">Jumlah Terjual</th>
                                    <th class="py-2.5 px-4 text-center">Frekuensi Transaksi</th>
                                    <th class="py-2.5 px-4 text-right">Total Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-stone-100 dark:divide-stone-800">
                                @foreach($productSales as $item)
                                    <tr class="hover:bg-stone-50/50 dark:hover:bg-stone-800/40">
                                        <td class="py-2.5 px-4 font-semibold text-stone-800 dark:text-stone-200">{{ $item->product_name }}</td>
                                        <td class="py-2.5 px-4 text-center font-bold text-stone-900 dark:text-stone-100">{{ $item->total_quantity }}</td>
                                        <td class="py-2.5 px-4 text-center text-stone-600 dark:text-stone-400">{{ $item->transaction_count }} kali</td>
                                        <td class="py-2.5 px-4 text-right font-extrabold text-[#C1440E]">Rp {{ number_format($item->total_sales, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- TRANSACTIONS HISTORY TABLE --}}
            <div class="bg-white dark:bg-stone-900 rounded-2xl shadow-sm border border-stone-200 dark:border-stone-800 overflow-hidden">
                <div class="p-4 border-b border-stone-200 dark:border-stone-800">
                    <h4 class="font-bold text-stone-900 dark:text-stone-100 text-sm">Riwayat Transaksi Terkait</h4>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-stone-50 dark:bg-stone-800/50 text-stone-600 dark:text-stone-400 font-semibold border-b border-stone-200 dark:border-stone-800">
                            <tr>
                                <th class="py-3 px-4">No. Transaksi</th>
                                <th class="py-3 px-4">Tanggal & Jam</th>
                                <th class="py-3 px-4">Kasir</th>
                                <th class="py-3 px-4">Metode</th>
                                <th class="py-3 px-4 text-right">Total Transaksi</th>
                                <th class="py-3 px-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100 dark:divide-stone-800">
                            @forelse($transactions as $tx)
                                <tr class="hover:bg-stone-50/50 dark:hover:bg-stone-800/40">
                                    <td class="py-3 px-4 font-semibold text-stone-800 dark:text-stone-200">{{ $tx->transaction_number }}</td>
                                    <td class="py-3 px-4 font-mono text-stone-500">{{ \Carbon\Carbon::parse($tx->transaction_date)->format('d M Y') }} {{ $tx->transaction_time }}</td>
                                    <td class="py-3 px-4">{{ $tx->cashier?->name ?? 'Kasir' }}</td>
                                    <td class="py-3 px-4">{{ $tx->payment_method }}</td>
                                    <td class="py-3 px-4 text-right font-bold text-stone-900 dark:text-stone-100">Rp {{ number_format($tx->total, 0, ',', '.') }}</td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $tx->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                            {{ $tx->status === 'completed' ? 'Selesai' : 'Dibatalkan' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-stone-400 text-xs">
                                        Tidak ada transaksi tercatat pada periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        @else
            {{-- CATERING SUMMARY CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gradient-to-br from-indigo-600 to-purple-600 text-white p-5 rounded-2xl shadow-sm">
                    <span class="text-xs uppercase tracking-wider font-semibold opacity-90">Total Nilai Pesanan Catering</span>
                    <h3 class="text-2xl font-black mt-1">Rp {{ number_format($summary['total_order_value'] ?? 0, 0, ',', '.') }}</h3>
                    <p class="text-[11px] opacity-80 mt-1">Akumulasi kontrak/nilai order katering yang masuk</p>
                </div>

                <div class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 p-5 rounded-2xl shadow-sm">
                    <span class="text-xs uppercase tracking-wider font-semibold text-stone-500">Realisasi Dana Masuk</span>
                    <h3 class="text-2xl font-black text-emerald-600 mt-1">Rp {{ number_format($summary['total_income'] ?? 0, 0, ',', '.') }}</h3>
                    <p class="text-[11px] text-stone-400 mt-1">Dana kas nyata yang sudah dibayarkan (DP + Pelunasan)</p>
                </div>

                <div class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 p-5 rounded-2xl shadow-sm">
                    <span class="text-xs uppercase tracking-wider font-semibold text-stone-500">Jumlah Pesanan Acara</span>
                    <h3 class="text-2xl font-black text-stone-900 dark:text-stone-100 mt-1">{{ number_format($summary['order_count'] ?? 0) }} order</h3>
                    <p class="text-[11px] text-stone-400 mt-1">Total kontrak katering pada periode terpilih</p>
                </div>
            </div>

            {{-- STATUS BREAKDOWN PILLS --}}
            <div class="bg-white dark:bg-stone-900 rounded-2xl shadow-sm border border-stone-200 dark:border-stone-800 p-4">
                <h4 class="font-bold text-stone-900 dark:text-stone-100 text-xs uppercase tracking-wider mb-2">Breakdown Status Progres:</h4>
                <div class="flex flex-wrap gap-2 text-xs">
                    @foreach($statusBreakdown as $status => $count)
                        <span class="px-3 py-1 rounded-lg bg-stone-100 dark:bg-stone-800 font-semibold text-stone-700 dark:text-stone-300">
                            {{ $status }}: <strong class="text-stone-900 dark:text-stone-100">{{ $count }}</strong>
                        </span>
                    @endforeach
                </div>
            </div>

            {{-- CATERING ORDERS TABLE --}}
            <div class="bg-white dark:bg-stone-900 rounded-2xl shadow-sm border border-stone-200 dark:border-stone-800 overflow-hidden">
                <div class="p-4 border-b border-stone-200 dark:border-stone-800">
                    <h4 class="font-bold text-stone-900 dark:text-stone-100 text-sm">Rincian Order Catering</h4>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-stone-50 dark:bg-stone-800/50 text-stone-600 dark:text-stone-400 font-semibold border-b border-stone-200 dark:border-stone-800">
                            <tr>
                                <th class="py-3 px-4">No. Order</th>
                                <th class="py-3 px-4">Nama Pelanggan</th>
                                <th class="py-3 px-4">WhatsApp</th>
                                <th class="py-3 px-4">Tgl. Acara</th>
                                <th class="py-3 px-4 text-right">Nilai Kontrak</th>
                                <th class="py-3 px-4 text-center">Progres</th>
                                <th class="py-3 px-4 text-center">Status Bayar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100 dark:divide-stone-800">
                            @forelse($orders as $order)
                                <tr class="hover:bg-stone-50/50 dark:hover:bg-stone-800/40">
                                    <td class="py-3 px-4 font-semibold text-stone-800 dark:text-stone-200">{{ $order->order_number }}</td>
                                    <td class="py-3 px-4 font-medium">{{ $order->customer_name }}</td>
                                    <td class="py-3 px-4 text-stone-500">{{ $order->customer_phone }}</td>
                                    <td class="py-3 px-4 font-mono">{{ \Carbon\Carbon::parse($order->event_date)->format('d M Y') }}</td>
                                    <td class="py-3 px-4 text-right font-bold text-stone-900 dark:text-stone-100">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-stone-100 dark:bg-stone-800 text-stone-800 dark:text-stone-200">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $order->payment_status === 'PAID' ? 'bg-emerald-100 text-emerald-800' : ($order->payment_status === 'DP' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800') }}">
                                            {{ $order->payment_status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-8 text-center text-stone-400 text-xs">
                                        Tidak ada pesanan katering pada periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</x-filament-panels::page>
