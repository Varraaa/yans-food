@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    {{-- HEADER CONTROLS: PERIOD, FILTERS, EXPORT --}}
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-200 space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            {{-- PERIOD SHORTCUTS --}}
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 text-xs">
                @foreach([
                    'today' => 'Hari Ini',
                    'this_week' => 'Minggu Ini',
                    'this_month' => 'Bulan Ini',
                    'this_year' => 'Tahun Ini',
                    'all' => 'Semua Waktu',
                    'custom' => 'Custom Tanggal'
                ] as $key => $label)
                    <a 
                        href="{{ route('admin.catering.income.index', array_merge(request()->query(), ['period' => $key])) }}"
                        class="px-3.5 py-2 rounded-xl font-bold whitespace-nowrap transition {{ $period === $key ? 'bg-[#C1440E] text-white shadow-sm' : 'bg-stone-100 text-stone-700 hover:bg-stone-200' }}"
                    >
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            {{-- ACTION: EXPORT CSV --}}
            <a 
                href="{{ route('admin.catering.income.export', request()->query()) }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs shadow-sm transition active:scale-[0.98]"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Download Laporan (CSV)</span>
            </a>
        </div>

        {{-- SUB-FILTERS: TIPE PEMBAYARAN, METODE, & CUSTOM DATES --}}
        <form action="{{ route('admin.catering.income.index') }}" method="GET" class="pt-3 border-t border-stone-100 flex flex-wrap items-center gap-4 text-xs">
            <input type="hidden" name="period" value="{{ $period }}">

            <div class="flex items-center gap-2">
                <span class="text-stone-500 font-semibold">Tipe:</span>
                <select name="payment_type" onchange="this.form.submit()" class="py-1.5 px-3 rounded-lg border border-stone-300 bg-stone-50 text-xs font-medium text-stone-800 focus:ring-1 focus:ring-[#C1440E]">
                    <option value="all">Semua Tipe (DP & Pelunasan)</option>
                    <option value="DP" {{ $paymentType === 'DP' ? 'selected' : '' }}>Hanya Uang Muka (DP)</option>
                    <option value="PELUNASAN" {{ $paymentType === 'PELUNASAN' ? 'selected' : '' }}>Hanya Pelunasan</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <span class="text-stone-500 font-semibold">Metode:</span>
                <select name="payment_method" onchange="this.form.submit()" class="py-1.5 px-3 rounded-lg border border-stone-300 bg-stone-50 text-xs font-medium text-stone-800 focus:ring-1 focus:ring-[#C1440E]">
                    <option value="all">Semua Metode Pembayaran</option>
                    <option value="CASH" {{ $paymentMethod === 'CASH' ? 'selected' : '' }}>Tunai (Cash)</option>
                    <option value="TRANSFER" {{ $paymentMethod === 'TRANSFER' ? 'selected' : '' }}>Transfer Bank</option>
                    <option value="QRIS" {{ $paymentMethod === 'QRIS' ? 'selected' : '' }}>QRIS</option>
                </select>
            </div>

            @if($period === 'custom')
                <div class="flex items-center gap-2">
                    <span class="text-stone-500 font-semibold">Rentang:</span>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="py-1.5 px-3 rounded-lg border border-stone-300 bg-white text-xs text-stone-800">
                    <span class="text-stone-400">s/d</span>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="py-1.5 px-3 rounded-lg border border-stone-300 bg-white text-xs text-stone-800">
                    <button type="submit" class="px-3 py-1.5 bg-stone-800 text-white font-bold rounded-lg text-xs">Terapkan</button>
                </div>
            @endif
        </form>
    </div>

    {{-- 4 RICH SUMMARY KPI CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- TOTAL INCOME --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-[#C1440E] to-amber-600 text-white p-5 rounded-2xl shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <span class="text-[11px] uppercase tracking-wider font-bold opacity-80">Total Kas Masuk</span>
                    <h3 class="text-2xl font-black mt-1">Rp {{ number_format($summary['total_income'] ?? 0, 0, ',', '.') }}</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-xs flex items-center justify-center text-xl">
                    💰
                </div>
            </div>
            <p class="text-[11px] opacity-80 mt-2 font-medium">Realisasi dana tunai & transfer masuk</p>
        </div>

        {{-- DP INCOME --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-sky-600 to-blue-700 text-white p-5 rounded-2xl shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <span class="text-[11px] uppercase tracking-wider font-bold opacity-80">Uang Muka (DP)</span>
                    <h3 class="text-2xl font-black mt-1">Rp {{ number_format($summary['dp_income'] ?? 0, 0, ',', '.') }}</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-xs flex items-center justify-center text-xl">
                    📥
                </div>
            </div>
            <p class="text-[11px] opacity-80 mt-2 font-medium">Dana tanda jadi / booking katering</p>
        </div>

        {{-- PELUNASAN INCOME --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-emerald-600 to-teal-700 text-white p-5 rounded-2xl shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <span class="text-[11px] uppercase tracking-wider font-bold opacity-80">Pelunasan Masuk</span>
                    <h3 class="text-2xl font-black mt-1">Rp {{ number_format($summary['pelunasan_income'] ?? 0, 0, ',', '.') }}</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-xs flex items-center justify-center text-xl">
                    ✅
                </div>
            </div>
            <p class="text-[11px] opacity-80 mt-2 font-medium">Pelunasan akhir sebelum / saat acara</p>
        </div>

        {{-- PAYMENT COUNT --}}
        <div class="bg-white border border-stone-200 p-5 rounded-2xl shadow-sm flex flex-col justify-between">
            <div class="flex justify-between items-start">
                <div>
                    <span class="text-[11px] uppercase tracking-wider font-bold text-stone-500">Kwitansi Masuk</span>
                    <h3 class="text-2xl font-black text-stone-900 mt-1">{{ number_format($summary['payment_count'] ?? 0) }} kali</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-stone-100 flex items-center justify-center text-xl">
                    🧾
                </div>
            </div>
            <p class="text-[11px] text-stone-400 mt-2 font-medium">Dari {{ number_format($summary['orders_count'] ?? 0) }} pesanan acara</p>
        </div>
    </div>

    {{-- DETAILED PAYMENTS TABLE --}}
    <div class="bg-white rounded-2xl shadow-sm border border-stone-200 overflow-hidden">
        <div class="p-5 border-b border-stone-200 flex items-center justify-between">
            <div>
                <h4 class="font-bold text-stone-900 text-sm">Rincian Riwayat Penerimaan Pembayaran</h4>
                <p class="text-xs text-stone-500 mt-0.5">Daftar seluruh kwitansi pembayaran masuk yang telah diverifikasi</p>
            </div>
            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-stone-100 text-stone-600">
                {{ count($payments) }} Catatan Kwitansi
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-stone-50 text-stone-600 font-bold border-b border-stone-200 uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3 px-4">Tgl. Bayar</th>
                        <th class="py-3 px-4">No. Kwitansi</th>
                        <th class="py-3 px-4">No. Order</th>
                        <th class="py-3 px-4">Pelanggan & WA</th>
                        <th class="py-3 px-4 text-center">Tipe Bayar</th>
                        <th class="py-3 px-4 text-center">Metode</th>
                        <th class="py-3 px-4 text-right">Nominal Masuk</th>
                        <th class="py-3 px-4">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-amber-50/30 transition">
                            <td class="py-3.5 px-4 font-mono font-medium text-stone-600">
                                {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}
                            </td>
                            <td class="py-3.5 px-4 font-mono font-bold text-stone-900">
                                {{ $payment->payment_number }}
                            </td>
                            <td class="py-3.5 px-4">
                                <a href="{{ route('admin.catering.orders.show', $payment->catering_order_id) }}" class="px-2.5 py-1 rounded-md bg-stone-100 font-mono text-[11px] font-semibold text-stone-700 hover:bg-stone-200 transition">
                                    {{ $payment->order?->order_number ?? '-' }}
                                </a>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-stone-900">
                                    {{ $payment->order?->customer_name ?? '-' }}
                                </div>
                                @if($payment->order?->customer_phone)
                                    @php
                                        $waNumber = preg_replace('/[^0-9]/', '', $payment->order->customer_phone);
                                        if (str_starts_with($waNumber, '0')) $waNumber = '62' . substr($waNumber, 1);
                                    @endphp
                                    <a 
                                        href="https://wa.me/{{ $waNumber }}?text=Halo%20{{ urlencode($payment->order->customer_name) }},%20kami%20dari%20Yan's%20Food%20telah%20menerima%20pembayaran%20{{ $payment->payment_type }}%20sebesar%20Rp%20{{ number_format($payment->amount, 0, ',', '.') }}%20(Kwitansi%20{{ $payment->payment_number }})." 
                                        target="_blank" 
                                        class="inline-flex items-center gap-1 text-[11px] text-emerald-600 hover:text-emerald-700 font-medium mt-0.5"
                                    >
                                        <span>💬 {{ $payment->order->customer_phone }}</span>
                                    </a>
                                @endif
                            </td>
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
                            <td class="py-3.5 px-4 text-right font-black text-sm text-[#C1440E]">
                                Rp {{ number_format($payment->amount, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-4 text-stone-500 max-w-xs truncate">
                                {{ $payment->notes ?: '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-stone-400">
                                <div class="text-3xl mb-1">📭</div>
                                Tidak ada catatan kwitansi pembayaran pada kriteria ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
