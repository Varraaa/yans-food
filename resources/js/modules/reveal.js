/**
 * Yan's Food — Scroll Reveal via IntersectionObserver Sinematik & Halus (§3.2)
 * Memberikan pengalaman visual yang tenang, megah, dan memukau saat scrolling
 */

export function initScrollReveal() {
    const revealElements = document.querySelectorAll('[data-reveal]');
    const groupContainers = document.querySelectorAll('[data-reveal-group]');

    if (!revealElements.length && !groupContainers.length) return;

    // 1. Hormati preferensi aksesibilitas pengguna (prefers-reduced-motion)
    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReduced) {
        revealElements.forEach(el => el.classList.add('is-revealed', 'is-visible'));
        groupContainers.forEach(group => {
            Array.from(group.children).forEach(child => child.classList.add('is-revealed', 'is-visible'));
        });
        return;
    }

    // 2. Setup IntersectionObserver dengan viewport threshold yang presisi
    // rootMargin negatif (-30px) memastikan animasi baru mulai saat elemen sudah masuk pandangan pengguna
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
                    // Beri micro-delay alami agar browser sempat merender frame awal
                    requestAnimationFrame(() => {
                        el.classList.add('is-revealed', 'is-visible');
                    });
                }

                // Unobserve setelah animasi terpicu untuk performa 60fps yang ringan
                obs.unobserve(el);
            }
        });
    }, {
        threshold: 0.12,
        rootMargin: '0px 0px -30px 0px'
    });

    // 3. Elemen data-reveal individual
    revealElements.forEach(el => {
        const rect = el.getBoundingClientRect();
        // Jika elemen berada di viewport awal saat load, beri stagger awal yang lembut
        if (rect.top < window.innerHeight && rect.bottom > 60) {
            const initialDelay = el.getAttribute('data-reveal-delay') || 100;
            setTimeout(() => {
                el.classList.add('is-revealed', 'is-visible');
            }, parseInt(initialDelay, 10));
        } else {
            observer.observe(el);
        }
    });

    // 4. Container data-reveal-group dengan stagger berjenjang yang memukau
    groupContainers.forEach(group => {
        const children = group.children;
        const baseStagger = parseInt(group.getAttribute('data-stagger') || '120', 10);

        Array.from(children).forEach((child, index) => {
            if (!child.hasAttribute('data-reveal')) {
                child.setAttribute('data-reveal', 'up');
            }
            if (!child.hasAttribute('data-reveal-delay')) {
                // Jeda bertingkat 120ms per item (maksimal 8 kartu dalam 1 gelombang)
                const staggerDelay = Math.min(index, 8) * baseStagger;
                child.setAttribute('data-reveal-delay', staggerDelay);
            }

            const rect = child.getBoundingClientRect();
            if (rect.top < window.innerHeight && rect.bottom > 60) {
                const initialDelay = parseInt(child.getAttribute('data-reveal-delay'), 10) || (index * 80);
                setTimeout(() => {
                    child.classList.add('is-revealed', 'is-visible');
                }, initialDelay + 120);
            } else {
                observer.observe(child);
            }
        });
    });
}
