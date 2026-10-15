@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-stone-900 flex items-center gap-2">
                <span>🖨️</span>
                <span>Konfigurasi Thermal Printer</span>
            </h1>
            <p class="text-xs text-stone-500 mt-0.5">Kelola sambungan printer kasir Bluetooth, USB, atau Jaringan (LAN).</p>
        </div>
        <button type="button" onclick="document.getElementById('modal-add-printer').classList.remove('hidden')" class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#C1440E] hover:bg-[#a3380b] text-white rounded-xl font-bold text-xs shadow-sm transition">
            <span>+ Tambah Printer Baru</span>
        </button>
    </div>

    {{-- PRINTERS GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($printers as $printer)
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-200 flex flex-col justify-between space-y-4">
                <div class="space-y-2">
                    <div class="flex items-start justify-between">
                        <h3 class="font-bold text-stone-900 text-base">{{ $printer->name }}</h3>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase {{ $printer->status === 'ACTIVE' ? 'bg-emerald-100 text-emerald-800' : 'bg-stone-100 text-stone-600' }}">
                            {{ $printer->status }}
                        </span>
                    </div>

                    <div class="space-y-1 text-xs text-stone-600">
                        <div class="flex justify-between">
                            <span class="text-stone-400">Koneksi:</span>
                            <span class="font-bold">{{ $printer->connection_type }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-stone-400">Lebar Kertas:</span>
                            <span class="font-bold">{{ $printer->paper_width }}</span>
                        </div>
                        @if(!empty($printer->settings['ip_address']))
                            <div class="flex justify-between font-mono">
                                <span class="text-stone-400">Alamat IP:</span>
                                <span>{{ $printer->settings['ip_address'] }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="pt-3 border-t border-stone-100 flex items-center justify-between">
                    <button type="button" onclick="testPrint('{{ $printer->name }}', '{{ $printer->paper_width }}')" class="text-xs font-bold text-[#C1440E] hover:underline">
                        Tes Cetak Nota
                    </button>
                    <form action="{{ route('admin.printers.destroy', $printer->id) }}" method="POST" onsubmit="return confirm('Hapus konfigurasi printer ini?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs font-bold text-rose-600 hover:text-rose-800">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-dashed border-stone-300">
                <div class="text-3xl mb-1">🖨️</div>
                <p class="text-stone-500 text-sm font-medium">Belum ada perangkat printer yang dikonfigurasi.</p>
            </div>
        @endforelse
    </div>
</div>

{{-- MODAL ADD PRINTER --}}
<div id="modal-add-printer" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-stone-900/60 backdrop-blur-xs p-4">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-stone-200 overflow-hidden">
        <div class="p-4 bg-stone-900 text-white flex justify-between items-center">
            <h3 class="font-bold text-sm">Tambah Konfigurasi Printer Thermal</h3>
            <button type="button" onclick="document.getElementById('modal-add-printer').classList.add('hidden')" class="text-white hover:text-stone-300 font-bold">✕</button>
        </div>

        <form action="{{ route('admin.printers.store') }}" method="POST" class="p-5 space-y-4 text-xs">
            @csrf

            <div class="space-y-1">
                <label class="block font-bold text-stone-700 uppercase tracking-wider">Nama Printer *</label>
                <input type="text" name="name" required placeholder="Contoh: Thermal Kasir 58mm" class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="block font-bold text-stone-700 uppercase tracking-wider">Jenis Koneksi *</label>
                    <select name="connection_type" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                        <option value="BLUETOOTH">Bluetooth</option>
                        <option value="USB">USB Cable</option>
                        <option value="NETWORK">LAN / WiFi Network</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="block font-bold text-stone-700 uppercase tracking-wider">Lebar Kertas *</label>
                    <select name="paper_width" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                        <option value="58mm">58 mm (Standard POS)</option>
                        <option value="80mm">80 mm (Wide POS)</option>
                    </select>
                </div>
            </div>

            <div class="space-y-1">
                <label class="block font-bold text-stone-700 uppercase tracking-wider">Status Printer *</label>
                <select name="status" required class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
                    <option value="ACTIVE">ACTIVE (Digunakan Kasir)</option>
                    <option value="INACTIVE">INACTIVE (Nonaktif)</option>
                </select>
            </div>

            <div class="space-y-1">
                <label class="block font-bold text-stone-700 uppercase tracking-wider">Alamat IP / Port (Opsional jika Network)</label>
                <input type="text" name="ip_address" placeholder="192.168.1.100:9100" class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-50 text-xs focus:ring-1 focus:ring-[#C1440E]">
            </div>

            <div class="pt-3 flex justify-end gap-2 border-t border-stone-100">
                <button type="button" onclick="document.getElementById('modal-add-printer').classList.add('hidden')" class="px-4 py-2 text-stone-600 font-bold">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-[#C1440E] hover:bg-[#a3380b] text-white font-bold rounded-xl shadow-sm transition">Simpan Printer</button>
            </div>
        </form>
    </div>
</div>

<script>
    function testPrint(name, width) {
        alert('Mengirim sinyal tes cetak ke ' + name + ' (' + width + '). Pastikan perangkat printer terhubung & kertas terpasang.');
    }
</script>
@endsection
