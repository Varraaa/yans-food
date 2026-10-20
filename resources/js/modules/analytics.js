/**
 * Yan's Food — Privacy-Friendly UX Analytics & Funnel Tracker (§11)
 * Compliant with YANS-FOOD-WEB-UX-SPECIFICATION.md
 * 
 * Tracks Key Micro-Conversions:
 * - menu_search
 * - menu_category_filter
 * - product_view_modal
 * - platform_delivery_click
 * - wa_click
 */

export function trackEvent(eventName, params = {}) {
    try {
        const payload = {
            event: eventName,
            timestamp: new Date().toISOString(),
            url: window.location.pathname,
            ...params
        };

        // If GTM / GA4 dataLayer is available, push into it
        if (window.dataLayer && Array.isArray(window.dataLayer)) {
            window.dataLayer.push(payload);
        }

        // Custom event for internal listening / debugging
        window.dispatchEvent(new CustomEvent('yf:analytics', { detail: payload }));
    } catch (e) {
        // Silently catch tracking errors to never disrupt user experience
    }
}

export function initAnalytics() {
    // 1. Automatic click tracking for elements with [data-track]
    document.addEventListener('click', (e) => {
        const trackTarget = e.target.closest('[data-track]');
        if (trackTarget) {
            const eventName = trackTarget.getAttribute('data-track');
            const eventVal = trackTarget.getAttribute('data-track-value') || '';
            trackEvent(eventName, { value: eventVal });
        }

        // WhatsApp Conversions
        const waLink = e.target.closest('a[href*="wa.me"], a[href*="whatsapp.com"], #floating-wa-btn');
        if (waLink) {
            trackEvent('wa_click', {
                location: waLink.id || waLink.getAttribute('aria-label') || 'chat_link'
            });
        }

        // Delivery Platforms (Section A)
        const platformCard = e.target.closest('a[href*="shopee"], a[href*="gojek"], a[href*="grab"]');
        if (platformCard) {
            trackEvent('platform_delivery_click', {
                platform: platformCard.href
            });
        }
    }, { passive: true });

    // Expose trackEvent globally
    window.trackEvent = trackEvent;
}
