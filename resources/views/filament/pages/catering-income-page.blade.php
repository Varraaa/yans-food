<x-filament-panels::page>
    <div class="space-y-6">
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
                        class="px-3.5 py-2 rounded-xl font-semibold transition {{ $period === $key ? 'bg-[#C1440E] text-white shadow-sm' : 'bg-stone-100 dark:bg-stone-800 text-stone-700 dark:text-stone-300 hover:bg-stone-200 dark:hover:bg-stone-700' }}"
                    >
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            @if($period === 'custom')
                <div class="flex items-center gap-2 text-xs">
                    <input type="date" wire:model.live="startDate" class="py-1.5 px-3 rounded-lg border border-stone-300 dark:border-stone-700 bg-white dark:bg-stone-800 text-xs text-stone-800 dark:text-stone-200">
                    <span class="text-stone-500">s/d</span>
                    <input type="date" wire:model.live="endDate" class="py-1.5 px-3 rounded-lg border border-stone-300 dark:border-stone-700 bg-white dark:bg-stone-800 text-xs text-stone-800 dark:text-stone-200">
                </div>
            @endif
        </div>

        {{-- SUMMARY KPI CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gradient-to-br from-amber-500 to-[#C1440E] text-white p-5 rounded-2xl shadow-sm">
                <span class="text-xs uppercase tracking-wider font-semibold opacity-90">Total Uang Diterima</span>
                <h3 class="text-2xl font-black mt-1">Rp {{ number_format($summary['total_income'] ?? 0, 0, ',', '.') }}</h3>
                <p class="text-[11px] opacity-80 mt-1">Realisasi dana kas dari DP & Pelunasan catering</p>
            </div>

            <div class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 p-5 rounded-2xl shadow-sm">
                <span class="text-xs uppercase tracking-wider font-semibold text-stone-500">Jumlah Transaksi Bayar</span>
                <h3 class="text-2xl font-black text-stone-900 dark:text-stone-100 mt-1">{{ number_format($summary['payment_count'] ?? 0) }} kali</h3>
                <p class="text-[11px] text-stone-400 mt-1">Penerimaan pembayaran tercatat</p>
            </div>

            <div class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 p-5 rounded-2xl shadow-sm">
                <span class="text-xs uppercase tracking-wider font-semibold text-stone-500">Order Terkait</span>
                <h3 class="text-2xl font-black text-stone-900 dark:text-stone-100 mt-1">{{ number_format($summary['orders_count'] ?? 0) }} pesanan</h3>
                <p class="text-[11px] text-stone-400 mt-1">Jumlah acara/order yang melakukan pembayaran</p>
            </div>
        </div>

        {{-- RINCIAN TABEL PEMBAYARAN --}}
        <div class="bg-white dark:bg-stone-900 rounded-2xl shadow-sm border border-stone-200 dark:border-stone-800 overflow-hidden">
            <div class="p-4 border-b border-stone-200 dark:border-stone-800 flex justify-between items-center">
                <h4 class="font-bold text-stone-900 dark:text-stone-100 text-sm">Rincian Riwayat Penerimaan Pembayaran</h4>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-stone-50 dark:bg-stone-800/50 text-stone-600 dark:text-stone-400 font-semibold border-b border-stone-200 dark:border-stone-800">
                        <tr>
                            <th class="py-3 px-4">Tgl. Bayar</th>
                            <th class="py-3 px-4">No. Kwitansi</th>
                            <th class="py-3 px-4">No. Order</th>
                            <th class="py-3 px-4">Nama Pelanggan</th>
                            <th class="py-3 px-4">Jenis Pembayaran</th>
                            <th class="py-3 px-4">Metode</th>
                            <th class="py-3 px-4 text-right">Nominal Uang</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 dark:divide-stone-800">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-stone-50/50 dark:hover:bg-stone-800/40">
                                <td class="py-3 px-4 font-mono">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                                <td class="py-3 px-4 font-semibold text-stone-800 dark:text-stone-200">{{ $payment->payment_number }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-0.5 rounded bg-stone-100 dark:bg-stone-800 font-mono text-[11px] text-stone-700 dark:text-stone-300">
                                        {{ $payment->order?->order_number ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 font-medium">{{ $payment->order?->customer_name ?? '-' }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $payment->payment_type === 'PELUNASAN' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                        {{ $payment->payment_type }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-stone-600 dark:text-stone-400">{{ $payment->payment_method }}</td>
                                <td class="py-3 px-4 text-right font-bold text-stone-900 dark:text-stone-100">
                                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-stone-400 text-xs">
                                    Tidak ada catatan pembayaran pada periode yang dipilih.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-filament-panels::page>
