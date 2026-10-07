<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? "Yan's Food — Dapur Kuliner Rumahan" }}</title>
    <meta name="description" content="Yan's Food menyajikan sajian kuliner rumahan otentik, kudapan renyah, dan masakan hangat bernutrisi dari dapur higienis terpercaya.">

    <!-- Preconnect Google Fonts: Outfit (Headings Modern & Bersahaja) & Plus Jakarta Sans (Body Nyaman & Jernih) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <!-- Tailwind & Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="bg-cream-bg font-sans text-on-surface antialiased min-h-screen flex flex-col selection:bg-primary-fixed selection:text-primary-dark relative">

    <!-- Smooth Scroll Progress Indicator -->
    <div id="scroll-progress-bar" 
         class="fixed top-0 left-0 h-1 bg-gradient-to-r from-primary via-tertiary to-primary-container z-[60] transition-all duration-75 pointer-events-none" 
         style="width: 0%">
    </div>

    <!-- Modular Navbar -->
    <x-navbar />

    <!-- Main View Content -->
    <main class="w-full pt-20 bg-cream-bg flex-1">
        {{ $slot }}
    </main>

    <!-- Modular Footer -->
    <x-footer />

    <!-- Back to Top Button -->
    <x-back-to-top />

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

    <!-- Modular Keranjang & Kasir Drawer -->
    <x-cart-drawer />

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
