@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    {{-- HEADER & FILTERS --}}
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-200 space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-stone-900 flex items-center gap-2">
                    <span>🧾</span>
                    <span>Riwayat Transaksi Kasir POS</span>
                </h1>
                <p class="text-xs text-stone-500 mt-0.5">Daftar struk belanja yang telah diproses di kasir Yan's Food.</p>
            </div>
            <a href="{{ route('admin.pos.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#C1440E] hover:bg-[#a3380b] text-white rounded-xl font-bold text-xs shadow-sm transition">
                <span>+ Buka Kasir POS</span>
            </a>
        </div>

        <form action="{{ route('admin.transactions.index') }}" method="GET" class="pt-3 border-t border-stone-100 flex flex-wrap items-center gap-3 text-xs">
            <div class="flex-1 min-w-[200px]">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari nomor transaksi..." 
                    class="w-full px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]"
                >
            </div>

            <div>
                <input 
                    type="date" 
                    name="date" 
                    value="{{ request('date') }}" 
                    class="px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]"
                >
            </div>

            <div>
                <select name="method" class="px-3 py-2 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                    <option value="all">Semua Metode</option>
                    <option value="CASH" {{ request('method') === 'CASH' ? 'selected' : '' }}>Tunai (Cash)</option>
                    <option value="TRANSFER" {{ request('method') === 'TRANSFER' ? 'selected' : '' }}>Transfer</option>
                    <option value="QRIS" {{ request('method') === 'QRIS' ? 'selected' : '' }}>QRIS</option>
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-stone-800 text-white rounded-xl font-bold hover:bg-stone-900 transition">
                Filter
            </button>

            @if(request()->hasAny(['search', 'date', 'method']))
                <a href="{{ route('admin.transactions.index') }}" class="px-3 py-2 text-stone-500 hover:text-stone-800 font-bold">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- TRANSACTIONS TABLE --}}
    <div class="bg-white rounded-2xl shadow-sm border border-stone-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-stone-50 text-stone-600 font-bold border-b border-stone-200 uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3.5 px-4">No. Transaksi</th>
                        <th class="py-3.5 px-4">Tanggal & Jam</th>
                        <th class="py-3.5 px-4">Kasir</th>
                        <th class="py-3.5 px-4 text-center">Metode</th>
                        <th class="py-3.5 px-4 text-right">Subtotal</th>
                        <th class="py-3.5 px-4 text-right">Total</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($transactions as $tx)
                        <tr class="hover:bg-amber-50/30 transition">
                            <td class="py-3.5 px-4 font-mono font-bold text-stone-900">
                                {{ $tx->transaction_number }}
                            </td>
                            <td class="py-3.5 px-4 font-mono text-stone-600">
                                {{ \Carbon\Carbon::parse($tx->transaction_date)->format('d M Y') }} <span class="text-stone-500 font-semibold text-[11px]">{{ substr($tx->transaction_time, 0, 5) }} WIB</span>
                            </td>
                            <td class="py-3.5 px-4 text-stone-700">
                                {{ $tx->cashier?->name ?? 'Kasir' }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="px-2 py-0.5 rounded font-bold text-[10px] bg-stone-100 text-stone-700">
                                    {{ $tx->payment_method }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right font-medium text-stone-600">
                                Rp {{ number_format($tx->subtotal, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-4 text-right font-black text-sm text-[#C1440E]">
                                Rp {{ number_format($tx->total, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase {{ $tx->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                    {{ $tx->status === 'completed' ? 'Selesai' : 'Batal' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <a href="{{ route('admin.transactions.show', $tx->id) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-stone-100 hover:bg-stone-200 text-stone-800 rounded-lg font-bold text-[11px] transition">
                                    <span>👁️ Detail</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-stone-400">
                                <div class="text-3xl mb-1">📭</div>
                                Tidak ada transaksi yang sesuai dengan filter pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-stone-200">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection
