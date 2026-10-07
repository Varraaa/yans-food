<footer class="w-full bg-inverse-surface text-inverse-on-surface pt-16 pb-12 mt-auto">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-12 pb-14 border-b border-surface-variant/20">
            
            <!-- Col 1: Brand & Motto -->
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <span class="font-headline-sm text-tertiary-fixed font-bold tracking-tight text-2xl font-serif">Yan's Food</span>
                </div>
                <p class="font-body-sm text-surface-variant leading-relaxed">
                    Usaha kuliner rumahan yang menyajikan aneka kudapan renyah & makanan hangat dengan rasa otentik, higienis, dan penuh dedikasi.
                </p>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-surface-container-highest/20 text-tertiary-fixed font-label-sm text-xs">
                    <span class="w-2 h-2 rounded-full bg-success"></span>
                    <span>100% Halal & Fresh Cooked</span>
                </div>
            </div>

            <!-- Col 2: Navigasi Cepat -->
            <div class="space-y-4">
                <h4 class="font-label-md uppercase tracking-wider text-tertiary-fixed font-semibold text-xs">Navigasi</h4>
                <ul class="space-y-2.5 font-body-sm">
                    <li><a href="{{ url('/') }}" class="text-surface-variant hover:text-on-primary transition-colors">Home (Beranda)</a></li>
                    <li><a href="{{ url('/about') }}" class="text-surface-variant hover:text-on-primary transition-colors">About (Tentang Kami)</a></li>
                    <li><a href="{{ url('/menu') }}" class="text-surface-variant hover:text-on-primary transition-colors">Menu (Katalog Lengkap)</a></li>
                    <li><a href="{{ url('/pesan') }}" class="text-surface-variant hover:text-on-primary transition-colors">Pesan (Online & Katering)</a></li>
                    <li><a href="{{ url('/contact') }}" class="text-surface-variant hover:text-on-primary transition-colors">Contact (Kontak & Lokasi)</a></li>
                </ul>
            </div>

            <!-- Col 3: Kontak & Operasional -->
            <div class="space-y-4">
                <h4 class="font-label-md uppercase tracking-wider text-tertiary-fixed font-semibold text-xs">Kontak & Operasional</h4>
                <ul class="space-y-3 font-body-sm text-surface-variant">
                    <li class="flex items-start gap-2.5">
                        <span class="material-symbols-outlined text-[20px] text-tertiary-fixed shrink-0">location_on</span>
                        <span>Jl. Melati No. 14, Jakarta Selatan</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="material-symbols-outlined text-[20px] text-tertiary-fixed shrink-0">schedule</span>
                        <span>Buka Setiap Hari: 08.00 - 20.00 WIB</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="material-symbols-outlined text-[20px] text-tertiary-fixed shrink-0">call</span>
                        <a href="https://wa.me/6281234567890" target="_blank" rel="noopener" class="hover:text-tertiary-fixed transition-colors">
                            +62 812-3456-7890
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Col 4: Sosial Media -->
            <div class="space-y-4">
                <h4 class="font-label-md uppercase tracking-wider text-tertiary-fixed font-semibold text-xs">Sosial Media</h4>
                <div class="flex flex-col gap-2.5 font-body-sm text-surface-variant">
                    <a href="https://instagram.com" target="_blank" rel="noopener" class="flex items-center gap-2 hover:text-tertiary-fixed transition-colors">
                        <span class="material-symbols-outlined text-[18px] text-tertiary-fixed">photo_camera</span>
                        <span>Instagram @yansfood.official</span>
                    </a>
                    <a href="https://tiktok.com" target="_blank" rel="noopener" class="flex items-center gap-2 hover:text-tertiary-fixed transition-colors">
                        <span class="material-symbols-outlined text-[18px] text-tertiary-fixed">videocam</span>
                        <span>TikTok @yansfood</span>
                    </a>
                    <a href="mailto:halo@yansfood.id" class="flex items-center gap-2 hover:text-tertiary-fixed transition-colors">
                        <span class="material-symbols-outlined text-[18px] text-tertiary-fixed">mail</span>
                        <span>halo@yansfood.id</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Row: Platform Delivery & Copyright -->
        <div class="pt-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-2 flex-wrap">
                <span class="font-label-sm text-surface-variant mr-2">Tersedia juga di:</span>
                <a href="{{ url('/pesan') }}" class="px-3 py-1.5 rounded-full bg-surface-container-highest/20 text-surface-variant hover:bg-[#EE4D2D] hover:text-white font-label-sm transition-all duration-200">
                    ShopeeFood
                </a>
                <a href="{{ url('/pesan') }}" class="px-3 py-1.5 rounded-full bg-surface-container-highest/20 text-surface-variant hover:bg-[#00AA13] hover:text-white font-label-sm transition-all duration-200">
                    GoFood
                </a>
                <a href="{{ url('/pesan') }}" class="px-3 py-1.5 rounded-full bg-surface-container-highest/20 text-surface-variant hover:bg-[#00B14F] hover:text-white font-label-sm transition-all duration-200">
                    GrabFood
                </a>
            </div>
            <div class="font-body-sm text-surface-variant text-center md:text-right">
                &copy; {{ date('Y') }} Yan's Food. Semua hak cipta dilindungi.
            </div>
        </div>
    </div>
</footer>
