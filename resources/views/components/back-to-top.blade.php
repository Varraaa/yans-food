{{--
    Yan's Food - Back To Top Component
    - Fixed di pojok kanan bawah
    - Muncul mulus ketika user scroll > 250px
    - Smooth scrolling ke atas saat diklik
    - Desain premium dengan bayangan halus & efek hover naik
--}}

<button id="back-to-top-btn"
        type="button"
        aria-label="Kembali ke atas halaman"
        title="Kembali ke atas"
        onclick="scrollToTop()"
        class="fixed bottom-6 right-6 z-40 sm:bottom-8 sm:right-8 w-12 h-12 rounded-full bg-primary-container text-on-primary shadow-lg hover:shadow-2xl hover:bg-primary-dark hover:-translate-y-1 active:translate-y-0 transition-all duration-300 ease-out flex items-center justify-center opacity-0 translate-y-6 pointer-events-none group focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
    <span class="material-symbols-outlined text-[24px] transition-transform duration-200 group-hover:-translate-y-0.5">
        arrow_upward
    </span>
    <span class="sr-only">Kembali ke atas</span>
</button>

<script>
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    window.addEventListener('scroll', function() {
        const btn = document.getElementById('back-to-top-btn');
        if (!btn) return;
        
        if (window.scrollY > 250) {
            btn.classList.remove('opacity-0', 'translate-y-6', 'pointer-events-none');
            btn.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
        } else {
            btn.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
            btn.classList.add('opacity-0', 'translate-y-6', 'pointer-events-none');
        }
    }, { passive: true });
</script>
