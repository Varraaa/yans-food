<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-6 pb-2">
    <!-- Category Filter Ribbon -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 md:pb-0 scrollbar-none" id="categoryFilterContainer">
        <button type="button" 
                class="category-btn px-4 py-2 rounded-full font-label-md transition-all duration-200 shadow-sm bg-primary-container text-on-primary whitespace-nowrap active:scale-95" 
                data-filter="all">
            Semua (9)
        </button>
        <button type="button" 
                class="category-btn px-4 py-2 rounded-full font-label-md transition-all duration-200 bg-surface-warm text-on-surface hover:bg-surface-container-high shadow-sm whitespace-nowrap active:scale-95" 
                data-filter="ringan">
            Makanan Ringan
        </button>
        <button type="button" 
                class="category-btn px-4 py-2 rounded-full font-label-md transition-all duration-200 bg-surface-warm text-on-surface hover:bg-surface-container-high shadow-sm whitespace-nowrap active:scale-95" 
                data-filter="berat">
            Makanan Berat
        </button>
        <button type="button" 
                class="category-btn px-4 py-2 rounded-full font-label-md transition-all duration-200 bg-surface-warm text-on-surface hover:bg-surface-container-high shadow-sm whitespace-nowrap active:scale-95" 
                data-filter="mie">
            Mie Instan
        </button>
        <button type="button" 
                class="category-btn px-4 py-2 rounded-full font-label-md transition-all duration-200 bg-surface-warm text-on-surface hover:bg-surface-container-high shadow-sm whitespace-nowrap active:scale-95" 
                data-filter="minuman">
            Minuman Segar
        </button>
    </div>

    <!-- Live Search Box -->
    <div class="relative w-full md:w-80">
        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-secondary text-[20px] pointer-events-none">search</span>
        <input type="text" 
               id="searchInput" 
               placeholder="Cari risoles, nasi goreng, kopi..." 
               class="w-full pl-10 pr-10 py-2.5 rounded-xl bg-surface-warm text-on-surface placeholder:text-secondary/60 font-body-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-container/30 border border-surface-variant/40">
        <button type="button" 
                id="clearSearch" 
                class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-secondary hover:text-on-surface text-[18px]">
            <span class="material-symbols-outlined text-[18px]">close</span>
        </button>
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
                });
                this.classList.remove('bg-surface-warm', 'text-on-surface');
                this.classList.add('bg-primary-container', 'text-on-primary');

                currentFilter = this.getAttribute('data-filter');
                filterProducts();
            });
        });

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                searchQuery = this.value.trim().toLowerCase();
                if (clearSearch) {
                    if (searchQuery.length > 0) {
                        clearSearch.classList.remove('hidden');
                    } else {
                        clearSearch.classList.add('hidden');
                    }
                }
                filterProducts();
            });
        }

        if (clearSearch) {
            clearSearch.addEventListener('click', function () {
                searchInput.value = '';
                searchQuery = '';
                this.classList.add('hidden');
                filterProducts();
            });
        }
    });
</script>
