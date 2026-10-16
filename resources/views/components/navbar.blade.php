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

<header id="main-navbar" class="fixed top-0 inset-x-0 z-50 bg-cream-bg/95 backdrop-blur-md shadow-[0_1px_8px_rgba(38,32,27,0.04)] transition-all duration-300">
    <div class="navbar-container h-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 flex items-center justify-between gap-3 sm:gap-4 transition-all duration-300">
        
        <!-- Brand Logo -->
        <a href="{{ url('/') }}" class="brand-logo flex items-center gap-2.5 sm:gap-3 group shrink-0 transition-transform duration-300">
            <!-- Artisanal Skillet & Steam Monogram Emblem -->
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
            <!-- Brand Wordmark & Tagline -->
            <div class="flex flex-col justify-center leading-none">
                <span class="font-headline-sm text-lg sm:text-xl font-black text-on-surface tracking-tight font-serif group-hover:text-primary transition-colors">Yan's Food</span>
                <span class="text-[9px] sm:text-[10px] font-extrabold uppercase tracking-[0.16em] text-primary pt-1">Dapur Kuliner Rumahan</span>
            </div>
        </a>

        <!-- Desktop Navigation Links with Modern Underline Animation -->
        <nav class="hidden md:flex items-center gap-1 lg:gap-3">
            @foreach($navLinks as $link)
                @php
                    $isActive = ($link['path'] === '/' && ($currentRoute === '/' || $currentRoute === '')) || 
                                ($link['path'] !== '/' && request()->is($link['path'].'*'));
                @endphp
                <a href="{{ $link['url'] }}" 
                   class="relative group py-2.5 px-3 lg:px-4 flex flex-col items-center justify-center font-label-md transition-colors duration-200 {{ $isActive ? 'text-primary font-bold' : 'text-on-surface/80 hover:text-primary font-medium' }}">
                    <span class="tracking-wide text-[15px] select-none">{{ $link['label'] }}</span>
                    
                    <!-- Modern Animated Underline (Clean, Tanpa Titik) -->
                    <span class="absolute bottom-1 inset-x-2.5 h-[2.5px] rounded-full bg-gradient-to-r from-primary to-primary-container transition-all duration-300 ease-out {{ $isActive ? 'scale-x-100 opacity-100' : 'scale-x-0 opacity-0 group-hover:scale-x-100 group-hover:opacity-100 origin-center' }}"></span>
                </a>
            @endforeach
        </nav>

        <!-- Header Actions -->
        <div class="flex items-center gap-2 sm:gap-3 shrink-0">
            <!-- Order CTA Button (Direct ke /pesan, M01 panah geser +4px) -->
            <a href="{{ url('/pesan') }}" 
               class="inline-flex items-center justify-center gap-1.5 font-label-md px-3.5 sm:px-5 py-2 sm:py-2.5 rounded-xl bg-primary-container text-on-primary hover:bg-primary-dark transition-all duration-200 shadow-sm hover:shadow-md active:scale-95 text-xs sm:text-sm group">
                <span class="material-symbols-outlined text-[18px] sm:text-[20px]">local_mall</span>
                <span>Pesan Sekarang</span>
                <span class="inline-block transition-transform duration-200 group-hover:translate-x-1 font-bold">→</span>
            </a>

            <!-- Mobile & Tablet Hamburger Button (§3.4: 48x48 touch target) -->
            <button id="mobile-menu-toggle"
                    type="button" 
                    aria-label="Buka Menu Navigasi"
                    aria-expanded="false"
                    class="md:hidden w-12 h-12 flex items-center justify-center rounded-xl text-on-surface hover:bg-surface-container transition-colors focus:outline-none focus:ring-2 focus:ring-primary/20">
                <span class="material-symbols-outlined text-[28px]">menu</span>
            </button>
        </div>
    </div>
</header>

<!-- Mobile & Tablet Responsive Drawer Navigation with Dimmed Backdrop -->
<div id="mobile-nav-backdrop" 
     class="fixed inset-0 z-[70] bg-charcoal/50 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-300 ease-in-out md:hidden"
     onclick="closeMobileNav()">
</div>

<aside id="mobile-drawer" 
       aria-label="Navigasi Menu Mobile"
       class="fixed top-0 right-0 bottom-0 z-[70] w-full max-w-xs sm:max-w-sm bg-surface-warm shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col md:hidden border-l border-surface-variant/40">
    
    <!-- Drawer Header -->
    <div class="h-20 px-6 flex items-center justify-between bg-cream-bg/95 border-b border-surface-variant/40 shrink-0">
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
        <button type="button" 
                aria-label="Tutup Menu"
                onclick="closeMobileNav()"
                class="w-10 h-10 flex items-center justify-center rounded-xl text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors">
            <span class="material-symbols-outlined text-[24px]">close</span>
        </button>
    </div>

    <!-- Drawer Navigation Links -->
    <div class="flex-1 overflow-y-auto px-5 py-6 flex flex-col justify-between">
        <nav class="flex flex-col gap-1.5">
            <span class="text-[11px] font-bold uppercase tracking-wider text-on-surface-variant/70 px-3 mb-1">Navigasi Halaman</span>
            @foreach($navLinks as $link)
                @php
                    $isActive = ($link['path'] === '/' && ($currentRoute === '/' || $currentRoute === '')) || 
                                ($link['path'] !== '/' && request()->is($link['path'].'*'));
                @endphp
                <a href="{{ $link['url'] }}" 
                   onclick="closeMobileNav()"
                   class="relative group flex items-center justify-between px-3.5 py-3 rounded-xl transition-all duration-200 overflow-hidden {{ $isActive ? 'bg-primary-fixed/40 text-primary font-bold shadow-xs' : 'text-on-surface hover:text-primary hover:bg-surface-container/60 font-medium' }}">
                    <!-- Modern Active Accent Bar on Left -->
                    @if($isActive)
                        <span class="absolute left-0 inset-y-1.5 w-1 bg-gradient-to-b from-primary to-tertiary rounded-r-full"></span>
                    @endif
                    
                    <span class="pl-2 text-[15px]">{{ $link['label'] }}</span>
                    <span class="material-symbols-outlined text-[18px] transition-transform duration-200 group-hover:translate-x-1 {{ $isActive ? 'text-primary' : 'text-on-surface-variant/40' }}">chevron_right</span>
                </a>
            @endforeach

            <!-- Order Button in Mobile Drawer -->
            <div class="pt-5 mt-2 border-t border-surface-variant/30">
                <a href="{{ url('/pesan') }}" 
                   onclick="closeMobileNav()"
                   class="w-full min-h-[46px] px-4 py-3 rounded-xl bg-primary-container text-on-primary font-label-md flex items-center justify-center gap-2 shadow-md hover:bg-primary-dark transition-colors">
                    <span class="material-symbols-outlined text-[20px]">shopping_bag</span>
                    <span>Pesan Sekarang</span>
                </a>
            </div>
        </nav>

        <!-- Drawer Footer Info -->
        <div class="pt-6 border-t border-surface-variant/40 space-y-4">
            <div class="space-y-1">
                <p class="font-label-sm text-[11px] text-on-surface-variant uppercase tracking-wider font-semibold">Hubungi Dapur Kami</p>
                <p class="font-body-sm text-xs text-on-surface">Jl. Melati No. 14, Jakarta Selatan</p>
                <p class="font-body-sm text-xs text-on-surface font-semibold text-primary">WA: +62 812-3456-7890</p>
            </div>
            <div class="flex items-center gap-2 pt-1">
                <a href="https://instagram.com" target="_blank" rel="noopener" aria-label="Instagram" class="w-9 h-9 rounded-xl bg-surface-container flex items-center justify-center text-on-surface-variant hover:text-primary hover:bg-surface-container-high transition-colors">
                    <span class="material-symbols-outlined text-[18px]">photo_camera</span>
                </a>
                <a href="https://wa.me/6281234567890" target="_blank" rel="noopener" aria-label="WhatsApp" class="w-9 h-9 rounded-xl bg-surface-container flex items-center justify-center text-on-surface-variant hover:text-primary hover:bg-surface-container-high transition-colors">
                    <span class="material-symbols-outlined text-[18px]">chat</span>
                </a>
                <a href="mailto:halo@yansfood.id" aria-label="Email" class="w-9 h-9 rounded-xl bg-surface-container flex items-center justify-center text-on-surface-variant hover:text-primary hover:bg-surface-container-high transition-colors">
                    <span class="material-symbols-outlined text-[18px]">mail</span>
                </a>
            </div>
        </div>
    </div>
</aside>

<script>
    function openMobileNav() {
        const backdrop = document.getElementById('mobile-nav-backdrop');
        const drawer = document.getElementById('mobile-drawer');
        if (!backdrop || !drawer) return;
        backdrop.classList.remove('opacity-0', 'pointer-events-none');
        drawer.classList.remove('translate-x-full');
        document.body.classList.add('overflow-hidden');
    }

    function closeMobileNav() {
        const backdrop = document.getElementById('mobile-nav-backdrop');
        const drawer = document.getElementById('mobile-drawer');
        if (!backdrop || !drawer) return;
        backdrop.classList.add('opacity-0', 'pointer-events-none');
        drawer.classList.add('translate-x-full');
        document.body.classList.remove('overflow-hidden');
    }
</script>
