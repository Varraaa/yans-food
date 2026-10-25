@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto py-4 px-2 sm:px-4 space-y-6">

    {{-- ALERT SUKSES --}}
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-semibold flex items-center justify-between shadow-xs print:hidden">
            <div class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-emerald-600 text-[22px]">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
            <span class="text-xs font-mono font-bold text-emerald-700">{{ $transaction->transaction_number }}</span>
        </div>
    @endif

    {{-- TOP ACTION BUTTONS BAR (PRINT:HIDDEN) --}}
    {{-- TOP ACTION BUTTONS BAR (PRINT:HIDDEN) --}}
    <div class="bg-white p-4 rounded-2xl border border-stone-200 shadow-sm print:hidden space-y-3">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 pb-3 border-b border-stone-100">
            <a href="{{ route('admin.transactions.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-stone-600 hover:text-stone-900 transition">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                <span>Riwayat Transaksi</span>
            </a>

            <!-- Status Device RPP02N (DT-58B) -->
            <div class="flex flex-wrap items-center gap-2.5">
                <span id="rpp02n-status-badge" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-stone-100 text-stone-700 border border-stone-300">
                    <span id="rpp02n-status-dot" class="w-2 h-2 rounded-full bg-stone-400"></span>
                    <span id="rpp02n-status-text">RPP02N Siap Konek</span>
                </span>
                
                <label class="flex items-center gap-1.5 text-xs text-stone-600 cursor-pointer select-none hover:text-stone-900">
                    <input type="checkbox" id="chk-auto-print" class="w-3.5 h-3.5 rounded text-[#C1440E] focus:ring-[#C1440E]">
                    <span class="font-medium text-[11px] sm:text-xs">⚡ Otomatis cetak ke RPP02N saat struk dibuka</span>
                </label>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-2">
            <div class="flex flex-wrap items-center gap-2">
                {{-- TOMBOL UTAMA CETAK KE RPP02N (BLUETOOTH) --}}
                <button 
                    type="button" 
                    id="btn-print-rpp02n"
                    onclick="printReceiptToRPP02N()" 
                    class="px-4 py-2.5 bg-[#C1440E] hover:bg-[#a3380b] text-white rounded-xl font-bold text-xs shadow-sm transition flex items-center justify-center gap-2 active:scale-95 text-center"
                    title="Koneksikan & cetak langsung ke printer kecil RPP02N lewat Bluetooth"
                >
                    <span class="material-symbols-outlined text-[18px]">bluetooth</span>
                    <span>🖨️ Cetak ke RPP02N (Bluetooth)</span>
                </button>

                {{-- TOMBOL CETAK USB --}}
                <button 
                    type="button" 
                    onclick="printReceiptUsb()" 
                    class="px-3 py-2.5 bg-stone-800 hover:bg-black text-white rounded-xl font-bold text-xs shadow-sm transition flex items-center justify-center gap-1.5 active:scale-95 text-center"
                    title="Cetak langsung menggunakan kabel data USB"
                >
                    <span class="material-symbols-outlined text-[16px]">usb</span>
                    <span>Cetak via USB</span>
                </button>
            </div>

            {{-- TOMBOL SELESAI TRANSAKSI (§9.2) --}}
            <a 
                href="{{ route('admin.pos.index') }}" 
                class="px-4 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl font-bold text-xs shadow-sm transition flex items-center justify-center gap-1.5 active:scale-95 text-center shrink-0"
            >
                <span class="material-symbols-outlined text-[18px]">point_of_sale</span>
                <span>Selesai &rarr; Kasir</span>
            </a>
        </div>
    </div>

    {{-- THERMAL RECEIPT CONTAINER (§9.1) --}}
    @php
        $is80mm = ($paperWidth ?? '58mm') === '80mm';
        $widthClass = $is80mm ? 'max-w-[340px]' : 'max-w-[280px]';
        $methodValue = $transaction->payment_method instanceof \App\Enums\PaymentMethod 
            ? $transaction->payment_method->value 
            : (string) $transaction->payment_method;
    @endphp

    <style>
        @media print {
            @page {
                size: 58mm auto;
                margin: 0;
            }
            html, body {
                width: 58mm !important;
                margin: 0 !important;
                padding: 0 !important;
                background: #ffffff !important;
            }
            nav, header, footer, aside, .print\:hidden {
                display: none !important;
            }
            #thermal-receipt-printable {
                width: 58mm !important;
                max-width: 58mm !important;
                margin: 0 !important;
                padding: 3mm 2mm !important;
                border: none !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                display: block !important;
            }
        }
    </style>

    <div class="flex justify-center">
        <div id="thermal-receipt-printable" class="receipt-thermal-paper {{ $widthClass }} w-full bg-white p-5 sm:p-6 rounded-2xl border border-stone-300 shadow-md font-mono text-xs text-stone-900 space-y-3 leading-tight select-none">
            
            {{-- RECEIPT HEADER --}}
            <div class="text-center pb-2.5 border-b border-dashed border-stone-300 space-y-1">
                <h2 class="text-base font-black tracking-wider uppercase text-stone-900">
                    {{ $receipt['header']['store_name'] ?? "YAN'S FOOD" }}
                </h2>
                <p class="text-[10px] text-stone-500 font-sans">Dapur Kuliner Rumahan & Selera Nusantara</p>
                <p class="text-[10px] text-stone-600 leading-snug">
                    {{ $receipt['header']['address'] ?? 'Bandung, Kp. Ciloa, RT.04/RW.10, Kec. Soreang' }}
                </p>
                <p class="text-[10px] text-stone-500">WA: {{ $receipt['header']['phone'] ?? '082221222936' }}</p>
            </div>

            {{-- META INFO --}}
            <div class="py-2 border-b border-dashed border-stone-300 text-[11px] space-y-1">
                <div class="flex justify-between">
                    <span class="text-stone-500">No:</span>
                    <span class="font-bold">{{ $transaction->transaction_number }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-stone-500">Waktu:</span>
                    <span>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d/m/Y') }} {{ substr($transaction->transaction_time, 0, 5) }} WIB</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-stone-500">Pelanggan:</span>
                    <span class="font-bold text-stone-900">{{ $transaction->customer_name ?: 'Pelanggan' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-stone-500">Kasir:</span>
                    <span>{{ $transaction->cashier?->name ?? 'Kasir Utama' }}</span>
                </div>
            </div>

            {{-- ITEMS LIST --}}
            <div class="py-2 border-b border-dashed border-stone-300 space-y-2 text-[11px]">
                @foreach($transaction->items as $item)
                    <div>
                        <div class="font-bold text-stone-900 leading-snug">{{ $item->product_name }}</div>
                        <div class="flex justify-between text-stone-600 pl-2 mt-0.5">
                            <span>{{ $item->quantity }} x {{ number_format($item->unit_price, 0, ',', '.') }}</span>
                            <span class="font-semibold text-stone-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- BILLING SUMMARY --}}
            <div class="py-2 border-b border-dashed border-stone-300 space-y-1.5 text-[11px]">
                <div class="flex justify-between text-stone-600">
                    <span>Subtotal:</span>
                    <span>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
                </div>
                @if($transaction->discount > 0)
                    <div class="flex justify-between text-emerald-700">
                        <span>Diskon:</span>
                        <span>- Rp {{ number_format($transaction->discount, 0, ',', '.') }}</span>
                    </div>
                @endif
                <div class="flex justify-between text-sm font-black text-stone-900 pt-1 border-t border-dotted border-stone-200">
                    <span>TOTAL:</span>
                    <span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- PAYMENT BLOCK (§9.1) --}}
            <div class="py-2 border-b border-dashed border-stone-300 space-y-1 text-[11px]">
                <div class="flex justify-between items-center font-bold">
                    <span class="text-stone-500">Metode Bayar:</span>
                    @if($methodValue === 'QRIS')
                        <span class="px-2 py-0.5 rounded bg-sky-100 text-sky-800 text-[10px] font-black">QRIS</span>
                    @else
                        <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 text-[10px] font-black">CASH (TUNAI)</span>
                    @endif
                </div>

                @if($methodValue === 'QRIS')
                    <div class="flex justify-between text-stone-800 font-bold pt-0.5">
                        <span>Dibayar via QRIS:</span>
                        <span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                    </div>
                @else
                    <div class="flex justify-between text-stone-600">
                        <span>Uang Tunai:</span>
                        <span>Rp {{ number_format($transaction->amount_paid, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-stone-900 font-bold">
                        <span>Kembalian:</span>
                        <span>Rp {{ number_format($transaction->change, 0, ',', '.') }}</span>
                    </div>
                @endif
            </div>

            {{-- FOOTER MESSAGE --}}
            <div class="text-center pt-2 space-y-1 text-[10px] text-stone-500">
                <p class="font-bold text-stone-700">Terima kasih atas kunjungan Anda!</p>
                <p>Sajian Rumahan Penuh Kehangatan</p>
                <p class="font-mono text-[9px] text-stone-400 pt-1">Simpan struk ini sebagai bukti pembayaran yang sah.</p>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    const receiptData = @json($receipt);

    async function printReceiptToRPP02N() {
        const btn = document.getElementById('btn-print-rpp02n');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = `<span class="material-symbols-outlined text-[18px] animate-spin">refresh</span><span>Menghubungkan ke RPP02N...</span>`;
        }

        try {
            if (window.RPP02N) {
                await window.RPP02N.print(receiptData);
            } else {
                alert('Modul printer belum siap atau browser tidak mendukung Web Bluetooth.');
            }
        } catch (e) {
            console.error(e);
        } finally {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = `<span class="material-symbols-outlined text-[18px]">bluetooth</span><span>🖨️ Cetak ke RPP02N (Bluetooth)</span>`;
            }
        }
    }

    async function printReceiptUsb() {
        if (window.RPP02N && navigator.serial) {
            await window.RPP02N.printUsb(receiptData);
        } else {
            alert('Fitur Web Serial USB didukung pada Google Chrome / Edge Desktop. Pastikan printer terhubung kabel USB.');
        }
    }

    // Auto print hook when receipt page is loaded
    document.addEventListener('DOMContentLoaded', function () {
        const autoChk = document.getElementById('chk-auto-print');
        if (autoChk) {
            autoChk.checked = localStorage.getItem('rpp02n_auto_print') === 'true';
            autoChk.addEventListener('change', function () {
                localStorage.setItem('rpp02n_auto_print', this.checked ? 'true' : 'false');
                if (this.checked) {
                    window.RPP02N?.showToast('Otomatis cetak aktif. Setiap struk dibuka akan otomatis dikirim ke RPP02N.', 'info', 3000);
                }
            });

            // If auto-print enabled, automatically initiate print to RPP02N after brief DOM ready
            if (autoChk.checked) {
                setTimeout(() => {
                    printReceiptToRPP02N();
                }, 700);
            }
        }
    });
</script>
@endpush
@endsection
