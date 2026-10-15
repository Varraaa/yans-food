@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-stone-600 hover:text-stone-900 transition">
            ← Kembali ke Katalog Produk
        </a>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-stone-200 space-y-6">
        <div>
            <h1 class="text-xl font-bold text-stone-900">Tambah Produk Kuliner Baru</h1>
            <p class="text-xs text-stone-500 mt-0.5">Masukkan data menu, harga jual, stok, dan ketersediaan.</p>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
            @csrf

            <div class="space-y-1">
                <label class="block font-bold text-stone-700 uppercase tracking-wider">Nama Menu / Produk *</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-sm focus:ring-1 focus:ring-[#C1440E]" placeholder="Contoh: Nasi Box Ayam Bakar">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="block font-bold text-stone-700 uppercase tracking-wider">Kategori Menu *</label>
                    <select name="category_id" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="block font-bold text-stone-700 uppercase tracking-wider">Status Ketersediaan *</label>
                    <select name="status" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                        <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>Sedia (Bisa Dijual di POS & Publik)</option>
                        <option value="unavailable" {{ old('status') === 'unavailable' ? 'selected' : '' }}>Tidak Tersedia (Kosong)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="space-y-1">
                    <label class="block font-bold text-stone-700 uppercase tracking-wider">Harga Jual (Rp) *</label>
                    <input type="number" name="price" value="{{ old('price') }}" min="0" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs font-bold focus:ring-1 focus:ring-[#C1440E]" placeholder="15000">
                </div>

                <div class="space-y-1">
                    <label class="block font-bold text-stone-700 uppercase tracking-wider">Stok *</label>
                    <input type="number" name="stock" value="{{ old('stock', 50) }}" min="0" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                </div>

                <div class="space-y-1">
                    <label class="block font-bold text-stone-700 uppercase tracking-wider">Satuan Unit *</label>
                    <input type="text" name="unit" value="{{ old('unit', 'porsi') }}" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]" placeholder="porsi / box / pcs">
                </div>
            </div>

            <div class="space-y-1">
                <label class="block font-bold text-stone-700 uppercase tracking-wider">Foto Produk (Opsional)</label>
                <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs">
            </div>

            <div class="space-y-1">
                <label class="block font-bold text-stone-700 uppercase tracking-wider">Deskripsi Menu</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]" placeholder="Komposisi lauk, sambal, atau pelengkap...">{{ old('description') }}</textarea>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-stone-100">
                <a href="{{ route('admin.products.index') }}" class="px-4 py-2 text-stone-600 hover:text-stone-900 font-bold">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-[#C1440E] hover:bg-[#a3380b] text-white font-bold rounded-xl shadow-sm transition">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
