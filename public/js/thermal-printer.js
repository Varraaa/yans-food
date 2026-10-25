/**
 * Yan's Food — RPP02N (Model: DT-58B) Bluetooth & USB Thermal Printer Driver
 * Specifically built for:
 * - Device: RPP02N
 * - Model: DT-58B (58mm POS Thermal Printer)
 * - Interfaces: Bluetooth 4.0 (BLE) + USB
 * - Character width: 32 chars per line (Standard 58mm Font A)
 */

(function (window) {
    'use strict';

    const PRINTER_CONFIG = {
        name: 'RPP02N',
        model: 'DT-58B',
        paperWidth: '58mm',
        charsPerLine: 32,
        baudRate: 9600,
        knownServices: [
            '000018f0-0000-1000-8000-00805f9b34fb',
            '0000e781-0000-1000-8000-00805f9b34fb',
            '0000ff00-0000-1000-8000-00805f9b34fb',
            '0000fee7-0000-1000-8000-00805f9b34fb',
            '49535343-fe7d-4ae5-8fa9-9fafd205e455',
            0x18f0,
            0xff00,
            0xe781,
            0xfee7
        ]
    };

    let bluetoothDevice = null;
    let writeCharacteristic = null;

    class EscPosBuilder {
        constructor(width = 32) {
            this.width = width;
            this.buffer = [];
        }

        addBytes(...bytes) {
            for (let i = 0; i < bytes.length; i++) {
                this.buffer.push(bytes[i]);
            }
            return this;
        }

        init() {
            return this.addBytes(0x1B, 0x40); // ESC @
        }

        alignLeft() {
            return this.addBytes(0x1B, 0x61, 0x00);
        }

        alignCenter() {
            return this.addBytes(0x1B, 0x61, 0x01);
        }

        alignRight() {
            return this.addBytes(0x1B, 0x61, 0x02);
        }

        boldOn() {
            return this.addBytes(0x1B, 0x45, 0x01);
        }

        boldOff() {
            return this.addBytes(0x1B, 0x45, 0x00);
        }

        doubleHeightOn() {
            return this.addBytes(0x1D, 0x21, 0x01);
        }

        doubleSizeOn() {
            return this.addBytes(0x1D, 0x21, 0x11);
        }

        normalSize() {
            return this.addBytes(0x1D, 0x21, 0x00);
        }

        lineFeed(n = 1) {
            for (let i = 0; i < n; i++) {
                this.addBytes(0x0A);
            }
            return this;
        }

        feedAndCut() {
            // Feed 4-5 lines so paper passes the cutter blade on DT-58B
            this.addBytes(0x1B, 0x64, 0x04);
            // Optional cut command (GS V 0) for models with auto-cut
            this.addBytes(0x1D, 0x56, 0x00);
            return this;
        }

        text(str) {
            // Encode clean ASCII/Latin1
            const cleaned = (str || '').replace(/[^\x20-\x7E\xA0-\xFF]/g, ' ');
            for (let i = 0; i < cleaned.length; i++) {
                this.buffer.push(cleaned.charCodeAt(i));
            }
            return this;
        }

        textLine(str = '') {
            return this.text(str).lineFeed();
        }

        separator(char = '-') {
            return this.textLine(char.repeat(this.width));
        }

        doubleSeparator() {
            return this.textLine('='.repeat(this.width));
        }

        centerText(str) {
            const s = (str || '').trim();
            if (s.length >= this.width) return this.textLine(s.slice(0, this.width));
            const left = Math.floor((this.width - s.length) / 2);
            return this.textLine(' '.repeat(left) + s);
        }

        justify(leftStr, rightStr) {
            const left = (leftStr || '').toString();
            const right = (rightStr || '').toString();
            const available = this.width - left.length - right.length;
            if (available <= 0) {
                // Wrap into 2 lines if too wide
                this.textLine(left);
                const pad = Math.max(0, this.width - right.length);
                return this.textLine(' '.repeat(pad) + right);
            }
            return this.textLine(left + ' '.repeat(available) + right);
        }

        getBytes() {
            return new Uint8Array(this.buffer);
        }
    }

    /**
     * Format standard transaction data into ESC/POS binary stream for DT-58B
     */
    function buildEscPosFromReceipt(data) {
        const builder = new EscPosBuilder(PRINTER_CONFIG.charsPerLine);
        const header = data.header || {};
        const order = data.order_info || {};
        const items = data.items || [];
        const summary = data.summary || {};
        const payment = data.payment || {};
        const footer = data.footer || {};

        builder.init();

        // 1. Header (Centered, bold title)
        builder.alignCenter();
        builder.boldOn().doubleHeightOn();
        builder.textLine(header.store_name || "YAN'S FOOD");
        builder.normalSize().boldOff();
        builder.textLine("Dapur Kuliner Rumahan");
        builder.textLine(header.address || "Bandung, Kp. Ciloa, RT.04/RW.10");
        builder.textLine("WA: " + (header.phone || "082221222936"));
        builder.doubleSeparator();

        // 2. Meta Info (No transaksi, Tanggal, Kasir, Pelanggan)
        builder.alignLeft();
        builder.justify("No Transaksi:", order.number || "-");
        builder.justify("Tanggal:", (order.date || "") + " " + (order.time || ""));
        builder.justify("Kasir:", order.cashier || "Kasir");
        builder.justify("Pelanggan:", order.customer || "Umum");
        builder.separator('-');

        // 3. Items list
        for (let i = 0; i < items.length; i++) {
            const it = items[i];
            const name = it.name || "Menu";
            const qty = it.qty || 1;
            const price = Number(it.price || 0).toLocaleString('id-ID');
            const subtotal = Number(it.subtotal || (qty * (it.price || 0))).toLocaleString('id-ID');

            builder.textLine(name);
            builder.justify(`  ${qty} x ${price}`, subtotal);
        }
        builder.separator('-');

        // 4. Totals & Payment Summary
        const subtotalStr = "Rp " + Number(summary.subtotal || 0).toLocaleString('id-ID');
        const discountVal = Number(summary.discount || 0);
        const totalStr = "Rp " + Number(summary.total || 0).toLocaleString('id-ID');
        const methodStr = (payment.method || "CASH").toString().toUpperCase();
        const paidStr = "Rp " + Number(payment.paid || 0).toLocaleString('id-ID');
        const changeStr = "Rp " + Number(payment.change || 0).toLocaleString('id-ID');

        builder.justify("Subtotal:", subtotalStr);
        if (discountVal > 0) {
            builder.justify("Diskon:", "-Rp " + discountVal.toLocaleString('id-ID'));
        }

        builder.boldOn();
        builder.justify("TOTAL:", totalStr);
        builder.boldOff();

        builder.justify("Metode Bayar:", methodStr);
        builder.justify("Bayar Tunai:", paidStr);
        builder.boldOn();
        builder.justify("Kembali:", changeStr);
        builder.boldOff();

        builder.doubleSeparator();

        // 5. Footer
        builder.alignCenter();
        builder.textLine(footer.message || "Terima Kasih!");
        builder.textLine(footer.sub_message || "Selamat Menikmati Hidangan");
        builder.doubleSeparator();

        // Feed paper past tear bar
        builder.feedAndCut();

        return builder.getBytes();
    }

    /**
     * Show friendly notifications on screen
     */
    function showToast(message, type = 'info', duration = 4000) {
        let toastContainer = document.getElementById('rpp02n-toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'rpp02n-toast-container';
            toastContainer.className = 'fixed bottom-5 right-5 z-[9999] flex flex-col gap-2 pointer-events-none';
            document.body.appendChild(toastContainer);
        }

        const toast = document.createElement('div');
        const bgColors = {
            info: 'bg-stone-900 text-white border-stone-700',
            success: 'bg-emerald-700 text-white border-emerald-600',
            warning: 'bg-amber-600 text-white border-amber-500',
            error: 'bg-rose-700 text-white border-rose-600'
        };

        const icons = {
            info: 'print',
            success: 'check_circle',
            warning: 'warning',
            error: 'error'
        };

        toast.className = `pointer-events-auto px-4 py-3 rounded-2xl shadow-xl border text-xs sm:text-sm font-semibold flex items-center gap-2.5 transition-all duration-300 transform translate-y-4 opacity-0 ${bgColors[type] || bgColors.info}`;
        toast.innerHTML = `
            <span class="material-symbols-outlined text-[20px] shrink-0">${icons[type] || 'print'}</span>
            <span>${message}</span>
        `;

        toastContainer.appendChild(toast);

        // Animate In
        requestAnimationFrame(() => {
            toast.classList.remove('translate-y-4', 'opacity-0');
        });

        // Animate Out & Remove
        setTimeout(() => {
            toast.classList.add('translate-y-4', 'opacity-0');
            setTimeout(() => toast.remove(), 300);
        }, duration);
    }

    /**
     * Send raw byte buffer to Bluetooth GATT characteristic in safe packets
     */
    async function sendBufferToCharacteristic(characteristic, buffer) {
        const chunkSize = 128; // Safe chunk size for Bluetooth LE DT-58B / RPP02N
        for (let i = 0; i < buffer.length; i += chunkSize) {
            const chunk = buffer.slice(i, i + chunkSize);
            if (characteristic.writeValueWithoutResponse) {
                await characteristic.writeValueWithoutResponse(chunk);
            } else {
                await characteristic.writeValue(chunk);
            }
            // Small pause between chunks to avoid buffer overflow on microcontroller
            await new Promise(r => setTimeout(r, 30));
        }
    }

    /**
     * Connect to RPP02N DT-58B via Web Bluetooth
     */
    async function connectBluetoothPrinter() {
        if (!navigator.bluetooth) {
            throw new Error("Browser Anda belum mendukung Web Bluetooth. Silakan gunakan Google Chrome / Microsoft Edge versi terbaru, atau gunakan opsi Cetak via Windows / USB.");
        }

        if (bluetoothDevice && bluetoothDevice.gatt.connected && writeCharacteristic) {
            return { device: bluetoothDevice, characteristic: writeCharacteristic };
        }

        showToast("Mencari perangkat Bluetooth RPP02N...", "info", 3000);

        try {
            // First attempt: filter by name or known prefixes
            bluetoothDevice = await navigator.bluetooth.requestDevice({
                filters: [
                    { name: 'RPP02N' },
                    { namePrefix: 'RPP' },
                    { namePrefix: 'DT-58' },
                    { namePrefix: 'POS' },
                    { namePrefix: 'Printer' },
                    { namePrefix: 'MTP' },
                    { namePrefix: 'BlueTooth' }
                ],
                optionalServices: PRINTER_CONFIG.knownServices
            });
        } catch (filterErr) {
            // If user cancelled, rethrow
            if (filterErr.name === 'NotFoundError') {
                // Fallback attempt: show all devices
                bluetoothDevice = await navigator.bluetooth.requestDevice({
                    acceptAllDevices: true,
                    optionalServices: PRINTER_CONFIG.knownServices
                });
            } else {
                throw filterErr;
            }
        }

        if (!bluetoothDevice) {
            throw new Error("Tidak ada perangkat printer yang dipilih.");
        }

        bluetoothDevice.addEventListener('gattserverdisconnected', () => {
            writeCharacteristic = null;
            showToast("Koneksi Bluetooth ke " + bluetoothDevice.name + " terputus.", "warning");
            updatePrinterStatusBadge(false);
        });

        showToast(`Menghubungkan ke ${bluetoothDevice.name || 'RPP02N'}...`, "info", 3000);

        const server = await bluetoothDevice.gatt.connect();
        updatePrinterStatusBadge(true, bluetoothDevice.name);

        // Search for writable characteristic across all services
        const services = await server.getPrimaryServices().catch(() => []);
        
        for (const service of services) {
            const characteristics = await service.getCharacteristics().catch(() => []);
            for (const char of characteristics) {
                if (char.properties.write || char.properties.writeWithoutResponse) {
                    writeCharacteristic = char;
                    break;
                }
            }
            if (writeCharacteristic) break;
        }

        // If not found in primary list, try known standard printer services
        if (!writeCharacteristic) {
            for (const serviceUuid of PRINTER_CONFIG.knownServices) {
                try {
                    const service = await server.getPrimaryService(serviceUuid);
                    const chars = await service.getCharacteristics();
                    for (const char of chars) {
                        if (char.properties.write || char.properties.writeWithoutResponse) {
                            writeCharacteristic = char;
                            break;
                        }
                    }
                    if (writeCharacteristic) break;
                } catch (e) {
                    // Try next
                }
            }
        }

        if (!writeCharacteristic) {
            throw new Error(`Berhasil terhubung ke ${bluetoothDevice.name}, tetapi tidak menemukan kanal cetak yang sesuai.`);
        }

        localStorage.setItem('rpp02n_connected_name', bluetoothDevice.name || 'RPP02N');
        return { device: bluetoothDevice, characteristic: writeCharacteristic };
    }

    /**
     * Connect to RPP02N DT-58B via Web Serial (USB Cable)
     */
    async function printUsbSerial(receiptData) {
        if (!navigator.serial) {
            throw new Error("Browser Anda belum mendukung Web Serial USB. Silakan gunakan Google Chrome / Edge versi desktop, atau gunakan dialog cetak Windows.");
        }

        showToast("Menghubungkan kabel USB ke printer kasir...", "info", 3000);

        const port = await navigator.serial.requestPort();
        await port.open({ baudRate: PRINTER_CONFIG.baudRate });

        try {
            const buffer = buildEscPosFromReceipt(receiptData);
            const writer = port.writable.getWriter();
            await writer.write(buffer);
            writer.releaseLock();
            showToast("Struk berhasil dikirim ke printer via USB!", "success", 4000);
        } finally {
            await port.close();
        }
    }

    /**
     * Main Direct Print Function for RPP02N
     */
    async function printToRPP02N(receiptData, options = {}) {
        try {
            showToast("Menyiapkan cetakan thermal RPP02N (DT-58B)...", "info", 2500);

            // 1. Try Bluetooth first
            const { device, characteristic } = await connectBluetoothPrinter();
            showToast(`Mengirim data struk ke ${device.name || 'RPP02N'}...`, "info", 3000);

            const buffer = buildEscPosFromReceipt(receiptData);
            await sendBufferToCharacteristic(characteristic, buffer);

            showToast(`Struk BERHASIL dicetak di ${device.name || 'RPP02N'}!`, "success", 5000);
            return true;
        } catch (err) {
            console.error("RPP02N Print Error:", err);
            
            // If user explicitly aborted dialog, do nothing
            if (err.name === 'NotFoundError' || err.message.includes('User cancelled')) {
                showToast("Pencarian printer Bluetooth dibatalkan.", "warning", 3000);
                return false;
            }

            // Offer fallback to Windows System Print Dialog
            const useFallback = confirm(
                `Koneksi Bluetooth ke RPP02N gagal: ${err.message}\n\nIngin mencetak menggunakan Dialog Cetak Windows / USB sekarang?`
            );

            if (useFallback) {
                window.print();
            }
            return false;
        }
    }

    /**
     * Update UI Status Badge if elements exist
     */
    function updatePrinterStatusBadge(isConnected, deviceName = 'RPP02N') {
        const badge = document.getElementById('rpp02n-status-badge');
        const text = document.getElementById('rpp02n-status-text');
        const dot = document.getElementById('rpp02n-status-dot');

        if (badge) {
            if (isConnected) {
                badge.className = 'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300 shadow-2xs';
                if (text) text.textContent = `${deviceName} Terhubung`;
                if (dot) dot.className = 'w-2 h-2 rounded-full bg-emerald-500 animate-pulse';
            } else {
                badge.className = 'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-stone-100 text-stone-700 border border-stone-300';
                if (text) text.textContent = 'RPP02N Siap Konek';
                if (dot) dot.className = 'w-2 h-2 rounded-full bg-stone-400';
            }
        }
    }

    /**
     * Test print action for admin settings
     */
    async function testPrintRPP02N() {
        const testReceipt = {
            header: {
                store_name: "YAN'S FOOD",
                address: "Bandung, Kp. Ciloa, RT.04/RW.10",
                phone: "082221222936"
            },
            order_info: {
                number: "TEST-" + Math.floor(1000 + Math.random() * 9000),
                customer: "Pelanggan Tes",
                cashier: "Admin Kasir",
                date: new Date().toLocaleDateString('id-ID'),
                time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + " WIB"
            },
            items: [
                { name: "Tes Koneksi Printer RPP02N", qty: 1, price: 0, subtotal: 0 },
                { name: "Model: DT-58B (58mm)", qty: 1, price: 0, subtotal: 0 }
            ],
            summary: {
                subtotal: 0,
                discount: 0,
                total: 0
            },
            payment: {
                method: "TEST-PRINT",
                paid: 0,
                change: 0
            },
            footer: {
                message: "Tes Cetak Thermal Berhasil!",
                sub_message: "Printer RPP02N Siap Digunakan Kasir"
            }
        };

        return await printToRPP02N(testReceipt);
    }

    // Expose Global Public API
    window.RPP02N = {
        config: PRINTER_CONFIG,
        print: printToRPP02N,
        printUsb: printUsbSerial,
        testPrint: testPrintRPP02N,
        connectBluetooth: connectBluetoothPrinter,
        buildEscPos: buildEscPosFromReceipt,
        showToast: showToast
    };

})(window);
