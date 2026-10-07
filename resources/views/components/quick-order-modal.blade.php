<!-- Quick Order Modal -->
<div id="quickOrderModal" 
     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-inverse-surface/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
    
    <div class="relative w-full max-w-lg rounded-2xl bg-surface-warm p-6 sm:p-8 shadow-2xl border border-surface-variant/40 transform scale-95 transition-transform duration-300 max-h-[90vh] overflow-y-auto">
        <!-- Close Button -->
        <button type="button" 
                onclick="closeQuickOrder()" 
                class="absolute top-4 right-4 w-9 h-9 rounded-full bg-surface-container flex items-center justify-center text-on-surface hover:bg-surface-variant transition-colors">
            <span class="material-symbols-outlined text-[20px]">close</span>
        </button>

        <div class="space-y-6">
            <!-- Modal Header / Product Preview -->
            <div class="flex gap-4 items-start">
                <img id="modalProductImage" 
                     src="" 
                     alt="" 
                     class="w-20 h-20 rounded-xl object-cover bg-surface-container shrink-0">
                <div class="space-y-1">
                    <span id="modalProductCategory" class="px-2.5 py-0.5 rounded-full bg-surface-container text-on-surface font-label-sm text-xs font-semibold"></span>
                    <h3 id="modalProductTitle" class="font-headline-sm text-on-surface text-xl font-serif"></h3>
                    <p id="modalProductPrice" class="font-numeric-currency text-primary-container text-lg font-bold"></p>
                </div>
            </div>

            <p id="modalProductDesc" class="font-body-sm text-secondary leading-relaxed"></p>

            <!-- Quantity Modifier -->
            <div class="p-4 rounded-xl bg-cream-bg flex items-center justify-between">
                <div>
                    <span class="font-label-md text-on-surface block font-semibold">Jumlah Pesanan</span>
                    <span class="font-body-sm text-secondary text-xs">Porsi / pcs</span>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" 
                            onclick="changeModalQty(-1)" 
                            class="w-9 h-9 rounded-lg bg-surface-warm shadow-sm flex items-center justify-center text-on-surface hover:bg-surface-container-high transition-colors active:scale-95">
                        <span class="material-symbols-outlined text-[18px]">remove</span>
                    </button>
                    <span id="modalQtyDisplay" class="font-numeric-currency text-on-surface text-lg font-bold w-8 text-center">1</span>
                    <button type="button" 
                            onclick="changeModalQty(1)" 
                            class="w-9 h-9 rounded-lg bg-surface-warm shadow-sm flex items-center justify-center text-on-surface hover:bg-surface-container-high transition-colors active:scale-95">
                        <span class="material-symbols-outlined text-[18px]">add</span>
                    </button>
                </div>
            </div>

            <!-- Catatan Khusus -->
            <div class="space-y-2">
                <label for="modalNotes" class="block font-label-sm text-on-surface font-semibold text-xs">Catatan Pesanan (Opsional)</label>
                <input type="text" 
                       id="modalNotes" 
                       placeholder="Misal: Sambal dipisah, goreng agak kering..." 
                       class="w-full px-3.5 py-2.5 rounded-lg bg-cream-bg text-on-surface font-body-sm border border-surface-variant/60 focus:outline-none focus:border-primary-container">
            </div>

            <!-- Total Price Calculation -->
            <div class="flex items-center justify-between pt-2 border-t border-surface-variant/40">
                <span class="font-label-md text-secondary">Estimasi Total:</span>
                <span id="modalTotalPrice" class="font-numeric-currency text-primary-container text-2xl font-bold"></span>
            </div>

            <!-- Action Buttons -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                <button type="button" 
                        onclick="confirmAddToCart()" 
                        class="w-full py-3 px-4 rounded-xl bg-surface-container hover:bg-surface-container-high text-on-surface font-label-md flex items-center justify-center gap-2 transition-colors">
                    <span class="material-symbols-outlined text-[18px]">shopping_bag</span>
                    <span>Masuk Keranjang</span>
                </button>
                <button type="button" 
                        onclick="confirmOrderToWhatsApp()" 
                        class="w-full py-3 px-4 rounded-xl bg-primary-container hover:bg-primary-dark text-on-primary font-label-md flex items-center justify-center gap-2 shadow-md transition-colors active:scale-95">
                    <span class="material-symbols-outlined text-[18px]">chat</span>
                    <span>Pesan via WA</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let activeProduct = {
        title: '',
        price: 0,
        priceFormatted: '',
        category: '',
        desc: '',
        image: '',
        qty: 1
    };

    function parseNumericPrice(priceStr) {
        if (typeof priceStr === 'number') return priceStr;
        return parseInt(priceStr.replace(/[^0-9]/g, ''), 10) || 0;
    }

    function formatRupiah(num) {
        return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function openQuickOrder(title, price, category, desc, image) {
        activeProduct = {
            title,
            price: parseNumericPrice(price),
            priceFormatted: price,
            category,
            desc,
            image: image || '',
            qty: 1
        };

        document.getElementById('modalProductTitle').textContent = title;
        document.getElementById('modalProductCategory').textContent = category;
        document.getElementById('modalProductDesc').textContent = desc;
        document.getElementById('modalProductPrice').textContent = 'Rp ' + price;
        document.getElementById('modalProductImage').src = activeProduct.image;
        document.getElementById('modalProductImage').alt = title;
        document.getElementById('modalQtyDisplay').textContent = '1';
        document.getElementById('modalNotes').value = '';
        updateModalTotal();

        const modal = document.getElementById('quickOrderModal');
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.firstElementChild.classList.remove('scale-95');
        modal.firstElementChild.classList.add('scale-100');
    }

    function closeQuickOrder() {
        const modal = document.getElementById('quickOrderModal');
        modal.classList.add('opacity-0', 'pointer-events-none');
        modal.firstElementChild.classList.remove('scale-100');
        modal.firstElementChild.classList.add('scale-95');
    }

    function changeModalQty(delta) {
        activeProduct.qty = Math.max(1, activeProduct.qty + delta);
        document.getElementById('modalQtyDisplay').textContent = activeProduct.qty;
        updateModalTotal();
    }

    function updateModalTotal() {
        const total = activeProduct.price * activeProduct.qty;
        document.getElementById('modalTotalPrice').textContent = formatRupiah(total);
    }

    function confirmAddToCart() {
        const notes = document.getElementById('modalNotes').value.trim();
        for (let i = 0; i < activeProduct.qty; i++) {
            addToCart(activeProduct.title, activeProduct.price, activeProduct.category);
        }
        closeQuickOrder();
    }

    function confirmOrderToWhatsApp() {
        const notes = document.getElementById('modalNotes').value.trim();
        const total = activeProduct.price * activeProduct.qty;
        const adminWA = "6281234567890";

        const text = `Halo Admin Yan's Food, saya ingin memesan menu harian:\n\n` +
            `• Menu: *${activeProduct.title}*\n` +
            `• Kategori: ${activeProduct.category}\n` +
            `• Jumlah: ${activeProduct.qty} porsi/pcs\n` +
            `• Estimasi Total: ${formatRupiah(total)}\n` +
            (notes ? `• Catatan: ${notes}\n\n` : `\n`) +
            `Mohon info ketersediaan dan ongkos kirim ke alamat saya. Terima kasih!`;

        const encodedUrl = `https://wa.me/${adminWA}?text=${encodeURIComponent(text)}`;
        closeQuickOrder();
        window.open(encodedUrl, '_blank');
    }
</script>
