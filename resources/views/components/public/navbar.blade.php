@php
    $currentRoute = request()->path();
    $navLinks = [
        ['label' => 'Home', 'url' => url('/'), 'path' => '/'],
        ['label' => 'About', 'url' => url('/about'), 'path' => 'about'],
        ['label' => 'Menu', 'url' => url('/menu'), 'path' => 'menu'],
        ['label' => 'Pesan', 'url' => url('/pesan'), 'path' => 'pesan'],
        ['label' => 'Contact', 'url' => url('/contact'), 'path' => 'contact'],
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

        <!-- Desktop Navigation with Sliding Underline Indicator (§3.4) -->
        <nav class="hidden lg:flex items-center gap-1 desktop-nav-wrap" aria-label="Navigasi Utama">
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
            <!-- CTA Button "Pesan Sekarang" (§3.4, M01) -->
            <a href="{{ url('/pesan') }}" class="btn-primary text-xs sm:text-sm py-2 px-3.5 sm:px-4.5">
                <span class="material-symbols-outlined text-[18px]">local_mall</span>
                <span>Pesan Sekarang</span>
                <span class="btn-arrow font-bold" aria-hidden="true">→</span>
            </a>

            <!-- Mobile Morphing Hamburger Button (§3.4: 48x48px touch target) -->
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

<!-- Mobile Fullscreen Overlay Navigation (§3.4) -->
<div id="mobile-nav-overlay" 
     class="mobile-nav-overlay lg:hidden" 
     role="dialog" 
     aria-modal="true" 
     aria-label="Menu Navigasi Mobile">

    <!-- Overlay Header -->
    <div class="flex items-center justify-between pb-6 border-b border-surface-variant/40 shrink-0">
        <div class="flex items-center gap-2.5">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-[#D6A253] via-[#C1440E] to-[#8F3209] p-[2px] shadow-xs shrink-0">
                <div class="w-full h-full rounded-[10px] bg-[#FBF6EE] flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#C1440E]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C11.5 3 13 4 12 5" stroke="#D6A253" stroke-width="2" stroke-linecap="round"/>
                        <path d="M4 11C4 16 7.5 18 12 18C16.5 18 20 16 20 11H4Z" fill="#C1440E"/>
                        <line x1="2.5" y1="11" x2="21.5" y2="11" stroke="#26201B" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
            <div class="flex flex-col leading-none">
                <span class="font-headline-sm text-base font-bold text-on-surface font-serif">Yan's Food</span>
                <span class="text-[9px] uppercase tracking-wider text-primary font-bold pt-0.5">Dapur Kuliner Rumahan</span>
            </div>
        </div>
        <button id="mobile-menu-close" 
                type="button" 
                aria-label="Tutup Menu Navigasi"
                class="w-12 h-12 flex items-center justify-center rounded-xl text-on-surface hover:bg-surface-container transition-colors">
            <span class="material-symbols-outlined text-[26px]">close</span>
        </button>
    </div>

    <!-- Overlay Navigation Links (Large Fraunces/Outfit 26-28px, Stagger 50ms) -->
    <nav class="flex-1 overflow-y-auto py-8 flex flex-col justify-center gap-2" aria-label="Daftar Tautan Mobile">
        @foreach($navLinks as $index => $link)
            @php
                $isActive = ($link['path'] === '/' && ($currentRoute === '/' || $currentRoute === '')) || 
                            ($link['path'] !== '/' && request()->is($link['path'].'*'));
            @endphp
            <a href="{{ $link['url'] }}" 
               class="mobile-nav-link {{ $isActive ? 'is-active text-primary' : 'hover:text-primary' }}">
                <span class="active-bullet {{ $isActive ? '' : 'hidden' }}" aria-hidden="true"></span>
                <span>{{ $link['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <!-- Overlay Footer Actions & Contact -->
    <div class="pt-6 border-t border-surface-variant/40 space-y-4 shrink-0">
        <a href="{{ url('/pesan') }}" class="btn-primary w-full py-3.5 text-center justify-center">
            <span class="material-symbols-outlined text-[20px]">local_mall</span>
            <span>Pesan Sekarang</span>
            <span class="btn-arrow font-bold" aria-hidden="true">→</span>
        </a>

        <div class="flex items-center justify-between text-xs text-secondary pt-2">
            <span>WA: +62 812-3456-7890</span>
            <div class="flex items-center gap-3">
                <a href="https://instagram.com" target="_blank" rel="noopener" aria-label="Instagram Yan's Food" class="text-on-surface hover:text-primary">
                    <span class="material-symbols-outlined text-[20px]">photo_camera</span>
                </a>
                <a href="https://wa.me/6281234567890" target="_blank" rel="noopener" aria-label="WhatsApp Yan's Food" class="text-on-surface hover:text-primary">
                    <span class="material-symbols-outlined text-[20px]">chat</span>
                </a>
            </div>
        </div>
    </div>
</div>
