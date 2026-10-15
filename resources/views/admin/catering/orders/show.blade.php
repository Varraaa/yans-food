@extends('layouts.admin')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.catering.orders.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-stone-600 hover:text-stone-900 transition">
            ← Kembali ke Daftar Pesanan Catering
        </a>

        @if($unpaid > 0 && $order->status !== 'CANCELLED')
            <a href="{{ route('admin.catering.payments.create', ['order_id' => $order->id]) }}" class="px-4 py-2 bg-[#C1440E] hover:bg-[#a3380b] text-white rounded-xl font-bold text-xs shadow-sm transition">
                + Catat Pembayaran (DP / Pelunasan)
            </a>
        @endif
    </div>

    {{-- MAIN ORDER SUMMARY --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-stone-200 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-stone-200">
            <div>
                <span class="text-[10px] font-bold text-stone-400 uppercase tracking-wider">Nomor Pesanan</span>
                <h1 class="text-2xl font-mono font-black text-stone-900">{{ $order->order_number }}</h1>
            </div>

            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full text-xs font-black uppercase {{ $order->payment_status === 'PAID' ? 'bg-emerald-100 text-emerald-800' : ($order->payment_status === 'DP' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800') }}">
                    Bayar: {{ $order->payment_status }}
                </span>

                <form action="{{ route('admin.catering.orders.status', $order->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <select name="status" onchange="this.form.submit()" class="px-3 py-1 rounded-full text-xs font-bold border border-stone-300 bg-stone-50 cursor-pointer">
                        @foreach(['PENDING', 'CONFIRMED', 'IN_PROGRESS', 'READY', 'DELIVERING', 'COMPLETED', 'CANCELLED'] as $st)
                            <option value="{{ $st }}" {{ $order->status === $st ? 'selected' : '' }}>Progres: {{ $st }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        {{-- CUSTOMER & EVENT DETAILS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs">
            <div class="p-3 bg-stone-50 rounded-xl">
                <span class="text-stone-400 block mb-0.5">Nama Pemesan:</span>
                <div class="font-bold text-stone-900 text-sm">{{ $order->customer_name }}</div>
                @if($order->customer_phone)
                    @php
                        $wa = preg_replace('/[^0-9]/', '', $order->customer_phone);
                        if (str_starts_with($wa, '0')) $wa = '62' . substr($wa, 1);
                    @endphp
                    <a href="https://wa.me/{{ $wa }}" target="_blank" class="inline-flex items-center gap-1 text-emerald-600 font-bold mt-1">
                        <span>💬 {{ $order->customer_phone }}</span>
                    </a>
                @endif
            </div>

            <div class="p-3 bg-stone-50 rounded-xl">
                <span class="text-stone-400 block mb-0.5">Jadwal Acara:</span>
                <div class="font-bold text-stone-900 text-sm font-mono">{{ \Carbon\Carbon::parse($order->event_date)->format('d M Y') }}</div>
                <div class="text-stone-600 font-mono mt-0.5">Pukul: {{ $order->event_time }} WIB</div>
            </div>

            <div class="p-3 bg-stone-50 rounded-xl">
                <span class="text-stone-400 block mb-0.5">Keperluan Acara:</span>
                <div class="font-bold text-stone-900">{{ $order->event_purpose ?: 'Acara Keluarga / Kantor' }}</div>
            </div>

            <div class="p-3 bg-stone-50 rounded-xl">
                <span class="text-stone-400 block mb-0.5">Alamat Pengantaran:</span>
                <div class="font-medium text-stone-800">{{ $order->customer_address }}</div>
            </div>
        </div>

        @if($order->notes)
            <div class="p-3 bg-amber-50/70 border border-amber-200/60 rounded-xl text-xs text-amber-900">
                <strong>Catatan Pemesan:</strong> {{ $order->notes }}
            </div>
        @endif

        {{-- ORDER ITEMS TABLE --}}
        <div>
            <h3 class="text-xs font-bold text-stone-900 uppercase tracking-wider mb-2">Rincian Menu Katering</h3>
            <div class="rounded-xl border border-stone-200 overflow-hidden">
                <table class="w-full text-left text-xs">
                    <thead class="bg-stone-50 text-stone-600 font-bold border-b border-stone-200">
                        <tr>
                            <th class="py-2.5 px-4">Menu Makanan</th>
                            <th class="py-2.5 px-4 text-center">Porsi (Qty)</th>
                            <th class="py-2.5 px-4 text-right">Harga Satuan</th>
                            <th class="py-2.5 px-4 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="py-3 px-4 font-bold text-stone-800">{{ $item->product_name }}</td>
                                <td class="py-3 px-4 text-center font-black">{{ $item->quantity }}</td>
                                <td class="py-3 px-4 text-right text-stone-600">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                <td class="py-3 px-4 text-right font-bold text-stone-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-stone-50 font-bold border-t border-stone-200 text-xs">
                        <tr>
                            <td colspan="3" class="py-2.5 px-4 text-right text-stone-500">Nilai Kontrak Pesanan:</td>
                            <td class="py-2.5 px-4 text-right font-black text-sm text-stone-900">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="text-emerald-700">
                            <td colspan="3" class="py-2 px-4 text-right">Total Uang Sudah Masuk:</td>
                            <td class="py-2 px-4 text-right font-black text-sm">Rp {{ number_format($totalPaid, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="{{ $unpaid > 0 ? 'text-rose-700' : 'text-stone-500' }}">
                            <td colspan="3" class="py-2.5 px-4 text-right font-extrabold uppercase">Sisa Tagihan Belum Lunas:</td>
                            <td class="py-2.5 px-4 text-right font-black text-base">Rp {{ number_format($unpaid, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- PAYMENTS HISTORY TABLE --}}
        <div>
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-xs font-bold text-stone-900 uppercase tracking-wider">Riwayat Kwitansi Pembayaran</h3>
            </div>
            <div class="rounded-xl border border-stone-200 overflow-hidden">
                <table class="w-full text-left text-xs">
                    <thead class="bg-stone-50 text-stone-600 font-bold border-b border-stone-200">
                        <tr>
                            <th class="py-2 px-3">No. Kwitansi</th>
                            <th class="py-2 px-3">Tgl. Bayar</th>
                            <th class="py-2 px-3">Jenis</th>
                            <th class="py-2 px-3">Metode</th>
                            <th class="py-2 px-3 text-right">Nominal Masuk</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse($order->payments as $pay)
                            <tr>
                                <td class="py-2.5 px-3 font-mono font-bold text-stone-800">{{ $pay->payment_number }}</td>
                                <td class="py-2.5 px-3 font-mono text-stone-600">{{ \Carbon\Carbon::parse($pay->payment_date)->format('d M Y') }}</td>
                                <td class="py-2.5 px-3">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $pay->payment_type === 'PELUNASAN' ? 'bg-emerald-100 text-emerald-800' : 'bg-sky-100 text-sky-800' }}">
                                        {{ $pay->payment_type }}
                                    </span>
                                </td>
                                <td class="py-2.5 px-3 text-stone-600">{{ $pay->payment_method }}</td>
                                <td class="py-2.5 px-3 text-right font-black text-stone-900">Rp {{ number_format($pay->amount, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-stone-400">Belum ada pembayaran yang diterima untuk pesanan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
