<x-app-layout>
    <x-slot name="title">Cara Pesan — Online Delivery & Katering Acara | Yan's Food</x-slot>

    <div x-data="{ 
        activeTab: window.location.hash === '#online' ? 'online' : 'katering' 
    }">
        <!-- 1. Minimalist Editorial Hero Header with Intent Switcher (§6.1) -->
        <section class="relative w-full py-12 lg:py-16 bg-surface-container-low overflow-hidden border-b border-surface-variant/40" data-reveal>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 relative z-10">
                <div class="max-w-3xl space-y-4">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-surface-container text-primary font-label-sm uppercase tracking-wider text-xs font-semibold">
                        <span class="material-symbols-outlined text-[16px]">local_mall</span>
                        <span>Pilihan Layanan Fleksibel</span>
                    </div>
                    <h1 class="font-headline-lg text-3xl sm:text-4xl lg:text-5xl text-on-surface tracking-tight font-serif">
                        Cara Pesan <span class="text-primary italic font-medium">Yan's Food</span>
                    </h1>
                    <p class="font-body-lg text-secondary leading-relaxed text-base sm:text-lg">
                        Pilih santapan praktis langsung antar untuk santai hari ini, atau reservasi paket katering lezat untuk acara keluarga & kantor Anda.
                    </p>

                    <!-- Segmented Control Intent Switcher (§6.1) -->
                    <div class="pt-4">
                        <div class="inline-flex p-1.5 rounded-2xl bg-surface-container border border-surface-variant/40 shadow-xs">
                            <a href="#online" 
                               @click="activeTab = 'online'"
                               :class="activeTab === 'online' ? 'bg-surface-warm text-primary shadow-xs font-bold' : 'text-secondary hover:text-on-surface'"
                               class="px-5 py-2.5 rounded-xl font-label-md text-xs sm:text-sm transition-all flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">moped</span>
                                <span>Online Delivery (Instan)</span>
                            </a>
                            <a href="#katering" 
                               @click="activeTab = 'katering'"
                               :class="activeTab === 'katering' ? 'bg-surface-warm text-primary shadow-xs font-bold' : 'text-secondary hover:text-on-surface'"
                               class="px-5 py-2.5 rounded-xl font-label-md text-xs sm:text-sm transition-all flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">dinner_dining</span>
                                <span>Katering Acara (Box & Prasmanan)</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Ambient Warm Texture Ring -->
            <div class="absolute -right-24 -bottom-24 w-96 h-96 rounded-full bg-gradient-to-tr from-primary-fixed/20 to-tertiary-fixed/30 blur-3xl pointer-events-none"></div>
        </section>

        <!-- 2. SECTION A: Instan Online Delivery (§6.1 #online) -->
        <section id="online" class="w-full py-16 lg:py-20 bg-cream-bg" data-reveal>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
                <!-- Section Intro & Highlights -->
                <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8 mb-12">
                    <div class="max-w-2xl space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-[22px]">moped</span>
                            <span class="font-label-md text-primary tracking-wide uppercase text-xs sm:text-sm font-semibold">Pesan Langsung Antar</span>
                        </div>
                        <h2 class="font-headline-md text-2xl sm:text-3xl text-on-surface font-serif">Mau Makan Sekarang? Pesan Online</h2>
                        <p class="font-body-md text-secondary leading-relaxed text-sm sm:text-base">
                            Nggak sempat mampir atau lagi sibuk di kantor? Menu favorit Yan's Food seperti Risol Mayo, Nasi Goreng Jadul, dan aneka minuman segar siap meluncur hangat ke tempatmu melalui mitra delivery terpercaya.
                        </p>
                    </div>

                    <!-- Operational Micro Card -->
                    <div class="p-4 sm:p-5 rounded-2xl bg-surface-warm shadow-xs flex items-center gap-4 border border-surface-variant/40 shrink-0">
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
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8" data-reveal-                    <!-- ShopeeFood Card -->
                    <div class="group relative rounded-3xl bg-surface-warm p-6 sm:p-8 shadow-xs transition-all duration-300 hover:-translate-y-1.5 hover:shadow-md flex flex-col justify-between border border-surface-variant/40">
                        <div class="space-y-5">
                            <div class="flex items-start justify-between">
                                <div class="w-14 h-14 rounded-2xl bg-[#EE4D2D] text-white flex items-center justify-center shadow-md p-2.5 shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="w-full h-full fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                                        <!-- Shopee Bag Handle -->
                                        <path d="M15 15V11.5C15 8.74 17.24 6.5 20 6.5C22.76 6.5 25 8.74 25 11.5V15" stroke="white" stroke-width="2.5" stroke-linecap="round" fill="none"/>
                                        <!-- Shopee Bag Body -->
                                        <path d="M10 14H30L28.2 31.5C28.08 32.5 27.2 33.5 26.1 33.5H13.9C12.8 33.5 11.92 32.5 11.8 31.5L10 14Z" fill="white"/>
                                        <!-- Fork & Spoon Cutlery Motif -->
                                        <path d="M17 19V27M15.5 19H18.5M23 19V27M21.5 21C21.5 23 23 23 23 23V19" stroke="#EE4D2D" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                                    </svg>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-orange-100 text-[#EE4D2D] font-label-sm text-xs font-bold">
                                    Promo Ongkir & Diskon
                                </span>
                            </div>
                            <div>
                                <h3 class="font-headline-sm text-on-surface mb-1 font-serif text-xl">ShopeeFood</h3>
                                <p class="font-body-sm text-secondary leading-relaxed text-xs sm:text-sm">
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
                               class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-[#EE4D2D] hover:bg-[#d83d1e] text-white font-label-md transition-all duration-200 shadow-sm active:scale-95 text-xs sm:text-sm font-bold">
                                <span>Buka di ShopeeFood</span>
                                <span class="material-symbols-outlined text-[18px]">arrow_outward</span>
                            </a>
                        </div>
                    </div>

                    <!-- GoFood Card -->
                    <div class="group relative rounded-3xl bg-surface-warm p-6 sm:p-8 shadow-xs transition-all duration-300 hover:-translate-y-1.5 hover:shadow-md flex flex-col justify-between border border-surface-variant/40">
                        <div class="space-y-5">
                            <div class="flex items-start justify-between">
                                <div class="w-14 h-14 rounded-2xl bg-[#ED2724] text-white flex items-center justify-center shadow-md p-2.5 shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="w-full h-full fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="20" cy="20" r="14" fill="white"/>
                                        <circle cx="20" cy="20" r="11" fill="#ED2724"/>
                                        <!-- Fork & Spoon Cutlery Motif -->
                                        <path d="M16 14V26M14.5 14H17.5M24 14V26M22.5 16C22.5 18.5 24 18.5 24 18.5V14" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                                    </svg>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-[#ED2724] font-label-sm text-xs font-bold">
                                    Pengiriman Tercepat
                                </span>
                            </div>
                            <div>
                                <h3 class="font-headline-sm text-on-surface mb-1 font-serif text-xl">GoFood</h3>
                                <p class="font-body-sm text-secondary leading-relaxed text-xs sm:text-sm">
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
                               class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-[#ED2724] hover:bg-[#c91e1b] text-white font-label-md transition-all duration-200 shadow-sm active:scale-95 text-xs sm:text-sm font-bold">
                                <span>Buka di GoFood</span>
                                <span class="material-symbols-outlined text-[18px]">arrow_outward</span>
                            </a>
                        </div>
                    </div>

                    <!-- GrabFood Card -->
                    <div class="group relative rounded-3xl bg-surface-warm p-6 sm:p-8 shadow-xs transition-all duration-300 hover:-translate-y-1.5 hover:shadow-md flex flex-col justify-between border border-surface-variant/40">
                        <div class="space-y-5">
                            <div class="flex items-start justify-between">
                                <div class="w-14 h-14 rounded-2xl bg-[#00B14F] text-white flex items-center justify-center shadow-md p-2.5 shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="w-full h-full fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                                        <!-- Grab Food Cloche -->
                                        <path d="M11 25C11 19 15 14 20 14C25 14 29 19 29 25H11Z" fill="white"/>
                                        <rect x="9" y="26.5" width="22" height="3.5" rx="1.75" fill="white"/>
                                        <circle cx="20" cy="11.5" r="2.5" fill="white"/>
                                        <!-- Smile accent -->
                                        <path d="M16 21C18 23 22 23 24 21" stroke="#00B14F" stroke-width="2" stroke-linecap="round" fill="none"/>
                                    </svg>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-100 text-[#00B14F] font-label-sm text-xs font-bold">
                                    Rating 4.9 Bintang
                                </span>
                            </div>
                            <div>
                                <h3 class="font-headline-sm text-on-surface mb-1 font-serif text-xl">GrabFood</h3>
                                <p class="font-body-sm text-secondary leading-relaxed text-xs sm:text-sm">
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
                               class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-[#00B14F] hover:bg-[#009241] text-white font-label-md transition-all duration-200 shadow-sm active:scale-95 text-xs sm:text-sm font-bold">
                                <span>Buka di GrabFood</span>
                                <span class="material-symbols-outlined text-[18px]">arrow_outward</span>
                            </a>
                        </div>
                    </div> </div>
                </div>
            </div>
        </section>

        <!-- Visual Divider with Warm Ornaments -->
        <div class="w-full py-6 bg-cream-bg flex items-center justify-center">
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
                <x-catering-form />

                <!-- Syarat & Ketentuan Pemesanan Katering Accordion / Box -->
                <div class="max-w-4xl mx-auto mt-12 p-6 sm:p-8 rounded-3xl bg-surface-warm border border-surface-variant/40">
                    <h3 class="font-headline-sm text-on-surface font-serif text-lg sm:text-xl mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[22px]">policy</span>
                        <span>Ketentuan Pemesanan Katering</span>
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs sm:text-sm font-body-sm text-secondary">
                        <div class="flex items-start gap-2.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary mt-2 shrink-0"></span>
                            <span><strong>Batas Pemesanan:</strong> Minimal H-2 sebelum hari acara untuk memastikan belanja bahan segar.</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary mt-2 shrink-0"></span>
                            <span><strong>Uang Muka (DP):</strong> DP 50% untuk penguncian slot jadwal masak dan pelunasan saat pengantaran.</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary mt-2 shrink-0"></span>
                            <span><strong>Pengiriman:</strong> Diantar armada khusus dengan boks termal menjaga temperatur tetap hangat.</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary mt-2 shrink-0"></span>
                            <span><strong>Kebersihan & Higienitas:</strong> Setiap box disegel stiker segel higienis anti kontaminasi.</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
