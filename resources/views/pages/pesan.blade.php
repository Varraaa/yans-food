<x-app-layout>
    <x-slot name="title">Cara Pesan — Online Delivery & Datang Langsung | Yan's Food</x-slot>

    <div>
        <!-- 1. Editorial Hero Header with Prominent Intent Switcher -->
        <section class="relative w-full py-12 lg:py-16 bg-cream-bg overflow-hidden border-b border-surface-variant/40" data-reveal>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 lg:px-12 relative z-10">
                <div class="max-w-3xl space-y-3">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-surface-container text-primary font-label-sm uppercase tracking-wider text-xs font-semibold">
                        <span class="material-symbols-outlined text-[16px]">local_mall</span>
                        <span>2 Pilihan Layanan Pemesanan Yan's Food</span>
                    </div>
                    <h1 class="font-headline-lg text-3xl sm:text-4xl lg:text-5xl text-on-surface tracking-tight font-serif font-bold">
                        Pesan Sajian <span class="text-primary italic font-normal">Yan's Food</span>
                    </h1>
                    <p class="font-body-lg text-secondary leading-relaxed text-base sm:text-lg">
                        Nikmati aneka kudapan renyah dan santapan hangat khas dapur rumahan kami melalui 2 pilihan layanan resmi: diantar langsung lewat aplikasi online delivery atau datang langsung ke tempat kami.
                    </p>
                </div>

                <!-- Intent Switcher (2 Prominent Cards) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-8 max-w-4xl">
                    <!-- Intent Card 1: Pesan Lewat Aplikasi Delivery -->
                    <a href="#online" 
                       id="intent-card-online" 
                       class="intent-card hover-card-premium flex items-start gap-4 group p-6 rounded-3xl bg-surface-warm border border-surface-variant/40 shadow-xs transition-all duration-300 cursor-pointer">
                        <div class="w-14 h-14 rounded-2xl bg-orange-100 text-primary flex items-center justify-center shrink-0 hover-icon-bounce shadow-2xs group-hover:shadow-md transition-all duration-300">
                            <span class="material-symbols-outlined text-[28px]">moped</span>
                        </div>
                        <div class="space-y-1.5 flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <h3 class="font-headline-sm text-on-surface font-serif text-lg sm:text-xl font-bold group-hover:text-primary transition-colors duration-300">
                                    1. Pesan Lewat Aplikasi Delivery
                                </h3>
                                <span class="material-symbols-outlined text-secondary text-[20px] transition-transform duration-300 group-hover:translate-y-1 group-hover:text-primary">arrow_downward</span>
                            </div>
                            <p class="font-body-sm text-secondary text-xs sm:text-sm leading-relaxed">
                                Pesan instan lewat ShopeeFood, GoFood, atau GrabFood. Diantar hangat langsung ke rumah atau kantor Anda oleh kurir aplikasi.
                            </p>
                            <span class="font-label-sm text-primary font-bold text-xs inline-flex items-center gap-1 pt-1 group-hover:translate-x-1 transition-transform duration-200">
                                <span>Pilih Mitra Pengantaran</span>
                                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                            </span>
                        </div>
                    </a>

                    <!-- Intent Card 2: Datang Langsung ke Tempat -->
                    <a href="#langsung" 
                       id="intent-card-takeaway" 
                       class="intent-card hover-card-premium flex items-start gap-4 group p-6 rounded-3xl bg-surface-warm border border-surface-variant/40 shadow-xs transition-all duration-300 cursor-pointer">
                        <div class="w-14 h-14 rounded-2xl bg-amber-100 text-primary flex items-center justify-center shrink-0 hover-icon-bounce shadow-2xs group-hover:shadow-md transition-all duration-300">
                            <span class="material-symbols-outlined text-[28px]">storefront</span>
                        </div>
                        <div class="space-y-1.5 flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <h3 class="font-headline-sm text-on-surface font-serif text-lg sm:text-xl font-bold group-hover:text-primary transition-colors duration-300">
                                    2. Datang Langsung ke Tempat
                                </h3>
                                <span class="material-symbols-outlined text-secondary text-[20px] transition-transform duration-300 group-hover:translate-y-1 group-hover:text-primary">arrow_downward</span>
                            </div>
                            <p class="font-body-sm text-secondary text-xs sm:text-sm leading-relaxed">
                                Datang langsung, pesan di tempat, tunggu pesanan disiapkan segar, terima &amp; bawa pulang. <em>(Konsep drive-thru / takeaway, tidak bisa makan di tempat)</em>.
                            </p>
                            <span class="font-label-sm text-primary font-bold text-xs inline-flex items-center gap-1 pt-1 group-hover:translate-x-1 transition-transform duration-200">
                                <span>Panduan Datang Langsung</span>
                                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                            </span>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <!-- 2. SECTION A: Pesan Online Platform (#online) -->
        <section id="online" class="w-full py-16 lg:py-20 bg-surface-warm/40 scroll-mt-24" data-reveal>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 lg:px-12">
                <!-- Section Intro & Highlights -->
                <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8 mb-12">
                    <div class="max-w-2xl space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-[22px]">delivery_dining</span>
                            <span class="font-label-md text-primary tracking-wide uppercase text-xs sm:text-sm font-semibold">Pesan Langsung Antar Hari Ini</span>
                        </div>
                        <h2 class="font-headline-md text-2xl sm:text-3xl text-on-surface font-serif font-bold">
                            Pesan Lewat Aplikasi Favoritmu
                        </h2>
                        <p class="font-body-md text-secondary leading-relaxed text-sm sm:text-base">
                            Semua kudapan dan sajian hangat Yan's Food digoreng dan dimasak segar per pesanan. Pilih aplikasi langgananmu di bawah untuk mengecek voucher diskon dan promo gratis ongkir.
                        </p>
                    </div>

                    <!-- Operational Micro Card -->
                    <div class="p-4 sm:p-5 rounded-2xl bg-surface-container shadow-xs flex items-center gap-4 border border-surface-variant/40 shrink-0">
                        <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0 text-emerald-800">
                            <span class="material-symbols-outlined text-[24px]">schedule</span>
                        </div>
                        <div>
                            <p class="font-label-sm text-secondary text-xs font-medium">Jam Buka Dapur Online</p>
                            <p class="font-label-md text-on-surface font-bold text-sm">08.00 – 20.00 WIB (Setiap Hari)</p>
                        </div>
                    </div>
                </div>

                <!-- 3 Platform Delivery Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                    <!-- ShopeeFood Card -->
                    <a href="https://shopee.co.id/universal-link/now-food" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="group rounded-3xl bg-surface-warm p-5 sm:p-6 lg:p-8 shadow-xs hover:shadow-lg border border-surface-variant/40 flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <img src="{{ asset('images/platforms/shopeefood.svg') }}" alt="ShopeeFood" class="w-14 h-14 rounded-2xl shadow-sm group-hover:scale-105 transition-transform duration-300 shrink-0">
                                <span class="px-3 py-1 rounded-full bg-[#FFF0ED] text-[#EE4D2D] font-label-sm text-xs font-semibold">
                                    ShopeeFood
                                </span>
                            </div>
                            <div>
                                <h3 class="font-headline-sm text-on-surface font-serif text-xl font-bold mb-1 group-hover:text-primary transition-colors">
                                    Yan's Food di ShopeeFood
                                </h3>
                                <p class="font-body-sm text-secondary leading-relaxed text-xs sm:text-sm">
                                    Klaim voucher diskon s/d 50% dan voucher gratis ongkir setiap hari lewat aplikasi Shopee Anda.
                                </p>
                            </div>
                            <div class="pt-2 flex items-center gap-2 text-secondary font-label-sm text-xs">
                                <span class="material-symbols-outlined text-[18px] text-tertiary">check_circle</span>
                                <span>Menu lengkap & promo aktif</span>
                            </div>
                        </div>
                        <div class="pt-6 border-t border-surface-variant/40 mt-6 flex items-center justify-between text-primary font-label-md font-bold text-xs sm:text-sm">
                            <span>Buka di ShopeeFood</span>
                            <span class="material-symbols-outlined text-[18px] transition-transform duration-200 group-hover:translate-x-1 group-hover:-translate-y-1">arrow_outward</span>
                        </div>
                    </a>

                    <!-- GoFood Card -->
                    <a href="https://gofood.link" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="group rounded-3xl bg-surface-warm p-5 sm:p-6 lg:p-8 shadow-xs hover:shadow-lg border border-surface-variant/40 flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <img src="{{ asset('images/platforms/gofood.svg') }}" alt="GoFood" class="w-14 h-14 rounded-2xl shadow-sm group-hover:scale-105 transition-transform duration-300 shrink-0">
                                <span class="px-3 py-1 rounded-full bg-[#FFECEC] text-[#ED2724] font-label-sm text-xs font-semibold">
                                    GoFood
                                </span>
                            </div>
                            <div>
                                <h3 class="font-headline-sm text-on-surface font-serif text-xl font-bold mb-1 group-hover:text-primary transition-colors">
                                    Yan's Food di GoFood
                                </h3>
                                <p class="font-body-sm text-secondary leading-relaxed text-xs sm:text-sm">
                                    Pengantaran super cepat dengan GoSend Instant. Tersedia promo GoPay Coins dan langganan GoFood PLUS.
                                </p>
                            </div>
                            <div class="pt-2 flex items-center gap-2 text-secondary font-label-sm text-xs">
                                <span class="material-symbols-outlined text-[18px] text-tertiary">check_circle</span>
                                <span>Rating 4.9 & Super Partner</span>
                            </div>
                        </div>
                        <div class="pt-6 border-t border-surface-variant/40 mt-6 flex items-center justify-between text-primary font-label-md font-bold text-xs sm:text-sm">
                            <span>Buka di GoFood</span>
                            <span class="material-symbols-outlined text-[18px] transition-transform duration-200 group-hover:translate-x-1 group-hover:-translate-y-1">arrow_outward</span>
                        </div>
                    </a>

                    <!-- GrabFood Card -->
                    <a href="https://food.grab.com" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="group rounded-3xl bg-surface-warm p-5 sm:p-6 lg:p-8 shadow-xs hover:shadow-lg border border-surface-variant/40 flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <img src="{{ asset('images/platforms/grabfood.svg') }}" alt="GrabFood" class="w-14 h-14 rounded-2xl shadow-sm group-hover:scale-105 transition-transform duration-300 shrink-0">
                                <span class="px-3 py-1 rounded-full bg-[#E8F8F0] text-[#00B14F] font-label-sm text-xs font-semibold">
                                    GrabFood
                                </span>
                            </div>
                            <div>
                                <h3 class="font-headline-sm text-on-surface font-serif text-xl font-bold mb-1 group-hover:text-primary transition-colors">
                                    Yan's Food di GrabFood
                                </h3>
                                <p class="font-body-sm text-secondary leading-relaxed text-xs sm:text-sm">
                                    Nikmati promo GrabUnlimited, voucher potongan harga, dan pembayaran praktis via OVO.
                                </p>
                            </div>
                            <div class="pt-2 flex items-center gap-2 text-secondary font-label-sm text-xs">
                                <span class="material-symbols-outlined text-[18px] text-tertiary">check_circle</span>
                                <span>Mitra resmi bintang 5</span>
                            </div>
                        </div>
                        <div class="pt-6 border-t border-surface-variant/40 mt-6 flex items-center justify-between text-primary font-label-md font-bold text-xs sm:text-sm">
                            <span>Buka di GrabFood</span>
                            <span class="material-symbols-outlined text-[18px] transition-transform duration-200 group-hover:translate-x-1 group-hover:-translate-y-1">arrow_outward</span>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <!-- 3. SECTION B: Datang Langsung ke Tempat (#langsung / #takeaway) -->
        <section id="langsung" class="w-full py-16 lg:py-24 bg-surface-container-low/50 scroll-mt-24" data-reveal>
            <!-- Backwards-compatible anchor for legacy links -->
            <span id="takeaway" class="sr-only"></span>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 lg:px-12">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-14 items-center">
                    <!-- Left: Information & Instructions -->
                    <div class="lg:col-span-7 space-y-6">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-sand-bg-alt text-on-surface font-label-sm uppercase tracking-wider text-xs font-semibold">
                            <span class="material-symbols-outlined text-primary text-[16px]">storefront</span>
                            <span>Datang Langsung ke Tempat (Pesan &amp; Bawa Pulang)</span>
                        </div>
                        <h2 class="font-headline-lg text-3xl sm:text-4xl text-on-surface font-serif font-bold">
                            Pesan Langsung di Tempat, Bawa Pulang Hangat
                        </h2>
                        <p class="font-body-lg text-secondary leading-relaxed text-base sm:text-lg">
                            Konsep layanan simpel mirip <em>drive-thru</em>: Anda datang langsung ke lokasi dapur kami, pesan menu favorit di tempat, tunggu beberapa menit pesanan disiapkan dan digoreng hangat dadakan, terima pesanan terkemas rapi, lalu siap dibawa pulang.
                        </p>


                        <!-- 4 Step Flow: Datang -> Pesan -> Tunggu -> Bawa Pulang -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 pt-2">
                            <div class="p-4 rounded-2xl bg-surface-warm border border-surface-variant/40 shadow-xs space-y-2">
                                <div class="w-8 h-8 rounded-lg bg-orange-100 text-primary flex items-center justify-center font-bold text-sm font-serif">
                                    1
                                </div>
                                <h4 class="font-label-md font-bold text-on-surface text-sm">Datang ke Tempat</h4>
                                <p class="font-body-sm text-secondary text-xs leading-relaxed">
                                    Kunjungi lokasi dapur kami di Bandung, Kp. Ciloa, RT.04/RW.10, Kec. Soreang. Parkir nyaman tersedia.
                                </p>
                            </div>
                            <div class="p-4 rounded-2xl bg-surface-warm border border-surface-variant/40 shadow-xs space-y-2">
                                <div class="w-8 h-8 rounded-lg bg-orange-100 text-primary flex items-center justify-center font-bold text-sm font-serif">
                                    2
                                </div>
                                <h4 class="font-label-md font-bold text-on-surface text-sm">Pesan di Kasir</h4>
                                <p class="font-body-sm text-secondary text-xs leading-relaxed">
                                    Pesan langsung menu kudapan atau makanan di tempat dan bayar via Tunai / QRIS.
                                </p>
                            </div>
                            <div class="p-4 rounded-2xl bg-surface-warm border border-surface-variant/40 shadow-xs space-y-2">
                                <div class="w-8 h-8 rounded-lg bg-orange-100 text-primary flex items-center justify-center font-bold text-sm font-serif">
                                    3
                                </div>
                                <h4 class="font-label-md font-bold text-on-surface text-sm">Tunggu Disiapkan</h4>
                                <p class="font-body-sm text-secondary text-xs leading-relaxed">
                                    Tunggu 10–15 menit selagi pesanan digoreng &amp; dimasak hangat dadakan.
                                </p>
                            </div>
                            <div class="p-4 rounded-2xl bg-surface-warm border border-surface-variant/40 shadow-xs space-y-2">
                                <div class="w-8 h-8 rounded-lg bg-orange-100 text-primary flex items-center justify-center font-bold text-sm font-serif">
                                    4
                                </div>
                                <h4 class="font-label-md font-bold text-on-surface text-sm">Terima &amp; Pulang</h4>
                                <p class="font-body-sm text-secondary text-xs leading-relaxed">
                                    Terima paket rapi bersegel higienis dan bawa pulang untuk dinikmati di rumah.
                                </p>
                            </div>
                        </div>

                        <div class="pt-4 flex flex-wrap items-center gap-4">
                            <a href="https://maps.app.goo.gl/KnCpj3ViPCHGNmH66" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="btn-primary text-sm inline-flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">directions</span>
                                <span>Petunjuk Arah Google Maps</span>
                            </a>
                            <a href="{{ url('/menu') }}" class="btn-outline text-sm">
                                <span>Lihat Daftar Menu Lengkap</span>
                            </a>
                        </div>
                    </div>

                    <!-- Right: Kitchen Location Card -->
                    <div class="lg:col-span-5 bg-surface-warm p-6 sm:p-8 rounded-3xl border border-surface-variant/40 shadow-sm space-y-5">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-surface-container flex items-center justify-center text-primary shrink-0">
                                <span class="material-symbols-outlined text-[26px]">location_on</span>
                            </div>
                            <div>
                                <h3 class="font-headline-sm text-on-surface font-serif text-lg font-bold">Lokasi Dapur Yan's Food</h3>
                                <p class="font-body-sm text-secondary text-xs">Titik datang langsung &amp; ambil pesanan</p>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-cream-bg border border-surface-variant/50 space-y-2">
                            <p class="font-label-md font-bold text-on-surface text-sm">Yan's Food Dapur Rumahan</p>
                            <p class="font-body-sm text-secondary text-xs leading-relaxed">
                                Bandung, Kp. Ciloa, RT.04/RW.10, Kec. Soreang.
                            </p>
                            <div class="pt-1 flex items-center justify-between text-xs font-semibold">
                                <span class="text-secondary">Jam Layanan:</span>
                                <span class="text-primary font-bold">08.00 – 20.00 WIB (Setiap Hari)</span>
                            </div>
                        </div>

                        <div class="pt-2">
                            <a href="https://maps.app.goo.gl/KnCpj3ViPCHGNmH66" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-primary text-white font-label-md hover:bg-primary-dark transition-all text-xs sm:text-sm font-bold shadow-xs">
                                <span class="material-symbols-outlined text-[18px]">near_me</span>
                                <span>Buka di Google Maps</span>
                                <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- FAQ Accordions on Ordering -->
                <div class="max-w-4xl mx-auto mt-20 space-y-4" data-accordion-group="single">
                    <div class="text-center mb-8 space-y-2">
                        <span class="font-label-sm text-primary uppercase tracking-wider text-xs font-bold">Pusat Bantuan</span>
                        <h3 class="font-headline-md text-2xl text-on-surface font-serif font-bold">Pertanyaan Seputar Pemesanan</h3>
                    </div>

                    <!-- Accordion 1: Dine In / Makan di Tempat -->
                    <div class="accordion-item is-open">
                        <button type="button" class="accordion-header" aria-expanded="true">
                            <span class="font-serif text-base sm:text-lg">Apakah bisa makan di tempat (dine-in)?</span>
                            <span class="material-symbols-outlined accordion-icon">expand_more</span>
                        </button>
                        <div class="accordion-collapse">
                            <div class="accordion-content">
                                <div class="accordion-body">
                                    <strong>Tidak bisa.</strong> Yan's Food tidak menyediakan meja maupun kursi makan di tempat. Layanan datang langsung kami berkonsep seperti <em>drive-thru</em>: pelanggan datang, memesan langsung di kasir dapur, menunggu pesanan disiapkan hangat, menerima pesanan yang telah dikemas rapi, lalu membawanya pulang untuk dinikmati bersama keluarga atau rekan kerja.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Accordion 2: Waktu Pembuatan -->
                    <div class="accordion-item">
                        <button type="button" class="accordion-header" aria-expanded="false">
                            <span class="font-serif text-base sm:text-lg">Berapa lama waktu penyiapan pesanan saat datang langsung?</span>
                            <span class="material-symbols-outlined accordion-icon">expand_more</span>
                        </button>
                        <div class="accordion-collapse">
                            <div class="accordion-content">
                                <div class="accordion-body">
                                    Semua kudapan dan sajian kami digoreng/dimasak dadakan per pesanan agar tetap renyah optimal. Rata-rata waktu penyiapan berkisar antara <strong>10–15 menit</strong> tergantung jumlah item pesanan Anda.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Accordion 3: Metode Pembayaran -->
                    <div class="accordion-item">
                        <button type="button" class="accordion-header" aria-expanded="false">
                            <span class="font-serif text-base sm:text-lg">Apa saja metode pembayaran yang diterima?</span>
                            <span class="material-symbols-outlined accordion-icon">expand_more</span>
                        </button>
                        <div class="accordion-collapse">
                            <div class="accordion-content">
                                <div class="accordion-body">
                                    Untuk pemesanan via aplikasi (ShopeeFood, GoFood, GrabFood), Anda dapat menggunakan e-wallet (ShopeePay, GoPay, OVO) atau kartu debit/kredit. Untuk pembelian datang langsung di tempat, kami melayani Tunai (Cash) dan <strong>QRIS Semua Bank / E-Wallet</strong>.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Accordion 4: Ketersediaan Menu -->
                    <div class="accordion-item">
                        <button type="button" class="accordion-header" aria-expanded="false">
                            <span class="font-serif text-base sm:text-lg">Bagaimana jika menu favorit saya sedang habis?</span>
                            <span class="material-symbols-outlined accordion-icon">expand_more</span>
                        </button>
                        <div class="accordion-collapse">
                            <div class="accordion-content">
                                <div class="accordion-body">
                                    Karena kami membuat sajian segar harian tanpa bahan pengawet, stok dibuat terbatas per kloter. Anda dapat mengecek status ketersediaan langsung di katalog menu online website ini atau bertanya ke admin kami.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
