<div class="max-w-4xl mx-auto rounded-3xl bg-surface-warm p-6 sm:p-8 lg:p-12 shadow-sm border border-surface-variant/40">
    <div class="max-w-xl mb-10">
        <span class="font-label-md text-primary font-semibold tracking-wider uppercase text-xs">Formulir Reservasi</span>
        <h3 class="font-headline-md text-on-surface mt-1 font-serif">Pesan Jadwal Katering Anda</h3>
        <p class="font-body-sm text-secondary mt-2 leading-relaxed">
            Isi data acara Anda di bawah ini. Tombol akan otomatis menyusun ringkasan rapi dan langsung membuka percakapan WhatsApp dengan tim reservasi Yan's Food.
        </p>
    </div>

    <form class="space-y-6 sm:space-y-8" id="catering-form" onsubmit="event.preventDefault(); submitCateringToWhatsApp();">
        <!-- Row 1: Nama & Kontak -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="block font-label-md text-on-surface" for="pemesan-nama">Nama Lengkap Pemesan *</label>
                <input type="text" 
                       id="pemesan-nama" 
                       placeholder="Contoh: Ibu Rina Wardani" 
                       required 
                       class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 transition-all duration-200">
            </div>
            <div class="space-y-2">
                <label class="block font-label-md text-on-surface" for="pemesan-phone">Nomor WhatsApp Aktif *</label>
                <input type="tel" 
                       id="pemesan-phone" 
                       placeholder="Contoh: 081234567890" 
                       required 
                       class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 transition-all duration-200">
            </div>
        </div>

        <!-- Row 2: Tanggal & Waktu Acara -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="block font-label-md text-on-surface" for="acara-tanggal">Tanggal Acara *</label>
                <input type="date" 
                       id="acara-tanggal" 
                       required 
                       class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 transition-all duration-200">
            </div>
            <div class="space-y-2">
                <label class="block font-label-md text-on-surface" for="acara-waktu">Waktu Pengantaran Tiba *</label>
                <input type="time" 
                       id="acara-waktu" 
                       required 
                       class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 transition-all duration-200">
            </div>
        </div>

        <!-- Row 3: Pilihan Paket & Jumlah Porsi -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="block font-label-md text-on-surface" for="paket-tipe">Jenis Paket Katering *</label>
                <select id="paket-tipe" 
                        required 
                        class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 transition-all duration-200 cursor-pointer">
                    <option value="" disabled selected>Pilih salah satu paket</option>
                    <option value="Paket Snack Box Manis & Gurih (Mulai Rp 12k)">Paket Snack Box Manis & Gurih (Mulai Rp 12k)</option>
                    <option value="Paket Nasi Kotak Nusantara (Mulai Rp 28k - Terpopuler)">Paket Nasi Kotak Nusantara (Mulai Rp 28k - Terpopuler)</option>
                    <option value="Paket Prasmanan Mini Rumahan (Min. 25 Porsi)">Paket Prasmanan Mini Rumahan (Min. 25 Porsi)</option>
                    <option value="Custom Mix Box / Custom Menu Acara">Custom / Konsultasi Menu Khusus</option>
                </select>
            </div>
            <div class="space-y-2">
                <label class="block font-label-md text-on-surface" for="jumlah-porsi">Jumlah Porsi / Box (Min. 15) *</label>
                <input type="number" 
                       id="jumlah-porsi" 
                       min="15" 
                       value="20" 
                       required 
                       class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 transition-all duration-200">
            </div>
        </div>

        <!-- Row 4: Alamat Lengkap -->
        <div class="space-y-2">
            <label class="block font-label-md text-on-surface" for="alamat-kirim">Alamat Pengiriman Lengkap *</label>
            <input type="text" 
                   id="alamat-kirim" 
                   placeholder="Jalan, No. Rumah/Gedung, RT/RW, Kelurahan, Kecamatan, Patokan Lokasi" 
                   required 
                   class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 transition-all duration-200">
        </div>

        <!-- Row 5: Catatan Khusus -->
        <div class="space-y-2">
            <label class="block font-label-md text-on-surface" for="catatan-khusus">Catatan Khusus (Opsi Menu / Permintaan Khusus / Jam Antar)</label>
            <textarea id="catatan-khusus" 
                      rows="3" 
                      placeholder="Contoh: Pisang coklat jangan terlalu manis, mohon sambal dipisah wadahnya, butuh sendok garpu ekstra..." 
                      class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 transition-all duration-200"></textarea>
        </div>

        <!-- Submit Button Action -->
        <div class="pt-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-t border-surface-variant/40">
            <div class="flex items-center gap-2 text-on-surface-variant font-body-sm text-xs">
                <span class="material-symbols-outlined text-success text-[18px]">verified</span>
                <span>Pemesanan katering minimal H-2 sebelum acara</span>
            </div>
            <button type="submit" 
                    class="inline-flex items-center justify-center gap-3 px-8 py-3.5 rounded-xl bg-primary-container text-on-primary font-label-md hover:bg-primary-dark transition-all duration-200 shadow-md active:scale-95">
                <span>Kirim Pesanan via WhatsApp</span>
                <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
            </button>
        </div>
    </form>
</div>

<script>
    function submitCateringToWhatsApp() {
        const nama = document.getElementById('pemesan-nama').value.trim();
        const phone = document.getElementById('pemesan-phone').value.trim();
        const tanggal = document.getElementById('acara-tanggal').value;
        const waktu = document.getElementById('acara-waktu').value;
        const paket = document.getElementById('paket-tipe').value;
        const porsi = document.getElementById('jumlah-porsi').value;
        const alamat = document.getElementById('alamat-kirim').value.trim();
        const catatan = document.getElementById('catatan-khusus').value.trim();

        const adminWA = "6281234567890";

        const text = `Halo Admin Yan's Food, saya ingin melakukan pemesanan katering rumahan:\n\n` +
            `*Data Pemesan:*\n` +
            `• Nama: ${nama}\n` +
            `• Kontak / WA: ${phone}\n\n` +
            `*Jadwal Acara:*\n` +
            `• Tanggal: ${tanggal}\n` +
            `• Jam Pengantaran: ${waktu} WIB\n\n` +
            `*Detail Pesanan:*\n` +
            `• Paket: ${paket}\n` +
            `• Jumlah: ${porsi} Box / Porsi\n` +
            `• Alamat Pengiriman: ${alamat}\n` +
            (catatan ? `• Catatan Khusus: ${catatan}\n\n` : `\n`) +
            `Mohon konfirmasi ketersediaan slot jadwal dan total rincian biayanya. Terima kasih!`;

        const encodedUrl = `https://wa.me/${adminWA}?text=${encodeURIComponent(text)}`;
        window.open(encodedUrl, '_blank');
    }
</script>
