<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? "Yan's Food — Dapur Kuliner Rumahan" }}</title>
    <meta name="description" content="Yan's Food menyajikan sajian kuliner rumahan otentik, kudapan renyah, dan masakan hangat bernutrisi dari dapur higienis terpercaya.">

    <script>document.documentElement.classList.add('js');</script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <!-- Preconnect Google Fonts: Outfit (Headings Modern & Bersahaja) & Plus Jakarta Sans (Body Nyaman & Jernih) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=block" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons&display=block" />

    <!-- Tailwind & Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        html { scroll-behavior: smooth; }
        /* Style untuk navbar shrink §3.4 */
        #main-navbar.is-shrunk {
            height: 64px !important;
            background-color: rgba(251, 246, 238, 0.92) !important;
            backdrop-filter: blur(12px) !important;
            border-bottom: 1px solid rgba(38, 32, 27, 0.08) !important;
            box-shadow: 0 4px 20px -2px rgba(38, 32, 27, 0.05) !important;
        }
        #main-navbar.is-shrunk .navbar-container {
            height: 64px !important;
        }
        #main-navbar.is-shrunk .brand-logo {
            transform: scale(0.9);
        }
        /* Transisi Floating WA Pill §3.5 */
        .wa-pill-expand {
            transition: width 280ms cubic-bezier(0.22, 1, 0.36, 1), padding 280ms cubic-bezier(0.22, 1, 0.36, 1);
        }
    </style>
</head>
<body class="bg-cream-bg font-sans text-on-surface antialiased min-h-screen flex flex-col selection:bg-primary-fixed selection:text-primary-dark relative">

    <!-- Accessible Skip Link (§3.4) -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-[100] focus:px-4 focus:py-2.5 focus:bg-stone-900 focus:text-white focus:rounded-xl focus:shadow-xl focus:font-bold focus:text-xs">
        Lewati ke konten utama
    </a>

    <!-- Smooth Scroll Progress Indicator (§3.3, M26) -->
    <div id="scroll-progress-bar" 
         class="fixed top-0 left-0 h-1 bg-gradient-to-r from-primary via-tertiary to-primary-container z-[60] transition-all duration-75 pointer-events-none" 
         style="width: 0%">
    </div>

    <!-- Modular Navbar -->
    <x-navbar />

    <!-- Main View Content -->
    <main id="main-content" class="w-full pt-20 bg-cream-bg flex-1 outline-none">
        {{ $slot }}
    </main>

    <!-- Modular Footer -->
    <x-footer />

    <!-- Back to Top Button (§3.4, M25: kiri-bawah setelah > 1.5 layar) -->
    <button id="back-to-top-btn"
            type="button"
            aria-label="Kembali ke atas halaman"
            title="Kembali ke atas"
            class="fixed bottom-6 left-6 z-40 sm:bottom-8 sm:left-8 w-11 h-11 rounded-full bg-white/90 backdrop-blur-md text-stone-700 hover:text-primary border border-stone-200/80 shadow-md hover:shadow-xl hover:-translate-y-0.5 active:scale-95 transition-all duration-300 flex items-center justify-center opacity-0 translate-y-6 pointer-events-none group">
        <span class="material-symbols-outlined text-[20px] transition-transform duration-200 group-hover:-translate-y-0.5">
            arrow_upward
        </span>
    </button>

    <!-- Floating WhatsApp Action Button (§3.5: kanan-bawah, muncul setelah 600px, pil expand on hover desktop) -->
    @php
        $currentPath = request()->path();
        $waPrompt = "Halo Yan's Food, saya ingin bertanya.";
        if (str_contains($currentPath, 'menu')) {
            $waPrompt = "Halo Yan's Food, saya ingin bertanya seputar menu.";
        } elseif (str_contains($currentPath, 'pesan')) {
            $waPrompt = "Halo Admin Yan's Food, saya ingin konsultasi pesanan katering.";
        }
    @endphp
    <a id="floating-wa-btn"
       href="https://wa.me/6281234567890?text={{ urlencode($waPrompt) }}" 
       target="_blank" 
       rel="noopener"
       aria-label="Chat Admin Yan's Food via WhatsApp"
       class="fixed bottom-6 right-6 z-40 sm:bottom-8 sm:right-8 h-14 w-14 lg:hover:w-44 rounded-full bg-[#25D366] hover:bg-[#20bd5a] text-white shadow-lg hover:shadow-2xl transition-all duration-300 flex items-center justify-center lg:justify-start lg:px-4 gap-2.5 overflow-hidden group opacity-0 translate-y-4 pointer-events-none">
        <svg class="w-6 h-6 fill-current shrink-0" viewBox="0 0 24 24">
            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
        </svg>
        <span class="hidden lg:inline text-xs font-bold whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200">
            Chat Admin
        </span>
    </a>

    <!-- Floating Feedback Toast -->
    <div id="toast-cart" class="fixed bottom-24 left-4 right-4 sm:left-auto sm:right-6 z-50 transform translate-y-28 opacity-0 pointer-events-none transition-all duration-300 ease-out flex items-center justify-between gap-4 bg-inverse-surface text-inverse-on-surface px-5 py-3.5 rounded-xl shadow-xl max-w-md">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-tertiary-fixed text-[22px]">check_circle</span>
            <span id="toast-message" class="font-body-sm font-medium">Menu ditambahkan</span>
        </div>
        <a href="{{ url('/pesan') }}" class="font-label-sm text-tertiary-fixed font-bold pl-2 hover:underline">Lihat Pesanan</a>
    </div>

    <!-- Quick Order Modal -->
    <x-quick-order-modal />

    <!-- Global Cart, Scroll Progress & Notification Script -->
    <script>
        // Smooth Scroll Progress
        window.addEventListener('scroll', function() {
            const scrollBar = document.getElementById('scroll-progress-bar');
            if (!scrollBar) return;
            const winScroll = document.documentElement.scrollTop || document.body.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = height > 0 ? (winScroll / height) * 100 : 0;
            scrollBar.style.width = scrolled + '%';
        }, { passive: true });

        function showToast(message) {
            const toast = document.getElementById('toast-cart');
            const toastMsg = document.getElementById('toast-message');
            if (!toast) return;
            if (toastMsg) toastMsg.textContent = message;
            toast.classList.remove('translate-y-28', 'opacity-0', 'pointer-events-none');
            setTimeout(() => {
                toast.classList.add('translate-y-28', 'opacity-0', 'pointer-events-none');
            }, 3000);
        }

        function addToCart(title, price, category = 'Makanan') {
            let cart = JSON.parse(localStorage.getItem('yans_cart') || '[]');
            const existing = cart.find(item => item.title === title);
            if (existing) {
                existing.qty += 1;
            } else {
                cart.push({ title, price, category, qty: 1 });
            }
            localStorage.setItem('yans_cart', JSON.stringify(cart));
            if (typeof updateCartBadge === 'function') {
                updateCartBadge();
            }
            showToast(`${title} ditambahkan ke pesanan!`);
        }
    </script>
</body>
</html>
