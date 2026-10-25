@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-stone-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
        <div>
            <h1 class="text-lg sm:text-xl font-bold text-stone-900 flex items-center gap-2">
                <span>🖨️</span>
                <span>Konfigurasi Thermal Printer</span>
            </h1>
            <p class="text-xs text-stone-500 mt-0.5">Kelola sambungan printer kasir Bluetooth, USB, atau Jaringan (LAN).</p>
        </div>
        <button type="button" onclick="document.getElementById('modal-add-printer').classList.remove('hidden')" class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 sm:py-2 bg-[#C1440E] hover:bg-[#a3380b] text-white rounded-xl font-bold text-xs shadow-sm transition w-full sm:w-auto">
            <span>+ Tambah Printer Baru</span>
        </button>
    </div>

    {{-- DEDICATED RPP02N DEVICE PROFILE CARD --}}
    <div class="bg-gradient-to-br from-stone-900 via-stone-800 to-stone-900 rounded-3xl p-5 sm:p-6 text-white shadow-xl border border-stone-700/60 relative overflow-hidden">
        <div class="absolute -right-8 -bottom-8 w-48 h-48 bg-[#C1440E]/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 relative z-10">
            <div class="space-y-3 max-w-xl">
                <div class="flex flex-wrap items-center gap-2.5">
                    <span class="px-2.5 py-1 rounded-lg bg-[#C1440E] text-white text-xs font-black tracking-wider uppercase shadow-xs flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[15px]">print</span>
                        <span>Printer Kasir Default</span>
                    </span>
                    <span id="rpp02n-status-badge" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/40">
                        <span id="rpp02n-status-dot" class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span id="rpp02n-status-text">RPP02N Siap Konek</span>
                    </span>
                </div>

                <div class="space-y-1">
                    <h2 class="text-xl sm:text-2xl font-black font-serif text-white tracking-wide">
                        RPP02N <span class="text-stone-300 font-sans font-normal text-sm sm:text-base">(Model: DT-58B)</span>
                    </h2>
                    <p class="text-xs text-stone-300 leading-relaxed">
                        Thermal receipt printer portable 58mm untuk cetak otomatis nota pesanan kasir Yan's Food langsung via Bluetooth 4.0 tanpa dialog cetak atau via kabel data USB.
                    </p>
                </div>

                {{-- SPECS CHIPS --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 pt-1 text-[11px]">
                    <div class="bg-white/10 backdrop-blur-xs p-2.5 rounded-xl border border-white/10">
                        <span class="block text-stone-400 text-[10px]">Nama Bluetooth:</span>
                        <span class="font-bold font-mono text-white">RPP02N</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-xs p-2.5 rounded-xl border border-white/10">
                        <span class="block text-stone-400 text-[10px]">Model:</span>
                        <span class="font-bold text-white">DT-58B</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-xs p-2.5 rounded-xl border border-white/10">
                        <span class="block text-stone-400 text-[10px]">Interface:</span>
                        <span class="font-bold text-white">USB + BT 4.0</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-xs p-2.5 rounded-xl border border-white/10">
                        <span class="block text-stone-400 text-[10px]">Kertas / Daya:</span>
                        <span class="font-bold text-white">58mm / 5V-1A</span>
                    </div>
                </div>
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="flex flex-col sm:flex-row lg:flex-col gap-2.5 shrink-0 justify-center">
                <button 
                    type="button" 
                    id="btn-test-bluetooth"
                    onclick="handleTestBluetooth()"
                    class="px-4 py-3 bg-[#C1440E] hover:bg-[#a3380b] text-white rounded-xl font-bold text-xs shadow-lg transition flex items-center justify-center gap-2 active:scale-95 text-center cursor-pointer"
                >
                    <span class="material-symbols-outlined text-[18px]">bluetooth</span>
                    <span>🖨️ Tes Cetak Bluetooth (RPP02N)</span>
                </button>

                <button 
                    type="button" 
                    onclick="handleTestUsb()"
                    class="px-4 py-2.5 bg-stone-700 hover:bg-stone-600 text-white rounded-xl font-bold text-xs transition flex items-center justify-center gap-2 active:scale-95 text-center cursor-pointer border border-stone-600"
                >
                    <span class="material-symbols-outlined text-[17px]">usb</span>
                    <span>Tes Cetak via USB</span>
                </button>

                <button 
                    type="button" 
                    onclick="window.print()"
                    class="px-4 py-2 bg-stone-800 hover:bg-stone-700 text-stone-300 rounded-xl font-semibold text-[11px] transition flex items-center justify-center gap-1.5 active:scale-95 text-center border border-stone-700"
                >
                    <span class="material-symbols-outlined text-[15px]">print</span>
                    <span>Dialog Windows (58mm)</span>
                </button>
            </div>
        </div>

        {{-- TIPS & GUIDELINES --}}
        <div class="mt-4 pt-4 border-t border-white/10 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-[11px] text-stone-400">
            <div class="flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px] text-amber-400">tips_and_updates</span>
                <span>Nyalakan Bluetooth di HP/Laptop, lalu nyalakan printer RPP02N (LED menyala biru).</span>
            </div>
            <div class="text-stone-300">
                <span>PIN Bluetooth Default: </span>
                <span class="font-mono font-bold bg-white/20 px-1.5 py-0.5 rounded text-white">1234</span> atau <span class="font-mono font-bold bg-white/20 px-1.5 py-0.5 rounded text-white">0000</span>
            </div>
        </div>
    </div>

    {{-- PRINTERS GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($printers as $printer)
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-200 flex flex-col justify-between space-y-4">
                <div class="space-y-2">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="font-bold text-stone-900 text-base">{{ $printer->name }}</h3>
                            @if(!empty($printer->settings['model']))
                                <span class="text-[11px] text-stone-500 font-mono">{{ $printer->settings['model'] }} ({{ $printer->settings['interface'] ?? 'USB/BT' }})</span>
                            @endif
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase {{ strtoupper($printer->status) === 'ACTIVE' ? 'bg-emerald-100 text-emerald-800' : 'bg-stone-100 text-stone-600' }}">
                            {{ $printer->status }}
                        </span>
                    </div>

                    <div class="space-y-1 text-xs text-stone-600">
                        <div class="flex justify-between">
                            <span class="text-stone-400">Koneksi:</span>
                            <span class="font-bold">{{ strtoupper($printer->connection_type) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-stone-400">Lebar Kertas:</span>
                            <span class="font-bold">{{ $printer->paper_width }}</span>
                        </div>
                        @if(!empty($printer->settings['output']))
                            <div class="flex justify-between font-mono">
                                <span class="text-stone-400">Daya Adaptor:</span>
                                <span>{{ $printer->settings['output'] }}</span>
                            </div>
                        @endif
                        @if(!empty($printer->settings['ip_address']))
                            <div class="flex justify-between font-mono">
                                <span class="text-stone-400">Alamat IP:</span>
                                <span>{{ $printer->settings['ip_address'] }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="pt-3 border-t border-stone-100 flex items-center justify-between">
                    <button type="button" onclick="testPrint('{{ $printer->name }}', '{{ $printer->paper_width }}')" class="text-xs font-bold text-[#C1440E] hover:underline flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">print</span>
                        <span>Tes Cetak Nota</span>
                    </button>
                    @if($printer->name !== 'RPP02N (DT-58B)')
                        <form action="{{ route('admin.printers.destroy', $printer->id) }}" method="POST" onsubmit="return confirm('Hapus konfigurasi printer ini?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-bold text-rose-600 hover:text-rose-800">
                                Hapus
                            </button>
                        </form>
                    @else
                        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full">Default POS</span>
                    @endif
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
    async function handleTestBluetooth() {
        const btn = document.getElementById('btn-test-bluetooth');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = `<span class="material-symbols-outlined text-[18px] animate-spin">refresh</span><span>Menghubungkan ke RPP02N...</span>`;
        }
        try {
            if (window.RPP02N) {
                await window.RPP02N.testPrint();
            } else {
                alert('Driver printer belum dimuat.');
            }
        } catch (e) {
            console.error(e);
        } finally {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = `<span class="material-symbols-outlined text-[18px]">bluetooth</span><span>🖨️ Tes Cetak Bluetooth (RPP02N)</span>`;
            }
        }
    }

    async function handleTestUsb() {
        if (!navigator.serial) {
            alert('Web Serial USB didukung pada Google Chrome & Edge desktop. Pastikan kabel data terpasang ke laptop/PC. Atau gunakan opsi Dialog Windows (58mm).');
            window.print();
            return;
        }

        const testData = {
            header: { store_name: "YAN'S FOOD", address: "Bandung, Kp. Ciloa, RT.04/RW.10", phone: "082221222936" },
            order_info: { number: "USB-TEST", customer: "Tes USB", cashier: "Admin", date: new Date().toLocaleDateString('id-ID'), time: "12:00 WIB" },
            items: [{ name: "Tes Kabel Data USB RPP02N", qty: 1, price: 0, subtotal: 0 }],
            summary: { subtotal: 0, discount: 0, total: 0 },
            payment: { method: "USB", paid: 0, change: 0 },
            footer: { message: "Tes USB Berhasil!", sub_message: "Printer RPP02N Siap Digunakan" }
        };

        try {
            await window.RPP02N.printUsb(testData);
        } catch (e) {
            alert('Gagal tes USB: ' + e.message);
        }
    }

    function testPrint(name, width) {
        if (name.includes('RPP02N') || name.includes('DT-58B')) {
            handleTestBluetooth();
        } else {
            alert('Mengirim sinyal tes cetak ke ' + name + ' (' + width + '). Pastikan perangkat terhubung.');
            window.print();
        }
    }
</script>
@endsection
