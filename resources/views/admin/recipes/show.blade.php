@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <a href="{{ route('admin.recipes.index') }}" class="text-xs font-bold text-stone-600 hover:text-stone-900 transition">
            ← Kembali ke Buku Resep
        </a>
        <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ route('admin.recipes.edit', $recipe->id) }}" class="px-4 py-2 bg-stone-100 hover:bg-stone-200 text-stone-800 rounded-xl font-bold text-xs transition">
                ✏️ Ubah Resep
            </a>
            <button type="button" onclick="window.print()" class="px-4 py-2 bg-stone-900 hover:bg-black text-white rounded-xl font-bold text-xs shadow-sm transition">
                🖨️ Cetak Resep Dapur
            </button>
        </div>
    </div>

    <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-stone-200 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3 pb-4 border-b border-stone-200">
            <div>
                <span class="text-xs font-bold text-[#C1440E] uppercase tracking-wider">
                    Menu: {{ $recipe->product?->name ?? 'Produk Kuliner' }}
                </span>
                <h1 class="text-xl sm:text-2xl font-black text-stone-900 mt-1">{{ $recipe->name }}</h1>
            </div>
            <span class="self-start px-3 py-1 bg-amber-50 text-amber-800 rounded-xl text-xs font-bold border border-amber-200 shrink-0">
                Takaran: {{ $recipe->yield ?: '1 Porsi' }}
            </span>
        </div>

        @if($recipe->notes)
            <div class="p-3 bg-amber-50/70 border border-amber-200/60 rounded-xl text-xs text-amber-900">
                <strong>Catatan Dapur:</strong> {{ $recipe->notes }}
            </div>
        @endif

        {{-- INGREDIENTS TABLE --}}
        <div>
            <h3 class="text-xs font-bold text-stone-900 uppercase tracking-wider mb-3">Bahan Baku yang Diperlukan</h3>
            <div class="rounded-xl border border-stone-200 overflow-x-auto">
                <table class="w-full text-left text-xs whitespace-nowrap min-w-[340px]">
                    <thead class="bg-stone-50 text-stone-600 font-bold border-b border-stone-200">
                        <tr>
                            <th class="py-2.5 px-4">Nama Bahan</th>
                            <th class="py-2.5 px-4 text-center">Takaran (Kuantitas)</th>
                            <th class="py-2.5 px-4 text-center">Satuan Unit</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse($recipe->ingredients as $ing)
                            <tr class="hover:bg-stone-50">
                                <td class="py-2.5 px-4 font-bold text-stone-800">{{ $ing->ingredient_name }}</td>
                                <td class="py-2.5 px-4 text-center font-black text-stone-900">{{ $ing->quantity }}</td>
                                <td class="py-2.5 px-4 text-center text-stone-600">{{ $ing->unit }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-6 text-center text-stone-400">Belum ada bahan baku tercatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($recipe->description)
            <div class="pt-4 border-t border-stone-200">
                <h3 class="text-xs font-bold text-stone-900 uppercase tracking-wider mb-2">Petunjuk Pengolahan & Masak</h3>
                <div class="p-4 bg-stone-50 rounded-xl text-xs text-stone-700 leading-relaxed whitespace-pre-line">
                    {{ $recipe->description }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
