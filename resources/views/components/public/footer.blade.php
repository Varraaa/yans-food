<!-- Modular Footer (§5.6) -->
<footer class="w-full bg-inverse-surface text-inverse-on-surface pt-16 pb-24 lg:pb-12 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 lg:px-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-12 pb-14 border-b border-surface-variant/20">
            
            <!-- Col 1: Brand & Motto -->
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-[#D6A253] via-[#C1440E] to-[#8F3209] p-[2px] shadow-sm shrink-0">
                        <div class="w-full h-full rounded-[14px] bg-[#362F25] flex items-center justify-center">
                            <svg class="w-6 h-6 text-[#D6A253]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M12 2C11.5 3 13 4 12 5" stroke="#D6A253" stroke-width="2" stroke-linecap="round"/>
                                <path d="M8 3.5C7.5 4.5 9 5.5 8 6.5" stroke="#FFDDB1" stroke-width="1.8" stroke-linecap="round"/>
                                <path d="M16 3.5C15.5 4.5 17 5.5 16 6.5" stroke="#FFDDB1" stroke-width="1.8" stroke-linecap="round"/>
                                <path d="M4 11C4 16 7.5 18 12 18C16.5 18 20 16 20 11H4Z" fill="#D6A253"/>
                                <line x1="2.5" y1="11" x2="21.5" y2="11" stroke="#FCEFDF" stroke-width="2" stroke-linecap="round"/>
                            </svg>
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
                    <a href="https://instagram.com" target="_blank" rel="noopener" aria-label="Instagram Yan's Food" class="flex items-center gap-2 hover:text-tertiary-fixed transition-colors">
                        <span class="material-symbols-outlined text-[18px] text-tertiary-fixed">photo_camera</span>
                        <span>Instagram @yansfood.official</span>
                    </a>
                    <a href="https://tiktok.com" target="_blank" rel="noopener" aria-label="TikTok Yan's Food" class="flex items-center gap-2 hover:text-tertiary-fixed transition-colors">
                        <span class="material-symbols-outlined text-[18px] text-tertiary-fixed">videocam</span>
                        <span>TikTok @yansfood</span>
                    </a>
                    <a href="mailto:halo@yansfood.id" aria-label="Email Yan's Food" class="flex items-center gap-2 hover:text-tertiary-fixed transition-colors">
                        <span class="material-symbols-outlined text-[18px] text-tertiary-fixed">mail</span>
                        <span>halo@yansfood.id</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Row: Platform Delivery & Copyright (§5.6, M22) -->
        <div class="pt-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-2.5 flex-wrap">
                <span class="font-label-sm text-surface-variant mr-1">Tersedia juga di:</span>
                <a href="{{ url('/pesan') }}#online" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-surface-container-highest/20 text-surface-variant hover:bg-[#EE4D2D] hover:text-white font-label-sm transition-all duration-200 group">
                    <svg class="w-4 h-4 fill-current text-[#EE4D2D] group-hover:text-white transition-colors shrink-0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 6h-3.18C15.4 3.84 13.78 2 12 2s-3.4 1.84-3.82 4H5c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-7-2c1.08 0 2.09 1.13 2.5 2h-5c.41-.87 1.42-2 2.5-2zm7 16H5V8h14v12zm-7-9c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 6c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
                    </svg>
                    <span>ShopeeFood</span>
                </a>
                <a href="{{ url('/pesan') }}#online" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-surface-container-highest/20 text-surface-variant hover:bg-[#ED2724] hover:text-white font-label-sm transition-all duration-200 group">
                    <svg class="w-4 h-4 fill-current text-[#ED2724] group-hover:text-white transition-colors shrink-0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 15c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm3-5c0 1.66-1.34 3-3 3s-3-1.34-3-3 1.34-3 3-3 3 1.34 3 3z"/>
                    </svg>
                    <span>GoFood</span>
                </a>
                <a href="{{ url('/pesan') }}#online" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-surface-container-highest/20 text-surface-variant hover:bg-[#00B14F] hover:text-white font-label-sm transition-all duration-200 group">
                    <svg class="w-4 h-4 fill-current text-[#00B14F] group-hover:text-white transition-colors shrink-0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z"/>
                    </svg>
                    <span>GrabFood</span>
                </a>
            </div>
            <div class="font-body-sm text-surface-variant text-center md:text-right">
                &copy; {{ date('Y') }} Yan's Food. Semua hak cipta dilindungi.
            </div>
        </div>
    </div>
</footer>
