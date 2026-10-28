<!-- Modular Footer (§5.6) -->
<footer class="w-full bg-inverse-surface text-inverse-on-surface pt-16 pb-12 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 lg:px-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 lg:gap-12 pb-14 border-b border-surface-variant/20">
            
            <!-- Col 1: Brand & Motto -->
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-[#E2631C] p-[2px] shadow-sm shrink-0">
                        <div class="w-full h-full rounded-[14px] bg-[#E2631C] flex items-center justify-center overflow-hidden">
                            <img src="{{ asset('images/logo/Icon Yans Food.svg') }}" 
                                 alt="Yan's Food" 
                                 class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="flex flex-col leading-none">
                        <span class="font-headline-sm text-tertiary-fixed font-bold tracking-tight text-xl font-serif">Yan's Food</span>
                        <span class="text-[9px] font-bold uppercase tracking-[0.16em] text-[#D6A253] pt-0.5">Dapur Kuliner Rumahan</span>
                    </div>
                </div>
                <p class="font-body-sm text-surface-variant leading-relaxed">
                    Usaha kuliner rumahan yang menyajikan aneka kudapan renyah & makanan hangat dengan rasa otentik, higienis, dan penuh dedikasi.
                </p>
            </div>

            <!-- Col 2: Navigasi Cepat -->
            <div class="space-y-4">
                <h4 class="font-label-md uppercase tracking-wider text-tertiary-fixed font-semibold text-xs">Navigasi</h4>
                <ul class="space-y-2.5 font-body-sm">
                    <li><a href="{{ url('/') }}" class="text-surface-variant hover:text-on-primary transition-colors">Home (Beranda)</a></li>
                    <li><a href="{{ url('/about') }}" class="text-surface-variant hover:text-on-primary transition-colors">About (Tentang Kami)</a></li>
                    <li><a href="{{ url('/menu') }}" class="text-surface-variant hover:text-on-primary transition-colors">Menu (Katalog Lengkap)</a></li>
                    <li><a href="{{ url('/pesan') }}" class="text-surface-variant hover:text-on-primary transition-colors">Pesan (Delivery &amp; Datang Langsung)</a></li>
                    <li><a href="{{ url('/contact') }}" class="text-surface-variant hover:text-on-primary transition-colors">Contact (Kontak &amp; Lokasi)</a></li>
                </ul>
            </div>

            <!-- Col 3: Kontak & Operasional -->
            <div class="space-y-4">
                <h4 class="font-label-md uppercase tracking-wider text-tertiary-fixed font-semibold text-xs">Kontak &amp; Operasional</h4>
                <ul class="space-y-3 font-body-sm text-surface-variant">
                    <li class="flex items-start gap-2.5">
                        <span class="material-symbols-outlined text-[20px] text-tertiary-fixed shrink-0">location_on</span>
                        <a href="https://maps.app.goo.gl/KnCpj3ViPCHGNmH66" target="_blank" rel="noopener noreferrer" class="hover:text-tertiary-fixed transition-colors inline-flex items-center gap-1 group">
                            <span>Bandung, Kp. Ciloa, RT.04/RW.10, Kec. Soreang</span>
                            <span class="material-symbols-outlined text-[14px] opacity-70 group-hover:opacity-100">open_in_new</span>
                        </a>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="material-symbols-outlined text-[20px] text-tertiary-fixed shrink-0">schedule</span>
                        <span>Buka Setiap Hari: 08.00 - 22.00 WIB</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="material-symbols-outlined text-[20px] text-tertiary-fixed shrink-0">call</span>
                        <a href="https://wa.me/6282221222936" target="_blank" rel="noopener" class="hover:text-tertiary-fixed transition-colors">
                            +62 822-2122-2936 (WhatsApp Admin)
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Row: Platform Delivery & Copyright (§5.6, M22) -->
        <div class="pt-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-2.5 flex-wrap">
                <span class="font-label-sm text-surface-variant mr-1">Tersedia juga di:</span>
                <a href="{{ url('/pesan') }}#online" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-surface-container-highest/20 text-surface-variant hover:bg-[#EE4D2D] hover:text-white font-label-sm transition-all duration-200 group">
                    <img src="{{ asset('images/platforms/shopeefood.svg') }}" alt="ShopeeFood" class="w-4 h-4 rounded-xs shrink-0 object-contain shadow-xs">
                    <span>ShopeeFood</span>
                </a>
                <a href="{{ url('/pesan') }}#online" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-surface-container-highest/20 text-surface-variant hover:bg-[#EE2737] hover:text-white font-label-sm transition-all duration-200 group">
                    <img src="{{ asset('images/platforms/gofood.svg') }}" alt="GoFood" class="w-4 h-4 rounded-xs shrink-0 object-contain shadow-xs">
                    <span>GoFood</span>
                </a>
                <a href="{{ url('/pesan') }}#online" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-surface-container-highest/20 text-surface-variant hover:bg-[#00B14F] hover:text-white font-label-sm transition-all duration-200 group">
                    <img src="{{ asset('images/platforms/grabfood.svg') }}" alt="GrabFood" class="w-4 h-4 rounded-xs shrink-0 object-contain shadow-xs">
                    <span>GrabFood</span>
                </a>
            </div>
            <div class="font-body-sm text-surface-variant text-center md:text-right">
                &copy; {{ date('Y') }} Yan's Food. Semua hak cipta dilindungi.
            </div>
        </div>
    </div>
</footer>
