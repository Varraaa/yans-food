@props(['products' => null])

@php
    $minDate = \Carbon\Carbon::now()->addDays(2)->format('Y-m-d');
    
    // Prepare catalog data for JSON embedding
    $catalogList = [];
    if ($products && $products->count() > 0) {
        foreach ($products as $prod) {
            $catalogList[] = [
                'id' => $prod->id,
                'name' => $prod->name,
                'category' => $prod->category?->name ?? 'Menu Katering',
                'price' => (int) $prod->price,
                'unit' => $prod->unit ?: 'porsi',
                'image' => $prod->image_url ?: 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=150',
                'slug' => $prod->slug,
                'qty' => 0,
            ];
        }
    }
@endphp

<!-- 3-Step Catering Reservation Form (§6.1–§6.6) -->
<div class="max-w-5xl mx-auto rounded-3xl bg-surface-warm p-6 sm:p-8 lg:p-12 shadow-xs border border-surface-variant/40" 
     id="catering-form-container">

    <!-- Embedded Catalog Data (§6.3) -->
    @if(!empty($catalogList))
        <script id="catering-products-data" type="application/json">
            {!! json_encode($catalogList) !!}
        </script>
    @endif
    
    <!-- Draft Restore Banner (§6.6) -->
    <div id="catering-draft-banner" 
         class="hidden mb-8 p-4 rounded-2xl bg-amber-50/90 border border-amber-200/80 text-amber-900 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs sm:text-sm shadow-xs">
        <div class="flex items-center gap-2.5">
            <span class="material-symbols-outlined text-[20px] text-amber-700">history_toggle_off</span>
            <span>Kamu memiliki draf pesanan katering yang belum dikirim.</span>
        </div>
        <div class="flex items-center gap-3">
            <button type="button" 
                    id="btn-restore-draft"
                    class="font-bold text-primary hover:underline cursor-pointer">
                Lanjutkan Draf
            </button>
            <span class="text-amber-300">•</span>
            <button type="button" 
                    id="btn-discard-draft"
                    class="text-amber-700 hover:text-amber-950 cursor-pointer">
                Mulai Baru
            </button>
        </div>
    </div>

    <!-- Stepper Indicator (§6.1) -->
    <div class="mb-10">
        <div class="flex items-center justify-between max-w-lg mx-auto relative">
            <div class="absolute left-0 right-0 top-1/2 -translate-y-1/2 h-0.5 bg-surface-variant -z-0"></div>
            <div data-stepper-fill class="absolute left-0 top-1/2 -translate-y-1/2 h-0.5 bg-primary transition-all duration-300 -z-0" style="width: 0%;"></div>

            <!-- Step 1 Circle -->
            <button type="button" 
                    data-step-circle="1"
                    data-goto-step="1"
                    aria-label="Langkah 1: Acara Kamu"
                    class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs transition-all relative z-10 bg-primary text-white ring-4 ring-primary/20 cursor-pointer">
                <span class="step-check-icon hidden material-symbols-outlined text-[18px]">check</span>
                <span class="step-num-text">1</span>
            </button>

            <!-- Step 2 Circle -->
            <button type="button" 
                    data-step-circle="2"
                    data-goto-step="2"
                    aria-label="Langkah 2: Pilih Menu"
                    class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs transition-all relative z-10 bg-surface-warm text-secondary border border-surface-variant cursor-pointer">
                <span class="step-check-icon hidden material-symbols-outlined text-[18px]">check</span>
                <span class="step-num-text">2</span>
            </button>

            <!-- Step 3 Circle -->
            <button type="button" 
                    data-step-circle="3"
                    data-goto-step="3"
                    aria-label="Langkah 3: Data Pemesan"
                    class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs transition-all relative z-10 bg-surface-warm text-secondary border border-surface-variant cursor-pointer">
                <span class="step-check-icon hidden material-symbols-outlined text-[18px]">check</span>
                <span class="step-num-text">3</span>
            </button>
        </div>

        <div class="flex items-center justify-between max-w-lg mx-auto mt-2 text-xs font-label-md text-secondary text-center">
            <span class="w-24 text-left font-bold text-primary">1. Acara</span>
            <span class="w-24 text-center">2. Menu</span>
            <span class="w-24 text-right">3. Konfirmasi</span>
        </div>
    </div>

    <!-- The Form Container -->
    <form id="catering-booking-form" class="space-y-8" novalidate>
        <!-- Honeypot anti-spam (§6.5) -->
        <input type="text" name="website_trap" class="hidden" tabindex="-1" autocomplete="off">

        <!-- ==============================================
             STEP 1: INFO ACARA (§6.2)
             ============================================== -->
        <div data-step="1" class="space-y-6">
            <div class="border-b border-surface-variant/40 pb-4">
                <h3 class="font-headline-md text-2xl text-on-surface font-serif">Langkah 1: Rencana Acara Anda</h3>
                <p class="font-body-sm text-secondary text-xs sm:text-sm mt-1">
                    Beri tahu kami jadwal dan lokasi acara untuk mengamankan slot dapur kami.
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
                           name="event_date"
                           min="{{ $minDate }}" 
                           value="{{ $minDate }}"
                           required 
                           class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                    <p class="text-xs text-secondary leading-relaxed">
                        Acara kurang dari 2 hari lagi? <a href="https://wa.me/6281234567890?text=Halo%20Admin%2C%20saya%20butuh%20katering%20mendesak" target="_blank" rel="noopener noreferrer" class="text-primary font-semibold hover:underline">Chat admin via WhatsApp</a> untuk cek slot darurat.
                    </p>
                </div>

                <!-- Jam Dibutuhkan (08:00 - 18:00 WIB) -->
                <div class="space-y-2">
                    <label class="block font-label-md text-on-surface text-xs sm:text-sm font-semibold" for="event_time">
                        Jam Pesanan Tiba / Dibutuhkan *
                    </label>
                    <select id="event_time" 
                            name="event_time" 
                            required
                            class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                        <option value="08:00">08:00 WIB (Pagi)</option>
                        <option value="09:00">09:00 WIB</option>
                        <option value="10:00">10:00 WIB</option>
                        <option value="11:00" selected>11:00 WIB (Siang / Makan Siang)</option>
                        <option value="12:00">12:00 WIB</option>
                        <option value="13:00">13:00 WIB</option>
                        <option value="14:00">14:00 WIB</option>
                        <option value="15:00">15:00 WIB</option>
                        <option value="16:00">16:00 WIB</option>
                        <option value="17:00">17:00 WIB (Sore)</option>
                        <option value="18:00">18:00 WIB (Malam)</option>
                    </select>
                </div>
            </div>

            <!-- Jenis Acara Chips (§6.2) -->
            <div class="space-y-2">
                <label class="block font-label-md text-on-surface text-xs sm:text-sm font-semibold">
                    Jenis Acara / Keperluan
                </label>
                <div class="flex flex-wrap gap-2">
                    <button type="button" data-purpose-chip="Arisan Keluarga / RT" class="px-3.5 py-1.5 rounded-full bg-primary text-white text-xs font-semibold shadow-2xs transition-all">
                        Arisan Keluarga / RT
                    </button>
                    <button type="button" data-purpose-chip="Rapat Kantor / Seminar" class="px-3.5 py-1.5 rounded-full bg-surface-container text-on-surface hover:bg-surface-variant text-xs font-semibold transition-all">
                        Rapat Kantor / Seminar
                    </button>
                    <button type="button" data-purpose-chip="Pengajian / Tasyakuran" class="px-3.5 py-1.5 rounded-full bg-surface-container text-on-surface hover:bg-surface-variant text-xs font-semibold transition-all">
                        Pengajian / Tasyakuran
                    </button>
                    <button type="button" data-purpose-chip="Ulang Tahun / Syukuran" class="px-3.5 py-1.5 rounded-full bg-surface-container text-on-surface hover:bg-surface-variant text-xs font-semibold transition-all">
                        Ulang Tahun / Syukuran
                    </button>
                    <button type="button" data-purpose-chip="Pernikahan / Lamaran" class="px-3.5 py-1.5 rounded-full bg-surface-container text-on-surface hover:bg-surface-variant text-xs font-semibold transition-all">
                        Pernikahan / Lamaran
                    </button>
                </div>
                <input type="hidden" id="event_purpose" name="event_purpose" value="Arisan Keluarga / RT">
            </div>

            <!-- Pengantaran vs Ambil Sendiri (§6.2) -->
            <div class="space-y-4 pt-2">
                <label class="block font-label-md text-on-surface text-xs sm:text-sm font-semibold">
                    Metode Pengambilan Pesanan *
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <label class="p-4 rounded-2xl border border-surface-variant/60 bg-cream-bg flex items-center gap-3 cursor-pointer hover:border-primary transition-all">
                        <input type="radio" name="delivery_type" value="diantar" checked class="w-4 h-4 text-primary focus:ring-primary">
                        <div>
                            <span class="font-bold text-xs sm:text-sm text-on-surface block">Diantar ke Lokasi Acara</span>
                            <span class="text-secondary text-[11px] block">Armada kami siap antar ke alamat tujuan</span>
                        </div>
                    </label>
                    <label class="p-4 rounded-2xl border border-surface-variant/60 bg-cream-bg flex items-center gap-3 cursor-pointer hover:border-primary transition-all">
                        <input type="radio" name="delivery_type" value="ambil" class="w-4 h-4 text-primary focus:ring-primary">
                        <div>
                            <span class="font-bold text-xs sm:text-sm text-on-surface block">Ambil Sendiri di Dapur</span>
                            <span class="text-secondary text-[11px] block">Ambil langsung di dapur Yan's Food (Bebas ongkir)</span>
                        </div>
                    </label>
                </div>

                <!-- Textarea Alamat Pengantaran -->
                <div id="delivery-address-wrapper" class="space-y-2 pt-2">
                    <label class="block font-label-md text-on-surface text-xs sm:text-sm font-semibold" for="customer_address">
                        Alamat Lengkap Pengantaran *
                    </label>
                    <textarea id="customer_address" 
                              name="customer_address" 
                              rows="2" 
                              placeholder="Contoh: Jl. Melati No. 12, RT 03/RW 05, Kel. Sukamaju (Patokan dekat Masjid Al-Ikhlas)"
                              class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm leading-relaxed"></textarea>
                </div>
            </div>

            <!-- Navigation Button -->
            <div class="pt-6 flex justify-end border-t border-surface-variant/40">
                <button type="button" 
                        id="btn-next-step-1"
                        class="btn-primary w-full sm:w-auto">
                    <span>Lanjut ke Pilih Menu</span>
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </button>
            </div>
        </div>

        <!-- ==============================================
             STEP 2: PILIH MENU & ESTIMASI LIVE (§6.3)
             ============================================== -->
        <div data-step="2" class="hidden space-y-6">
            <div class="border-b border-surface-variant/40 pb-4">
                <h3 class="font-headline-md text-2xl text-on-surface font-serif">Langkah 2: Tentukan Menu Katering</h3>
                <p class="font-body-sm text-secondary text-xs sm:text-sm mt-1">
                    Pilih menu favorit Anda dan atur jumlah porsi yang dibutuhkan untuk tamu acara.
                </p>
            </div>

            <!-- Main Layout: Menu Catalog (Left) + Live Sticky Summary (Right) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <!-- Left Catalog Column (7 cols) -->
                <div class="lg:col-span-7 space-y-4">
                    <div class="flex items-center justify-between text-xs text-secondary font-semibold pb-1">
                        <span>DAFTAR MENU KATERING</span>
                        <span>ATUR PORSI (+ / -)</span>
                    </div>

                    <!-- Items List Container rendered by JS -->
                    <div id="catering-menu-items" class="space-y-3">
                        <!-- Populated dynamically via catering-form.js -->
                    </div>
                </div>

                <!-- Right Live Summary Column (5 cols) (§6.3) -->
                <div class="lg:col-span-5 sticky top-28 space-y-4">
                    <div class="p-6 rounded-3xl bg-sand-bg border border-surface-variant/60 shadow-xs space-y-5">
                        <div class="flex items-center justify-between border-b border-surface-variant/40 pb-3">
                            <span class="font-headline-sm font-serif font-bold text-base text-on-surface">Rincian Pesananmu</span>
                            <span id="live-items-count" class="font-label-sm text-xs text-secondary">0 item dipilih</span>
                        </div>

                        <!-- Selected Items List -->
                        <div id="live-selected-items-list" class="max-h-56 overflow-y-auto space-y-1">
                            <!-- Populated dynamically -->
                        </div>

                        <!-- Minimum Order Progress Rule (§6.3) -->
                        <div class="space-y-2 pt-2 border-t border-surface-variant/40">
                            <div class="w-full h-2 rounded-full bg-surface-variant/40 overflow-hidden">
                                <div id="min-order-progress" class="h-full bg-primary transition-all duration-300" style="width: 0%;"></div>
                            </div>
                            <div id="min-order-alert" class="p-3 rounded-xl bg-amber-50 text-amber-900 text-xs flex items-center gap-2 border border-amber-200">
                                <span class="material-symbols-outlined text-[18px] text-amber-600">info</span>
                                <span>Minimal pesanan katering adalah Rp 200.000</span>
                            </div>
                        </div>

                        <!-- Live Total Estimation -->
                        <div class="pt-3 border-t border-surface-variant/40 flex items-center justify-between">
                            <div>
                                <span class="font-label-sm text-xs text-secondary block">Estimasi Total</span>
                                <span class="text-[10px] text-secondary italic">Dikonfirmasi ulang oleh admin</span>
                            </div>
                            <div id="live-total-desktop" class="font-numeric-currency text-2xl font-bold text-primary font-serif">
                                Rp 0
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-surface-variant/40">
                <button type="button" 
                        data-action="prev-step" 
                        class="btn-outline w-full sm:w-auto">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    <span>Kembali ke Jadwal</span>
                </button>

                <button type="button" 
                        id="btn-next-step-2" 
                        disabled
                        class="btn-primary w-full sm:w-auto disabled:opacity-50 disabled:cursor-not-allowed">
                    <span>Lanjut ke Data Pemesan</span>
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </button>
            </div>
        </div>

        <!-- ==============================================
             STEP 3: DATA PEMESAN & KONFIRMASI (§6.4)
             ============================================== -->
        <div data-step="3" class="hidden space-y-6">
            <div class="border-b border-surface-variant/40 pb-4">
                <h3 class="font-headline-md text-2xl text-on-surface font-serif">Langkah 3: Data Pemesan & Konfirmasi</h3>
                <p class="font-body-sm text-secondary text-xs sm:text-sm mt-1">
                    Periksa kembali ringkasan pesanan Anda sebelum mengirim permintaan ke WhatsApp admin.
                </p>
            </div>

            <!-- Customer Contact Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block font-label-md text-on-surface text-xs sm:text-sm font-semibold" for="customer_name">
                        Nama Lengkap Pemesan *
                    </label>
                    <input type="text" 
                           id="customer_name" 
                           name="customer_name" 
                           autocomplete="name"
                           placeholder="Contoh: Ibu Siti Rahma" 
                           required 
                           class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                </div>

                <div class="space-y-2">
                    <label class="block font-label-md text-on-surface text-xs sm:text-sm font-semibold" for="customer_phone">
                        Nomor WhatsApp Aktif *
                    </label>
                    <div class="relative flex items-center">
                        <span class="absolute left-4 font-mono font-bold text-sm text-secondary select-none">
                            +62
                        </span>
                        <input type="tel" 
                               id="customer_phone" 
                               name="customer_phone" 
                               inputmode="tel"
                               autocomplete="tel"
                               placeholder="812 3456 7890" 
                               required 
                               class="w-full pl-14 pr-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                    </div>
                    <span class="text-[11px] text-secondary">Admin kami akan menghubungi nomor ini untuk konfirmasi akhir.</span>
                </div>
            </div>

            <!-- Special Notes (§6.4) -->
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <label class="block font-label-md text-on-surface text-xs sm:text-sm font-semibold" for="catering_notes">
                        Catatan Khusus (Opsional)
                    </label>
                    <span id="notes-char-count" class="text-xs text-secondary">0/500</span>
                </div>
                <textarea id="catering_notes" 
                          name="notes" 
                          rows="2" 
                          maxlength="500"
                          placeholder="Alergi makanan, tingkat pedas, permintaan kemasan khusus, atau request tambahan..." 
                          class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm leading-relaxed"></textarea>
            </div>

            <!-- Final Order Recap Card (§6.4) -->
            <div class="rounded-2xl bg-surface-container/40 p-5 sm:p-6 border border-surface-variant/50 space-y-4">
                <div class="flex items-center justify-between border-b border-surface-variant/40 pb-3">
                    <h4 class="font-headline-sm font-serif font-bold text-on-surface text-base">Ringkasan Pesanan Katering</h4>
                    <span class="text-xs text-primary font-semibold">Cek Sebelum Mengirim</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="text-secondary">Jadwal Acara:</span>
                            <a href="#" data-goto-step="1" class="text-primary hover:underline font-semibold">Ubah</a>
                        </div>
                        <p id="recap-schedule" class="font-bold text-on-surface">-</p>
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="text-secondary">Metode / Lokasi:</span>
                            <a href="#" data-goto-step="1" class="text-primary hover:underline font-semibold">Ubah</a>
                        </div>
                        <p id="recap-delivery" class="font-bold text-on-surface">-</p>
                    </div>
                </div>

                <div class="space-y-1.5 pt-3 border-t border-surface-variant/40">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-secondary">Menu yang Dipesan:</span>
                        <a href="#" data-goto-step="2" class="text-primary hover:underline font-semibold">Ubah</a>
                    </div>
                    <div id="recap-menu-list" class="space-y-1 text-on-surface">
                        <!-- Populated dynamically -->
                    </div>
                </div>

                <div class="pt-3 border-t border-surface-variant/40 flex items-center justify-between">
                    <span class="font-bold text-sm text-on-surface">Estimasi Total Biaya</span>
                    <span id="recap-total" class="font-numeric-currency text-xl font-bold text-primary font-serif">Rp 0</span>
                </div>
            </div>

            <!-- Agreement Checkbox (§6.4) -->
            <div class="pt-2">
                <label class="flex items-start gap-3 cursor-pointer">
                    <input type="checkbox" 
                           id="order_agreement" 
                           required 
                           class="w-5 h-5 rounded text-primary focus:ring-primary mt-0.5">
                    <span class="text-xs sm:text-sm text-secondary leading-relaxed select-none">
                        Saya paham ini merupakan formulir permintaan pesanan awal; total final dan kesepakatan uang muka (DP 50%) akan dikonfirmasi resmi oleh admin Yan's Food via WhatsApp.
                    </span>
                </label>
            </div>

            <!-- Navigation & Submit Action (§6.4) -->
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-surface-variant/40">
                <button type="button" 
                        data-action="prev-step" 
                        class="btn-outline w-full sm:w-auto">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    <span>Kembali ke Menu</span>
                </button>

                <button type="submit" 
                        id="btn-submit-catering" 
                        class="btn-primary w-full sm:w-auto px-8">
                    <span class="submit-spinner hidden material-symbols-outlined text-[20px] animate-spin">progress_activity</span>
                    <span class="submit-label">Kirim Pesanan Katering</span>
                    <span class="material-symbols-outlined text-[18px]">send</span>
                </button>
            </div>
        </div>
    </form>
</div>
