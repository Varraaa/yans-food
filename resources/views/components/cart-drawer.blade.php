{{-- 
    Yan's Food - Modular Keranjang & Kasir Drawer (Cart / Cashier Slide-over Drawer)
    Mengikuti acuan DESIGN.md & Google Stitch:
    - Slide-over panel dari kanan dengan animasi transisi halus
    - Ringkasan daftar pesanan real-time dari localStorage ('yans_cart')
    - Pengaturan jumlah (+/-) & hapus item
    - Kalkulasi Subtotal & Total
    - Form opsi: Nama Pemesan, Metode (Bungkus/Makan di Tempat/Antar), Catatan
    - Tombol Checkout langsung ke WhatsApp format rapi & terstruktur
--}}

<div id="cart-drawer-backdrop" 
     class="fixed inset-0 z-50 bg-charcoal/40 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 ease-in-out"
     onclick="toggleCartDrawer(false)">
</div>

<aside id="cart-drawer-panel" 
       aria-label="Keranjang dan Kasir Pesanan"
       class="fixed top-0 right-0 bottom-0 z-50 w-full max-w-full sm:max-w-md bg-surface-warm shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col border-l border-surface-variant/30">
    
    <!-- Drawer Header -->
    <div class="h-20 px-6 bg-cream-bg/95 border-b border-surface-variant/40 flex items-center justify-between shrink-0">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary-fixed/50 flex items-center justify-center text-primary-dark">
                <span class="material-symbols-outlined text-[22px]">shopping_bag</span>
            </div>
            <div>
                <h2 class="font-headline-sm text-lg font-bold text-on-surface">Keranjang & Kasir</h2>
                <p id="cart-items-count-text" class="font-body-sm text-xs text-on-surface-variant">0 item dipilih</p>
            </div>
        </div>

        <button type="button" 
                onclick="toggleCartDrawer(false)"
                aria-label="Tutup Keranjang"
                class="w-10 h-10 rounded-xl flex items-center justify-center text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors">
            <span class="material-symbols-outlined text-[24px]">close</span>
        </button>
    </div>

    <!-- Drawer Content / Items List -->
    <div id="cart-items-container" class="flex-1 overflow-y-auto px-6 py-4 space-y-4">
        <!-- Rendered dynamically by JavaScript -->
    </div>

    <!-- Empty State Container -->
    <div id="cart-empty-state" class="hidden flex-1 flex flex-col items-center justify-center p-8 text-center space-y-4">
        <div class="w-20 h-20 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant">
            <span class="material-symbols-outlined text-[40px] text-muted-gray">production_quantity_limits</span>
        </div>
        <div class="space-y-1">
            <h3 class="font-headline-sm text-lg font-semibold text-on-surface">Keranjang Masih Kosong</h3>
            <p class="font-body-sm text-xs text-on-surface-variant max-w-xs">
                Pilih menu lezat favorit Anda dari katalog untuk mulai memesan atau makan di tempat.
            </p>
        </div>
        <a href="{{ url('/menu') }}" 
           onclick="toggleCartDrawer(false)"
           class="inline-flex items-center gap-2 font-label-md px-5 py-2.5 rounded-xl bg-primary-container text-on-primary hover:bg-primary-dark transition-colors shadow-sm text-sm">
            <span class="material-symbols-outlined text-[18px]">restaurant_menu</span>
            <span>Jelajahi Menu</span>
        </a>
    </div>

    <!-- Drawer Footer / Checkout Section -->
    <div id="cart-checkout-footer" class="p-6 bg-cream-bg/95 border-t border-surface-variant/40 space-y-4 shrink-0">
        <!-- Form Informasi Pemesan -->
        <div class="space-y-2.5">
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block font-label-sm text-[11px] text-on-surface-variant uppercase mb-1">Nama Pemesan</label>
                    <input type="text" 
                           id="cart-customer-name" 
                           placeholder="Nama Anda"
                           class="w-full px-3 py-1.5 text-xs rounded-lg border border-surface-variant bg-surface-warm focus:outline-none focus:border-primary text-on-surface">
                </div>
                <div>
                    <label class="block font-label-sm text-[11px] text-on-surface-variant uppercase mb-1">Jenis Pesanan</label>
                    <select id="cart-order-type" 
                            class="w-full px-2 py-1.5 text-xs rounded-lg border border-surface-variant bg-surface-warm focus:outline-none focus:border-primary text-on-surface">
                        <option value="Bungkus / Takeaway">Bungkus (Takeaway)</option>
                        <option value="Makan di Tempat">Makan di Tempat</option>
                        <option value="Pesan Antar / Delivery">Pesan Antar (Delivery)</option>
                    </select>
                </div>
            </div>
            <div>
                <input type="text" 
                       id="cart-order-notes" 
                       placeholder="Catatan (misal: sambal dipisah, meja 3)"
                       class="w-full px-3 py-1.5 text-xs rounded-lg border border-surface-variant bg-surface-warm focus:outline-none focus:border-primary text-on-surface">
            </div>
        </div>

        <!-- Rincian Biaya -->
        <div class="space-y-1.5 pt-2 border-t border-surface-variant/30 text-xs">
            <div class="flex justify-between items-center text-on-surface-variant">
                <span>Subtotal Pesanan</span>
                <span id="cart-subtotal-text" class="font-medium text-on-surface">Rp 0</span>
            </div>
            <div class="flex justify-between items-center text-on-surface-variant">
                <span>Biaya Kemasan & Layanan</span>
                <span class="font-medium text-success-available">Gratis</span>
            </div>
            <div class="flex justify-between items-center text-sm font-bold text-on-surface pt-1 border-t border-surface-variant/20">
                <span>Total Pembayaran</span>
                <span id="cart-total-text" class="text-primary-dark font-numeric-currency text-base">Rp 0</span>
            </div>
        </div>

        <!-- Tombol Aksi Kasir -->
        <div class="space-y-2">
            <button type="button" 
                    onclick="proceedCartCheckoutWhatsApp()"
                    class="w-full min-h-[46px] px-4 py-3 rounded-xl bg-primary-container text-on-primary hover:bg-primary-dark font-label-md flex items-center justify-center gap-2 transition-all duration-200 shadow-md">
                <span class="material-symbols-outlined text-[20px]">chat</span>
                <span>Kirim Pesanan ke WhatsApp</span>
            </button>
            <div class="flex items-center justify-between text-xs px-1 text-on-surface-variant">
                <button type="button" onclick="clearCart()" class="hover:text-danger-error transition-colors flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">delete</span>
                    <span>Kosongkan</span>
                </button>
                <span class="text-[11px] text-muted-gray">Proses cepat & tanpa antre</span>
            </div>
        </div>
    </div>
</aside>

<script>
    function toggleCartDrawer(open = true) {
        const backdrop = document.getElementById('cart-drawer-backdrop');
        const panel = document.getElementById('cart-drawer-panel');
        if (!backdrop || !panel) return;

        if (open) {
            renderCartItems();
            backdrop.classList.remove('opacity-0', 'pointer-events-none');
            panel.classList.remove('translate-x-full');
            document.body.classList.add('overflow-hidden');
        } else {
            backdrop.classList.add('opacity-0', 'pointer-events-none');
            panel.classList.add('translate-x-full');
            document.body.classList.remove('overflow-hidden');
        }
    }

    function getCart() {
        return JSON.parse(localStorage.getItem('yans_cart') || '[]');
    }

    function saveCart(cart) {
        localStorage.setItem('yans_cart', JSON.stringify(cart));
        updateCartBadge();
        renderCartItems();
    }

    function updateCartBadge() {
        const cart = getCart();
        const totalCount = cart.reduce((acc, item) => acc + (item.qty || 1), 0);
        
        document.querySelectorAll('.cart-badge-count').forEach(el => {
            el.textContent = totalCount;
            if (totalCount > 0) {
                el.classList.remove('hidden');
            } else {
                el.classList.add('hidden');
            }
        });

        const countText = document.getElementById('cart-items-count-text');
        if (countText) {
            countText.textContent = `${totalCount} item dipilih`;
        }
    }

    function updateCartItemQty(index, delta) {
        const cart = getCart();
        if (!cart[index]) return;

        cart[index].qty += delta;
        if (cart[index].qty <= 0) {
            cart.splice(index, 1);
        }
        saveCart(cart);
    }

    function removeCartItem(index) {
        const cart = getCart();
        cart.splice(index, 1);
        saveCart(cart);
    }

    function clearCart() {
        if (confirm('Kosongkan semua pesanan dari keranjang?')) {
            localStorage.removeItem('yans_cart');
            updateCartBadge();
            renderCartItems();
            if (typeof showToast === 'function') {
                showToast('Keranjang telah dikosongkan');
            }
        }
    }

    function formatRupiah(num) {
        return 'Rp ' + Number(num).toLocaleString('id-ID');
    }

    function parseNumericPrice(priceStr) {
        if (typeof priceStr === 'number') return priceStr;
        const cleaned = String(priceStr).replace(/[^0-9]/g, '');
        return parseInt(cleaned, 10) || 0;
    }

    function renderCartItems() {
        const cart = getCart();
        const container = document.getElementById('cart-items-container');
        const emptyState = document.getElementById('cart-empty-state');
        const footer = document.getElementById('cart-checkout-footer');
        const subtotalEl = document.getElementById('cart-subtotal-text');
        const totalEl = document.getElementById('cart-total-text');

        if (!container || !emptyState || !footer) return;

        if (cart.length === 0) {
            container.classList.add('hidden');
            emptyState.classList.remove('hidden');
            footer.classList.add('hidden');
            return;
        }

        container.classList.remove('hidden');
        emptyState.classList.add('hidden');
        footer.classList.remove('hidden');

        let subtotal = 0;
        let html = '';

        cart.forEach((item, index) => {
            const numericPrice = parseNumericPrice(item.price);
            const itemTotal = numericPrice * (item.qty || 1);
            subtotal += itemTotal;

            html += `
                <div class="bg-surface-warm p-3.5 rounded-xl border border-surface-variant/40 flex items-center justify-between gap-3 shadow-xs">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-1.5 mb-0.5">
                            <span class="font-label-sm text-[10px] uppercase px-1.5 py-0.5 rounded bg-surface-container text-on-surface-variant">${item.category || 'Menu'}</span>
                        </div>
                        <h4 class="font-headline-sm text-sm font-bold text-on-surface truncate">${item.title}</h4>
                        <p class="font-body-sm text-xs font-semibold text-primary">${item.price}</p>
                    </div>

                    <!-- Quantity Control -->
                    <div class="flex items-center gap-2">
                        <div class="flex items-center bg-cream-bg rounded-lg border border-surface-variant/60 p-0.5">
                            <button type="button" 
                                    onclick="updateCartItemQty(${index}, -1)"
                                    aria-label="Kurangi"
                                    class="w-7 h-7 flex items-center justify-center rounded text-on-surface hover:bg-surface-container">
                                <span class="material-symbols-outlined text-[16px]">remove</span>
                            </button>
                            <span class="w-7 text-center font-bold text-xs text-on-surface font-mono">${item.qty || 1}</span>
                            <button type="button" 
                                    onclick="updateCartItemQty(${index}, 1)"
                                    aria-label="Tambah"
                                    class="w-7 h-7 flex items-center justify-center rounded text-on-surface hover:bg-surface-container">
                                <span class="material-symbols-outlined text-[16px]">add</span>
                            </button>
                        </div>
                        
                        <button type="button" 
                                onclick="removeCartItem(${index})"
                                aria-label="Hapus Item"
                                class="w-8 h-8 flex items-center justify-center text-muted-gray hover:text-danger-error transition-colors">
                            <span class="material-symbols-outlined text-[18px]">delete_outline</span>
                        </button>
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;
        if (subtotalEl) subtotalEl.textContent = formatRupiah(subtotal);
        if (totalEl) totalEl.textContent = formatRupiah(subtotal);
    }

    function proceedCartCheckoutWhatsApp() {
        const cart = getCart();
        if (cart.length === 0) return;

        const customerName = document.getElementById('cart-customer-name')?.value.trim() || 'Pelanggan';
        const orderType = document.getElementById('cart-order-type')?.value || 'Bungkus / Takeaway';
        const orderNotes = document.getElementById('cart-order-notes')?.value.trim() || '-';

        let subtotal = 0;
        let itemsListText = '';

        cart.forEach((item, index) => {
            const numericPrice = parseNumericPrice(item.price);
            const itemTotal = numericPrice * (item.qty || 1);
            subtotal += itemTotal;
            itemsListText += `${index + 1}. ${item.title} (${item.qty}x) = ${formatRupiah(itemTotal)}\n`;
        });

        const message = 
`*PESANAN YAN'S FOOD* 🍽️
===========================
*Nama:* ${customerName}
*Jenis Pesanan:* ${orderType}
*Catatan:* ${orderNotes}

*Daftar Menu:*
${itemsListText}
===========================
*TOTAL:* ${formatRupiah(subtotal)}

Halo Admin Yan's Food, saya ingin mengonfirmasi pesanan di atas. Mohon info estimasi waktu dan pembayarannya. Terima kasih! 🙏`;

        const encodedMessage = encodeURIComponent(message);
        window.open(`https://wa.me/6281234567890?text=${encodedMessage}`, '_blank');
    }

    // Inisialisasi badge saat halaman dimuat
    document.addEventListener('DOMContentLoaded', () => {
        updateCartBadge();
    });
</script>
