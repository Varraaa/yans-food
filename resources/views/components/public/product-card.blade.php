@props([
    'title',
    'category' => 'Makanan',
    'categorySlug' => 'all',
    'price' => 0,
    'unit' => '/ pcs',
    'image' => '',
    'desc' => '',
    'status' => 'sedia',
    'isFavorite' => false,
    'slug' => null,
])

@php
    $isAvailable = strtolower($status) === 'sedia' || $status === 'available' || $status === 1 || $status === true;
    $numPrice = is_numeric($price) ? (int)$price : (int)preg_replace('/[^0-9]/', '', (string)$price);
    $formattedPrice = number_format($numPrice, 0, ',', '.');
    $productSlug = $slug ?: \Illuminate\Support\Str::slug($title);
@endphp

<article class="card-product group {{ !$isAvailable ? 'card-product-unavailable' : '' }}" 
         tabindex="0"
         role="button"
         aria-haspopup="dialog"
         aria-label="Buka detail {{ $title }}"
         data-category="{{ $categorySlug }}"
         data-category-name="{{ $category }}"
         data-name="{{ strtolower($title) }}"
         data-title="{{ $title }}"
         data-price="{{ $numPrice }}"
         data-price-formatted="{{ $formattedPrice }}"
         data-unit="{{ $unit }}"
         data-image="{{ $image }}"
         data-desc="{{ $desc }}"
         data-available="{{ $isAvailable ? '1' : '0' }}"
         data-slug="{{ $productSlug }}">
    
    <div class="space-y-3.5">
        <!-- 1. Visual Photo Container (4:5 Aspect Ratio, §3.8, §5.3) -->
        <div class="relative w-full aspect-[4/5] rounded-2xl overflow-hidden bg-sand-bg-alt img-zoom-container">
            <img class="w-full h-full object-cover img-zoom product-img" 
                 src="{{ $image }}" 
                 alt="{{ $title }}"
                 loading="lazy">
            
            <!-- Category & Favorite Badges (§5.3) -->
            <div class="absolute top-2 left-2 sm:top-2.5 sm:left-2.5 flex flex-wrap gap-1 sm:gap-1.5 z-10">
                @if($isFavorite)
                    <span class="badge-favorite w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-amber-500 text-white flex items-center justify-center shadow-xs shrink-0" title="Menu Favorit">
                        <span class="material-symbols-outlined text-[14px] sm:text-[16px] leading-none select-none" style="font-variation-settings: 'FILL' 1, 'wght' 700;">star</span>
                    </span>
                @endif
                <span class="px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-full bg-surface-warm/95 backdrop-blur-md text-on-surface font-label-sm text-[10px] sm:text-[11px] font-semibold shadow-xs border border-surface-variant/30">
                    {{ $category }}
                </span>
            </div>

            <!-- Availability Status Badge -->
            <div class="absolute top-2 right-2 sm:top-2.5 sm:right-2.5 z-10">
                @if($isAvailable)
                    <span class="px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-full bg-emerald-100/95 text-emerald-800 font-label-sm text-[10px] sm:text-[11px] font-semibold shadow-xs flex items-center gap-1 backdrop-blur-xs">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                        <span class="hidden xs:inline sm:inline">Sedia</span>
                    </span>
                @else
                    <span class="px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-full bg-surface-container text-secondary font-label-sm text-[10px] sm:text-[11px] font-semibold shadow-xs border border-surface-variant/40">
                        <span class="hidden xs:inline sm:inline">Habis</span>
                    </span>
                @endif
            </div>
        </div>

        <!-- 2. Typography & Story Description (Max 2 lines, §5.3) -->
        <div class="space-y-1 sm:space-y-1.5">
            <h3 class="font-headline-sm text-on-surface group-hover:text-primary transition-colors text-sm sm:text-base md:text-lg lg:text-xl font-serif line-clamp-2 leading-snug">
                {{ $title }}
            </h3>
            <p class="font-body-sm text-secondary line-clamp-2 text-[11px] sm:text-xs md:text-sm leading-relaxed">
                {{ $desc }}
            </p>
        </div>
    </div>

    <!-- 3. Price & Action Hint (§5.3 & review_rekomendasi_ux_animasi_yan_s_food.md) -->
    <div class="pt-2.5 sm:pt-3.5 mt-2 sm:mt-2.5 flex items-center justify-between gap-2 border-t border-surface-variant/40">
        <div>
            <span class="font-label-sm text-secondary block text-[10px] sm:text-[11px]">Harga</span>
            <div class="font-bold tabular-nums text-primary text-sm sm:text-base md:text-lg">
                Rp {{ $formattedPrice }}
                <span class="font-normal text-secondary text-[10px] sm:text-xs">{{ $unit }}</span>
            </div>
        </div>

        <div class="flex items-center gap-1.5 shrink-0">
            @if($isAvailable)
                <!-- Jalur Pintas Pemesanan Instan WhatsApp (§1.B) -->
                @php
                    $waText = rawurlencode("Halo Yan's Food, saya ingin memesan: {$title} (Rp {$formattedPrice})");
                @endphp
                <a href="https://wa.me/6282221222936?text={{ $waText }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   onclick="event.stopPropagation();"
                   class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-[#25D366]/15 hover:bg-[#25D366] text-[#1EBE5D] hover:text-white flex items-center justify-center transition-all shadow-2xs hover:scale-105 active:scale-95"
                   title="Pesan {{ $title }} Langsung via WhatsApp"
                   aria-label="Pesan via WhatsApp">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.275.072.376-.044c.101-.116.433-.506.549-.68.116-.174.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824zm-3.423-14.416c-6.627 0-12 5.373-12 12 0 2.159.57 4.184 1.564 5.938l-1.564 5.714 5.861-1.537c1.701.925 3.652 1.457 5.727 1.457 6.627 0 12-5.373 12-12 0-6.627-5.373-12-12-12z"/>
                    </svg>
                </a>
            @endif

            <div class="inline-flex items-center gap-0.5 sm:gap-1 text-[11px] sm:text-xs font-label-md text-secondary group-hover:text-primary transition-colors">
                <span class="hidden sm:inline">Detail</span>
                <span class="material-symbols-outlined text-[16px] sm:text-[18px] transition-transform duration-200 group-hover:translate-x-0.5">arrow_forward</span>
            </div>
        </div>
    </div>
</article>
