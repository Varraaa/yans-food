<x-app-layout>
    <x-slot name="title">Cara Pesan — Online Delivery & Takeaway | Yan's Food</x-slot>

    <div>
        <!-- 1. Editorial Hero Header with Prominent Intent Switcher -->
        <section class="relative w-full py-12 lg:py-16 bg-cream-bg overflow-hidden border-b border-surface-variant/40" data-reveal>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 lg:px-12 relative z-10">
                <div class="max-w-3xl space-y-3">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-surface-container text-primary font-label-sm uppercase tracking-wider text-xs font-semibold">
                        <span class="material-symbols-outlined text-[16px]">local_mall</span>
                        <span>Pilihan Layanan Pesan Praktis & Cepat</span>
                    </div>
                    <h1 class="font-headline-lg text-3xl sm:text-4xl lg:text-5xl text-on-surface tracking-tight font-serif font-bold">
                        Pesan Sajian <span class="text-primary italic font-normal">Yan's Food</span>
                    </h1>
                    <p class="font-body-lg text-secondary leading-relaxed text-base sm:text-lg">
                        Nikmati aneka kudapan renyah dan santapan hangat khas dapur rumahan kami. Diantar langsung ke pintu Anda lewat aplikasi online atau pesan langsung untuk diambil di dapur.
                    </p>
                </div>

                <!-- Intent Switcher (2 Prominent Cards) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-8 max-w-4xl">
                    <!-- Intent Card 1: Pesan Lewat Aplikasi Mitra -->
                    <a href="#online" 
                       id="intent-card-online" 
                       class="intent-card flex items-start gap-4 group">
                        <div class="w-14 h-14 rounded-2xl bg-orange-100 text-primary flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                            <span class="material-symbols-outlined text-[28px]">moped</span>
                        </div>
                        <div class="space-y-1">
                            <div class="flex items-center justify-between">
                                <h3 class="font-headline-sm text-on-surface font-serif text-lg sm:text-xl font-bold group-hover:text-primary transition-colors">
                                    Pesan Lewat Aplikasi Delivery
                                </h3>
                                <span class="material-symbols-outlined text-secondary text-[20px] transition-transform duration-200 group-hover:translate-x-1">arrow_downward</span>
                            </div>
                            <p class="font-body-sm text-secondary text-xs sm:text-sm leading-relaxed">
                                Pesan instan lewat ShopeeFood, GoFood, atau GrabFood. Diantar hangat langsung ke rumah atau kantor Anda.
                            </p>
                            <span class="font-label-sm text-primary font-bold text-xs inline-flex items-center gap-1 pt-1">
                                <span>Pilih Mitra Pengantaran</span>
                                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                            </span>
                        </div>
                    </a>

                    <!-- Intent Card 2: Pesan Langsung / Ambil di Dapur -->
                    <a href="#takeaway" 
                       id="intent-card-takeaway" 
                       class="intent-card flex items-start gap-4 group">
                        <div class="w-14 h-14 rounded-2xl bg-amber-100 text-[#9B3100] flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                            <span class="material-symbols-outlined text-[28px]">storefront</span>
                        </div>
                        <div class="space-y-1">
                            <div class="flex items-center justify-between">
                                <h3 class="font-headline-sm text-on-surface font-serif text-lg sm:text-xl font-bold group-hover:text-primary transition-colors">
                                    Pesan Takeaway / Ambil Sendiri
                                </h3>
                                <span class="material-symbols-outlined text-secondary text-[20px] transition-transform duration-200 group-hover:translate-x-1">arrow_downward</span>
                            </div>
                            <p class="font-body-sm text-secondary text-xs sm:text-sm leading-relaxed">
                                Hubungi dapur via WhatsApp untuk siapkan pesanan terlebih dahulu, lalu ambil hangat tanpa antre di lokasi kami.
                            </p>
                            <span class="font-label-sm text-primary font-bold text-xs inline-flex items-center gap-1 pt-1">
                                <span>Panduan Pesan Ambil</span>
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
                                <div class="w-14 h-14 rounded-2xl bg-[#FFF0ED] flex items-center justify-center text-[#EE4D2D]">
                                    <svg class="w-8 h-8 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19 6h-3.18C15.4 3.84 13.78 2 12 2s-3.4 1.84-3.82 4H5c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-7-2c1.08 0 2.09 1.13 2.5 2h-5c.41-.87 1.42-2 2.5-2zm7 16H5V8h14v12zm-7-9c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 6c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
                                    </svg>
                                </div>
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
                                <div class="w-14 h-14 rounded-2xl bg-[#FFECEC] flex items-center justify-center text-[#ED2724]">
                                    <svg class="w-8 h-8 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 15c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm3-5c0 1.66-1.34 3-3 3s-3-1.34-3-3 1.34-3 3-3 3 1.34 3 3z"/>
                                    </svg>
                                </div>
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
                                <div class="w-14 h-14 rounded-2xl bg-[#E8F8F0] flex items-center justify-center text-[#00B14F]">
                                    <svg class="w-8 h-8 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z"/>
                                    </svg>
                                </div>
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

        <!-- 3. SECTION B: Takeaway & Pesan Langsung via WhatsApp (#takeaway) -->
        <section id="takeaway" class="w-full py-16 lg:py-24 bg-surface-container-low/50 scroll-mt-24" data-reveal>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 lg:px-12">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-14 items-center">
                    <!-- Left: Information & Instructions -->
                    <div class="lg:col-span-7 space-y-6">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-sand-bg-alt text-on-surface font-label-sm uppercase tracking-wider text-xs font-semibold">
                            <span class="material-symbols-outlined text-primary text-[16px]">storefront</span>
                            <span>Pesan Ambil di Dapur / Takeaway</span>
                        </div>
                        <h2 class="font-headline-lg text-3xl sm:text-4xl text-on-surface font-serif font-bold">
                            Ambil Hangat di Dapur Tanpa Menunggu
                        </h2>
                        <p class="font-body-lg text-secondary leading-relaxed text-base sm:text-lg">
                            Ingin makanan siap saat Anda tiba? Hubungi kami beberapa menit sebelumnya melalui WhatsApp, kami akan menyiapkan pesanan Anda hangat-hangat langsung dari penggorengan.
                        </p>

                        <!-- 3 Step Flow -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4">
                            <div class="p-4 rounded-2xl bg-surface-warm border border-surface-variant/40 shadow-xs space-y-2">
                                <div class="w-8 h-8 rounded-lg bg-orange-100 text-primary flex items-center justify-center font-bold text-sm font-serif">
                                    1
                                </div>
                                <h4 class="font-label-md font-bold text-on-surface text-sm">Pilih Menu</h4>
                                <p class="font-body-sm text-secondary text-xs leading-relaxed">
                                    Buka daftar menu kami dan tentukan varian kudapan atau sajian yang ingin dipesan.
                                </p>
                            </div>
                            <div class="p-4 rounded-2xl bg-surface-warm border border-surface-variant/40 shadow-xs space-y-2">
                                <div class="w-8 h-8 rounded-lg bg-orange-100 text-primary flex items-center justify-center font-bold text-sm font-serif">
                                    2
                                </div>
                                <h4 class="font-label-md font-bold text-on-surface text-sm">Chat WhatsApp</h4>
                                <p class="font-body-sm text-secondary text-xs leading-relaxed">
                                    Kirim daftar pesanan & jam estimasi tiba ke admin dapur kami via WhatsApp.
                                </p>
                            </div>
                            <div class="p-4 rounded-2xl bg-surface-warm border border-surface-variant/40 shadow-xs space-y-2">
                                <div class="w-8 h-8 rounded-lg bg-orange-100 text-primary flex items-center justify-center font-bold text-sm font-serif">
                                    3
                                </div>
                                <h4 class="font-label-md font-bold text-on-surface text-sm">Ambil Hangat</h4>
                                <p class="font-body-sm text-secondary text-xs leading-relaxed">
                                    Tiba di dapur Yan's Food, bayar secara tunai atau QRIS, dan nikmati sajian hangat.
                                </p>
                            </div>
                        </div>

                        <div class="pt-4 flex flex-wrap items-center gap-4">
                            <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Yan's%20Food,%20saya%20mau%20pesan%20takeaway" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="btn-whatsapp text-sm inline-flex">
                                <span class="material-symbols-outlined text-[18px]">chat</span>
                                <span>Pesan via WhatsApp Sekarang</span>
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
                                <h3 class="font-headline-sm text-on-surface font-serif text-lg font-bold">Lokasi Pick-up Dapur</h3>
                                <p class="font-body-sm text-secondary text-xs">Parkir mobil & motor nyaman tersedia</p>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-cream-bg border border-surface-variant/50 space-y-2">
                            <p class="font-label-md font-bold text-on-surface text-sm">Yan's Food Dapur Rumahan</p>
                            <p class="font-body-sm text-secondary text-xs leading-relaxed">
                                Jl. Melati No. 14, Jakarta Selatan (200m sebelah timur Masjid At-Taqwa).
                            </p>
                            <p class="font-body-sm text-primary text-xs font-semibold pt-1">
                                Jam Operasional Ambil: 08.00 – 20.00 WIB
                            </p>
                        </div>

                        <div class="pt-2">
                            <a href="{{ url('/contact') }}" class="inline-flex items-center gap-1.5 text-xs font-label-md text-primary font-bold hover:underline">
                                <span>Buka Peta & Petunjuk Arah Lengkap</span>
                                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
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

                    <!-- Accordion 1: Waktu Pembuatan -->
                    <div class="accordion-item is-open">
                        <button type="button" class="accordion-header" aria-expanded="true">
                            <span class="font-serif text-base sm:text-lg">Berapa lama waktu penyiapan pesanan?</span>
                            <span class="material-symbols-outlined accordion-icon">expand_more</span>
                        </button>
                        <div class="accordion-collapse">
                            <div class="accordion-content">
                                <div class="accordion-body">
                                    Semua kudapan kami digoreng dadakan saat pesanan masuk agar tetap renyah optimal. Rata-rata waktu penyiapan berkisar antara <strong>10–20 menit</strong> tergantung jumlah item pesanan Anda.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Accordion 2: Metode Pembayaran -->
                    <div class="accordion-item">
                        <button type="button" class="accordion-header" aria-expanded="false">
                            <span class="font-serif text-base sm:text-lg">Apa saja metode pembayaran yang diterima?</span>
                            <span class="material-symbols-outlined accordion-icon">expand_more</span>
                        </button>
                        <div class="accordion-collapse">
                            <div class="accordion-content">
                                <div class="accordion-body">
                                    Untuk pemesanan via aplikasi (ShopeeFood, GoFood, GrabFood), Anda dapat menggunakan e-wallet (ShopeePay, GoPay, OVO) atau kartu debit/kredit. Untuk pembelian langsung di dapur kami melayani Tunai (Cash) dan <strong>QRIS Semua Bank / E-Wallet</strong>.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Accordion 3: Ketersediaan Menu -->
                    <div class="accordion-item">
                        <button type="button" class="accordion-header" aria-expanded="false">
                            <span class="font-serif text-base sm:text-lg">Bagaimana jika menu favorit saya sedang habis?</span>
                            <span class="material-symbols-outlined accordion-icon">expand_more</span>
                        </button>
                        <div class="accordion-collapse">
                            <div class="accordion-content">
                                <div class="accordion-body">
                                    Karena kami membuat kudapan segar harian tanpa bahan pengawet, stok dibuat terbatas per kloter. Anda dapat mengecek status ketersediaan langsung di katalog online atau bertanya ke admin kami melalui WhatsApp.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
