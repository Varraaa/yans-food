@extends('layouts.admin')

@section('content')
<div class="max-w-xl mx-auto py-4 px-2 sm:px-4 space-y-6">
    <div class="bg-white rounded-3xl shadow-md border border-stone-200 overflow-hidden text-center p-6 sm:p-8 space-y-6">
        
        {{-- HEADER (§8.1) --}}
        <div class="space-y-1">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-sky-50 text-sky-700 font-bold text-xs border border-sky-200">
                <span class="material-symbols-outlined text-[16px]">qr_code_2</span>
                <span>Pembayaran QRIS</span>
            </span>
            <h1 class="text-xl sm:text-2xl font-black text-stone-900 tracking-tight">
                {{ $qrisMerchantName ?? "Yan's Food" }}
            </h1>
            <p class="text-xs text-stone-500">
                Tunjukkan layar ini kepada pelanggan untuk dipindai melalui aplikasi m-Banking atau E-Wallet.
            </p>
        </div>

        {{-- TOTAL TAGIHAN BESAR (§8.2) --}}
        <div class="p-4 sm:p-5 rounded-2xl bg-amber-50/70 border border-amber-200/80 space-y-1">
            <span class="text-xs font-bold uppercase tracking-wider text-stone-500">Total yang Harus Dibayar</span>
            <div class="text-3xl sm:text-4xl font-black text-[#C1440E] tabular-nums tracking-tight">
                Rp {{ number_format($total, 0, ',', '.') }}
            </div>
            <p class="text-[11px] text-stone-600 font-medium">
                Pastikan pelanggan memasukkan nominal sesuai total di atas saat membayar.
            </p>
        </div>

        {{-- GAMBAR QR CODE (§8.3) --}}
        @php
            $displayQrisUrl = null;
            if (!empty($qrisImagePath)) {
                if (str_starts_with($qrisImagePath, 'http')) {
                    $displayQrisUrl = $qrisImagePath;
                } elseif (file_exists(public_path($qrisImagePath))) {
                    $displayQrisUrl = asset($qrisImagePath);
                } elseif (file_exists(storage_path('app/public/' . $qrisImagePath))) {
                    $displayQrisUrl = asset('storage/' . $qrisImagePath);
                }
            }
            if (!$displayQrisUrl && file_exists(public_path('images/qris/qris-yansfood.jpeg'))) {
                $displayQrisUrl = asset('images/qris/qris-yansfood.jpeg');
            }
        @endphp

        <div class="flex flex-col items-center justify-center">
            @if($displayQrisUrl)
                <div class="p-3 sm:p-4 bg-white rounded-3xl border-2 border-stone-200 shadow-md max-w-[360px] w-full flex flex-col items-center">
                    <div class="w-full bg-stone-900 text-white py-1 px-3 rounded-xl flex items-center justify-between text-[11px] font-black uppercase tracking-wider mb-2">
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[15px] text-amber-400">qr_code_scanner</span>
                            <span>QRIS Standar Nasional</span>
                        </span>
                        <span class="text-stone-300 font-mono text-[10px]">ASLI</span>
                    </div>

                    <div class="w-full aspect-square bg-stone-50 rounded-2xl overflow-hidden flex items-center justify-center border border-stone-100 p-2">
                        <img 
                            src="{{ $displayQrisUrl }}" 
                            alt="QR Code QRIS {{ $qrisMerchantName ?? "Yan's Food" }}"
                            class="w-full h-full object-contain rounded-xl"
                            loading="eager"
                        >
                    </div>

                    <div class="mt-2 text-center text-[10px] text-stone-500 font-medium">
                        BCA • Mandiri • BRI • BNI • GoPay • OVO • Dana • ShopeePay • LinkAja
                    </div>
                </div>
            @else
                <div class="p-8 bg-stone-50 rounded-2xl border-2 border-dashed border-rose-300 max-w-[320px] w-full aspect-square flex flex-col items-center justify-center text-center space-y-2">
                    <span class="material-symbols-outlined text-rose-500 text-[40px]">warning</span>
                    <p class="text-xs font-bold text-rose-700">Gambar QRIS Belum Tersedia</p>
                    <p class="text-[11px] text-stone-500 leading-relaxed">
                        Silakan unggah QR code QRIS terlebih dahulu di menu Pengaturan.
                    </p>
                    <a href="{{ route('admin.settings.index') }}" class="mt-2 text-xs font-bold text-[#C1440E] hover:underline">
                        Buka Pengaturan &rarr;
                    </a>
                </div>
            @endif
        </div>

        {{-- TEKS BANTU ADMIN (§8.4) --}}
        <div class="p-3 rounded-xl bg-stone-50 border border-stone-200 text-[11px] text-stone-600 flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-[16px] text-amber-600 shrink-0">info</span>
            <span>Pastikan pembayaran sudah masuk di aplikasi bank / e-wallet toko sebelum menekan tombol <strong>Next</strong>.</span>
        </div>

        {{-- TOMBOL AKSI (§8.5) --}}
        <div class="pt-2 flex flex-col sm:flex-row gap-3">
            {{-- TOMBOL CANCEL / KEMBALI KE KERANJANG --}}
            <form action="{{ route('admin.pos.qris.cancel', $token) }}" method="POST" class="w-full sm:w-1/3">
                @csrf
                <button 
                    type="submit" 
                    class="w-full py-3.5 px-4 rounded-xl border border-stone-300 bg-white hover:bg-stone-50 text-stone-700 font-bold text-xs sm:text-sm transition flex items-center justify-center gap-1.5 shadow-xs"
                >
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    <span>Kembali</span>
                </button>
            </form>

            {{-- TOMBOL NEXT (KONFIRMASI PEMBAYARAN) --}}
            <form action="{{ route('admin.pos.qris.confirm', $token) }}" method="POST" class="w-full sm:w-2/3" onsubmit="handleNextSubmit(this)">
                @csrf
                <button 
                    type="submit" 
                    id="btn-confirm-next"
                    @if(empty($qrisImagePath)) disabled @endif
                    class="w-full py-3.5 px-6 rounded-xl bg-emerald-600 hover:bg-emerald-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-black text-sm sm:text-base transition flex items-center justify-center gap-2 shadow-md active:scale-98"
                >
                    <span id="btn-next-label">Next &rarr; Struk Pembayaran</span>
                    <span class="material-symbols-outlined text-[20px]">receipt_long</span>
                </button>
            </form>
        </div>

    </div>
</div>

<script>
function handleNextSubmit(form) {
    const btn = document.getElementById('btn-confirm-next');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = `<span class="inline-flex items-center gap-2">⏳ Memproses Transaksi...</span>`;
    }
}
</script>
@endsection
