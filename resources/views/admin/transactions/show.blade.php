@extends('layouts.admin')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    {{-- BACK & ACTIONS --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <a href="{{ route('admin.transactions.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-stone-600 hover:text-stone-900 transition">
            <span>← Kembali ke Riwayat Transaksi</span>
        </a>
        <button type="button" onclick="window.print()" class="px-4 py-2 bg-stone-900 hover:bg-black text-white rounded-xl font-bold text-xs shadow-sm transition flex items-center justify-center gap-1.5 w-full sm:w-auto">
            <span>🖨️ Cetak Struk Ulang</span>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
        {{-- DETAILS CARD --}}
        <div class="md:col-span-7 bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-stone-200 space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-stone-200">
                <div>
                    <span class="text-[10px] font-bold text-stone-400 uppercase tracking-wider">Nomor Struk</span>
                    <h2 class="text-xl font-mono font-black text-stone-900">{{ $transaction->transaction_number }}</h2>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-black uppercase {{ $transaction->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                    {{ $transaction->status === 'completed' ? 'Selesai' : 'Dibatalkan' }}
                </span>
            </div>

            {{-- META INFO --}}
            <div class="grid grid-cols-2 gap-4 text-xs">
                <div>
                    <span class="text-stone-400">Tanggal Transaksi:</span>
                    <div class="font-bold text-stone-800 font-mono mt-0.5">{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y') }}</div>
                </div>
                <div>
                    <span class="text-stone-400">Jam Transaksi:</span>
                    <div class="font-bold text-stone-800 font-mono mt-0.5">{{ $transaction->transaction_time }} WIB</div>
                </div>
                <div>
                    <span class="text-stone-400">Nama Pelanggan:</span>
                    <div class="font-bold text-stone-900 mt-0.5">{{ $transaction->customer_name ?: '-' }}</div>
                </div>
                <div>
                    <span class="text-stone-400">Kasir Bertugas:</span>
                    <div class="font-bold text-stone-800 mt-0.5">{{ $transaction->cashier?->name ?? 'Kasir' }}</div>
                </div>
                <div>
                    <span class="text-stone-400">Metode Bayar:</span>
                    <div class="mt-0.5">
                        @php
                            $methodVal = $transaction->payment_method instanceof \BackedEnum ? $transaction->payment_method->value : (string) $transaction->payment_method;
                        @endphp
                        @if(strtoupper($methodVal) === 'QRIS')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-sky-50 text-sky-700 border border-sky-200">
                                <i class="fa-solid fa-qrcode text-[10px]"></i> QRIS
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <i class="fa-solid fa-money-bill-wave text-[10px]"></i> CASH (Tunai)
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ITEMS TABLE --}}
            <div class="pt-2">
                <h4 class="text-xs font-bold text-stone-900 uppercase tracking-wider mb-2">Item Belanja</h4>
                <div class="rounded-xl border border-stone-200 overflow-x-auto">
                    <table class="w-full text-left text-xs whitespace-nowrap min-w-[340px]">
                        <thead class="bg-stone-50 text-stone-600 font-bold border-b border-stone-200">
                            <tr>
                                <th class="py-2.5 px-3">Nama Menu</th>
                                <th class="py-2.5 px-3 text-center">Qty</th>
                                <th class="py-2.5 px-3 text-right">Harga</th>
                                <th class="py-2.5 px-3 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @foreach($transaction->items as $item)
                                <tr>
                                    <td class="py-2.5 px-3 font-semibold text-stone-800">{{ $item->product_name }}</td>
                                    <td class="py-2.5 px-3 text-center font-bold">{{ $item->quantity }}</td>
                                    <td class="py-2.5 px-3 text-right text-stone-600">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                    <td class="py-2.5 px-3 text-right font-bold text-stone-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-stone-50 font-bold border-t border-stone-200">
                            <tr>
                                <td colspan="3" class="py-2 px-3 text-right text-stone-500">Subtotal:</td>
                                <td class="py-2 px-3 text-right text-stone-900">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @if($transaction->discount > 0)
                                <tr class="text-emerald-700">
                                    <td colspan="3" class="py-1 px-3 text-right">Diskon:</td>
                                    <td class="py-1 px-3 text-right">- Rp {{ number_format($transaction->discount, 0, ',', '.') }}</td>
                                </tr>
                            @endif
                            <tr class="text-sm font-black text-stone-900">
                                <td colspan="3" class="py-2.5 px-3 text-right text-[#C1440E]">TOTAL BAYAR:</td>
                                <td class="py-2.5 px-3 text-right text-[#C1440E]">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="text-xs text-stone-600">
                                <td colspan="3" class="py-1 px-3 text-right">Uang Diterima:</td>
                                <td class="py-1 px-3 text-right">Rp {{ number_format($transaction->amount_paid, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="text-xs text-stone-600">
                                <td colspan="3" class="py-1 px-3 text-right font-bold text-stone-900">Kembalian:</td>
                                <td class="py-1 px-3 text-right font-bold text-stone-900">Rp {{ number_format($transaction->change, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- RECEIPT PREVIEW (PRINTABLE) --}}
        <div class="md:col-span-5 bg-white p-6 rounded-2xl shadow-sm border border-stone-200">
            <h4 class="text-xs font-bold text-stone-400 uppercase tracking-wider mb-3 text-center">Tampilan Struk Thermal</h4>
            
            <div id="printable-receipt" class="bg-amber-50/50 p-5 rounded-xl border border-stone-200 text-stone-800 font-mono text-xs shadow-sm">
                <div class="text-center pb-3 border-b border-dashed border-stone-300">
                    <h3 class="text-base font-bold text-stone-900 tracking-wider">{{ $receipt['header']['store_name'] }}</h3>
                    <p class="text-stone-600">{{ $receipt['header']['address'] }}</p>
                    <p class="text-stone-500">WA: {{ $receipt['header']['phone'] }}</p>
                </div>

                <div class="py-2 border-b border-dashed border-stone-300 space-y-1">
                    <div class="flex justify-between">
                        <span>No: {{ $receipt['order_info']['number'] }}</span>
                        <span>Kasir: {{ $receipt['order_info']['cashier'] }}</span>
                    </div>
                    <div class="flex justify-between text-stone-500">
                        <span>Tgl: {{ $receipt['order_info']['date'] }}</span>
                        <span>Jam: {{ $receipt['order_info']['time'] }}</span>
                    </div>
                </div>

                <div class="py-3 border-b border-dashed border-stone-300 space-y-2">
                    @foreach($receipt['items'] as $it)
                        <div>
                            <div class="font-bold text-stone-900">{{ $it['name'] }}</div>
                            <div class="flex justify-between text-stone-600 pl-2">
                                <span>{{ $it['qty'] }} x Rp {{ number_format($it['price'], 0, ',', '.') }}</span>
                                <span class="font-semibold">Rp {{ number_format($it['subtotal'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="py-3 border-b border-dashed border-stone-300 space-y-1.5">
                    <div class="flex justify-between">
                        <span>Subtotal:</span>
                        <span>Rp {{ number_format($receipt['summary']['subtotal'], 0, ',', '.') }}</span>
                    </div>
                    @if($receipt['summary']['discount'] > 0)
                        <div class="flex justify-between text-emerald-600">
                            <span>Diskon:</span>
                            <span>- Rp {{ number_format($receipt['summary']['discount'], 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between font-bold text-sm text-stone-900 pt-1 border-t border-dotted border-stone-300">
                        <span>TOTAL:</span>
                        <span>Rp {{ number_format($receipt['summary']['total'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between pt-1">
                        <span>Bayar ({{ $receipt['payment']['method'] }}):</span>
                        <span>Rp {{ number_format($receipt['payment']['paid'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-stone-900">
                        <span>Kembalian:</span>
                        <span>Rp {{ number_format($receipt['payment']['change'], 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="text-center pt-4 text-stone-500 space-y-1">
                    <p>{{ $receipt['footer']['message'] }}</p>
                    <p class="text-[10px]">{{ $receipt['footer']['sub_message'] }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
