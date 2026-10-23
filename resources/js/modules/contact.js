/**
 * Contact Page Module (§5.5)
 * Live status pill, copy address, & fast WhatsApp inquiry
 */
export function initContactPage() {
    // 1. Operating status
    const pill = document.getElementById('live-status-pill');
    const dot = document.getElementById('live-status-dot');
    const text = document.getElementById('live-status-text');
    if (pill && dot && text) {
        const now = new Date();
        const utc = now.getTime() + (now.getTimezoneOffset() * 60000);
        const wib = new Date(utc + (3600000 * 7));
        const hours = wib.getHours();
        const minutes = wib.getMinutes();
        const currentTime = hours * 60 + minutes;

        // Jam buka: 08:00 - 22:00
        const openTime = 8 * 60;
        const closeTime = 22 * 60;

        if (currentTime >= openTime && currentTime < closeTime) {
            dot.className = "w-2 h-2 rounded-full bg-emerald-500 animate-pulse";
            text.textContent = "Buka Sekarang • Dapur aktif melayani sampai 22:00 WIB";
            text.className = "text-emerald-700 font-semibold";
        } else {
            dot.className = "w-2 h-2 rounded-full bg-amber-500";
            text.textContent = "Tutup Sementara • Dapur buka kembali pukul 08:00 WIB";
            text.className = "text-amber-800 font-semibold";
        }
    }

    // 2. Copy address handler
    const copyAddrBtn = document.getElementById('btn-copy-address');
    if (copyAddrBtn) {
        copyAddrBtn.addEventListener('click', () => {
            const addr = copyAddrBtn.getAttribute('data-address') || 'Bandung, Kp. Ciloa, RT.04/RW.10, Kec. Soreang';
            if (window.copyToClipboard) {
                window.copyToClipboard(addr, 'Alamat dapur berhasil disalin!');
            }
        });
    }

    // 3. Contact form submit handler (Negotiation & Catering Inquiry via WhatsApp)
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const name = (document.getElementById('fullName')?.value || '').trim();
            const phone = (document.getElementById('waNumber')?.value || '').trim();
            const type = document.getElementById('inquiryType')?.value || 'Konsultasi & Negosiasi Pesanan Katering Acara';
            const portion = (document.getElementById('portionEstimate')?.value || '').trim();
            const eventDate = (document.getElementById('eventDate')?.value || '').trim();
            const message = (document.getElementById('messageContent')?.value || '').trim();
            const adminWA = "6282221222936";

            const msgText = `Halo Kak, saya ingin berkomunikasi & negosiasi pesanan:\n\n` +
                `• Nama: ${name}\n` +
                `• WhatsApp: ${phone}\n` +
                `• Topik / Keperluan: ${type}\n` +
                `• Estimasi Porsi: ${portion || '-'}\n` +
                `• Rencana Tanggal Acara: ${eventDate || '-'}\n` +
                `• Rincian / Catatan Negosiasi: ${message}\n\n` +
                `Catatan: Saya memahami pemesanan katering/acara ini memerlukan konfirmasi dan persetujuan. Mohon informasinya lebih lanjut. Terima kasih!`;

            const encodedUrl = `https://wa.me/${adminWA}?text=${encodeURIComponent(msgText)}`;
            window.open(encodedUrl, '_blank');
        });
    }
}
