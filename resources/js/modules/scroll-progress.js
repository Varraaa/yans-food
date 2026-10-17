/**
 * Yan's Food — Scroll Progress & Back To Top (§3.3, M26)
 * Compliant with YANS-FOOD-WEB-UX-SPECIFICATION.md
 */

export function initScrollProgress() {
    const progressBar = document.getElementById('scroll-progress-bar');
    const backToTopBtn = document.getElementById('back-to-top-btn');

    if (backToTopBtn) {
        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    window.addEventListener('scroll', () => {
        const winScroll = document.documentElement.scrollTop || document.body.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;

        if (progressBar) {
            const scrolled = height > 0 ? (winScroll / height) * 100 : 0;
            progressBar.style.width = scrolled + '%';
        }

        if (backToTopBtn) {
            if (winScroll > 250) {
                backToTopBtn.classList.remove('opacity-0', 'translate-y-6', 'pointer-events-none');
                backToTopBtn.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
            } else {
                backToTopBtn.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
                backToTopBtn.classList.add('opacity-0', 'translate-y-6', 'pointer-events-none');
            }
        }
    }, { passive: true });
}
