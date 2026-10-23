/**
 * Yan's Food — Product Detail Modal & Mobile Bottom Sheet (§5.3, M19–M20)
 * Deep linking, Web Share API, WhatsApp prefilled, keyboard & swipe navigation.
 */
export function initProductModal() {
    const backdrop = document.getElementById('product-modal-backdrop');
    if (!backdrop) return;

    const dialog = backdrop.querySelector('.product-modal-dialog');
    const closeButtons = backdrop.querySelectorAll('[data-close-product-modal]');
    const imgEl = document.getElementById('modal-product-img');
    const catEl = document.getElementById('modal-product-cat');
    const titleEl = document.getElementById('modal-product-title');
    const statusEl = document.getElementById('modal-product-status');
    const priceEl = document.getElementById('modal-product-price');
    const unitEl = document.getElementById('modal-product-unit');
    const descEl = document.getElementById('modal-product-desc');
    const platformActionBtn = document.getElementById('modal-action-platform');
    const waActionBtn = document.getElementById('modal-action-wa');
    const shareBtn = document.getElementById('modal-btn-share');
    const prevBtn = document.getElementById('modal-btn-prev');
    const nextBtn = document.getElementById('modal-btn-next');
    const counterEl = document.getElementById('modal-product-counter');

    let currentCardIndex = -1;
    let visibleCards = [];
    let lastActiveElement = null;

    // 1. Open modal with specific card element
    function openModalWithCard(card) {
        if (!card) return;

        // Remember element for returning focus (M20)
        lastActiveElement = card;

        // Collect currently visible cards in the catalog
        visibleCards = Array.from(document.querySelectorAll('.card-product:not(.hidden)'));
        currentCardIndex = visibleCards.indexOf(card);

        populateModalData(card);

        backdrop.classList.add('is-open');
        backdrop.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-scroll-lock');

        // Update URL hash for deep linking
        const slug = card.getAttribute('data-slug') || '';
        if (slug) {
            window.history.replaceState({}, '', `#produk-${slug}`);
        }

        // Focus close button or first interactive element
        setTimeout(() => {
            const firstInteractive = backdrop.querySelector('button:not([disabled]), a:not([disabled])');
            if (firstInteractive) firstInteractive.focus();
        }, 100);
    }

    // 2. Populate modal content from card data attributes
    function populateModalData(card) {
        const title = card.getAttribute('data-title') || card.querySelector('h3')?.textContent?.trim() || card.getAttribute('data-name') || '';
        const price = card.getAttribute('data-price-formatted') || card.getAttribute('data-price') || '';
        const unit = card.getAttribute('data-unit') || '/ pcs';
        const category = card.getAttribute('data-category-name') || card.getAttribute('data-category') || '';
        const image = card.getAttribute('data-image') || '';
        const desc = card.getAttribute('data-desc') || '';
        const isAvailable = card.getAttribute('data-available') === '1';

        if (titleEl) titleEl.textContent = title;
        if (priceEl) priceEl.textContent = `Rp ${price}`;
        if (unitEl) unitEl.textContent = unit;
        if (catEl) catEl.textContent = category;
        if (descEl) descEl.textContent = desc;

        if (imgEl) {
            imgEl.src = image;
            imgEl.alt = title;
        }

        // Status badge
        if (statusEl) {
            if (isAvailable) {
                statusEl.className = 'px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-label-sm text-xs font-semibold inline-flex items-center gap-1.5';
                statusEl.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Sedia';
            } else {
                statusEl.className = 'px-3 py-1 rounded-full bg-surface-container text-secondary font-label-sm text-xs font-semibold inline-flex items-center gap-1.5';
                statusEl.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-outline"></span> Sedang Tidak Tersedia';
            }
        }

        // Actions configuration (§5.3 points 346–348)
        const adminWA = "6282221222936";
        const waMsg = encodeURIComponent(`Halo Kak, saya ingin pesan *${title}* apakah masih ready stok nya kak ?`);
        if (isAvailable) {
            if (platformActionBtn) {
                platformActionBtn.classList.remove('hidden');
                platformActionBtn.href = '/pesan#online';
            }
            if (waActionBtn) {
                waActionBtn.href = `https://wa.me/${adminWA}?text=${waMsg}`;
                waActionBtn.innerHTML = '<span class="material-symbols-outlined text-[18px]">chat</span><span>Tanya via WhatsApp</span>';
            }
        } else {
            if (platformActionBtn) {
                platformActionBtn.classList.add('hidden');
            }
            if (waActionBtn) {
                waActionBtn.href = `https://wa.me/${adminWA}?text=${waMsg}`;
                waActionBtn.innerHTML = '<span class="material-symbols-outlined text-[18px]">chat</span><span>Tanya via WhatsApp</span>';
            }
        }

        // Share button configuration
        if (shareBtn) {
            shareBtn.onclick = () => {
                const shareUrl = window.location.href;
                const shareTitle = `${title} — Yan's Food`;
                const shareText = `Lihat lezatnya ${title} di Yan's Food: ${desc}`;

                if (navigator.share) {
                    navigator.share({
                        title: shareTitle,
                        text: shareText,
                        url: shareUrl,
                    }).catch(() => {});
                } else if (window.copyToClipboard) {
                    window.copyToClipboard(shareUrl, 'Tautan menu disalin ke clipboard!');
                }
            };
        }

        // Counter display
        if (counterEl && visibleCards.length > 0) {
            counterEl.textContent = `${currentCardIndex + 1} / ${visibleCards.length}`;
        }

        // Prev / Next button states
        if (prevBtn) prevBtn.disabled = currentCardIndex <= 0;
        if (nextBtn) nextBtn.disabled = currentCardIndex >= visibleCards.length - 1;
    }

    // 3. Navigation inside modal (Prev / Next)
    function goToCard(index) {
        if (index < 0 || index >= visibleCards.length) return;
        currentCardIndex = index;
        const card = visibleCards[currentCardIndex];
        populateModalData(card);
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', () => goToCard(currentCardIndex - 1));
    }
    if (nextBtn) {
        nextBtn.addEventListener('click', () => goToCard(currentCardIndex + 1));
    }

    // 4. Close modal
    function closeModal() {
        backdrop.classList.remove('is-open');
        backdrop.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-scroll-lock');

        // Remove hash from URL without scrolling
        if (window.location.hash.startsWith('#produk-')) {
            window.history.replaceState({}, '', window.location.pathname + window.location.search);
        }

        // Return focus to triggering card (M20)
        if (lastActiveElement && typeof lastActiveElement.focus === 'function') {
            lastActiveElement.focus();
        }
    }

    closeButtons.forEach(btn => {
        btn.addEventListener('click', closeModal);
    });

    // Close on backdrop click (outside dialog)
    backdrop.addEventListener('click', (e) => {
        if (e.target === backdrop) {
            closeModal();
        }
    });

    // Keyboard support: Escape to close, ArrowLeft / ArrowRight to navigate
    document.addEventListener('keydown', (e) => {
        if (!backdrop.classList.contains('is-open')) return;

        if (e.key === 'Escape') {
            closeModal();
        } else if (e.key === 'ArrowLeft') {
            goToCard(currentCardIndex - 1);
        } else if (e.key === 'ArrowRight') {
            goToCard(currentCardIndex + 1);
        }
    });

    // 5. Mobile swipe-down to dismiss (< 768px)
    let touchStartY = 0;
    let touchMoveY = 0;
    if (dialog) {
        dialog.addEventListener('touchstart', (e) => {
            touchStartY = e.touches[0].clientY;
            touchMoveY = touchStartY;
        }, { passive: true });

        dialog.addEventListener('touchmove', (e) => {
            touchMoveY = e.touches[0].clientY;
            const diff = touchMoveY - touchStartY;
            // Only drag downwards if scroll is at top
            if (diff > 0 && dialog.scrollTop <= 0) {
                dialog.style.transform = `translateY(${diff}px)`;
            }
        }, { passive: true });

        dialog.addEventListener('touchend', () => {
            const diff = touchMoveY - touchStartY;
            if (diff > 90 && dialog.scrollTop <= 0) {
                dialog.style.transform = '';
                closeModal();
            } else {
                dialog.style.transform = '';
            }
            touchStartY = 0;
            touchMoveY = 0;
        });
    }

    // 6. Delegate card clicks across document
    document.addEventListener('click', (e) => {
        const card = e.target.closest('.card-product');
        if (card) {
            e.preventDefault();
            openModalWithCard(card);
        }
    });

    // 7. Check for deep link on load (#produk-slug or ?produk=slug)
    const hash = window.location.hash;
    const urlParams = new URLSearchParams(window.location.search);
    const targetSlug = hash.startsWith('#produk-') ? hash.replace('#produk-', '') : urlParams.get('produk');

    if (targetSlug) {
        setTimeout(() => {
            const matchingCard = document.querySelector(`.card-product[data-slug="${targetSlug}"]`);
            if (matchingCard) {
                openModalWithCard(matchingCard);
            }
        }, 150);
    }
}
