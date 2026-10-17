/**
 * Yan's Food — Toast Notification System & Clipboard Copy (§3.6, M23)
 * Compliant with YANS-FOOD-WEB-UX-SPECIFICATION.md
 */

let toastTimeout = null;

export function initToast() {
    window.showToast = function(message, type = 'status') {
        let toast = document.getElementById('toast-feedback');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'toast-feedback';
            document.body.appendChild(toast);
        }

        toast.setAttribute('role', type === 'error' ? 'alert' : 'status');
        toast.setAttribute('aria-live', 'polite');

        const iconSymbol = type === 'error' ? 'error' : 'check_circle';
        const iconColor = type === 'error' ? 'text-[#B3432E]' : 'text-[#3F7D53]';

        toast.innerHTML = `
            <span class="material-symbols-outlined ${iconColor} text-[20px] shrink-0">${iconSymbol}</span>
            <span>${message}</span>
        `;

        toast.classList.add('is-visible');

        // Bersihkan timeout sebelumnya
        if (toastTimeout) clearTimeout(toastTimeout);

        function startDismissTimer() {
            toastTimeout = setTimeout(() => {
                toast.classList.remove('is-visible');
            }, 4000);
        }

        // Jeda timeout saat di-hover atau di-fokus (§3.6)
        toast.onmouseenter = () => clearTimeout(toastTimeout);
        toast.onmouseleave = () => startDismissTimer();
        toast.onfocus = () => clearTimeout(toastTimeout);
        toast.onblur = () => startDismissTimer();

        startDismissTimer();
    };

    // Helper salin teks ke clipboard (M23)
    window.copyToClipboard = function(text, successMessage = 'Teks berhasil disalin!') {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(() => {
                window.showToast(successMessage);
            }).catch(() => {
                fallbackCopy(text, successMessage);
            });
        } else {
            fallbackCopy(text, successMessage);
        }
    };

    function fallbackCopy(text, successMessage) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.left = '-9999px';
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            document.execCommand('copy');
            window.showToast(successMessage);
        } catch (err) {
            window.showToast('Gagal menyalin teks.', 'error');
        }
        document.body.removeChild(textArea);
    }
}
