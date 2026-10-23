@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <a href="{{ route('admin.expenses.index') }}" class="text-xs font-bold text-stone-600 hover:text-stone-900 transition flex items-center gap-1">
            <span>←</span>
            <span>Kembali ke Daftar Pengeluaran</span>
        </a>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.expenses.edit', $expense->id) }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-stone-100 hover:bg-stone-200 text-stone-800 rounded-xl font-bold text-xs transition">
                <span>✏️</span>
                <span>Ubah</span>
            </a>
            <form action="{{ route('admin.expenses.destroy', $expense->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan pengeluaran ini? File nota dan data akan dihapus permanen.')" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-xl font-bold text-xs transition">
                    <span>🗑️</span>
                    <span>Hapus</span>
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-stone-200 space-y-6">
        {{-- HEADER INFO --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-stone-100 gap-3">
            <div>
                <span class="text-xs font-mono font-bold text-[#C1440E] uppercase tracking-wider block">
                    {{ $expense->expense_number }}
                </span>
                <h1 class="text-xl sm:text-2xl font-black text-stone-900 mt-0.5">{{ $expense->name }}</h1>
            </div>
            <div class="text-left sm:text-right">
                <span class="text-[11px] text-stone-400 block">Nominal Pengeluaran</span>
                <span class="text-2xl font-black text-rose-600 font-mono">
                    Rp {{ number_format($expense->amount, 0, ',', '.') }}
                </span>
            </div>
        </div>

        {{-- DETAIL GRID --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 text-xs">
            <div class="p-3.5 bg-stone-50 rounded-xl border border-stone-100">
                <span class="text-stone-400 font-medium block">Tanggal Pengeluaran</span>
                <span class="font-bold text-stone-800 text-sm mt-0.5 block font-mono">
                    {{ \Carbon\Carbon::parse($expense->expense_date)->translatedFormat('d F Y') }}
                </span>
            </div>

            <div class="p-3.5 bg-stone-50 rounded-xl border border-stone-100">
                <span class="text-stone-400 font-medium block">Kategori Biaya</span>
                <span class="inline-block px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200 mt-1">
                    {{ $expense->category?->name ?? 'Operasional' }}
                </span>
            </div>

            <div class="p-3.5 bg-stone-50 rounded-xl border border-stone-100">
                <span class="text-stone-400 font-medium block">Metode Pembayaran</span>
                <span class="font-bold text-stone-800 text-sm mt-0.5 block">
                    @if($expense->payment_method === 'CASH')
                        <span class="text-emerald-700">💵 Uang Tunai (Cash)</span>
                    @else
                        <span class="text-sky-700">💳 Transfer Bank</span>
                    @endif
                </span>
            </div>

            <div class="p-3.5 bg-stone-50 rounded-xl border border-stone-100">
                <span class="text-stone-400 font-medium block">Status</span>
                <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 mt-1">
                    {{ $expense->status ?: 'APPROVED' }}
                </span>
            </div>

            <div class="p-3.5 bg-stone-50 rounded-xl border border-stone-100">
                <span class="text-stone-400 font-medium block">Dicatat Oleh</span>
                <span class="font-bold text-stone-800 text-sm mt-0.5 block">
                    {{ $expense->creator?->name ?? 'Admin Yan\'s Food' }}
                </span>
            </div>

            <div class="p-3.5 bg-stone-50 rounded-xl border border-stone-100">
                <span class="text-stone-400 font-medium block">Waktu Pencatatan</span>
                <span class="font-bold text-stone-700 text-xs mt-0.5 block font-mono">
                    {{ $expense->created_at ? $expense->created_at->format('d/m/Y H:i') . ' WIB' : '-' }}
                </span>
            </div>
        </div>

        {{-- CATATAN / DESKRIPSI --}}
        @if($expense->description)
            <div class="p-4 bg-amber-50/50 border border-amber-200/60 rounded-xl text-xs space-y-1">
                <span class="font-bold text-amber-900 uppercase tracking-wider text-[10px] block">Catatan / Keterangan:</span>
                <p class="text-stone-700 leading-relaxed whitespace-pre-line">{{ $expense->description }}</p>
            </div>
        @endif

        {{-- BUKTI NOTA / KWITANSI --}}
        <div class="pt-4 border-t border-stone-100 space-y-3 text-xs">
            <span class="font-bold text-stone-800 uppercase tracking-wider block text-[11px]">
                Foto Nota / Kwitansi Belanja
            </span>
            @if($expense->receipt_image)
                <div class="space-y-3">
                    <div class="max-w-md rounded-2xl overflow-hidden border border-stone-200 shadow-sm bg-stone-50">
                        <img 
                            src="{{ asset('storage/' . $expense->receipt_image) }}" 
                            alt="Bukti Nota {{ $expense->expense_number }}"
                            class="w-full h-auto max-h-96 object-contain p-2"
                        >
                    </div>
                    <div>
                        <a 
                            href="{{ asset('storage/' . $expense->receipt_image) }}" 
                            target="_blank" 
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-stone-800 hover:bg-black text-white rounded-lg text-xs font-bold transition"
                        >
                            <span>🔍 Buka Gambar Ukuran Asli</span>
                        </a>
                    </div>
                </div>
            @else
                <div class="p-6 text-center rounded-xl border border-dashed border-stone-300 bg-stone-50 text-stone-400">
                    <span class="text-2xl block mb-1">🧾</span>
                    <span>Tidak ada foto nota/kwitansi yang dilampirkan pada pengeluaran ini.</span>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
