/**
 * Yan's Food — Hero Intro Sequence Sinematik (§3.3)
 * Menampilkan intro panggung kuliner yang berkesan, tenang, dan tidak terburu-buru
 */

export function initHeroIntro() {
    const heroSection = document.querySelector('[data-hero-section]');
    if (!heroSection) return;

    // Hormati preferensi aksesibilitas pengguna
    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReduced) {
        heroSection.querySelectorAll('.hero-photo-intro, [data-hero-step]').forEach(el => {
            el.classList.add('is-loaded', 'is-revealed');
        });
        return;
    }

    // 1. 150ms: Foto hero masuk megah berskala lembut (durasi 1200ms)
    setTimeout(() => {
        const photo = heroSection.querySelector('.hero-photo-intro');
        if (photo) photo.classList.add('is-loaded');
    }, 150);

    // 2. 350ms: Headline utama meluncur tenang dan berwibawa
    setTimeout(() => {
        const headline = heroSection.querySelector('[data-hero-step="headline"]');
        if (headline) headline.classList.add('is-revealed');
    }, 350);

    // 3. 650ms: Subheadline deskripsi resep otentik naik perlahan
    setTimeout(() => {
        const subheadline = heroSection.querySelector('[data-hero-step="subheadline"]');
        if (subheadline) subheadline.classList.add('is-revealed');
    }, 650);

    // 4. 950ms: Dua tombol CTA utama tampil elegan siap interaksi
    setTimeout(() => {
        const ctas = heroSection.querySelector('[data-hero-step="cta"]');
        if (ctas) ctas.classList.add('is-revealed');
    }, 950);

    // 5. 1300ms: Floating badges & scroll indicator muncul santai memandu pengunjung
    setTimeout(() => {
        const badges = heroSection.querySelectorAll('[data-hero-step="badge"]');
        badges.forEach((b, idx) => {
            setTimeout(() => b.classList.add('is-revealed'), idx * 150);
        });

        const scrollIndicator = heroSection.querySelector('[data-hero-step="scroll-indicator"]');
        if (scrollIndicator) scrollIndicator.classList.add('is-revealed');
    }, 1300);
}
