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
            
            <!-- Favorite Badge (§5.3) -->
            @if($isFavorite)
                <div class="absolute top-2 left-2 sm:top-2.5 sm:left-2.5 z-10 flex items-center">
                    <!-- Bintang Realistis 3D Faceted Gold Star (Modern & Mewah) -->
                    <span class="badge-favorite relative inline-flex items-center justify-center w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-gradient-to-br from-stone-900/90 via-stone-800/85 to-stone-950/95 backdrop-blur-md border border-amber-400/50 shadow-md shrink-0 group-hover:scale-110 transition-transform duration-300" title="Menu Favorit Pilihan Pelanggan">
                        <span class="absolute inset-0 rounded-full bg-amber-400/20 blur-[2px]"></span>
                        <svg class="w-4 h-4 sm:w-4.5 sm:h-4.5 relative z-10 drop-shadow-[0_1px_2px_rgba(0,0,0,0.7)]" viewBox="0 0 24 24" fill="none">
                            <defs>
                                <linearGradient id="goldLight-{{ $productSlug }}" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#FFF4B8"/>
                                    <stop offset="50%" stop-color="#FFD700"/>
                                    <stop offset="100%" stop-color="#F5A623"/>
                                </linearGradient>
                                <linearGradient id="goldDark-{{ $productSlug }}" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#E5A100"/>
                                    <stop offset="60%" stop-color="#C47D00"/>
                                    <stop offset="100%" stop-color="#8C5200"/>
                                </linearGradient>
                            </defs>
                            <!-- Faceted 3D Gold Star Rays -->
                            <polygon points="12,12 12,2.5 14.3,9.5" fill="url(#goldLight-{{ $productSlug }})"/>
                            <polygon points="12,12 12,2.5 9.7,9.5" fill="url(#goldDark-{{ $productSlug }})"/>
                            <polygon points="12,12 21.5,9.5 16,14" fill="url(#goldLight-{{ $productSlug }})"/>
                            <polygon points="12,12 21.5,9.5 14.3,9.5" fill="url(#goldDark-{{ $productSlug }})"/>
                            <polygon points="12,12 18,20.5 12,16.5" fill="url(#goldLight-{{ $productSlug }})"/>
                            <polygon points="12,12 18,20.5 16,14" fill="url(#goldDark-{{ $productSlug }})"/>
                            <polygon points="12,12 6,20.5 12,16.5" fill="url(#goldDark-{{ $productSlug }})"/>
                            <polygon points="12,12 6,20.5 8,14" fill="url(#goldLight-{{ $productSlug }})"/>
                            <polygon points="12,12 2.5,9.5 8,14" fill="url(#goldDark-{{ $productSlug }})"/>
                            <polygon points="12,12 2.5,9.5 9.7,9.5" fill="url(#goldLight-{{ $productSlug }})"/>
                        </svg>
                    </span>
                </div>
            @endif

            <!-- Availability Status Badge (Modern Clean Ready Indicator) -->
            <div class="absolute top-2 right-2 sm:top-2.5 sm:right-2.5 z-10">
                @if($isAvailable)
                    <span class="px-2.5 py-1 rounded-full bg-stone-900/85 backdrop-blur-md text-emerald-300 font-label-sm text-[10px] sm:text-[11px] font-bold shadow-md flex items-center gap-1.5 border border-emerald-500/40" title="Produk Tersedia & Siap Saji">
                        <!-- Verified Check Icon -->
                        <svg class="w-3.5 h-3.5 text-emerald-400 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                        <span class="tracking-wide">Ready</span>
                    </span>
                @else
                    <span class="px-2.5 py-1 rounded-full bg-stone-900/80 backdrop-blur-md text-stone-300 font-label-sm text-[10px] sm:text-[11px] font-semibold shadow-md border border-stone-700/60 flex items-center gap-1.5" title="Produk Sedang Habis">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 shrink-0"></span>
                        <span>Habis</span>
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
