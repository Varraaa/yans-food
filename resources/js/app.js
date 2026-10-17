/**
 * Yan's Food — Main Application Script
 * Compliant with YANS-FOOD-WEB-UX-SPECIFICATION.md
 */

import { initScrollReveal } from './modules/reveal.js';
import { initNavbar } from './modules/navbar.js';
import { initHeroIntro } from './modules/hero-intro.js';
import { initFloatingWA } from './modules/wa-fab.js';
import { initToast } from './modules/toast.js';
import { initScrollProgress } from './modules/scroll-progress.js';
import { initOperatingHours } from './modules/operating-hours.js';
import { initOrderSuccess } from './modules/order-success.js';
import { initContactPage } from './modules/contact.js';
import { initMenuCatalog } from './modules/menu-catalog.js';
import { initProductModal } from './modules/product-modal.js';
import { initPesanIntent } from './modules/pesan-intent.js';
import { initAccordions } from './modules/accordion.js';
import { initCateringForm } from './modules/catering-form.js';
import { initLightbox } from './modules/lightbox.js';
import { initAnalytics } from './modules/analytics.js';

// 1. Progressive Enhancement Marker (§3.2)
document.documentElement.classList.add('js');

// 2. Initialize UX Modules on DOM Ready
document.addEventListener('DOMContentLoaded', () => {
    initAnalytics();
    initScrollReveal();
    initNavbar();
    initHeroIntro();
    initFloatingWA();
    initToast();
    initScrollProgress();
    initOperatingHours();
    initOrderSuccess();
    initContactPage();
    initMenuCatalog();
    initProductModal();
    initPesanIntent();
    initAccordions();
    initCateringForm();
    initLightbox();
    initBackToTopButton();
});

// 3. Back to Top Button (§3.4, M25)
function initBackToTopButton() {
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

// 4. Global Add to Cart & Storage Helper
window.addToCart = function(title, price, category = 'Makanan') {
    let cart = JSON.parse(localStorage.getItem('yans_cart') || '[]');
    const numericPrice = typeof price === 'number' ? price : parseInt(String(price).replace(/[^0-9]/g, ''), 10) || 0;
    const existing = cart.find(item => item.title === title);

    if (existing) {
        existing.qty += 1;
    } else {
        cart.push({ title, price: numericPrice, category, qty: 1 });
    }

    localStorage.setItem('yans_cart', JSON.stringify(cart));
    if (typeof window.updateCartBadge === 'function') {
        window.updateCartBadge();
    }
    if (typeof window.showToast === 'function') {
        window.showToast(`${title} ditambahkan ke pesanan!`);
    }
};
