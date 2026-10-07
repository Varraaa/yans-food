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

<header class="fixed top-0 inset-x-0 z-50 bg-cream-bg/95 backdrop-blur-md shadow-[0_1px_8px_rgba(38,32,27,0.04)] transition-all duration-300">
    <div class="h-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 flex items-center justify-between gap-4">
        
        <!-- Brand Logo -->
        <a href="{{ url('/') }}" class="flex items-center gap-2.5 sm:gap-3 group">
            <svg class="h-9 sm:h-10 w-auto" viewBox="0 0 280 80" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="terracottaGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#C1440E"/>
                        <stop offset="100%" stop-color="#D6A253"/>
                    </linearGradient>
                </defs>
                <g transform="translate(10, 10)">
                    <rect x="0" y="0" width="60" height="60" rx="16" fill="#F1E6D6" stroke="#C1440E" stroke-width="1.5"/>
                    <path d="M30 18 C28 24 35 27 30 33" stroke="#D6A253" stroke-width="2.5" stroke-linecap="round" fill="none"/>
                    <path d="M24 22 C22 26 27 28 24 33" stroke="#C1440E" stroke-width="2" stroke-linecap="round" fill="none"/>
                    <path d="M18 36 C18 45 42 45 42 36 Z" fill="#C1440E"/>
                    <line x1="15" y1="36" x2="45" y2="36" stroke="#26201B" stroke-width="2" stroke-linecap="round"/>
                    <circle cx="30" cy="48" r="2.5" fill="#D6A253"/>
                </g>
                <text x="82" y="42" font-family="'Outfit', sans-serif" font-weight="700" font-size="28" fill="#26201B" letter-spacing="-0.5">Yan's Food</text>
                <text x="83" y="58" font-family="'Plus Jakarta Sans', sans-serif" font-weight="600" font-size="10" fill="#C1440E" letter-spacing="2">DAPUR KULINER RUMAHAN</text>
            </svg>
        </a>

        <!-- Desktop Navigation Links -->
        <nav class="hidden md:flex items-center gap-1.5 lg:gap-3">
            @foreach($navLinks as $link)
                @php
                    $isActive = ($link['path'] === '/' && ($currentRoute === '/' || $currentRoute === '')) || 
                                ($link['path'] !== '/' && request()->is($link['path'].'*'));
                @endphp
                <a href="{{ $link['url'] }}" 
                   class="{{ $isActive 
                            ? 'bg-primary-container text-on-primary font-bold rounded-lg px-3.5 py-1.5 shadow-sm' 
                            : 'font-label-md px-3.5 py-1.5 rounded-lg text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high transition-colors' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

        <!-- Header Actions -->
        <div class="flex items-center gap-2 sm:gap-3">
            <!-- Cart / Kasir Trigger Button -->
            <button type="button" 
                    onclick="toggleCartDrawer(true)"
                    aria-label="Buka Keranjang & Kasir"
                    class="relative w-10 h-10 sm:w-11 sm:h-11 flex items-center justify-center rounded-xl bg-surface-container text-on-surface hover:text-primary hover:bg-surface-container-high transition-colors">
                <span class="material-symbols-outlined text-[22px] sm:text-[24px]">shopping_bag</span>
                <span class="cart-badge-count hidden absolute -top-1 -right-1 min-w-[20px] h-5 px-1.5 rounded-full bg-primary-container text-on-primary text-[11px] font-bold flex items-center justify-center shadow-xs">
                    0
                </span>
            </button>

            <a href="{{ url('/pesan') }}" class="hidden sm:inline-flex items-center justify-center font-label-md px-4 sm:px-5 py-2 sm:py-2.5 rounded-lg bg-primary-container text-on-primary hover:bg-primary-dark transition-all duration-200 shadow-sm">
                Pesan Sekarang
            </a>

            <!-- Mobile Hamburger Button -->
            <button type="button" 
                    aria-label="Buka Menu Navigasi"
                    onclick="document.getElementById('mobile-drawer').classList.remove('translate-x-full'); document.body.classList.add('overflow-hidden');"
                    class="md:hidden w-10 h-10 sm:w-11 sm:h-11 flex items-center justify-center rounded-xl text-on-surface hover:bg-surface-container transition-colors">
                <span class="material-symbols-outlined text-[26px]">menu</span>
            </button>
        </div>
    </div>
</header>

<!-- Mobile Fullscreen Drawer Navigation -->
<div id="mobile-drawer" class="fixed inset-0 z-50 transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col bg-surface-warm md:hidden">
    <!-- Drawer Header -->
    <div class="h-20 px-6 flex items-center justify-between bg-cream-bg/95 border-b border-surface-variant/40">
        <div class="flex items-center gap-2.5">
            <span class="font-headline-sm text-primary font-bold tracking-tight">Yan's Food</span>
        </div>
        <button type="button" 
                aria-label="Tutup Menu"
                onclick="document.getElementById('mobile-drawer').classList.add('translate-x-full'); document.body.classList.remove('overflow-hidden');"
                class="w-11 h-11 flex items-center justify-center rounded-lg text-on-surface-variant hover:bg-surface-container transition-colors">
            <span class="material-symbols-outlined text-[28px]">close</span>
        </button>
    </div>

    <!-- Drawer Navigation Links -->
    <div class="flex-1 overflow-y-auto px-6 py-6 flex flex-col justify-between">
        <nav class="flex flex-col gap-2">
            @foreach($navLinks as $link)
                @php
                    $isActive = ($link['path'] === '/' && ($currentRoute === '/' || $currentRoute === '')) || 
                                ($link['path'] !== '/' && request()->is($link['path'].'*'));
                @endphp
                <a href="{{ $link['url'] }}" 
                   onclick="document.getElementById('mobile-drawer').classList.add('translate-x-full'); document.body.classList.remove('overflow-hidden');"
                   class="h-12 flex items-center text-lg {{ $isActive ? 'text-primary-container font-bold font-serif' : 'text-on-surface font-medium hover:text-primary' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach

            <div class="pt-4">
                <a href="{{ url('/pesan') }}" 
                   class="w-full min-h-[48px] px-4 py-3 rounded-xl bg-primary-container text-on-primary font-label-md flex items-center justify-center gap-2 shadow-md">
                    <span class="material-symbols-outlined text-[20px]">shopping_bag</span>
                    <span>Pesan Sekarang</span>
                </a>
            </div>
        </nav>

        <!-- Drawer Footer Info -->
        <div class="pt-8 border-t border-surface-variant/40 space-y-4">
            <div class="space-y-1">
                <p class="font-label-sm text-on-surface-variant uppercase tracking-wider">Hubungi Dapur Kami</p>
                <p class="font-body-sm text-on-surface">Jl. Melati No. 14, Jakarta Selatan</p>
                <p class="font-body-sm text-on-surface">WhatsApp: +62 812-3456-7890</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="https://instagram.com" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant hover:text-primary">
                    <span class="material-symbols-outlined text-[20px]">photo_camera</span>
                </a>
                <a href="https://wa.me/6281234567890" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant hover:text-primary">
                    <span class="material-symbols-outlined text-[20px]">chat</span>
                </a>
                <a href="mailto:halo@yansfood.id" class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant hover:text-primary">
                    <span class="material-symbols-outlined text-[20px]">mail</span>
                </a>
            </div>
        </div>
    </div>
</div>
