<x-app-layout>
    <x-slot name="title">Cara Pesan — Online Delivery & Katering Acara | Yan's Food</x-slot>    <div>
        <!-- 1. Editorial Hero Header with Prominent Intent Switcher (§5.4) -->
        <section class="relative w-full py-12 lg:py-16 bg-cream-bg overflow-hidden border-b border-surface-variant/40" data-reveal>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 relative z-10">
                <div class="max-w-3xl space-y-3">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-surface-container text-primary font-label-sm uppercase tracking-wider text-xs font-semibold">
                        <span class="material-symbols-outlined text-[16px]">local_mall</span>
                        <span>Dua Pilihan Layanan Sesuai Kebutuhanmu</span>
                    </div>
                    <h1 class="font-headline-lg text-3xl sm:text-4xl lg:text-5xl text-on-surface tracking-tight font-serif font-bold">
                        Pesan Sajian <span class="text-primary italic font-normal">Yan's Food</span>
                    </h1>
                    <p class="font-body-lg text-secondary leading-relaxed text-base sm:text-lg">
                        Mulai dari santapan lezat siap antar untuk makan siang hari ini, hingga paket katering lengkap untuk momen spesial keluarga dan acaramu.
                    </p>
                </div>

                <!-- Intent Switcher (2 Prominent Cards, §5.4 point 1) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-8 max-w-4xl">
                    <!-- Intent Card 1: Makan Sekarang -->
                    <a href="#online" 
                       id="intent-card-online" 
                       class="intent-card flex items-start gap-4 group">
                        <div class="w-14 h-14 rounded-2xl bg-orange-100 text-primary flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                            <span class="material-symbols-outlined text-[28px]">moped</span>
                        </div>
                        <div class="space-y-1">
                            <div class="flex items-center justify-between">
                                <h3 class="font-headline-sm text-on-surface font-serif text-lg sm:text-xl font-bold group-hover:text-primary transition-colors">
                                    Mau makan sekarang?
                                </h3>
                                <span class="material-symbols-outlined text-secondary text-[20px] transition-transform duration-200 group-hover:translate-x-1">arrow_downward</span>
                            </div>
                            <p class="font-body-sm text-secondary text-xs sm:text-sm leading-relaxed">
                                Pesan instan lewat ShopeeFood, GoFood, atau GrabFood. Diantar hangat langsung ke rumah atau kantor.
                            </p>
                            <span class="font-label-sm text-primary font-bold text-xs inline-flex items-center gap-1 pt-1">
                                <span>Lihat Pilihan Platform</span>
                                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                            </span>
                        </div>
                    </a>

                    <!-- Intent Card 2: Ada Acara / Katering -->
                    <a href="#katering" 
                       id="intent-card-katering" 
                       class="intent-card flex items-start gap-4 group">
                        <div class="w-14 h-14 rounded-2xl bg-amber-100 text-[#9B3100] flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                            <span class="material-symbols-outlined text-[28px]">celebration</span>
                        </div>
                        <div class="space-y-1">
                            <div class="flex items-center justify-between">
                                <h3 class="font-headline-sm text-on-surface font-serif text-lg sm:text-xl font-bold group-hover:text-primary transition-colors">
                                    Ada acara keluarga / kantor?
                                </h3>
                                <span class="material-symbols-outlined text-secondary text-[20px] transition-transform duration-200 group-hover:translate-x-1">arrow_downward</span>
                            </div>
                            <p class="font-body-sm text-secondary text-xs sm:text-sm leading-relaxed">
                                Pesan snack box atau nasi kotak katering. Bisa atur tanggal, pilih menu, dan hitung estimasi total.
                            </p>
                            <span class="font-label-sm text-primary font-bold text-xs inline-flex items-center gap-1 pt-1">
                                <span>Isi Form Katering Acara</span>
                                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                            </span>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <!-- 2. SECTION A: Pesan Online Platform (§5.4 #online) -->
        <section id="online" class="w-full py-16 lg:py-20 bg-surface-warm/40 scroll-mt-24" data-reveal>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
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

                <!-- 3 Delivery Platforms Grid (Entire Card Clickable, M22, M24) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8" data-reveal-group>
                    <!-- ShopeeFood Card -->
                    <a href="https://shopee.co.id" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="group relative rounded-3xl bg-surface-warm p-6 sm:p-8 shadow-xs hover:shadow-md transition-all duration-300 flex flex-col justify-between border border-surface-variant/40 hover:-translate-y-1 block">
                        <div class="space-y-5">
                            <div class="flex items-start justify-between">
                                <div class="w-14 h-14 rounded-2xl bg-[#EE4D2D] text-white flex items-center justify-center shadow-xs p-2.5 shrink-0 platform-card-logo">
                                    <svg class="w-full h-full fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15 15V11.5C15 8.74 17.24 6.5 20 6.5C22.76 6.5 25 8.74 25 11.5V15" stroke="white" stroke-width="2.5" stroke-linecap="round" fill="none"/>
                                        <path d="M10 14H30L28.2 31.5C28.08 32.5 27.2 33.5 26.1 33.5H13.9C12.8 33.5 11.92 32.5 11.8 31.5L10 14Z" fill="white"/>
                                        <path d="M17 19V27M15.5 19H18.5M23 19V27M21.5 21C21.5 23 23 23 23 23V19" stroke="#EE4D2D" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                                    </svg>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-orange-100 text-[#EE4D2D] font-label-sm text-xs font-bold">
                                    Voucher & Diskon
                                </span>
                            </div>
                            <div>
                                <h3 class="font-headline-sm text-on-surface mb-1 font-serif text-xl font-bold group-hover:text-primary transition-colors">
                                    ShopeeFood
                                </h3>
                                <p class="font-body-sm text-secondary leading-relaxed text-xs sm:text-sm">
                                    Banyak promo gratis ongkir dan bundling hemat risoles & kudapan harian.
                                </p>
                            </div>
                            <div class="pt-2 flex items-center gap-2 text-secondary font-label-sm text-xs">
                                <span class="material-symbols-outlined text-[18px] text-tertiary">check_circle</span>
                                <span>Menu harian sedia lengkap</span>
                            </div>
                        </div>
                        <div class="pt-6 border-t border-surface-variant/40 mt-6 flex items-center justify-between text-primary font-label-md font-bold text-xs sm:text-sm">
                            <span>Buka di ShopeeFood</span>
                            <span class="material-symbols-outlined text-[18px] transition-transform duration-200 group-hover:translate-x-1 group-hover:-translate-y-1">arrow_outward</span>
                        </div>
                    </a>

                    <!-- GoFood Card -->
                    <a href="https://gofood.co.id" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="group relative rounded-3xl bg-surface-warm p-6 sm:p-8 shadow-xs hover:shadow-md transition-all duration-300 flex flex-col justify-between border border-surface-variant/40 hover:-translate-y-1 block">
                        <div class="space-y-5">
                            <div class="flex items-start justify-between">
                                <div class="w-14 h-14 rounded-2xl bg-[#ED2724] text-white flex items-center justify-center shadow-xs p-2.5 shrink-0 platform-card-logo">
                                    <svg class="w-full h-full fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="20" cy="20" r="14" fill="white"/>
                                        <circle cx="20" cy="20" r="11" fill="#ED2724"/>
                                        <path d="M16 14V26M14.5 14H17.5M24 14V26M22.5 16C22.5 18.5 24 18.5 24 18.5V14" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                                    </svg>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-[#ED2724] font-label-sm text-xs font-bold">
                                    Driver Tercepat
                                </span>
                            </div>
                            <div>
                                <h3 class="font-headline-sm text-on-surface mb-1 font-serif text-xl font-bold group-hover:text-primary transition-colors">
                                    GoFood
                                </h3>
                                <p class="font-body-sm text-secondary leading-relaxed text-xs sm:text-sm">
                                    Armada Gojek gesit menjamin makanan sampai hangat dan siap dinikmati.
                                </p>
                            </div>
                            <div class="pt-2 flex items-center gap-2 text-secondary font-label-sm text-xs">
                                <span class="material-symbols-outlined text-[18px] text-tertiary">check_circle</span>
                                <span>Packaging higienis bersegel</span>
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
                       class="group relative rounded-3xl bg-surface-warm p-6 sm:p-8 shadow-xs hover:shadow-md transition-all duration-300 flex flex-col justify-between border border-surface-variant/40 hover:-translate-y-1 block">
                        <div class="space-y-5">
                            <div class="flex items-start justify-between">
                                <div class="w-14 h-14 rounded-2xl bg-[#00B14F] text-white flex items-center justify-center shadow-xs p-2.5 shrink-0 platform-card-logo">
                                    <svg class="w-full h-full fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11 25C11 19 15 14 20 14C25 14 29 19 29 25H11Z" fill="white"/>
                                        <rect x="9" y="26.5" width="22" height="3.5" rx="1.75" fill="white"/>
                                        <circle cx="20" cy="11.5" r="2.5" fill="white"/>
                                        <path d="M16 21C18 23 22 23 24 21" stroke="#00B14F" stroke-width="2" stroke-linecap="round" fill="none"/>
                                    </svg>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-100 text-[#00B14F] font-label-sm text-xs font-bold">
                                    Rating 4.9 Bintang
                                </span>
                            </div>
                            <div>
                                <h3 class="font-headline-sm text-on-surface mb-1 font-serif text-xl font-bold group-hover:text-primary transition-colors">
                                    GrabFood
                                </h3>
                                <p class="font-body-sm text-secondary leading-relaxed text-xs sm:text-sm">
                                    Nikmati promo GrabUnlimited dan pembayaran praktis via OVO.
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

        <!-- 3. Distinct Divider with "atau" and 64px vertical spacing (§5.4 point 377) -->
        <div class="w-full my-16 flex items-center justify-center">
            <div class="max-w-4xl w-full px-6 flex items-center gap-4">
                <div class="flex-1 h-px bg-surface-variant/60"></div>
                <div class="px-5 py-2 rounded-full bg-surface-container border border-surface-variant/50 text-secondary font-serif italic text-sm font-semibold shadow-xs">
                    atau pesan katering untuk acara
                </div>
                <div class="flex-1 h-px bg-surface-variant/60"></div>
            </div>
        </div> </div>

        <!-- 3. SECTION B: Catering Service & Reservation Form (§6.1 #katering) -->
        <section id="katering" class="w-full py-16 lg:py-24 bg-surface-container-low/50" data-reveal>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
                <!-- Section Header -->
                <div class="text-center max-w-3xl mx-auto mb-14 space-y-4">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-sand-bg-alt text-on-surface font-label-sm uppercase tracking-wider text-xs font-semibold">
                        <span class="material-symbols-outlined text-primary text-[16px]">celebration</span>
                        <span>Untuk Acara & Momen Istimewa</span>
                    </div>
                    <h2 class="font-headline-lg text-3xl sm:text-4xl text-on-surface font-serif">Layanan Katering Rumahan Berkualitas</h2>
                    <p class="font-body-lg text-secondary leading-relaxed text-base sm:text-lg">
                        Pilihan snack box dan nasi kotak higienis, lezat, dan tepat waktu untuk arisan, pengajian, rapat kantor, dan pesta keluarga Anda.
                    </p>
                </div>

                <!-- Catering Packages Highlights -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16" data-reveal-group>
                    <!-- Paket 1: Snack Box -->
                    <div class="rounded-3xl bg-surface-warm p-6 sm:p-8 shadow-xs flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 border border-surface-variant/40">
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
                                <p class="font-body-sm text-secondary leading-relaxed text-xs sm:text-sm">
                                    Kombinasi klasik kudapan gurih renyah dan camilan manis legit favorit semua usia dalam satu kotak bersih.
                                </p>
                            </div>
                            <ul class="space-y-2.5 font-body-sm text-on-surface text-xs sm:text-sm">
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

                    <!-- Paket 2: Nasi Kotak Nusantara (Featured Card with Warm Amber Accent) -->
                    <div class="rounded-3xl bg-surface-warm p-6 sm:p-8 shadow-md flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 relative ring-2 ring-primary">
                        <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-gradient-to-r from-tertiary-container to-tertiary text-on-tertiary font-label-sm text-xs shadow-xs flex items-center gap-1.5 font-semibold">
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
                                <p class="font-body-sm text-secondary leading-relaxed text-xs sm:text-sm">
                                    Porsi mantap penuh citarasa rempah otentik rumahan, disajikan hangat dengan lauk pauk komplit bercita rasa tinggi.
                                </p>
                            </div>
                            <ul class="space-y-2.5 font-body-sm text-on-surface text-xs sm:text-sm">
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
                    <div class="rounded-3xl bg-surface-warm p-6 sm:p-8 shadow-xs flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 border border-surface-variant/40">
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
                                <p class="font-body-sm text-secondary leading-relaxed text-xs sm:text-sm">
                                    Konsep sajian hangat prasmanan mini fleksibel untuk acara santai intim bersama keluarga besar atau rekan kantor.
                                </p>
                            </div>
                            <ul class="space-y-2.5 font-body-sm text-on-surface text-xs sm:text-sm">
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

                <!-- 3-Step Interactive Catering Booking Wizard (§6) -->
                <x-catering-form :products="$products" />

                <!-- Ketentuan & FAQ Accordions (§5.4 points 382, 384, M21) -->
                <div class="max-w-4xl mx-auto mt-16 space-y-4" data-accordion-group="single">
                    <div class="text-center mb-8 space-y-2">
                        <span class="font-label-sm text-primary uppercase tracking-wider text-xs font-bold">Informasi Penting</span>
                        <h3 class="font-headline-md text-2xl text-on-surface font-serif font-bold">Pertanyaan & Ketentuan Katering</h3>
                    </div>

                    <!-- Accordion 1: Waktu Pemesanan -->
                    <div class="accordion-item is-open">
                        <button type="button" class="accordion-header" aria-expanded="true">
                            <span class="font-serif text-base sm:text-lg">Berapa lama sebelum acara pesanan harus masuk?</span>
                            <span class="material-symbols-outlined accordion-icon">expand_more</span>
                        </button>
                        <div class="accordion-collapse">
                            <div class="accordion-content">
                                <div class="accordion-body">
                                    Pemesanan katering snack box dan nasi kotak disarankan minimal <strong>H-2 sebelum hari acara</strong>. Untuk pemesanan dalam jumlah besar (di atas 100 porsi) atau saat akhir pekan, kami sarankan konfirmasi H-5 untuk mengamankan slot dapur kami.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Accordion 2: Sistem Pembayaran & DP -->
                    <div class="accordion-item">
                        <button type="button" class="accordion-header" aria-expanded="false">
                            <span class="font-serif text-base sm:text-lg">Bagaimana sistem pembayaran dan uang muka (DP)?</span>
                            <span class="material-symbols-outlined accordion-icon">expand_more</span>
                        </button>
                        <div class="accordion-collapse">
                            <div class="accordion-content">
                                <div class="accordion-body">
                                    Pesanan katering dikunci setelah pembayaran uang muka (DP) sebesar 50% melalui transfer bank resmi Yan's Food. Pelunasan sisa 50% dapat dilakukan saat pesanan tiba di lokasi acara atau H-1 pengantaran.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Accordion 3: Area Pengantaran -->
                    <div class="accordion-item">
                        <button type="button" class="accordion-header" aria-expanded="false">
                            <span class="font-serif text-base sm:text-lg">Apakah pesanan bisa diantar ke lokasi acara?</span>
                            <span class="material-symbols-outlined accordion-icon">expand_more</span>
                        </button>
                        <div class="accordion-collapse">
                            <div class="accordion-content">
                                <div class="accordion-body">
                                    Bisa! Kami melayani pengantaran ke seluruh area kota dan sekitarnya menggunakan armada ber-boks termal tertutup untuk memastikan kehangatan dan kebersihan makanan tetap terjaga prima.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Accordion 4: Menu Kustom -->
                    <div class="accordion-item">
                        <button type="button" class="accordion-header" aria-expanded="false">
                            <span class="font-serif text-base sm:text-lg">Bisa minta menu atau penyesuaian khusus (custom request)?</span>
                            <span class="material-symbols-outlined accordion-icon">expand_more</span>
                        </button>
                        <div class="accordion-collapse">
                            <div class="accordion-content">
                                <div class="accordion-body">
                                    Tentu bisa. Anda dapat menuliskan preferensi lauk, tingkat kepedasan, atau permintaan alergi tertentu di kolom catatan formulir, atau berkonsultasi langsung dengan admin kami via WhatsApp.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Secondary Consultation Action Button (§5.4 point 385) -->
                <div class="pt-12 text-center space-y-3">
                    <p class="font-body-sm text-secondary text-sm">
                        Lebih suka ngobrol atau ingin diskusi budget acara secara langsung?
                    </p>
                    <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Yan's%20Food,%20saya%20mau%20konsultasi%20katering%20acara" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="btn-whatsapp text-sm inline-flex">
                        <span class="material-symbols-outlined text-[18px]">chat</span>
                        <span>Chat Admin Langsung via WhatsApp</span>
                    </a>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
