@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    {{-- HEADER & ACTIONS --}}
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-200 space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-stone-900 flex items-center gap-2">
                    <span>🍗</span>
                    <span>Katalog Produk Menu</span>
                </h1>
                <p class="text-xs text-stone-500 mt-0.5">Kelola seluruh sajian kuliner Yan's Food, status ketersediaan, dan harga.</p>
            </div>
            <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#C1440E] hover:bg-[#a3380b] text-white rounded-xl font-bold text-xs shadow-sm transition">
                <span>+ Tambah Produk Baru</span>
            </a>
        </div>

        {{-- SEARCH & FILTER BAR --}}
        <form action="{{ route('admin.products.index') }}" method="GET" class="pt-3 border-t border-stone-100 flex flex-wrap items-center gap-3 text-xs">
            <div class="flex-1 min-w-[200px]">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari nama produk..." 
                    class="w-full px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]"
                >
            </div>

            <div>
                <select name="category" class="px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <select name="status" class="px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                    <option value="">Semua Status</option>
                    <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Sedia (Available)</option>
                    <option value="unavailable" {{ request('status') === 'unavailable' ? 'selected' : '' }}>Tidak Tersedia</option>
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-stone-800 text-white rounded-xl font-bold hover:bg-stone-900 transition">
                Filter
            </button>

            @if(request()->hasAny(['search', 'category', 'status']))
                <a href="{{ route('admin.products.index') }}" class="px-3 py-2 text-stone-500 hover:text-stone-800 font-bold">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- PRODUCTS GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @forelse($products as $product)
            <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden shadow-xs hover:shadow-md transition flex flex-col justify-between">
                <div>
                    <div class="relative aspect-video bg-stone-100 overflow-hidden">
                        <img 
                            src="{{ $product->image_url }}" 
                            alt="{{ $product->name }}" 
                            class="w-full h-full object-cover"
                            loading="lazy"
                            onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=600&q=80';"
                        >

                        <span class="absolute top-2 right-2 px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase {{ $product->status === 'available' ? 'bg-emerald-600 text-white shadow' : 'bg-rose-600 text-white shadow' }}">
                            {{ $product->status === 'available' ? 'Sedia' : 'Tidak Tersedia' }}
                        </span>
                    </div>

                    <div class="p-4">
                        <span class="text-[10px] font-bold text-stone-400 uppercase tracking-wider">
                            {{ $product->category?->name ?? 'Menu' }}
                        </span>
                        <h3 class="font-bold text-stone-900 text-sm leading-snug line-clamp-2 mt-0.5">
                            {{ $product->name }}
                        </h3>
                        <p class="text-xs text-stone-500 line-clamp-2 mt-1">{{ $product->description ?: 'Tidak ada deskripsi.' }}</p>

                        <div class="mt-3 flex items-center justify-between text-xs">
                            <span class="font-black text-base text-[#C1440E]">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            <span class="text-stone-500 font-medium">Stok: {{ $product->stock }} {{ $product->unit }}</span>
                        </div>
                    </div>
                </div>

                <div class="p-4 pt-0 border-t border-stone-100 mt-2 flex items-center justify-end gap-2">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="px-3 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-lg font-bold text-xs transition">
                        ✏️ Edit
                    </a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg font-bold text-xs transition">
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
