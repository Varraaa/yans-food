@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.expenses.index') }}" class="text-xs font-bold text-stone-600 hover:text-stone-900 transition flex items-center gap-1">
            <span>←</span>
            <span>Kembali ke Daftar Pengeluaran</span>
        </a>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-stone-200 space-y-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-mono font-bold text-[#C1440E] uppercase">{{ $expense->expense_number }}</span>
            </div>
            <h1 class="text-xl font-bold text-stone-900 mt-0.5">Ubah Catatan Pengeluaran</h1>
            <p class="text-xs text-stone-500 mt-0.5">Perbarui informasi biaya, nota, atau kategori operasional.</p>
        </div>

        <form action="{{ route('admin.expenses.update', $expense->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div class="space-y-1">
                <label class="block font-bold text-stone-700 uppercase tracking-wider">Nama / Keperluan Belanja *</label>
                <input 
                    type="text" 
                    name="name" 
                    value="{{ old('name', $expense->name) }}" 
                    required 
                    placeholder="Contoh: Belanja Ayam Segar 10 Ekor" 
                    class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-sm focus:ring-1 focus:ring-[#C1440E]"
                >
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="block font-bold text-stone-700 uppercase tracking-wider">Kategori Pengeluaran *</label>
                    <select name="category" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                        @php
                            $currentCatName = $expense->category?->name ?? '';
                        @endphp
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category', $currentCatName) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="block font-bold text-stone-700 uppercase tracking-wider">Metode Pembayaran *</label>
                    <select name="payment_method" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                        <option value="CASH" {{ old('payment_method', $expense->payment_method) === 'CASH' ? 'selected' : '' }}>Tunai (Cash)</option>
                        <option value="TRANSFER" {{ old('payment_method', $expense->payment_method) === 'TRANSFER' ? 'selected' : '' }}>Transfer Bank</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="block font-bold text-stone-700 uppercase tracking-wider">Nominal Biaya (Rp) *</label>
                    <input 
                        type="number" 
                        name="amount" 
                        value="{{ old('amount', (int)$expense->amount) }}" 
                        min="1" 
                        required 
                        placeholder="0" 
                        class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-sm font-black focus:ring-1 focus:ring-[#C1440E]"
                    >
                </div>

                <div class="space-y-1">
                    <label class="block font-bold text-stone-700 uppercase tracking-wider">Tanggal Pengeluaran *</label>
                    <input 
                        type="date" 
                        name="expense_date" 
                        value="{{ old('expense_date', $expense->expense_date ? \Carbon\Carbon::parse($expense->expense_date)->format('Y-m-d') : date('Y-m-d')) }}" 
                        required 
                        class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]"
                    >
                </div>
            </div>

            <div class="space-y-2">
                <label class="block font-bold text-stone-700 uppercase tracking-wider">Upload / Ganti Foto Nota Kwitansi (Opsional)</label>
                @if($expense->receipt_image)
                    <div class="flex items-center gap-3 p-2 bg-stone-50 rounded-xl border border-stone-200">
                        <img src="{{ asset('storage/' . $expense->receipt_image) }}" alt="Nota Saat Ini" class="w-12 h-12 object-cover rounded-lg border border-stone-300">
                        <div class="text-[11px] text-stone-600">
                            <span class="font-bold text-stone-800 block">Nota saat ini tersimpan</span>
                            <a href="{{ asset('storage/' . $expense->receipt_image) }}" target="_blank" class="text-[#C1440E] hover:underline">Lihat Gambar</a>
                        </div>
                    </div>
                @endif
                <input type="file" name="receipt_image" accept="image/*" class="w-full px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs">
                <p class="text-[10px] text-stone-400">Kosongkan jika tidak ingin mengganti foto nota yang sudah ada.</p>
            </div>

            <div class="space-y-1">
                <label class="block font-bold text-stone-700 uppercase tracking-wider">Catatan Tambahan</label>
                <textarea name="description" rows="2" placeholder="Nama toko, pasar, atau rincian..." class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">{{ old('description', $expense->description) }}</textarea>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-stone-100">
                <a href="{{ route('admin.expenses.index') }}" class="px-4 py-2 text-stone-600 hover:text-stone-900 font-bold">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-[#C1440E] hover:bg-[#a3380b] text-white font-bold rounded-xl shadow-sm transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
