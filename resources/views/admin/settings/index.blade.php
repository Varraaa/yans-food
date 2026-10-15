@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-stone-200 space-y-6">
        <div>
            <span class="text-[10px] font-bold text-[#C1440E] uppercase tracking-wider">Sistem & Konfigurasi</span>
            <h1 class="text-xl font-bold text-stone-900 mt-0.5">Pengaturan Informasi Usaha & Link Platform</h1>
            <p class="text-xs text-stone-500 mt-1">
                Kelola tautan pemesanan pesan-antar (ShopeeFood, GoFood, GrabFood) dan profil kontak Yan's Food.
            </p>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-5 text-xs">
            @csrf
            @method('PUT')

            {{-- PROFIL USAHA --}}
            <div class="space-y-4">
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
                        <input type="text" name="store_phone" value="{{ old('store_phone', $settings['store_phone'] ?? '081234567890') }}" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="block font-bold text-stone-700 uppercase tracking-wider">Alamat Dapur / Lokasi *</label>
                    <input type="text" name="store_address" value="{{ old('store_address', $settings['store_address'] ?? '') }}" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                </div>

                <div class="space-y-1">
                    <label class="block font-bold text-stone-700 uppercase tracking-wider">Jam Operasional *</label>
                    <input type="text" name="operational_hours" value="{{ old('operational_hours', $settings['operational_hours'] ?? 'Senin - Sabtu: 08:00 - 20:00 WIB') }}" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
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
                <button type="submit" class="px-5 py-2.5 bg-[#C1440E] hover:bg-[#a3380b] text-white font-bold rounded-xl shadow-sm transition">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
