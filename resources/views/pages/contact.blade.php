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
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" data-reveal-group>
                        <!-- Card 1: Alamat -->
                        <div class="bg-surface-warm p-6 rounded-3xl shadow-xs hover:shadow-md transition-shadow border border-surface-variant/40 flex flex-col justify-between">
                            <div>
                                <div class="w-10 h-10 rounded-xl bg-surface-container flex items-center justify-center text-primary mb-4">
                                    <span class="material-symbols-outlined text-[22px]">location_on</span>
                                </div>
                                <h3 class="font-headline-sm text-on-surface mb-1 text-lg font-serif">Alamat &amp; Pick-up</h3>
                                <p class="font-body-sm text-on-surface font-semibold leading-relaxed">
                                    Jl. Melati No. 14, Jakarta Selatan
                                </p>
                                <p class="font-body-sm text-secondary mt-1.5 text-xs leading-normal">
                                    Patokan: 200m timur Masjid At-Taqwa. Parkir motor &amp; mobil teduh tersedia.
                                </p>
                            </div>
                            <div class="pt-4 mt-2">
                                <button type="button" 
                                        id="btn-copy-address"
                                        data-address="Jl. Melati No. 14, Jakarta Selatan"
                                        class="inline-flex items-center gap-1.5 text-xs font-label-md text-primary hover:text-primary-dark font-bold cursor-pointer">
                                    <span class="material-symbols-outlined text-[16px]">content_copy</span>
                                    <span>Salin Alamat</span>
                                </button>
                            </div>
                        </div>

                        <!-- Card 2: Jam Operasional -->
                        <div class="bg-surface-warm p-6 rounded-3xl shadow-xs hover:shadow-md transition-shadow border border-surface-variant/40">
                            <div class="w-10 h-10 rounded-xl bg-surface-container flex items-center justify-center text-primary mb-4">
                                <span class="material-symbols-outlined text-[22px]">schedule</span>
                            </div>
                            <h3 class="font-headline-sm text-on-surface mb-2 text-lg font-serif">Jam Buka Dapur</h3>
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
                            <span class="inline-block mt-3 px-2.5 py-0.5 rounded-full bg-success-surface text-success font-label-sm text-[11px] font-semibold">
                                Sedia Setiap Hari
                            </span>
                        </div>

                        <!-- Card 3: WhatsApp Resmi -->
                        <div class="bg-surface-warm p-6 rounded-3xl shadow-xs hover:shadow-md transition-shadow border border-surface-variant/40 flex flex-col justify-between">
                            <div>
                                <div class="w-10 h-10 rounded-xl bg-surface-container flex items-center justify-center text-primary mb-4">
                                    <span class="material-symbols-outlined text-[22px]">chat</span>
                                </div>
                                <h3 class="font-headline-sm text-on-surface mb-1 text-lg font-serif">WhatsApp Resmi</h3>
                                <p class="font-numeric-currency text-primary-container mb-1 tracking-normal text-base font-bold">
                                    +62 812-3456-7890
                                </p>
                                <p class="font-body-sm text-secondary text-xs">
                                    Layanan CS, informasi menu, &amp; pemesanan takeout/delivery.
                                </p>
                            </div>
                            <div class="pt-4 mt-2">
                                <a href="https://wa.me/6281234567890" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 text-xs font-label-md text-emerald-600 hover:text-emerald-700 font-bold">
                                    <span class="material-symbols-outlined text-[16px]">send</span>
                                    <span>Chat Langsung</span>
                                </a>
                            </div>
                        </div>

                        <!-- Card 4: Email & Sosmed -->
                        <div class="bg-surface-warm p-6 rounded-3xl shadow-xs hover:shadow-md transition-shadow border border-surface-variant/40">
                            <div class="w-10 h-10 rounded-xl bg-surface-container flex items-center justify-center text-primary mb-4">
                                <span class="material-symbols-outlined text-[22px]">alternate_email</span>
                            </div>
                            <h3 class="font-headline-sm text-on-surface mb-1 text-lg font-serif">Surel &amp; Medsos</h3>
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
                    </div>

                    <!-- Form Tanya Cepat via WhatsApp -->
                    <div class="bg-surface-warm p-6 sm:p-8 lg:p-10 rounded-3xl shadow-xs border border-surface-variant/40">
                        <div class="flex items-start justify-between gap-4 mb-6">
                            <div>
                                <span class="font-label-sm text-tertiary uppercase tracking-wider font-semibold text-xs">Tanya Cepat</span>
                                <h2 class="font-headline-sm text-on-surface mt-1 font-serif text-xl sm:text-2xl">Kirim Pesan ke Dapur</h2>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-sand-bg-alt flex items-center justify-center text-primary shrink-0">
                                <span class="material-symbols-outlined">mail</span>
                            </div>
                        </div>

                        <form class="space-y-5" id="contactForm">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div class="space-y-2">
                                    <label class="block font-label-md text-on-surface text-xs sm:text-sm font-semibold" for="fullName">Nama Lengkap *</label>
                                    <input type="text" 
                                           id="fullName" 
                                           placeholder="Contoh: Ibu Rina Hartono" 
                                           required 
                                           class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-sm">
                                </div>
                                <div class="space-y-2">
                                    <label class="block font-label-md text-on-surface text-xs sm:text-sm font-semibold" for="waNumber">Nomor WhatsApp *</label>
                                    <input type="tel" 
                                           id="waNumber" 
                                           placeholder="0812xxxxxxx" 
                                           required 
                                           class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-sm">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block font-label-md text-on-surface text-xs sm:text-sm font-semibold" for="inquiryType">Jenis Keperluan *</label>
                                <select id="inquiryType" 
                                        class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all cursor-pointer text-sm">
                                    <option value="Pertanyaan Seputar Menu">Pertanyaan Seputar Menu Harian &amp; Kudapan</option>
                                    <option value="Pemesanan Makanan / Takeaway">Pemesanan Makanan &amp; Takeaway</option>
                                    <option value="Kerjasama atau Masukan">Kerjasama, Masukan, atau Saran Rasa</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="block font-label-md text-on-surface text-xs sm:text-sm font-semibold" for="messageContent">Pesan Anda *</label>
                                <textarea id="messageContent" 
                                          rows="4" 
                                          placeholder="Tuliskan pertanyaan spesifik atau pesanan yang ingin ditanyakan..." 
                                          required 
                                          class="w-full px-4 py-3 rounded-xl bg-cream-bg text-on-surface font-body-md border border-surface-variant/60 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all resize-y text-sm"></textarea>
                            </div>

                            <button type="submit" 
                                    class="w-full inline-flex items-center justify-center gap-3 px-6 py-3.5 rounded-xl bg-primary text-white font-label-md hover:bg-primary-dark transition-all duration-200 shadow-md group active:scale-95 text-sm font-bold">
                                <span class="material-symbols-outlined text-[20px] group-hover:scale-110 transition-transform">send</span>
                                <span>Kirim Pesan via WhatsApp</span>
                            </button>

                            <p class="font-body-sm text-secondary text-center text-xs">
                                Pesan ini akan otomatis membuka aplikasi WhatsApp admin Yan's Food dengan teks terformat rapi.
                            </p>
                        </form>
                    </div>
                </div>

                <!-- Right Column: Location Map Facade & Pick-up Guide (§5.5) -->
                <div class="lg:col-span-5 flex flex-col gap-6">
                    <div class="bg-surface-warm rounded-3xl overflow-hidden shadow-xs border border-surface-variant/40 flex flex-col">
                        <!-- Map Facade Banner with CTA (§5.5) -->
                        <div class="relative w-full h-72 sm:h-80 bg-surface-container overflow-hidden group">
                            <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuA7y5-2aOwUWUp8TG6NCFQLOSRta_LK5hzQhQjCAERSfSvE1gliowLKgrrCoAfBtv9vJXDuTHVtCNEMVDXPKPRzYAp0XJO7mggJbE37wSRzSyaRRHm6Xc2ennHw-QkkElXtMaHPpXSWCfIDrp7ZtLMsU68bdekqgPUoq5MA-0Tb6kh_xn_5M_jVdAqvAOkHaZmdahfBVa5-96zFPMajx4ohvhiOUAZXwTfIZy82Rv7ScC8XkXxLBa5D" 
                                 alt="Peta Lokasi Yan's Food" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            
                            <div class="absolute bottom-4 left-4 right-4 p-4 rounded-2xl bg-surface-warm/95 backdrop-blur-md shadow-md border border-surface-variant/40 flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <span class="material-symbols-outlined text-primary text-[22px]">pin_drop</span>
                                    <span class="font-label-sm font-semibold text-on-surface text-xs sm:text-sm">Jakarta Selatan</span>
                                </div>
                                <a href="https://maps.google.com/?q=Jakarta+Selatan" target="_blank" rel="noopener" 
                                   class="text-xs font-label-md text-primary hover:underline flex items-center gap-1 font-bold">
                                    <span>Buka di Google Maps</span>
                                    <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                                </a>
                            </div>
                        </div>

                        <!-- Pick-up Instructions -->
                        <div class="p-6 sm:p-8 space-y-4">
                            <h3 class="font-headline-sm text-on-surface font-serif text-lg">Panduan Pengambilan Pesanan</h3>
                            <ul class="space-y-3 font-body-sm text-secondary text-xs sm:text-sm">
                                <li class="flex items-start gap-2.5">
                                    <span class="material-symbols-outlined text-success text-[18px] shrink-0 mt-0.5">check_circle</span>
                                    <span>Konfirmasikan pesanan via WhatsApp minimal 30 menit sebelum jadwal ambil di dapur.</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <span class="material-symbols-outlined text-success text-[18px] shrink-0 mt-0.5">check_circle</span>
                                    <span>Tunjukkan nama pemesan atau bukti invoice chat saat tiba di depan pintu dapur.</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <span class="material-symbols-outlined text-success text-[18px] shrink-0 mt-0.5">check_circle</span>
                                    <span>Pesanan dikemas rapi dalam kantong higienis dan bersuhu hangat siap santap.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
