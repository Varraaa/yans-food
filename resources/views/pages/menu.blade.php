<x-app-layout>
    <x-slot name="title">Daftar Menu & Katalog | Yan's Food</x-slot>

    <!-- Top Banner / Editorial Header -->
    <section class="w-full max-w-7xl mx-auto px-4 sm:px-6 md:px-8 lg:px-12 pt-8 pb-4 md:pt-12 md:pb-6" data-reveal>
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 pb-6 border-b border-surface-variant/40">
            <div class="space-y-3 max-w-2xl">
                <h1 class="font-headline-lg text-3xl sm:text-4xl lg:text-5xl text-on-surface tracking-tight font-serif">
                    Daftar Menu Yan's Food
                </h1>
                <p class="font-body-lg text-secondary leading-relaxed text-base sm:text-lg">
                    Semua hidangan dan kudapan kami olah dari bahan pilihan dengan resep rumahan otentik. Silakan pilih menu favorit Anda untuk santap hangat hari ini.
                </p>
            </div>

            <!-- Quick Metrics Strip -->
            <div class="flex items-center gap-4 sm:gap-6 p-4 rounded-2xl bg-surface-container shadow-xs self-start lg:self-auto border border-surface-variant/40">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-surface-warm flex items-center justify-center text-primary-container shadow-xs">
                        <span class="material-symbols-outlined text-[22px]">skillet</span>
                    </div>
                    <div>
                        <div class="font-label-md text-on-surface font-semibold text-sm">100% Halal</div>
                        <div class="font-label-sm text-secondary text-xs">Masakan Higienis</div>
                    </div>
                </div>
                <div class="w-px h-8 bg-surface-variant"></div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-surface-warm flex items-center justify-center text-primary-container shadow-xs">
                        <span class="material-symbols-outlined text-[22px]">timer</span>
                    </div>
                    <div>
                        <div class="font-label-md text-on-surface font-semibold text-sm">Fresh Cooked</div>
                        <div class="font-label-sm text-secondary text-xs">Dibuat Sesuai Order</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Ribbon & Search Bar -->
        <x-category-filter />
    </section>

    <!-- Product Catalog Grid (§5.3: Mobile Grid 2, Tablet/Desktop Grid 3) -->
    <section class="w-full max-w-7xl mx-auto px-4 sm:px-6 md:px-8 lg:px-12 py-6 pb-16">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-3.5 sm:gap-5 lg:gap-8" id="productGrid" data-reveal-group>
            @if(isset($products) && $products->isNotEmpty())
                @foreach($products as $product)
                    @php
                        $catName = $product->category?->name ?? 'Makanan';
                        $catSlug = 'all';
                        if (stripos($catName, 'Ringan') !== false) $catSlug = 'ringan';
                        elseif (stripos($catName, 'Berat') !== false) $catSlug = 'berat';
                        elseif (stripos($catName, 'Mie') !== false) $catSlug = 'mie';
                        elseif (stripos($catName, 'Minum') !== false) $catSlug = 'minuman';
                        else $catSlug = \Illuminate\Support\Str::slug($catName);
                    @endphp
                    <x-public.product-card 
                        :title="$product->name"
                        :category="$catName"
                        :categorySlug="$catSlug"
                        :price="$product->price"
                        :unit="'/ ' . ($product->unit ?? 'pcs')"
                        :image="$product->image_url"
                        :desc="$product->description ?? 'Olahan kuliner lezat khas racikan bumbu dapur Yan\'s Food.'"
                        :status="$product->status ?? 'sedia'"
                        :isFavorite="$loop->first || $loop->iteration <= 2"
                        :slug="\Illuminate\Support\Str::slug($product->name)" />
                @endforeach
            @else
                <!-- Fallback Curated Items (§5.3) -->
                <!-- Item 1: Risol Mayo -->
                <x-public.product-card 
                    title="Risol Mayo"
                    category="Makanan Ringan"
                    categorySlug="ringan"
                    price="14000"
                    unit="/ porsi"
                    :image="asset('images/Menu/Risol Mayo.png')"
                    desc="Mayo homemade creamy dengan potongan daging dan telur berbalut tepung roti emas renyah."
                    status="sedia"
                    :isFavorite="true"
                    slug="risol-mayo" />

                <!-- Item 2: Pisang Coklat Lumer -->
                <x-public.product-card 
                    title="Pisang Coklat Lumer"
                    category="Makanan Ringan"
                    categorySlug="ringan"
                    price="14000"
                    unit="/ porsi"
                    :image="asset('images/Menu/Pisang Coklat.png')"
                    desc="Pisang manis legit dengan coklat premium leleh di dalam balutan kulit pastry renyah khas racikan Yan's Food."
                    status="sedia"
                    :isFavorite="true"
                    slug="pisang-coklat-lumer" />

                <!-- Item 3: Cireng Rujak -->
                <x-public.product-card 
                    title="Cireng Rujak"
                    category="Makanan Ringan"
                    categorySlug="ringan"
                    price="10500"
                    unit="/ porsi"
                    :image="asset('images/Menu/Cireng Rujak.png')"
                    desc="Cireng renyah kenyal dengan cocolan bumbu rujak pedas manis segar."
                    status="sedia"
                    :isFavorite="false"
                    slug="cireng-rujak" />

                <!-- Item 4: Nasi Goreng Jadul Yan's -->
                <x-public.product-card 
                    title="Nasi Goreng Jadul"
                    category="Makanan Berat"
                    categorySlug="berat"
                    price="21000"
                    unit="/ porsi"
                    :image="asset('images/Menu/Nasi Goreng Jadul.png')"
                    desc="Racikan bumbu ulek terasi khas tempo dulu, suwiran ayam gurih, telur ceplok setengah matang, dan acar timun segar."
                    status="sedia"
                    :isFavorite="true"
                    slug="nasi-goreng-jadul" />

                <!-- Item 5: Nasi Chicken Katsu -->
                <x-public.product-card 
                    title="Nasi + Chicken Katsu"
                    category="Makanan Berat"
                    categorySlug="berat"
                    price="26500"
                    unit="/ porsi"
                    :image="asset('images/Menu/Nasi Chicken Katsu.png')"
                    desc="Nasi putih pulen dengan chicken katsu dada ayam renyah, salad sayuran segar, saus dan mayones."
                    status="sedia"
                    :isFavorite="false"
                    slug="nasi-chicken-katsu" />

                <!-- Item 6: Teh Manis -->
                <x-public.product-card 
                    title="Teh Manis (Hangat / Dingin)"
                    category="Minuman Segar"
                    categorySlug="minuman"
                    price="7000"
                    unit="/ cup"
                    :image="asset('images/Menu/Teh Manis.png')"
                    desc="Seduhan teh melati wangi khas Jawa dengan daun teh pilihan, tersedia pilihan hangat atau dingin segar."
                    status="sedia"
                    :isFavorite="false"
                    slug="teh-manis" />
            @endif
        </div>

        <!-- Empty State Container (§5.3 point 355, §7) -->
        <div id="menuEmptyState" class="hidden flex-col items-center justify-center py-16 px-4 text-center bg-surface-warm/50 rounded-3xl border border-surface-variant/30 mt-6">
            <div class="w-16 h-16 rounded-2xl bg-surface-container flex items-center justify-center mb-4 text-primary shadow-xs">
                <span class="material-symbols-outlined text-[36px]">search_off</span>
            </div>
            <h3 class="font-headline-sm text-on-surface font-semibold text-xl mb-1.5 font-serif">Belum Ada Menu yang Cocok</h3>
            <p class="font-body-md text-secondary max-w-sm mb-6 text-sm">
                Tidak ada menu yang sesuai dengan <span id="emptySearchQuery" class="font-semibold text-on-surface"></span>. Coba kata kunci lain atau reset filter.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-3">
                <button type="button" 
                        id="menuResetFilterBtn"
                        class="btn-primary text-xs sm:text-sm">
                    <span class="material-symbols-outlined text-[18px]">restart_alt</span>
                    <span>Tampilkan Semua Menu</span>
                </button>
            </div>
        </div>

        <!-- Load More Button (§5.3 point 353) -->
        <div class="pt-10 flex justify-center">
            <button type="button" 
                    id="menuLoadMoreBtn" 
                    class="hidden btn-outline text-xs sm:text-sm">
                <span>Tampilkan Lebih Banyak Menu</span>
                <span class="material-symbols-outlined text-[18px]">expand_more</span>
            </button>
        </div>
    </section>

    <!-- Banner Pesan Online & Takeaway Delivery -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 lg:px-12 pb-20" data-reveal>
        <div class="relative overflow-hidden bg-sand-bg-alt rounded-3xl p-6 sm:p-8 lg:p-10 shadow-sm flex flex-col lg:flex-row lg:items-center justify-between gap-6 sm:gap-8 border border-surface-variant/40">
            <div class="space-y-3 w-full lg:max-w-xl text-left">
                <div class="inline-flex items-center gap-2 text-primary font-label-sm font-bold uppercase tracking-wider text-xs">
                    <span class="material-symbols-outlined text-[18px]">delivery_dining</span>
                    <span>Pemesanan Cepat & Praktis</span>
                </div>
                <h3 class="font-headline-md text-2xl sm:text-3xl text-on-surface font-serif leading-snug">
                    Mau Menikmati Sajian Lezat Yan's Food Sekarang?
                </h3>
                <p class="font-body-md text-secondary leading-relaxed text-sm sm:text-base">
                    Pesan menu favorit Anda langsung melalui platform online delivery (ShopeeFood, GoFood, GrabFood) atau datang langsung ke dapur kami.
                </p>
            </div>
            
            <!-- Action Buttons: Clean Row on Tablet & Desktop, Full Width Stack on Mobile -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4 shrink-0 w-full lg:w-auto">
                <a href="{{ url('/pesan') }}" class="btn-hover-sophisticated w-full sm:w-auto px-6 py-3.5 rounded-xl bg-primary-container text-on-primary font-label-md flex items-center justify-center gap-2 shadow-md hover:bg-primary-dark transition-all text-xs sm:text-sm font-bold group">
                    <span class="material-symbols-outlined text-[20px] transition-transform duration-300 group-hover:scale-110 group-hover:-rotate-6">local_mall</span>
                    <span>Pesan Online Delivery</span>
                </a>
                <a href="https://maps.app.goo.gl/KnCpj3ViPCHGNmH66" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="btn-hover-glass w-full sm:w-auto px-6 py-3.5 rounded-xl bg-surface-warm text-on-surface font-label-md flex items-center justify-center gap-2 shadow-xs hover:bg-surface-container transition-all border border-surface-variant/50 text-xs sm:text-sm font-semibold group">
                    <span class="material-symbols-outlined text-[20px] text-primary transition-transform duration-300 group-hover:scale-110 group-hover:translate-x-0.5">near_me</span>
                    <span>Datang Langsung ke Tempat</span>
                </a>
            </div>
        </div>
    </section>
</x-app-layout>
