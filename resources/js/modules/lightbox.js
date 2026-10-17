/**
 * Yan's Food — Image Lightbox Module (M27)
 * Compliant with YANS-FOOD-WEB-UX-SPECIFICATION.md §5.2, M27
 */

export function initLightbox() {
    const lightboxModal = document.getElementById('gallery-lightbox');
    if (!lightboxModal) return;

    const lightboxImg = lightboxModal.querySelector('#lightbox-image');
    const lightboxCaption = lightboxModal.querySelector('#lightbox-caption');
    const closeBtn = lightboxModal.querySelector('#lightbox-close-btn');

    function openLightbox(src, caption) {
        if (!lightboxImg) return;
        lightboxImg.src = src;
        if (lightboxCaption) lightboxCaption.textContent = caption || '';
        lightboxModal.classList.remove('hidden');
        lightboxModal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        lightboxModal.classList.add('hidden');
        lightboxModal.classList.remove('flex');
        document.body.style.overflow = '';
        if (lightboxImg) lightboxImg.src = '';
    }

    // Attach click to all trigger elements
    document.querySelectorAll('[data-lightbox-src]').forEach(trigger => {
        trigger.addEventListener('click', (e) => {
            e.preventDefault();
            const src = trigger.getAttribute('data-lightbox-src');
            const caption = trigger.getAttribute('data-lightbox-caption') || '';
            openLightbox(src, caption);
        });
    });

    if (closeBtn) {
        closeBtn.addEventListener('click', closeLightbox);
    }

    lightboxModal.addEventListener('click', (e) => {
        if (e.target === lightboxModal) {
            closeLightbox();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !lightboxModal.classList.contains('hidden')) {
            closeLightbox();
        }
    });
}
