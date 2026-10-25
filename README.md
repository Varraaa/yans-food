# 🍱 Yan's Food — Platform Terpadu POS Kasir, Manajemen Resto & Profil Usaha

<p align="center">
  <img src="public/images/logo/Logo Yans Food.svg" alt="Yan's Food Logo" width="160" style="border-radius: 16px; box-shadow: 0 8px 24px rgba(0,0,0,0.12);">
</p>

<p align="center">
  <strong>Dokumentasi Sistem Terpadu, Arsitektur Perangkat Lunak, dan Basis Data</strong><br>
  <em>"Cita Rasa Rumahan Disajikan dengan Hati — Kudapan Renyah & Makanan Hangat Bernutrisi"</em>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Framework-Laravel_12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/Styling-Tailwind_CSS_v4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Language-PHP_8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/Database-MySQL_8.x-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Hardware-RPP02N_(DT--58B)-10B981?style=for-the-badge&logo=bluetooth&logoColor=white" alt="Thermal Printer">
</p>

---

## 💡 1. Konsep Dasar & Filosofi Bisnis

### A. Latar Belakang & Identitas Usaha
**Yan's Food** adalah unit usaha kuliner yang berfokus pada olahan masakan khas rumahan berkualitas tinggi, aneka kudapan renyah tradisional, serta makanan hangat bernutrisi harian. Mengusung nilai utama *"Cita Rasa Rumahan Disajikan dengan Hati"*, seluruh produk diolah dari bahan baku berkualitas, terjamin higienis, dan disajikan hangat langsung dari dapur.

### B. Problem Statement & Solusi Digital
Dalam operasional harian gerai makanan cepat saji rumahan, terdapat beberapa kendala utama:
1. **Pencatatan Kasir & Sinkronisasi Stok:** Selisih antara uang fisik di laci kasir dan sisa stok barang, serta risiko kesalahan perhitungan manual saat jam ramai pelanggan.
2. **Snapshot Riwayat Transaksi:** Kebutuhan memastikan data transaksi historis tetap valid dan tidak berubah ketika harga menu di katalog diperbarui di kemudian hari.
3. **Pembukuan Keuangan Terpadu:** Pengeluaran dapur (bahan mentah, gas LPG, minyak goreng, kemasan takeaway, biaya listrik & air) harus terkoneksi langsung dengan omset penjualan kasir untuk mengetahui laba bersih riil (*simple net profit*).
4. **Dukungan Perangkat Kasir Mandiri:** Cetak struk belanja thermal secara instan tanpa ketergantungan driver rumit atau dialog cetak browser yang mengganggu kecepatan pelayanan kasir.
5. **Kanal Pemesanan Jelas:** Menghadirkan profil usaha yang membedakan saluran online delivery, pemesanan langsung di tempat (takeaway drive-thru), dan pesanan katering partai besar.

**Solusi Terpadu Yan's Food:**  
Membangun satu ekosistem web modern yang mengintegrasikan **Website Profil Usaha Publik** (katalog 40 menu resmi, citra brand, kanal pesan delivery, dan panduan takeaway) dengan **Admin Back-Office & POS Panel** (kasir kilat Tunai/QRIS, manajemen stok, resep *Bill of Materials*, buku pengeluaran operasional, laporan keuangan, dan driver printer thermal RPP02N via Web Bluetooth & USB).

---

## 🔄 2. Alur Operasional & Logika Bisnis (Core Business Workflow)

Sistem dirancang mengadopsi prinsip **Single Source of Truth** — seluruh data produk, kalkulasi transaksi kasir, pemotongan stok otomatis, dan perhitungan keuangan dikelola secara terpusat di sisi server (*server-side truth*) untuk mencegah manipulasi angka.

```
┌──────────────────────────────────────────────────────────────────────────────────┐
│                             EKOSISTEM DIGITAL YAN'S FOOD                         │
└────────────────────────────────────────┬─────────────────────────────────────────┘
                                         │
        ┌────────────────────────────────┴────────────────────────────────┐
        ▼                                                                 ▼
┌───────────────────────────────┐               ┌───────────────────────────────────┐
│     SISI PUBLIK (KONSUMEN)    │               │     SISI BACK-OFFICE (ADMIN & POS)│
├───────────────────────────────┤               ├───────────────────────────────────┤
│ • Profil Dapur & Kisah Usaha  │               │ • Kasir POS Cepat (Tunai & QRIS)  │
│ • Katalog 40 Menu Resmi       │               │ • Cetak Struk RPP02N (BT / USB)   │
│ • Foto Produk Dedikasi 1:1    │──────────────▶│ • Pemotongan Stok via Trigger     │
│ • Kanal Online Delivery Mitra │               │ • Manajemen Resep / BOM Bahan     │
│ • Panduan Pesan Bawa Pulang   │               │ • Buku Biaya Operasional Toko     │
│ • Form Katering via WhatsApp  │               │ • Laporan Omset, Laba & Ekspor CSV│
└───────────────────────────────┘               └───────────────────────────────────┘
```

---

### A. Alur Pemesanan Publik (2 Saluran Utama & Katering)
1. **Eksplorasi Menu & Informasi:** Konsumen menjelajahi katalog kuliner lengkap dengan foto eksklusif 1:1, deskripsi cita rasa, porsi, dan harga resmi.
2. **Kanal 1 — Online Delivery (Mitra Resmi):** Konsumen diarahkan ke platform partner resmi (**ShopeeFood, GoFood, GrabFood**) untuk pengantaran cepat ke lokasi pemesan.
3. **Kanal 2 — Datang Langsung ke Tempat (Pesan & Bawa Pulang / Takeaway):** Konsumen datang langsung ke lokasi dapur Yan's Food, memesan di kasir, menunggu hidangan dimasak/digoreng hangat dadakan, menerima pesanan terkemas rapi, lalu membawanya pulang (**Khusus Takeaway / Tidak Melayani Dine-in**).
4. **Saluran Katering Acara (Khusus Non-Sistem):** Permintaan porsi besar atau konsumsi acara khusus difasilitasi melalui formulir kontak yang terhubung langsung ke WhatsApp Admin untuk negosiasi kesepakatan harga dan jadwal dapur.

---

### B. Alur Point of Sale (POS) & Keamanan Kasir
Sistem kasir POS dioptimalkan untuk kecepatan pelayanan di meja kasir:
1. **Penyajian Produk Aktif:** Hanya produk berstatus `Sedia` (*available*) dengan kuantitas stok memadai yang dapat dipilih kasir.
2. **Metode Pembayaran:**
   - **Tunai (Cash):** Dilengkapi kalkulator pecahan uang cepat (*quick cash chips*) dan hitungan nominal kembalian otomatis.
   - **QRIS (Cashless):** Menampilkan QRIS dinamis/statis toko yang dapat dipindai oleh semua aplikasi perbankan & e-wallet.
3. **Penyimpanan Snapshot Historis:** Saat transaksi disimpan, nama produk dan harga jual saat itu disalin permanen ke `transaction_items` agar data masa lalu tidak terdistorsi jika ada penyesuaian harga di masa depan.
4. **Pengurangan Stok Otomatis:** Trigger database memotong stok fisik di tabel produk seketika saat item transaksi tersimpan.
5. **Cetak Struk Fisik Thermal:** Struk dicetak secara langsung (*silent printing*) ke printer **RPP02N (DT-58B)** menggunakan transmisi biner ESC/POS tanpa memunculkan kotak dialog cetak browser.

---

### C. Konsep Perhitungan Laba Bersih (*Simple Net Profit*)
Sistem keuangan mengintegrasikan pendapatan transaksi kasir dan seluruh biaya operasional dapur secara real-time:

$$\text{Laba Bersih Sederhana} = \text{Total Penjualan Kasir POS} - \text{Total Biaya Operasional}$$

- **Penjualan POS Kasir:** Menjumlahkan seluruh transaksi valid berstatus `completed`.
- **Biaya Operasional:** Menampung pengeluaran operasional yang disetujui (*Approved*), mencakup Bahan Baku, Gas Dapur, Listrik, Air, Kemasan/Packaging, Transportasi, Peralatan, Pemeliharaan, dan Biaya Lain-lain.

---

## 🖨️ 3. Spesifikasi & Integrasi Hardware Printer Thermal

Sistem telah terintegrasi langsung dengan printer thermal mini fisik:

| Parameter | Spesifikasi Perangkat |
| :--- | :--- |
| **Model / Nama Perangkat** | **RPP02N (Model: DT-58B)** |
| **Lebar Kertas** | 58 mm (32 karakter per baris) |
| **Daya & Arus** | DC 5V – 1A / Rechargeable Battery |
| **Protokol Perintah** | ESC/POS Binary Command Set |
| **Mode Koneksi 1** | **Bluetooth Low Energy / Classic** via Web Bluetooth API |
| **Mode Koneksi 2** | **USB Direct** via Web Serial / WebUSB API |
| **Karakteristik Cetak** | Langsung cetak fisik tanpa pop-up dialog print browser |

Driver modul JavaScript printer berada pada [`public/js/thermal-printer.js`](file:///c:/SEKOLAH/12semester1/PROD%20(PA%20ANGGA)/Yans%20Food/yans-food/public/js/thermal-printer.js) dengan halaman status dan pengujian di menu **Admin > Printer**.

---

## 🗄️ 4. Penerapan Konsep RDBMS & Integritas Basis Data

Sistem Yan's Food menerapkan 5 pilar utama basis data relasional (RDBMS) di level engine MySQL untuk menjamin performa tinggi, keamanan finansial, dan konsistensi data:

### 1. Database Trigger (`trg_after_transaction_item_insert`)
- **Lokasi File:** [`database/migrations/2026_10_11_000009_create_database_routines_and_triggers.php`](file:///c:/SEKOLAH/12semester1/PROD%20(PA%20ANGGA)/Yans%20Food/yans-food/database/migrations/2026_10_11_000009_create_database_routines_and_triggers.php)
- **Fungsi:** Bekerja secara otomatis setelah baris baru ditambahkan ke tabel `transaction_items`. Trigger ini langsung memotong nilai kolom `stock` pada tabel `products` sejumlah kuantitas pesanan (`NEW.quantity`) dan memastikan stok tidak bernilai negatif (`GREATEST(0, stock - NEW.quantity)`).

### 2. Stored Function (`fn_calculate_simple_profit`)
- **Lokasi File:** [`database/migrations/2026_10_11_000009_create_database_routines_and_triggers.php`](file:///c:/SEKOLAH/12semester1/PROD%20(PA%20ANGGA)/Yans%20Food/yans-food/database/migrations/2026_10_11_000009_create_database_routines_and_triggers.php)
- **Fungsi:** Fungsi terkompilasi dalam basis data yang menerima parameter tanggal awal dan tanggal akhir `(p_start_date, p_end_date)`. Fungsi mengkalkulasi selisih total omset transaksi berstatus `completed` dengan total pengeluaran berstatus `approved` langsung di memori database engine dan mengembalikan nilai desimal laba bersih.

### 3. Stored Procedure (`sp_get_daily_sales_summary`)
- **Lokasi File:** [`database/migrations/2026_10_25_000001_create_stored_procedure_daily_sales_recap.php`](file:///c:/SEKOLAH/12semester1/PROD%20(PA%20ANGGA)/Yans%20Food/yans-food/database/migrations/2026_10_25_000001_create_stored_procedure_daily_sales_recap.php)
- **Fungsi:** Prosedur tersimpan untuk rekapitulasi cepat harian. Menerima input tanggal `IN p_date DATE` dan mengeluarkan 2 variabel output: `OUT p_total_revenue DECIMAL(15,2)` (total omset) serta `OUT p_total_transactions INT` (total transaksi kasir) secara instan untuk efisiensi query analitik.

### 4. Database Transaction: Commit
- **Lokasi File:** [`app/Services/TransactionService.php`](file:///c:/SEKOLAH/12semester1/PROD%20(PA%20ANGGA)/Yans%20Food/yans-food/app/Services/TransactionService.php) & [`app/Http/Controllers/Admin/RecipeController.php`](file:///c:/SEKOLAH/12semester1/PROD%20(PA%20ANGGA)/Yans%20Food/yans-food/app/Http/Controllers/Admin/RecipeController.php)
- **Fungsi:** Menjamin prinsip *Atomicity* (ACID). Seluruh rangkaian operasi (pembuatan header nota transaksi, penambahan rincian item, dan kalkulasi pembayaran) hanya akan dipermanenkan (`DB::commit()`) setelah semua operasi berhasil 100% tanpa celah inkonsistensi.

### 5. Database Transaction: Rollback
- **Lokasi File:** [`app/Services/TransactionService.php`](file:///c:/SEKOLAH/12semester1/PROD%20(PA%20ANGGA)/Yans%20Food/yans-food/app/Services/TransactionService.php)
- **Fungsi:** Apabila terjadi kegagalan (misalnya stok barang tidak mencukupi, koneksi terputus di tengah jalan, atau kegagalan query), sistem mengeksekusi blok `catch` dan menjalankan `DB::rollBack()`. Seluruh perubahan yang sempat ditulis akan dibatalkan seketika, mengembalikan basis data ke kondisi awal sebelum proses dimulai.

---

## 🏛️ 5. Arsitektur Perangkat Lunak

Aplikasi menggunakan pola arsitektur berlapis (*layered architecture*) yang memisahkan logika antarmuka, kontroler, layanan bisnis, dan basis data:

```
┌────────────────────────────────────────────────────────────────────────┐
│                        PRESENTATION & UI LAYER                         │
├───────────────────────────────────┬────────────────────────────────────┤
│       Website Publik (Blade)      │        Admin Panel (Blade Custom)  │
│  - Home, About, Menu, Pesan, dsb. │  - Dashboard, POS, Produk, Laporan │
└─────────────────┬─────────────────┴──────────────────┬─────────────────┘
                  │                                    │
                  ▼                                    ▼
┌────────────────────────────────────────────────────────────────────────┐
│                   APPLICATION LOGIC & CONTROLLER LAYER                 │
├───────────────────────────────────┬────────────────────────────────────┤
│   PageController (Public Front)   │  Admin Controllers (POS, Reports)  │
└─────────────────┬─────────────────┴──────────────────┬─────────────────┘
                  │                                    │
                  ▼                                    ▼
┌────────────────────────────────────────────────────────────────────────┐
│                      ENTERPRISE SERVICE LAYER                          │
├────────────────────────────────────────────────────────────────────────┤
│ • TransactionService   : Validasi kasir, transaksi belanja, ACID logic │
│ • ReportService        : Agregasi keuangan, grafik analitik, CSV export│
│ • ReceiptService       : Format struk kasir & ESC/POS text builder     │
│ • ThermalPrinterService: Layanan komputasi print layout & konfigurasi  │
└───────────────────────────────────┬────────────────────────────────────┘
                                    │
                                    ▼
┌────────────────────────────────────────────────────────────────────────┐
│                 DOMAIN MODELS & DATABASE REPOSITORIES                  │
├────────────────────────────────────────────────────────────────────────┤
│ User, Product, ProductCategory, Recipe, Transaction, Expense, Setting  │
└────────────────────────────────────────────────────────────────────────┘
```

### Modul Panel Admin:
1. **DASHBOARD:** Ringkasan KPI harian (omset kasir, jumlah transaksi, pengeluaran belanja dapur, laba bersih riil, grafik penjualan, dan notifikasi stok menipis).
2. **KASIR (POS):** Layar kasir cepat dengan filter kategori responsif, pencarian menu instan, keranjang interaktif, pilihan metode Tunai/QRIS, serta tombol cetak struk RPP02N.
3. **PRODUK & KATALOG:** Kelola 40 produk resmi lengkap dengan kategori, harga jual, stok fisik, dan upload foto produk ke penyimpanan publik.
4. **RESEP & BAHAN BAKU:** Perumusan komposisi bahan baku (*Bill of Materials*) per porsi menu dengan tampilan grid 2x2 responsif di perangkat mobile.
5. **RIWAYAT TRANSAKSI:** Arsip seluruh transaksi kasir lengkap dengan filter tanggal/bulan, rincian item, dan cetak ulang struk.
6. **PENGELUARAN:** Buku pencatatan pengeluaran operasional gerai harian (bahan baku, utilitas, kemasan, dll.) dengan filter bulan bebas overflow.
7. **LAPORAN KEUANGAN:** Evaluasi laba bersih, rangkuman omset, produk terlaris, dan fitur ekspor data laporan ke format CSV.
8. **PRINTER KASIR:** Layar pengujian dan koneksi langsung printer kasir **RPP02N (DT-58B)** via Web Bluetooth dan USB.
9. **PENGATURAN TOKO:** Konfigurasi identitas gerai (nama usaha, nomor kontak, alamat dapur, catatan kaki struk kasir) dan unggah QRIS toko.

---

## 📁 6. Struktur Direktori Proyek

```text
yans-food/
├── app/
│   ├── Enums/                          # Enum Standar (PaymentMethod, ExpenseCategoryEnum)
│   ├── Http/Controllers/
│   │   ├── Admin/                      # Kontroler Back-Office & Kasir POS
│   │   │   ├── DashboardController.php
│   │   │   ├── ExpenseController.php
│   │   │   ├── PosController.php
│   │   │   ├── PrinterController.php
│   │   │   ├── ProductController.php
│   │   │   ├── RecipeController.php
│   │   │   ├── ReportController.php
│   │   │   ├── SettingController.php
│   │   │   └── TransactionController.php
│   │   └── PageController.php          # Kontroler Company Profile Publik
│   │
│   ├── Models/                         # Eloquent ORM Models
│   │   ├── Expense.php
│   │   ├── ExpenseCategory.php
│   │   ├── Product.php
│   │   ├── ProductCategory.php
│   │   ├── Recipe.php
│   │   ├── RecipeIngredient.php
│   │   ├── Setting.php
│   │   ├── Transaction.php
│   │   ├── TransactionItem.php
│   │   └── User.php
│   │
│   └── Services/                       # Service Layer (Business & Database Logic)
│       ├── ReceiptService.php
│       ├── ReportService.php
│       ├── ThermalPrinterService.php
│       └── TransactionService.php
│
├── database/
│   ├── migrations/                     # Skema Tabel, Triggers, Functions, & Procedures
│   └── seeders/                        # Seeder 40 Menu Produk, Kategori, Resep & Akun Admin
│
├── public/
│   ├── images/
│   │   ├── logo/                       # Asset Identitas Usaha (Logo Yans Food.svg, Favicon, Icon)
│   │   └── Menu/                       # 40 Foto Produk Eksklusif (1:1 Terpetakan Unik)
│   └── js/
│       └── thermal-printer.js          # Web Bluetooth & WebUSB Direct ESC/POS Driver
│
├── resources/
│   ├── css/app.css                     # Tailwind CSS v4 & Styling Responsif
│   ├── js/                             # Entry Point Vite Frontend
│   └── views/
│       ├── admin/                      # Template Blade Back-Office & POS
│       ├── components/                 # Komponen Reusable (Navbar, Footer, Button, Card)
│       ├── layouts/                    # Master Layout (App, Admin, Guest)
│       └── pages/                      # Halaman Publik (Home, About, Menu, Pesan, Contact)
│
├── routes/
│   └── web.php                         # Routing Web Publik & Panel Admin
│
└── README.md                           # Dokumentasi Resmi Proyek
```

---

## ⚡ 7. Panduan Menjalankan Sistem Secara Lokal

### Prasyarat Lingkungan:
- **PHP:** Versi 8.2 atau lebih tinggi (ekstensi wajib: `pdo_mysql`, `mbstring`, `intl`, `curl`, `gd`, `openssl`)
- **Composer:** Versi 2.x
- **Node.js:** Versi 18+ & NPM
- **Basis Data:** MySQL 8.x

### Langkah Instalasi:

1. **Clone & Masuk ke Direktori Proyek:**
   ```bash
   git clone <url-repository>
   cd yans-food
   ```

2. **Pasang Dependensi PHP & Frontend:**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment (`.env`):**
   Salin `.env.example` menjadi `.env` lalu sesuaikan konfigurasi koneksi basis data:
   ```env
   APP_NAME="Yan's Food"
   APP_ENV=local
   APP_KEY=base64:...
   APP_URL=http://localhost:8002

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=yans-food
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate Key & Hubungkan Storage:**
   ```bash
   php artisan key:generate
   php artisan storage:link
   ```

5. **Jalankan Migrasi & Database Seeder:**
   ```bash
   php artisan migrate:fresh --seed
   ```
   *(Perintah di atas akan membentuk tabel, mengaktifkan trigger, stored function, stored procedure, serta mengisi 40 katalog menu dan akun admin).*

6. **Jalankan Aplikasi:**
   ```bash
   # Terminal 1: Kompilasi frontend Tailwind / Vite
   npm run dev

   # Terminal 2: Server backend Laravel
   php artisan serve --port=8002
   ```

7. **Akses Aplikasi:**
   - **Website Profil Publik:** [http://localhost:8002](http://localhost:8002)
   - **Panel Admin & Kasir POS:** [http://localhost:8002/admin/login](http://localhost:8002/admin/login)
   - **Kredensial Default:** `admin@yansfood.id` | Sandi: `password`

---

## 🚀 8. Panduan Siap Hosting & Produksi (Deployment Checklist)

Saat proyek dipublikasikan ke layanan hosting (cPanel / VPS / Cloud Server):

1. **Kompilasi Aset Produksi:**
   ```bash
   npm run build
   ```
2. **Penyesuaian `.env` Produksi:**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://domainanda.com
   ```
3. **Optimasi Cache Laravel:**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
4. **Keamanan File Lingkungan:**
   Pastikan file konfigurasi lokal Windows seperti `powershell.bat` dan `powershell.cmd` tetap berada di dalam `.gitignore` sehingga tidak terunggah ke repositori git atau server hosting publik.

---

<p align="center">
  <strong>Yan's Food Digital System</strong> — Dapur Kuliner Rumahan & Sistem POS Terpadu.<br>
  © 2026 Yan's Food. Seluruh Hak Cipta Dilindungi Undang-Undang.
</p>
