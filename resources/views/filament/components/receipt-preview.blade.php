<div class="bg-amber-50/50 p-6 rounded-xl border border-stone-200 text-stone-800 font-mono text-xs max-w-sm mx-auto shadow-sm">
    <div class="text-center pb-3 border-b border-dashed border-stone-300">
        <h3 class="text-base font-bold text-stone-900 tracking-wider">{{ $receipt['header']['store_name'] ?? "YAN'S FOOD" }}</h3>
        <p class="text-stone-600">{{ $receipt['header']['address'] ?? 'Dapur & Katering Rumahan' }}</p>
        <p class="text-stone-500">WA: {{ $receipt['header']['phone'] ?? '0812-3456-7890' }}</p>
    </div>

    <div class="py-2 border-b border-dashed border-stone-300 space-y-1">
        <div class="flex justify-between">
            <span>No: {{ $receipt['order_info']['number'] ?? '-' }}</span>
            <span>Kasir: {{ $receipt['order_info']['cashier'] ?? '-' }}</span>
        </div>
        <div class="flex justify-between text-stone-500">
            <span>Tgl: {{ $receipt['order_info']['date'] ?? '-' }}</span>
            <span>Jam: {{ $receipt['order_info']['time'] ?? '-' }}</span>
        </div>
    </div>

    <div class="py-3 border-b border-dashed border-stone-300 space-y-2">
        @foreach($receipt['items'] ?? [] as $item)
            <div>
                <div class="font-semibold text-stone-900">{{ $item['name'] }}</div>
                <div class="flex justify-between text-stone-600 pl-2">
                    <span>{{ $item['qty'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                    <span>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                </div>
            </div>
        @endforeach
    </div>

    <div class="py-3 border-b border-dashed border-stone-300 space-y-1">
        <div class="flex justify-between">
            <span>Subtotal:</span>
            <span>Rp {{ number_format($receipt['summary']['subtotal'] ?? 0, 0, ',', '.') }}</span>
        </div>
        @if(($receipt['summary']['discount'] ?? 0) > 0)
            <div class="flex justify-between text-emerald-600">
                <span>Diskon:</span>
                <span>- Rp {{ number_format($receipt['summary']['discount'], 0, ',', '.') }}</span>
            </div>
        @endif
        <div class="flex justify-between font-bold text-sm text-stone-900 pt-1 border-t border-dotted border-stone-300">
            <span>TOTAL:</span>
            <span>Rp {{ number_format($receipt['summary']['total'] ?? 0, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between pt-1">
            <span>Bayar ({{ $receipt['payment']['method'] ?? 'CASH' }}):</span>
            <span>Rp {{ number_format($receipt['payment']['paid'] ?? 0, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between font-semibold text-stone-900">
            <span>Kembalian:</span>
            <span>Rp {{ number_format($receipt['payment']['change'] ?? 0, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="text-center pt-4 text-stone-500 space-y-1">
        <p>{{ $receipt['footer']['message'] ?? 'Terima Kasih Atas Kunjungan Anda' }}</p>
        <p class="text-[10px]">{{ $receipt['footer']['sub_message'] ?? '100% Halal & Fresh Cooked' }}</p>
    </div>

    <div class="mt-4 pt-3 text-center border-t border-stone-200">
        <button type="button" onclick="window.print()" class="px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white font-sans text-xs font-semibold rounded-lg shadow transition">
            🖨️ Cetak ke Thermal Printer
        </button>
    </div>
</div>
