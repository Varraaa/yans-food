<x-app-layout>
    <x-slot name="title">Beranda | Yan's Food — Dapur Kuliner Rumahan</x-slot>

    <!-- 1. HERO SECTION (§5.1 & §3.3) -->
    <section class="relative w-full overflow-hidden bg-cream-bg pt-6 pb-12 sm:pt-10 sm:pb-16 lg:py-16 px-4 sm:px-6 md:px-8 lg:px-12 block lg:flex lg:items-center lg:min-h-[calc(100svh-5rem)] lg:max-h-[920px]" data-hero-section>
        <div class="max-w-7xl mx-auto w-full grid grid-cols-1 md:grid-cols-12 gap-8 md:gap-8 lg:gap-14 items-center">
            
            <!-- Left Hero Content (md:col-span-7) -->
            <div class="md:col-span-7 flex flex-col items-start gap-4 sm:gap-5 lg:gap-7">
                <!-- Main Headline -->
                <h1 class="font-headline-lg text-3xl sm:text-4xl md:text-[38px] lg:text-6xl text-on-surface tracking-tight font-serif leading-[1.2] sm:leading-[1.15]" data-hero-step="headline">
                    Rasa Rumahan, <br class="hidden sm:block"/>
                    <span class="text-primary italic font-normal">Disajikan dengan Hati</span>
                </h1>

                <!-- Subheadline -->
                <p class="font-body-lg text-secondary max-w-2xl leading-relaxed text-sm sm:text-base lg:text-lg" data-hero-step="subheadline">
                    Dari dapur rumahan yang bersih dan penuh dedikasi, Yan's Food menghadirkan aneka kudapan gurih, hidangan hangat, hingga minuman segar untuk setiap momen santaimu.
                </p>

                <!-- CTA Buttons (§5.1: Primer & Sekunder M01-M04) -->
                <div class="flex flex-wrap items-center gap-3 sm:gap-4 pt-2 w-full sm:w-auto" data-hero-step="cta">
                    <a href="{{ url('/menu') }}" class="btn-primary w-full sm:w-auto text-xs sm:text-sm py-2.5 sm:py-3 px-4 sm:px-5">
                        <span>Lihat Menu Lengkap</span>
                        <span class="material-symbols-outlined text-[18px] sm:text-[20px] transition-transform duration-200 group-hover:translate-x-1">arrow_forward</span>
                    </a>
                    <a href="{{ url('/pesan') }}" class="btn-outline w-full sm:w-auto text-xs sm:text-sm py-2.5 sm:py-3 px-4 sm:px-5">
                        <span class="material-symbols-outlined text-[18px] sm:text-[20px] text-primary">local_mall</span>
                        <span>Pesan Online Delivery</span>
                    </a>
                </div>

                <!-- Trust Badges Under Hero (§5.1) -->
                <div class="pt-2 sm:pt-4 grid grid-cols-3 gap-2 sm:gap-4 lg:gap-6 w-full max-w-lg bg-surface-warm p-3 sm:p-4 lg:p-5 rounded-2xl shadow-xs border border-surface-variant/40">
                    <div class="flex flex-col">
                        <span class="font-headline-sm text-primary font-bold text-base sm:text-xl lg:text-2xl font-serif">100%</span>
                        <span class="font-label-sm text-secondary text-[10px] sm:text-xs">Bahan Alami</span>
                    </div>
                    <div class="flex flex-col border-x border-surface-variant/50 px-2 sm:px-3 lg:px-4">
                        <span class="font-headline-sm text-primary font-bold text-base sm:text-xl lg:text-2xl font-serif">Fresh</span>
                        <span class="font-label-sm text-secondary text-[10px] sm:text-xs">Dibuat Hari Ini</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-headline-sm text-primary font-bold text-base sm:text-xl lg:text-2xl font-serif">Halal</span>
                        <span class="font-label-sm text-secondary text-[10px] sm:text-xs">Higienis Amanah</span>
                    </div>
                </div>
            </div>

            <!-- Right Visual Interactive Photo Card (md:col-span-5) with Modern UX -->
            <div class="md:col-span-5 relative flex justify-center w-full">
                <a href="{{ url('/menu') }}" 
                   class="group relative block w-full max-w-[280px] sm:max-w-xs md:max-w-[290px] lg:max-w-md aspect-[4/5] max-h-[360px] sm:max-h-[420px] md:max-h-[440px] rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 border-4 border-surface-warm bg-surface-container cursor-pointer select-none"
                   aria-label="Lihat Semua Menu dan Sajian Kuliner Yan's Food">
                    
                    <!-- Culinary Photo with Smooth Hover Zoom -->
                    <img src="{{ asset('images/Menu/menu.png') }}" 
                         alt="Sajian kuliner otentik Yan's Food" 
                         class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105">

                    <!-- Subtle Dark Gradient Scrim for Bottom Legibility -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-60 group-hover:opacity-40 transition-opacity pointer-events-none"></div>

                    <!-- Interactive Glassmorphic Editorial Card at Bottom -->
                    <div class="absolute bottom-3.5 left-3.5 right-3.5 z-20 p-2.5 sm:p-4 rounded-2xl bg-[#FDFBF7]/95 backdrop-blur-md shadow-lg border border-white/70 flex items-center justify-between gap-2 sm:gap-3 transition-transform duration-300 group-hover:-translate-y-0.5">
                        <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-orange-100 text-primary flex items-center justify-center shrink-0 group-hover:bg-primary group-hover:text-white transition-colors duration-300">
                                <span class="material-symbols-outlined text-[18px] sm:text-[22px]">restaurant_menu</span>
                            </div>
                            <div class="min-w-0">
                                <p class="font-headline-sm text-on-surface text-xs sm:text-sm font-bold font-serif truncate">Kudapan & Makanan Hangat</p>
                                <p class="font-body-sm text-secondary text-[10px] sm:text-xs truncate">Resep Asli Racikan Keluarga</p>
                            </div>
                        </div>

                        <!-- Micro Interactive Chevron Button -->
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-surface-container flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all shrink-0 shadow-2xs">
                            <span class="material-symbols-outlined text-[15px] sm:text-[17px] group-hover:translate-x-0.5 transition-transform">arrow_forward</span>
                        </div>
                    </div>
                </a>

                <!-- Decorative Ambient Warm Glows -->
                <div class="absolute -top-6 -right-6 w-32 h-32 bg-primary/10 rounded-full blur-2xl -z-10 pointer-events-none"></div>
                <div class="absolute -bottom-6 -left-6 w-40 h-40 bg-tertiary-fixed/30 rounded-full blur-3xl -z-10 pointer-events-none"></div>
            </div>
        </div>

        <!-- Scroll Indicator (§3.3) -->
        <div class="hidden lg:flex absolute bottom-3 left-1/2 -translate-x-1/2 items-center gap-1.5 text-secondary font-label-sm text-xs opacity-75" data-hero-step="scroll-indicator">
            <span>Scroll untuk melihat menu</span>
            <span class="material-symbols-outlined text-[16px] animate-bounce">arrow_downward</span>
        </div>
    </section>

    <!-- 2. PENGENALAN SINGKAT (§5.1 point 2) -->
    <section class="w-full py-14 sm:py-16 lg:py-24 px-4 sm:px-6 md:px-8 lg:px-12 bg-surface-warm border-y border-surface-variant/30" data-reveal>
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-12 gap-8 md:gap-10 lg:gap-16 items-center">
            <!-- Left: Kitchen Craft Photo -->
            <div class="md:col-span-6 relative">
                <div class="aspect-[4/3] max-h-[280px] sm:max-h-[350px] md:max-h-[400px] rounded-3xl overflow-hidden shadow-md bg-surface-container">
                    <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuBn1TinkqNIVV7h2qq1GxjrOnc4gBx76s0MsWSkKpaCqOcpu0_YHs1PEx71CI1kVG54saVxEsBaCarut2IMBc3gB6FkdYFLWED9CzdQiyWN4JpOaLwxKrC-omYS70DjFf4YAAWzb7Q7OFbMVdeleBHwkI366riPzhZPmJJdm5Q1lZ_nbh7rMkIvcv8ky4vmqUmgNQSU03ql4J3e2Q_Py6cpZw8GlulXxb1w4VV49vZ6dLfJO-FeEheV" 
                         alt="Dapur Bersih Yan's Food" 
                         class="w-full h-full object-cover">
                </div>
                <!-- Offset Detail Card (Visible on Desktop lg) -->
                <div class="absolute -bottom-6 right-2 sm:right-4 lg:-right-6 p-4 sm:p-6 rounded-2xl bg-inverse-surface text-inverse-on-surface max-w-xs shadow-xl hidden lg:block">
                    <div class="flex items-center gap-2 mb-2 text-tertiary-fixed">
                        <span class="material-symbols-outlined text-[20px]">verified</span>
                        <span class="font-label-sm font-bold uppercase tracking-wider text-xs">Komitmen Kualitas</span>
                    </div>
                    <p class="font-body-sm text-surface-variant text-xs sm:text-sm leading-relaxed">
                        Tanpa bahan pengawet buatan. Menghormati resep pusaka dengan sentuhan dapur higienis modern.
                    </p>
                </div>
            </div>

            <!-- Right: Story & Philosophy -->
            <div class="md:col-span-6 flex flex-col items-start gap-5 sm:gap-6">
                <span class="font-label-md uppercase tracking-widest text-primary font-bold text-xs sm:text-sm">Tentang Dapur Kami</span>
                <h2 class="font-headline-lg text-3xl sm:text-4xl lg:text-5xl text-on-surface tracking-tight font-serif leading-tight">
                    Dapur Rumahan yang Naik Kelas Tanpa Kehilangan <span class="text-primary italic">Rasa Aslinya</span>
                </h2>
                <div class="space-y-4 font-body-md text-secondary leading-relaxed">
                    <p>
                        Berawal dari aroma sedap di dapur rumah yang selalu dirindukan keluarga dan tetangga dekat, Yan's Food tumbuh sebagai persembahan tulus bagi para penikmat rasa otentik rumahan.
                    </p>
                    <p>
                        Kami meyakini bahwa makanan yang lezat tercipta dari niat tulus dan bahan-bahan segar pilihan yang diolah tanpa kompromi. Setiap risoles digulung manual dengan tangan terampil, setiap rempah ditakar seimbang tanpa bahan pengawet sintesis, menjaga cita rasa jujur yang menghangatkan hati.
                    </p>
                </div>
                <div class="pt-2 flex items-center gap-6 sm:gap-8">
                    <div class="flex flex-col">
                        <span class="font-headline-md text-primary font-bold text-2xl sm:text-3xl font-serif">3+</span>
                        <span class="font-body-sm text-secondary text-xs sm:text-sm">Tahun Berdedikasi</span>
                    </div>
                    <div class="h-10 w-px bg-surface-variant"></div>
                    <div class="flex flex-col">
                        <span class="font-headline-md text-primary font-bold text-2xl sm:text-3xl font-serif">15+</span>
                        <span class="font-body-sm text-secondary text-xs sm:text-sm">Varian Resep Otentik</span>
                    </div>
                    <div class="h-10 w-px bg-surface-variant"></div>
                    <div class="flex flex-col">
                        <span class="font-headline-md text-primary font-bold text-2xl sm:text-3xl font-serif">100%</span>
                        <span class="font-body-sm text-secondary text-xs sm:text-sm">Halal & Higienis</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. PRODUK UNGGULAN (§5.1 point 3) -->
    <section class="w-full py-16 lg:py-24 px-4 sm:px-6 md:px-8 lg:px-12 bg-cream-bg" data-reveal>
        <div class="max-w-7xl mx-auto flex flex-col gap-12">
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="space-y-3 max-w-2xl">
                    <span class="font-label-md uppercase tracking-widest text-primary font-bold text-xs sm:text-sm">Menu Pilihan Terbaik</span>
                    <h2 class="font-headline-lg text-3xl sm:text-4xl text-on-surface tracking-tight font-serif">Menu Favorit Pilihan Pelanggan</h2>
                    <p class="font-body-lg text-secondary text-base sm:text-lg">Kreasi rumahan yang paling sering dipesan ulang oleh pelanggan setia kami.</p>
                </div>
                <a href="{{ url('/menu') }}" class="inline-flex items-center gap-2 font-label-md text-primary hover:text-primary-dark transition-colors font-bold self-start md:self-end pb-1 group">
                    <span>Lihat Semua Menu</span>
                    <span class="material-symbols-outlined text-[20px] transition-transform duration-200 group-hover:translate-x-1">arrow_forward</span>
                </a>
            </div>

            <!-- 4 Featured Cards Grid (Mobile & Tablet 2-Cols, Desktop 4-Cols) -->
            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-5 lg:gap-6" data-reveal-group>
                <!-- 1: Risol Mayo -->
                <x-public.product-card 
                    title="Risol Mayo"
                    category="Makanan Ringan"
                    categorySlug="ringan"
                    price="14000"
                    unit="/ porsi"
                    :image="asset('images/Menu/Risol Mayo.png')"
                    desc="Risol mayo creamy gurih berbalut kulit renyah emas, pilihan pedas atau original. Gratis saus dan mayones."
                    status="sedia"
                    :isFavorite="true"
                    slug="risol-mayo" />

                <!-- 2: Nasi Goreng Jadul -->
                <x-public.product-card 
                    title="Nasi Goreng Jadul"
                    category="Makanan Berat"
                    categorySlug="berat"
                    price="21000"
                    unit="/ porsi"
                    :image="asset('images/Menu/Nasi Goreng Jadul.png')"
                    desc="Nasi goreng jadul bumbu ulek tradisional dengan 1 butir telur, sayuran, kerupuk, dalam kemasan higienis."
                    status="sedia"
                    :isFavorite="true"
                    slug="nasi-goreng-jadul" />

                <!-- 3: Pisang Coklat Lumer -->
                <x-public.product-card 
                    title="Pisang Coklat Lumer"
                    category="Makanan Ringan"
                    categorySlug="ringan"
                    price="14000"
                    unit="/ porsi"
                    :image="asset('images/Menu/Pisang Coklat.png')"
                    desc="Pisang manis legit dengan isian cokelat lumer berbalut kulit pastry renyah khas racikan Yan's Food."
                    status="sedia"
                    :isFavorite="true"
                    slug="pisang-coklat-lumer" />

                <!-- 4: Teh Manis (Hangat / Dingin) -->
                <x-public.product-card 
                    title="Teh Manis (Hangat / Dingin)"
                    category="Minuman Segar"
                    categorySlug="minuman"
                    price="7000"
                    unit="/ cup"
                    :image="asset('images/Menu/Teh Manis.png')"
                    desc="Seduhan teh melati wangi khas Jawa dengan daun teh pilihan, tersedia pilihan hangat atau dingin segar."
                    status="sedia"
                    :isFavorite="false"
                    slug="teh-manis-hangat-dingin" />
            </div>
        </div>
    </section>

    <!-- 4. KENAPA PILIH KAMI (§5.1 point 4) -->
    <section class="w-full py-16 lg:py-24 px-4 sm:px-6 md:px-8 lg:px-12 bg-surface-container-low border-y border-surface-variant/30" data-reveal>
        <div class="max-w-7xl mx-auto flex flex-col gap-14">
            <div class="text-center max-w-2xl mx-auto space-y-3">
                <span class="font-label-md uppercase tracking-widest text-primary font-bold text-xs sm:text-sm">Keunggulan Yan's Food</span>
                <h2 class="font-headline-lg text-3xl sm:text-4xl text-on-surface tracking-tight font-serif">Kualitas Jujur dari Dapur Kami</h2>
                <p class="font-body-lg text-secondary text-base sm:text-lg">Kami mengutamakan kesegaran dan higienitas untuk menghadirkan rasa yang selalu bisa dipercaya.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 lg:gap-8" data-reveal-group>
                <!-- Feature 1: Bahan Baku Segar Setiap Hari -->
                <div class="group hover-card-premium p-6 lg:p-8 rounded-3xl bg-surface-warm shadow-xs flex flex-col gap-4 border border-surface-variant/40 cursor-default">
                    <div class="w-14 h-14 rounded-2xl bg-primary-fixed flex items-center justify-center text-primary hover-icon-bounce shrink-0 shadow-2xs group-hover:shadow-md transition-all duration-300">
                        <span class="material-symbols-outlined text-[30px]">eco</span>
                    </div>
                    <h3 class="font-headline-sm text-on-surface text-xl font-serif group-hover:text-primary transition-colors duration-300">
                        Bahan Baku Segar Setiap Hari
                    </h3>
                    <p class="font-body-md text-secondary leading-relaxed text-sm sm:text-base">
                        Dibuat fresh tanpa stok beku lama, menjaga nutrisi, kesegaran rempah, dan kerenyahan tekstur terbaik di setiap gigitan.
                    </p>
                    <div class="pt-2 mt-auto flex items-center gap-2 text-xs font-label-sm font-semibold text-primary opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <span>Segar dari Dapur</span>
                        <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                    </div>
                </div>

                <!-- Feature 2: Higienis & Standar Dapur Rapi -->
                <div class="group hover-card-premium p-6 lg:p-8 rounded-3xl bg-surface-warm shadow-xs flex flex-col gap-4 border border-surface-variant/40 cursor-default">
                    <div class="w-14 h-14 rounded-2xl bg-tertiary-fixed flex items-center justify-center text-tertiary hover-icon-bounce shrink-0 shadow-2xs group-hover:shadow-md transition-all duration-300">
                        <span class="material-symbols-outlined text-[30px]">sanitizer</span>
                    </div>
                    <h3 class="font-headline-sm text-on-surface text-xl font-serif group-hover:text-tertiary transition-colors duration-300">
                        Higienis &amp; Standar Dapur Rapi
                    </h3>
                    <p class="font-body-md text-secondary leading-relaxed text-sm sm:text-base">
                        Proses pembuatan bersih berstandar rumahan premium dengan sanitasi peralatan masak dan kebersihan kemasan yang disiplin.
                    </p>
                    <div class="pt-2 mt-auto flex items-center gap-2 text-xs font-label-sm font-semibold text-tertiary opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <span>Standar Kebersihan Tinggi</span>
                        <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                    </div>
                </div>

                <!-- Feature 3: Rasa Otentik & Jujur -->
                <div class="group hover-card-premium p-6 lg:p-8 rounded-3xl bg-surface-warm shadow-xs flex flex-col gap-4 border border-surface-variant/40 cursor-default">
                    <div class="w-14 h-14 rounded-2xl bg-secondary-fixed flex items-center justify-center text-primary hover-icon-bounce shrink-0 shadow-2xs group-hover:shadow-md transition-all duration-300">
                        <span class="material-symbols-outlined text-[30px]">soup_kitchen</span>
                    </div>
                    <h3 class="font-headline-sm text-on-surface text-xl font-serif group-hover:text-primary transition-colors duration-300">
                        Rasa Otentik &amp; Jujur
                    </h3>
                    <p class="font-body-md text-secondary leading-relaxed text-sm sm:text-base">
                        Bumbu rempah asli warisan keluarga tanpa perisa sintetik berlebih, menghadirkan nostalgia kelezatan masakan ibu di rumah.
                    </p>
                    <div class="pt-2 mt-auto flex items-center gap-2 text-xs font-label-sm font-semibold text-primary opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <span>Resep Asli Warisan</span>
                        <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. TEASER DELIVERY PLATFORMS & DATANG LANGSUNG (§5.1 point 5) -->
    <section class="w-full py-16 px-4 sm:px-6 md:px-8 lg:px-12 bg-cream-bg" data-reveal>
        <div class="max-w-7xl mx-auto rounded-3xl bg-surface-container p-6 sm:p-8 lg:p-14 shadow-xs flex flex-col lg:flex-row items-center justify-between gap-8 sm:gap-10 border border-surface-variant/40">
            <div class="space-y-4 max-w-xl text-center lg:text-left">
                <span class="font-label-md uppercase tracking-wider text-primary font-bold text-xs sm:text-sm">2 Pilihan Pesan Mudah &amp; Cepat</span>
                <h2 class="font-headline-md text-2xl sm:text-3xl text-on-surface tracking-tight font-serif">Tersedia di Platform Favoritmu &amp; Datang Langsung</h2>
                <p class="font-body-lg text-secondary text-sm sm:text-base">
                    Mau santap lezat tanpa repot? Kami siap antar langsung pesanan hangat ke depan pintumu lewat online delivery (ShopeeFood, GoFood, GrabFood) atau datang langsung ke tempat kami untuk pesan.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row items-center gap-4 w-full lg:w-auto">
                <div class="flex items-center gap-3 flex-wrap justify-center">
                    <a href="{{ url('/pesan') }}#online" class="px-5 py-3 rounded-xl bg-surface-warm shadow-xs flex items-center gap-2.5 font-label-md text-on-surface hover:-translate-y-0.5 transition-all border border-surface-variant/40 group">
                        <img src="{{ asset('images/platforms/shopeefood.svg') }}" alt="ShopeeFood" class="w-6 h-6 rounded-md shrink-0 object-contain shadow-xs">
                        <span class="font-medium group-hover:text-[#EE4D2D] transition-colors">ShopeeFood</span>
                    </a>
                    <a href="{{ url('/pesan') }}#online" class="px-5 py-3 rounded-xl bg-surface-warm shadow-xs flex items-center gap-2.5 font-label-md text-on-surface hover:-translate-y-0.5 transition-all border border-surface-variant/40 group">
                        <img src="{{ asset('images/platforms/gofood.svg') }}" alt="GoFood" class="w-6 h-6 rounded-md shrink-0 object-contain shadow-xs">
                        <span class="font-medium group-hover:text-[#EE2737] transition-colors">GoFood</span>
                    </a>
                    <a href="{{ url('/pesan') }}#online" class="px-5 py-3 rounded-xl bg-surface-warm shadow-xs flex items-center gap-2.5 font-label-md text-on-surface hover:-translate-y-0.5 transition-all border border-surface-variant/40 group">
                        <img src="{{ asset('images/platforms/grabfood.svg') }}" alt="GrabFood" class="w-6 h-6 rounded-md shrink-0 object-contain shadow-xs">
                        <span class="font-medium group-hover:text-[#00B14F] transition-colors">GrabFood</span>
                    </a>
                </div>
                <a href="{{ url('/pesan') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-inverse-surface text-inverse-on-surface hover:bg-black font-label-md transition-all shadow-xs shrink-0 active:scale-95">
                    <span>Lihat Panduan Pesan</span>
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>

    <!-- 6. TESTIMONI & SUARA PELANGGAN (§5.1 point 6) -->
    <section class="w-full py-16 lg:py-24 px-4 sm:px-6 md:px-8 lg:px-12 bg-surface-warm border-t border-surface-variant/30" data-reveal>
        <div class="max-w-7xl mx-auto flex flex-col gap-12">
            <div class="text-center max-w-2xl mx-auto space-y-3">
                <span class="font-label-md uppercase tracking-widest text-primary font-bold text-xs sm:text-sm">Kata Pelanggan Kami</span>
                <h2 class="font-headline-lg text-3xl sm:text-4xl text-on-surface tracking-tight font-serif">Kisah Nyata dari Meja Mereka</h2>
                <p class="font-body-lg text-secondary text-base">Testimoni tulus dari para pelanggan yang telah mempercayakan santapan harian dan acara spesial mereka kepada Yan's Food.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8" data-reveal-group>
                <!-- Quote 1: Risol Mayo (Data Master) -->
                <div class="group hover-card-premium p-6 sm:p-8 rounded-3xl bg-cream-bg shadow-xs border border-surface-variant/40 flex flex-col justify-between cursor-default">
                    <div class="space-y-4">
                        <div class="flex items-center text-[#E5A000] text-sm group-hover:scale-105 transition-transform duration-300 origin-left">
                            <span class="material-symbols-outlined text-[18px] icon-fill">star</span>
                            <span class="material-symbols-outlined text-[18px] icon-fill">star</span>
                            <span class="material-symbols-outlined text-[18px] icon-fill">star</span>
                            <span class="material-symbols-outlined text-[18px] icon-fill">star</span>
                            <span class="material-symbols-outlined text-[18px] icon-fill">star</span>
                        </div>
                        <p class="font-body-md text-on-surface leading-relaxed italic font-serif text-sm sm:text-base group-hover:text-primary transition-colors duration-300">
                            &ldquo;Risol mayonya bener-bener juara! Kulit luarnya garing renyah keemasan, dan isian mayonesnya lumer gurih melimpah. Tiap kali kumpul keluarga atau arisan selalu pesan ini dan langsung ludes seketika.&rdquo;
                        </p>
                    </div>
                    <div class="pt-6 border-t border-surface-variant/40 mt-6 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center font-bold text-primary text-sm font-serif hover-icon-bounce shrink-0 shadow-2xs">
                            RW
                        </div>
                        <div>
                            <p class="font-label-md text-on-surface font-semibold text-sm">Ibu Rina Wardani</p>
                            <p class="font-body-sm text-secondary text-xs">Pelanggan Setia Risol Mayo</p>
                        </div>
                    </div>
                </div>

                <!-- Quote 2: Nasi Goreng (Data Master) -->
                <div class="group hover-card-premium p-6 sm:p-8 rounded-3xl bg-cream-bg shadow-xs border border-surface-variant/40 flex flex-col justify-between cursor-default">
                    <div class="space-y-4">
                        <div class="flex items-center text-[#E5A000] text-sm group-hover:scale-105 transition-transform duration-300 origin-left">
                            <span class="material-symbols-outlined text-[18px] icon-fill">star</span>
                            <span class="material-symbols-outlined text-[18px] icon-fill">star</span>
                            <span class="material-symbols-outlined text-[18px] icon-fill">star</span>
                            <span class="material-symbols-outlined text-[18px] icon-fill">star</span>
                            <span class="material-symbols-outlined text-[18px] icon-fill">star</span>
                        </div>
                        <p class="font-body-md text-on-surface leading-relaxed italic font-serif text-sm sm:text-base group-hover:text-primary transition-colors duration-300">
                            &ldquo;Nasi goreng di Yan's Food punya racikan bumbu ulek rempah rumahan yang otentik dan meresap banget. Gurihnya pas, porsinya ngenyangin, telurnya mantap, dan kerupuknya renyah. Menu makan siang andalan kantor!&rdquo;
                        </p>
                    </div>
                    <div class="pt-6 border-t border-surface-variant/40 mt-6 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-tertiary-fixed flex items-center justify-center font-bold text-tertiary text-sm font-serif hover-icon-bounce shrink-0 shadow-2xs">
                            DH
                        </div>
                        <div>
                            <p class="font-label-md text-on-surface font-semibold text-sm">Dimas Hendrawan</p>
                            <p class="font-body-sm text-secondary text-xs">Penikmat Nasi Goreng &amp; Menu Berat</p>
                        </div>
                    </div>
                </div>

                <!-- Quote 3: Snack Box & Katering Acara -->
                <div class="group hover-card-premium p-6 sm:p-8 rounded-3xl bg-cream-bg shadow-xs border border-surface-variant/40 flex flex-col justify-between cursor-default">
                    <div class="space-y-4">
                        <div class="flex items-center text-[#E5A000] text-sm group-hover:scale-105 transition-transform duration-300 origin-left">
                            <span class="material-symbols-outlined text-[18px] icon-fill">star</span>
                            <span class="material-symbols-outlined text-[18px] icon-fill">star</span>
                            <span class="material-symbols-outlined text-[18px] icon-fill">star</span>
                            <span class="material-symbols-outlined text-[18px] icon-fill">star</span>
                            <span class="material-symbols-outlined text-[18px] icon-fill">star</span>
                        </div>
                        <p class="font-body-md text-on-surface leading-relaxed italic font-serif text-sm sm:text-base group-hover:text-primary transition-colors duration-300">
                            &ldquo;Pesan paket snack box dan katering untuk acara rapat kantor dan syukuran keluarga besar. Makanannya tiba tepat waktu, kemasannya higienis dan rapi, serta variasinya komplit. Semua tamu dan rekan kerja sangat puas!&rdquo;
                        </p>
                    </div>
                    <div class="pt-6 border-t border-surface-variant/40 mt-6 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-secondary-fixed flex items-center justify-center font-bold text-on-secondary-fixed text-sm font-serif hover-icon-bounce shrink-0 shadow-2xs">
                            SA
                        </div>
                        <div>
                            <p class="font-label-md text-on-surface font-semibold text-sm">Sarah Anindya</p>
                            <p class="font-body-sm text-secondary text-xs">Penyelenggara Acara &amp; Katering (50+ Box)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. CTA PENUTUP (§5.1 point 7) -->
    <section class="w-full py-16 lg:py-24 px-4 sm:px-6 md:px-8 lg:px-12 bg-gradient-to-br from-primary-container via-primary to-primary-dark text-on-primary" data-reveal>
        <div class="max-w-4xl mx-auto text-center flex flex-col items-center gap-8">
            <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center shadow-inner">
                <span class="material-symbols-outlined text-tertiary-fixed text-[36px]">lunch_dining</span>
            </div>
            <h2 class="font-headline-lg text-3xl sm:text-4xl lg:text-5xl text-on-primary tracking-tight font-serif max-w-2xl">
                Siap Menikmati Kelezatan Yan's Food Hari Ini?
            </h2>
            <p class="font-body-lg text-on-primary-container max-w-xl leading-relaxed text-base sm:text-lg">
                Pesan untuk santapan keluarga, camilan santai, hingga makan siang hangat favorit Anda.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-4 pt-2">
                <a href="{{ url('/pesan') }}#online" class="btn-hover-sophisticated inline-flex items-center justify-center gap-2.5 px-8 py-4 rounded-2xl bg-surface-warm text-primary font-label-md hover:bg-surface-bright transition-all duration-300 font-bold group shadow-lg">
                    <span class="material-symbols-outlined text-[22px] transition-transform duration-300 group-hover:scale-110 group-hover:-rotate-6">moped</span>
                    <span>Pesan via Aplikasi</span>
                </a>
                <a href="https://maps.app.goo.gl/KnCpj3ViPCHGNmH66" target="_blank" rel="noopener noreferrer" class="btn-hover-glass inline-flex items-center justify-center gap-2.5 px-8 py-4 rounded-2xl bg-white/15 hover:bg-white/25 text-white font-label-md backdrop-blur-md transition-all duration-300 border border-white/25 font-bold group">
                    <span class="material-symbols-outlined text-[22px] text-tertiary-fixed transition-transform duration-300 group-hover:scale-110 group-hover:translate-x-0.5">near_me</span>
                    <span>Datang Langsung ke Tempat</span>
                </a>
            </div>
        </div>
    </section>
</x-app-layout>
