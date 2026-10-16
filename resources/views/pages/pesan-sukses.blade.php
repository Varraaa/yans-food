<x-app-layout>
    <x-slot name="title">Pesanan Berhasil Dicatat — {{ $order->order_number }} | Yan's Food</x-slot>

    <div class="w-full py-12 lg:py-20 px-4 sm:px-6 lg:px-12 bg-cream-bg min-h-[calc(100vh-14rem)] flex items-center justify-center">
        <div class="max-w-3xl w-full mx-auto" data-reveal>
            
            <!-- Success Status Header (§6.7) -->
            <div class="text-center space-y-4 mb-10">
                <!-- Animated Checkmark Badge -->
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-emerald-100 text-emerald-600 shadow-md ring-8 ring-emerald-50 mb-2">
                    <span class="material-symbols-outlined text-[44px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                </div>
                
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-surface-container text-on-surface font-mono text-xs font-semibold shadow-2xs border border-surface-variant/50">
                    <span>Nomor Pesanan:</span>
                    <span class="text-primary font-bold">{{ $order->order_number }}</span>
                    <button type="button" 
                            onclick="window.copyToClipboard('{{ $order->order_number }}', 'Nomor pesanan berhasil disalin!')"
                            title="Salin nomor pesanan"
                            class="text-secondary hover:text-on-surface ml-1 p-0.5">
                        <span class="material-symbols-outlined text-[16px]">content_copy</span>
                    </button>
                </div>

                <h1 class="font-headline-lg text-3xl sm:text-4xl text-on-surface tracking-tight font-serif">
                    Pesanan Katering Berhasil Dicatat!
                </h1>
                <p class="font-body-md text-secondary max-w-xl mx-auto leading-relaxed text-sm sm:text-base">
                    Terima kasih telah mempercayakan santapan acara Anda kepada Yan's Food. Tim dapur kami telah menerima rincian jadwal dan pesanan Anda.
                </p>
            </div>

            <!-- Detail Summary Card -->
            <div class="rounded-3xl bg-surface-warm p-6 sm:p-8 lg:p-10 shadow-xs border border-surface-variant/40 space-y-8" id="orderSummaryCard">
                
                <!-- Acara & Waktu Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pb-6 border-b border-surface-variant/40">
                    <div class="space-y-1">
                        <span class="font-label-sm text-secondary text-xs block">Jadwal Acara & Jam Tiba</span>
                        <p class="font-headline-sm text-on-surface font-semibold text-base sm:text-lg">
                            {{ $order->event_date ? $order->event_date->translatedFormat('l, d F Y') : '-' }}
                        </p>
                        <p class="font-body-sm text-primary font-medium text-xs sm:text-sm">
                            Pukul {{ $order->event_time }} WIB
                        </p>
                    </div>

                    <div class="space-y-1">
                        <span class="font-label-sm text-secondary text-xs block">Jenis Acara / Keperluan</span>
                        <p class="font-headline-sm text-on-surface font-semibold text-base sm:text-lg">
                            {{ $order->event_purpose ?: 'Acara Spesial' }}
                        </p>
                        <p class="font-body-sm text-secondary text-xs sm:text-sm">
                            Pemesan: <span class="font-semibold text-on-surface">{{ $order->customer_name }}</span> ({{ $order->customer_phone }})
                        </p>
                    </div>
                </div>

                <!-- Alamat Pengiriman -->
                <div class="space-y-1 pb-6 border-b border-surface-variant/40">
                    <span class="font-label-sm text-secondary text-xs block">Alamat Pengantaran</span>
                    <p class="font-body-md text-on-surface leading-relaxed text-sm sm:text-base">
                        {{ $order->customer_address }}
                    </p>
                    @if($order->notes)
                        <div class="mt-3 p-3.5 rounded-xl bg-surface-container-low text-xs sm:text-sm font-body-sm text-secondary border border-surface-variant/40">
                            <span class="font-semibold text-on-surface">Catatan Khusus:</span> {{ $order->notes }}
                        </div>
                    @endif
                </div>

                <!-- Rincian Menu & Biaya -->
                <div class="space-y-4">
                    <span class="font-label-sm text-secondary text-xs block uppercase tracking-wider font-semibold">Rincian Menu yang Dipesan</span>
                    
                    <div class="space-y-3">
                        @foreach($order->items as $item)
                            <div class="flex items-center justify-between py-2 border-b border-surface-variant/30 text-sm">
                                <div class="flex items-center gap-3">
                                    <span class="w-7 h-7 rounded-lg bg-surface-container flex items-center justify-center font-mono text-xs font-bold text-on-surface">
                                        {{ $item->quantity }}x
                                    </span>
                                    <span class="font-body-md text-on-surface font-medium">{{ $item->product_name }}</span>
                                </div>
                                <span class="font-mono font-semibold text-on-surface">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Total Estimasi -->
                    <div class="flex items-center justify-between pt-4">
                        <div>
                            <span class="font-label-md text-on-surface font-semibold text-sm sm:text-base block">Total Estimasi Biaya</span>
                            <span class="font-body-sm text-secondary text-xs">Belum termasuk penyesuaian khusus atau ongkir</span>
                        </div>
                        <div class="font-numeric-currency text-primary text-2xl sm:text-3xl font-bold font-serif">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <!-- Langkah Berikutnya Box (§6.7) -->
                <div class="p-4 sm:p-5 rounded-2xl bg-amber-50/70 border border-amber-200/60 text-amber-900 space-y-2">
                    <div class="flex items-center gap-2 font-semibold text-xs sm:text-sm">
                        <span class="material-symbols-outlined text-[20px] text-amber-700">info</span>
                        <span>Langkah Selanjutnya: Konfirmasi WhatsApp</span>
                    </div>
                    <p class="font-body-sm text-xs sm:text-sm leading-relaxed text-amber-800">
                        Klik tombol hijau di bawah untuk melanjutkan chat WhatsApp bersama admin Yan's Food. Admin kami akan memastikan ketersediaan slot tanggal, konfirmasi detail pesanan, dan mengirim panduan pembayaran DP 50%.
                    </p>
                </div>

                <!-- Actions (§6.8) -->
                <div class="pt-4 flex flex-col sm:flex-row items-center gap-4">
                    <a href="{{ $waUrl }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="w-full sm:flex-1 inline-flex items-center justify-center gap-2.5 px-6 py-4 rounded-xl bg-[#25D366] hover:bg-[#20bd5a] text-white font-label-md font-bold text-sm sm:text-base shadow-md hover:shadow-lg transition-all active:scale-98">
                        <span class="material-symbols-outlined text-[22px]">chat</span>
                        <span>Lanjut Konsultasi via WhatsApp</span>
                    </a>

                    <button type="button" 
                            onclick="copyOrderSummary()"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-4 rounded-xl bg-surface-container hover:bg-surface-container-high text-on-surface font-label-md text-sm border border-surface-variant/40 transition-colors active:scale-95">
                        <span class="material-symbols-outlined text-[18px]">content_copy</span>
                        <span>Salin Ringkasan</span>
                    </button>
                </div>

                <!-- Footer Navigation -->
                <div class="pt-4 flex items-center justify-center gap-6 text-xs sm:text-sm font-label-md text-secondary border-t border-surface-variant/30">
                    <a href="{{ url('/') }}" class="hover:text-primary transition-colors flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">home</span>
                        <span>Kembali ke Beranda</span>
                    </a>
                    <span>•</span>
                    <a href="{{ url('/pesan') }}" class="hover:text-primary transition-colors flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">add_circle</span>
                        <span>Buat Pesanan Baru</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Script to Clear Draft & Copy Summary (§6.6 & §6.8) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Bersihkan draf form yang tersimpan di browser setelah order sukses
            try {
                localStorage.removeItem('yf_catering_draft_v1');
            } catch (e) {
                console.warn('Could not remove localStorage draft', e);
            }
        });

        function copyOrderSummary() {
            const summaryText = `*RINGKASAN PESANAN KATERING YAN'S FOOD*\n\n` +
                `• Nomor Pesanan: {{ $order->order_number }}\n` +
                `• Pemesan: {{ $order->customer_name }} ({{ $order->customer_phone }})\n` +
                `• Jadwal Acara: {{ $order->event_date ? $order->event_date->format('d/m/Y') : '-' }} jam {{ $order->event_time }} WIB\n` +
                `• Keperluan: {{ $order->event_purpose ?: 'Acara' }}\n` +
                `• Alamat Kirim: {{ $order->customer_address }}\n` +
                @if($order->notes)
                `• Catatan: {{ $order->notes }}\n` +
                @endif
                `\n*Menu Pesanan:*\n` +
                @foreach($order->items as $item)
                `- {{ $item->product_name }} x{{ $item->quantity }} = Rp {{ number_format($item->subtotal, 0, ',', '.') }}\n` +
                @endforeach
                `\n• Estimasi Total: Rp {{ number_format($order->total, 0, ',', '.') }}`;

            window.copyToClipboard(summaryText, 'Ringkasan pesanan berhasil disalin ke clipboard!');
        }
    </script>
</x-app-layout>
