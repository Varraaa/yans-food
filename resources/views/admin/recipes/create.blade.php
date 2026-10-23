@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.recipes.index') }}" class="text-xs font-bold text-stone-600 hover:text-stone-900 transition">
            ← Kembali ke Buku Resep
        </a>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-stone-200 space-y-6">
        <div>
            <h1 class="text-xl font-bold text-stone-900">Tambah Resep Menu Masakan</h1>
            <p class="text-xs text-stone-500 mt-0.5">Dokumentasikan takaran porsi dan bahan baku untuk menjaga kualitas rasa.</p>
        </div>

        <form action="{{ route('admin.recipes.store') }}" method="POST" class="space-y-5 text-xs">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="block font-bold text-stone-700 uppercase tracking-wider">Produk Terkait *</label>
                    <select name="product_id" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                        <option value="">Pilih Menu Produk</option>
                        @foreach($products as $prod)
                            <option value="{{ $prod->id }}" {{ old('product_id') == $prod->id ? 'selected' : '' }}>{{ $prod->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="block font-bold text-stone-700 uppercase tracking-wider">Nama Resep / Variasi *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Resep Standar Ayam Bakar Madu" class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="block font-bold text-stone-700 uppercase tracking-wider">Porsi Hasil (Yield)</label>
                    <input type="text" name="yield" value="{{ old('yield', '10 Porsi') }}" placeholder="Contoh: 10 Porsi / 1 Ekor" class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                </div>
                <div class="space-y-1">
                    <label class="block font-bold text-stone-700 uppercase tracking-wider">Catatan Penting</label>
                    <input type="text" name="notes" value="{{ old('notes') }}" placeholder="Contoh: Marinasi minimal 2 jam di kulkas" class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                </div>
            </div>

            <div class="space-y-1">
                <label class="block font-bold text-stone-700 uppercase tracking-wider">Langkah Pembuatan / Deskripsi</label>
                <textarea name="description" rows="3" placeholder="Instruksi memasak..." class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">{{ old('description') }}</textarea>
            </div>

            {{-- DYNAMIC INGREDIENTS SECTION --}}
            <div class="pt-4 border-t border-stone-200 space-y-3">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-stone-900 text-sm">Daftar Bahan Baku & Takaran</h4>
                        <p class="text-[11px] text-stone-500">Masukkan nama bahan, jumlah kuantitas, dan satuan.</p>
                    </div>
                    <button type="button" onclick="addIngredientRow()" class="px-3 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-800 rounded-lg font-bold text-xs transition">
                        + Tambah Bahan
                    </button>
                </div>

                <div id="ingredients-wrapper" class="space-y-2.5">
                    <!-- Default Row 1 -->
                    <div class="ingredient-row grid grid-cols-12 gap-2 items-center bg-stone-50 p-2.5 rounded-xl border border-stone-200">
                        <div class="col-span-12 sm:col-span-5">
                            <input type="text" name="ingredients[0][name]" placeholder="Nama Bahan (Ayam, Bawang, Kecap)" required class="w-full px-2.5 py-1.5 rounded-lg border border-stone-300 bg-white text-xs">
                        </div>
                        <div class="col-span-5 sm:col-span-3">
                            <input type="number" step="any" name="ingredients[0][quantity]" placeholder="Qty" required class="w-full px-2.5 py-1.5 rounded-lg border border-stone-300 bg-white text-xs">
                        </div>
                        <div class="col-span-5 sm:col-span-3">
                            <input type="text" name="ingredients[0][unit]" placeholder="Satuan (kg, gr, sdm)" required class="w-full px-2.5 py-1.5 rounded-lg border border-stone-300 bg-white text-xs">
                        </div>
                        <div class="col-span-2 sm:col-span-1 text-center">
                            <button type="button" onclick="this.closest('.ingredient-row').remove()" class="text-rose-500 hover:text-rose-700 font-bold text-base p-1">✕</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-stone-100">
                <a href="{{ route('admin.recipes.index') }}" class="px-4 py-2 text-stone-600 hover:text-stone-900 font-bold">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-[#C1440E] hover:bg-[#a3380b] text-white font-bold rounded-xl shadow-sm transition">
                    Simpan Resep
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let rowIndex = 1;
    function addIngredientRow() {
        const wrapper = document.getElementById('ingredients-wrapper');
        const div = document.createElement('div');
        div.className = 'ingredient-row grid grid-cols-12 gap-2 items-center bg-stone-50 p-2.5 rounded-xl border border-stone-200';
        div.innerHTML = `
            <div class="col-span-12 sm:col-span-5">
                <input type="text" name="ingredients[${rowIndex}][name]" placeholder="Nama Bahan" required class="w-full px-2.5 py-1.5 rounded-lg border border-stone-300 bg-white text-xs">
            </div>
            <div class="col-span-5 sm:col-span-3">
                <input type="number" step="any" name="ingredients[${rowIndex}][quantity]" placeholder="Qty" required class="w-full px-2.5 py-1.5 rounded-lg border border-stone-300 bg-white text-xs">
            </div>
            <div class="col-span-5 sm:col-span-3">
                <input type="text" name="ingredients[${rowIndex}][unit]" placeholder="Satuan" required class="w-full px-2.5 py-1.5 rounded-lg border border-stone-300 bg-white text-xs">
            </div>
            <div class="col-span-2 sm:col-span-1 text-center">
                <button type="button" onclick="this.closest('.ingredient-row').remove()" class="text-rose-500 hover:text-rose-700 font-bold text-base p-1">✕</button>
            </div>
        `;
        wrapper.appendChild(div);
        rowIndex++;
    }
</script>
@endsection
