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

        <div class="p-4 bg-amber-50/70 border border-amber-200/60 rounded-xl flex items-start gap-3">
            <span class="text-lg">👑</span>
            <div class="text-xs text-amber-900">
                <strong>Status Hak Akses:</strong> Pemilik Usaha & Administrator Utama (Full Access). Tidak ada role sekunder untuk mencegah kerancuan wewenang.
            </div>
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

            <div class="space-y-1 pt-2 border-t border-stone-100">
                <label class="block font-bold text-stone-700 uppercase tracking-wider">Kata Sandi Baru (Opsional)</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah kata sandi..." class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                <p class="text-[11px] text-stone-400">Minimal 6 karakter.</p>
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
