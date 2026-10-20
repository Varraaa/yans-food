@php
    $currentRoute = request()->path();
    $navLinks = [
        ['label' => 'Home', 'url' => url('/'), 'path' => '/'],
        ['label' => 'About', 'url' => url('/about'), 'path' => 'about'],
        ['label' => 'Menu', 'url' => url('/menu'), 'path' => 'menu'],
        ['label' => 'Pesan', 'url' => url('/pesan'), 'path' => 'pesan'],
        ['label' => 'Contact', 'url' => url('/contact'), 'path' => 'contact'],
    ];

    $mobileNavItems = [
        [
            'label' => 'Beranda',
            'subtitle' => 'Halaman utama & sajian dapur',
            'url' => url('/'),
            'path' => '/',
            'icon' => 'cottage',
            'badge' => null,
        ],
        [
            'label' => 'Tentang Kami',
            'subtitle' => 'Cerita rasa rumahan & dedikasi',
            'url' => url('/about'),
            'path' => 'about',
            'icon' => 'auto_stories',
            'badge' => null,
        ],
        [
            'label' => 'Daftar Menu',
            'subtitle' => 'Kudapan gurih, lauk & minuman',
            'url' => url('/menu'),
            'path' => 'menu',
            'icon' => 'restaurant_menu',
            'badge' => null,
        ],
        [
            'label' => 'Form Pesanan',
            'subtitle' => 'Katering acara, tumpeng & nasi box',
            'url' => url('/pesan'),
            'path' => 'pesan',
            'icon' => 'receipt_long',
            'badge' => null,
        ],
        [
            'label' => 'Kontak & Lokasi',
            'subtitle' => 'Alamat dapur & info pemesanan',
            'url' => url('/contact'),
            'path' => 'contact',
            'icon' => 'support_agent',
            'badge' => null,
        ],
    ];
@endphp

<!-- Header / Fixed Navbar (§3.4) -->
<header id="main-navbar" class="bg-cream-bg/90">
    <div class="navbar-container max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 flex items-center justify-between gap-3 sm:gap-4">
        
        <!-- Brand Logo & Monogram -->
        <a href="{{ url('/') }}" class="brand-logo flex items-center gap-2.5 sm:gap-3 group shrink-0" aria-label="Yan's Food — Beranda">
            <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-gradient-to-br from-[#D6A253] via-[#C1440E] to-[#8F3209] p-[2px] shadow-xs group-hover:shadow-md transition-all shrink-0">
                <div class="w-full h-full rounded-[14px] bg-[#FBF6EE] flex items-center justify-center relative overflow-hidden">
                    <svg class="w-6 h-6 text-[#C1440E] transition-transform duration-300 group-hover:scale-105" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C11.5 3 13 4 12 5" stroke="#D6A253" stroke-width="2" stroke-linecap="round"/>
                        <path d="M8 3.5C7.5 4.5 9 5.5 8 6.5" stroke="#C1440E" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M16 3.5C15.5 4.5 17 5.5 16 6.5" stroke="#C1440E" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M4 11C4 16 7.5 18 12 18C16.5 18 20 16 20 11H4Z" fill="#C1440E"/>
                        <line x1="2.5" y1="11" x2="21.5" y2="11" stroke="#26201B" stroke-width="2" stroke-linecap="round"/>
                        <circle cx="12" cy="19.5" r="1.5" fill="#D6A253"/>
                    </svg>
                </div>
            </div>
            <div class="flex flex-col justify-center leading-none">
                <span class="font-headline-sm text-lg sm:text-xl font-black text-on-surface tracking-tight font-serif group-hover:text-primary transition-colors">Yan's Food</span>
                <span class="text-[9px] sm:text-[10px] font-extrabold uppercase tracking-[0.16em] text-primary pt-1">Dapur Kuliner Rumahan</span>
            </div>
        </a>

        <!-- Desktop Navigation with Sliding Underline Indicator (§3.4: Desktop xl and above) -->
        <nav class="hidden xl:flex items-center gap-1 desktop-nav-wrap" aria-label="Navigasi Utama">
            <span class="nav-slider-indicator" aria-hidden="true"></span>
            @foreach($navLinks as $link)
                @php
                    $isActive = ($link['path'] === '/' && ($currentRoute === '/' || $currentRoute === '')) || 
                                ($link['path'] !== '/' && request()->is($link['path'].'*'));
                @endphp
                <a href="{{ $link['url'] }}" 
                   class="desktop-nav-link relative py-3 px-4 flex items-center justify-center font-label-md text-sm transition-colors duration-200 {{ $isActive ? 'is-active text-primary font-bold' : 'text-on-surface/80 hover:text-primary font-medium' }}">
                    <span class="select-none">{{ $link['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <!-- Header Actions: CTA & Hamburger -->
        <div class="flex items-center gap-2 sm:gap-3 shrink-0">
            <!-- CTA Button "Pesan Sekarang" (Hidden on Mobile & Tablet, visible only on Desktop xl) -->
            <a href="{{ url('/pesan') }}" class="hidden xl:inline-flex btn-primary text-xs sm:text-sm py-2 px-3.5 sm:px-4.5">
                <span class="material-symbols-outlined text-[18px]">local_mall</span>
                <span>Pesan Sekarang</span>
                <span class="btn-arrow font-bold" aria-hidden="true">→</span>
            </a>

            <!-- Mobile & Tablet Morphing Hamburger Button (Active on Mobile and Tablet < xl) -->
            <button id="mobile-menu-toggle"
                    type="button" 
                    aria-label="Buka Menu Navigasi"
                    aria-expanded="false"
                    class="hamburger-btn xl:hidden hover:bg-surface-container">
                <span class="hamburger-line" aria-hidden="true"></span>
                <span class="hamburger-line" aria-hidden="true"></span>
                <span class="hamburger-line" aria-hidden="true"></span>
            </button>
        </div>
    </div>
</header>

<!-- Mobile & Tablet Fullscreen Overlay Navigation (§3.4) -->
<div id="mobile-nav-overlay" 
     class="mobile-nav-overlay xl:hidden overflow-hidden" 
     role="dialog" 
     aria-modal="true" 
     aria-label="Menu Navigasi Mobile dan Tablet">

    <div class="h-full w-full max-w-lg md:max-w-2xl lg:max-w-3xl mx-auto flex flex-col justify-between overflow-y-auto overscroll-contain p-4 sm:p-6 md:p-8 space-y-4 md:space-y-6">
        <!-- Overlay Header -->
        <div class="flex items-center justify-between pb-3.5 border-b border-surface-variant/40 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 md:w-11 md:h-11 rounded-xl bg-gradient-to-br from-[#D6A253] via-[#C1440E] to-[#8F3209] p-[2px] shadow-xs shrink-0">
                    <div class="w-full h-full rounded-[10px] bg-[#FBF6EE] flex items-center justify-center">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-[#C1440E]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C11.5 3 13 4 12 5" stroke="#D6A253" stroke-width="2" stroke-linecap="round"/>
                            <path d="M4 11C4 16 7.5 18 12 18C16.5 18 20 16 20 11H4Z" fill="#C1440E"/>
                            <line x1="2.5" y1="11" x2="21.5" y2="11" stroke="#26201B" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>
                <div class="flex flex-col leading-none">
                    <span class="font-headline-sm text-base md:text-lg font-bold text-on-surface font-serif">Yan's Food</span>
                    <span class="text-[9px] md:text-[10px] uppercase tracking-wider text-primary font-bold pt-1">Dapur Kuliner Rumahan</span>
                </div>
            </div>
            
            <button id="mobile-menu-close" 
                    type="button" 
                    aria-label="Tutup Menu Navigasi"
                    class="w-11 h-11 md:w-12 md:h-12 flex items-center justify-center rounded-2xl bg-surface-warm/80 border border-surface-variant/40 text-on-surface hover:bg-surface-container active:scale-95 transition-all">
                <span class="material-symbols-outlined text-[24px] md:text-[26px]">close</span>
            </button>
        </div>

        <!-- Featured Pesan Sekarang Hero Card (Placed inside Hamburger Menu for Mobile & Tablet) -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#C1440E] via-[#A6380A] to-[#782806] text-white p-4.5 md:p-6 shadow-md border border-white/10 group shrink-0">
            <div class="absolute -right-8 -bottom-8 w-36 h-36 rounded-full bg-white/10 blur-xl pointer-events-none"></div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="space-y-1.5 max-w-lg">
                    <h3 class="font-serif text-base sm:text-lg md:text-xl font-bold text-white tracking-tight leading-snug">
                        Pesan Makanan & Katering Sekarang
                    </h3>
                    <p class="text-[11px] sm:text-xs text-white/90 leading-relaxed">
                        Pilih kudapan gurih, paket nasi box, atau katering lezat siap santap khas resep rumahan terpercaya.
                    </p>
                </div>

                <a href="{{ url('/pesan') }}" 
                   class="w-full md:w-auto md:shrink-0 py-3 md:py-3.5 px-5 md:px-7 rounded-xl bg-white text-[#C1440E] hover:bg-amber-50 active:scale-[0.98] font-bold text-xs sm:text-sm shadow-sm flex items-center justify-center gap-2 transition-all">
                    <span class="material-symbols-outlined text-[19px]">local_mall</span>
                    <span>Pesan Sekarang</span>
                    <span class="material-symbols-outlined text-[17px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>
        </div>

        <!-- Modern Navigation Cards (1-Col on Mobile, 2-Cols Grid on Tablet) -->
        <nav class="flex-1 py-1" aria-label="Daftar Tautan Mobile dan Tablet">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2.5 md:gap-3.5">
                @foreach($mobileNavItems as $item)
                    @php
                        $isActive = ($item['path'] === '/' && ($currentRoute === '/' || $currentRoute === '')) || 
                                    ($item['path'] !== '/' && request()->is($item['path'].'*'));
                    @endphp
                    <a href="{{ $item['url'] }}" 
                       class="group relative flex items-center justify-between p-3.5 md:p-4 rounded-2xl transition-all duration-200 border {{ $isActive ? 'bg-primary/10 border-primary/40 ring-1 ring-primary/20 shadow-xs' : 'bg-surface-warm/90 hover:bg-white border-surface-variant/40 hover:border-primary/30 hover:shadow-xs active:scale-[0.99]' }}">
                        <div class="flex items-center gap-3 md:gap-3.5">
                            <div class="w-10 h-10 md:w-11 md:h-11 rounded-xl flex items-center justify-center transition-colors shrink-0 {{ $isActive ? 'bg-primary text-white shadow-xs' : 'bg-white text-primary border border-surface-variant/30 group-hover:bg-primary group-hover:text-white' }}">
                                <span class="material-symbols-outlined text-[20px] md:text-[22px]">{{ $item['icon'] }}</span>
                            </div>
                            <div class="flex flex-col text-left">
                                <div class="flex items-center gap-2">
                                    <span class="font-serif text-sm sm:text-base md:text-lg font-bold leading-tight {{ $isActive ? 'text-primary' : 'text-on-surface group-hover:text-primary transition-colors' }}">
                                        {{ $item['label'] }}
                                    </span>
                                    @if($item['badge'])
                                        <span class="px-2 py-0.5 rounded-full bg-primary-container text-on-primary text-[10px] font-bold shadow-2xs">
                                            {{ $item['badge'] }}
                                        </span>
                                    @endif
                                    @if($isActive)
                                        <span class="w-1.5 h-1.5 rounded-full bg-primary" aria-hidden="true"></span>
                                    @endif
                                </div>
                                <span class="text-[11px] md:text-xs text-secondary leading-tight mt-0.5">
                                    {{ $item['subtitle'] }}
                                </span>
                            </div>
                        </div>
                        
                        <span class="material-symbols-outlined text-[18px] md:text-[20px] text-secondary group-hover:text-primary group-hover:translate-x-1 transition-all">
                            chevron_right
                        </span>
                    </a>
                @endforeach
            </div>
        </nav>

        <!-- Overlay Footer Quick Contact & Social -->
        <div class="pt-3.5 border-t border-surface-variant/40 shrink-0 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Yan's%20Food,%20saya%20ingin%20tanya%20seputar%20menu%20dan%20pemesanan" 
               target="_blank" 
               rel="noopener"
               class="w-full md:w-auto py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:scale-[0.98] text-white flex items-center justify-between md:justify-center gap-3 text-xs md:text-sm font-semibold shadow-xs transition-all">
                <span class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">chat</span>
                    <span>Tanya Admin via WhatsApp</span>
                </span>
                <span class="text-[10px] bg-emerald-700/90 px-2 py-0.5 rounded-md font-bold tracking-wide">Fast Response</span>
            </a>

            <div class="flex items-center justify-between md:justify-end gap-4 text-[11px] md:text-xs text-secondary">
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">schedule</span>
                    <span>08:00 - 20:00 WIB</span>
                </span>
                <div class="flex items-center gap-3">
                    <a href="https://instagram.com" target="_blank" rel="noopener" aria-label="Instagram Yan's Food" class="text-on-surface hover:text-primary transition-colors flex items-center gap-1 font-medium">
                        <span class="material-symbols-outlined text-[17px]">photo_camera</span>
                        <span>Instagram</span>
                    </a>
                    <a href="https://wa.me/6281234567890" target="_blank" rel="noopener" aria-label="WhatsApp Yan's Food" class="text-on-surface hover:text-primary transition-colors flex items-center gap-1 font-medium">
                        <span class="material-symbols-outlined text-[17px]">chat</span>
                        <span>WhatsApp</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
