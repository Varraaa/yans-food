# 🍱 Yan's Food — Platform Terpadu POS Kasir, Manajemen Produk & Company Profile

<p align="center">
  <img src="public/images/logo.png" alt="Yan's Food Logo" width="125" style="border-radius: 50%; box-shadow: 0 6px 16px rgba(0,0,0,0.12);">
</p>

<p align="center">
  <strong>Dokumentasi Konsep Sistem, Alur Bisnis, dan Arsitektur Aplikasi</strong><br>
  <em>"Cita Rasa Rumahan Disajikan dengan Hati — Kudapan Renyah & Makanan Hangat Bernutrisi"</em>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Framework-Laravel_12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/Styling-Tailwind_CSS_v4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Language-PHP_8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/Architecture-Custom_Blade_+_Tailwind-orange?style=for-the-badge" alt="Custom Blade">
</p>

---

## 💡 1. Konsep Dasar & Filosofi Bisnis

### A. Latar Belakang & Identitas Usaha
**Yan's Food** adalah unit usaha kuliner yang berfokus pada olahan masakan khas rumahan berkualitas tinggi, aneka kudapan renyah tradisional, serta makanan hangat siap santap bernutrisi harian. Mengusung nilai utama *"Rasa Rumahan Disajikan dengan Hati"*, seluruh produk diolah dari bahan baku berkualitas, higienis, dan dimasak secara higienis.

### B. Problem Statement & Solusi Digital
Dalam operasional harian usaha makanan cepat saji rumahan dan gerai fisik, tantangan yang dihadapi meliputi:
1. **Pencatatan Transaksi Kasir POS & Kehilangan Jejak Stok:** Selisih uang kas fisik dengan produk terjual, serta perlunya sinkronisasi stok otomatis setiap kali transaksi diselesaikan.
2. **Kebutuhan Snapshot Harga Historis:** Perlunya memastikan harga dan data transaksi lama tetap utuh ketika terjadi kenaikan atau pembaruan harga katalog di masa depan.
3. **Pembukuan Operasional yang Terhubung:** Pengeluaran belanja dapur (gas, minyak, beras, kemasan takeaway) harus terhubung langsung dengan omset penjualan kasir, sehingga pemilik usaha mengetahui laba bersih riil secara akurat.
4. **Kehadiran Digital & 2 Kanal Pemesanan Resmi:** Pelanggan membutuhkan profil digital yang interaktif untuk melihat daftar menu, info dapur, serta akses cepat ke 2 kanal pemesanan resmi: online delivery (ShopeeFood, GoFood, GrabFood) dan panduan datang langsung ke tempat (pesan di tempat & bawa pulang).

**Solusi Terpadu Yan's Food:**  
Membangun satu ekosistem web terpadu yang memadukan **Company Profile Publik** (sebagai etalase menu, citra brand, kanal pesan online delivery & panduan datang langsung ke tempat) dengan **Admin Back-Office & POS Panel** (sebagai pusat kendali kasir POS, stok produk, resep/BOM dapur, pengeluaran operasional, dan laporan laba rugi).

---

## 🔄 2. Konsep Alur Operasional & Logika Bisnis (Core Business Workflow)

Sistem dirancang mengadopsi prinsip **Single Source of Truth** — seluruh data produk, kalkulasi transaksi kasir, pemotongan stok otomatis, dan perhitungan keuangan dikelola secara terpusat di sisi server (*server-side truth*) untuk mencegah manipulasi harga dari sisi client.

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
│ • Eksplorasi Profil & Dapur   │               │ • Kasir POS (Point of Sale) Cepat │
│ • Katalog Kudapan & Makanan   │               │ • Manajemen Produk & Stok Fisik   │
│ • Link Pesan Online Delivery  │──────────────▶│ • Manajemen Resep & Bahan Baku    │
│   (ShopeeFood/GoFood/GrabFood)│               │ • Pencatatan Biaya Operasional    │
│ • Datang Langsung ke Tempat   │               │ • Laporan Finansial & Cetak Struk │
│   (Pesan & Bawa Pulang)       │               │                                   │
│ • Form Negosiasi Katering/WA  │               │                                   │
└───────────────────────────────┘               └───────────────────────────────────┘
```

---

### A. Alur Pemesanan Publik (2 Kanal Pemesanan Utama)
1. **Eksplorasi Menu & Informasi:** Konsumen menjelajahi katalog menu kudapan dan makanan hangat lengkap dengan foto, deskripsi rasa, porsi, dan harga resmi.
2. **Kanal 1: Online Delivery Platform (Mitra Resmi):** Pengunjung dapat langsung menekan tombol platform mitra (**ShopeeFood, GoFood, GrabFood**) untuk pemesanan instan harian yang diantar kurir ke depan rumah.
3. **Kanal 2: Datang Langsung ke Tempat (Pesan & Bawa Pulang / Konsep Mirip Drive-thru):** Pelanggan datang langsung ke lokasi dapur Yan's Food, memesan langsung di kasir/dapur, menunggu pesanan dimasak/digoreng hangat dadakan, menerima pesanan terkemas rapi, lalu langsung membawanya pulang (**TIDAK BISA MAKAN DI TEMPAT / No Dine-in**).
4. **Komunikasi & Negosiasi Pesanan Katering Acara (Khusus Non-Sistem):** Jika ada pelanggan yang berminat memesan porsi besar/katering untuk acara, pelanggan dapat mengisi formulir di halaman Kontak yang langsung terhubung ke WhatsApp Admin. Pesanan katering ini **tidak masuk ke dalam sistem software**, melainkan dinegosiasikan langsung di WhatsApp. Admin Yan's Food yang menentukan apakah pesanan katering diterima atau ditolak sesuai kapasitas dapur.

---

### B. Alur Point of Sale (POS) & Keamanan Kasir
Sistem kasir POS dirancang untuk operasional cepat pada gerai fisik atau meja kasir dapur:
1. **Penyajian Produk Aktif:** Hanya produk berstatus `Sedia` (*available*) dengan stok fisik tersedia yang dapat ditransaksikan di kasir.
2. **Kalkulasi Server Independen:** Perhitungan subtotal, potongan diskon, total belanja, dan nominal kembalian dihitung ulang oleh backend service guna mencegah manipulasi angka.
3. **Penyimpanan Snapshot Historis:** Saat transaksi disimpan, nama produk dan harga satuan disalin permanen ke tabel rincian transaksi sebagai arsip historis.
4. **Pengurangan Stok Otomatis:** Database trigger memotong stok fisik produk secara real-time saat transaksi berhasil disimpan.
5. **Pencetakan Struk Fleksibel:** Menghasilkan pratinjau struk thermal kasir (58mm/80mm) yang siap dicetak ke printer kasir USB/Bluetooth/LAN.

---

### C. Konsep Laba Bersih Sederhana (*Simple Net Profit*)
Sistem keuangan bisnis Yan's Food mengintegrasikan pemasukan harian dan seluruh pengeluaran operasional secara terpusat:
$$\text{Laba Bersih Sederhana} = \text{Total Penjualan Kasir POS} - \text{Total Biaya Operasional}$$

- **Penjualan POS Kasir:** Menghitung transaksi berstatus `completed`.
- **Biaya Operasional:** Menampung pengeluaran operasional dapur yang disetujui (*Approved*), mencakup Bahan Baku, Gas Dapur, Listrik, Air, Kemasan/Packaging, Transportasi, Peralatan, Pemeliharaan, dan Biaya Lain-lain.

---

## 🏛️ 3. Struktur & Arsitektur Aplikasi (Software Architecture)

Proyek ini dibangun menggunakan arsitektur berlapis (*multi-tiered architecture*) yang rapi:

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
│   Public Page Controllers         │     Admin Controllers (POS, Report)│
└─────────────────┬─────────────────┴──────────────────┬─────────────────┘
                  │                                    │
                  ▼                                    ▼
┌────────────────────────────────────────────────────────────────────────┐
│                      ENTERPRISE SERVICE LAYER                          │
├────────────────────────────────────────────────────────────────────────┤
│ • TransactionService   : Validasi kasir, transaksi belanja, stok       │
│ • ReportService        : Agregasi performa finansial, grafik, ekspor   │
│ • ReceiptService       : Format struk kasir & print layout             │
│ • ThermalPrinterService: Abstraksi perintah cetak USB/Bluetooth/LAN    │
└───────────────────────────────────┬────────────────────────────────────┘
                                    │
                                    ▼
┌────────────────────────────────────────────────────────────────────────┐
│                 DOMAIN MODELS & DATABASE REPOSITORIES                  │
├────────────────────────────────────────────────────────────────────────┤
│ User, Product, ProductCategory, Recipe, Transaction, Expense, Printer  │
└────────────────────────────────────────────────────────────────────────┘
```

---

### A. Lapisan Antarmuka Publik (Public Website Layer)
- **`pages.home`:** Identitas visual dapur rumahan, filosofi rasa, grid menu favorit pelanggan, dan CTA pemesanan delivery.
- **`pages.menu`:** Katalog kuliner dinamis interaktif dengan filter kategori instan (Kudapan Renyah, Makanan Hangat, Aneka Lauk, Minuman Segar).
- **`pages.pesan`:** Pusat pemesanan online delivery mitra (ShopeeFood, GoFood, GrabFood) dan panduan pesan takeaway mandiri via WhatsApp.
- **`pages.about` & `pages.contact`:** Narasi perjalanan kuliner dapur rumahan, alamat dapur, jam operasional, peta interaktif, dan formulir kontak langsung.

---

### B. Lapisan Panel Admin (Back-Office & POS Layer)
1. **DASHBOARD:** Ringkasan KPI harian (Omset POS hari ini, transaksi kasir, pengeluaran belanja operasional, laba bersih riil, serta peringatan stok produk menipis).
2. **KASIR (POS):** Layar kasir cepat untuk transaksi belanja langsung, pemilihan produk, keranjang belanja dinamis, kalkulator pembayaran, dan cetak struk kasir.
3. **PRODUK & KATALOG:** Manajemen produk (nama menu, kategori, harga, stok fisik, status sedia, upload foto produk).
4. **RESEP & INVENTARIS:** Standar resep dapur (*Bill of Materials*) dan kebutuhan bahan baku per porsi.
5. **TRANSAKSI:** Riwayat seluruh struk transaksi kasir lengkap dengan filter tanggal dan cetak ulang nota.
6. **PENGELUARAN:** Pencatatan biaya operasional harian dapur berdasarkan kategori biaya.
7. **LAPORAN:** Analisis keuangan komprehensif (omset vs pengeluaran, laba bersih, produk terlaris, dan ekspor data CSV).
8. **PENGATURAN & PRINTER:** Konfigurasi printer thermal kasir (58mm/80mm) dan informasi profil usaha.

---

## 📁 4. Struktur Direktori Proyek

```text
yans-food/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/                      # Controller Panel Admin (POS, Produk, Resep, Laporan, dsb.)
│   │   │   ├── DashboardController.php
│   │   │   ├── ExpenseController.php
│   │   │   ├── PosController.php
│   │   │   ├── PrinterController.php
│   │   │   ├── ProductController.php
│   │   │   ├── RecipeController.php
│   │   │   ├── ReportController.php
│   │   │   └── TransactionController.php
│   │   └── PageController.php          # Controller Web Company Profile Publik
│   │
│   ├── Models/                         # Eloquent Models
│   │   ├── Expense.php
│   │   ├── ExpenseCategory.php
│   │   ├── Printer.php
│   │   ├── Product.php
│   │   ├── ProductCategory.php
│   │   ├── Recipe.php
│   │   ├── RecipeIngredient.php
│   │   ├── Transaction.php
│   │   ├── TransactionItem.php
│   │   └── User.php
│   │
│   └── Services/                       # Service Layer
│       ├── ReceiptService.php
│       ├── ReportService.php
│       ├── ThermalPrinterService.php
│       └── TransactionService.php
│
├── database/
│   ├── migrations/                     # Migrasi Skema Database & Database Trigger
│   └── seeders/                        # Data Awal Master Produk, Kategori & Akun Admin
│
├── resources/
│   ├── css/app.css                     # Tailwind CSS & Token Desain
│   ├── js/                             # Logika Interaktif Frontend (Modal, Search, Cart, POS)
│   └── views/
│       ├── admin/                      # Blade View Panel Admin & Kasir POS
│       ├── components/                 # Komponen Reusable Publik (Navbar, Footer, Modal)
│       └── pages/                      # Halaman Company Profile Publik (Home, About, Menu, Pesan, Contact)
│
├── routes/
│   └── web.php                         # Routing Web Publik & Panel Admin
│
└── README.md                           # Dokumentasi Sistem
```

---

## ⚡ 5. Panduan Menjalankan Sistem Secara Lokal

### Prasyarat:
- **PHP:** Versi 8.2+ (ekstensi: `pdo_mysql`, `mbstring`, `intl`, `curl`, `gd`)
- **Composer:** Versi 2.x
- **Node.js:** Versi 18+ & NPM
- **Database:** MySQL 8.x

### Langkah Instalasi:

1. **Install Dependensi:**
   ```bash
   composer install
   npm install
   ```

2. **Konfigurasi Environment (`.env`):**
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

3. **Generate Key & Storage Link:**
   ```bash
   php artisan key:generate
   php artisan storage:link
   ```

4. **Migrasi Database & Seeding:**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Jalankan Aplikasi:**
   ```bash
   # Terminal 1: Kompilasi frontend
   npm run dev

   # Terminal 2: Server Laravel
   php artisan serve --port=8002
   ```

6. **Akses Sistem:**
   - **Company Profile Publik:** `http://localhost:8002`
   - **Panel Admin & Kasir POS:** `http://localhost:8002/admin/login`
   - **Kredensial Default:** `admin@yansfood.id` / Sandi: `password`

---

<p align="center">
  <strong>Yan's Food Digital System</strong> — Dapur Kuliner Rumahan & Sistem POS Terpadu.<br>
  © 2026 Yan's Food. Hak Cipta Dilindungi Undang-Undang.
</p>
