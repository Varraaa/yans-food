/**
 * Yan's Food — Menu Catalog Filter, Search, & URL Sync (§5.3, M11, M12)
 * Pure vanilla JS, zero dependencies, progressive enhancement.
 */
export function initMenuCatalog() {
    const catalogGrid = document.getElementById('productGrid');
    if (!catalogGrid) return;

    const chips = Array.from(document.querySelectorAll('[data-filter-chip]'));
    const searchInput = document.getElementById('menuSearchInput');
    const clearSearchBtn = document.getElementById('menuClearSearchBtn');
    const availableToggle = document.getElementById('menuAvailableToggle');
    const sortSelect = document.getElementById('menuSortSelect');
    const emptyState = document.getElementById('menuEmptyState');
    const emptySearchQuery = document.getElementById('emptySearchQuery');
    const resetFilterBtn = document.getElementById('menuResetFilterBtn');
    const countBadge = document.getElementById('menuResultsCount');
    const loadMoreBtn = document.getElementById('menuLoadMoreBtn');

    // Get all initial product cards
    const allCards = Array.from(catalogGrid.querySelectorAll('.card-product'));
    if (allCards.length === 0) return;

    // State management
    const state = {
        category: 'all',
        query: '',
        availableOnly: false,
        sort: 'recommended',
        visibleLimit: 24,
    };

    // 1. Read initial state from URL & sessionStorage
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('kategori')) {
        state.category = urlParams.get('kategori').toLowerCase();
    }
    if (urlParams.has('q')) {
        state.query = urlParams.get('q').trim();
        if (searchInput) searchInput.value = state.query;
    }
    if (urlParams.has('tersedia')) {
        state.availableOnly = urlParams.get('tersedia') === '1';
    } else {
        const savedAvailable = sessionStorage.getItem('yf_filter_available');
        if (savedAvailable !== null) {
            state.availableOnly = savedAvailable === '1';
        }
    }
    if (urlParams.has('sort')) {
        state.sort = urlParams.get('sort');
        if (sortSelect) sortSelect.value = state.sort;
    }

    if (availableToggle) {
        availableToggle.checked = state.availableOnly;
    }

    // 2. Synchronize URL without reloading
    function syncUrl() {
        const params = new URLSearchParams();
        if (state.category && state.category !== 'all') {
            params.set('kategori', state.category);
        }
        if (state.query) {
            params.set('q', state.query);
        }
        if (state.availableOnly) {
            params.set('tersedia', '1');
        }
        if (state.sort && state.sort !== 'recommended') {
            params.set('sort', state.sort);
        }

        const newQuery = params.toString();
        const newUrl = newQuery ? `${window.location.pathname}?${newQuery}` : window.location.pathname;
        window.history.replaceState({}, '', newUrl);
    }

    // 3. Filter and Sort execution
    function applyFilters() {
        // Keep height stable during transition (M12)
        const currentHeight = catalogGrid.offsetHeight;
        if (currentHeight > 0) {
            catalogGrid.style.minHeight = `${currentHeight}px`;
        }

        let matched = allCards.filter(card => {
            // Category check
            const cat = card.getAttribute('data-category') || '';
            const matchCategory = (state.category === 'all') || (cat === state.category);

            // Search query check
            const name = (card.getAttribute('data-name') || '').toLowerCase();
            const desc = (card.getAttribute('data-desc') || '').toLowerCase();
            const q = state.query.toLowerCase();
            const matchQuery = !q || name.includes(q) || desc.includes(q);

            // Availability check
            const isAvailable = card.getAttribute('data-available') === '1';
            const matchAvailable = !state.availableOnly || isAvailable;

            return matchCategory && matchQuery && matchAvailable;
        });

        // Sorting
        if (state.sort === 'price-low') {
            matched.sort((a, b) => Number(a.getAttribute('data-price') || 0) - Number(b.getAttribute('data-price') || 0));
        } else if (state.sort === 'price-high') {
            matched.sort((a, b) => Number(b.getAttribute('data-price') || 0) - Number(a.getAttribute('data-price') || 0));
        } else if (state.sort === 'name-az') {
            matched.sort((a, b) => (a.getAttribute('data-name') || '').localeCompare(b.getAttribute('data-name') || ''));
        }

        // DOM update
        allCards.forEach(card => {
            card.classList.add('hidden');
            card.classList.remove('is-revealed');
        });

        const toShow = matched.slice(0, state.visibleLimit);
        toShow.forEach((card, idx) => {
            card.classList.remove('hidden');
            // Stagger entrance (M12)
            setTimeout(() => {
                card.classList.add('is-revealed');
            }, Math.min(idx * 40, 320));
            catalogGrid.appendChild(card);
        });

        // Release min-height
        setTimeout(() => {
            catalogGrid.style.minHeight = '';
        }, 360);

        // Update count badge
        if (countBadge) {
            countBadge.textContent = `${matched.length} menu`;
        }

        // Update active chip UI
        chips.forEach(chip => {
            const filterVal = chip.getAttribute('data-filter-chip');
            if (filterVal === state.category) {
                chip.classList.add('is-active');
                chip.setAttribute('aria-selected', 'true');
            } else {
                chip.classList.remove('is-active');
                chip.setAttribute('aria-selected', 'false');
            }
        });

        // Search clear button visibility
        if (clearSearchBtn) {
            if (state.query) {
                clearSearchBtn.classList.remove('hidden');
            } else {
                clearSearchBtn.classList.add('hidden');
            }
        }

        // Empty state
        if (emptyState) {
            if (matched.length === 0) {
                emptyState.classList.remove('hidden');
                if (emptySearchQuery) {
                    emptySearchQuery.textContent = state.query ? `"${state.query}"` : 'filter yang dipilih';
                }
            } else {
                emptyState.classList.add('hidden');
            }
        }

        // Load more button
        if (loadMoreBtn) {
            if (matched.length > state.visibleLimit) {
                loadMoreBtn.classList.remove('hidden');
            } else {
                loadMoreBtn.classList.add('hidden');
            }
        }

        syncUrl();
    }

    // 4. Attach Event Listeners
    // Chips click
    chips.forEach(chip => {
        chip.addEventListener('click', () => {
            state.category = chip.getAttribute('data-filter-chip') || 'all';
            state.visibleLimit = 24;
            applyFilters();
        });
    });

    // Search input (debounce 250ms)
    let searchDebounceTimer = null;
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            clearTimeout(searchDebounceTimer);
            searchDebounceTimer = setTimeout(() => {
                state.query = e.target.value.trim();
                state.visibleLimit = 24;
                applyFilters();
            }, 250);
        });
    }

    // Clear search
    if (clearSearchBtn && searchInput) {
        clearSearchBtn.addEventListener('click', () => {
            searchInput.value = '';
            state.query = '';
            state.visibleLimit = 24;
            applyFilters();
            searchInput.focus();
        });
    }

    // Availability toggle
    if (availableToggle) {
        availableToggle.addEventListener('change', (e) => {
            state.availableOnly = e.target.checked;
            sessionStorage.setItem('yf_filter_available', state.availableOnly ? '1' : '0');
            state.visibleLimit = 24;
            applyFilters();
        });
    }

    // Sort select
    if (sortSelect) {
        sortSelect.addEventListener('change', (e) => {
            state.sort = e.target.value;
            applyFilters();
        });
    }

    // Reset filter
    if (resetFilterBtn) {
        resetFilterBtn.addEventListener('click', () => {
            state.category = 'all';
            state.query = '';
            state.availableOnly = false;
            state.sort = 'recommended';
            state.visibleLimit = 24;
            if (searchInput) searchInput.value = '';
            if (availableToggle) availableToggle.checked = false;
            if (sortSelect) sortSelect.value = 'recommended';
            sessionStorage.removeItem('yf_filter_available');
            applyFilters();
        });
    }

    // Load more
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', () => {
            state.visibleLimit += 12;
            applyFilters();
        });
    }

    // Initial run
    applyFilters();
}
