/**
 * Yan's Food — Pesan Intent Switcher & Section Observer
 * Synchronizes intent cards with current scroll view (Online Delivery vs Takeaway).
 */
export function initPesanIntent() {
    const onlineSection = document.getElementById('online');
    const takeawaySection = document.getElementById('langsung') || document.getElementById('takeaway');
    const intentOnlineCard = document.getElementById('intent-card-online');
    const intentTakeawayCard = document.getElementById('intent-card-takeaway') || document.getElementById('intent-card-langsung');

    if (!onlineSection || !takeawaySection || !intentOnlineCard || !intentTakeawayCard) return;

    // 1. Click handlers for smooth scroll
    intentOnlineCard.addEventListener('click', (e) => {
        e.preventDefault();
        onlineSection.scrollIntoView({ behavior: 'smooth' });
    });

    intentTakeawayCard.addEventListener('click', (e) => {
        e.preventDefault();
        takeawaySection.scrollIntoView({ behavior: 'smooth' });
    });

    // 2. IntersectionObserver to track active section
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                if (entry.target.id === 'online') {
                    intentOnlineCard.classList.add('is-active');
                    intentTakeawayCard.classList.remove('is-active');
                } else if (entry.target.id === 'langsung' || entry.target.id === 'takeaway') {
                    intentTakeawayCard.classList.add('is-active');
                    intentOnlineCard.classList.remove('is-active');
                }
            }
        });
    }, {
        rootMargin: '-80px 0px -40% 0px',
        threshold: 0.1
    });

    observer.observe(onlineSection);
    observer.observe(takeawaySection);
}
