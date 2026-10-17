/**
 * Yan's Food — Accessible Accordions (§5.4, M21)
 * CSS grid transition, full keyboard accessibility, aria-expanded.
 */
export function initAccordions() {
    const headers = document.querySelectorAll('.accordion-header');

    headers.forEach(header => {
        header.addEventListener('click', () => {
            const item = header.closest('.accordion-item');
            if (!item) return;

            const isOpen = item.classList.contains('is-open');
            const group = item.closest('[data-accordion-group="single"]');

            // If single-open mode is active, close siblings
            if (group && !isOpen) {
                group.querySelectorAll('.accordion-item.is-open').forEach(sibling => {
                    sibling.classList.remove('is-open');
                    const sibHeader = sibling.querySelector('.accordion-header');
                    if (sibHeader) sibHeader.setAttribute('aria-expanded', 'false');
                });
            }

            if (isOpen) {
                item.classList.remove('is-open');
                header.setAttribute('aria-expanded', 'false');
            } else {
                item.classList.add('is-open');
                header.setAttribute('aria-expanded', 'true');
            }
        });
    });
}
