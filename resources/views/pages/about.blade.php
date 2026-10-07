<x-app-layout>
    <x-slot name="title">Tentang Kami — Kisah & Nilai Dapur | Yan's Food</x-slot>

    <div class="relative w-full overflow-hidden">
        <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[720px] h-[340px] bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>

        <!-- 1. Header / Intro Narrative Sub-Hero -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 pt-12 pb-14 lg:pt-16 lg:pb-16 w-full relative z-10">
            <div class="flex flex-col items-center text-center max-w-3xl mx-auto space-y-5">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sand-bg-alt shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                    <span class="font-label-sm uppercase tracking-widest text-primary font-semibold text-xs">TENTANG KAMI &bull; DEDIKASI KULINER</span>
                </div>
                <h1 class="font-headline-lg text-3xl sm:text-4xl lg:text-5xl text-on-surface tracking-tight font-serif leading-tight">
                    Dapur Rumahan yang Tumbuh Bersama Kehangatan &amp; Kejujuran Rasa
                </h1>
                <p class="font-body-lg text-secondary max-w-2xl leading-relaxed text-base sm:text-lg">
                    Bermula dari meja makan kecil keluarga hingga menjadi pilihan kudapan dan santapan harian favorit di lingkungan kami.
                </p>
                <div class="pt-2 flex items-center justify-center gap-3 text-tertiary-fixed-dim">
                    <span class="h-px w-12 bg-surface-variant"></span>
                    <span class="material-symbols-outlined text-[20px] text-tertiary">restaurant</span>
                    <span class="h-px w-12 bg-surface-variant"></span>
                </div>
            </div>
        </section>

        <!-- 2. Asymmetrical Brand Story Section -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-10 lg:py-16 w-full border-t border-surface-variant/30">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                <!-- Visual Story Column (Left) -->
                <div class="lg:col-span-6 relative">
                    <div class="relative rounded-3xl overflow-hidden shadow-xl bg-surface-container aspect-[4/5] w-full">
                        <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuAzRT8g-wzoYqZeUDrksy8MnGbkK54k0QHLwrOQjY9qL7V4Hv8d4qmf1uK3-VgIntBqHioQJRnQkfdGj_qjH9DSll49RWYcUjdTXLsmbLWQtjZrBM4n2M_8YrdNLt7WRiTx-NPA3XFsIZrO03tpGPXefj9O-ho2dweK4X7Uto5vboGOmU_AKp_FnvP8cywJc8JvrIE5MwfDXtglImY-P1_2gpLyDNhQPq-X47HBJXyGn7CweR2D0y6F" 
                             alt="Proses Masak Dapur Yan's Food" 
                             class="w-full h-full object-cover transition-transform duration-700 hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-inverse-surface/70 via-inverse-surface/10 to-transparent"></div>
                        
                        <!-- Overlay Pill -->
                        <div class="absolute bottom-6 left-6 right-6 p-4 sm:p-5 rounded-2xl bg-surface-warm/95 backdrop-blur-md shadow-md border border-surface-variant/40">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-primary-fixed flex items-center justify-center text-primary-dark shrink-0">
                                    <span class="material-symbols-outlined text-[22px]">skillet</span>
                                </div>
                                <div>
                                    <p class="font-headline-sm text-on-surface font-serif text-base">Tradisi Dapur Nenek</p>
                                    <p class="font-body-sm text-secondary text-xs sm:text-sm">Resep turun-temurun dengan rempah alami utuh tanpa jalan pintas.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Decorative Floating Accent Badge -->
                    <div class="hidden sm:flex absolute -bottom-6 -right-6 bg-surface-warm p-4 rounded-2xl shadow-xl items-center gap-3 max-w-xs z-20 border border-surface-variant/40">
                        <span class="material-symbols-outlined text-tertiary text-2xl">verified</span>
                        <div>
                            <p class="font-label-md text-on-surface text-sm">Tanpa Pengawet Sintetis</p>
                            <p class="font-body-sm text-secondary text-xs">Selalu segar setiap hari</p>
                        </div>
                    </div>
                </div>

                <!-- Narrative Column (Right) -->
                <div class="lg:col-span-6 space-y-6">
                    <div class="space-y-3">
                        <span class="font-label-md uppercase tracking-wider text-primary font-bold text-xs sm:text-sm">Kisah Kami</span>
                        <h2 class="font-headline-md text-2xl sm:text-3xl lg:text-4xl text-on-surface font-serif leading-snug">
                            Bukan Pabrik Makanan, Kami Memasak Seperti untuk Keluarga Sendiri
                        </h2>
                    </div>

                    <div class="space-y-4 font-body-md text-secondary leading-relaxed text-sm sm:text-base">
                        <p>
                            Yan's Food berawal dari dapur mungil di sudut rumah kami. Bermula dari resep rahasia risol mayo lembut racikan keluarga—dengan isian smoked beef gurih, telur iris lembut, serta racikan mayones manis-gurih khas rumahan yang lumer di lidah.
                        </p>
                        <p>
                            Banyak yang bertanya mengapa menu kami bervariasi: dari camilan renyah seperti risol mayo dan pisang coklat lumer, santapan berat seperti nasi goreng bumbu jadul harum terasi bakar, hingga segarnya es kopi susu gula aren. Jawabannya sederhana: dapur rumah yang sesungguhnya selalu memasak apa yang membawa senyum dan kehangatan bagi keluarga.
                        </p>
                    </div>

                    <!-- Highlight Quote Box -->
                    <div class="p-6 rounded-2xl bg-sand-bg-alt shadow-sm relative overflow-hidden border border-surface-variant/40">
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-tertiary"></div>
                        <p class="font-headline-sm italic text-on-surface leading-relaxed pl-2 font-serif text-sm sm:text-base">
                            &ldquo;Kami percaya masakan terbaik tidak lahir dari kompor industri, melainkan dari tangan yang telaten dan bumbu rempah yang tak pernah dipangkas demi keuntungan semata.&rdquo;
                        </p>
                        <p class="mt-3 font-label-md text-tertiary font-bold pl-2 text-xs uppercase tracking-wider">
                            &mdash; Dapur Utama Yan's Food
                        </p>
                    </div>

                    <!-- Stat Chips / Highlights -->
                    <div class="grid grid-cols-3 gap-3 pt-2">
                        <div class="p-4 rounded-2xl bg-surface-warm shadow-sm flex flex-col items-center text-center justify-center border border-surface-variant/40">
                            <span class="font-numeric-currency text-primary text-xl sm:text-2xl font-bold font-serif">100%</span>
                            <span class="font-label-sm text-secondary text-[11px] sm:text-xs mt-1">Bebas Pengawet</span>
                        </div>
                        <div class="p-4 rounded-2xl bg-surface-warm shadow-sm flex flex-col items-center text-center justify-center border border-surface-variant/40">
                            <span class="font-numeric-currency text-primary text-xl sm:text-2xl font-bold font-serif">15+</span>
                            <span class="font-label-sm text-secondary text-[11px] sm:text-xs mt-1">Varian Resep</span>
                        </div>
                        <div class="p-4 rounded-2xl bg-surface-warm shadow-sm flex flex-col items-center text-center justify-center border border-surface-variant/40">
                            <span class="font-numeric-currency text-primary text-xl sm:text-2xl font-bold font-serif">500+</span>
                            <span class="font-label-sm text-secondary text-[11px] sm:text-xs mt-1">Acara Terlayani</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. Section Visi, Misi & Nilai-Nilai Inti (Card Grid) -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-16 lg:py-24 w-full bg-surface-container-low/40 rounded-3xl my-8">
            <div class="text-center max-w-2xl mx-auto mb-14 space-y-3">
                <span class="font-label-md uppercase tracking-wider text-primary font-bold text-xs sm:text-sm">Fondasi Kualitas</span>
                <h2 class="font-headline-md text-2xl sm:text-3xl lg:text-4xl text-on-surface font-serif">
                    Prinsip yang Selalu Kami Rawat
                </h2>
                <p class="font-body-md text-secondary">
                    Tiga komitmen yang tak pernah kami kompromikan sejak hari pertama panci kompor kami dinyalakan.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="group p-8 rounded-3xl bg-surface-warm shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300 flex flex-col justify-between border border-surface-variant/40">
                    <div class="space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-success-surface flex items-center justify-center text-success transition-transform duration-300 group-hover:scale-110">
                            <span class="material-symbols-outlined text-[30px]" style="font-variation-settings: 'FILL' 1;">sanitizer</span>
                        </div>
                        <h3 class="font-headline-sm text-on-surface font-serif text-xl">
                            Dapur Bersih Berstandar Resto
                        </h3>
                        <p class="font-body-md text-secondary leading-relaxed text-sm">
                            Menjaga sanitasi ketat dengan standar kebersihan modern tanpa mematikan atmosfer kehangatan dapur rumahan yang penuh cita rasa.
                        </p>
                    </div>
                    <div class="pt-6 flex items-center gap-2 text-success font-label-sm font-semibold text-xs border-t border-surface-variant/30 mt-6">
                        <span class="material-symbols-outlined text-[18px]">verified_user</span>
                        <span>Higienis & Terinspeksi Harian</span>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="group p-8 rounded-3xl bg-surface-warm shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300 flex flex-col justify-between border border-surface-variant/40">
                    <div class="space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-surface-container-high flex items-center justify-center text-primary-container transition-transform duration-300 group-hover:scale-110">
                            <span class="material-symbols-outlined text-[30px]" style="font-variation-settings: 'FILL' 1;">eco</span>
                        </div>
                        <h3 class="font-headline-sm text-on-surface font-serif text-xl">
                            Bahan Baku Segar Pagi Hari
                        </h3>
                        <p class="font-body-md text-secondary leading-relaxed text-sm">
                            Daging asap pilihan, rempah alami pasar pagi, tanpa perisa kimiawi sintetis atau pengawet buatan yang mengorbankan kesehatan.
                        </p>
                    </div>
                    <div class="pt-6 flex items-center gap-2 text-primary font-label-sm font-semibold text-xs border-t border-surface-variant/30 mt-6">
                        <span class="material-symbols-outlined text-[18px]">nest_eco_leaf</span>
                        <span>100% Rempah Murni</span>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="group p-8 rounded-3xl bg-surface-warm shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300 flex flex-col justify-between border border-surface-variant/40">
                    <div class="space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-tertiary-fixed flex items-center justify-center text-on-tertiary-fixed-variant transition-transform duration-300 group-hover:scale-110">
                            <span class="material-symbols-outlined text-[30px]" style="font-variation-settings: 'FILL' 1;">favorite</span>
                        </div>
                        <h3 class="font-headline-sm text-on-surface font-serif text-xl">
                            Rasa yang Bikin Kangen Rumah
                        </h3>
                        <p class="font-body-md text-secondary leading-relaxed text-sm">
                            Porsi mantap, isian padat legit, dibuat segar per kloter penggorengan sehingga tiba di tangan Anda dalam kondisi prima.
                        </p>
                    </div>
                    <div class="pt-6 flex items-center gap-2 text-tertiary font-label-sm font-semibold text-xs border-t border-surface-variant/30 mt-6">
                        <span class="material-symbols-outlined text-[18px]">soup_kitchen</span>
                        <span>Fresh Per Kloter Masak</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. CTA to Menu -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-12 pb-20 text-center">
            <div class="p-8 sm:p-12 rounded-3xl bg-surface-warm border border-surface-variant/40 shadow-sm flex flex-col items-center gap-6">
                <h3 class="font-headline-md text-2xl sm:text-3xl text-on-surface font-serif">
                    Ingin Mencoba Cita Rasa Kami?
                </h3>
                <p class="font-body-md text-secondary max-w-xl text-sm sm:text-base">
                    Jelajahi menu harian kami atau pesan paket katering spesial untuk acara Anda hari ini.
                </p>
                <div class="flex flex-wrap items-center justify-center gap-4">
                    <a href="{{ url('/menu') }}" class="px-7 py-3.5 rounded-xl bg-primary-container text-on-primary font-label-md hover:bg-primary-dark transition-colors shadow-md">
                        Buka Katalog Menu
                    </a>
                    <a href="{{ url('/pesan') }}" class="px-7 py-3.5 rounded-xl bg-surface-container text-on-surface font-label-md hover:bg-surface-container-high transition-colors">
                        Pesan Katering & Online
                    </a>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
