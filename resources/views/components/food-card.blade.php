@props([
    'title',
    'category',
    'categorySlug' => 'all',
    'price',
    'unit' => '/ pcs',
    'image',
    'desc',
    'status' => 'sedia',
    'isFavorite' => false,
])

@php
    $isAvailable = strtolower($status) === 'sedia';
@endphp

<article class="product-card group flex flex-col justify-between rounded-2xl bg-surface-warm p-4 shadow-sm hover:shadow-md transition-all duration-200 {{ !$isAvailable ? 'opacity-80' : '' }}" 
         data-category="{{ $categorySlug }}" 
         data-title="{{ $title }}">
    <div class="space-y-4">
        <!-- Product Thumbnail with Badges -->
        <div class="relative w-full aspect-square rounded-xl overflow-hidden bg-surface-container">
            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 {{ !$isAvailable ? 'grayscale-[30%] opacity-70' : '' }}" 
                 src="{{ $image }}" 
                 alt="{{ $title }}"
                 loading="lazy">
            
            <!-- Category & Favorite Badges -->
            <div class="absolute top-3 left-3 flex flex-wrap gap-1.5 z-10">
                @if($isFavorite)
                    <span class="px-2.5 py-1 rounded-full bg-primary-container text-on-primary font-label-sm shadow-sm font-semibold">
                        Favorit
                    </span>
                @endif
                <span class="px-2.5 py-1 rounded-full bg-surface-warm/95 backdrop-blur-sm text-on-surface font-label-sm shadow-sm font-medium">
                    {{ $category }}
                </span>
            </div>

            <!-- Availability Status Badge -->
            <div class="absolute top-3 right-3 z-10">
                @if($isAvailable)
                    <span class="px-2.5 py-1 rounded-full bg-success-surface text-success font-label-sm shadow-sm flex items-center gap-1 font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-success"></span>
                        Sedia
                    </span>
                @else
                    <span class="px-2.5 py-1 rounded-full bg-neutral-surface text-secondary font-label-sm shadow-sm font-semibold">
                        Habis
                    </span>
                @endif
            </div>
        </div>

        <!-- Typography & Story Description -->
        <div class="space-y-2">
            <h3 class="font-headline-sm text-on-surface group-hover:text-primary transition-colors text-xl font-serif">
                {{ $title }}
            </h3>
            <p class="font-body-sm text-secondary line-clamp-2 leading-relaxed">
                {{ $desc }}
            </p>
        </div>
    </div>

    <!-- Pricing & Action Button -->
    <div class="pt-5 mt-4 flex items-center justify-between border-t border-surface-variant/40">
        <div>
            <span class="font-label-sm text-secondary block text-xs">Harga</span>
            <div class="font-numeric-currency text-primary-container">
                Rp {{ is_numeric($price) ? number_format($price, 0, ',', '.') : $price }} 
                <span class="font-body-sm text-secondary font-normal text-xs">{{ $unit }}</span>
            </div>
        </div>

        @if($isAvailable)
            <button type="button" 
                    onclick="openQuickOrder('{{ addslashes($title) }}', '{{ is_numeric($price) ? number_format($price, 0, ',', '.') : $price }}', '{{ addslashes($category) }}', '{{ addslashes($desc) }}', '{{ $image }}')"
                    class="px-4 py-2 rounded-xl bg-primary-container hover:bg-primary-dark text-on-primary font-label-md transition-all duration-200 flex items-center gap-1.5 shadow-sm active:scale-95 text-xs sm:text-sm">
                <span class="material-symbols-outlined text-[16px] sm:text-[18px]">local_mall</span>
                <span>Pesan Sekarang</span>
            </button>
        @else
            <button type="button" disabled
                    class="px-3.5 py-2 rounded-xl bg-surface-container text-on-surface-variant/60 font-label-md flex items-center gap-1.5 cursor-not-allowed text-xs sm:text-sm">
                <span class="material-symbols-outlined text-[16px] sm:text-[18px]">block</span>
                <span>Habis</span>
            </button>
        @endif
    </div>
</article>
