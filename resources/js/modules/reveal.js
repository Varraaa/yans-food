/**
 * Yan's Food — Scroll Reveal via Single IntersectionObserver (§3.2)
 * Compliant with YANS-FOOD-WEB-UX-SPECIFICATION.md
 */

export function initScrollReveal() {
    const revealElements = document.querySelectorAll('[data-reveal]');
    const groupContainers = document.querySelectorAll('[data-reveal-group]');

    if (!revealElements.length && !groupContainers.length) return;

    // 1. Hormati prefers-reduced-motion (§3.1, §9)
    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReduced) {
        revealElements.forEach(el => el.classList.add('is-revealed', 'is-visible'));
        groupContainers.forEach(group => {
            Array.from(group.children).forEach(child => child.classList.add('is-revealed', 'is-visible'));
        });
        return;
    }

    // 2. Setup Single IntersectionObserver
    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const delay = el.getAttribute('data-reveal-delay');

                if (delay) {
                    setTimeout(() => {
                        el.classList.add('is-revealed', 'is-visible');
                    }, parseInt(delay, 10));
                } else {
                    el.classList.add('is-revealed', 'is-visible');
                }

                // Hanya animasi sekali (§3.2)
                obs.unobserve(el);
            }
        });
    }, {
        threshold: 0.15,
        rootMargin: '0px 0px -8% 0px'
    });

    // 3. Elemen data-reveal individual
    revealElements.forEach(el => {
        const rect = el.getBoundingClientRect();
        // Elemen di atas lipatan layar saat pemuatan langsung tampil
        if (rect.top < window.innerHeight && rect.bottom > 0) {
            el.classList.add('is-revealed', 'is-visible');
        } else {
            observer.observe(el);
        }
    });

    // 4. Container data-reveal-group dengan stagger otomatis (§3.1, §3.2)
    groupContainers.forEach(group => {
        const children = group.children;
        Array.from(children).forEach((child, index) => {
            if (!child.hasAttribute('data-reveal')) {
                child.setAttribute('data-reveal', 'up');
            }
            if (!child.hasAttribute('data-reveal-delay')) {
                // --stagger: 60ms, max 6 (§3.1)
                const staggerDelay = Math.min(index, 6) * 60;
                child.setAttribute('data-reveal-delay', staggerDelay);
            }

            const rect = child.getBoundingClientRect();
            if (rect.top < window.innerHeight && rect.bottom > 0) {
                child.classList.add('is-revealed', 'is-visible');
            } else {
                observer.observe(child);
            }
        });
    });
}
