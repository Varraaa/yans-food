@extends('layouts.admin')

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">
    {{-- PAGE HEADER (NO CRUD) --}}
    <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-stone-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-lg sm:text-xl font-bold text-stone-900 flex items-center gap-2">
                <span>🖨️</span>
                <span>Thermal Printer Kasir</span>
            </h1>
            <p class="text-xs text-stone-500 mt-0.5">
                Perangkat cetak struk nota pesanan resmi Yan's Food (RPP02N / Model DT-58B).
            </p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Printer Siap Digunakan</span>
            </span>
        </div>
    </div>

    {{-- DEDICATED RPP02N DEVICE PROFILE CARD --}}
    <div class="bg-gradient-to-br from-stone-900 via-stone-800 to-stone-900 rounded-3xl p-5 sm:p-7 text-white shadow-xl border border-stone-700/60 relative overflow-hidden">
        <div class="absolute -right-8 -bottom-8 w-56 h-56 bg-[#C1440E]/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 relative z-10">
            <div class="space-y-3.5 max-w-xl">
                <div class="flex flex-wrap items-center gap-2.5">
                    <span class="px-2.5 py-1 rounded-lg bg-[#C1440E] text-white text-xs font-black tracking-wider uppercase shadow-xs flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[15px]">print</span>
                        <span>Printer Resmi Yan's Food</span>
                    </span>
                    <span id="rpp02n-status-badge" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/40">
                        <span id="rpp02n-status-dot" class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span id="rpp02n-status-text">RPP02N Aktif</span>
                    </span>
                </div>

                <div class="space-y-1">
                    <h2 class="text-xl sm:text-2xl font-black font-serif text-white tracking-wide">
                        RPP02N <span class="text-stone-300 font-sans font-normal text-sm sm:text-base">(Model: DT-58B)</span>
                    </h2>
                    <p class="text-xs text-stone-300 leading-relaxed">
                        Thermal receipt printer portable 58mm untuk cetak otomatis struk nota kasir Yan's Food melalui koneksi nirkabel Bluetooth 4.0 atau sambungan kabel data USB.
                    </p>
                </div>

                {{-- SPECS CHIPS --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 pt-1 text-[11px]">
                    <div class="bg-white/10 backdrop-blur-xs p-2.5 rounded-xl border border-white/10">
                        <span class="block text-stone-400 text-[10px]">Nama Bluetooth:</span>
                        <span class="font-bold font-mono text-white">RPP02N</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-xs p-2.5 rounded-xl border border-white/10">
                        <span class="block text-stone-400 text-[10px]">Model Perangkat:</span>
                        <span class="font-bold text-white">DT-58B</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-xs p-2.5 rounded-xl border border-white/10">
                        <span class="block text-stone-400 text-[10px]">Interface:</span>
                        <span class="font-bold text-white">Bluetooth + USB</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-xs p-2.5 rounded-xl border border-white/10">
                        <span class="block text-stone-400 text-[10px]">Kertas / Daya:</span>
                        <span class="font-bold text-white">58mm / 5V-1A</span>
                    </div>
                </div>
            </div>

            {{-- 2 ACTION BUTTONS (BLUETOOTH & USB ONLY) --}}
            <div class="flex flex-col sm:flex-row lg:flex-col gap-3 shrink-0 justify-center w-full sm:w-auto">
                {{-- 1. CETAK BLUETOOTH --}}
                <button 
                    type="button" 
                    id="btn-test-bluetooth"
                    onclick="handleTestBluetooth()"
                    class="px-5 py-3.5 bg-[#C1440E] hover:bg-[#a3380b] text-white rounded-xl font-bold text-xs shadow-lg transition flex items-center justify-center gap-2 active:scale-95 text-center cursor-pointer"
                >
                    <span class="material-symbols-outlined text-[19px]">bluetooth</span>
                    <span>🖨️ Tes Cetak via Bluetooth (RPP02N)</span>
                </button>

                {{-- 2. CETAK USB --}}
                <button 
                    type="button" 
                    onclick="handleTestUsb()"
                    class="px-5 py-3 bg-stone-700 hover:bg-stone-600 text-white rounded-xl font-bold text-xs transition flex items-center justify-center gap-2 active:scale-95 text-center cursor-pointer border border-stone-600"
                >
                    <span class="material-symbols-outlined text-[18px]">usb</span>
                    <span>🔌 Tes Cetak via Kabel USB</span>
                </button>
            </div>
        </div>

        {{-- TIPS & GUIDELINES PADA KARTU --}}
        <div class="mt-5 pt-4 border-t border-white/10 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 text-[11px] text-stone-400">
            <div class="flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px] text-amber-400">tips_and_updates</span>
                <span>Nyalakan Bluetooth di HP/Laptop, pastikan printer RPP02N menyala (lampu indikator biru).</span>
            </div>
            <div class="text-stone-300">
                <span>PIN Bluetooth Default: </span>
                <span class="font-mono font-bold bg-white/20 px-1.5 py-0.5 rounded text-white">1234</span> atau <span class="font-mono font-bold bg-white/20 px-1.5 py-0.5 rounded text-white">0000</span>
            </div>
        </div>
    </div>

    {{-- CARA PENGGUNAAN PADA KASIR POS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- CARD BLUETOOTH GUIDE --}}
        <div class="bg-white p-5 rounded-2xl border border-stone-200 shadow-sm space-y-3">
            <div class="flex items-center gap-2.5 text-[#C1440E]">
                <div class="w-9 h-9 rounded-xl bg-orange-50 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[20px]">bluetooth</span>
                </div>
                <h3 class="font-bold text-stone-900 text-sm">Mode 1: Cetak via Bluetooth (Nirkabel)</h3>
            </div>
            <ul class="text-xs text-stone-600 space-y-2 leading-relaxed">
                <li class="flex items-start gap-2">
                    <span class="text-emerald-600 font-bold">✓</span>
                    <span>Bisa digunakan dari HP (Android), Tablet, atau Laptop yang memiliki Bluetooth.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-emerald-600 font-bold">✓</span>
                    <span>Pada halaman <strong>Kasir (POS)</strong>, setelah pembayaran Tunai/QRIS selesai, klik tombol <strong>"Cetak Nota"</strong>.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-emerald-600 font-bold">✓</span>
                    <span>Pilih perangkat <strong>RPP02N</strong> pada jendela pencarian Bluetooth browser. Printer langsung mencetak nota fisik seketika.</span>
                </li>
            </ul>
        </div>

        {{-- CARD USB GUIDE --}}
        <div class="bg-white p-5 rounded-2xl border border-stone-200 shadow-sm space-y-3">
            <div class="flex items-center gap-2.5 text-stone-700">
                <div class="w-9 h-9 rounded-xl bg-stone-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[20px]">usb</span>
                </div>
                <h3 class="font-bold text-stone-900 text-sm">Mode 2: Cetak via Kabel USB (Direct Cable)</h3>
            </div>
            <ul class="text-xs text-stone-600 space-y-2 leading-relaxed">
                <li class="flex items-start gap-2">
                    <span class="text-emerald-600 font-bold">✓</span>
                    <span>Digunakan ketika printer tersambung menggunakan kabel data USB ke PC/Laptop kasir.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-emerald-600 font-bold">✓</span>
                    <span>Didukung pada browser <strong>Google Chrome</strong> atau <strong>Microsoft Edge</strong> desktop via Web Serial.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-emerald-600 font-bold">✓</span>
                    <span>Stabil dan tidak memerlukan koneksi baterai/bluetooth saat kasir beroperasi seharian.</span>
                </li>
            </ul>
        </div>
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
                btn.innerHTML = `<span class="material-symbols-outlined text-[19px]">bluetooth</span><span>🖨️ Tes Cetak via Bluetooth (RPP02N)</span>`;
            }
        }
    }

    async function handleTestUsb() {
        if (!navigator.serial) {
            alert('Fitur Web USB didukung pada Google Chrome atau Microsoft Edge desktop. Pastikan kabel data terpasang ke laptop/PC kasir.');
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
</script>
@endsection
