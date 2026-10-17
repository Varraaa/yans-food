/**
 * Yan's Food — Hero Intro Sequence (§3.3)
 * Compliant with YANS-FOOD-WEB-UX-SPECIFICATION.md
 */

export function initHeroIntro() {
    const heroSection = document.querySelector('[data-hero-section]');
    if (!heroSection) return;

    // Hormati prefers-reduced-motion (§3.1)
    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReduced) {
        heroSection.querySelectorAll('.hero-photo-intro, [data-hero-step]').forEach(el => {
            el.classList.add('is-loaded', 'is-revealed');
        });
        return;
    }

    // 1. 100ms: foto hero fade-in + skala 1.06 -> 1 (900ms)
    setTimeout(() => {
        const photo = heroSection.querySelector('.hero-photo-intro');
        if (photo) photo.classList.add('is-loaded');
    }, 100);

    // 2. 150ms: headline masuk
    setTimeout(() => {
        const headline = heroSection.querySelector('[data-hero-step="headline"]');
        if (headline) headline.classList.add('is-revealed');
    }, 150);

    // 3. 400ms: subheadline fade-up
    setTimeout(() => {
        const subheadline = heroSection.querySelector('[data-hero-step="subheadline"]');
        if (subheadline) subheadline.classList.add('is-revealed');
    }, 400);

    // 4. 520ms: dua tombol CTA fade-up
    setTimeout(() => {
        const ctas = heroSection.querySelector('[data-hero-step="cta"]');
        if (ctas) ctas.classList.add('is-revealed');
    }, 520);

    // 5. 800ms: scroll indicator fade-in
    setTimeout(() => {
        const scrollIndicator = heroSection.querySelector('[data-hero-step="scroll-indicator"]');
        if (scrollIndicator) scrollIndicator.classList.add('is-revealed');
    }, 800);
}
