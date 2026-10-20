/**
 * Yan's Food — Floating WhatsApp Button
 */

export function initFloatingWA() {
    const waBtn = document.getElementById('floating-wa-btn');
    if (!waBtn) return;

    let hasPulsed = false;

    function onScroll() {
        const scrollY = window.scrollY;

        // 1. Sembunyikan di 600px pertama
        if (scrollY < 600) {
            waBtn.classList.remove('is-visible');
            return;
        }

        // 2. Tampilkan tombol
        waBtn.classList.add('is-visible');

        // 3. Satu kali pulse lembut saat pertama kali muncul
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
