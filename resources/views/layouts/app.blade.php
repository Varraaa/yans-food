<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? "Yan's Food — Dapur Kuliner Rumahan" }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo/Favicon Yans Food.svg') }}">
    <meta name="description" content="Yan's Food menyajikan sajian kuliner rumahan otentik, kudapan renyah, dan masakan hangat bernutrisi dari dapur higienis terpercaya.">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Facebook (§10) -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Yan's Food">
    <meta property="og:title" content="{{ $title ?? "Yan's Food — Dapur Kuliner Rumahan" }}">
    <meta property="og:description" content="Yan's Food menyajikan sajian kuliner rumahan otentik, kudapan renyah, dan masakan hangat bernutrisi higienis terpercaya.">
    <meta property="og:image" content="{{ asset('images/logo/Icon Yans Food.svg') }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title ?? "Yan's Food — Dapur Kuliner Rumahan" }}">
    <meta name="twitter:description" content="Yan's Food menyajikan sajian kuliner rumahan otentik, kudapan renyah, dan masakan hangat bernutrisi higienis terpercaya.">

    <!-- Schema.org JSON-LD LocalBusiness / Restaurant (§10) -->
    <script type="application/ld+json">
    {
        "{{ '@context' }}": "https://schema.org",
        "{{ '@type' }}": "Restaurant",
        "name": "Yan's Food",
        "image": "{{ asset('images/logo/Icon Yans Food.svg') }}",
        "description": "Kuliner rumahan otentik, kudapan renyah, dan masakan hangat bernutrisi higienis terpercaya.",
        "servesCuisine": "Indonesian",
        "priceRange": "$$",
        "telephone": "+6282221222936",
        "address": {
            "{{ '@type' }}": "PostalAddress",
            "streetAddress": "Kp. Ciloa, RT.04/RW.10, Kec. Soreang",
            "addressLocality": "Bandung",
            "addressRegion": "Jawa Barat",
            "addressCountry": "ID"
        },
        "openingHoursSpecification": [
            {
                "{{ '@type' }}": "OpeningHoursSpecification",
                "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
                "opens": "08:00",
                "closes": "22:00"
            }
        ]
    }
    </script>

    <!-- Progressive Enhancement Marker (§3.2, Aturan 2) -->
    <script>document.documentElement.classList.add('js');</script>

    <!-- Preconnect Google Fonts: Outfit (Headings) & Plus Jakarta Sans (Body) (§8.2) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=block" rel="stylesheet">

    <!-- Tailwind v4 & Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream-bg font-sans text-on-surface antialiased min-h-screen flex flex-col selection:bg-primary-fixed selection:text-primary-dark relative">

    <!-- Accessible Skip Link (§3.4, §9) -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-[100] focus:px-4 focus:py-2.5 focus:bg-stone-900 focus:text-white focus:rounded-xl focus:shadow-xl focus:font-bold focus:text-xs">
        Lewati ke konten utama
    </a>

    <!-- Smooth Scroll Progress Indicator (§3.3, M26) -->
    <div id="scroll-progress-bar" class="scroll-progress-bar"></div>

    <!-- Modular Public Navbar (§3.4) -->
    <x-public.navbar />

    <!-- Main View Content -->
    <main id="main-content" class="w-full pt-20 bg-cream-bg flex-1 outline-none">
        {{ $slot }}
    </main>

    <!-- Modular Public Footer (§5.6) -->
    <x-public.footer />

    <!-- Back to Top Button (§3.4, M25) -->
    <x-back-to-top />

    <!-- Toast Notification Container (§3.6) -->
    <x-public.toast />

    <!-- Product Detail Modal / Mobile Bottom Sheet (§5.3, M19–M20) -->
    <x-public.product-modal />

</body>
</html>
