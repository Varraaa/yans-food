@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-200 space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-stone-900 flex items-center gap-2">
                    <span>💳</span>
                    <span>Riwayat Kwitansi Pembayaran Catering</span>
                </h1>
                <p class="text-xs text-stone-500 mt-0.5">Daftar transaksi penerimaan uang muka (DP) dan pelunasan katering.</p>
            </div>
            <a href="{{ route('admin.catering.payments.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#C1440E] hover:bg-[#a3380b] text-white rounded-xl font-bold text-xs shadow-sm transition">
                <span>+ Catat Pembayaran Baru</span>
            </a>
        </div>

        <form action="{{ route('admin.catering.payments.index') }}" method="GET" class="pt-3 border-t border-stone-100 flex flex-wrap items-center gap-3 text-xs">
            <div class="flex-1 min-w-[200px]">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari no kwitansi, no order, nama..." 
                    class="w-full px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]"
                >
            </div>

            <div>
                <select name="payment_type" class="px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                    <option value="all">Semua Tipe</option>
                    <option value="DP" {{ request('payment_type') === 'DP' ? 'selected' : '' }}>Uang Muka (DP)</option>
                    <option value="PELUNASAN" {{ request('payment_type') === 'PELUNASAN' ? 'selected' : '' }}>Pelunasan</option>
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-stone-800 text-white rounded-xl font-bold hover:bg-stone-900 transition">
                Filter
            </button>
        </form>
    </div>

    {{-- PAYMENTS TABLE --}}
    <div class="bg-white rounded-2xl shadow-sm border border-stone-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-stone-50 text-stone-600 font-bold border-b border-stone-200 uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3 px-4">No. Kwitansi</th>
                        <th class="py-3 px-4">Tgl. Bayar</th>
                        <th class="py-3 px-4">No. Order</th>
                        <th class="py-3 px-4">Pelanggan</th>
                        <th class="py-3 px-4 text-center">Tipe</th>
                        <th class="py-3 px-4 text-center">Metode</th>
                        <th class="py-3 px-4 text-right">Nominal Masuk</th>
                        <th class="py-3 px-4">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-amber-50/30 transition">
                            <td class="py-3.5 px-4 font-mono font-bold text-stone-900">{{ $payment->payment_number }}</td>
                            <td class="py-3.5 px-4 font-mono text-stone-600">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                            <td class="py-3.5 px-4">
                                <a href="{{ route('admin.catering.orders.show', $payment->catering_order_id) }}" class="font-mono font-bold text-[#C1440E] hover:underline">
                                    {{ $payment->order?->order_number ?? '-' }}
                                </a>
                            </td>
                            <td class="py-3.5 px-4 font-medium text-stone-800">{{ $payment->order?->customer_name ?? '-' }}</td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase {{ $payment->payment_type === 'PELUNASAN' ? 'bg-emerald-100 text-emerald-800' : 'bg-sky-100 text-sky-800' }}">
                                    {{ $payment->payment_type }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="px-2 py-0.5 rounded font-bold text-[10px] bg-stone-100 text-stone-700">
                                    {{ $payment->payment_method }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right font-black text-sm text-stone-900">
                                Rp {{ number_format($payment->amount, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-4 text-stone-500 max-w-xs truncate">{{ $payment->notes ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-stone-400">
                                <div class="text-3xl mb-1">💳</div>
                                Tidak ada catatan kwitansi pembayaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-stone-200">
            {{ $payments->links() }}
        </div>
    </div>
</div>
@endsection
