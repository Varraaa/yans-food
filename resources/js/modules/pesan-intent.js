/**
 * Yan's Food — Pesan Intent Switcher & Section Observer (§5.4)
 * Synchronizes intent cards with current scroll view and manages deep linking.
 */
export function initPesanIntent() {
    const onlineSection = document.getElementById('online');
    const kateringSection = document.getElementById('katering');
    const intentOnlineCard = document.getElementById('intent-card-online');
    const intentKateringCard = document.getElementById('intent-card-katering');

    if (!onlineSection || !kateringSection || !intentOnlineCard || !intentKateringCard) return;

    // 1. Click handlers for smooth scroll
    intentOnlineCard.addEventListener('click', (e) => {
        e.preventDefault();
        onlineSection.scrollIntoView({ behavior: 'smooth' });
    });

    intentKateringCard.addEventListener('click', (e) => {
        e.preventDefault();
        kateringSection.scrollIntoView({ behavior: 'smooth' });
    });

    // 2. IntersectionObserver to track active section
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                if (entry.target.id === 'online') {
                    intentOnlineCard.classList.add('is-active');
                    intentKateringCard.classList.remove('is-active');
                } else if (entry.target.id === 'katering') {
                    intentKateringCard.classList.add('is-active');
                    intentOnlineCard.classList.remove('is-active');
                }
            }
        });
    }, {
        rootMargin: '-80px 0px -40% 0px',
        threshold: 0.1
    });

    observer.observe(onlineSection);
    observer.observe(kateringSection);

    // 3. Deep link support from query param `?produk=slug`
    const urlParams = new URLSearchParams(window.location.search);
    const targetProduct = urlParams.get('produk');
    if (targetProduct) {
        setTimeout(() => {
            kateringSection.scrollIntoView({ behavior: 'smooth' });
        }, 300);
    }
}
