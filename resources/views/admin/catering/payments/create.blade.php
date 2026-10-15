@extends('layouts.admin')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.catering.orders.index') }}" class="text-xs font-bold text-stone-600 hover:text-stone-900 transition">
            ← Kembali ke Daftar Pesanan
        </a>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-stone-200 space-y-6">
        <div>
            <h1 class="text-xl font-bold text-stone-900">Catat Pembayaran Katering</h1>
            <p class="text-xs text-stone-500 mt-0.5">Input penerimaan uang muka (DP) atau pelunasan sisa tagihan.</p>
        </div>

        <form action="{{ route('admin.catering.payments.store') }}" method="POST" class="space-y-4 text-xs">
            @csrf

            <div class="space-y-1">
                <label class="block font-bold text-stone-700 uppercase tracking-wider">Pilih Pesanan Katering *</label>
                <select name="catering_order_id" id="catering_order_id" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                    <option value="">-- Pilih Pesanan Katering --</option>
                    @foreach($orders as $ord)
                        @php
                            $paid = $ord->payments->sum('amount');
                            $sisa = max(0, $ord->total - $paid);
                        @endphp
                        <option 
                            value="{{ $ord->id }}" 
                            data-total="{{ $ord->total }}" 
                            data-paid="{{ $paid }}" 
                            data-sisa="{{ $sisa }}"
                            {{ old('catering_order_id', $selectedOrderId) == $ord->id ? 'selected' : '' }}
                        >
                            {{ $ord->order_number }} — {{ $ord->customer_name }} (Sisa: Rp {{ number_format($sisa, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="p-3 bg-stone-50 rounded-xl space-y-1 border border-stone-200">
                <div class="flex justify-between text-stone-600">
                    <span>Total Nilai Kontrak:</span>
                    <strong id="info-total" class="text-stone-900">Rp 0</strong>
                </div>
                <div class="flex justify-between text-stone-600">
                    <span>Sudah Pernah Dibayar:</span>
                    <strong id="info-paid" class="text-emerald-700">Rp 0</strong>
                </div>
                <div class="flex justify-between text-stone-700 font-bold border-t border-stone-200 pt-1">
                    <span>Sisa Tagihan Maksimal:</span>
                    <strong id="info-sisa" class="text-rose-600">Rp 0</strong>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="block font-bold text-stone-700 uppercase tracking-wider">Jenis Pembayaran *</label>
                    <select name="payment_type" id="payment_type" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                        <option value="DP" {{ old('payment_type') === 'DP' ? 'selected' : '' }}>Uang Muka (DP)</option>
                        <option value="PELUNASAN" {{ old('payment_type') === 'PELUNASAN' ? 'selected' : '' }}>Pelunasan</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="block font-bold text-stone-700 uppercase tracking-wider">Metode Bayar *</label>
                    <select name="payment_method" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                        <option value="TRANSFER">Transfer Bank</option>
                        <option value="CASH">Tunai (Cash)</option>
                        <option value="QRIS">QRIS</option>
                    </select>
                </div>
            </div>

            <div class="space-y-1">
                <div class="flex justify-between items-center">
                    <label class="block font-bold text-stone-700 uppercase tracking-wider">Nominal Diterima (Rp) *</label>
                    <button type="button" onclick="setFullPayment()" class="text-[11px] text-[#C1440E] font-bold hover:underline">Isi Sisa Penuh</button>
                </div>
                <input type="number" name="amount" id="amount" value="{{ old('amount') }}" min="1000" required placeholder="0" class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-sm font-black focus:ring-1 focus:ring-[#C1440E]">
            </div>

            <div class="space-y-1">
                <label class="block font-bold text-stone-700 uppercase tracking-wider">Catatan Tambahan (Opsional)</label>
                <input type="text" name="notes" value="{{ old('notes') }}" placeholder="Contoh: Transfer via BCA an Bpk Ahmad" class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-stone-100">
                <a href="{{ route('admin.catering.orders.index') }}" class="px-4 py-2 text-stone-600 hover:text-stone-900 font-bold">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-[#C1440E] hover:bg-[#a3380b] text-white font-bold rounded-xl shadow-sm transition">
                    Simpan Kwitansi Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const orderSelect = document.getElementById('catering_order_id');
    const infoTotal = document.getElementById('info-total');
    const infoPaid = document.getElementById('info-paid');
    const infoSisa = document.getElementById('info-sisa');
    const amountInput = document.getElementById('amount');
    const paymentTypeSelect = document.getElementById('payment_type');

    function updateOrderInfo() {
        const opt = orderSelect.options[orderSelect.selectedIndex];
        if (!opt || !opt.value) {
            infoTotal.textContent = 'Rp 0';
            infoPaid.textContent = 'Rp 0';
            infoSisa.textContent = 'Rp 0';
            return;
        }

        const total = parseFloat(opt.getAttribute('data-total')) || 0;
        const paid = parseFloat(opt.getAttribute('data-paid')) || 0;
        const sisa = parseFloat(opt.getAttribute('data-sisa')) || 0;

        infoTotal.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        infoPaid.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(paid);
        infoSisa.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(sisa);

        if (paid > 0) {
            paymentTypeSelect.value = 'PELUNASAN';
        } else {
            paymentTypeSelect.value = 'DP';
        }
    }

    function setFullPayment() {
        const opt = orderSelect.options[orderSelect.selectedIndex];
        if (opt && opt.value) {
            const sisa = parseFloat(opt.getAttribute('data-sisa')) || 0;
            amountInput.value = sisa;
        }
    }

    orderSelect.addEventListener('change', updateOrderInfo);
    updateOrderInfo();
</script>
@endsection
