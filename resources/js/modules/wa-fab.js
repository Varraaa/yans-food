/**
 * Yan's Food — Floating WhatsApp Button (§3.5)
 * Compliant with YANS-FOOD-WEB-UX-SPECIFICATION.md
 */

export function initFloatingWA() {
    const waBtn = document.getElementById('floating-wa-btn');
    if (!waBtn) return;

    let hasPulsed = false;
    const cateringForm = document.getElementById('katering') || document.querySelector('[data-catering-section]');

    function onScroll() {
        const scrollY = window.scrollY;

        // 1. Sembunyikan di 600px pertama (§3.5)
        if (scrollY < 600) {
            waBtn.classList.remove('is-visible');
            return;
        }

        // 2. Sembunyikan saat form katering sedang tampil aktif di viewport (§3.5)
        if (cateringForm) {
            const rect = cateringForm.getBoundingClientRect();
            if (rect.top < window.innerHeight && rect.bottom > 0) {
                waBtn.classList.remove('is-visible');
                return;
            }
        }

        // 3. Tampilkan tombol
        waBtn.classList.add('is-visible');

        // 4. Satu kali pulse lembut saat pertama kali muncul (§3.5)
        if (!hasPulsed) {
            hasPulsed = true;
            const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            if (!prefersReduced) {
                waBtn.classList.add('pulse-once');
                setTimeout(() => {
                    waBtn.classList.remove('pulse-once');
                }, 1100);
            }
        }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
}
