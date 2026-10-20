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
import { initContactPage } from './modules/contact.js';
import { initMenuCatalog } from './modules/menu-catalog.js';
import { initProductModal } from './modules/product-modal.js';
import { initPesanIntent } from './modules/pesan-intent.js';
import { initAccordions } from './modules/accordion.js';
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
    initContactPage();
    initMenuCatalog();
    initProductModal();
    initPesanIntent();
    initAccordions();
    initLightbox();
});
