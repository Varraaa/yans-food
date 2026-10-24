<!-- Sticky Filter Bar & Live Search (§5.3, M11, M12) -->
<div class="sticky top-16 md:top-20 z-30 bg-cream-bg/95 backdrop-blur-md py-4 border-b border-surface-variant/40 -mx-4 sm:-mx-6 md:-mx-8 lg:-mx-12 px-4 sm:px-6 md:px-8 lg:px-12 transition-all">
    <div class="max-w-7xl mx-auto space-y-3">
        <!-- Top Controls: Search, Sort, & Availability Toggle -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
            <!-- Live Search Box with Debounce & Clear (§5.3) -->
            <div class="relative w-full sm:w-64 md:w-72 lg:w-80 shrink-0">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-secondary text-[20px] pointer-events-none">search</span>
                <input type="text" 
                       id="menuSearchInput" 
                       aria-label="Cari menu Yan's Food"
                       placeholder="Cari risoles, nasi bakar, kopi..." 
                       class="w-full pl-10 pr-10 py-2.5 rounded-xl bg-surface-warm text-on-surface placeholder:text-secondary/60 font-body-sm shadow-xs focus:outline-none focus:ring-2 focus:ring-primary/25 border border-surface-variant/50 text-sm">
                <button type="button" 
                        id="menuClearSearchBtn" 
                        aria-label="Hapus pencarian"
                        class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-secondary hover:text-on-surface p-1">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>

            <!-- Right Controls: Toggle Sedia & Sort (§5.3 points 330-331) -->
            <div class="flex items-center gap-3 sm:gap-4 overflow-x-auto pb-1 md:pb-0">
                <!-- Toggle "Hanya yang tersedia" (Switch) -->
                <label for="menuAvailableToggle" class="inline-flex items-center gap-2.5 cursor-pointer shrink-0 select-none bg-surface-warm px-3.5 py-2 rounded-xl border border-surface-variant/40 shadow-xs">
                    <input type="checkbox" id="menuAvailableToggle" class="sr-only peer">
                    <div class="w-9 h-5 bg-surface-container-high peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary relative"></div>
                    <span class="font-label-sm text-xs font-semibold text-on-surface">Tersedia Saja</span>
                </label>

                <!-- Sort Dropdown -->
                <div class="relative shrink-0">
                    <select id="menuSortSelect" 
                            aria-label="Urutkan menu"
                            class="appearance-none bg-surface-warm text-on-surface font-label-sm text-xs font-semibold pl-3 pr-8 py-2.5 rounded-xl border border-surface-variant/40 shadow-xs focus:outline-none focus:ring-2 focus:ring-primary/20 cursor-pointer">
                        <option value="recommended">Rekomendasi</option>
                        <option value="price-low">Harga Termurah</option>
                        <option value="price-high">Harga Termahal</option>
                        <option value="name-az">Nama A–Z</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-2.5 top-1/2 -translate-y-1/2 text-secondary text-[18px] pointer-events-none">expand_more</span>
                </div>

                <!-- Results Counter Pill -->
                <div id="menuResultsCount" class="hidden sm:inline-flex px-3 py-1.5 rounded-xl bg-surface-container text-secondary font-label-sm text-xs font-semibold shrink-0">
                    Semua Menu
                </div>

                <!-- Refresh / Reset Filter Button -->
                <button type="button" 
                        id="menuRefreshBtn" 
                        aria-label="Refresh filter dan kembalikan semua menu"
                        title="Refresh & Tampilkan Semua Menu"
                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-surface-warm hover:bg-surface-container text-secondary hover:text-on-surface font-label-sm text-xs font-semibold shadow-xs border border-surface-variant/40 transition active:scale-95 shrink-0 cursor-pointer">
                    <span class="material-symbols-outlined text-[18px]">refresh</span>
                    <span class="hidden sm:inline">Refresh</span>
                </button>
            </div>
        </div>

        <!-- Category Filter Ribbon with Smooth Horizontal Scroll (M11, §3.7) -->
        <div class="filter-ribbon-container" role="tablist" aria-label="Kategori Menu">
            <button type="button" 
                    role="tab"
                    aria-selected="true"
                    data-filter-chip="all"
                    class="category-chip is-active">
                <span>Semua Menu</span>
            </button>
            <button type="button" 
                    role="tab"
                    aria-selected="false"
                    data-filter-chip="ringan"
                    class="category-chip">
                <span>Makanan Ringan</span>
            </button>
            <button type="button" 
                    role="tab"
                    aria-selected="false"
                    data-filter-chip="berat"
                    class="category-chip">
                <span>Makanan Berat</span>
            </button>
            <button type="button" 
                    role="tab"
                    aria-selected="false"
                    data-filter-chip="mie"
                    class="category-chip">
                <span>Mie & Bakso</span>
            </button>
            <button type="button" 
                    role="tab"
                    aria-selected="false"
                    data-filter-chip="minuman"
                    class="category-chip">
                <span>Minuman Segar</span>
            </button>
        </div>
    </div>
</div>
