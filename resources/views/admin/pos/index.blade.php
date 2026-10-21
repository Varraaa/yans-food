@extends('layouts.admin')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
    {{-- LEFT COLUMN: PRODUCT SELECTION & CATALOG --}}
    <div class="lg:col-span-7 xl:col-span-8 space-y-4">
        {{-- SEARCH & FILTER BAR --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-stone-200 space-y-3">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                    🔍
                </span>
                <input 
                    type="text" 
                    id="search-input"
                    placeholder="Cari menu Yan's Food (Nasi Box, Ayam Bakar, Es Teh...)" 
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-stone-900 text-sm focus:ring-2 focus:ring-[#C1440E] focus:outline-none transition"
                >
            </div>

            {{-- CATEGORY PILLS --}}
            <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs" id="category-pills">
                <button 
                    type="button"
                    onclick="filterCategory('all', this)"
                    class="category-btn active px-3.5 py-1.5 rounded-xl font-bold whitespace-nowrap transition bg-[#C1440E] text-white shadow-sm"
                >
                    Semua Menu
                </button>
                @foreach($categories as $category)
                    <button 
                        type="button"
                        onclick="filterCategory('{{ $category->id }}', this)"
                        class="category-btn px-3.5 py-1.5 rounded-xl font-bold whitespace-nowrap transition bg-stone-100 text-stone-700 hover:bg-stone-200"
                    >
                        {{ $category->name }} ({{ $category->products_count }})
                    </button>
                @endforeach
            </div>
        </div>

        {{-- PRODUCTS GRID --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4" id="products-grid">
            @forelse($products as $product)
                @php
                    $isAvailable = $product->status === 'available' && $product->stock > 0;
                @endphp
                <div 
                    id="product-card-{{ $product->id }}"
                    data-id="{{ $product->id }}"
                    data-name="{{ $product->name }}"
                    data-price="{{ (float) $product->price }}"
                    data-unit="{{ $product->unit }}"
                    data-stock="{{ (int) $product->stock }}"
                    data-category="{{ $product->category_id }}"
                    onclick="posAddToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ (float) $product->price }}, '{{ $product->unit }}', {{ (int) $product->stock }})"
                    class="product-item group {{ $isAvailable ? 'cursor-pointer hover:border-[#C1440E]/60 hover:shadow-lg active:scale-[0.99]' : 'opacity-60 cursor-not-allowed border-stone-200' }} bg-white border rounded-2xl overflow-hidden transition-all flex flex-col justify-between"
                >
                    <div class="relative aspect-video bg-stone-100 overflow-hidden">
                        <img 
                            src="{{ $product->image_url }}" 
                            alt="{{ $product->name }}" 
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300" 
                            loading="lazy"
                            onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=600&q=80';"
                        >

                        {{-- BADGE IN CART --}}
                        <span id="badge-cart-{{ $product->id }}" class="hidden absolute top-2 left-2 bg-[#C1440E] text-white text-[11px] px-2 py-0.5 rounded-full font-black shadow-md flex items-center gap-1">
                            <span>🛒</span>
                            <span id="badge-qty-{{ $product->id }}">1x</span>
                        </span>

                        @if($product->stock > 0)
                            <span class="absolute top-2 right-2 bg-emerald-600/90 text-white text-[10px] px-2 py-0.5 rounded-full font-bold shadow flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                <span id="card-stock-label-{{ $product->id }}">Stok: {{ $product->stock }}</span>
                            </span>
                        @else
                            <span class="absolute top-2 right-2 bg-rose-600 text-white text-[10px] px-2 py-0.5 rounded-full font-bold shadow">
                                Habis
                            </span>
                        @endif
                    </div>

                    <div class="p-3.5 flex-1 flex flex-col justify-between">
                        <div>
                            <span class="text-[10px] text-stone-400 uppercase tracking-wider font-bold">
                                {{ $product->category?->name ?? 'Menu' }}
                            </span>
                            <h4 class="font-bold text-stone-900 text-sm leading-snug line-clamp-2 mt-0.5 group-hover:text-[#C1440E] transition product-title">
                                {{ $product->name }}
                            </h4>
                        </div>

                        <div class="mt-3 flex items-center justify-between pt-2.5 border-t border-stone-100">
                            <span class="text-sm font-black text-[#C1440E]">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            <button type="button" class="w-7 h-7 rounded-lg {{ $isAvailable ? 'bg-stone-100 text-stone-700 group-hover:bg-[#C1440E] group-hover:text-white' : 'bg-stone-100 text-stone-400' }} flex items-center justify-center transition text-xs font-black shadow-sm">
                                +
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-dashed border-stone-300">
                    <div class="text-3xl mb-2">🍽️</div>
                    <p class="text-stone-500 text-sm font-medium">Belum ada produk yang berstatus tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- RIGHT COLUMN: CART & CHECKOUT PANEL --}}
    <div class="lg:col-span-5 xl:col-span-4 bg-white rounded-2xl shadow-sm border border-stone-200 p-5 space-y-4 sticky top-24">
        {{-- CART HEADER --}}
        <div class="flex items-center justify-between pb-3 border-b border-stone-200">
            <div class="flex items-center gap-2">
                <span class="text-xl">🛒</span>
                <div>
                    <h3 class="font-bold text-stone-900 text-base">Keranjang Kasir</h3>
                    <p class="text-xs text-stone-500">Kasir: {{ Auth::user()->name ?? 'Owner Yan\'s Food' }}</p>
                </div>
            </div>
            <button 
                type="button" 
                onclick="clearCart()" 
                id="btn-clear-cart"
                class="hidden text-xs text-rose-500 hover:text-rose-700 font-bold px-2 py-1 rounded-md hover:bg-rose-50 transition"
            >
                Kosongkan
            </button>
        </div>

        {{-- REAL-TIME WIB CLOCK --}}
        <div class="flex items-center justify-between p-2.5 rounded-xl bg-amber-50/70 border border-amber-200/60 text-xs">
            <div class="flex items-center gap-1.5 text-stone-700">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="font-bold text-[11px] text-stone-600">Waktu Real-Time:</span>
            </div>
            <div class="flex items-center gap-1.5 font-mono font-black text-stone-900 text-xs">
                <span id="pos-realtime-clock">--:--:--</span>
                <span class="px-1.5 py-0.5 bg-[#C1440E] text-white rounded text-[10px] font-bold">WIB</span>
            </div>
        </div>

        {{-- CART ITEMS LIST --}}
        <div id="cart-list" class="max-h-64 overflow-y-auto space-y-3 divide-y divide-stone-100 pr-1">
            <div id="cart-empty-state" class="py-10 text-center text-stone-400 text-xs">
                <div class="text-2xl mb-1">👈</div>
                Klik menu di sebelah kiri untuk menambah ke struk pesanan
            </div>
        </div>

        {{-- PAYMENT METHOD SELECTION --}}
        <div class="pt-3 border-t border-stone-200 space-y-2">
            <label class="block text-[11px] font-bold text-stone-500 uppercase tracking-wider">Metode Pembayaran</label>
            <div class="grid grid-cols-3 gap-2">
                <button 
                    type="button" 
                    onclick="setPaymentMethod('CASH')"
                    id="btn-method-cash"
                    class="method-btn py-2 px-3 rounded-xl font-bold text-xs flex flex-col items-center justify-center gap-1 transition bg-[#C1440E] text-white shadow-sm"
                >
                    <span>💵</span>
                    <span>Tunai</span>
                </button>
                <button 
                    type="button" 
                    onclick="setPaymentMethod('TRANSFER')"
                    id="btn-method-transfer"
                    class="method-btn py-2 px-3 rounded-xl font-bold text-xs flex flex-col items-center justify-center gap-1 transition bg-stone-100 text-stone-700 hover:bg-stone-200"
                >
                    <span>💳</span>
                    <span>Transfer</span>
                </button>
                <button 
                    type="button" 
                    onclick="setPaymentMethod('QRIS')"
                    id="btn-method-qris"
                    class="method-btn py-2 px-3 rounded-xl font-bold text-xs flex flex-col items-center justify-center gap-1 transition bg-stone-100 text-stone-700 hover:bg-stone-200"
                >
                    <span>📱</span>
                    <span>QRIS</span>
                </button>
            </div>
        </div>

        {{-- PAYMENT CALCULATION & BILLING --}}
        <div class="space-y-2.5 text-sm pt-2 border-t border-stone-200">
            <div class="flex justify-between text-stone-600 text-xs">
                <span>Subtotal</span>
                <span class="font-bold" id="label-subtotal">Rp 0</span>
            </div>

            <div class="flex items-center justify-between text-xs">
                <span class="text-stone-600">Diskon Transaksi (Rp)</span>
                <input 
                    type="number" 
                    id="input-discount"
                    min="0"
                    value="0"
                    oninput="recalculate()"
                    class="w-28 text-right py-1 px-2.5 rounded-lg border border-stone-300 bg-stone-50 text-xs font-bold focus:ring-1 focus:ring-[#C1440E]"
                >
            </div>

            <div class="flex justify-between items-center text-base font-black text-stone-900 pt-2 border-t border-stone-200">
                <span>TOTAL BAYAR</span>
                <span class="text-2xl font-black text-[#C1440E]" id="label-total">Rp 0</span>
            </div>

            {{-- CASH SHORTCUTS CONTAINER --}}
            <div id="cash-tender-container" class="pt-2">
                <label class="block text-[11px] font-bold text-stone-500 uppercase tracking-wider mb-1.5">Uang Diterima (Cash)</label>
                <div class="grid grid-cols-4 gap-1.5 mb-2">
                    <button type="button" onclick="setExactAmount()" class="py-1.5 px-2 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-lg text-[11px] font-bold transition">
                        Pas
                    </button>
                    <button type="button" onclick="setNominal(50000)" class="py-1.5 px-2 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-lg text-[11px] font-bold transition">
                        50.000
                    </button>
                    <button type="button" onclick="setNominal(100000)" class="py-1.5 px-2 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-lg text-[11px] font-bold transition">
                        100.000
                    </button>
                    <button type="button" onclick="setNominal(200000)" class="py-1.5 px-2 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-lg text-[11px] font-bold transition">
                        200.000
                    </button>
                </div>

                <div class="relative">
                    <span class="absolute left-3.5 top-2.5 text-stone-500 font-black text-sm">Rp</span>
                    <input 
                        type="number" 
                        id="input-amount-paid"
                        min="0"
                        placeholder="0"
                        oninput="recalculate()"
                        class="w-full pl-10 pr-3 py-2 text-right font-black text-lg rounded-xl border border-stone-300 bg-white text-stone-900 focus:ring-2 focus:ring-[#C1440E] transition"
                    >
                </div>
            </div>

            {{-- NON-CASH NOTE CONTAINER --}}
            <div id="non-cash-container" class="hidden p-3 bg-stone-50 rounded-xl border border-stone-200 text-xs">
                <span class="text-stone-500 font-medium">Pembayaran via:</span>
                <strong id="non-cash-title" class="text-stone-800 block text-sm mt-0.5">QRIS Standar</strong>
            </div>

            {{-- STATUS CALLOUT: KEMBALIAN VS KURANG --}}
            <div id="status-shortfall" class="hidden p-3 bg-rose-50 rounded-xl border border-rose-200 flex justify-between items-center animate-pulse">
                <span class="text-xs font-bold text-rose-800">⚠️ KURANG BAYAR</span>
                <span class="text-base font-black text-rose-600" id="label-shortfall">Rp 0</span>
            </div>

            <div id="status-change" class="p-3 bg-emerald-50 rounded-xl border border-emerald-200 flex justify-between items-center">
                <span class="text-xs font-bold text-emerald-800">KEMBALIAN</span>
                <span class="text-lg font-black text-emerald-600" id="label-change">Rp 0</span>
            </div>

            {{-- PROCESS BUTTON --}}
            <button 
                type="button" 
                id="btn-process"
                disabled
                onclick="submitTransaction()"
                class="w-full py-3.5 px-4 rounded-xl font-black text-white shadow-md transition flex items-center justify-center gap-2 bg-stone-300 cursor-not-allowed"
            >
                <span id="btn-process-text">⚡ SELESAIKAN TRANSAKSI (CASH)</span>
            </button>
        </div>
    </div>
</div>

{{-- RECEIPT MODAL --}}
<div id="receipt-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-stone-900/60 backdrop-blur-xs p-4">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-stone-200 overflow-hidden">
        <div class="p-4 bg-emerald-600 text-white flex justify-between items-center">
            <div class="flex items-center gap-2 font-bold text-sm">
                <span>✅</span>
                <span>Transaksi Kasir Berhasil Disimpan!</span>
            </div>
            <button type="button" onclick="closeReceiptModal()" class="text-white hover:text-stone-200 text-lg font-bold">✕</button>
        </div>

        <div class="p-4 max-h-[75vh] overflow-y-auto" id="receipt-modal-body">
            <!-- Thermal Receipt will be injected here -->
        </div>

        <div class="p-4 bg-stone-50 border-t border-stone-200 flex justify-end gap-3">
            <button 
                type="button" 
                onclick="window.print()" 
                class="px-4 py-2.5 bg-stone-900 hover:bg-black text-white font-bold rounded-xl text-xs shadow transition flex items-center gap-1.5"
            >
                <span>🖨️</span>
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

    window.filterCategory = function(catId, btn) {
        document.querySelectorAll('.category-btn').forEach(b => {
            b.className = 'category-btn px-3.5 py-1.5 rounded-xl font-bold whitespace-nowrap transition bg-stone-100 text-stone-700 hover:bg-stone-200';
        });
        btn.className = 'category-btn active px-3.5 py-1.5 rounded-xl font-bold whitespace-nowrap transition bg-[#C1440E] text-white shadow-sm';

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
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase().trim();
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
            window.cart[id] = { id, name, price, unit, qty: 1, stock: stock };
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
        if (discountInput) discountInput.value = 0;
        if (amountPaidInput) amountPaidInput.value = '';
        window.renderCart();
    };

    window.setPaymentMethod = function(method) {
        window.paymentMethod = method;
        document.querySelectorAll('.method-btn').forEach(b => {
            b.className = 'method-btn py-2 px-3 rounded-xl font-bold text-xs flex flex-col items-center justify-center gap-1 transition bg-stone-100 text-stone-700 hover:bg-stone-200';
        });

        const activeBtn = document.getElementById('btn-method-' + method.toLowerCase());
        if (activeBtn) {
            activeBtn.className = 'method-btn py-2 px-3 rounded-xl font-bold text-xs flex flex-col items-center justify-center gap-1 transition bg-[#C1440E] text-white shadow-sm';
        }

        const cashContainer = document.getElementById('cash-tender-container');
        const nonCashContainer = document.getElementById('non-cash-container');
        const nonCashTitle = document.getElementById('non-cash-title');

        if (method === 'CASH') {
            if (cashContainer) cashContainer.classList.remove('hidden');
            if (nonCashContainer) nonCashContainer.classList.add('hidden');
        } else {
            if (cashContainer) cashContainer.classList.add('hidden');
            if (nonCashContainer) nonCashContainer.classList.remove('hidden');
            if (nonCashTitle) {
                nonCashTitle.textContent = method === 'QRIS' ? 'QRIS Standar (BCA / GoPay / OVO / Dana / ShopeePay)' : 'Transfer Bank (BCA / Mandiri / BNI / BRI)';
            }
            window.setExactAmount();
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
                el.classList.add('border-[#C1440E]', 'shadow-sm', 'ring-1', 'ring-[#C1440E]');
            } else {
                if (badge) badge.classList.add('hidden');
                el.classList.remove('border-[#C1440E]', 'shadow-sm', 'ring-1', 'ring-[#C1440E]');
            }
        });

        if (keys.length === 0) {
            if (cartList) {
                cartList.innerHTML = `
                    <div id="cart-empty-state" class="py-10 text-center text-stone-400 text-xs">
                        <div class="text-2xl mb-1">👈</div>
                        Klik menu di sebelah kiri untuk menambah ke struk pesanan
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
                    <div class="pt-3 first:pt-0 flex items-center justify-between gap-3 text-sm">
                        <div class="flex-1 min-w-0">
                            <h5 class="font-bold text-stone-800 truncate text-xs">${item.name}</h5>
                            <span class="text-[11px] text-stone-500">${window.formatRupiah(item.price)} / ${item.unit}</span>
                        </div>

                        <div class="flex items-center gap-1.5 bg-stone-50 p-1 rounded-lg border border-stone-200">
                            <button type="button" onclick="updateCartQty(${id}, -1)" class="w-6 h-6 rounded bg-white text-stone-700 hover:bg-stone-200 text-xs font-black shadow-xs transition">-</button>
                            <span class="font-black w-6 text-center text-xs text-stone-900">${item.qty}</span>
                            <button type="button" onclick="updateCartQty(${id}, 1)" class="w-6 h-6 rounded bg-white text-stone-700 hover:bg-stone-200 text-xs font-black shadow-xs transition">+</button>
                        </div>

                        <div class="text-right min-w-[70px]">
                            <span class="font-bold text-stone-900 text-xs">${window.formatRupiah(item.price * item.qty)}</span>
                        </div>
                    </div>
                `;
            }
            if (cartList) cartList.innerHTML = html;
        }

        if (window.paymentMethod !== 'CASH') {
            window.setExactAmount();
        } else {
            window.recalculate();
        }
    };

    window.recalculate = function() {
        const subtotal = window.calculateSubtotal();
        const total = window.calculateTotal();
        const amountPaidInput = document.getElementById('input-amount-paid');
        let amountPaid = parseFloat(amountPaidInput ? amountPaidInput.value : 0) || 0;

        if (window.paymentMethod !== 'CASH') {
            amountPaid = total;
            if (amountPaidInput && total > 0) amountPaidInput.value = total;
        }

        const labelSubtotal = document.getElementById('label-subtotal');
        const labelTotal = document.getElementById('label-total');
        if (labelSubtotal) labelSubtotal.textContent = window.formatRupiah(subtotal);
        if (labelTotal) labelTotal.textContent = window.formatRupiah(total);

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

        if (btnProcessText) {
            btnProcessText.textContent = `⚡ SELESAIKAN TRANSAKSI (${window.paymentMethod})`;
        }

        if (amountPaid < total && total > 0 && window.paymentMethod === 'CASH') {
            if (statusShortfall) statusShortfall.classList.remove('hidden');
            if (statusChange) statusChange.classList.add('hidden');
        } else {
            if (statusShortfall) statusShortfall.classList.add('hidden');
            if (statusChange) statusChange.classList.remove('hidden');
        }

        const hasItems = Object.keys(window.cart).length > 0;
        const isPaidEnough = (amountPaid >= total && total > 0) || (window.paymentMethod !== 'CASH' && total > 0);

        if (btnProcess) {
            if (hasItems && isPaidEnough) {
                btnProcess.disabled = false;
                btnProcess.className = 'w-full py-3.5 px-4 rounded-xl font-black text-white shadow-md transition flex items-center justify-center gap-2 bg-[#C1440E] hover:bg-[#a3380b] active:scale-[0.99] cursor-pointer';
            } else {
                btnProcess.disabled = true;
                btnProcess.className = 'w-full py-3.5 px-4 rounded-xl font-black text-white shadow-md transition flex items-center justify-center gap-2 bg-stone-300 cursor-not-allowed';
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

        const subtotal = window.calculateSubtotal();
        const total = window.calculateTotal();
        const discountInput = document.getElementById('input-discount');
        const discount = Math.max(0, parseFloat(discountInput ? discountInput.value : 0) || 0);
        const amountPaidInput = document.getElementById('input-amount-paid');
        let amountPaid = parseFloat(amountPaidInput ? amountPaidInput.value : 0) || 0;

        if (window.paymentMethod !== 'CASH') {
            amountPaid = total;
        }

        if (window.paymentMethod === 'CASH' && amountPaid < total) {
            alert('Uang pembayaran tunai masih kurang dari total belanja.');
            return;
        }

        const btnProcess = document.getElementById('btn-process');
        if (btnProcess) {
            btnProcess.disabled = true;
            btnProcess.innerHTML = `<span class="flex items-center gap-2">⏳ Menyimpan Transaksi...</span>`;
        }

        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

        fetch("{{ route('admin.pos.checkout') }}", {
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
                payment_method: window.paymentMethod
            })
        })
        .then(async (res) => {
            const data = await res.json();
            if (!res.ok) {
                throw new Error(data.message || 'Gagal menyimpan transaksi.');
            }
            return data;
        })
        .then(data => {
            if (btnProcess) {
                btnProcess.disabled = false;
                btnProcess.innerHTML = `<span id="btn-process-text">⚡ SELESAIKAN TRANSAKSI (${window.paymentMethod})</span>`;
            }

            if (data.success) {
                // Kurangi stok di katalog secara langsung tanpa reload
                items.forEach(it => {
                    const card = document.getElementById('product-card-' + it.product_id);
                    if (card) {
                        const currentStock = parseInt(card.getAttribute('data-stock') || '0', 10);
                        const newStock = Math.max(0, currentStock - it.quantity);
                        card.setAttribute('data-stock', newStock);

                        const stockLabel = document.getElementById('card-stock-label-' + it.product_id);
                        if (stockLabel) stockLabel.textContent = 'Stok: ' + newStock;

                        if (newStock <= 0) {
                            card.classList.remove('cursor-pointer', 'hover:border-[#C1440E]/60', 'hover:shadow-lg', 'active:scale-[0.99]');
                            card.classList.add('opacity-60', 'cursor-not-allowed');
                        }
                    }
                });

                window.clearCart();
                window.showReceiptModal(data.receipt);
            } else {
                alert('Gagal: ' + data.message);
            }
        })
        .catch(err => {
            if (btnProcess) {
                btnProcess.disabled = false;
                btnProcess.innerHTML = `<span id="btn-process-text">⚡ SELESAIKAN TRANSAKSI (${window.paymentMethod})</span>`;
            }
            alert('Kesalahan Transaksi: ' + err.message);
        });
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

    // Live Real-Time WIB Clock (Asia/Jakarta)
    function updatePosRealtimeClock() {
        const clockEl = document.getElementById('pos-realtime-clock');
        if (!clockEl) return;
        try {
            const now = new Date();
            const timeString = new Intl.DateTimeFormat('id-ID', {
                timeZone: 'Asia/Jakarta',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            }).format(now);
            clockEl.textContent = timeString;
        } catch (e) {
            const now = new Date();
            clockEl.textContent = now.toTimeString().split(' ')[0];
        }
    }
    updatePosRealtimeClock();
    setInterval(updatePosRealtimeClock, 1000);
</script>
@endpush
