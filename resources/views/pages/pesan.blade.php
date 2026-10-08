<x-app-layout>
    <x-slot name="title">Cara Pesan — Online Delivery & Katering | Yan's Food</x-slot>

    <!-- Minimalist Editorial Hero Header -->
    <section class="relative w-full py-12 lg:py-20 bg-surface-container-low overflow-hidden border-b border-surface-variant/40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 relative z-10">
            <div class="max-w-3xl space-y-4">
                <h1 class="font-headline-lg text-3xl sm:text-4xl lg:text-5xl text-on-surface tracking-tight font-serif">
                    Cara Pesan <span class="text-primary italic font-medium">Yan's Food</span>
                </h1>
                <p class="font-body-lg text-secondary leading-relaxed text-base sm:text-lg">
                    Nikmati hidangan kami untuk santapan harian praktis langsung antar, atau pesan paket katering untuk momen spesial bersama keluarga & rekan.
                </p>
            </div>
        </div>
        <!-- Ambient Warm Texture Ring -->
        <div class="absolute -right-24 -bottom-24 w-96 h-96 rounded-full bg-gradient-to-tr from-primary-fixed/20 to-tertiary-fixed/30 blur-3xl pointer-events-none"></div>
    </section>

    <!-- SECTION A: Instan Online Delivery -->
    <section class="w-full py-16 lg:py-20 bg-cream-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
            <!-- Section Intro & Highlights -->
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8 mb-12">
                <div class="max-w-2xl space-y-3">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[22px]">moped</span>
                        <span class="font-label-md text-primary tracking-wide uppercase text-xs sm:text-sm font-semibold">Pesan Langsung Antar</span>
                    </div>
                    <h2 class="font-headline-md text-2xl sm:text-3xl text-on-surface font-serif">Mau Makan Sekarang? Pesan Online</h2>
                    <p class="font-body-md text-secondary leading-relaxed">
                        Nggak sempat mampir atau lagi sibuk di kantor? Menu favorit Yan's Food seperti Risol Mayo, Nasi Goreng Jadul, dan aneka minuman segar siap meluncur hangat ke tempatmu melalui mitra delivery terpercaya.
                    </p>
                </div>

                <!-- Operational Micro Card -->
                <div class="p-4 sm:p-5 rounded-2xl bg-surface-warm shadow-sm flex items-center gap-4 border border-surface-variant/40 shrink-0">
                    <div class="w-12 h-12 rounded-xl bg-success-surface flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-success text-[24px]">schedule</span>
                    </div>
                    <div>
                        <p class="font-label-sm text-secondary text-xs">Estimasi Pengantaran Cepat</p>
                        <p class="font-label-md text-on-surface font-semibold text-sm">09.00 – 19.30 WIB (Tiap Hari)</p>
                    </div>
                </div>
            </div>

            <!-- 3 Delivery Platforms Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                <!-- ShopeeFood Card -->
                <div class="group relative rounded-3xl bg-surface-warm p-6 sm:p-8 shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:shadow-md flex flex-col justify-between border border-surface-variant/40">
                    <div class="space-y-5">
                        <div class="flex items-start justify-between">
                            <div class="w-14 h-14 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center shadow-inner">
                                <span class="material-symbols-outlined text-[32px]">shopping_bag</span>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-primary-fixed text-on-primary-fixed-variant font-label-sm text-xs font-semibold">
                                Promo Ongkir & Diskon
                            </span>
                        </div>
                        <div>
                            <h3 class="font-headline-sm text-on-surface mb-1 font-serif text-xl">ShopeeFood</h3>
                            <p class="font-body-sm text-secondary leading-relaxed">
                                Klaim aneka voucher gratis ongkir dan diskon merchant mingguan resmi toko Yan's Food.
                            </p>
                        </div>
                        <div class="pt-2 flex items-center gap-2 text-secondary font-label-sm text-xs">
                            <span class="material-symbols-outlined text-[18px] text-tertiary">check_circle</span>
                            <span>Menu harian terlengkap & promo bundling</span>
                        </div>
                    </div>
                    <div class="pt-8">
                        <a href="https://shopee.co.id" target="_blank" rel="noopener noreferrer" 
                           class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-primary-container text-on-primary font-label-md transition-colors duration-200 hover:bg-primary-dark shadow-sm active:scale-95">
                            <span>Buka di ShopeeFood</span>
                            <span class="material-symbols-outlined text-[18px]">arrow_outward</span>
                        </a>
                    </div>
                </div>

                <!-- GoFood Card -->
                <div class="group relative rounded-3xl bg-surface-warm p-6 sm:p-8 shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:shadow-md flex flex-col justify-between border border-surface-variant/40">
                    <div class="space-y-5">
                        <div class="flex items-start justify-between">
                            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-inner">
                                <span class="material-symbols-outlined text-[32px]">restaurant</span>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-success-surface text-success font-label-sm text-xs font-semibold">
                                Pengiriman Tercepat
                            </span>
                        </div>
                        <div>
                            <h3 class="font-headline-sm text-on-surface mb-1 font-serif text-xl">GoFood</h3>
                            <p class="font-body-sm text-secondary leading-relaxed">
                                Armada driver gesit siap mengantarkan pesanan hangat tiba di meja makan tepat waktu.
                            </p>
                        </div>
                        <div class="pt-2 flex items-center gap-2 text-secondary font-label-sm text-xs">
                            <span class="material-symbols-outlined text-[18px] text-tertiary">check_circle</span>
                            <span>Packaging tersegel rapi & higienis</span>
                        </div>
                    </div>
                    <div class="pt-8">
                        <a href="https://gofood.co.id" target="_blank" rel="noopener noreferrer" 
                           class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-primary-container text-on-primary font-label-md transition-colors duration-200 hover:bg-primary-dark shadow-sm active:scale-95">
                            <span>Buka di GoFood</span>
                            <span class="material-symbols-outlined text-[18px]">arrow_outward</span>
                        </a>
                    </div>
                </div>

                <!-- GrabFood Card -->
                <div class="group relative rounded-3xl bg-surface-warm p-6 sm:p-8 shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:shadow-md flex flex-col justify-between border border-surface-variant/40">
                    <div class="space-y-5">
                        <div class="flex items-start justify-between">
                            <div class="w-14 h-14 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center shadow-inner">
                                <span class="material-symbols-outlined text-[32px]">local_mall</span>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-xs font-semibold">
                                Rating 4.9 Bintang
                            </span>
                        </div>
                        <div>
                            <h3 class="font-headline-sm text-on-surface mb-1 font-serif text-xl">GrabFood</h3>
                            <p class="font-body-sm text-secondary leading-relaxed">
                                Langganan GrabUnlimited? Nikmati potongan harga spesial serta kemudahan opsi pembayaran.
                            </p>
                        </div>
                        <div class="pt-2 flex items-center gap-2 text-secondary font-label-sm text-xs">
                            <span class="material-symbols-outlined text-[18px] text-tertiary">check_circle</span>
                            <span>Dapur terverifikasi higienis bintang 5</span>
                        </div>
                    </div>
                    <div class="pt-8">
                        <a href="https://food.grab.com" target="_blank" rel="noopener noreferrer" 
                           class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-primary-container text-on-primary font-label-md transition-colors duration-200 hover:bg-primary-dark shadow-sm active:scale-95">
                            <span>Buka di GrabFood</span>
                            <span class="material-symbols-outlined text-[18px]">arrow_outward</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Visual Divider with Warm Gold Ornaments -->
    <div class="w-full py-8 bg-cream-bg flex items-center justify-center">
        <div class="max-w-7xl w-full px-6 lg:px-12 flex items-center gap-4">
            <div class="flex-1 h-px bg-surface-variant"></div>
            <div class="flex items-center gap-3 px-4 py-1.5 rounded-full bg-surface-container-high/60 border border-surface-variant/40">
                <span class="material-symbols-outlined text-tertiary text-[18px]">skillet</span>
                <span class="material-symbols-outlined text-primary text-[20px]">local_dining</span>
                <span class="material-symbols-outlined text-tertiary text-[18px]">dinner_dining</span>
            </div>
            <div class="flex-1 h-px bg-surface-variant"></div>
        </div>
    </div>

    <!-- SECTION B: Catering Service & Reservation Form -->
    <section class="w-full py-16 lg:py-24 bg-surface-container-low/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-14 space-y-4">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-sand-bg-alt text-on-surface font-label-sm uppercase tracking-wider text-xs">
                    <span class="material-symbols-outlined text-primary text-[16px]">celebration</span>
                    <span>Untuk Acara & Momen Istimewa</span>
                </div>
                <h2 class="font-headline-lg text-3xl sm:text-4xl text-on-surface font-serif">Layanan Katering Rumahan Berkualitas</h2>
                <p class="font-body-lg text-secondary leading-relaxed text-base sm:text-lg">
                    Pilihan snack box dan nasi kotak higienis, lezat, dan tepat waktu untuk arisan, pengajian, rapat kantor, dan pesta keluarga Anda.
                </p>
            </div>

            <!-- Catering Packages Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
                <!-- Paket 1: Snack Box -->
                <div class="rounded-3xl bg-surface-warm p-6 sm:p-8 shadow-sm flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 border border-surface-variant/40">
                    <div class="space-y-6">
                        <div class="aspect-[4/3] w-full rounded-2xl overflow-hidden bg-surface-variant relative">
                            <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuARZOQ96wet-CMX5rdD7lCFZyLs1EkrpKnlUC0RR99N8F7qRKAtVDp0zOXrFg0euopAroL4wdJES5KEUP4Mc10u-UzZYXlvj3_U850HmHFdI-2qa02DqfAOUMw-0VbCaGvmAt2949p2eWuHqz3RcdS7ODq1G6OninQUnQZKMoxPO6O-lS3WjYQWINUV6vdxskptYAzfbyMOIB5K2-d37eZht5g2KMxF67gGOJStQ-AFmbk3gNEvgEtd" 
                                 alt="Snack Box Yan's Food" 
                                 class="w-full h-full object-cover">
                            <div class="absolute bottom-3 left-3 px-3 py-1 rounded-md bg-inverse-surface/80 backdrop-blur-sm text-inverse-on-surface font-label-sm text-xs">
                                Min. 15 Box
                            </div>
                        </div>
                        <div>
                            <h3 class="font-headline-sm text-on-surface mb-2 font-serif text-xl">Snack Box Manis & Gurih</h3>
                            <p class="font-body-sm text-secondary leading-relaxed">
                                Kombinasi klasik kudapan gurih renyah dan camilan manis legit favorit semua usia dalam satu kotak bersih.
                            </p>
                        </div>
                        <ul class="space-y-2.5 font-body-sm text-on-surface">
                            <li class="flex items-center gap-2.5">
                                <span class="material-symbols-outlined text-success text-[18px]">done</span>
                                <span>Risol Mayo Saus Spesial</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="material-symbols-outlined text-success text-[18px]">done</span>
                                <span>Pisang Coklat Karamel Lumer</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="material-symbols-outlined text-success text-[18px]">done</span>
                                <span>Tahu Bakso / Lemper Daging</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="material-symbols-outlined text-success text-[18px]">done</span>
                                <span>Air Mineral Cup & Tisu Basah</span>
                            </li>
                        </ul>
                    </div>
                    <div class="pt-6 border-t border-surface-variant/40 mt-6">
                        <p class="font-label-sm text-secondary text-xs">Harga mulai dari</p>
                        <p class="font-headline-sm text-primary font-bold text-2xl font-serif">
                            Rp 12.000 <span class="font-body-sm text-secondary font-normal text-sm">/ box</span>
                        </p>
                    </div>
                </div>

                <!-- Paket 2: Nasi Kotak Nusantara (Featured Card with Warm Gold Accent) -->
                <div class="rounded-3xl bg-surface-warm p-6 sm:p-8 shadow-md flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 relative ring-2 ring-[#D6A253]">
                    <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-gradient-to-r from-tertiary-container to-tertiary text-on-tertiary font-label-sm text-xs shadow-sm flex items-center gap-1.5 font-semibold">
                        <span class="material-symbols-outlined text-[16px] text-tertiary-fixed">hotel_class</span>
                        <span>Paling Populer</span>
                    </div>
                    <div class="space-y-6">
                        <div class="aspect-[4/3] w-full rounded-2xl overflow-hidden bg-surface-variant relative mt-2">
                            <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDFkmFBQYeBj264oHilvJ9JGnrJ_1PQwJXxR2gokTFFviNr5gzGCDexUL9qKdLaBaTQmtl7Kr6kSRlVtonMXlr1NwwYVSGTCtr6AFa_iWNSqQ0D74vSZRm_HMXg6AOgcxsT3bHsrxoTQvSyHcyUcv3avNKLywFGPb8AYZAxOuVzhC-mVzhPiHFbQD6tEbON-W1f62G9pLQr_QEupaxxHXBTmkPriy348OCpVdEAQzNnXKeNuLYcLUDR" 
                                 alt="Nasi Kotak Nusantara" 
                                 class="w-full h-full object-cover">
                            <div class="absolute bottom-3 left-3 px-3 py-1 rounded-md bg-inverse-surface/80 backdrop-blur-sm text-inverse-on-surface font-label-sm text-xs">
                                Min. 15 Box
                            </div>
                        </div>
                        <div>
                            <h3 class="font-headline-sm text-on-surface mb-2 font-serif text-xl">Nasi Kotak Nusantara</h3>
                            <p class="font-body-sm text-secondary leading-relaxed">
                                Porsi mantap penuh citarasa rempah otentik rumahan, disajikan hangat dengan lauk pauk komplit bercita rasa tinggi.
                            </p>
                        </div>
                        <ul class="space-y-2.5 font-body-sm text-on-surface">
                            <li class="flex items-center gap-2.5">
                                <span class="material-symbols-outlined text-success text-[18px]">done</span>
                                <span>Nasi Gurih Daun Jeruk / Nasi Putih Wangi</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="material-symbols-outlined text-success text-[18px]">done</span>
                                <span>Ayam Goreng Rempah / Nasi Goreng Jadul</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="material-symbols-outlined text-success text-[18px]">done</span>
                                <span>Telur Balado Baluran Cabai Merah Segar</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="material-symbols-outlined text-success text-[18px]">done</span>
                                <span>Sambal Bajak, Lalap Timun & Kerupuk</span>
                            </li>
                        </ul>
                    </div>
                    <div class="pt-6 border-t border-surface-variant/40 mt-6">
                        <p class="font-label-sm text-secondary text-xs">Harga mulai dari</p>
                        <p class="font-headline-sm text-primary font-bold text-2xl font-serif">
                            Rp 28.000 <span class="font-body-sm text-secondary font-normal text-sm">/ box</span>
                        </p>
                    </div>
                </div>

                <!-- Paket 3: Prasmanan Mini Rumahan -->
                <div class="rounded-3xl bg-surface-warm p-6 sm:p-8 shadow-sm flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 border border-surface-variant/40">
                    <div class="space-y-6">
                        <div class="aspect-[4/3] w-full rounded-2xl overflow-hidden bg-surface-variant relative">
                            <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuBuyfhptf29m3mmuoyk7ijCTuAo74uLa05Oi1AfBEnwMzkAIDui51Iivgr7yOFapWRMsjABph3QUZrunTsCcUwb-UmKQtgeivoir6iVPYYTNrZvE14P9Sjy3eCiSpSoqA3O8eVDJ5Ji1wZv88oMYaAVN4il8ZMxV4luYK30gaFLi4sz3djaWr6-ALNV04Ttb8ZJDZabHsz-G4Vuzh9UdlvVymdp2J8m_RLQyNeYrC_IuS910SCiN60J" 
                                 alt="Prasmanan Mini Rumahan" 
                                 class="w-full h-full object-cover">
                            <div class="absolute bottom-3 left-3 px-3 py-1 rounded-md bg-inverse-surface/80 backdrop-blur-sm text-inverse-on-surface font-label-sm text-xs">
                                Min. 25 Porsi
                            </div>
                        </div>
                        <div>
                            <h3 class="font-headline-sm text-on-surface mb-2 font-serif text-xl">Prasmanan Mini Rumahan</h3>
                            <p class="font-body-sm text-secondary leading-relaxed">
                                Konsep sajian hangat prasmanan mini fleksibel untuk acara santai intim bersama keluarga besar atau rekan kantor.
                            </p>
                        </div>
                        <ul class="space-y-2.5 font-body-sm text-on-surface">
                            <li class="flex items-center gap-2.5">
                                <span class="material-symbols-outlined text-success text-[18px]">done</span>
                                <span>Pilihan 4 Menu Utama (Daging/Ayam & Sayur)</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="material-symbols-outlined text-success text-[18px]">done</span>
                                <span>2 Macam Camilan Tradisional Gurih & Manis</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="material-symbols-outlined text-success text-[18px]">done</span>
                                <span>Minuman Es Jeruk Nipis / Teh Dingin</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="material-symbols-outlined text-success text-[18px]">done</span>
                                <span>Peralatan Makan & Pemanas Komplit</span>
                            </li>
                        </ul>
                    </div>
                    <div class="pt-6 border-t border-surface-variant/40 mt-6">
                        <p class="font-label-sm text-secondary text-xs">Harga disesuaikan menu</p>
                        <p class="font-headline-sm text-primary font-bold text-2xl font-serif">
                            Hubungi Admin <span class="font-body-sm text-secondary font-normal text-sm">/ konsultasi</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Booking Form Container -->
            <x-catering-form />
        </div>
    </section>
</x-app-layout>
