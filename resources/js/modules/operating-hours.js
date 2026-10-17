/**
 * Live Operating Hours Pill (§5.5)
 * Updates live status pill based on WIB time (08:00 - 20:00)
 */
export function initOperatingHours() {
    const pill = document.getElementById('live-status-pill');
    const dot = document.getElementById('live-status-dot');
    const text = document.getElementById('live-status-text');
    if (!pill || !dot || !text) return;

    // Dapatkan waktu WIB sekarang (UTC+7)
    const now = new Date();
    const utc = now.getTime() + (now.getTimezoneOffset() * 60000);
    const wib = new Date(utc + (3600000 * 7));
    const hours = wib.getHours();
    const minutes = wib.getMinutes();
    const currentTime = hours * 60 + minutes;

    // Jam buka: 08:00 (480) - 20:00 (1200)
    const openTime = 8 * 60;
    const closeTime = 20 * 60;

    if (currentTime >= openTime && currentTime < closeTime) {
        pill.className = 'inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-100 text-emerald-800 font-label-sm text-xs font-semibold';
        dot.className = 'w-2 h-2 rounded-full bg-emerald-500 animate-pulse';
        text.textContent = 'Buka Sekarang • Tutup jam 20:00 WIB';
    } else {
        pill.className = 'inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-surface-container text-secondary font-label-sm text-xs font-semibold';
        dot.className = 'w-2 h-2 rounded-full bg-outline';
        text.textContent = 'Tutup • Buka Kembali Besok 08:00 WIB';
    }
}
