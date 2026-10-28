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
                <span class="material-symbols-outlined text-[16px]">add</span>
                <span>Tambah Produk Baru</span>
            </a>
        </div>

        {{-- SEARCH & FILTER BAR (INSTANT AUTO-FILTER ON INPUT) --}}
        <form id="product-filter-form" action="{{ route('admin.products.index') }}" method="GET" class="pt-3 border-t border-stone-100 flex flex-col sm:flex-row flex-wrap items-stretch sm:items-center gap-2.5 sm:gap-3 text-xs">
            {{-- INSTANT SEARCH INPUT --}}
            <div class="relative flex-1 min-w-[200px]">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-stone-400">
                    <span class="material-symbols-outlined text-[18px]">search</span>
                </span>
                <input 
                    type="text" 
                    id="admin-product-search"
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Ketik nama produk untuk mencari langsung..." 
                    autocomplete="off"
                    class="w-full pl-9 pr-8 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs text-stone-900 focus:bg-white focus:ring-1 focus:ring-[#C1440E] focus:outline-none transition"
                >
                <button 
                    type="button" 
                    id="btn-clear-product-search" 
                    class="hidden absolute inset-y-0 right-0 pr-2.5 flex items-center text-stone-400 hover:text-stone-600"
                    title="Hapus pencarian"
                >
                    <span class="material-symbols-outlined text-[16px]">close</span>
                </button>
            </div>

            {{-- KATEGORI DROPDOWN (AUTO FILTER ON CHANGE) --}}
            <div class="w-full sm:w-auto">
                <select name="category" onchange="this.form.submit()" class="w-full sm:w-auto px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E] focus:bg-white font-medium cursor-pointer">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- STATUS DROPDOWN (AUTO FILTER ON CHANGE) --}}
            <div class="w-full sm:w-auto">
                <select name="status" onchange="this.form.submit()" class="w-full sm:w-auto px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E] focus:bg-white font-medium cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Sedia (Available)</option>
                    <option value="unavailable" {{ request('status') === 'unavailable' ? 'selected' : '' }}>Tidak Tersedia</option>
                </select>
            </div>

            {{-- TOMBOL REFRESH / RESET --}}
            <div class="flex items-center gap-2">
                <a 
                    href="{{ route('admin.products.index') }}" 
                    id="btn-refresh-products"
                    title="Refresh dan Tampilkan Semua Produk"
                    class="px-3.5 py-2 rounded-xl border border-stone-300 bg-stone-100 hover:bg-stone-200 text-stone-700 hover:text-stone-900 font-bold transition flex items-center gap-1.5 shadow-2xs active:scale-95 text-center"
                >
                    <span class="material-symbols-outlined text-[16px]">refresh</span>
                    <span>Refresh</span>
                </a>
            </div>
        </form>
    </div>

    {{-- EMPTY SEARCH NOTICE (CLIENT-SIDE) --}}
    <div id="admin-product-empty" class="hidden py-16 text-center bg-white rounded-2xl border border-dashed border-stone-300">
        <div class="text-3xl mb-1">🔍</div>
        <p class="text-stone-700 text-sm font-bold">Produk tidak ditemukan</p>
        <p class="text-stone-500 text-xs mt-0.5">Tidak ada produk yang cocok dengan kata kunci pencarian Anda.</p>
        <div class="mt-3">
            <button type="button" onclick="resetProductSearch()" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-xl text-xs font-bold transition">
                <span class="material-symbols-outlined text-[16px]">refresh</span>
                <span>Reset Pencarian</span>
            </button>
        </div>
    </div>

    {{-- PRODUCTS GRID (2-GRID RESPONSIVE) --}}
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-4" id="admin-products-grid">
        @forelse($products as $product)
            <div 
                class="product-card-item bg-white rounded-2xl border border-stone-200 overflow-hidden shadow-xs hover:shadow-md transition flex flex-col justify-between"
                data-name="{{ strtolower($product->name) }}"
                data-category="{{ strtolower($product->category?->name ?? '') }}"
            >
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
                    </div>

                    <div class="p-3 sm:p-4">
                        <span class="product-item-cat text-[9px] sm:text-[10px] font-bold text-stone-400 uppercase tracking-wider block">
                            {{ $product->category?->name ?? 'Menu' }}
                        </span>
                        
                        {{-- JUDUL PRODUK & BADGE SISA STOK MODERN DI SEBELAH KANAN --}}
                        <div class="flex items-start justify-between gap-1.5 mt-0.5">
                            <h3 class="product-item-title font-bold text-stone-900 text-xs sm:text-sm leading-snug break-words flex-1 min-w-0" title="{{ $product->name }}">
                                {{ $product->name }}
                            </h3>
                            @if($product->stock > 0)
                                <span class="shrink-0 inline-flex items-center gap-1 px-2 py-0.5 rounded-md font-mono text-[10px] sm:text-[11px] font-bold border transition-colors {{ $product->stock > 10 ? 'bg-emerald-50 text-emerald-700 border-emerald-200/80' : 'bg-amber-50 text-amber-700 border-amber-200/80' }}" title="Sisa Stok: {{ $product->stock }} {{ $product->unit }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $product->stock > 10 ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                                    <span>{{ $product->stock }}</span>
                                </span>
                            @else
                                <span class="shrink-0 inline-flex items-center gap-1 px-2 py-0.5 rounded-md font-mono text-[10px] sm:text-[11px] font-bold border bg-rose-50 text-rose-700 border-rose-200/80" title="Stok Habis">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                    <span>0</span>
                                </span>
                            @endif
                        </div>

                        <p class="text-[11px] sm:text-xs text-stone-500 line-clamp-1 sm:line-clamp-2 mt-1">{{ $product->description ?: 'Tidak ada deskripsi.' }}</p>

                        <div class="mt-2 sm:mt-3 flex items-center justify-between text-xs">
                            <span class="font-black text-sm sm:text-base text-[#C1440E]">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            <span class="text-stone-400 font-medium text-[10px] sm:text-xs">/ {{ $product->unit }}</span>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('admin-product-search');
    const clearBtn = document.getElementById('btn-clear-product-search');
    const emptyNotice = document.getElementById('admin-product-empty');
    const productCards = document.querySelectorAll('.product-card-item');

    function filterProducts() {
        const q = (searchInput?.value || '').toLowerCase().trim();
        let visibleCount = 0;

        if (clearBtn) {
            if (q.length > 0) clearBtn.classList.remove('hidden');
            else clearBtn.classList.add('hidden');
        }

        productCards.forEach(card => {
            const name = card.getAttribute('data-name') || '';
            const cat = card.getAttribute('data-category') || '';
            if (!q || name.includes(q) || cat.includes(q)) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (emptyNotice) {
            if (visibleCount === 0 && productCards.length > 0) {
                emptyNotice.classList.remove('hidden');
            } else {
                emptyNotice.classList.add('hidden');
            }
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterProducts);
    }

    if (clearBtn) {
        clearBtn.addEventListener('click', function() {
            if (searchInput) {
                searchInput.value = '';
                filterProducts();
                searchInput.focus();
            }
        });
    }

    window.resetProductSearch = function() {
        if (searchInput) {
            searchInput.value = '';
            filterProducts();
        }
        window.location.href = "{{ route('admin.products.index') }}";
    };
});
</script>
@endsection
