<x-app-layout>
    <x-slot name="title">Kontak & Lokasi Dapur | Yan's Food</x-slot>

    <div class="relative w-full overflow-hidden">
        <div class="absolute -right-24 -top-24 w-96 h-96 rounded-full bg-primary/5 blur-3xl pointer-events-none"></div>
        <div class="absolute -left-20 bottom-0 w-80 h-80 rounded-full bg-tertiary-fixed-dim/20 blur-2xl pointer-events-none"></div>

        <!-- 1. Header -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 lg:px-12 pt-12 pb-10 flex flex-col items-center text-center" data-reveal>
            <h1 class="font-headline-lg text-3xl sm:text-4xl lg:text-5xl text-on-surface max-w-3xl tracking-tight mb-4 font-serif">
                Pintu Dapur Kami Selalu Terbuka untuk Anda
            </h1>
            <p class="font-body-lg text-secondary max-w-2xl leading-relaxed text-base sm:text-lg">
                Ada pertanyaan seputar menu, pemesanan, atau saran rasa? Kami siap menyambut Anda dengan ramah.
            </p>
        </section>

        <!-- 2. Main Content Grid -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 lg:px-12 py-6 pb-20 w-full" data-reveal>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
                
                <!-- Left Column: Info Cards & Form (7 Cols) -->
                <div class="lg:col-span-7 flex flex-col gap-8">
                    <!-- 4 Info Cards Grid -->
                    <!-- 4 Info Cards Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" data-reveal-group>
                        <!-- Card 1: Alamat -->
                        <div class="group hover-card-premium bg-surface-warm p-6 rounded-3xl shadow-xs border border-surface-variant/40 flex flex-col justify-between cursor-default">
                            <div>
                                <div class="w-10 h-10 rounded-xl bg-surface-container flex items-center justify-center text-primary mb-4 hover-icon-bounce shrink-0 shadow-2xs">
                                    <span class="material-symbols-outlined text-[22px]">location_on</span>
                                </div>
                                <h3 class="font-headline-sm text-on-surface mb-1 text-lg font-serif group-hover:text-primary transition-colors duration-300">Alamat &amp; Pick-up</h3>
                                <p class="font-body-sm text-on-surface font-semibold leading-relaxed">
                                    Bandung, Kp. Ciloa, RT.04/RW.10, Kec. Soreang
                                </p>
                                <p class="font-body-sm text-secondary mt-1.5 text-xs leading-normal">
                                    Kp. Ciloa, Soreang, Bandung. Parkir motor &amp; mobil teduh tersedia.
                                </p>
                            </div>
                            <div class="pt-4 mt-2">
                                <button type="button" 
                                        id="btn-copy-address"
                                        data-address="Bandung, Kp. Ciloa, RT.04/RW.10, Kec. Soreang"
                                        class="inline-flex items-center gap-1.5 text-xs font-label-md text-primary hover:text-primary-dark font-bold cursor-pointer transition-transform duration-200 group-hover:translate-x-1">
                                    <span class="material-symbols-outlined text-[16px]">content_copy</span>
                                    <span>Salin Alamat</span>
                                </button>
                            </div>
                        </div>

                        <!-- Card 2: Jam Operasional -->
                        <div class="group hover-card-premium bg-surface-warm p-6 rounded-3xl shadow-xs border border-surface-variant/40 flex flex-col justify-between cursor-default">
                            <div>
                                <div class="w-10 h-10 rounded-xl bg-surface-container flex items-center justify-center text-primary mb-4 hover-icon-bounce shrink-0 shadow-2xs">
                                    <span class="material-symbols-outlined text-[22px]">schedule</span>
                                </div>
                                <h3 class="font-headline-sm text-on-surface mb-2 text-lg font-serif group-hover:text-primary transition-colors duration-300">Jam Buka Dapur</h3>
                                <div class="space-y-1 text-xs sm:text-sm">
                                    <div class="flex items-center justify-between font-body-sm">
                                        <span class="text-secondary">Dapur &amp; Ambil:</span>
                                        <span class="font-semibold text-on-surface">08.00 - 20.00 WIB</span>
                                    </div>
                                    <div class="flex items-center justify-between font-body-sm">
                                        <span class="text-secondary">Delivery Online:</span>
                                        <span class="font-semibold text-on-surface">09.00 - 19.30 WIB</span>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-4 mt-2">
                                <span class="inline-block px-2.5 py-0.5 rounded-full bg-success-surface text-success font-label-sm text-[11px] font-semibold">
                                    Sedia Setiap Hari
                                </span>
                            </div>
                        </div>

                        <!-- Card 3: WhatsApp Resmi -->
                        <div class="group hover-card-premium bg-surface-warm p-6 rounded-3xl shadow-xs border border-surface-variant/40 flex flex-col justify-between cursor-default">
                            <div>
                                <div class="w-10 h-10 rounded-xl bg-surface-container flex items-center justify-center text-primary mb-4 hover-icon-bounce shrink-0 shadow-2xs">
                                    <span class="material-symbols-outlined text-[22px]">chat</span>
                                </div>
                                <h3 class="font-headline-sm text-on-surface mb-1 text-lg font-serif group-hover:text-primary transition-colors duration-300">WhatsApp Resmi</h3>
                                <p class="font-numeric-currency text-primary-container mb-1 tracking-normal text-base font-bold">
                                    +62 822-2122-2936
                                </p>
                                <p class="font-body-sm text-secondary text-xs">
                                    Layanan CS, informasi menu, &amp; pemesanan takeout/delivery.
                                </p>
                            </div>
                            <div class="pt-4 mt-2">
                                <a href="https://wa.me/6282221222936" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 text-xs font-label-md text-emerald-600 hover:text-emerald-700 font-bold transition-transform duration-200 group-hover:translate-x-1">
                                    <span class="material-symbols-outlined text-[16px]">send</span>
                                    <span>Chat Langsung</span>
                                </a>
                            </div>
                        </div>

                        <!-- Card 4: Email & Sosmed -->
                        <div class="group hover-card-premium bg-surface-warm p-6 rounded-3xl shadow-xs border border-surface-variant/40 flex flex-col justify-between cursor-default">
                            <div>
                                <div class="w-10 h-10 rounded-xl bg-surface-container flex items-center justify-center text-primary mb-4 hover-icon-bounce shrink-0 shadow-2xs">
                                    <span class="material-symbols-outlined text-[22px]">alternate_email</span>
                                </div>
                                <h3 class="font-headline-sm text-on-surface mb-1 text-lg font-serif group-hover:text-primary transition-colors duration-300">Surel &amp; Medsos</h3>
                                <a href="mailto:halo@yansfood.id" class="font-body-sm text-on-surface font-semibold hover:text-primary transition-colors block text-sm">
                                    halo@yansfood.id
                                </a>
                                <div class="flex items-center gap-3 mt-2 text-secondary font-body-sm text-xs">
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[16px] text-tertiary">photo_camera</span>
                                        @yansfood.official
                                    </span>
                                </div>
                            </div>
                            <div class="pt-4 mt-2 text-xs text-secondary font-label-sm">
                                <span>Respons Cepat</span>
                            </div>
                        </div>
                    </div>

                    <!-- Form Komunikasi & Negosiasi Pesanan Khusus / Katering via WhatsApp -->
                    <div class="bg-surface-warm p-6 sm:p-8 lg:p-10 rounded-3xl shadow-xs border border-surface-variant/40">
                        <div class="flex items-start justify-between gap-4 mb-4">
                            <div>
                                <span class="font-label-sm text-primary uppercase tracking-wider font-semibold text-xs">Komunikasi &amp; Negosiasi</span>
                                <h2 class="font-headline-sm text-on-surface mt-1 font-serif text-xl sm:text-2xl">Konsultasi Pesanan Khusus &amp; Katering</h2>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-sand-bg-alt flex items-center justify-center text-primary shrink-0">
                                <span class="material-symbols-outlined">handshake</span>
                            </div>
                        </div>

                        <p class="font-body-sm text-secondary text-xs sm:text-sm leading-relaxed mb-6">
                            Tertarik memesan kudapan atau makanan porsi besar untuk acara arisan, syukuran, atau pertemuan keluarga? Sampaikan rencana Anda di bawah untuk terhubung langsung dengan Admin Yan's Food di WhatsApp.
                        </p>

                        <form class="space-y-5" id="contactForm">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div class="space-y-2">
                                    <label class="block font-label-md text-on-surface text-xs sm:text-sm font-semibold" for="fullName">Nama Lengkap / Penanggung Jawab *</label>
                                    <input type="text" 
                                           id="fullName" 
                                           placeholder="Contoh: Ibu Rina Hartono" 
                                           required 
                                           class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-sm">
                                </div>
                                <div class="space-y-2">
                                    <label class="block font-label-md text-on-surface text-xs sm:text-sm font-semibold" for="waNumber">Nomor WhatsApp Aktif *</label>
                                    <input type="tel" 
                                           id="waNumber" 
                                           placeholder="Contoh: 0812xxxxxxx" 
                                           required 
                                           class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-sm">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block font-label-md text-on-surface text-xs sm:text-sm font-semibold" for="inquiryType">Topik / Jenis Keperluan *</label>
                                <select id="inquiryType" 
                                        class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all cursor-pointer text-sm">
                                    <option value="Konsultasi & Negosiasi Pesanan Katering Acara" selected>Konsultasi &amp; Negosiasi Pesanan Katering / Acara (Porsi Besar)</option>
                                    <option value="Negosiasi Paket Kudapan / Makanan Khusus">Negosiasi Paket Kudapan / Makanan Khusus</option>
                                    <option value="Pertanyaan Seputar Menu & Ketersediaan">Pertanyaan Seputar Menu Harian &amp; Dapur</option>
                                    <option value="Kerjasama atau Masukan Rasa">Kerjasama, Masukan, atau Saran Rasa</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div class="space-y-2">
                                    <label class="block font-label-md text-on-surface text-xs sm:text-sm font-semibold" for="portionEstimate">Estimasi Jumlah Porsi (Opsional)</label>
                                    <input type="text" 
                                           id="portionEstimate" 
                                           placeholder="Contoh: 30 - 50 box / porsi" 
                                           class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-sm">
                                </div>
                                <div class="space-y-2">
                                    <label class="block font-label-md text-on-surface text-xs sm:text-sm font-semibold" for="eventDate">Estimasi Tanggal Kebutuhan (Opsional)</label>
                                    <input type="text" 
                                           id="eventDate" 
                                           placeholder="Contoh: Sabtu, 28 Oktober 2026" 
                                           class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-sm">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block font-label-md text-on-surface text-xs sm:text-sm font-semibold" for="messageContent">Rincian Menu / Pesan Negosiasi *</label>
                                <textarea id="messageContent" 
                                          rows="4" 
                                          placeholder="Tuliskan varian menu yang diminati, kisaran budget, request khusus, atau pertanyaan yang ingin dinegosiasikan..." 
                                          required 
                                          class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all resize-y text-sm"></textarea>
                            </div>

                            <button type="submit" 
                                    class="btn-hover-sophisticated w-full inline-flex items-center justify-center gap-3 px-6 py-4 rounded-xl bg-primary text-white font-label-md hover:bg-primary-dark transition-all duration-300 shadow-md group active:scale-95 text-sm font-bold">
                                <span class="material-symbols-outlined text-[20px] group-hover:scale-115 group-hover:rotate-6 transition-transform duration-300">chat</span>
                                <span>Lanjutkan Negosiasi via WhatsApp Admin</span>
                                <span class="material-symbols-outlined text-[18px] opacity-70 group-hover:opacity-100 group-hover:translate-x-1.5 transition-all duration-300">arrow_forward</span>
                            </button>

                            <p class="font-body-sm text-secondary text-center text-xs">
                                Form ini akan langsung membuka WhatsApp resmi Admin Yan's Food dengan format pesan negosiasi yang rapi.
                            </p>
                        </form>
                    </div>
                </div>

                <!-- Right Column: Location Map Facade & Pick-up Guide (§5.5) -->
                <div class="lg:col-span-5 flex flex-col gap-6">
                    <div class="bg-surface-warm rounded-3xl overflow-hidden shadow-xs border border-surface-variant/40 flex flex-col">
                        <!-- Real Interactive Google Maps centered on Yan's Food Soreang Bandung -->
                        <div class="relative w-full h-72 sm:h-80 bg-surface-container overflow-hidden group">
                            <iframe 
                                src="https://maps.google.com/maps?q=Kp.+Ciloa,+RT.04/RW.10,+Soreang,+Bandung&t=&z=16&ie=UTF8&iwloc=&output=embed" 
                                class="w-full h-full border-0" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade"
                                title="Peta Lokasi Yan's Food Soreang Bandung">
                            </iframe>
                            
                            <div class="absolute bottom-3 left-3 right-3 p-3.5 rounded-2xl bg-surface-warm/95 backdrop-blur-md shadow-md border border-surface-variant/40 flex items-center justify-between pointer-events-auto">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-[20px]">pin_drop</span>
                                    <span class="font-label-sm font-semibold text-on-surface text-xs sm:text-sm truncate">Kp. Ciloa, Soreang, Bandung</span>
                                </div>
                                <a href="https://maps.app.goo.gl/KnCpj3ViPCHGNmH66" target="_blank" rel="noopener noreferrer" 
                                   class="text-xs font-label-md text-primary hover:underline flex items-center gap-1 font-bold shrink-0">
                                    <span>Buka di Google Maps</span>
                                    <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                                </a>
                            </div>
                        </div>

                        <!-- Pick-up & Walk-in Instructions -->
                        <div class="p-6 sm:p-8 space-y-4">
                            <h3 class="font-headline-sm text-on-surface font-serif text-lg">Panduan Datang Langsung ke Lokasi</h3>
                            <ul class="space-y-3 font-body-sm text-secondary text-xs sm:text-sm">
                                <li class="flex items-start gap-2.5">
                                    <span class="material-symbols-outlined text-success text-[18px] shrink-0 mt-0.5">check_circle</span>
                                    <span>Datang langsung ke dapur kami di Bandung, Kp. Ciloa, RT.04/RW.10, Kec. Soreang (Parkir motor &amp; mobil tersedia).</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <span class="material-symbols-outlined text-success text-[18px] shrink-0 mt-0.5">check_circle</span>
                                    <span>Pesan menu pilihan di kasir dapur, tunggu 10–15 menit pesanan disiapkan segar, dan bayar via Tunai atau QRIS.</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <span class="material-symbols-outlined text-amber-600 text-[18px] shrink-0 mt-0.5">no_meals</span>
                                    <span class="text-amber-900 font-medium">Hanya melayani bawa pulang (takeaway only). Dapur kami tidak menyediakan meja/kursi makan di tempat.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
