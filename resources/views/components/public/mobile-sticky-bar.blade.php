<!-- Mobile Sticky Bottom Action Bar — Sesuai Panduan UX review_rekomendasi_ux_animasi_yan_s_food.md (§4) -->
<aside class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-[#FFFDF9]/95 backdrop-blur-md border-t border-surface-variant/50 px-3.5 py-2.5 shadow-[0_-8px_25px_rgba(0,0,0,0.08)] flex items-center justify-between gap-2.5 transition-transform duration-300" aria-label="Aksi Cepat Pemesanan">
    <!-- Left: Store / Order Teaser -->
    <a href="{{ url('/menu') }}" class="flex items-center gap-2 min-w-0 flex-1 hover:opacity-85 transition">
        <div class="w-8 h-8 rounded-xl bg-orange-100 text-[#C1440E] flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-[18px]">restaurant_menu</span>
        </div>
        <div class="min-w-0">
            <p class="text-xs font-bold text-stone-900 truncate">Mau Pesan Apa?</p>
            <p class="text-[10px] text-stone-500 truncate">40 Menu Masakan & Kudapan</p>
        </div>
    </a>

    <!-- Right: High-Conversion Instant WhatsApp CTA -->
    <div class="flex items-center gap-1.5 shrink-0">
        <a href="{{ url('/menu') }}" 
           class="px-2.5 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 font-bold text-xs transition active:scale-95 flex items-center gap-1"
           title="Buka Katalog Menu">
            <span>Menu</span>
        </a>

        <a href="https://wa.me/6282221222936?text=Halo%20Yan%27s%20Food%2C%20saya%20ingin%20memesan%20makanan." 
           target="_blank" 
           rel="noopener noreferrer"
           class="px-3.5 py-2 rounded-xl bg-[#25D366] hover:bg-[#1ebe5d] active:scale-95 text-white font-bold text-xs shadow-sm transition flex items-center gap-1.5"
           aria-label="Pesan langsung lewat WhatsApp">
            <!-- WA SVG Icon -->
            <svg class="w-3.5 h-3.5 fill-current shrink-0" viewBox="0 0 24 24">
                <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.275.072.376-.044c.101-.116.433-.506.549-.68.116-.174.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824zm-3.423-14.416c-6.627 0-12 5.373-12 12 0 2.159.57 4.184 1.564 5.938l-1.564 5.714 5.861-1.537c1.701.925 3.652 1.457 5.727 1.457 6.627 0 12-5.373 12-12 0-6.627-5.373-12-12-12z"/>
            </svg>
            <span>Pesan WA</span>
        </a>
    </div>
</aside>
