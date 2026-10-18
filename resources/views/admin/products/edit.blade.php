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
            <h1 class="text-xl font-bold text-stone-900">Ubah Data Menu Produk</h1>
            <p class="text-xs text-stone-500 mt-0.5">Edit detail informasi produk {{ $product->name }}.</p>
        </div>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div class="space-y-1">
                <label class="block font-bold text-stone-700 uppercase tracking-wider">Nama Menu / Produk *</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-sm focus:ring-1 focus:ring-[#C1440E]">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="block font-bold text-stone-700 uppercase tracking-wider">Kategori Menu *</label>
                    <select name="category_id" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="block font-bold text-stone-700 uppercase tracking-wider">Status Ketersediaan *</label>
                    <select name="status" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                        <option value="available" {{ old('status', $product->status) === 'available' ? 'selected' : '' }}>Sedia (Bisa Dijual di POS & Publik)</option>
                        <option value="unavailable" {{ old('status', $product->status) === 'unavailable' ? 'selected' : '' }}>Tidak Tersedia (Kosong)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="space-y-1">
                    <label class="block font-bold text-stone-700 uppercase tracking-wider">Harga Jual (Rp) *</label>
                    <input type="number" name="price" value="{{ old('price', (float)$product->price) }}" min="0" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs font-bold focus:ring-1 focus:ring-[#C1440E]">
                </div>

                <div class="space-y-1">
                    <label class="block font-bold text-stone-700 uppercase tracking-wider">Stok *</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                </div>

                <div class="space-y-1">
                    <label class="block font-bold text-stone-700 uppercase tracking-wider">Satuan Unit *</label>
                    <input type="text" name="unit" value="{{ old('unit', $product->unit) }}" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                </div>
            </div>

            <div class="space-y-1">
                <label class="block font-bold text-stone-700 uppercase tracking-wider">Ganti Foto Produk (Opsional)</label>
                @if($product->image)
                    <div class="mb-2">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-24 h-16 object-cover rounded-lg border border-stone-200">
                    </div>
                @endif
                <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs">
            </div>

            <div class="space-y-1">
                <label class="block font-bold text-stone-700 uppercase tracking-wider">Deskripsi Menu</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-stone-100">
                <a href="{{ route('admin.products.index') }}" class="px-4 py-2 text-stone-600 hover:text-stone-900 font-bold">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-[#C1440E] hover:bg-[#a3380b] text-white font-bold rounded-xl shadow-sm transition">
                    Perbarui Produk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
