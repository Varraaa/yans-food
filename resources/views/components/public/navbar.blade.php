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
            'label' => 'Pesan Online',
            'subtitle' => 'Delivery via mitra & datang langsung',
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
<header id="main-navbar" class="bg-[#FBF6EE]">
    <div class="navbar-container max-w-7xl mx-auto px-4 sm:px-6 md:px-8 lg:px-12 flex items-center justify-between gap-3 sm:gap-4 md:gap-6">
        
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

        <!-- Desktop Navigation with Sliding Underline Indicator (lg and above: laptop/desktop) -->
        <nav class="hidden lg:flex items-center gap-1.5 lg:gap-2 desktop-nav-wrap" aria-label="Navigasi Utama">
            <span class="nav-slider-indicator" aria-hidden="true"></span>
            @foreach($navLinks as $link)
                @php
                    $isActive = ($link['path'] === '/' && ($currentRoute === '/' || $currentRoute === '')) || 
                                ($link['path'] !== '/' && request()->is($link['path'].'*'));
                @endphp
                <a href="{{ $link['url'] }}" 
                   class="desktop-nav-link relative py-2.5 px-3 lg:px-4 flex items-center justify-center font-label-md text-xs lg:text-sm transition-colors duration-200 {{ $isActive ? 'is-active text-primary font-bold' : 'text-on-surface/80 hover:text-primary font-medium' }}">
                    <span class="select-none">{{ $link['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <!-- Header Actions: CTA & Hamburger -->
        <div class="flex items-center gap-2 sm:gap-3 shrink-0">
            <!-- CTA Button "Pesan Sekarang" (Visible on Desktop lg) -->
            <a href="{{ url('/pesan') }}" class="hidden lg:inline-flex btn-primary text-sm py-2 px-4.5">
                <span class="material-symbols-outlined text-[18px]">local_mall</span>
                <span>Pesan Sekarang</span>
                <span class="btn-arrow font-bold" aria-hidden="true">→</span>
            </a>

            <!-- Morphing Hamburger Button (Visible on Mobile & Tablet screens < lg) -->
            <button id="mobile-menu-toggle"
                    type="button" 
                    aria-label="Buka Menu Navigasi"
                    aria-expanded="false"
                    class="hamburger-btn lg:hidden hover:bg-surface-container">
                <span class="hamburger-line" aria-hidden="true"></span>
                <span class="hamburger-line" aria-hidden="true"></span>
                <span class="hamburger-line" aria-hidden="true"></span>
            </button>
        </div>
    </div>
</header>

<!-- Fullscreen Overlay Navigation (Visible on Mobile & Tablet screens < lg) -->
<div id="mobile-nav-overlay" 
     class="mobile-nav-overlay lg:hidden overflow-hidden bg-[#FDFCFB]" 
     role="dialog" 
     aria-modal="true" 
     aria-label="Menu Navigasi Mobile & Tablet">

    <div class="h-full w-full flex flex-col justify-between overflow-y-auto overscroll-contain">
        
        <!-- Top Section: Header & Menu Links -->
        <div class="w-full max-w-lg md:max-w-xl mx-auto flex flex-col">
            <!-- Overlay Header: Brand Logo & Close Button (Reference Style) -->
            <div class="w-full px-6 py-5 flex items-center justify-between border-b border-[#EDE6DC]/80 shrink-0">
                <a href="{{ url('/') }}" class="font-serif text-2xl font-bold tracking-tight text-[#7E3717] hover:opacity-90 transition-opacity">
                    Yan's Food
                </a>
                
                <button id="mobile-menu-close" 
                        type="button" 
                        aria-label="Tutup Menu Navigasi"
                        class="p-1 -mr-1.5 text-stone-800 hover:text-[#7E3717] transition-colors focus:outline-none cursor-pointer">
                    <span class="material-symbols-outlined text-[30px] font-light leading-none">close</span>
                </button>
            </div>

            <!-- Modern Clean Minimalist Navigation Links (Full Width Rows as in Reference) -->
            <nav class="w-full flex flex-col" aria-label="Daftar Halaman Mobile & Tablet">
                @foreach($navLinks as $item)
                    @php
                        $isActive = ($item['path'] === '/' && ($currentRoute === '/' || $currentRoute === '')) || 
                                    ($item['path'] !== '/' && request()->is($item['path'].'*'));
                    @endphp
                    <a href="{{ $item['url'] }}" 
                       class="w-full px-6 py-4.5 border-b border-[#EDE6DC]/80 text-[16px] sm:text-[17px] md:text-[18px] transition-colors duration-150 flex items-center justify-between {{ $isActive ? 'bg-[#F5ECE1]/70 text-[#7E3717] font-bold' : 'text-[#383028] font-semibold hover:bg-stone-50/70 hover:text-[#7E3717]' }}">
                        <span>{{ $item['label'] }}</span>
                        @if($isActive)
                            <span class="w-2.5 h-2.5 rounded-full bg-[#7E3717]"></span>
                        @endif
                    </a>
                @endforeach
            </nav>
        </div>

        <!-- Bottom Section: ORDER NOW CTA Button (Full Width Rounded Button as in Reference) -->
        <div class="w-full max-w-lg md:max-w-xl mx-auto px-6 pb-6 pt-4 shrink-0">
            <a href="{{ url('/pesan') }}" 
               class="w-full py-4 px-6 rounded-xl bg-[#7E3717] hover:bg-[#682C10] active:scale-[0.99] text-white font-bold text-center block text-sm sm:text-base md:text-lg tracking-widest uppercase transition-all shadow-xs">
                ORDER NOW
            </a>
        </div>
    </div>
</div>
