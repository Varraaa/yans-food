<!-- Splash Screen Intro (2-3 Detik Sesi Pertama) — Sesuai Panduan UX review_rekomendasi_ux_animasi_yan_s_food.md -->
<div id="yansfood-splash" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-[#FAF7F2] transition-all duration-700 ease-out select-none" aria-hidden="true">
    <div class="relative flex flex-col items-center max-w-sm px-6 text-center">
        <!-- Ambient Warm Glow Background -->
        <div class="absolute -top-10 w-44 h-44 bg-gradient-to-tr from-[#D6A253]/25 via-[#E2631C]/20 to-transparent rounded-full blur-3xl -z-10 pointer-events-none"></div>

        <!-- Logo Monogram Badge -->
        <div id="splash-logo" class="w-24 h-24 sm:w-28 sm:h-28 rounded-3xl bg-gradient-to-br from-[#D6A253] via-[#C1440E] to-[#8F3209] p-[3px] shadow-2xl mb-4 scale-90 opacity-0 transition-all duration-500 ease-out">
            <div class="w-full h-full rounded-[21px] bg-[#E2631C] flex items-center justify-center overflow-hidden">
                <img src="{{ asset('images/logo/Icon Yans Food.svg') }}" 
                     alt="Yan's Food" 
                     class="w-full h-full object-cover">
            </div>
        </div>

        <!-- Brand Name -->
        <h1 id="splash-title" class="text-2xl sm:text-3xl font-black text-stone-900 tracking-tight font-serif opacity-0 transition-opacity duration-500">
            YAN'S FOOD
        </h1>
        <p id="splash-subtitle" class="text-[10px] sm:text-xs uppercase font-extrabold tracking-[0.22em] text-[#C1440E] mt-0.5 mb-5 opacity-0 transition-opacity duration-500">
            Dapur Kuliner Rumahan
        </p>

        <!-- Dynamic Progress Bar -->
        <div class="w-48 sm:w-56 h-1.5 bg-stone-200/80 rounded-full overflow-hidden shadow-inner mb-2.5">
            <div id="splash-progress-bar" class="h-full bg-gradient-to-r from-[#D6A253] via-[#E2631C] to-[#C1440E] rounded-full w-0 transition-all duration-[1300ms] ease-out"></div>
        </div>

        <!-- Caption Message -->
        <p id="splash-caption" class="text-[11px] sm:text-xs font-medium text-stone-500 italic transition-all duration-300">
            Menyiapkan hidangan hangat...
        </p>
    </div>
</div>

<script>
(function() {
    try {
        const SPLASH_KEY = 'yansfood_splash_shown';
        const splash = document.getElementById('yansfood-splash');
        if (!splash) return;

        // Aturan UX: Splash hanya tayang pada kunjungan pertama sesi browser
        if (sessionStorage.getItem(SPLASH_KEY)) {
            splash.style.display = 'none';
            return;
        }

        // Kunjungan pertama: kunci scroll sementara
        document.body.classList.add('overflow-hidden');

        const logo = document.getElementById('splash-logo');
        const title = document.getElementById('splash-title');
        const sub = document.getElementById('splash-subtitle');
        const bar = document.getElementById('splash-progress-bar');
        const caption = document.getElementById('splash-caption');

        // Fase 1: Logo & Judul masuk (0.0s - 0.4s)
        setTimeout(() => {
            if (logo) {
                logo.classList.remove('scale-90', 'opacity-0');
                logo.classList.add('scale-100', 'opacity-100');
            }
            if (title) title.classList.remove('opacity-0');
            if (sub) sub.classList.remove('opacity-0');
        }, 100);

        // Fase 2: Progress bar berjalan dinamis (0.4s - 1.6s)
        setTimeout(() => {
            if (bar) bar.style.width = '100%';
            if (logo) logo.classList.add('animate-pulse');
        }, 400);

        setTimeout(() => {
            if (caption) caption.textContent = 'Menata hidangan di meja...';
        }, 1100);

        // Fase 3: Exit / Curtain-up lift (1.8s - 2.4s)
        const dismissSplash = () => {
            if (splash.dataset.dismissed) return;
            splash.dataset.dismissed = 'true';
            sessionStorage.setItem(SPLASH_KEY, 'true');

            splash.classList.add('opacity-0', '-translate-y-8', 'pointer-events-none');
            document.body.classList.remove('overflow-hidden');

            setTimeout(() => {
                splash.remove();
            }, 750);
        };

        setTimeout(dismissSplash, 1900);

        // Safety fallback timeout (maksimal 2.8s)
        setTimeout(dismissSplash, 2800);
    } catch(e) {
        const s = document.getElementById('yansfood-splash');
        if (s) s.remove();
        document.body.classList.remove('overflow-hidden');
    }
})();
</script>
