@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-stone-200 space-y-6">
        <div>
            <span class="text-[10px] font-bold text-[#C1440E] uppercase tracking-wider">Pengelolaan Akun</span>
            <h1 class="text-xl font-bold text-stone-900 mt-0.5">Akun Admin Tunggal (Owner)</h1>
            <p class="text-xs text-stone-500 mt-1">
                Yan's Food dikelola oleh satu orang pemilik yang bertindak langsung sebagai administrator utama dengan kendali penuh atas seluruh sistem dan operasional.
            </p>
        </div>

        <form action="{{ route('admin.users.update') }}" method="POST" class="space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div class="space-y-1">
                <label class="block font-bold text-stone-700 uppercase tracking-wider">Nama Lengkap Pemilik *</label>
                <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-sm focus:ring-1 focus:ring-[#C1440E]">
            </div>

            <div class="space-y-1">
                <label class="block font-bold text-stone-700 uppercase tracking-wider">Email Login Admin *</label>
                <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-sm focus:ring-1 focus:ring-[#C1440E]">
            </div>

            <div class="space-y-1">
                <label class="block font-bold text-stone-700 uppercase tracking-wider">Peran Akun</label>
                <input type="text" disabled value="Owner & Admin Utama (Akses Penuh)" class="w-full px-3 py-2.5 rounded-xl border border-stone-200 bg-stone-100 text-stone-500 text-xs font-bold cursor-not-allowed">
            </div>

            {{-- PENGATURAN KATA SANDI & KEAMANAN AKUN --}}
            <div class="pt-4 border-t border-stone-100 space-y-4">
                <div class="p-3 bg-stone-50 rounded-xl border border-stone-200">
                    <h3 class="font-bold text-stone-900 text-xs uppercase tracking-wider flex items-center gap-1.5">
                        <span>🔒</span>
                        <span>Ubah Kata Sandi (Verifikasi Keamanan)</span>
                    </h3>
                    <p class="text-[11px] text-stone-500 mt-0.5">
                        Untuk mencegah pihak tidak berwenang mengganti kata sandi secara sengaja, Anda <strong>wajib menginput kata sandi yang sedang digunakan saat ini</strong> sebelum dapat membuat kata sandi baru.
                    </p>
                </div>

                {{-- 1. INPUT KATA SANDI SAAT INI (WAJIB DIISI SEBELUM SANDI BARU) --}}
                <div class="space-y-1">
                    <label class="block font-bold text-stone-700 uppercase tracking-wider">
                        Kata Sandi Saat Ini (Sedang Digunakan)
                    </label>
                    <input 
                        type="password" 
                        name="current_password" 
                        id="current_password"
                        autocomplete="current-password"
                        placeholder="Masukkan kata sandi yang sedang digunakan saat ini..." 
                        class="w-full px-3 py-2.5 rounded-xl border @error('current_password') border-rose-400 bg-rose-50/50 @else border-stone-300 bg-stone-50 @enderror text-xs focus:ring-1 focus:ring-[#C1440E]"
                    >
                    @error('current_password')
                        <p class="text-rose-600 text-[11px] font-medium mt-1">⚠️ {{ $message }}</p>
                    @enderror
                    <p class="text-[11px] text-stone-400">Verifikasi otentikasi wajib diisi jika ingin mengganti kata sandi.</p>
                </div>

                {{-- 2. INPUT KATA SANDI BARU & KONFIRMASI --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block font-bold text-stone-700 uppercase tracking-wider">Kata Sandi Baru</label>
                        <input 
                            type="password" 
                            name="password" 
                            id="password"
                            autocomplete="new-password"
                            placeholder="Kata sandi baru (minimal 6 karakter)..." 
                            class="w-full px-3 py-2.5 rounded-xl border @error('password') border-rose-400 bg-rose-50/50 @else border-stone-300 bg-stone-50 @enderror text-xs focus:ring-1 focus:ring-[#C1440E]"
                        >
                        @error('password')
                            <p class="text-rose-600 text-[11px] font-medium mt-1">⚠️ {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="block font-bold text-stone-700 uppercase tracking-wider">Konfirmasi Kata Sandi Baru</label>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="password_confirmation"
                            autocomplete="new-password"
                            placeholder="Ketik ulang kata sandi baru..." 
                            class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]"
                        >
                        <p class="text-[11px] text-stone-400">Pastikan sama dengan kata sandi baru.</p>
                    </div>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end border-t border-stone-100">
                <button type="submit" class="px-5 py-2.5 bg-[#C1440E] hover:bg-[#a3380b] text-white font-bold rounded-xl shadow-sm transition">
                    Simpan Perubahan Akun
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
