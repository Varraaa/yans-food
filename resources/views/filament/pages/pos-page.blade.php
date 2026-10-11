<x-filament-panels::page>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        {{-- LEFT COLUMN: PRODUCT SELECTION --}}
        <div class="lg:col-span-7 xl:col-span-8 space-y-4">
            {{-- SEARCH & FILTER BAR --}}
            <div class="bg-white dark:bg-stone-900 p-4 rounded-xl shadow-sm border border-stone-200 dark:border-stone-800 space-y-3">
                <div class="relative">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="searchQuery"
                        placeholder="🔍 Cari produk (Nasi Box, Ayam Bakar, Es Teh...)" 
                        class="w-full pl-4 pr-10 py-2.5 rounded-lg border border-stone-300 dark:border-stone-700 bg-stone-50 dark:bg-stone-800 text-stone-900 dark:text-stone-100 text-sm focus:ring-2 focus:ring-[#C1440E] focus:outline-none"
                    >
                </div>

                {{-- CATEGORY PILLS --}}
                <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs">
                    <button 
                        type="button"
                        wire:click="$set('selectedCategoryId', null)"
                        class="px-3 py-1.5 rounded-full font-medium whitespace-nowrap transition {{ is_null($selectedCategoryId) ? 'bg-[#C1440E] text-white shadow-sm' : 'bg-stone-100 dark:bg-stone-800 text-stone-700 dark:text-stone-300 hover:bg-stone-200 dark:hover:bg-stone-700' }}"
                    >
                        Semua Menu
                    </button>
                    @foreach($categories as $category)
                        <button 
                            type="button"
                            wire:click="$set('selectedCategoryId', {{ $category->id }})"
                            class="px-3 py-1.5 rounded-full font-medium whitespace-nowrap transition {{ $selectedCategoryId === $category->id ? 'bg-[#C1440E] text-white shadow-sm' : 'bg-stone-100 dark:bg-stone-800 text-stone-700 dark:text-stone-300 hover:bg-stone-200 dark:hover:bg-stone-700' }}"
                        >
                            {{ $category->name }} ({{ $category->products_count }})
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- PRODUCTS GRID --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
                @forelse($products as $product)
                    <div 
                        wire:key="product-{{ $product->id }}"
                        wire:click="addToCart({{ $product->id }})"
                        class="group cursor-pointer bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-xl overflow-hidden hover:shadow-md hover:border-[#C1440E]/50 transition-all flex flex-col justify-between"
                    >
                        <div class="relative aspect-video bg-stone-100 dark:bg-stone-800 overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" onerror="this.src='/images/logo.png'">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-stone-400 font-bold text-xs">
                                    {{ $product->name }}
                                </div>
                            @endif
                            <span class="absolute top-2 right-2 bg-emerald-500/90 text-white text-[10px] px-2 py-0.5 rounded-full font-semibold shadow">
                                Sedia
                            </span>
                        </div>

                        <div class="p-3 flex-1 flex flex-col justify-between">
                            <div>
                                <span class="text-[10px] text-stone-500 dark:text-stone-400 uppercase tracking-wider font-semibold">
                                    {{ $product->category?->name ?? 'Menu' }}
                                </span>
                                <h4 class="font-bold text-stone-900 dark:text-stone-100 text-sm leading-snug line-clamp-2 mt-0.5">
                                    {{ $product->name }}
                                </h4>
                            </div>

                            <div class="mt-3 flex items-center justify-between pt-2 border-t border-stone-100 dark:border-stone-800">
                                <span class="text-sm font-extrabold text-[#C1440E]">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                                <button type="button" class="w-7 h-7 rounded-full bg-stone-100 dark:bg-stone-800 text-stone-700 dark:text-stone-200 group-hover:bg-[#C1440E] group-hover:text-white flex items-center justify-center transition text-xs font-bold shadow-sm">
                                    +
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center bg-white dark:bg-stone-900 rounded-xl border border-dashed border-stone-300 dark:border-stone-800">
                        <p class="text-stone-500 dark:text-stone-400 text-sm">Tidak ada produk yang cocok dengan pencarian.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- RIGHT COLUMN: CART & CHECKOUT PANEL --}}
        <div class="lg:col-span-5 xl:col-span-4 bg-white dark:bg-stone-900 rounded-2xl shadow-sm border border-stone-200 dark:border-stone-800 p-5 space-y-4 sticky top-4">
            <div class="flex items-center justify-between pb-3 border-b border-stone-200 dark:border-stone-800">
                <div class="flex items-center gap-2">
                    <span class="text-xl">🛒</span>
                    <div>
                        <h3 class="font-bold text-stone-900 dark:text-stone-100 text-base">Pesanan Aktif</h3>
                        <p class="text-xs text-stone-500">Kasir: {{ auth()->user()->name ?? 'Kasir' }}</p>
                    </div>
                </div>
                @if(count($cart) > 0)
                    <button 
                        type="button" 
                        wire:click="clearCart" 
                        class="text-xs text-rose-500 hover:text-rose-700 font-medium"
                    >
                        Kosongkan
                    </button>
                @endif
            </div>

            {{-- CART ITEMS LIST --}}
            <div class="max-h-72 overflow-y-auto space-y-3 divide-y divide-stone-100 dark:divide-stone-800 pr-1">
                @forelse($cart as $id => $item)
                    <div wire:key="cart-item-{{ $id }}" class="pt-3 first:pt-0 flex items-center justify-between gap-3 text-sm">
                        <div class="flex-1 min-w-0">
                            <h5 class="font-semibold text-stone-800 dark:text-stone-200 truncate">{{ $item['name'] }}</h5>
                            <span class="text-xs text-stone-500">Rp {{ number_format($item['price'], 0, ',', '.') }} / {{ $item['unit'] }}</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <button 
                                type="button" 
                                wire:click="updateQuantity({{ $id }}, {{ $item['quantity'] - 1 }})"
                                class="w-6 h-6 rounded bg-stone-100 dark:bg-stone-800 text-stone-700 dark:text-stone-300 hover:bg-stone-200 text-xs font-bold"
                            >
                                -
                            </button>
                            <span class="font-bold w-5 text-center text-xs text-stone-900 dark:text-stone-100">{{ $item['quantity'] }}</span>
                            <button 
                                type="button" 
                                wire:click="updateQuantity({{ $id }}, {{ $item['quantity'] + 1 }})"
                                class="w-6 h-6 rounded bg-stone-100 dark:bg-stone-800 text-stone-700 dark:text-stone-300 hover:bg-stone-200 text-xs font-bold"
                            >
                                +
                            </button>
                        </div>

                        <div class="text-right min-w-[70px]">
                            <span class="font-bold text-stone-900 dark:text-stone-100 text-xs">
                                Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-stone-400 text-xs">
                        Pilih produk di sebelah kiri untuk menambahkan ke pesanan
                    </div>
                @endforelse
            </div>

            {{-- PAYMENT CALCULATION --}}
            <div class="pt-3 border-t border-stone-200 dark:border-stone-800 space-y-2 text-sm">
                <div class="flex justify-between text-stone-600 dark:text-stone-400 text-xs">
                    <span>Subtotal</span>
                    <span class="font-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <span class="text-stone-600 dark:text-stone-400">Diskon (Rp)</span>
                    <input 
                        type="number" 
                        wire:model.live.debounce.300ms="discount"
                        min="0"
                        class="w-24 text-right py-1 px-2 rounded border border-stone-300 dark:border-stone-700 bg-stone-50 dark:bg-stone-800 text-xs focus:ring-1 focus:ring-[#C1440E]"
                    >
                </div>

                <div class="flex justify-between items-center text-base font-extrabold text-stone-900 dark:text-stone-100 pt-2 border-t border-stone-200 dark:border-stone-800">
                    <span>TOTAL BAYAR</span>
                    <span class="text-xl text-[#C1440E]">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>

                {{-- QUICK CASH SHORTCUTS --}}
                <div class="pt-2">
                    <label class="block text-[11px] font-semibold text-stone-500 uppercase tracking-wider mb-1.5">Uang Diterima (Cash)</label>
                    <div class="grid grid-cols-4 gap-1.5 mb-2">
                        <button type="button" wire:click="setExactPayment" class="py-1 px-2 bg-stone-100 dark:bg-stone-800 hover:bg-stone-200 text-stone-700 dark:text-stone-300 rounded text-xs font-semibold">
                            Uang Pas
                        </button>
                        <button type="button" wire:click="setNominal(50000)" class="py-1 px-2 bg-stone-100 dark:bg-stone-800 hover:bg-stone-200 text-stone-700 dark:text-stone-300 rounded text-xs font-semibold">
                            50.000
                        </button>
                        <button type="button" wire:click="setNominal(100000)" class="py-1 px-2 bg-stone-100 dark:bg-stone-800 hover:bg-stone-200 text-stone-700 dark:text-stone-300 rounded text-xs font-semibold">
                            100.000
                        </button>
                        <button type="button" wire:click="setNominal(200000)" class="py-1 px-2 bg-stone-100 dark:bg-stone-800 hover:bg-stone-200 text-stone-700 dark:text-stone-300 rounded text-xs font-semibold">
                            200.000
                        </button>
                    </div>

                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-stone-500 font-bold text-sm">Rp</span>
                        <input 
                            type="number" 
                            wire:model.live.debounce.300ms="amountPaid"
                            min="0"
                            placeholder="0"
                            class="w-full pl-10 pr-3 py-2 text-right font-bold text-lg rounded-lg border border-stone-300 dark:border-stone-700 bg-white dark:bg-stone-800 text-stone-900 dark:text-stone-100 focus:ring-2 focus:ring-[#C1440E]"
                        >
                    </div>
                </div>

                {{-- KEMBALIAN DISPLAY --}}
                <div class="p-3 bg-amber-50 dark:bg-amber-950/40 rounded-xl border border-amber-200 dark:border-amber-900/50 flex justify-between items-center">
                    <span class="text-xs font-bold text-amber-800 dark:text-amber-300">KEMBALIAN</span>
                    <span class="text-base font-extrabold {{ $amountPaid >= $total ? 'text-emerald-600 dark:text-emerald-400' : 'text-stone-400' }}">
                        Rp {{ number_format($change, 0, ',', '.') }}
                    </span>
                </div>

                {{-- SUBMIT BUTTON --}}
                <button 
                    type="button" 
                    wire:click="processTransaction"
                    wire:loading.attr="disabled"
                    {{ count($cart) === 0 || $amountPaid < $total ? 'disabled' : '' }}
                    class="w-full py-3 px-4 rounded-xl font-bold text-white shadow-md transition flex items-center justify-center gap-2 {{ count($cart) === 0 || $amountPaid < $total ? 'bg-stone-300 dark:bg-stone-700 cursor-not-allowed' : 'bg-[#C1440E] hover:bg-[#a3380b] active:scale-[0.99]' }}"
                >
                    <span wire:loading.remove wire:target="processTransaction">⚡ PROSES TRANSAKSI (CASH)</span>
                    <span wire:loading wire:target="processTransaction">Memproses Transaksi...</span>
                </button>
            </div>
        </div>
    </div>

    {{-- SUCCESS RECEIPT MODAL --}}
    @if($completedReceipt)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-stone-900/60 backdrop-blur-sm p-4">
            <div class="bg-white dark:bg-stone-900 rounded-2xl max-w-md w-full shadow-2xl border border-stone-200 dark:border-stone-800 overflow-hidden animate-fade-in">
                <div class="p-4 bg-emerald-600 text-white flex justify-between items-center">
                    <div class="flex items-center gap-2 font-bold">
                        <span>✅</span>
                        <span>Transaksi Berhasil Disimpan!</span>
                    </div>
                    <button type="button" wire:click="closeReceiptModal" class="text-white hover:text-stone-200 text-lg">✕</button>
                </div>

                <div class="p-4 max-h-[75vh] overflow-y-auto">
                    @include('filament.components.receipt-preview', ['receipt' => $completedReceipt])
                </div>

                <div class="p-4 bg-stone-50 dark:bg-stone-800 border-t border-stone-200 dark:border-stone-700 flex justify-end">
                    <button 
                        type="button" 
                        wire:click="closeReceiptModal" 
                        class="px-5 py-2 bg-[#C1440E] hover:bg-[#a3380b] text-white font-semibold rounded-lg text-sm shadow transition"
                    >
                        Selesai & Transaksi Baru
                    </button>
                </div>
            </div>
        </div>
    @endif
</x-filament-panels::page>
