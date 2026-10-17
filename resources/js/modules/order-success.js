/**
 * Order Success Page Module (§6.8)
 * Cleans catering draft from localStorage and handles copying order summary & number
 */
export function initOrderSuccess() {
    const successContainer = document.querySelector('[data-order-success]');
    if (!successContainer) return;

    // Bersihkan draft catering yang tersimpan
    try {
        localStorage.removeItem('yf_catering_draft_v1');
    } catch (e) {
        console.warn('Could not remove localStorage draft', e);
    }

    // Copy order number handler
    const copyNumBtn = document.getElementById('btn-copy-order-number');
    if (copyNumBtn) {
        copyNumBtn.addEventListener('click', () => {
            const num = copyNumBtn.getAttribute('data-copy-target');
            if (num && window.copyToClipboard) {
                window.copyToClipboard(num, 'Nomor pesanan berhasil disalin!');
            }
        });
    }

    // Copy order summary handler
    const copyBtn = document.getElementById('btn-copy-order-summary');
    const summaryDataEl = document.getElementById('order-summary-payload');
    if (copyBtn && summaryDataEl) {
        copyBtn.addEventListener('click', () => {
            const text = summaryDataEl.textContent || summaryDataEl.innerText;
            if (window.copyToClipboard) {
                window.copyToClipboard(text.trim(), 'Ringkasan pesanan berhasil disalin ke clipboard!');
            }
        });
    }
}
