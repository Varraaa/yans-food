@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-stone-200 space-y-6">
        <div>
            <span class="text-[10px] font-bold text-[#C1440E] uppercase tracking-wider">Sistem & Konfigurasi</span>
            <h1 class="text-lg sm:text-xl font-bold text-stone-900 mt-0.5">Pengaturan Informasi Usaha & Pembayaran</h1>
            <p class="text-xs text-stone-500 mt-1">
                Kelola profil kontak, tautan pemesanan delivery, serta konfigurasi QRIS pembayaran resmi Yan's Food.
            </p>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px] text-emerald-600">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                <div class="font-bold flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[18px]">error</span>
                    <span>Terdapat kesalahan pada formulir:</span>
                </div>
                <ul class="list-disc list-inside pl-1 space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6 text-xs">
            @csrf
            @method('PUT')

            {{-- PENGATURAN QRIS PEMBAYARAN (§10) --}}
            <div class="p-4 sm:p-5 rounded-2xl bg-amber-50/50 border border-amber-200/80 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-2.5">
                    <div>
                        <h3 class="font-bold text-stone-900 text-sm flex items-center gap-2">
                            <span class="w-6 h-6 rounded-lg bg-[#C1440E] text-white flex items-center justify-center text-xs">📱</span>
                            <span>QRIS Pembayaran Kasir (Statis)</span>
                        </h3>
                        <p class="text-[11px] text-stone-600 mt-0.5">
                            Gambar QR Code resmi toko yang akan ditampilkan di layar kasir untuk dipindai pelanggan saat bertransaksi.
                        </p>
                    </div>
                    @if(!empty($settings['qris_image_path']))
                        <span class="self-start px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[10px] flex items-center gap-1 shrink-0">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            <span>QRIS Aktif</span>
                        </span>
                    @else
                        <span class="self-start px-2.5 py-1 rounded-full bg-rose-100 text-rose-800 font-bold text-[10px] flex items-center gap-1 shrink-0">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span>
                            <span>Belum Ada QRIS</span>
                        </span>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-5 items-center">
                    {{-- PREVIEW GAMBAR QRIS --}}
                    <div class="md:col-span-4 flex flex-col items-center justify-center p-3 bg-white rounded-xl border border-stone-200">
                        @if(!empty($settings['qris_image_path']))
                            <div class="relative group">
                                <img src="{{ asset($settings['qris_image_path']) }}" alt="QRIS Yan's Food" class="w-36 h-36 object-contain rounded-lg p-1 border border-stone-100 bg-white">
                            </div>
                            <span class="text-[10px] text-stone-400 font-medium mt-1.5">Pratinjau QR Saat Ini</span>
                        @else
                            <div class="w-36 h-36 rounded-lg border-2 border-dashed border-stone-300 flex flex-col items-center justify-center text-stone-400 p-3 text-center">
                                <span class="material-symbols-outlined text-[32px] text-stone-300 mb-1">qr_code_2</span>
                                <span class="text-[10px] leading-tight font-medium">Belum ada file QRIS diunggah</span>
                            </div>
                            <span class="text-[10px] text-stone-400 font-medium mt-1.5">Area Pratinjau</span>
                        @endif
                    </div>

                    {{-- FORM INPUT QRIS --}}
                    <div class="md:col-span-8 space-y-3.5">
                        <div class="space-y-1">
                            <label class="block font-bold text-stone-700 uppercase tracking-wider">Nama Merchant QRIS</label>
                            <input type="text" name="qris_merchant_name" value="{{ old('qris_merchant_name', $settings['qris_merchant_name'] ?? 'Yan\'s Food') }}" placeholder="Contoh: Yan's Food" class="w-full px-3 py-2 rounded-xl border border-stone-300 bg-white text-xs focus:ring-1 focus:ring-[#C1440E]">
                            <p class="text-[10px] text-stone-500">Nama merchant yang tertera pada aplikasi pembayaran pelanggan.</p>
                        </div>

                        <div class="space-y-1">
                            <label class="block font-bold text-stone-700 uppercase tracking-wider">Unggah File Gambar QR Code Baru</label>
                            <input type="file" name="qris_image" accept="image/png,image/jpeg,image/webp" class="block w-full text-xs text-stone-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#C1440E] file:text-white hover:file:bg-[#a3380b] file:cursor-pointer border border-stone-300 rounded-xl bg-white">
                            <p class="text-[10px] text-stone-500">Format didukung: PNG, JPG, JPEG, WEBP. Ukuran maksimal 2 MB.</p>
                        </div>

                        <div class="p-2.5 rounded-lg bg-amber-100/60 border border-amber-300/50 text-[11px] text-amber-900 flex items-start gap-2">
                            <span class="material-symbols-outlined text-[16px] text-amber-700 shrink-0 mt-0.5">info</span>
                            <span>Gunakan QRIS statis resmi toko Anda. Pastikan gambar jelas dan kontras tinggi agar mudah dipindai oleh kamera HP pelanggan.</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- PROFIL USAHA --}}
            <div class="space-y-4 pt-2">
                <h3 class="font-bold text-stone-900 text-sm border-b border-stone-100 pb-2 flex items-center gap-2">
                    <span>🏠</span>
                    <span>Profil Dapur Yan's Food</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block font-bold text-stone-700 uppercase tracking-wider">Nama Usaha *</label>
                        <input type="text" name="store_name" value="{{ old('store_name', $settings['store_name'] ?? 'Yan\'s Food') }}" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                    </div>

                    <div class="space-y-1">
                        <label class="block font-bold text-stone-700 uppercase tracking-wider">Nomor WhatsApp Admin *</label>
                        <input type="text" name="store_phone" value="{{ old('store_phone', $settings['store_phone'] ?? '082221222936') }}" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="block font-bold text-stone-700 uppercase tracking-wider">Alamat Dapur / Lokasi *</label>
                    <input type="text" name="store_address" value="{{ old('store_address', $settings['store_address'] ?? '') }}" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                </div>

                <div class="space-y-1">
                    <label class="block font-bold text-stone-700 uppercase tracking-wider">Jam Operasional *</label>
                    <input type="text" name="operational_hours" value="{{ old('operational_hours', $settings['operational_hours'] ?? 'Setiap Hari: 08:00 - 22:00 WIB') }}" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                </div>
            </div>

            {{-- LINK PESAN ONLINE THIRD PARTY --}}
            <div class="space-y-4 pt-4 border-t border-stone-200">
                <h3 class="font-bold text-stone-900 text-sm border-b border-stone-100 pb-2 flex items-center gap-2">
                    <span>🛵</span>
                    <span>Tautan Pesan Online (ShopeeFood, GoFood, GrabFood)</span>
                </h3>
                <p class="text-[11px] text-stone-500">Tautan ini tampil di bagian Pesan Online dan Footer Website Publik.</p>

                <div class="space-y-3">
                    <div class="space-y-1">
                        <label class="block font-bold text-stone-700 uppercase tracking-wider flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                            <span>Link ShopeeFood Toko</span>
                        </label>
                        <input type="url" name="shopeefood_url" value="{{ old('shopeefood_url', $settings['shopeefood_url'] ?? '') }}" placeholder="https://shopee.co.id/..." class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                    </div>

                    <div class="space-y-1">
                        <label class="block font-bold text-stone-700 uppercase tracking-wider flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                            <span>Link GoFood Toko</span>
                        </label>
                        <input type="url" name="gofood_url" value="{{ old('gofood_url', $settings['gofood_url'] ?? '') }}" placeholder="https://gofood.link/..." class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                    </div>

                    <div class="space-y-1">
                        <label class="block font-bold text-stone-700 uppercase tracking-wider flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-green-500"></span>
                            <span>Link GrabFood Toko</span>
                        </label>
                        <input type="url" name="grabfood_url" value="{{ old('grabfood_url', $settings['grabfood_url'] ?? '') }}" placeholder="https://food.grab.com/..." class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                    </div>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end border-t border-stone-100">
                <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-[#C1440E] hover:bg-[#a3380b] text-white font-bold rounded-xl shadow-sm transition text-center">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
