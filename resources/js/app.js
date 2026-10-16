/**
 * Yan's Food — Public Web UX & Micro-interactions
 * Compliant with YANS-FOOD-WEB-UX-SPECIFICATION.md
 */

// 1. Progressive Enhancement Marker (§3.2)
document.documentElement.classList.add('js');

document.addEventListener('DOMContentLoaded', () => {
    initScrollReveal();
    initNavbarScroll();
    initMobileNav();
    initFloatingWA();
    initBackToTop();
});

// ==========================================================================
// 2. SCROLL REVEAL (IntersectionObserver Tunggal - §3.2)
// ==========================================================================
function initScrollReveal() {
    const revealElements = document.querySelectorAll('[data-reveal]');
    if (!revealElements.length) return;

    // Hormati prefers-reduced-motion
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReducedMotion) {
        revealElements.forEach(el => el.classList.add('is-revealed'));
        return;
    }

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                
                // Cek delay manual
                const delay = el.getAttribute('data-reveal-delay');
                if (delay) {
                    setTimeout(() => el.classList.add('is-revealed'), parseInt(delay, 10));
                } else {
                    el.classList.add('is-revealed');
                }
                
                obs.unobserve(el);
            }
        });
    }, {
        threshold: 0.15,
        rootMargin: '0px 0px -8% 0px'
    });

    revealElements.forEach(el => {
        // Abaikan elemen di atas lipatan layar saat pemuatan awal
        const rect = el.getBoundingClientRect();
        if (rect.top < window.innerHeight && rect.bottom > 0) {
            el.classList.add('is-revealed');
        } else {
            observer.observe(el);
        }
    });

    // Handle container data-reveal-group
    const groups = document.querySelectorAll('[data-reveal-group]');
    groups.forEach(group => {
        const children = group.children;
        Array.from(children).forEach((child, index) => {
            if (!child.hasAttribute('data-reveal')) {
                child.setAttribute('data-reveal', 'up');
            }
            if (!child.hasAttribute('data-reveal-delay')) {
                const stagger = Math.min(index, 6) * 60; // --stagger 60ms, max 6
                child.setAttribute('data-reveal-delay', stagger);
            }
            observer.observe(child);
        });
    });
}

// ==========================================================================
// 3. NAVBAR SCROLL BEHAVIOR (§3.4: Shrink & Hide on scroll down / Show on up)
// ==========================================================================
function initNavbarScroll() {
    const navbar = document.getElementById('main-navbar');
    if (!navbar) return;

    let lastScrollY = window.scrollY;
    let accumulatedDown = 0;
    let accumulatedUp = 0;
    let isHidden = false;

    window.addEventListener('scroll', () => {
        const currentScrollY = window.scrollY;
        const diff = currentScrollY - lastScrollY;

        // Shrink state (> 24px)
        if (currentScrollY > 24) {
            navbar.classList.add('is-shrunk');
        } else {
            navbar.classList.remove('is-shrunk');
        }

        // Hide on scroll down (> 120px cepat) / Show on scroll up (>= 8px)
        if (currentScrollY <= 80 || document.body.classList.contains('mobile-menu-open')) {
            // Selalu tampil jika di dekat atas halaman atau menu terbuka
            if (isHidden) {
                navbar.style.transform = 'translateY(0)';
                isHidden = false;
            }
            accumulatedDown = 0;
            accumulatedUp = 0;
        } else if (diff > 0) {
            // Scrolling down
            accumulatedUp = 0;
            accumulatedDown += diff;
            if (accumulatedDown > 120 && !isHidden) {
                navbar.style.transform = 'translateY(-100%)';
                isHidden = true;
            }
        } else {
            // Scrolling up
            accumulatedDown = 0;
            accumulatedUp += Math.abs(diff);
            if (accumulatedUp >= 8 && isHidden) {
                navbar.style.transform = 'translateY(0)';
                isHidden = false;
            }
        }

        lastScrollY = currentScrollY;
    }, { passive: true });
}

// ==========================================================================
// 4. MOBILE DRAWER OVERLAY (§3.4)
// ==========================================================================
function initMobileNav() {
    const toggleBtn = document.getElementById('mobile-menu-toggle');
    const drawer = document.getElementById('mobile-drawer');
    const backdrop = document.getElementById('mobile-nav-backdrop');
    const closeBtn = document.getElementById('mobile-drawer-close');

    if (!toggleBtn || !drawer || !backdrop) return;

    function openNav() {
        document.body.classList.add('mobile-menu-open', 'overflow-hidden');
        backdrop.classList.remove('opacity-0', 'pointer-events-none');
        backdrop.classList.add('opacity-100', 'pointer-events-auto');
        drawer.classList.remove('translate-x-full');
        drawer.classList.add('translate-x-0');
        toggleBtn.classList.add('is-active');
        toggleBtn.setAttribute('aria-expanded', 'true');
    }

    function closeNav() {
        document.body.classList.remove('mobile-menu-open', 'overflow-hidden');
        backdrop.classList.remove('opacity-100', 'pointer-events-auto');
        backdrop.classList.add('opacity-0', 'pointer-events-none');
        drawer.classList.remove('translate-x-0');
        drawer.classList.add('translate-x-full');
        toggleBtn.classList.remove('is-active');
        toggleBtn.setAttribute('aria-expanded', 'false');
    }

    toggleBtn.addEventListener('click', () => {
        const isOpen = document.body.classList.contains('mobile-menu-open');
        if (isOpen) closeNav(); else openNav();
    });

    if (closeBtn) closeBtn.addEventListener('click', closeNav);
    backdrop.addEventListener('click', closeNav);

    // Close on Escape key
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && document.body.classList.contains('mobile-menu-open')) {
            closeNav();
            toggleBtn.focus();
        }
    });

    // Close when tapping navigation link inside drawer
    drawer.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            closeNav();
        });
    });

    // Expose globally for inline buttons if needed
    window.openMobileNav = openNav;
    window.closeMobileNav = closeNav;
}

// ==========================================================================
// 5. FLOATING WHATSAPP CTA (§3.5)
// ==========================================================================
function initFloatingWA() {
    const waBtn = document.getElementById('floating-wa-btn');
    if (!waBtn) return;

    let hasPulsed = false;
    const cateringFormSection = document.getElementById('katering');

    window.addEventListener('scroll', () => {
        const scrollY = window.scrollY;

        // Hide in first 600px
        if (scrollY < 600) {
            waBtn.classList.add('opacity-0', 'pointer-events-none', 'translate-y-4');
            waBtn.classList.remove('opacity-100', 'pointer-events-auto', 'translate-y-0');
            return;
        }

        // Hide when catering form is actively in view (§3.5)
        if (cateringFormSection) {
            const rect = cateringFormSection.getBoundingClientRect();
            if (rect.top < window.innerHeight && rect.bottom > 0) {
                waBtn.classList.add('opacity-0', 'pointer-events-none', 'translate-y-4');
                waBtn.classList.remove('opacity-100', 'pointer-events-auto', 'translate-y-0');
                return;
            }
        }

        // Show button
        waBtn.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-4');
        waBtn.classList.add('opacity-100', 'pointer-events-auto', 'translate-y-0');

        // One-time gentle pulse (§3.5)
        if (!hasPulsed) {
            hasPulsed = true;
            waBtn.classList.add('animate-pulse');
            setTimeout(() => {
                waBtn.classList.remove('animate-pulse');
            }, 1200);
        }
    }, { passive: true });
}

// ==========================================================================
// 6. BACK TO TOP BUTTON (§3.4, M25)
// ==========================================================================
function initBackToTop() {
    const btn = document.getElementById('back-to-top-btn');
    if (!btn) return;

    window.addEventListener('scroll', () => {
        if (window.scrollY > window.innerHeight * 1.5) {
            btn.classList.remove('opacity-0', 'translate-y-6', 'pointer-events-none');
            btn.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
        } else {
            btn.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
            btn.classList.add('opacity-0', 'translate-y-6', 'pointer-events-none');
        }
    }, { passive: true });

    btn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

// ==========================================================================
// 7. TOAST NOTIFICATION SYSTEM (§3.6)
// ==========================================================================
window.showToast = function(message, type = 'status') {
    let toast = document.getElementById('toast-feedback');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'toast-feedback';
        toast.setAttribute('role', type === 'error' ? 'alert' : 'status');
        toast.setAttribute('aria-live', 'polite');
        toast.className = 'fixed bottom-6 left-1/2 -translate-x-1/2 sm:left-auto sm:right-6 sm:translate-x-0 z-50 transform translate-y-20 opacity-0 pointer-events-none transition-all duration-300 ease-out flex items-center gap-3 bg-stone-900 text-white px-5 py-3 rounded-2xl shadow-xl max-w-sm text-xs font-semibold border border-white/10';
        document.body.appendChild(toast);
    }

    toast.innerHTML = `
        <span class="text-amber-400 text-base">${type === 'error' ? '⚠️' : '✅'}</span>
        <span>${message}</span>
    `;

    toast.classList.remove('translate-y-20', 'opacity-0', 'pointer-events-none');
    toast.classList.add('translate-y-0', 'opacity-100', 'pointer-events-auto');

    clearTimeout(window._toastTimeout);
    window._toastTimeout = setTimeout(() => {
        toast.classList.remove('translate-y-0', 'opacity-100', 'pointer-events-auto');
        toast.classList.add('translate-y-20', 'opacity-0', 'pointer-events-none');
    }, 4000);
};

// Clipboard copy helper with toast (M23)
window.copyToClipboard = function(text, successMessage = 'Teks berhasil disalin!') {
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(() => {
            window.showToast(successMessage);
        }).catch(() => {
            fallbackCopyText(text, successMessage);
        });
    } else {
        fallbackCopyText(text, successMessage);
    }
};

function fallbackCopyText(text, successMessage) {
    const textArea = document.createElement('textarea');
    textArea.value = text;
    textArea.style.position = 'fixed';
    textArea.style.left = '-9999px';
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
        document.execCommand('copy');
        window.showToast(successMessage);
    } catch (err) {
        window.showToast('Gagal menyalin teks.', 'error');
    }
    document.body.removeChild(textArea);
}
