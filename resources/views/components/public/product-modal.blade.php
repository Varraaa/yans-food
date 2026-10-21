<!-- Product Detail Modal & Mobile Bottom Sheet (§5.3, M19–M20) -->
<div id="product-modal-backdrop" 
     class="product-modal-backdrop" 
     role="dialog" 
     aria-modal="true" 
     aria-hidden="true" 
     aria-labelledby="modal-product-title">
    
    <div class="product-modal-dialog p-5 sm:p-7 space-y-5">
        <!-- Mobile Bottom Sheet Handle (§3.7, M19) -->
        <div class="md:hidden bottom-sheet-handle"></div>

        <!-- Top Header Controls (Close & Navigation) -->
        <div class="flex items-center justify-between pb-2 border-b border-surface-variant/30">
            <!-- Navigation Counter & Arrows -->
            <div class="flex items-center gap-2">
                <button type="button" 
                        id="modal-btn-prev" 
                        aria-label="Menu sebelumnya"
                        class="w-8 h-8 rounded-full bg-surface-container hover:bg-surface-variant text-on-surface flex items-center justify-center transition-colors disabled:opacity-30 disabled:pointer-events-none">
                    <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                </button>
                <span id="modal-product-counter" class="text-xs font-label-sm font-semibold text-secondary min-w-[40px] text-center">1 / 1</span>
                <button type="button" 
                        id="modal-btn-next" 
                        aria-label="Menu selanjutnya"
                        class="w-8 h-8 rounded-full bg-surface-container hover:bg-surface-variant text-on-surface flex items-center justify-center transition-colors disabled:opacity-30 disabled:pointer-events-none">
                    <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                </button>
            </div>

            <!-- Close Button -->
            <button type="button" 
                    data-close-product-modal
                    aria-label="Tutup detail produk"
                    class="w-8 h-8 rounded-full bg-surface-container hover:bg-surface-variant text-on-surface flex items-center justify-center transition-colors">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>

        <!-- Visual Media Photo -->
        <div class="relative w-full aspect-[16/10] sm:aspect-[16/9] rounded-2xl overflow-hidden bg-sand-bg-alt shadow-xs">
            <img id="modal-product-img" 
                 src="" 
                 alt="" 
                 class="w-full h-full object-cover">
            
            <!-- Badges Overlay -->
            <div class="absolute top-3 left-3 flex items-center gap-2">
                <span id="modal-product-cat" class="px-3 py-1 rounded-full bg-surface-warm/95 backdrop-blur-md text-on-surface font-label-sm text-xs font-semibold shadow-xs border border-surface-variant/30"></span>
            </div>
            <div class="absolute top-3 right-3">
                <span id="modal-product-status"></span>
            </div>
        </div>

        <!-- Product Information Content -->
        <div class="space-y-3">
            <div class="flex flex-col sm:flex-row sm:items-baseline justify-between gap-2">
                <h2 id="modal-product-title" class="font-headline-md text-2xl sm:text-3xl text-on-surface font-serif font-bold tracking-tight"></h2>
                <div class="flex items-baseline gap-1">
                    <span id="modal-product-price" class="text-2xl font-bold tabular-nums text-primary font-serif"></span>
                    <span id="modal-product-unit" class="text-xs font-label-sm text-secondary"></span>
                </div>
            </div>

            <p id="modal-product-desc" class="font-body-md text-secondary leading-relaxed text-sm sm:text-base pt-1"></p>
        </div>

        <!-- Contextual Action Buttons (§5.3 points 346–349) -->
        <div class="pt-4 border-t border-surface-variant/40 space-y-3">
            <!-- Available Actions -->
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full">
                <a id="modal-action-platform" 
                   href="/pesan#online" 
                   class="btn-primary w-full sm:flex-1 py-3 text-sm">
                    <span class="material-symbols-outlined text-[18px]">moped</span>
                    <span>Pesan via Platform Online</span>
                </a>
                <a id="modal-action-wa" 
                   href="#" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="btn-whatsapp w-full sm:flex-1 py-3 text-sm">
                    <span class="material-symbols-outlined text-[18px]">chat</span>
                    <span>Tanya via WhatsApp</span>
                </a>
        </div>
    </div>
</div>
