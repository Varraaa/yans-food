<!-- 3-Step Catering Reservation Form (§6) -->
<div class="max-w-4xl mx-auto rounded-3xl bg-surface-warm p-6 sm:p-8 lg:p-12 shadow-xs border border-surface-variant/40" 
     id="catering-form-container"
     x-data="cateringWizard()">
    
    <!-- Draft Restore Banner (§6.6) -->
    <div x-show="hasDraft && !draftDismissed" 
         x-cloak
         class="mb-8 p-4 rounded-2xl bg-amber-50/80 border border-amber-200/70 text-amber-900 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs sm:text-sm">
        <div class="flex items-center gap-2.5">
            <span class="material-symbols-outlined text-[20px] text-amber-700">history_toggle_off</span>
            <span>Kamu memiliki draf pesanan yang belum selesai disimpan.</span>
        </div>
        <div class="flex items-center gap-3">
            <button type="button" 
                    @click="restoreDraft()" 
                    class="font-bold text-primary hover:underline">
                Lanjutkan Draf
            </button>
            <span class="text-amber-300">•</span>
            <button type="button" 
                    @click="discardDraft()" 
                    class="text-amber-700 hover:text-amber-950">
                Mulai Baru
            </button>
        </div>
    </div>

    <!-- Stepper Indicator (§6.2) -->
    <div class="mb-10">
        <div class="flex items-center justify-between max-w-lg mx-auto relative">
            <div class="absolute left-0 right-0 top-1/2 -translate-y-1/2 h-0.5 bg-surface-variant -z-0"></div>
            <div class="absolute left-0 top-1/2 -translate-y-1/2 h-0.5 bg-primary transition-all duration-300 -z-0"
                 :style="`width: ${step === 1 ? '0%' : (step === 2 ? '50%' : '100%')}`"></div>

            <!-- Step 1 Circle -->
            <button type="button" 
                    @click="if(step > 1) step = 1"
                    :class="step >= 1 ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-surface-warm text-secondary border border-surface-variant'"
                    class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs transition-all relative z-10">
                <span x-show="step > 1" class="material-symbols-outlined text-[18px]">check</span>
                <span x-show="step <= 1">1</span>
            </button>

            <!-- Step 2 Circle -->
            <button type="button" 
                    @click="if(step > 2) step = 2"
                    :class="step >= 2 ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-surface-warm text-secondary border border-surface-variant'"
                    class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs transition-all relative z-10">
                <span x-show="step > 2" class="material-symbols-outlined text-[18px]">check</span>
                <span x-show="step <= 2">2</span>
            </button>

            <!-- Step 3 Circle -->
            <div :class="step === 3 ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-surface-warm text-secondary border border-surface-variant'"
                 class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs transition-all relative z-10">
                <span>3</span>
            </div>
        </div>

        <div class="flex items-center justify-between max-w-lg mx-auto mt-2 text-xs font-label-md text-secondary text-center">
            <span :class="step === 1 ? 'font-bold text-primary' : ''" class="w-24 text-left">1. Info Acara</span>
            <span :class="step === 2 ? 'font-bold text-primary' : ''" class="w-24 text-center">2. Pilih Menu</span>
            <span :class="step === 3 ? 'font-bold text-primary' : ''" class="w-24 text-right">3. Data Pemesan</span>
        </div>
    </div>

    <!-- The Form -->
    <form @submit.prevent="submitOrder()" class="space-y-8" id="catering-booking-form">
        <!-- Honeypot anti-spam (§6.5) -->
        <input type="text" name="website_trap" x-model="form.website_trap" class="hidden" tabindex="-1" autocomplete="off">

        <!-- ==============================================
             STEP 1: INFO ACARA (§6.2)
             ============================================== -->
        <div x-show="step === 1" x-transition.opacity.duration.300ms class="space-y-6">
            <div class="border-b border-surface-variant/40 pb-4">
                <h3 class="font-headline-md text-2xl text-on-surface font-serif">Langkah 1: Rencana Acara Anda</h3>
                <p class="font-body-sm text-secondary text-xs sm:text-sm mt-1">
                    Beri tahu kami jadwal dan jenis acara untuk memastikan ketersediaan dapur kami.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tanggal Acara (Min H-2) -->
                <div class="space-y-2">
                    <label class="block font-label-md text-on-surface text-xs sm:text-sm font-semibold" for="event_date">
                        Tanggal Acara * <span class="text-primary font-normal text-xs">(Minimal H-2)</span>
                    </label>
                    <input type="date" 
                           id="event_date" 
                           x-model="form.event_date" 
                           :min="minDate" 
                           required 
                           @change="saveDraft()"
                           class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                </div>

                <!-- Waktu Tiba (08:00 - 18:00 WIB) -->
                <div class="space-y-2">
                    <label class="block font-label-md text-on-surface text-xs sm:text-sm font-semibold" for="event_time">
                        Waktu Pengantaran Tiba * <span class="text-secondary font-normal text-xs">(08.00 - 18.00 WIB)</span>
                    </label>
                    <input type="time" 
                           id="event_time" 
                           x-model="form.event_time" 
                           min="08:00" 
                           max="18:00" 
                           required 
                           @change="saveDraft()"
                           class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Jenis Acara -->
                <div class="space-y-2">
                    <label class="block font-label-md text-on-surface text-xs sm:text-sm font-semibold" for="event_purpose">
                        Jenis Acara *
                    </label>
                    <select id="event_purpose" 
                            x-model="form.event_purpose" 
                            required 
                            @change="saveDraft()"
                            class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm cursor-pointer">
                        <option value="" disabled>Pilih Jenis Acara</option>
                        <option value="Arisan Keluarga / RT">Arisan Keluarga / RT</option>
                        <option value="Rapat Kantor / Meeting">Rapat Kantor / Meeting</option>
                        <option value="Syukuran / Selamatan Rumah">Syukuran / Selamatan Rumah</option>
                        <option value="Ulang Tahun / Pesta Santai">Ulang Tahun / Pesta Santai</option>
                        <option value="Pengajian / Kegiatan Ibadah">Pengajian / Kegiatan Ibadah</option>
                        <option value="Acara Lainnya">Acara Lainnya</option>
                    </select>
                </div>

                <!-- Estimasi Tamu / Porsi -->
                <div class="space-y-2">
                    <label class="block font-label-md text-on-surface text-xs sm:text-sm font-semibold" for="estimated_guests">
                        Estimasi Tamu / Porsi * <span class="text-secondary font-normal text-xs">(Min. 15 porsi)</span>
                    </label>
                    <input type="number" 
                           id="estimated_guests" 
                           x-model.number="form.estimated_guests" 
                           min="15" 
                           required 
                           @input="saveDraft()"
                           class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                </div>
            </div>

            <!-- Nav Step 1 to 2 -->
            <div class="pt-6 flex justify-end border-t border-surface-variant/40">
                <button type="button" 
                        @click="goToStep2()" 
                        class="px-7 py-3.5 rounded-xl bg-primary text-white font-label-md font-bold text-sm shadow-md hover:bg-primary-dark transition-all flex items-center gap-2 active:scale-95">
                    <span>Lanjut: Pilih Menu</span>
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </button>
            </div>
        </div>

        <!-- ==============================================
             STEP 2: PILIH MENU & ESTIMASI BIAYA (§6.2)
             ============================================== -->
        <div x-show="step === 2" x-transition.opacity.duration.300ms class="space-y-6">
            <div class="border-b border-surface-variant/40 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <h3 class="font-headline-md text-2xl text-on-surface font-serif">Langkah 2: Pilih Menu Katering</h3>
                    <p class="font-body-sm text-secondary text-xs sm:text-sm mt-1">
                        Pilih menu paket utama atau racik kombinasi hidangan sesuai kebutuhan tamu Anda.
                    </p>
                </div>
                <div class="text-right">
                    <span class="font-label-sm text-secondary text-xs block">Estimasi Subtotal</span>
                    <span class="font-numeric-currency text-primary text-xl font-bold font-serif" x-text="formatRupiah(calculateTotal())"></span>
                </div>
            </div>

            <!-- Minimum Order Notice (§6.2: Rp 200.000 / 15 box) -->
            <div x-show="calculateTotal() < 200000" 
                 class="p-4 rounded-2xl bg-amber-50 border border-amber-200/80 text-amber-900 flex items-center gap-2.5 text-xs sm:text-sm">
                <span class="material-symbols-outlined text-[20px] text-amber-700">warning</span>
                <span>Minimal pemesanan katering adalah <strong>Rp 200.000</strong> (atau 15 porsi). Tambahkan menu untuk melanjutkan.</span>
            </div>

            <!-- Menu Selector Cards Grid -->
            <div class="space-y-4">
                <template x-for="(item, index) in menuCatalog" :key="item.id">
                    <div class="p-4 rounded-2xl bg-cream-bg border border-surface-variant/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-all"
                         :class="item.qty > 0 ? 'ring-2 ring-primary/40 bg-white' : ''">
                        <div class="flex items-center gap-3.5">
                            <img :src="item.image" :alt="item.name" class="w-14 h-14 rounded-xl object-cover bg-surface-container shrink-0">
                            <div>
                                <div class="flex items-center gap-2">
                                    <h4 class="font-headline-sm text-on-surface font-semibold text-sm sm:text-base font-serif" x-text="item.name"></h4>
                                    <span class="px-2 py-0.5 rounded-full bg-surface-container text-secondary text-[10px] font-semibold" x-text="item.category"></span>
                                </div>
                                <p class="font-body-sm text-secondary text-xs line-clamp-1 mt-0.5" x-text="item.desc"></p>
                                <span class="font-numeric-currency text-primary font-bold text-xs sm:text-sm" x-text="formatRupiah(item.price) + ' / ' + item.unit"></span>
                            </div>
                        </div>

                        <!-- Stepper Quantity Control -->
                        <div class="flex items-center gap-3 self-end sm:self-center shrink-0">
                            <button type="button" 
                                    @click="adjustQty(item, -1)" 
                                    :disabled="item.qty === 0"
                                    class="w-9 h-9 rounded-lg bg-surface-warm border border-surface-variant/40 flex items-center justify-center text-on-surface hover:bg-surface-container disabled:opacity-30 disabled:cursor-not-allowed transition-colors active:scale-95">
                                <span class="material-symbols-outlined text-[16px]">remove</span>
                            </button>
                            <span class="font-mono font-bold text-sm sm:text-base w-8 text-center" x-text="item.qty"></span>
                            <button type="button" 
                                    @click="adjustQty(item, 1)" 
                                    class="w-9 h-9 rounded-lg bg-primary text-white flex items-center justify-center hover:bg-primary-dark transition-colors active:scale-95 shadow-xs">
                                <span class="material-symbols-outlined text-[16px]">add</span>
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Nav Step 2 -->
            <div class="pt-6 flex items-center justify-between border-t border-surface-variant/40">
                <button type="button" 
                        @click="step = 1" 
                        class="px-5 py-3 rounded-xl bg-surface-container text-on-surface font-label-md text-xs sm:text-sm hover:bg-surface-container-high transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    <span>Kembali</span>
                </button>
                <button type="button" 
                        @click="goToStep3()" 
                        :disabled="calculateTotal() < 200000"
                        class="px-7 py-3.5 rounded-xl bg-primary text-white font-label-md font-bold text-sm shadow-md hover:bg-primary-dark disabled:opacity-50 disabled:cursor-not-allowed transition-all flex items-center gap-2 active:scale-95">
                    <span>Lanjut: Data Pemesan</span>
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </button>
            </div>
        </div>

        <!-- ==============================================
             STEP 3: DATA PEMESAN & REVIEW (§6.2)
             ============================================== -->
        <div x-show="step === 3" x-transition.opacity.duration.300ms class="space-y-6">
            <div class="border-b border-surface-variant/40 pb-4">
                <h3 class="font-headline-md text-2xl text-on-surface font-serif">Langkah 3: Data Pemesan & Konfirmasi</h3>
                <p class="font-body-sm text-secondary text-xs sm:text-sm mt-1">
                    Pastikan nomor WhatsApp dan alamat pengantaran akurat agar admin dapat mengonfirmasi slot pesanan.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Pemesan -->
                <div class="space-y-2">
                    <label class="block font-label-md text-on-surface text-xs sm:text-sm font-semibold" for="customer_name">
                        Nama Lengkap Pemesan *
                    </label>
                    <input type="text" 
                           id="customer_name" 
                           x-model="form.customer_name" 
                           placeholder="Contoh: Ibu Rina Hartono" 
                           required 
                           @input="saveDraft()"
                           class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                </div>

                <!-- Nomor WhatsApp -->
                <div class="space-y-2">
                    <label class="block font-label-md text-on-surface text-xs sm:text-sm font-semibold" for="customer_phone">
                        Nomor WhatsApp Aktif *
                    </label>
                    <input type="tel" 
                           id="customer_phone" 
                           x-model="form.customer_phone" 
                           placeholder="Contoh: 081234567890" 
                           required 
                           @input="saveDraft()"
                           class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                </div>
            </div>

            <!-- Alamat Pengiriman -->
            <div class="space-y-2">
                <label class="block font-label-md text-on-surface text-xs sm:text-sm font-semibold" for="customer_address">
                    Alamat Pengantaran Lengkap * <span class="text-secondary font-normal text-xs">(Sertakan patokan lokasi/gedung)</span>
                </label>
                <textarea id="customer_address" 
                          x-model="form.customer_address" 
                          rows="3" 
                          placeholder="Jalan, Nomor Rumah / Gedung / Kantor, RT/RW, Kelurahan, Kecamatan, Patokan..." 
                          required 
                          @input="saveDraft()"
                          class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm resize-y"></textarea>
            </div>

            <!-- Catatan Khusus -->
            <div class="space-y-2">
                <label class="block font-label-md text-on-surface text-xs sm:text-sm font-semibold" for="notes">
                    Catatan Khusus (Opsional)
                </label>
                <input type="text" 
                       id="notes" 
                       x-model="form.notes" 
                       placeholder="Misal: Sambal dipisah wadah tersendiri, mohon diantar tepat jam 11 siang..." 
                       @input="saveDraft()"
                       class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
            </div>

            <!-- Live Review Card -->
            <div class="p-5 rounded-2xl bg-cream-bg border border-surface-variant/50 space-y-4">
                <div class="flex items-center justify-between border-b border-surface-variant/40 pb-3">
                    <span class="font-label-md text-on-surface font-bold text-sm uppercase tracking-wider">Ringkasan Pesanan Katering</span>
                    <span class="font-mono text-xs text-secondary" x-text="form.event_date + ' (' + form.event_time + ' WIB)'"></span>
                </div>
                
                <div class="space-y-2 text-xs sm:text-sm font-body-sm text-secondary">
                    <div class="flex justify-between">
                        <span>Acara:</span>
                        <span class="font-semibold text-on-surface" x-text="form.event_purpose"></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Pemesan:</span>
                        <span class="font-semibold text-on-surface" x-text="form.customer_name + ' (' + form.customer_phone + ')'"></span>
                    </div>
                    <div class="border-t border-surface-variant/30 pt-2 space-y-1">
                        <template x-for="item in getSelectedItems()" :key="item.id">
                            <div class="flex justify-between text-on-surface">
                                <span x-text="item.qty + 'x ' + item.name"></span>
                                <span class="font-mono font-semibold" x-text="formatRupiah(item.price * item.qty)"></span>
                            </div>
                        </template>
                    </div>
                    <div class="border-t border-surface-variant/40 pt-3 flex justify-between items-center text-sm sm:text-base">
                        <span class="font-bold text-on-surface">Total Estimasi:</span>
                        <span class="font-numeric-currency text-primary text-xl font-bold font-serif" x-text="formatRupiah(calculateTotal())"></span>
                    </div>
                </div>
            </div>

            <!-- Nav Step 3 & Submit Button -->
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-surface-variant/40">
                <button type="button" 
                        @click="step = 2" 
                        class="w-full sm:w-auto px-5 py-3 rounded-xl bg-surface-container text-on-surface font-label-md text-xs sm:text-sm hover:bg-surface-container-high transition-colors flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    <span>Kembali ke Menu</span>
                </button>
                <button type="submit" 
                        :disabled="isSubmitting"
                        class="w-full sm:w-auto px-8 py-4 rounded-xl bg-primary text-white font-label-md font-bold text-sm shadow-md hover:bg-primary-dark transition-all flex items-center justify-center gap-2.5 active:scale-95 disabled:opacity-50">
                    <span x-show="!isSubmitting" class="material-symbols-outlined text-[20px]">send</span>
                    <span x-show="isSubmitting" class="material-symbols-outlined text-[20px] animate-spin">progress_activity</span>
                    <span x-text="isSubmitting ? 'Mencatat Pesanan...' : 'Kirim Pesanan Katering'"></span>
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Alpine Wizard Script (§6) -->
<script>
    function cateringWizard() {
        const today = new Date();
        // Minimal H-2 (§6.2)
        const minD = new Date(today);
        minD.setDate(today.getDate() + 2);
        const minDateStr = minD.toISOString().split('T')[0];

        // Format default time 10:00
        const defaultDateStr = minDateStr;

        const defaultCatalog = [
            {
                id: 1,
                name: 'Paket Snack Box Manis & Gurih',
                category: 'Snack Box',
                desc: 'Risol Mayo + Pisang Coklat + Tahu Bakso + Air Mineral Cup',
                price: 12000,
                unit: 'box',
                image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuARZOQ96wet-CMX5rdD7lCFZyLs1EkrpKnlUC0RR99N8F7qRKAtVDp0zOXrFg0euopAroL4wdJES5KEUP4Mc10u-UzZYXlvj3_U850HmHFdI-2qa02DqfAOUMw-0VbCaGvmAt2949p2eWuHqz3RcdS7ODq1G6OninQUnQZKMoxPO6O-lS3WjYQWINUV6vdxskptYAzfbyMOIB5K2-d37eZht5g2KMxF67gGOJStQ-AFmbk3gNEvgEtd',
                qty: 20
            },
            {
                id: 2,
                name: 'Paket Nasi Kotak Nusantara (Terpopuler)',
                category: 'Nasi Kotak',
                desc: 'Nasi Daun Jeruk + Ayam Goreng Rempah + Telur Balado + Sambal + Kerupuk',
                price: 28000,
                unit: 'box',
                image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDFkmFBQYeBj264oHilvJ9JGnrJ_1PQwJXxR2gokTFFviNr5gzGCDexUL9qKdLaBaTQmtl7Kr6kSRlVtonMXlr1NwwYVSGTCtr6AFa_iWNSqQ0D74vSZRm_HMXg6AOgcxsT3bHsrxoTQvSyHcyUcv3avNKLywFGPb8AYZAxOuVzhC-mVzhPiHFbQD6tEbON-W1f62G9pLQr_QEupaxxHXBTmkPriy348OCpVdEAQzNnXKeNuLYcLUDR',
                qty: 0
            },
            {
                id: 3,
                name: 'Risol Mayo Spesial (Satuan)',
                category: 'Kudapan',
                desc: 'Kulit renyah lembut, smoked beef, telur, & saus mayo gurih lumer',
                price: 4500,
                unit: 'pcs',
                image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCyfuXln7cyGrY2lKM07Nk3VKMQjY3ZTmHoC1dw90oSQpU6K9GToD9dsNw7j-ONqeDlAGA4dUHsambXmkUw1VSykY9WS5EuOrd2vXOLVz_gDlJDQpTckcMcGct8EuAcmM-Aj5VFqr78aR9bpsCfWc7L5uPmlfvvfJvmZbLdxztCm-fUjNoCNBg6rJwiIGonOikHOEVhan_cN8QOl7vVORz_mOuXsXhhH3TopjOFzgKMvjN75USyuea4',
                qty: 0
            },
            {
                id: 4,
                name: 'Pisang Coklat Crispy (Satuan)',
                category: 'Kudapan',
                desc: 'Pisang raja manis legit dengan coklat melimpah berbalut kulit crispy emas',
                price: 3500,
                unit: 'pcs',
                image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBts6_Y8VjNhmV1LnrN6Dm5iR4sSQV3xhLKrMWDJ6fdyqbxY5O9UUI0S756Cpv4FT1Yz-u3S4boBHAif6DwRvoIGDRnvaOAQC6T3FOJTit1ctKXlOxUcwCSHO1NAsIzokrAtdKAhabshRPcb8-79Kx_Y0Npfeb0F49PFjc2JS3S2A5MMw-cxhx3jqPOPn8bT9D07fWrCrU6OzYatoJuHKSSOFKhB75_p_Sr9SRd84JFSYkDWNiu3HvX',
                qty: 0
            },
            {
                id: 5,
                name: 'Nasi Goreng Jadul Yan\'s',
                category: 'Makanan Berat',
                desc: 'Bumbu ulek terasi tradisional, suwiran ayam, telur ceplok, & kerupuk',
                price: 22000,
                unit: 'porsi',
                image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCvbMqJp4vasmNPRn7HlUQ53R3QwrbMiAJGRmOeSP3xoEqc-hb5EkQx28tGjOOddzhbh0BvjFwX_K2C7FkHaJpySF2zidCDs-Bx_mHHA3URhRcMv1OQhfIUJ4SnK1xWUswF-WwKCxa8-zJZmfBBJz1XBLusLQAzk5BcvZvIXzaDl0b5CzAHuTSEZQKFm2axnelXGbXdYgGwaMGpV41iikvWXq7ZllZ-h_pkIUZOUgUcN8KoU_ETwohF',
                qty: 0
            }
        ];

        return {
            step: 1,
            minDate: minDateStr,
            hasDraft: false,
            draftDismissed: false,
            isSubmitting: false,
            form: {
                event_date: defaultDateStr,
                event_time: '11:00',
                event_purpose: 'Arisan Keluarga / RT',
                estimated_guests: 20,
                customer_name: '',
                customer_phone: '',
                customer_address: '',
                notes: '',
                website_trap: ''
            },
            menuCatalog: defaultCatalog,

            init() {
                this.checkDraft();
            },

            checkDraft() {
                try {
                    const raw = localStorage.getItem('yf_catering_draft_v1');
                    if (raw) {
                        const parsed = JSON.parse(raw);
                        const ttl = 48 * 60 * 60 * 1000; // 48 jam (§6.6)
                        if (Date.now() - (parsed.savedAt || 0) < ttl) {
                            this.hasDraft = true;
                        } else {
                            localStorage.removeItem('yf_catering_draft_v1');
                        }
                    }
                } catch (e) {
                    console.warn(e);
                }
            },

            saveDraft() {
                try {
                    const data = {
                        form: this.form,
                        menuCatalog: this.menuCatalog,
                        step: this.step,
                        savedAt: Date.now()
                    };
                    localStorage.setItem('yf_catering_draft_v1', JSON.stringify(data));
                } catch (e) {
                    console.warn(e);
                }
            },

            restoreDraft() {
                try {
                    const raw = localStorage.getItem('yf_catering_draft_v1');
                    if (raw) {
                        const parsed = JSON.parse(raw);
                        if (parsed.form) this.form = Object.assign(this.form, parsed.form);
                        if (parsed.menuCatalog) this.menuCatalog = parsed.menuCatalog;
                        if (parsed.step) this.step = parsed.step;
                    }
                    this.hasDraft = false;
                    this.draftDismissed = true;
                    if (window.showToast) window.showToast('Draf pesanan berhasil dipulihkan!');
                } catch (e) {
                    console.warn(e);
                }
            },

            discardDraft() {
                try {
                    localStorage.removeItem('yf_catering_draft_v1');
                } catch (e) {}
                this.hasDraft = false;
                this.draftDismissed = true;
            },

            adjustQty(item, delta) {
                item.qty = Math.max(0, item.qty + delta);
                this.saveDraft();
            },

            calculateTotal() {
                return this.menuCatalog.reduce((sum, item) => sum + (item.price * item.qty), 0);
            },

            getSelectedItems() {
                return this.menuCatalog.filter(it => it.qty > 0);
            },

            formatRupiah(num) {
                return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            },

            goToStep2() {
                if (!this.form.event_date || !this.form.event_time || !this.form.event_purpose) {
                    alert('Mohon lengkapi seluruh informasi rencana acara Anda.');
                    return;
                }
                this.step = 2;
                this.saveDraft();
            },

            goToStep3() {
                if (this.calculateTotal() < 200000) {
                    alert('Minimal pemesanan katering adalah Rp 200.000.');
                    return;
                }
                this.step = 3;
                this.saveDraft();
            },

            async submitOrder() {
                if (!this.form.customer_name || !this.form.customer_phone || !this.form.customer_address) {
                    alert('Mohon lengkapi nama pemesan, nomor WhatsApp, dan alamat pengiriman.');
                    return;
                }

                this.isSubmitting = true;

                const selectedItems = this.getSelectedItems();
                const primaryItem = selectedItems[0] || null;

                const payload = {
                    customer_name: this.form.customer_name,
                    customer_phone: this.form.customer_phone,
                    customer_address: this.form.customer_address,
                    event_date: this.form.event_date,
                    event_time: this.form.event_time,
                    event_purpose: this.form.event_purpose,
                    notes: this.form.notes,
                    package_type: primaryItem ? primaryItem.name : 'Custom Katering',
                    quantity: primaryItem ? primaryItem.qty : this.form.estimated_guests,
                    website_trap: this.form.website_trap
                };

                try {
                    const response = await fetch('{{ route("pesan-catering.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(payload)
                    });

                    const res = await response.json();

                    if (res.success && res.redirect_url) {
                        localStorage.removeItem('yf_catering_draft_v1');
                        window.location.href = res.redirect_url;
                    } else if (res.whatsapp_url) {
                        localStorage.removeItem('yf_catering_draft_v1');
                        window.location.href = res.whatsapp_url;
                    } else {
                        alert(res.message || 'Terjadi kendala saat menyimpan pesanan.');
                    }
                } catch (err) {
                    console.error('Submit error', err);
                    alert('Koneksi terputus. Silakan hubungi WhatsApp kami langsung.');
                } finally {
                    this.isSubmitting = false;
                }
            }
        };
    }
</script>
