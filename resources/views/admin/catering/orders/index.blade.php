@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-200 space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-stone-900 flex items-center gap-2">
                    <span>🍱</span>
                    <span>Daftar Pesanan Catering</span>
                </h1>
                <p class="text-xs text-stone-500 mt-0.5">Pesanan masuk otomatis dari form pemesanan katering website publik.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.catering.income.index') }}" class="px-3.5 py-2 bg-stone-100 hover:bg-stone-200 text-stone-800 rounded-xl font-bold text-xs transition">
                    📈 Rekap Penghasilan
                </a>
                <a href="{{ route('admin.catering.payments.create') }}" class="px-3.5 py-2 bg-[#C1440E] hover:bg-[#a3380b] text-white rounded-xl font-bold text-xs shadow-sm transition">
                    + Catat Pembayaran
                </a>
            </div>
        </div>

        {{-- FILTER FORM --}}
        <form action="{{ route('admin.catering.orders.index') }}" method="GET" class="pt-3 border-t border-stone-100 flex flex-wrap items-center gap-3 text-xs">
            <div class="flex-1 min-w-[200px]">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari nomor order, nama, atau no WA..." 
                    class="w-full px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]"
                >
            </div>

            <div>
                <select name="status" class="px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                    <option value="all">Semua Status Progres</option>
                    <option value="PENDING" {{ request('status') === 'PENDING' ? 'selected' : '' }}>PENDING (Menunggu)</option>
                    <option value="CONFIRMED" {{ request('status') === 'CONFIRMED' ? 'selected' : '' }}>CONFIRMED (Dikonfirmasi)</option>
                    <option value="IN_PROGRESS" {{ request('status') === 'IN_PROGRESS' ? 'selected' : '' }}>IN_PROGRESS (Dimasak)</option>
                    <option value="READY" {{ request('status') === 'READY' ? 'selected' : '' }}>READY (Siap)</option>
                    <option value="DELIVERING" {{ request('status') === 'DELIVERING' ? 'selected' : '' }}>DELIVERING (Dikirim)</option>
                    <option value="COMPLETED" {{ request('status') === 'COMPLETED' ? 'selected' : '' }}>COMPLETED (Selesai)</option>
                    <option value="CANCELLED" {{ request('status') === 'CANCELLED' ? 'selected' : '' }}>CANCELLED (Batal)</option>
                </select>
            </div>

            <div>
                <select name="payment_status" class="px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                    <option value="all">Semua Status Bayar</option>
                    <option value="UNPAID" {{ request('payment_status') === 'UNPAID' ? 'selected' : '' }}>Belum Bayar (UNPAID)</option>
                    <option value="DP" {{ request('payment_status') === 'DP' ? 'selected' : '' }}>Uang Muka (DP)</option>
                    <option value="PAID" {{ request('payment_status') === 'PAID' ? 'selected' : '' }}>Lunas (PAID)</option>
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-stone-800 text-white rounded-xl font-bold hover:bg-stone-900 transition">
                Filter
            </button>

            @if(request()->hasAny(['search', 'status', 'payment_status']))
                <a href="{{ route('admin.catering.orders.index') }}" class="px-3 py-2 text-stone-500 hover:text-stone-800 font-bold">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- ORDERS TABLE --}}
    <div class="bg-white rounded-2xl shadow-sm border border-stone-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-stone-50 text-stone-600 font-bold border-b border-stone-200 uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3 px-4">No. Order</th>
                        <th class="py-3 px-4">Pelanggan & WA</th>
                        <th class="py-3 px-4">Tgl. Acara</th>
                        <th class="py-3 px-4 text-right">Nilai Kontrak</th>
                        <th class="py-3 px-4 text-center">Status Progres</th>
                        <th class="py-3 px-4 text-center">Pembayaran</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($orders as $order)
                        <tr class="hover:bg-amber-50/30 transition">
                            <td class="py-3.5 px-4 font-mono font-bold text-stone-900">
                                {{ $order->order_number }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-stone-800">{{ $order->customer_name }}</div>
                                @if($order->customer_phone)
                                    @php
                                        $wa = preg_replace('/[^0-9]/', '', $order->customer_phone);
                                        if (str_starts_with($wa, '0')) $wa = '62' . substr($wa, 1);
                                    @endphp
                                    <a href="https://wa.me/{{ $wa }}?text=Halo%20{{ urlencode($order->customer_name) }},%20kami%20dari%20Yan's%20Food%20mengenai%20pesanan%20katering%20{{ $order->order_number }}." target="_blank" class="text-[11px] text-emerald-600 hover:text-emerald-700 font-medium">
                                        💬 {{ $order->customer_phone }}
                                    </a>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 font-mono">
                                <div class="font-bold text-stone-800">{{ \Carbon\Carbon::parse($order->event_date)->format('d M Y') }}</div>
                                <div class="text-[11px] text-stone-500">{{ $order->event_time }} WIB</div>
                            </td>
                            <td class="py-3.5 px-4 text-right font-black text-stone-900 text-sm">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <form action="{{ route('admin.catering.orders.status', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="px-2.5 py-1 rounded-lg text-[10px] font-bold border border-stone-300 bg-stone-50 cursor-pointer">
                                        @foreach(['PENDING', 'CONFIRMED', 'IN_PROGRESS', 'READY', 'DELIVERING', 'COMPLETED', 'CANCELLED'] as $st)
                                            <option value="{{ $st }}" {{ $order->status === $st ? 'selected' : '' }}>{{ $st }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase {{ $order->payment_status === 'PAID' ? 'bg-emerald-100 text-emerald-800' : ($order->payment_status === 'DP' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800') }}">
                                    {{ $order->payment_status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <a href="{{ route('admin.catering.orders.show', $order->id) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-stone-100 hover:bg-stone-200 text-stone-800 rounded-lg font-bold text-[11px] transition">
                                    <span>👁️ Detail</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-stone-400">
                                <div class="text-3xl mb-1">🍱</div>
                                Belum ada pesanan catering yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-stone-200">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
