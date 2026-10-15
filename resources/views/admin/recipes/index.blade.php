@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-stone-900 flex items-center gap-2">
                <span>📖</span>
                <span>Buku Resep & Takaran Dapur</span>
            </h1>
            <p class="text-xs text-stone-500 mt-0.5">Dokumentasi bahan baku, takaran porsi, dan resep menu Yan's Food.</p>
        </div>
        <a href="{{ route('admin.recipes.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#C1440E] hover:bg-[#a3380b] text-white rounded-xl font-bold text-xs shadow-sm transition">
            <span>+ Tambah Resep Baru</span>
        </a>
    </div>

    {{-- RECIPES GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($recipes as $recipe)
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-200 flex flex-col justify-between hover:shadow-md transition">
                <div class="space-y-3">
                    <div class="flex items-start justify-between">
                        <div>
                            <span class="text-[10px] font-bold text-[#C1440E] uppercase tracking-wider">
                                {{ $recipe->product?->name ?? 'Menu Produk' }}
                            </span>
                            <h3 class="font-bold text-stone-900 text-base mt-0.5">{{ $recipe->name }}</h3>
                        </div>
                        <span class="px-2.5 py-1 bg-amber-50 text-amber-800 rounded-lg text-xs font-bold">
                            {{ $recipe->yield ?: '1 Porsi' }}
                        </span>
                    </div>

                    <p class="text-xs text-stone-500 line-clamp-2">
                        {{ $recipe->description ?: 'Belum ada deskripsi pembuatan.' }}
                    </p>

                    <div class="p-3 bg-stone-50 rounded-xl text-xs space-y-1">
                        <span class="font-bold text-stone-700 block text-[11px] uppercase tracking-wider">Komposisi Bahan:</span>
                        <div class="flex flex-wrap gap-1.5 pt-1">
                            @forelse($recipe->ingredients->take(5) as $ing)
                                <span class="px-2 py-0.5 rounded-md bg-white border border-stone-200 text-stone-700 text-[10px]">
                                    {{ $ing->ingredient_name }} ({{ $ing->quantity }} {{ $ing->unit }})
                                </span>
                            @empty
                                <span class="text-stone-400 italic text-[11px]">Belum ada bahan ditambahkan</span>
                            @endforelse
                            @if($recipe->ingredients->count() > 5)
                                <span class="px-2 py-0.5 rounded-md bg-stone-200 text-stone-600 text-[10px] font-bold">
                                    +{{ $recipe->ingredients->count() - 5 }} lainnya
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-stone-100 mt-4 flex items-center justify-between">
                    <a href="{{ route('admin.recipes.show', $recipe->id) }}" class="text-xs font-bold text-[#C1440E] hover:underline">
                        Lihat Selengkapnya →
                    </a>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.recipes.edit', $recipe->id) }}" class="p-1.5 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-lg text-xs">
                            ✏️
                        </a>
                        <form action="{{ route('admin.recipes.destroy', $recipe->id) }}" method="POST" onsubmit="return confirm('Hapus resep ini?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-xs">
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
