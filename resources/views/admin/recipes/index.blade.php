@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    {{-- HEADER & ACTIONS --}}
    <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-stone-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
        <div>
            <h1 class="text-lg sm:text-xl font-bold text-stone-900 flex items-center gap-2">
                <span>📖</span>
                <span>Buku Resep & Takaran Dapur</span>
            </h1>
            <p class="text-xs text-stone-500 mt-0.5">Dokumentasi bahan baku, takaran porsi, dan resep menu Yan's Food.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.recipes.create') }}" class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 sm:py-2 bg-[#C1440E] hover:bg-[#a3380b] text-white rounded-xl font-bold text-xs shadow-sm transition w-full sm:w-auto">
                <span class="material-symbols-outlined text-[16px]">add</span>
                <span>Tambah Resep Baru</span>
            </a>
        </div>
    </div>

    {{-- SEARCH & FILTER BAR --}}
    <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-stone-200 space-y-3">
        <form action="{{ route('admin.recipes.index') }}" method="GET" id="admin-recipe-form" class="flex flex-col md:flex-row flex-wrap items-stretch md:items-center gap-2.5 sm:gap-3 text-xs">
            {{-- SEARCH INPUT (INSTANT SEARCH) --}}
            <div class="flex-1 min-w-[220px] relative">
                <span class="material-symbols-outlined absolute left-3 top-2.5 text-stone-400 text-[18px]">search</span>
                <input 
                    type="text" 
                    id="admin-recipe-search"
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Ketik untuk mencari resep, produk, atau bahan baku..." 
                    autocomplete="off"
                    class="w-full pl-9 pr-8 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E] focus:bg-white transition"
                >
                <button type="button" id="admin-recipe-clear-btn" class="hidden absolute right-2.5 top-2.5 text-stone-400 hover:text-stone-600">
                    <span class="material-symbols-outlined text-[16px]">close</span>
                </button>
            </div>

            {{-- FILTER PRODUK --}}
            <div class="w-full md:w-auto min-w-[190px]">
                <select name="product_id" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E] focus:bg-white font-medium cursor-pointer">
                    <option value="">Semua Produk ({{ $products->count() }})</option>
                    @foreach($products as $prod)
                        <option value="{{ $prod->id }}" {{ request('product_id') == $prod->id ? 'selected' : '' }}>
                            {{ $prod->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- FILTER KATEGORI MENU --}}
            <div class="w-full md:w-auto min-w-[150px]">
                <select name="category_id" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E] focus:bg-white font-medium cursor-pointer">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- BUTTON REFRESH --}}
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.recipes.index') }}" id="btn-refresh-recipes" class="flex-1 md:flex-none px-3.5 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-xl font-bold transition flex items-center justify-center gap-1.5 cursor-pointer text-xs" title="Segarkan dan reset filter">
                    <span class="material-symbols-outlined text-[16px]">refresh</span>
                    <span>Refresh</span>
                </a>
            </div>
        </form>

        {{-- FILTER SUMMARY BADGES --}}
        @if(request()->hasAny(['search', 'product_id', 'category_id']))
            <div class="pt-2 border-t border-stone-100 flex flex-wrap items-center justify-between gap-2 text-[11px] text-stone-500">
                <div class="flex items-center gap-1.5 flex-wrap">
                    <span class="font-bold text-stone-700">Filter Aktif:</span>
                    @if(request('search'))
                        <span class="px-2 py-0.5 rounded-md bg-stone-100 border border-stone-200 text-stone-700 font-medium">
                            Kata kunci: "{{ request('search') }}"
                        </span>
                    @endif
                    @if(request('product_id'))
                        @php $selectedProd = $products->firstWhere('id', request('product_id')); @endphp
                        @if($selectedProd)
                            <span class="px-2 py-0.5 rounded-md bg-amber-50 border border-amber-200 text-amber-800 font-medium">
                                Produk: {{ $selectedProd->name }}
                            </span>
                        @endif
                    @endif
                    @if(request('category_id'))
                        @php $selectedCat = $categories->firstWhere('id', request('category_id')); @endphp
                        @if($selectedCat)
                            <span class="px-2 py-0.5 rounded-md bg-sky-50 border border-sky-200 text-sky-800 font-medium">
                                Kategori: {{ $selectedCat->name }}
                            </span>
                        @endif
                    @endif
                </div>
                <span class="font-bold text-stone-600">
                    Menampilkan {{ $recipes->total() }} dari {{ $totalRecipesCount }} resep
                </span>
            </div>
        @endif
    </div>

    {{-- RECIPES GRID (RESPONSIVE 2X2 ON MOBILE) --}}
    <div id="recipe-cards-container" class="grid grid-cols-2 lg:grid-cols-3 gap-2.5 sm:gap-4">
        @forelse($recipes as $recipe)
            <div class="recipe-card-item bg-white p-3 sm:p-5 rounded-2xl shadow-sm border border-stone-200 flex flex-col justify-between hover:shadow-md transition"
                data-name="{{ strtolower($recipe->name) }}"
                data-product="{{ strtolower($recipe->product?->name ?? '') }}"
                data-ingredients="{{ strtolower($recipe->ingredients->pluck('ingredient_name')->implode(' ')) }}">
                <div class="space-y-2 sm:space-y-3">
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-1 sm:gap-2">
                        <div class="min-w-0">
                            <div class="flex items-center gap-1 flex-wrap">
                                <span class="text-[9px] sm:text-[10px] font-bold text-[#C1440E] uppercase tracking-wider truncate block">
                                    {{ $recipe->product?->name ?? 'Menu Produk' }}
                                </span>
                                @if($recipe->product?->category)
                                    <span class="px-1.5 py-0.5 rounded text-[8px] sm:text-[8.5px] font-bold bg-stone-100 text-stone-500">
                                        {{ $recipe->product->category->name }}
                                    </span>
                                @endif
                            </div>
                            <h3 class="font-bold text-stone-900 text-xs sm:text-base mt-0.5 line-clamp-2 leading-snug">{{ $recipe->name }}</h3>
                        </div>
                        <span class="self-start px-1.5 py-0.5 sm:px-2.5 sm:py-1 bg-amber-50 text-amber-800 rounded-md sm:rounded-lg text-[9px] sm:text-xs font-bold shrink-0">
                            {{ $recipe->yield ?: '1 Porsi' }}
                        </span>
                    </div>

                    <p class="text-[10.5px] sm:text-xs text-stone-500 line-clamp-2 leading-relaxed">
                        {{ $recipe->description ?: 'Belum ada deskripsi pembuatan.' }}
                    </p>

                    <div class="p-2 sm:p-3 bg-stone-50 rounded-xl text-xs space-y-1">
                        <span class="font-bold text-stone-700 block text-[9px] sm:text-[11px] uppercase tracking-wider">Komposisi:</span>
                        <div class="flex flex-wrap gap-1 sm:gap-1.5 pt-0.5">
                            @forelse($recipe->ingredients->take(3) as $ing)
                                <span class="px-1.5 sm:px-2 py-0.5 rounded-md bg-white border border-stone-200 text-stone-700 text-[8.5px] sm:text-[10px] leading-tight">
                                    {{ $ing->ingredient_name }} ({{ $ing->quantity }} {{ $ing->unit }})
                                </span>
                            @empty
                                <span class="text-stone-400 italic text-[9px] sm:text-[11px]">Belum ada bahan</span>
                            @endforelse
                            @if($recipe->ingredients->count() > 3)
                                <span class="px-1.5 sm:px-2 py-0.5 rounded-md bg-stone-200 text-stone-600 text-[8.5px] sm:text-[10px] font-bold">
                                    +{{ $recipe->ingredients->count() - 3 }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="pt-2.5 sm:pt-4 border-t border-stone-100 mt-2.5 sm:mt-4 flex flex-col sm:flex-row sm:items-center justify-between gap-1.5 sm:gap-2">
                    <a href="{{ route('admin.recipes.show', $recipe->id) }}" class="text-[10.5px] sm:text-xs font-bold text-[#C1440E] hover:underline flex items-center gap-0.5">
                        <span>Detail</span>
                        <span class="material-symbols-outlined text-[13px] sm:text-[14px]">arrow_forward</span>
                    </a>
                    <div class="flex items-center gap-1 self-end sm:self-auto">
                        <a href="{{ route('admin.recipes.edit', $recipe->id) }}" class="p-1 sm:p-1.5 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-lg text-xs" title="Edit Resep">
                            ✏️
                        </a>
                        <form action="{{ route('admin.recipes.destroy', $recipe->id) }}" method="POST" onsubmit="return confirm('Hapus resep ini?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1 sm:p-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-xs" title="Hapus Resep">
                                🗑️
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-dashed border-stone-300 space-y-3">
                <span class="material-symbols-outlined text-4xl text-stone-300">menu_book</span>
                <div>
                    <p class="text-stone-700 text-sm font-bold">Resep tidak ditemukan</p>
                    <p class="text-stone-500 text-xs mt-0.5">Tidak ada resep produk yang sesuai dengan kriteria pencarian atau filter.</p>
                </div>
                @if(request()->hasAny(['search', 'product_id', 'category_id']))
                    <div>
                        <a href="{{ route('admin.recipes.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-xl text-xs font-bold transition">
                            <span class="material-symbols-outlined text-[16px]">filter_alt_off</span>
                            <span>Hapus Semua Filter</span>
                        </a>
                    </div>
                @endif
            </div>
        @endforelse
    </div>

    {{-- CLIENT SIDE EMPTY STATE FOR INSTANT SEARCH --}}
    <div id="admin-recipe-empty" class="hidden py-16 text-center bg-white rounded-2xl border border-dashed border-stone-300 space-y-3">
        <span class="material-symbols-outlined text-4xl text-stone-300">search_off</span>
        <div>
            <p class="text-stone-700 text-sm font-bold">Resep tidak ditemukan</p>
            <p class="text-stone-500 text-xs mt-0.5">Tidak ada resep yang sesuai dengan kata kunci pencarian Anda.</p>
        </div>
        <button type="button" onclick="window.clearRecipeSearch()" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-xl text-xs font-bold transition">
            <span class="material-symbols-outlined text-[16px]">refresh</span>
            <span>Reset Pencarian</span>
        </button>
    </div>

    <div>
        {{ $recipes->links() }}
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('admin-recipe-search');
        const clearBtn = document.getElementById('admin-recipe-clear-btn');
        const recipeCards = document.querySelectorAll('.recipe-card-item');
        const emptyState = document.getElementById('admin-recipe-empty');
        const cardsContainer = document.getElementById('recipe-cards-container');

        function doInstantRecipeFilter() {
            const query = (searchInput.value || '').trim().toLowerCase();
            let visibleCount = 0;

            if (clearBtn) {
                if (query.length > 0) {
                    clearBtn.classList.remove('hidden');
                } else {
                    clearBtn.classList.add('hidden');
                }
            }

            recipeCards.forEach(card => {
                const name = card.dataset.name || '';
                const product = card.dataset.product || '';
                const ingredients = card.dataset.ingredients || '';

                if (!query || name.includes(query) || product.includes(query) || ingredients.includes(query)) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (emptyState) {
                if (visibleCount === 0 && recipeCards.length > 0) {
                    emptyState.classList.remove('hidden');
                } else {
                    emptyState.classList.add('hidden');
                }
            }
        }

        if (searchInput) {
            searchInput.addEventListener('input', doInstantRecipeFilter);
        }

        window.clearRecipeSearch = function() {
            if (searchInput) {
                searchInput.value = '';
                doInstantRecipeFilter();
                searchInput.focus();
            }
        };

        if (clearBtn) {
            clearBtn.addEventListener('click', window.clearRecipeSearch);
        }
    });
    </script>
</div>
@endsection
