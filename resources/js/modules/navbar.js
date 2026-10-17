/**
 * Yan's Food — Navbar & Mobile Overlay Interaction (§3.4)
 * Compliant with YANS-FOOD-WEB-UX-SPECIFICATION.md
 */

export function initNavbar() {
    const navbar = document.getElementById('main-navbar');
    if (!navbar) return;

    initDesktopNavbar(navbar);
    initMobileOverlay();
}

/**
 * 1. Desktop Navbar: Shrink & Sliding Active Link Indicator (§3.4)
 */
function initDesktopNavbar(navbar) {
    // Scroll Shrink State (> 24px)
    function onScroll() {
        const scrollY = window.scrollY;
        if (scrollY > 24) {
            navbar.classList.add('is-shrunk');
        } else {
            navbar.classList.remove('is-shrunk');
        }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    // Sliding Underline Indicator (§3.4)
    const navWrap = navbar.querySelector('.desktop-nav-wrap');
    const indicator = navbar.querySelector('.nav-slider-indicator');
    const links = navbar.querySelectorAll('.desktop-nav-link');

    if (!navWrap || !indicator || !links.length) return;

    let activeLink = navbar.querySelector('.desktop-nav-link.is-active') || links[0];

    function positionIndicator(target) {
        if (!target) {
            indicator.style.opacity = '0';
            return;
        }
        const navRect = navWrap.getBoundingClientRect();
        const targetRect = target.getBoundingClientRect();
        const left = targetRect.left - navRect.left;
        const width = targetRect.width;

        indicator.style.left = `${left + 10}px`;
        indicator.style.width = `${Math.max(16, width - 20)}px`;
        indicator.style.opacity = '1';
    }

    // Set initial position
    positionIndicator(activeLink);

    links.forEach(link => {
        link.addEventListener('mouseenter', () => positionIndicator(link));
        link.addEventListener('focus', () => positionIndicator(link));
    });

    navWrap.addEventListener('mouseleave', () => positionIndicator(activeLink));
    window.addEventListener('resize', () => positionIndicator(activeLink), { passive: true });
}

/**
 * 2. Mobile Fullscreen Overlay with Hamburger Morph & Focus Trap (§3.4)
 */
function initMobileOverlay() {
    const toggleBtn = document.getElementById('mobile-menu-toggle');
    const overlay = document.getElementById('mobile-nav-overlay');
    const closeBtn = document.getElementById('mobile-menu-close');

    if (!toggleBtn || !overlay) return;

    const focusableSelectors = 'a[href], button:not([disabled]), [tabindex]:not([tabindex="-1"])';
    let previousActiveElement = null;

    function openOverlay() {
        previousActiveElement = document.activeElement;
        document.body.classList.add('overflow-hidden');
        overlay.classList.add('is-open');
        toggleBtn.classList.add('is-active');
        toggleBtn.setAttribute('aria-expanded', 'true');

        // Focus trap: fokus ke link pertama
        const focusableElements = overlay.querySelectorAll(focusableSelectors);
        if (focusableElements.length) {
            setTimeout(() => focusableElements[0].focus(), 100);
        }
    }

    function closeOverlay() {
        document.body.classList.remove('overflow-hidden');
        overlay.classList.remove('is-open');
        toggleBtn.classList.remove('is-active');
        toggleBtn.setAttribute('aria-expanded', 'false');

        // Kembalikan fokus ke tombol pemicu (§3.4)
        if (previousActiveElement && typeof previousActiveElement.focus === 'function') {
            previousActiveElement.focus();
        }
    }

    toggleBtn.addEventListener('click', () => {
        const isOpen = overlay.classList.contains('is-open');
        if (isOpen) {
            closeOverlay();
        } else {
            openOverlay();
        }
    });

    if (closeBtn) {
        closeBtn.addEventListener('click', closeOverlay);
    }

    // Tutup saat menekan tombol Escape (§3.4)
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && overlay.classList.contains('is-open')) {
            closeOverlay();
        }
    });

    // Keyboard Tab Trap di dalam overlay (§9, §3.4)
    overlay.addEventListener('keydown', (e) => {
        if (e.key !== 'Tab') return;

        const focusables = Array.from(overlay.querySelectorAll(focusableSelectors));
        if (!focusables.length) return;

        const first = focusables[0];
        const last = focusables[focusables.length - 1];

        if (e.shiftKey) {
            if (document.activeElement === first) {
                e.preventDefault();
                last.focus();
            }
        } else {
            if (document.activeElement === last) {
                e.preventDefault();
                first.focus();
            }
        }
    });

    // Tutup saat tap link di dalam overlay (§3.4)
    overlay.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', closeOverlay);
    });

    // Expose secara global jika dibutuhkan
    window.openMobileNav = openOverlay;
    window.closeMobileNav = closeOverlay;
}
