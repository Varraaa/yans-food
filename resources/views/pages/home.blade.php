<x-app-layout>
    <x-slot name="title">Beranda | Yan's Food — Dapur Kuliner Rumahan</x-slot>

    <!-- HERO SECTION -->
    <section class="relative w-full overflow-hidden bg-cream-bg py-12 lg:py-20 px-4 sm:px-6 lg:px-12">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            
            <!-- Left Hero Content -->
            <div class="lg:col-span-7 flex flex-col items-start gap-6 lg:gap-8">
                <!-- Review Pill Badge -->
                <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-surface-container text-tertiary shadow-sm">
                    <span class="flex items-center text-[#E5A000] text-sm">
                        <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">star</span>
                        <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">star</span>
                        <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">star</span>
                        <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">star</span>
                        <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">star</span>
                    </span>
                    <span class="font-label-md text-on-surface font-semibold">4.9/5</span>
                    <span class="w-1 h-1 rounded-full bg-outline"></span>
                    <span class="font-body-sm text-on-surface-variant">500+ Pelanggan Puas</span>
                </div>

                <!-- Main Headline -->
                <h1 class="font-headline-lg text-4xl sm:text-5xl lg:text-6xl text-on-surface tracking-tight font-serif leading-[1.15]">
                    Rasa Rumahan, <br class="hidden sm:block"/>
                    <span class="text-primary italic font-normal">Disajikan dengan Hati</span>
                </h1>

                <!-- Subheadline -->
                <p class="font-body-lg text-secondary max-w-2xl leading-relaxed text-base sm:text-lg">
                    Dari dapur rumahan yang bersih dan penuh dedikasi, Yan's Food menghadirkan aneka kudapan gurih, hidangan hangat, hingga minuman segar untuk setiap momen santaimu.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-wrap items-center gap-4 pt-2 w-full sm:w-auto">
                    <a href="{{ url('/menu') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-xl bg-primary-container text-on-primary font-label-md hover:bg-primary-dark transition-all duration-200 shadow-md active:scale-95">
                        <span>Lihat Menu Lengkap</span>
                        <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    </a>
                    <a href="{{ url('/pesan') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-xl bg-surface-warm text-on-surface font-label-md hover:bg-surface-container transition-all duration-200 shadow-sm border border-surface-variant/40 active:scale-95">
                        <span class="material-symbols-outlined text-[20px] text-primary">local_mall</span>
                        <span>Pesan Sekarang</span>
                    </a>
                </div>

                <!-- Trust Badges Under Hero -->
                <div class="pt-6 grid grid-cols-3 gap-4 sm:gap-6 w-full max-w-lg bg-surface-container-low p-4 sm:p-5 rounded-2xl shadow-sm border border-surface-variant/30">
                    <div class="flex flex-col">
                        <span class="font-headline-sm text-primary font-bold text-xl sm:text-2xl font-serif">100%</span>
                        <span class="font-label-sm text-secondary text-xs sm:text-sm">Bahan Segar Alami</span>
                    </div>
                    <div class="flex flex-col border-x border-surface-variant/50 px-3 sm:px-4">
                        <span class="font-headline-sm text-primary font-bold text-xl sm:text-2xl font-serif">Fresh</span>
                        <span class="font-label-sm text-secondary text-xs sm:text-sm">Dibuat Hari Ini</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-headline-sm text-primary font-bold text-xl sm:text-2xl font-serif">Halal</span>
                        <span class="font-label-sm text-secondary text-xs sm:text-sm">Higienis & Amanah</span>
                    </div>
                </div>
            </div>

            <!-- Right Visual Collage -->
            <div class="lg:col-span-5 relative">
                <div class="relative w-full aspect-[4/5] rounded-3xl overflow-hidden shadow-xl bg-surface-container">
                    <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuC0yQ-j1z3AvTOxnG1AkwOJ0fmoq8g9MoW0OcApYSuwOdpLt4FLyDdc2QgEF-ukq3fjIM2dKQHU0UJNThY7N4VTaXisRBgJsC6POPbZxqmyfkqRfvPtbc-jSP_QjJWXgWcIdyWiG1qr5EFYCyICPlpR7qPax3-gh_Dd5sOIJ5Z1Jurn7jRr5iufoXtSWwf4mEGafDRK3Qc2aaIJBIDNbvSSDAlVoK21EfipdBbJizEcd-q3tLdbCeau" 
                         alt="Sajian kuliner otentik Yan's Food" 
                         class="w-full h-full object-cover">
                    
                    <!-- Floating Editorial Pill Overlay -->
                    <div class="absolute bottom-6 left-6 right-6 p-4 sm:p-5 rounded-2xl bg-surface-warm/95 backdrop-blur-md shadow-lg flex items-center justify-between border border-surface-variant/40">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-xl bg-primary-fixed flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-primary text-[24px]">restaurant_menu</span>
                            </div>
                            <div>
                                <p class="font-headline-sm text-on-surface text-base sm:text-lg font-serif">Kudapan & Makanan Hangat</p>
                                <p class="font-body-sm text-secondary text-xs sm:text-sm">Resep Asli Racikan Keluarga</p>
                            </div>
                        </div>
                        <span class="font-label-sm uppercase tracking-wider text-primary font-bold bg-primary/10 px-2.5 py-1 rounded-md text-[11px]">Fresh Cooked</span>
                    </div>
                </div>

                <!-- Decorative Ambient Glows -->
                <div class="absolute -top-6 -right-6 w-32 h-32 bg-primary/10 rounded-full blur-2xl -z-10"></div>
                <div class="absolute -bottom-6 -left-6 w-40 h-40 bg-tertiary-fixed/30 rounded-full blur-3xl -z-10"></div>
            </div>
        </div>
    </section>

    <!-- PENGENALAN SINGKAT (§4.2 point 2) -->
    <section class="w-full py-16 lg:py-24 px-4 sm:px-6 lg:px-12 bg-surface-warm border-y border-surface-variant/30">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            <!-- Left: Kitchen Craft Photo -->
            <div class="lg:col-span-6 relative">
                <div class="aspect-[4/3] rounded-3xl overflow-hidden shadow-md bg-surface-container">
                    <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuBn1TinkqNIVV7h2qq1GxjrOnc4gBx76s0MsWSkKpaCqOcpu0_YHs1PEx71CI1kVG54saVxEsBaCarut2IMBc3gB6FkdYFLWED9CzdQiyWN4JpOaLwxKrC-omYS70DjFf4YAAWzb7Q7OFbMVdeleBHwkI366riPzhZPmJJdm5Q1lZ_nbh7rMkIvcv8ky4vmqUmgNQSU03ql4J3e2Q_Py6cpZw8GlulXxb1w4VV49vZ6dLfJO-FeEheV" 
                         alt="Dapur Bersih Yan's Food" 
                         class="w-full h-full object-cover">
                </div>
                <!-- Offset Detail Card -->
                <div class="absolute -bottom-6 -right-4 sm:-right-6 p-5 sm:p-6 rounded-2xl bg-inverse-surface text-inverse-on-surface max-w-xs shadow-xl hidden sm:block">
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
            <div class="lg:col-span-6 flex flex-col items-start gap-6">
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

    <!-- PRODUK UNGGULAN (§4.2 point 3) -->
    <section class="w-full py-16 lg:py-24 px-4 sm:px-6 lg:px-12 bg-cream-bg">
        <div class="max-w-7xl mx-auto flex flex-col gap-12">
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="space-y-3 max-w-2xl">
                    <span class="font-label-md uppercase tracking-widest text-primary font-bold text-xs sm:text-sm">Menu Pilihan Terbaik</span>
                    <h2 class="font-headline-lg text-3xl sm:text-4xl text-on-surface tracking-tight font-serif">Menu Favorit Pilihan Pelanggan</h2>
                    <p class="font-body-lg text-secondary text-base sm:text-lg">Kreasi rumahan yang paling sering dipesan ulang oleh pelanggan setia kami.</p>
                </div>
                <a href="{{ url('/menu') }}" class="inline-flex items-center gap-2 font-label-md text-primary hover:text-primary-dark transition-colors font-bold self-start md:self-end pb-1">
                    <span>Lihat Semua Menu</span>
                    <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                </a>
            </div>

            <!-- 4 Featured Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- 1: Risol Mayo -->
                <x-food-card 
                    title="Risol Mayo Spesial"
                    category="Kudapan Gurih"
                    categorySlug="ringan"
                    price="4.500"
                    unit="/ pcs"
                    image="https://lh3.googleusercontent.com/aida-public/AB6AXuCyfuXln7cyGrY2lKM07Nk3VKMQjY3ZTmHoC1dw90oSQpU6K9GToD9dsNw7j-ONqeDlAGA4dUHsambXmkUw1VSykY9WS5EuOrd2vXOLVz_gDlJDQpTckcMcGct8EuAcmM-Aj5VFqr78aR9bpsCfWc7L5uPmlfvvfJvmZbLdxztCm-fUjNoCNBg6rJwiIGonOikHOEVhan_cN8QOl7vVORz_mOuXsXhhH3TopjOFzgKMvjN75USyuea4"
                    desc="Kulit renyah lembut, smoked beef, telur, & racikan saus mayo gurih lumer khas racikan Yan's Food."
                    status="sedia"
                    :isFavorite="true" />

                <!-- 2: Nasi Goreng Jadul -->
                <x-food-card 
                    title="Nasi Goreng Jadul"
                    category="Makanan Berat"
                    categorySlug="berat"
                    price="22.000"
                    unit="/ porsi"
                    image="https://lh3.googleusercontent.com/aida-public/AB6AXuCvbMqJp4vasmNPRn7HlUQ53R3QwrbMiAJGRmOeSP3xoEqc-hb5EkQx28tGjOOddzhbh0BvjFwX_K2C7FkHaJpySF2zidCDs-Bx_mHHA3URhRcMv1OQhfIUJ4SnK1xWUswF-WwKCxa8-zJZmfBBJz1XBLusLQAzk5BcvZvIXzaDl0b5CzAHuTSEZQKFm2axnelXGbXdYgGwaMGpV41iikvWXq7ZllZ-h_pkIUZOUgUcN8KoU_ETwohF"
                    desc="Aroma bumbu ulek terasi tradisional dengan suwiran ayam, telur ceplok setengah matang, & kerupuk."
                    status="sedia"
                    :isFavorite="true" />

                <!-- 3: Pisang Coklat Crispy -->
                <x-food-card 
                    title="Pisang Coklat Lumer"
                    category="Kudapan Manis"
                    categorySlug="ringan"
                    price="3.500"
                    unit="/ pcs"
                    image="https://lh3.googleusercontent.com/aida-public/AB6AXuBts6_Y8VjNhmV1LnrN6Dm5iR4sSQV3xhLKrMWDJ6fdyqbxY5O9UUI0S756Cpv4FT1Yz-u3S4boBHAif6DwRvoIGDRnvaOAQC6T3FOJTit1ctKXlOxUcwCSHO1NAsIzokrAtdKAhabshRPcb8-79Kx_Y0Npfeb0F49PFjc2JS3S2A5MMw-cxhx3jqPOPn8bT9D07fWrCrU6OzYatoJuHKSSOFKhB75_p_Sr9SRd84JFSYkDWNiu3HvX"
                    desc="Pisang raja manis legit dengan coklat melimpah berbalut kulit crispy emas yang renyah tahan lama."
                    status="sedia"
                    :isFavorite="true" />

                <!-- 4: Es Kopi Susu Aren -->
                <x-food-card 
                    title="Es Kopi Susu Aren"
                    category="Minuman Segar"
                    categorySlug="minuman"
                    price="15.000"
                    unit="/ cup"
                    image="https://lh3.googleusercontent.com/aida-public/AB6AXuDuU3Yxrcih-pg6m2nRhDlGOylXXNiZpcpRJOwpGtbqdy2tID_2dcQH8vFY45VJyojhQ_EhfmASszkIE7eY72DmaCVEuoHwd-g6ry7je_ScQ_2fJ8jLVTp1o_iCgl3eLUn5tGJpOrxa83pkjoHbquHRihUHOkcatbhcowl5ghx9jMRDqgTc1xq11rmDLIGt391ni6_gw1qdmchrGD1pMbRA1MfIPrtdWISTKpeaLC0pLS0h91QGgf47"
                    desc="Espresso blend robusta segar dengan gula aren murni dan susu gurih creamy yang menyegarkan."
                    status="sedia"
                    :isFavorite="false" />
            </div>
        </div>
    </section>

    <!-- KENAPA PILIH KAMI (§4.2 point 4) -->
    <section class="w-full py-16 lg:py-24 px-4 sm:px-6 lg:px-12 bg-surface-container-low border-y border-surface-variant/30">
        <div class="max-w-7xl mx-auto flex flex-col gap-14">
            <div class="text-center max-w-2xl mx-auto space-y-3">
                <span class="font-label-md uppercase tracking-widest text-primary font-bold text-xs sm:text-sm">Keunggulan Yan's Food</span>
                <h2 class="font-headline-lg text-3xl sm:text-4xl text-on-surface tracking-tight font-serif">Kualitas Jujur dari Dapur Kami</h2>
                <p class="font-body-lg text-secondary text-base sm:text-lg">Kami mengutamakan kesegaran dan higienitas untuk menghadirkan rasa yang selalu bisa dipercaya.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="p-8 rounded-3xl bg-surface-warm shadow-sm flex flex-col gap-4 border border-surface-variant/30 hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-primary-fixed flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[30px]">eco</span>
                    </div>
                    <h3 class="font-headline-sm text-on-surface text-xl font-serif">Bahan Baku Segar Setiap Hari</h3>
                    <p class="font-body-md text-secondary leading-relaxed">
                        Dibuat fresh tanpa stok beku lama, menjaga nutrisi, kesegaran rempah, dan kerenyahan tekstur terbaik di setiap gigitan.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="p-8 rounded-3xl bg-surface-warm shadow-sm flex flex-col gap-4 border border-surface-variant/30 hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-tertiary-fixed flex items-center justify-center text-tertiary">
                        <span class="material-symbols-outlined text-[30px]">sanitizer</span>
                    </div>
                    <h3 class="font-headline-sm text-on-surface text-xl font-serif">Higienis & Standar Dapur Rapi</h3>
                    <p class="font-body-md text-secondary leading-relaxed">
                        Proses pembuatan bersih berstandar rumahan premium dengan sanitasi peralatan masak dan kebersihan kemasan yang disiplin.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="p-8 rounded-3xl bg-surface-warm shadow-sm flex flex-col gap-4 border border-surface-variant/30 hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-secondary-fixed flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[30px]">soup_kitchen</span>
                    </div>
                    <h3 class="font-headline-sm text-on-surface text-xl font-serif">Rasa Otentik & Jujur</h3>
                    <p class="font-body-md text-secondary leading-relaxed">
                        Bumbu rempah asli warisan keluarga tanpa perisa sintetik berlebih, menghadirkan nostalgia kelezatan masakan ibu di rumah.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- TEASER DELIVERY PLATFORMS (§4.2 point 5) -->
    <section class="w-full py-16 px-4 sm:px-6 lg:px-12 bg-cream-bg">
        <div class="max-w-7xl mx-auto rounded-3xl bg-surface-container p-8 sm:p-10 lg:p-14 shadow-sm flex flex-col lg:flex-row items-center justify-between gap-10 border border-surface-variant/40">
            <div class="space-y-4 max-w-xl text-center lg:text-left">
                <span class="font-label-md uppercase tracking-wider text-primary font-bold text-xs sm:text-sm">Pesan Mudah & Cepat</span>
                <h2 class="font-headline-md text-2xl sm:text-3xl text-on-surface tracking-tight font-serif">Tersedia di Platform Favoritmu</h2>
                <p class="font-body-lg text-secondary">
                    Mau santap lezat tanpa repot keluar rumah? Kami siap antar langsung pesanan hangat ke depan pintumu.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row items-center gap-4 w-full lg:w-auto">
                <div class="flex items-center gap-3 flex-wrap justify-center">
                    <a href="{{ url('/pesan') }}" class="px-5 py-3 rounded-xl bg-surface-warm shadow-sm flex items-center gap-2.5 font-label-md text-on-surface hover:-translate-y-0.5 transition-all border border-surface-variant/40">
                        <span class="w-3 h-3 rounded-full bg-[#EE4D2D]"></span>
                        <span>ShopeeFood</span>
                    </a>
                    <a href="{{ url('/pesan') }}" class="px-5 py-3 rounded-xl bg-surface-warm shadow-sm flex items-center gap-2.5 font-label-md text-on-surface hover:-translate-y-0.5 transition-all border border-surface-variant/40">
                        <span class="w-3 h-3 rounded-full bg-[#00AA13]"></span>
                        <span>GoFood</span>
                    </a>
                    <a href="{{ url('/pesan') }}" class="px-5 py-3 rounded-xl bg-surface-warm shadow-sm flex items-center gap-2.5 font-label-md text-on-surface hover:-translate-y-0.5 transition-all border border-surface-variant/40">
                        <span class="w-3 h-3 rounded-full bg-[#00B14F]"></span>
                        <span>GrabFood</span>
                    </a>
                </div>
                <a href="{{ url('/pesan') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-inverse-surface text-inverse-on-surface hover:bg-black font-label-md transition-all shadow-sm shrink-0 active:scale-95">
                    <span>Lihat Semua Cara Pesan</span>
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>

    <!-- CTA PENUTUP (§4.2 point 7) -->
    <section class="w-full py-16 lg:py-24 px-4 sm:px-6 lg:px-12 bg-gradient-to-br from-primary-container via-primary to-primary-dark text-on-primary">
        <div class="max-w-4xl mx-auto text-center flex flex-col items-center gap-8">
            <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center shadow-inner">
                <span class="material-symbols-outlined text-tertiary-fixed text-[36px]">lunch_dining</span>
            </div>
            <h2 class="font-headline-lg text-3xl sm:text-4xl lg:text-5xl text-on-primary tracking-tight font-serif max-w-2xl">
                Siap Menikmati Kelezatan Yan's Food Hari Ini?
            </h2>
            <p class="font-body-lg text-on-primary-container max-w-xl leading-relaxed text-base sm:text-lg">
                Pesan untuk sarapan keluarga, camilan arisan, makan siang kantor, hingga acara katering spesial Anda.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-4 pt-2">
                <a href="{{ url('/menu') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-xl bg-surface-warm text-primary font-label-md hover:bg-surface-bright transition-all duration-200 shadow-xl font-bold active:scale-95">
                    <span>Buka Menu Lengkap</span>
                    <span class="material-symbols-outlined text-[20px]">restaurant_menu</span>
                </a>
                <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Yan's%20Food,%20saya%20mau%20pesan" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-xl bg-inverse-surface/40 hover:bg-inverse-surface/60 text-white font-label-md backdrop-blur-md transition-all duration-200 border border-white/10 active:scale-95">
                    <span class="material-symbols-outlined text-[20px]">chat</span>
                    <span>Pesan via WhatsApp</span>
                </a>
            </div>
        </div>
    </section>
</x-app-layout>
