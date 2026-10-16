<!-- Sticky Filter Bar & Live Search (§5.2) -->
<div class="sticky top-16 md:top-20 z-30 bg-cream-bg/95 backdrop-blur-md py-3.5 border-b border-surface-variant/40 -mx-4 sm:-mx-6 lg:-mx-12 px-4 sm:px-6 lg:px-12 transition-all">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center justify-between gap-3">
        <!-- Category Filter Ribbon with horizontal scroll -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 md:pb-0 scrollbar-none" id="categoryFilterContainer" role="tablist" aria-label="Kategori Menu">
            <button type="button" 
                    role="tab"
                    aria-selected="true"
                    class="category-btn px-4 py-2 rounded-full font-label-md transition-all duration-200 shadow-xs bg-primary-container text-on-primary whitespace-nowrap active:scale-95 text-xs sm:text-sm font-semibold" 
                    data-filter="all">
                Semua <span id="count-all" class="ml-1 opacity-80 text-xs"></span>
            </button>
            <button type="button" 
                    role="tab"
                    aria-selected="false"
                    class="category-btn px-4 py-2 rounded-full font-label-md transition-all duration-200 bg-surface-warm text-on-surface hover:bg-surface-container-high shadow-xs whitespace-nowrap active:scale-95 border border-surface-variant/40 text-xs sm:text-sm" 
                    data-filter="ringan">
                Makanan Ringan <span id="count-ringan" class="ml-1 opacity-70 text-xs"></span>
            </button>
            <button type="button" 
                    role="tab"
                    aria-selected="false"
                    class="category-btn px-4 py-2 rounded-full font-label-md transition-all duration-200 bg-surface-warm text-on-surface hover:bg-surface-container-high shadow-xs whitespace-nowrap active:scale-95 border border-surface-variant/40 text-xs sm:text-sm" 
                    data-filter="berat">
                Makanan Berat <span id="count-berat" class="ml-1 opacity-70 text-xs"></span>
            </button>
            <button type="button" 
                    role="tab"
                    aria-selected="false"
                    class="category-btn px-4 py-2 rounded-full font-label-md transition-all duration-200 bg-surface-warm text-on-surface hover:bg-surface-container-high shadow-xs whitespace-nowrap active:scale-95 border border-surface-variant/40 text-xs sm:text-sm" 
                    data-filter="mie">
                Mie Instan <span id="count-mie" class="ml-1 opacity-70 text-xs"></span>
            </button>
            <button type="button" 
                    role="tab"
                    aria-selected="false"
                    class="category-btn px-4 py-2 rounded-full font-label-md transition-all duration-200 bg-surface-warm text-on-surface hover:bg-surface-container-high shadow-xs whitespace-nowrap active:scale-95 border border-surface-variant/40 text-xs sm:text-sm" 
                    data-filter="minuman">
                Minuman Segar <span id="count-minuman" class="ml-1 opacity-70 text-xs"></span>
            </button>
        </div>

        <!-- Live Search Box with Debounce & Clear (§5.2) -->
        <div class="relative w-full md:w-72 shrink-0">
            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-secondary text-[20px] pointer-events-none">search</span>
            <input type="text" 
                   id="searchInput" 
                   aria-label="Cari menu Yan's Food"
                   placeholder="Cari risoles, nasi, kopi..." 
                   class="w-full pl-10 pr-10 py-2 rounded-xl bg-surface-warm text-on-surface placeholder:text-secondary/60 font-body-sm shadow-xs focus:outline-none focus:ring-2 focus:ring-primary-container/30 border border-surface-variant/40 text-sm">
            <button type="button" 
                    id="clearSearch" 
                    aria-label="Hapus pencarian"
                    class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-secondary hover:text-on-surface p-1">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>
    </div>
</div>

<!-- Filter JavaScript Logic -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categoryButtons = document.querySelectorAll('.category-btn');
        const searchInput = document.getElementById('searchInput');
        const clearSearch = document.getElementById('clearSearch');
        const productCards = document.querySelectorAll('.product-card');
        const emptyState = document.getElementById('empty-state');

        let currentFilter = 'all';
        let searchQuery = '';
        let debounceTimer = null;

        // Hitung dinamis jumlah menu per kategori
        function updateCategoryCounts() {
            let counts = { all: 0, ringan: 0, berat: 0, mie: 0, minuman: 0 };
            productCards.forEach(card => {
                const cat = card.getAttribute('data-category');
                counts.all++;
                if (counts[cat] !== undefined) counts[cat]++;
            });

            const elAll = document.getElementById('count-all');
            const elRingan = document.getElementById('count-ringan');
            const elBerat = document.getElementById('count-berat');
            const elMie = document.getElementById('count-mie');
            const elMinuman = document.getElementById('count-minuman');

            if (elAll) elAll.textContent = `(${counts.all})`;
            if (elRingan) elRingan.textContent = `(${counts.ringan})`;
            if (elBerat) elBerat.textContent = `(${counts.berat})`;
            if (elMie) elMie.textContent = `(${counts.mie})`;
            if (elMinuman) elMinuman.textContent = `(${counts.minuman})`;
        }

        updateCategoryCounts();

        function filterProducts() {
            let visibleCount = 0;

            productCards.forEach(card => {
                const category = card.getAttribute('data-category');
                const title = (card.getAttribute('data-title') || '').toLowerCase();

                const matchesCategory = (currentFilter === 'all') || (category === currentFilter);
                const matchesSearch = !searchQuery || title.includes(searchQuery);

                if (matchesCategory && matchesSearch) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (emptyState) {
                if (visibleCount === 0) {
                    emptyState.classList.remove('hidden');
                    emptyState.classList.add('flex');
                } else {
                    emptyState.classList.add('hidden');
                    emptyState.classList.remove('flex');
                }
            }
        }

        categoryButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                categoryButtons.forEach(b => {
                    b.classList.remove('bg-primary-container', 'text-on-primary');
                    b.classList.add('bg-surface-warm', 'text-on-surface');
                    b.setAttribute('aria-selected', 'false');
                });
                this.classList.remove('bg-surface-warm', 'text-on-surface');
                this.classList.add('bg-primary-container', 'text-on-primary');
                this.setAttribute('aria-selected', 'true');

                currentFilter = this.getAttribute('data-filter');
                filterProducts();
            });
        });

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                const val = this.value.trim().toLowerCase();
                
                if (clearSearch) {
                    if (val.length > 0) {
                        clearSearch.classList.remove('hidden');
                    } else {
                        clearSearch.classList.add('hidden');
                    }
                }

                // Debounce 150ms (§5.2)
                debounceTimer = setTimeout(() => {
                    searchQuery = val;
                    filterProducts();
                }, 150);
            });
        }

        if (clearSearch) {
            clearSearch.addEventListener('click', function () {
                searchInput.value = '';
                searchQuery = '';
                this.classList.add('hidden');
                searchInput.focus();
                filterProducts();
            });
        }
    });
</script>
