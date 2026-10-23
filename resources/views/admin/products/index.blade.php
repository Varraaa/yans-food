@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    {{-- HEADER & ACTIONS --}}
    <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-stone-200 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
            <div>
                <h1 class="text-lg sm:text-xl font-bold text-stone-900 flex items-center gap-2">
                    <span>🍗</span>
                    <span>Katalog Produk Menu</span>
                </h1>
                <p class="text-xs text-stone-500 mt-0.5">Kelola seluruh sajian kuliner Yan's Food, status ketersediaan, dan harga.</p>
            </div>
            <a href="{{ route('admin.products.create') }}" class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 sm:py-2 bg-[#C1440E] hover:bg-[#a3380b] text-white rounded-xl font-bold text-xs shadow-sm transition w-full sm:w-auto">
                <span>+ Tambah Produk Baru</span>
            </a>
        </div>

        {{-- SEARCH & FILTER BAR --}}
        <form action="{{ route('admin.products.index') }}" method="GET" class="pt-3 border-t border-stone-100 flex flex-col sm:flex-row flex-wrap items-stretch sm:items-center gap-2.5 sm:gap-3 text-xs">
            <div class="w-full sm:flex-1 sm:min-w-[180px]">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari nama produk..." 
                    class="w-full px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]"
                >
            </div>

            <div class="w-full sm:w-auto">
                <select name="category" class="w-full sm:w-auto px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="w-full sm:w-auto">
                <select name="status" class="w-full sm:w-auto px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                    <option value="">Semua Status</option>
                    <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Sedia (Available)</option>
                    <option value="unavailable" {{ request('status') === 'unavailable' ? 'selected' : '' }}>Tidak Tersedia</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 sm:flex-none px-4 py-2 bg-stone-800 text-white rounded-xl font-bold hover:bg-stone-900 transition text-center">
                    Filter
                </button>

                @if(request()->hasAny(['search', 'category', 'status']))
                    <a href="{{ route('admin.products.index') }}" class="px-3 py-2 text-stone-500 hover:text-stone-800 font-bold text-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- PRODUCTS GRID (2-GRID RESPONSIVE) --}}
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-4">
        @forelse($products as $product)
            <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden shadow-xs hover:shadow-md transition flex flex-col justify-between">
                <div>
                    {{-- SMALLER PRODUCT IMAGE --}}
                    <div class="relative h-28 sm:h-36 bg-stone-100 overflow-hidden">
                        <img 
                            src="{{ $product->image_url }}" 
                            alt="{{ $product->name }}" 
                            class="w-full h-full object-cover"
                            loading="lazy"
                            onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=600&q=80';"
                        >

                        <span class="absolute top-2 right-2 px-2 py-0.5 rounded-full text-[9px] sm:text-[10px] font-black uppercase {{ $product->status === 'available' ? 'bg-emerald-600 text-white shadow' : 'bg-rose-600 text-white shadow' }}">
                            {{ $product->status === 'available' ? 'Sedia' : 'Kosong' }}
                        </span>
                    </div>

                    <div class="p-3 sm:p-4">
                        <span class="text-[9px] sm:text-[10px] font-bold text-stone-400 uppercase tracking-wider block">
                            {{ $product->category?->name ?? 'Menu' }}
                        </span>
                        <h3 class="font-bold text-stone-900 text-xs sm:text-sm leading-snug line-clamp-2 mt-0.5">
                            {{ $product->name }}
                        </h3>
                        <p class="text-[11px] sm:text-xs text-stone-500 line-clamp-1 sm:line-clamp-2 mt-1">{{ $product->description ?: 'Tidak ada deskripsi.' }}</p>

                        <div class="mt-2 sm:mt-3 flex flex-col sm:flex-row sm:items-center justify-between text-xs gap-0.5 sm:gap-1">
                            <span class="font-black text-sm sm:text-base text-[#C1440E]">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            <span class="text-stone-500 font-medium text-[10px] sm:text-xs">Stok: {{ $product->stock }} {{ $product->unit }}</span>
                        </div>
                    </div>
                </div>

                <div class="p-3 sm:p-4 pt-0 border-t border-stone-100 mt-2 flex flex-wrap items-center justify-end gap-1.5 sm:gap-2">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="px-2.5 sm:px-3 py-1 sm:py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-lg font-bold text-[11px] sm:text-xs transition">
                        ✏️ Edit
                    </a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-2.5 sm:px-3 py-1 sm:py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg font-bold text-[11px] sm:text-xs transition">
                            🗑️ Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-dashed border-stone-300">
                <div class="text-3xl mb-1">🍗</div>
                <p class="text-stone-500 text-sm font-medium">Belum ada produk yang cocok dengan pencarian.</p>
            </div>
        @endforelse
    </div>

    <div>
        {{ $products->links() }}
    </div>
</div>
@endsection
