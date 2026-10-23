@extends('layouts.admin')

@php
    $title = "Kasir — Yan's Food";
@endphp

@section('content')
<div class="space-y-4">
    {{-- PAGE HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-stone-900 font-serif flex items-center gap-2">
                <span>🛒</span>
                <span>Kasir</span>
            </h1>
            <p class="text-xs sm:text-sm text-stone-500 mt-0.5">
                Panel kasir penjualan langsung &amp; cetak struk pesanan Yan's Food.
            </p>
        </div>
    </div>

    {{-- SESSION ALERTS --}}
    @if(session('success'))
        <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px] text-emerald-600">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 text-xs font-bold">✕</button>
        </div>
    @endif
    @if(session('error'))
        <div class="p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px] text-rose-600">error</span>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-700 hover:text-rose-900 text-xs font-bold">✕</button>
        </div>
    @endif
    @if(session('info'))
        <div class="p-3.5 rounded-2xl bg-sky-50 border border-sky-200 text-sky-800 text-xs font-semibold flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px] text-sky-600">info</span>
                <span>{{ session('info') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-sky-700 hover:text-sky-900 text-xs font-bold">✕</button>
        </div>
    @endif

    {{-- POS MAIN GRID --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
        {{-- LEFT COLUMN: PRODUCT SELECTION & CATALOG (7 or 8 COLS) --}}
        <div class="lg:col-span-7 xl:col-span-8 space-y-4">
            {{-- SEARCH & FILTER BAR --}}
            <div class="bg-white p-4 rounded-2xl shadow-xs border border-stone-200/90 space-y-3">
                <div class="flex flex-col sm:flex-row gap-2.5">
                    {{-- SEARCH INPUT --}}
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-stone-400">
                            <span class="material-symbols-outlined text-[20px]">search</span>
                        </span>
                        <input 
                            type="text" 
                            id="search-input"
                            placeholder="Cari menu Yan's Food... (tekan F2)" 
                            class="w-full pl-10 pr-9 py-2.5 rounded-xl border border-stone-300 bg-stone-50/70 text-stone-900 text-sm focus:bg-white focus:ring-2 focus:ring-[#C1440E] focus:outline-none transition shadow-inner placeholder:text-stone-400"
                        >
                        <button 
                            type="button" 
                            id="btn-clear-search" 
                            onclick="clearSearch()" 
                            class="hidden absolute inset-y-0 right-0 pr-3 flex items-center text-stone-400 hover:text-stone-600"
                        >
                            <span class="material-symbols-outlined text-[18px]">close</span>
                        </button>
                    </div>
                </div>

                {{-- CATEGORY PILLS --}}
                <div class="flex items-center gap-1.5 overflow-x-auto pb-1 text-xs no-scrollbar" id="category-pills">
                    <button 
                        type="button"
                        onclick="filterCategory('all', this)"
                        class="category-btn active px-3.5 py-1.5 rounded-xl font-bold whitespace-nowrap transition bg-[#C1440E] text-white shadow-xs"
                    >
                        Semua Menu ({{ count($products) }})
                    </button>
                    @foreach($categories as $category)
                        <button 
                            type="button"
                            onclick="filterCategory('{{ $category->id }}', this)"
                            class="category-btn px-3.5 py-1.5 rounded-xl font-semibold whitespace-nowrap transition bg-stone-100 text-stone-600 hover:bg-stone-200"
                        >
                            {{ $category->name }} ({{ $category->products_count }})
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- PRODUCTS GRID --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-3.5" id="products-grid">
                @forelse($products as $product)
                    @php
                        $isAvailable = $product->status === 'available' && $product->stock > 0;
                    @endphp
                    <div 
                        id="product-card-{{ $product->id }}"
                        data-id="{{ $product->id }}"
                        data-name="{{ $product->name }}"
                        data-price="{{ (float) $product->price }}"
                        data-unit="{{ $product->unit ?? 'porsi' }}"
                        data-stock="{{ (int) $product->stock }}"
                        data-category="{{ $product->category_id }}"
                        onclick="posAddToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ (float) $product->price }}, '{{ $product->unit ?? 'porsi' }}', {{ (int) $product->stock }})"
                        class="product-item group relative bg-white border border-stone-200/90 rounded-2xl overflow-hidden transition-all duration-200 flex flex-col justify-between select-none {{ $isAvailable ? 'cursor-pointer hover:border-[#C1440E]/70 hover:shadow-md hover:-translate-y-0.5 active:scale-[0.98]' : 'opacity-60 cursor-not-allowed bg-stone-50/70' }}"
                    >
                        {{-- PRODUCT IMAGE --}}
                        <div class="relative aspect-[4/3] bg-stone-100 overflow-hidden">
                            <img 
                                src="{{ $product->image_url }}" 
                                alt="{{ $product->name }}" 
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-300" 
                                loading="lazy"
                                onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=600&q=80';"
                            >

                            {{-- BADGE IN CART --}}
                            <span id="badge-cart-{{ $product->id }}" class="hidden absolute top-2 left-2 bg-[#C1440E] text-white text-[11px] px-2 py-0.5 rounded-full font-black shadow-md flex items-center gap-1">
                                <span class="material-symbols-outlined text-[13px]">shopping_bag</span>
                                <span id="badge-qty-{{ $product->id }}">1x</span>
                            </span>

                            {{-- STOCK BADGE --}}
                            @if($product->stock > 0)
                                <span class="absolute top-2 right-2 bg-stone-900/80 backdrop-blur-xs text-white text-[10px] px-2 py-0.5 rounded-full font-bold shadow-xs flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                    <span id="card-stock-label-{{ $product->id }}">{{ $product->stock }}</span>
                                </span>
                            @else
                                <span class="absolute top-2 right-2 bg-rose-600 text-white text-[10px] px-2.5 py-0.5 rounded-full font-black shadow-xs">
                                    Habis
                                </span>
                            @endif
                        </div>

                        {{-- PRODUCT INFO --}}
                        <div class="p-3 flex-1 flex flex-col justify-between space-y-2">
                            <div>
                                <span class="text-[10px] text-stone-400 uppercase tracking-wider font-bold">
                                    {{ $product->category?->name ?? 'Menu' }}
                                </span>
                                <h4 class="font-bold text-stone-900 text-xs sm:text-sm leading-snug line-clamp-2 mt-0.5 group-hover:text-[#C1440E] transition product-title">
                                    {{ $product->name }}
                                </h4>
                            </div>

                            <div class="pt-2 border-t border-stone-100 flex items-center justify-between">
                                <div>
                                    <span class="text-xs sm:text-sm font-black text-[#C1440E] tabular-nums">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                    <span class="text-[10px] text-stone-400 block font-medium">/ {{ $product->unit ?? 'porsi' }}</span>
                                </div>
                                <button 
                                    type="button" 
                                    class="w-7 h-7 rounded-lg {{ $isAvailable ? 'bg-stone-100 text-stone-700 group-hover:bg-[#C1440E] group-hover:text-white' : 'bg-stone-100 text-stone-300' }} flex items-center justify-center transition text-xs font-black shadow-2xs"
                                >
                                    <span class="material-symbols-outlined text-[16px]">add</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-dashed border-stone-300">
                        <span class="material-symbols-outlined text-[48px] text-stone-300 mb-2">restaurant_menu</span>
                        <p class="text-stone-500 text-sm font-semibold">Belum ada menu produk yang berstatus tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- RIGHT COLUMN: CART & BILLING TERMINAL (5 or 4 COLS) --}}
        <div class="lg:col-span-5 xl:col-span-4 bg-white rounded-2xl shadow-sm border border-stone-200/90 p-4 sm:p-5 space-y-4 sticky top-20">
            {{-- CART HEADER --}}
            <div class="flex items-center justify-between pb-3 border-b border-stone-200">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-amber-500/10 text-[#C1440E] flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-[22px]">shopping_cart</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-stone-900 text-sm leading-tight">Keranjang Struk</h3>
                        <p class="text-[11px] text-stone-500">Kasir: <strong class="text-stone-700 font-semibold">{{ Auth::user()->name ?? "Owner Yan's Food" }}</strong></p>
                    </div>
                </div>
                <button 
                    type="button" 
                    onclick="clearCart()" 
                    id="btn-clear-cart"
                    class="hidden text-[11px] text-rose-600 hover:text-rose-700 font-bold px-2 py-1 rounded-lg hover:bg-rose-50 transition flex items-center gap-1"
                >
                    <span class="material-symbols-outlined text-[15px]">delete_sweep</span>
                    <span>Kosongkan</span>
                </button>
            </div>

            {{-- CUSTOMER NAME FIELD (MANDATORY) --}}
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-stone-400">
                    <span class="material-symbols-outlined text-[18px]">person</span>
                </span>
                <input 
                    type="text" 
                    id="input-customer-name"
                    placeholder="Nama Pelanggan *"
                    class="w-full pl-9 pr-3 py-2 rounded-xl border border-stone-200 bg-stone-50 text-xs text-stone-800 focus:bg-white focus:ring-1 focus:ring-[#C1440E] focus:outline-none transition placeholder:text-stone-400 font-medium"
                    required
                >
            </div>

            {{-- CART ITEMS CONTAINER --}}
            <div id="cart-list" class="max-h-56 overflow-y-auto space-y-2.5 divide-y divide-stone-100 pr-1 text-xs">
                <div id="cart-empty-state" class="py-8 text-center text-stone-400 space-y-2">
                    <span class="material-symbols-outlined text-[36px] text-stone-300">point_of_sale</span>
                    <p class="text-xs font-medium text-stone-500">Keranjang kasir masih kosong.</p>
                    <p class="text-[10px] text-stone-400">Klik menu di sebelah kiri untuk memasukkan pesanan.</p>
                </div>
            </div>

            {{-- SEGMENTED PAYMENT METHOD SWITCH (§7.1) --}}
            <div class="pt-3 border-t border-stone-200 space-y-2">
                <div class="flex items-center justify-between">
                    <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest">Metode Pembayaran</label>
                    <span class="text-[10px] text-stone-400 font-mono">(Tekan F4)</span>
                </div>
                <div class="grid grid-cols-2 gap-2 p-1 bg-stone-100 rounded-2xl border border-stone-200/80">
                    {{-- CASH BUTTON --}}
                    <button 
                        type="button" 
                        onclick="setPaymentMethod('CASH')"
                        id="btn-method-cash"
                        class="method-btn py-2.5 px-3 rounded-xl font-bold text-xs flex items-center justify-center gap-2 transition bg-emerald-600 text-white shadow-xs"
                    >
                        <span class="material-symbols-outlined text-[18px]">payments</span>
                        <span>Tunai (Cash)</span>
                    </button>

                    {{-- QRIS BUTTON --}}
                    <button 
                        type="button" 
                        onclick="setPaymentMethod('QRIS')"
                        id="btn-method-qris"
                        class="method-btn py-2.5 px-3 rounded-xl font-bold text-xs flex items-center justify-center gap-2 transition text-stone-600 hover:text-stone-900"
                    >
                        <span class="material-symbols-outlined text-[18px]">qr_code_2</span>
                        <span>QRIS Statis</span>
                    </button>
                </div>
            </div>

            {{-- BILLING SUMMARY & DISCOUNT --}}
            <div class="space-y-2 pt-2 border-t border-stone-200 text-xs">
                <div class="flex justify-between items-center text-stone-500">
                    <span>Subtotal Menu</span>
                    <span class="font-bold text-stone-800 tabular-nums" id="label-subtotal">Rp 0</span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-stone-500">Potongan Diskon (Rp)</span>
                    <div class="relative w-32">
                        <span class="absolute left-2.5 top-1.5 text-stone-400 text-[11px] font-bold">Rp</span>
                        <input 
                            type="number" 
                            id="input-discount"
                            min="0"
                            value="0"
                            placeholder="0"
                            oninput="recalculate()"
                            class="w-full text-right py-1 pl-7 pr-2.5 rounded-lg border border-stone-300 bg-stone-50 text-xs font-bold text-stone-900 focus:bg-white focus:ring-1 focus:ring-[#C1440E] tabular-nums"
                        >
                    </div>
                </div>

                {{-- TOTAL DISPLAY CARD --}}
                <div class="p-3.5 bg-gradient-to-br from-stone-900 to-stone-800 text-white rounded-2xl shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-[10px] text-amber-400 uppercase tracking-widest font-bold block">Total Tagihan</span>
                        <span class="text-[11px] text-stone-300" id="label-item-count">0 menu dipilih</span>
                    </div>
                    <div class="text-right">
                        <span class="text-2xl font-black text-amber-400 tabular-nums tracking-tight" id="label-total">Rp 0</span>
                    </div>
                </div>

                {{-- CASH INPUT CONTAINER (§7.2) --}}
                <div id="cash-tender-container" class="pt-2 space-y-2">
                    <div class="flex items-center justify-between">
                        <label class="block text-[10px] font-black text-stone-400 uppercase tracking-widest">Uang Tunai Diterima</label>
                        <span class="text-[10px] text-stone-400 font-medium">Pilih preset atau ketik</span>
                    </div>

                    {{-- QUICK MONEY PRESET CHIPS --}}
                    <div class="grid grid-cols-4 gap-1.5">
                        <button type="button" onclick="setExactAmount()" class="py-1.5 px-2 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-lg text-[11px] font-bold transition text-center shadow-2xs">
                            Pas
                        </button>
                        <button type="button" onclick="setNominal(50000)" class="py-1.5 px-2 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-lg text-[11px] font-bold transition text-center shadow-2xs">
                            50.000
                        </button>
                        <button type="button" onclick="setNominal(100000)" class="py-1.5 px-2 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-lg text-[11px] font-bold transition text-center shadow-2xs">
                            100.000
                        </button>
                        <button type="button" onclick="setNominal(200000)" class="py-1.5 px-2 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-lg text-[11px] font-bold transition text-center shadow-2xs">
                            200.000
                        </button>
                    </div>

                    {{-- CASH TENDER INPUT --}}
                    <div class="relative">
                        <span class="absolute left-3.5 top-2 text-stone-400 font-bold text-sm">Rp</span>
                        <input 
                            type="number" 
                            id="input-amount-paid"
                            inputmode="numeric"
                            min="0"
                            placeholder="0"
                            oninput="recalculate()"
                            class="w-full pl-10 pr-3 py-2 text-right font-black text-lg rounded-xl border border-stone-300 bg-white text-stone-900 focus:ring-2 focus:ring-[#C1440E] transition tabular-nums shadow-inner"
                        >
                    </div>

                    {{-- KEMBALIAN / KURANG STATUS BANNERS --}}
                    <div id="status-shortfall" class="hidden p-2.5 bg-rose-50 rounded-xl border border-rose-200 flex justify-between items-center text-xs">
                        <span class="font-bold text-rose-800 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px] text-rose-600">warning</span>
                            <span>Kurang Bayar</span>
                        </span>
                        <span class="font-black text-rose-600 tabular-nums text-sm" id="label-shortfall">Rp 0</span>
                    </div>

                    <div id="status-change" class="p-2.5 bg-emerald-50 rounded-xl border border-emerald-200 flex justify-between items-center text-xs">
                        <span class="font-bold text-emerald-800 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px] text-emerald-600">change_circle</span>
                            <span>Uang Kembalian</span>
                        </span>
                        <span class="font-black text-emerald-700 tabular-nums text-base" id="label-change">Rp 0</span>
                    </div>
                </div>

                {{-- QRIS SUMMARY CONTAINER (§7.3) --}}
                <div id="qris-summary-container" class="hidden pt-2 space-y-2.5">
                    <div class="p-3.5 rounded-2xl bg-sky-50/80 border border-sky-200 space-y-2 text-xs">
                        <div class="flex items-center justify-between text-sky-900 font-bold">
                            <span class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[18px] text-sky-600">qr_code_scanner</span>
                                <span>Layar QRIS Statis</span>
                            </span>
                            <span class="px-2 py-0.5 bg-sky-200/70 text-sky-800 rounded-md text-[10px] font-black uppercase">Aktif</span>
                        </div>
                        <p class="text-stone-700 text-xs">
                            Total tagihan QRIS: <strong class="text-stone-900 tabular-nums font-black text-sm" id="qris-summary-total">Rp 0</strong>
                        </p>
                        <p class="text-[11px] text-stone-500 leading-tight">
                            Klik tombol <strong>Lanjut ke QRIS</strong> di bawah untuk menampilkan gambar QR code kepada pelanggan. Setelah pelanggan berhasil scan dan membayar, klik <strong>Next</strong> untuk konfirmasi dan mencetak struk.
                        </p>
                    </div>
                </div>

                {{-- PRIMARY PROCESS BUTTON --}}
                <div class="pt-2">
                    <button 
                        type="button" 
                        id="btn-process"
                        disabled
                        onclick="submitTransaction()"
                        class="w-full py-3.5 px-4 rounded-xl font-black text-white shadow-md transition flex items-center justify-center gap-2 bg-stone-300 cursor-not-allowed text-xs sm:text-sm active:scale-[0.99]"
                    >
                        <span class="material-symbols-outlined text-[18px]">payments</span>
                        <span id="btn-process-text">BAYAR CASH & CETAK STRUK (F9)</span>
                    </button>
                </div>

                {{-- KEYBOARD SHORTCUTS HINT --}}
                <div class="text-[10px] text-stone-400 text-center pt-1 font-mono">
                    Pintasan: <strong>F9</strong> Eksekusi • <strong>F2</strong> Cari • <strong>F4</strong> Ganti Metode
                </div>
            </div>
        </div>
    </div>
</div>

{{-- RECEIPT MODAL (FALLBACK MODAL) --}}
<div id="receipt-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-stone-900/60 backdrop-blur-xs p-4">
    <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl border border-stone-200 overflow-hidden">
        <div class="p-4 bg-emerald-600 text-white flex justify-between items-center">
            <div class="flex items-center gap-2 font-bold text-sm">
                <span class="material-symbols-outlined text-[20px]">check_circle</span>
                <span>Transaksi Kasir Berhasil Disimpan!</span>
            </div>
            <button type="button" onclick="closeReceiptModal()" class="text-white hover:text-stone-200 text-lg font-bold">✕</button>
        </div>

        <div class="p-4 max-h-[75vh] overflow-y-auto" id="receipt-modal-body">
            <!-- Thermal Receipt will be injected here -->
        </div>

        <div class="p-4 bg-stone-50 border-t border-stone-200 flex justify-end gap-2.5">
            <button 
                type="button" 
                onclick="window.print()" 
                class="px-4 py-2.5 bg-stone-900 hover:bg-black text-white font-bold rounded-xl text-xs shadow transition flex items-center gap-1.5"
            >
                <span class="material-symbols-outlined text-[16px]">print</span>
                <span>Cetak Thermal</span>
            </button>
            <button 
                type="button" 
                onclick="closeReceiptModal()" 
                class="px-5 py-2.5 bg-[#C1440E] hover:bg-[#a3380b] text-white font-bold rounded-xl text-xs shadow transition"
            >
                Selesai & Transaksi Baru
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    window.cart = {}; // { productId: { id, name, price, unit, qty, stock } }
    window.paymentMethod = 'CASH';

    window.formatRupiah = function(number) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
    };

    window.clearSearch = function() {
        const input = document.getElementById('search-input');
        if (input) {
            input.value = '';
            input.dispatchEvent(new Event('input'));
            input.focus();
        }
    };

    window.filterCategory = function(catId, btn) {
        document.querySelectorAll('.category-btn').forEach(b => {
            b.className = 'category-btn px-3.5 py-1.5 rounded-xl font-semibold whitespace-nowrap transition bg-stone-100 text-stone-600 hover:bg-stone-200';
        });
        btn.className = 'category-btn active px-3.5 py-1.5 rounded-xl font-bold whitespace-nowrap transition bg-[#C1440E] text-white shadow-xs';

        document.querySelectorAll('.product-item').forEach(el => {
            const elCat = el.getAttribute('data-category');
            if (catId === 'all' || elCat === catId) {
                el.style.display = 'flex';
            } else {
                el.style.display = 'none';
            }
        });
    };

    const searchInput = document.getElementById('search-input');
    const clearSearchBtn = document.getElementById('btn-clear-search');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase().trim();
            if (clearSearchBtn) {
                if (query.length > 0) {
                    clearSearchBtn.classList.remove('hidden');
                } else {
                    clearSearchBtn.classList.add('hidden');
                }
            }
            document.querySelectorAll('.product-item').forEach(el => {
                const name = (el.querySelector('.product-title')?.textContent || '').toLowerCase();
                if (name.includes(query)) {
                    el.style.display = 'flex';
                } else {
                    el.style.display = 'none';
                }
            });
        });
    }

    window.posAddToCart = function(id, name, price, unit, stock) {
        if (stock <= 0) {
            alert(`Stok produk "${name}" sedang habis.`);
            return;
        }

        if (window.cart[id]) {
            if (window.cart[id].qty >= stock) {
                alert(`Kuantitas di keranjang sudah mencapai batas sisa stok (${stock} ${unit}).`);
                return;
            }
            window.cart[id].qty += 1;
        } else {
            window.cart[id] = { id, name, price, unit: unit || 'porsi', qty: 1, stock: stock };
        }
        window.renderCart();
    };
    window.addToCart = window.posAddToCart;

    window.updateCartQty = function(id, delta) {
        if (!window.cart[id]) return;

        if (delta > 0 && window.cart[id].stock !== undefined && window.cart[id].qty >= window.cart[id].stock) {
            alert(`Kuantitas maksimal adalah sisa stok yang tersedia (${window.cart[id].stock} ${window.cart[id].unit}).`);
            return;
        }

        window.cart[id].qty += delta;
        if (window.cart[id].qty <= 0) {
            delete window.cart[id];
        }
        window.renderCart();
    };

    window.removeFromCart = function(id) {
        delete window.cart[id];
        window.renderCart();
    };

    window.clearCart = function() {
        window.cart = {};
        const discountInput = document.getElementById('input-discount');
        const amountPaidInput = document.getElementById('input-amount-paid');
        const customerInput = document.getElementById('input-customer-name');
        if (discountInput) discountInput.value = 0;
        if (amountPaidInput) amountPaidInput.value = '';
        if (customerInput) customerInput.value = '';
        window.renderCart();
    };

    window.setPaymentMethod = function(method) {
        window.paymentMethod = method;
        
        const btnCash = document.getElementById('btn-method-cash');
        const btnQris = document.getElementById('btn-method-qris');
        const cashContainer = document.getElementById('cash-tender-container');
        const qrisContainer = document.getElementById('qris-summary-container');
        const btnProcess = document.getElementById('btn-process');

        if (method === 'CASH') {
            if (btnCash) {
                btnCash.className = 'method-btn py-2.5 px-3 rounded-xl font-bold text-xs flex items-center justify-center gap-2 transition bg-emerald-600 text-white shadow-xs';
            }
            if (btnQris) {
                btnQris.className = 'method-btn py-2.5 px-3 rounded-xl font-bold text-xs flex items-center justify-center gap-2 transition text-stone-600 hover:text-stone-900';
            }
            if (cashContainer) cashContainer.classList.remove('hidden');
            if (qrisContainer) qrisContainer.classList.add('hidden');
        } else {
            if (btnQris) {
                btnQris.className = 'method-btn py-2.5 px-3 rounded-xl font-bold text-xs flex items-center justify-center gap-2 transition bg-sky-700 text-white shadow-xs';
            }
            if (btnCash) {
                btnCash.className = 'method-btn py-2.5 px-3 rounded-xl font-bold text-xs flex items-center justify-center gap-2 transition text-stone-600 hover:text-stone-900';
            }
            if (cashContainer) cashContainer.classList.add('hidden');
            if (qrisContainer) qrisContainer.classList.remove('hidden');
        }

        window.recalculate();
    };

    window.setExactAmount = function() {
        const total = window.calculateTotal();
        const amountInput = document.getElementById('input-amount-paid');
        if (amountInput) amountInput.value = total > 0 ? total : '';
        window.recalculate();
    };

    window.setNominal = function(val) {
        window.setPaymentMethod('CASH');
        const amountInput = document.getElementById('input-amount-paid');
        if (amountInput) amountInput.value = val;
        window.recalculate();
    };

    window.calculateSubtotal = function() {
        let subtotal = 0;
        for (const id in window.cart) {
            subtotal += window.cart[id].price * window.cart[id].qty;
        }
        return subtotal;
    };

    window.calculateTotal = function() {
        const subtotal = window.calculateSubtotal();
        const discountInput = document.getElementById('input-discount');
        const discount = Math.max(0, parseFloat(discountInput ? discountInput.value : 0) || 0);
        return Math.max(0, subtotal - discount);
    };

    window.renderCart = function() {
        const cartList = document.getElementById('cart-list');
        const clearBtn = document.getElementById('btn-clear-cart');
        const keys = Object.keys(window.cart);

        // Update badges pada katalog produk
        document.querySelectorAll('.product-item').forEach(el => {
            const id = el.getAttribute('data-id');
            const badge = document.getElementById('badge-cart-' + id);
            const badgeQty = document.getElementById('badge-qty-' + id);
            if (window.cart[id]) {
                if (badge) badge.classList.remove('hidden');
                if (badgeQty) badgeQty.textContent = window.cart[id].qty + 'x';
                el.classList.add('border-[#C1440E]', 'shadow-xs', 'ring-1', 'ring-[#C1440E]/60');
            } else {
                if (badge) badge.classList.add('hidden');
                el.classList.remove('border-[#C1440E]', 'shadow-xs', 'ring-1', 'ring-[#C1440E]/60');
            }
        });

        if (keys.length === 0) {
            if (cartList) {
                cartList.innerHTML = `
                    <div id="cart-empty-state" class="py-8 text-center text-stone-400 space-y-2">
                        <span class="material-symbols-outlined text-[36px] text-stone-300">point_of_sale</span>
                        <p class="text-xs font-medium text-stone-500">Keranjang kasir masih kosong.</p>
                        <p class="text-[10px] text-stone-400">Klik menu di sebelah kiri untuk memasukkan pesanan.</p>
                    </div>
                `;
            }
            if (clearBtn) clearBtn.classList.add('hidden');
        } else {
            if (clearBtn) clearBtn.classList.remove('hidden');
            let html = '';
            for (const id in window.cart) {
                const item = window.cart[id];
                html += `
                    <div class="pt-2.5 first:pt-0 flex items-center justify-between gap-2 text-xs">
                        <div class="flex-1 min-w-0 pr-1">
                            <h5 class="font-bold text-stone-800 truncate text-xs leading-tight">${item.name}</h5>
                            <span class="text-[10px] text-stone-400">${window.formatRupiah(item.price)} / ${item.unit}</span>
                        </div>

                        <div class="flex items-center gap-1 bg-stone-100 p-0.5 rounded-lg border border-stone-200">
                            <button type="button" onclick="updateCartQty(${id}, -1)" class="w-5 h-5 rounded bg-white text-stone-700 hover:bg-stone-200 text-xs font-black shadow-2xs transition flex items-center justify-center">-</button>
                            <span class="font-black w-5 text-center text-xs text-stone-900">${item.qty}</span>
                            <button type="button" onclick="updateCartQty(${id}, 1)" class="w-5 h-5 rounded bg-white text-stone-700 hover:bg-stone-200 text-xs font-black shadow-2xs transition flex items-center justify-center">+</button>
                        </div>

                        <div class="text-right min-w-[70px]">
                            <span class="font-black text-stone-900 text-xs tabular-nums">${window.formatRupiah(item.price * item.qty)}</span>
                        </div>

                        <button type="button" onclick="removeFromCart(${id})" title="Hapus dari keranjang" class="text-stone-300 hover:text-rose-600 transition p-1">
                            <span class="material-symbols-outlined text-[15px]">delete</span>
                        </button>
                    </div>
                `;
            }
            if (cartList) cartList.innerHTML = html;
        }

        window.recalculate();
    };

    window.recalculate = function() {
        const subtotal = window.calculateSubtotal();
        const total = window.calculateTotal();
        const amountPaidInput = document.getElementById('input-amount-paid');
        let amountPaid = parseFloat(amountPaidInput ? amountPaidInput.value : 0) || 0;

        const labelSubtotal = document.getElementById('label-subtotal');
        const labelTotal = document.getElementById('label-total');
        const labelItemCount = document.getElementById('label-item-count');
        const qrisSummaryTotal = document.getElementById('qris-summary-total');

        const itemCount = Object.values(window.cart).reduce((acc, curr) => acc + curr.qty, 0);

        if (labelSubtotal) labelSubtotal.textContent = window.formatRupiah(subtotal);
        if (labelTotal) labelTotal.textContent = window.formatRupiah(total);
        if (labelItemCount) labelItemCount.textContent = `${itemCount} menu dipilih`;
        if (qrisSummaryTotal) qrisSummaryTotal.textContent = window.formatRupiah(total);

        const change = Math.max(0, amountPaid - total);
        const shortfall = Math.max(0, total - amountPaid);

        const labelChange = document.getElementById('label-change');
        const labelShortfall = document.getElementById('label-shortfall');
        if (labelChange) labelChange.textContent = window.formatRupiah(change);
        if (labelShortfall) labelShortfall.textContent = window.formatRupiah(shortfall);

        const statusShortfall = document.getElementById('status-shortfall');
        const statusChange = document.getElementById('status-change');
        const btnProcess = document.getElementById('btn-process');
        const btnProcessText = document.getElementById('btn-process-text');

        const hasItems = Object.keys(window.cart).length > 0;

        if (window.paymentMethod === 'CASH') {
            if (btnProcessText) btnProcessText.textContent = 'BAYAR CASH & CETAK STRUK (F9)';
            
            if (amountPaid < total && total > 0) {
                if (statusShortfall) statusShortfall.classList.remove('hidden');
                if (statusChange) statusChange.classList.add('hidden');
            } else {
                if (statusShortfall) statusShortfall.classList.add('hidden');
                if (statusChange) statusChange.classList.remove('hidden');
            }

            const isPaidEnough = (amountPaid >= total && total > 0);
            if (btnProcess) {
                if (hasItems && isPaidEnough) {
                    btnProcess.disabled = false;
                    btnProcess.className = 'w-full py-3.5 px-4 rounded-xl font-black text-white shadow-md transition flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 active:scale-[0.99] cursor-pointer text-xs sm:text-sm';
                } else {
                    btnProcess.disabled = true;
                    btnProcess.className = 'w-full py-3.5 px-4 rounded-xl font-black text-white shadow-md transition flex items-center justify-center gap-2 bg-stone-300 cursor-not-allowed text-xs sm:text-sm';
                }
            }
        } else {
            // QRIS Method
            if (btnProcessText) btnProcessText.textContent = 'LANJUT KE QRIS (F9)';
            if (statusShortfall) statusShortfall.classList.add('hidden');
            if (statusChange) statusChange.classList.add('hidden');

            if (btnProcess) {
                if (hasItems && total > 0) {
                    btnProcess.disabled = false;
                    btnProcess.className = 'w-full py-3.5 px-4 rounded-xl font-black text-white shadow-md transition flex items-center justify-center gap-2 bg-sky-700 hover:bg-sky-800 active:scale-[0.99] cursor-pointer text-xs sm:text-sm';
                } else {
                    btnProcess.disabled = true;
                    btnProcess.className = 'w-full py-3.5 px-4 rounded-xl font-black text-white shadow-md transition flex items-center justify-center gap-2 bg-stone-300 cursor-not-allowed text-xs sm:text-sm';
                }
            }
        }
    };

    window.submitTransaction = function() {
        const items = [];
        for (const id in window.cart) {
            items.push({
                product_id: parseInt(id),
                quantity: window.cart[id].qty
            });
        }

        if (items.length === 0) {
            alert('Pilih minimal 1 menu sebelum checkout.');
            return;
        }

        const total = window.calculateTotal();
        const discountInput = document.getElementById('input-discount');
        const discount = Math.max(0, parseFloat(discountInput ? discountInput.value : 0) || 0);
        const amountPaidInput = document.getElementById('input-amount-paid');
        let amountPaid = parseFloat(amountPaidInput ? amountPaidInput.value : 0) || 0;
        const customerNameInput = document.getElementById('input-customer-name');
        const customerName = customerNameInput ? customerNameInput.value.trim() : '';

        if (!customerName) {
            alert('Wajib mengisi Nama Pelanggan sebelum memproses transaksi.');
            if (customerNameInput) {
                customerNameInput.focus();
                customerNameInput.classList.add('border-rose-500', 'ring-1', 'ring-rose-500');
            }
            return;
        } else if (customerNameInput) {
            customerNameInput.classList.remove('border-rose-500', 'ring-1', 'ring-rose-500');
        }

        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';
        const btnProcess = document.getElementById('btn-process');

        if (window.paymentMethod === 'CASH') {
            if (amountPaid < total) {
                alert('Uang pembayaran tunai masih kurang dari total belanja.');
                return;
            }

            if (btnProcess) {
                btnProcess.disabled = true;
                btnProcess.innerHTML = `<span class="flex items-center gap-2">⏳ Menyimpan Transaksi Cash...</span>`;
            }

            fetch("{{ route('admin.pos.pay-cash') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    items: items,
                    amount_paid: amountPaid,
                    discount: discount,
                    customer_name: customerName || null
                })
            })
            .then(async (res) => {
                const data = await res.json();
                if (!res.ok) {
                    throw new Error(data.message || 'Gagal memproses pembayaran Cash.');
                }
                return data;
            })
            .then(data => {
                window.clearCart();
                if (data.redirect_url) {
                    window.location.href = data.redirect_url;
                } else if (data.receipt) {
                    window.showReceiptModal(data.receipt);
                }
            })
            .catch(err => {
                if (btnProcess) {
                    btnProcess.disabled = false;
                    btnProcess.innerHTML = `<span class="material-symbols-outlined text-[18px]">payments</span><span id="btn-process-text">BAYAR CASH & CETAK STRUK (F9)</span>`;
                }
                alert('Kesalahan Transaksi: ' + err.message);
            });

        } else if (window.paymentMethod === 'QRIS') {
            if (btnProcess) {
                btnProcess.disabled = true;
                btnProcess.innerHTML = `<span class="flex items-center gap-2">⏳ Menyiapkan Layar QRIS...</span>`;
            }

            fetch("{{ route('admin.pos.qris.prepare') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    items: items,
                    discount: discount,
                    customer_name: customerName || null
                })
            })
            .then(async (res) => {
                const data = await res.json();
                if (!res.ok) {
                    throw new Error(data.message || 'Gagal menyiapkan QRIS.');
                }
                return data;
            })
            .then(data => {
                if (data.redirect_url) {
                    window.location.href = data.redirect_url;
                }
            })
            .catch(err => {
                if (btnProcess) {
                    btnProcess.disabled = false;
                    btnProcess.innerHTML = `<span class="material-symbols-outlined text-[18px]">qr_code_2</span><span id="btn-process-text">LANJUT KE QRIS (F9)</span>`;
                }
                alert('Kesalahan QRIS: ' + err.message);
            });
        }
    };

    window.showReceiptModal = function(receipt) {
        if (!receipt) return;

        let itemsHtml = '';
        (receipt.items || []).forEach(item => {
            itemsHtml += `
                <div>
                    <div class="font-bold text-stone-900">${item.name}</div>
                    <div class="flex justify-between text-stone-600 pl-2">
                        <span>${item.qty} x ${window.formatRupiah(item.price)}</span>
                        <span class="font-semibold">${window.formatRupiah(item.subtotal)}</span>
                    </div>
                </div>
            `;
        });

        const storeName = receipt.header?.store_name || "YAN'S FOOD";
        const storeAddress = receipt.header?.address || 'Bandung, Kp. Ciloa, RT.04/RW.10, Kec. Soreang';
        const storePhone = receipt.header?.phone || '082221222936';
        const orderNum = receipt.order_info?.number || '-';
        const cashierName = receipt.order_info?.cashier || 'Kasir';
        const orderDate = receipt.order_info?.date || '';
        const orderTime = receipt.order_info?.time || '';
        const subtotal = receipt.summary?.subtotal || 0;
        const discount = receipt.summary?.discount || 0;
        const total = receipt.summary?.total || 0;
        const method = receipt.payment?.method || window.paymentMethod;
        const paid = receipt.payment?.paid || 0;
        const change = receipt.payment?.change || 0;
        const footerMsg = receipt.footer?.message || 'Terima kasih atas kunjungan Anda!';
        const footerSub = receipt.footer?.sub_message || 'Selamat Menikmati';

        const html = `
            <div id="printable-receipt" class="bg-amber-50/50 p-6 rounded-xl border border-stone-200 text-stone-800 font-mono text-xs max-w-sm mx-auto shadow-sm">
                <div class="text-center pb-3 border-b border-dashed border-stone-300">
                    <h3 class="text-base font-bold text-stone-900 tracking-wider">${storeName}</h3>
                    <p class="text-stone-600">${storeAddress}</p>
                    <p class="text-stone-500">WA: ${storePhone}</p>
                </div>

                <div class="py-2 border-b border-dashed border-stone-300 space-y-1">
                    <div class="flex justify-between">
                        <span>No: ${orderNum}</span>
                        <span>Kasir: ${cashierName}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Pelanggan:</span>
                        <span class="font-bold text-stone-900">${receipt.order_info?.customer || customerName || '-'}</span>
                    </div>
                    <div class="flex justify-between text-stone-500">
                        <span>Tgl: ${orderDate}</span>
                        <span>Jam: ${orderTime.includes('WIB') ? orderTime : orderTime + ' WIB'}</span>
                    </div>
                </div>

                <div class="py-3 border-b border-dashed border-stone-300 space-y-2">
                    ${itemsHtml}
                </div>

                <div class="py-3 border-b border-dashed border-stone-300 space-y-1.5">
                    <div class="flex justify-between">
                        <span>Subtotal:</span>
                        <span>${window.formatRupiah(subtotal)}</span>
                    </div>
                    ${discount > 0 ? `
                        <div class="flex justify-between text-emerald-600">
                            <span>Diskon:</span>
                            <span>- ${window.formatRupiah(discount)}</span>
                        </div>
                    ` : ''}
                    <div class="flex justify-between font-bold text-sm text-stone-900 pt-1.5 border-t border-dotted border-stone-300">
                        <span>TOTAL:</span>
                        <span>${window.formatRupiah(total)}</span>
                    </div>
                    <div class="flex justify-between pt-1">
                        <span>Bayar (${method}):</span>
                        <span>${window.formatRupiah(paid)}</span>
                    </div>
                    <div class="flex justify-between font-bold text-stone-900">
                        <span>Kembalian:</span>
                        <span>${window.formatRupiah(change)}</span>
                    </div>
                </div>

                <div class="text-center pt-4 text-stone-500 space-y-1">
                    <p>${footerMsg}</p>
                    <p class="text-[10px]">${footerSub}</p>
                </div>
            </div>
        `;

        const modalBody = document.getElementById('receipt-modal-body');
        const modal = document.getElementById('receipt-modal');
        if (modalBody) modalBody.innerHTML = html;
        if (modal) modal.classList.remove('hidden');
    };

    window.closeReceiptModal = function() {
        const modal = document.getElementById('receipt-modal');
        if (modal) modal.classList.add('hidden');
    };

    // Keyboard Shortcuts Support
    document.addEventListener('keydown', function(e) {
        // F9: Submit transaction
        if (e.key === 'F9') {
            e.preventDefault();
            const btn = document.getElementById('btn-process');
            if (btn && !btn.disabled) {
                btn.click();
            }
        }
        // F2: Focus search input
        if (e.key === 'F2') {
            e.preventDefault();
            const search = document.getElementById('search-input');
            if (search) search.focus();
        }
        // F4: Toggle payment method between CASH and QRIS
        if (e.key === 'F4') {
            e.preventDefault();
            window.setPaymentMethod(window.paymentMethod === 'CASH' ? 'QRIS' : 'CASH');
        }
        // Escape: Close receipt modal or clear search
        if (e.key === 'Escape') {
            const modal = document.getElementById('receipt-modal');
            if (modal && !modal.classList.contains('hidden')) {
                closeReceiptModal();
            }
        }
    });

    // Pulihkan keranjang jika kembali dari pembatalan sesi QRIS (§7.5)
    @if(session('restore_cart'))
    document.addEventListener('DOMContentLoaded', function() {
        const restored = @json(session('restore_cart'));
        if (Array.isArray(restored)) {
            restored.forEach(it => {
                const card = document.getElementById('product-card-' + it.product_id);
                if (card) {
                    const name = card.getAttribute('data-name');
                    const price = parseFloat(card.getAttribute('data-price'));
                    const unit = card.getAttribute('data-unit');
                    const stock = parseInt(card.getAttribute('data-stock'), 10);
                    for (let q = 0; q < it.quantity; q++) {
                        posAddToCart(it.product_id, name, price, unit, stock);
                    }
                }
            });
            window.setPaymentMethod('QRIS');
        }
    });
    @endif
</script>
@endpush
