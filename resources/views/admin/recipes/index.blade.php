@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-stone-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
        <div>
            <h1 class="text-lg sm:text-xl font-bold text-stone-900 flex items-center gap-2">
                <span>📖</span>
                <span>Buku Resep & Takaran Dapur</span>
            </h1>
            <p class="text-xs text-stone-500 mt-0.5">Dokumentasi bahan baku, takaran porsi, dan resep menu Yan's Food.</p>
        </div>
        <a href="{{ route('admin.recipes.create') }}" class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 sm:py-2 bg-[#C1440E] hover:bg-[#a3380b] text-white rounded-xl font-bold text-xs shadow-sm transition w-full sm:w-auto">
            <span>+ Tambah Resep Baru</span>
        </a>
    </div>

    {{-- RECIPES GRID (2-GRID RESPONSIVE) --}}
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
        @forelse($recipes as $recipe)
            <div class="bg-white p-3.5 sm:p-5 rounded-2xl shadow-sm border border-stone-200 flex flex-col justify-between hover:shadow-md transition">
                <div class="space-y-2.5 sm:space-y-3">
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-1.5 sm:gap-2">
                        <div>
                            <span class="text-[9px] sm:text-[10px] font-bold text-[#C1440E] uppercase tracking-wider block">
                                {{ $recipe->product?->name ?? 'Menu Produk' }}
                            </span>
                            <h3 class="font-bold text-stone-900 text-sm sm:text-base mt-0.5 line-clamp-1 sm:line-clamp-2">{{ $recipe->name }}</h3>
                        </div>
                        <span class="self-start px-2 py-0.5 sm:px-2.5 sm:py-1 bg-amber-50 text-amber-800 rounded-lg text-[10px] sm:text-xs font-bold shrink-0">
                            {{ $recipe->yield ?: '1 Porsi' }}
                        </span>
                    </div>

                    <p class="text-[11px] sm:text-xs text-stone-500 line-clamp-2">
                        {{ $recipe->description ?: 'Belum ada deskripsi pembuatan.' }}
                    </p>

                    <div class="p-2 sm:p-3 bg-stone-50 rounded-xl text-xs space-y-1">
                        <span class="font-bold text-stone-700 block text-[10px] sm:text-[11px] uppercase tracking-wider">Komposisi Bahan:</span>
                        <div class="flex flex-wrap gap-1 sm:gap-1.5 pt-0.5 sm:pt-1">
                            @forelse($recipe->ingredients->take(4) as $ing)
                                <span class="px-1.5 sm:px-2 py-0.5 rounded-md bg-white border border-stone-200 text-stone-700 text-[9px] sm:text-[10px]">
                                    {{ $ing->ingredient_name }} ({{ $ing->quantity }} {{ $ing->unit }})
                                </span>
                            @empty
                                <span class="text-stone-400 italic text-[10px] sm:text-[11px]">Belum ada bahan</span>
                            @endforelse
                            @if($recipe->ingredients->count() > 4)
                                <span class="px-1.5 sm:px-2 py-0.5 rounded-md bg-stone-200 text-stone-600 text-[9px] sm:text-[10px] font-bold">
                                    +{{ $recipe->ingredients->count() - 4 }} lainnya
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="pt-3 sm:pt-4 border-t border-stone-100 mt-3 sm:mt-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <a href="{{ route('admin.recipes.show', $recipe->id) }}" class="text-[11px] sm:text-xs font-bold text-[#C1440E] hover:underline">
                        Lihat Selengkapnya →
                    </a>
                    <div class="flex items-center gap-1.5 self-end sm:self-auto">
                        <a href="{{ route('admin.recipes.edit', $recipe->id) }}" class="p-1 sm:p-1.5 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-lg text-xs" title="Edit Resep">
                            ✏️
                        </a>
                        <form action="{{ route('admin.recipes.destroy', $recipe->id) }}" method="POST" onsubmit="return confirm('Hapus resep ini?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1 sm:p-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-xs" title="Hapus Resep">
                                🗑️
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-dashed border-stone-300">
                <div class="text-3xl mb-1">📖</div>
                <p class="text-stone-500 text-sm font-medium">Belum ada resep menu masakan tercatat.</p>
            </div>
        @endforelse
    </div>

    <div>
        {{ $recipes->links() }}
    </div>
</div>
@endsection
