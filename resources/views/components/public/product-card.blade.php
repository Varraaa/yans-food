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
                    <span class="badge-favorite px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-full bg-primary-container text-on-primary font-label-sm text-[10px] sm:text-[11px] font-bold shadow-xs">
                        Favorit
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

    <!-- 3. Price & Action Hint (§5.3) -->
    <div class="pt-2.5 sm:pt-4 mt-2 sm:mt-3 flex items-center justify-between border-t border-surface-variant/40">
        <div>
            <span class="font-label-sm text-secondary block text-[10px] sm:text-[11px]">Harga</span>
            <div class="font-bold tabular-nums text-primary text-sm sm:text-base md:text-lg">
                Rp {{ $formattedPrice }}
                <span class="font-normal text-secondary text-[10px] sm:text-xs">{{ $unit }}</span>
            </div>
        </div>

        <div class="inline-flex items-center gap-0.5 sm:gap-1 text-[11px] sm:text-xs font-label-md text-secondary group-hover:text-primary transition-colors">
            <span class="hidden sm:inline">Detail</span>
            <span class="material-symbols-outlined text-[16px] sm:text-[18px] transition-transform duration-200 group-hover:translate-x-0.5">arrow_forward</span>
        </div>
    </div>
</article>
