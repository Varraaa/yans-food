# 🍱 Yan's Food — Platform Terpadu Kuliner, POS Kasir & Manajemen Katering

<p align="center">
  <img src="public/images/logo.png" alt="Yan's Food Logo" width="125" style="border-radius: 50%; box-shadow: 0 6px 16px rgba(0,0,0,0.12);">
</p>

<p align="center">
  <strong>Dokumentasi Konsep Sistem, Alur Bisnis, dan Arsitektur Aplikasi</strong><br>
  <em>"Cita Rasa Rumahan, Kualitas Restoran — 100% Halal & Fresh Cooked"</em>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Framework-Laravel_12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/Admin_Engine-Filament_v3-EBB305?style=for-the-badge&logo=filament&logoColor=white" alt="Filament v3">
  <img src="https://img.shields.io/badge/Fullstack_State-Livewire_3-FB70A9?style=for-the-badge&logo=livewire&logoColor=white" alt="Livewire 3">
  <img src="https://img.shields.io/badge/Styling-Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Language-PHP_8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
</p>

---

## 💡 1. Konsep Dasar & Filosofi Bisnis

### A. Latar Belakang & Identitas Usaha
**Yan's Food** adalah unit usaha kuliner yang berfokus pada olahan masakan khas rumahan berkualitas tinggi, makanan ringan tradisional, aneka lauk pauk, hingga paket prasmanan dan nasi kotak katering. Mengusung nilai utama *"Cita Rasa Rumahan, Kualitas Restoran"*, seluruh makanan diproduksi dengan komitmen *100% Halal*, bahan baku segar harian (*fresh cooked*), dan tanpa bahan pengawet berbahaya.

### B. Problem Statement & Solusi Digital
Dalam operasional harian usaha makanan dan katering, permasalahan yang kerap terjadi meliputi:
1. **Pencatatan Pesanan Katering Tercecer:** Pesanan acara dari pelanggan sering masuk via percakapan WhatsApp tanpa format baku, menyebabkan risiko kelupaan jadwal acara, salah porsi, atau alamat pengantaran tidak lengkap.
2. **Kerancuan Finansial Uang Muka (DP):** Ketidakmampuan membedakan antara progres kesiapan memasak dengan riwayat penerimaan pembayaran bertahap (katering berstatus selesai dimasak sering dianggap sudah lunas, padahal pelunasan belum diselesaikan).
3. **Pencatatan Kasir POS & Kehilangan Jejak Stok:** Selisih uang kas fisik kasir dengan produk terjual, serta tidak adanya riwayat harga produk saat terjadi perubahan harga di masa depan.
4. **Pembukuan Operasional yang Terpisah:** Pengeluaran belanja dapur (gas, minyak, beras, kemasan box) tidak terhubung dengan omset harian, sehingga pemilik usaha kesulitan mengetahui laba bersih riil.

**Solusi Terpadu Yan's Food:**  
Membangun satu ekosistem web terpadu yang memadukan **Company Profile Publik** (sebagai etalase citra brand dan kanal reservasi pelanggan) dengan **Admin Back-Office & POS Panel** (sebagai pusat kendali operasional, dapur, dan finansial).

---

## 🔄 2. Konsep Alur Operasional & Logika Bisnis (Core Business Workflow)

Sistem dirancang mengadopsi prinsip **Single Source of Truth** — seluruh data produk, status pesanan, dan perhitungan keuangan dikelola secara terpusat di sisi server (*server-side truth*) untuk mencegah manipulasi harga dari sisi client.

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
│ • Eksplorasi Profil & Menu    │               │ • Kasir POS (Point of Sale)       │
│ • Link Pesan Online Instan    │               │ • Manajemen Resep & Bahan Baku    │
│ • Formulir Reservasi Katering │──────────────▶│ • Kontrol Pesanan & DP Katering   │
│   (Tersimpan Resmi ke Sistem) │               │ • Pencatatan Biaya Operasional    │
│ • Konsultasi Terarah via WA   │               │ • Laporan Keuangan & Cetak Struk  │
└───────────────────────────────┘               └───────────────────────────────────┘
```

---

### A. Alur Hybrid Pemesanan Katering (Public Form $\rightarrow$ Database $\rightarrow$ WhatsApp)
Pesanan katering **tidak diinput manual oleh admin dari percakapan chat acak**. Alur resmi yang diterapkan:
1. **Pengisian Formulir:** Konsumen membuka halaman publik katering, memilih jenis paket, memasukkan jumlah porsi (minimum order tertera otomatis), tanggal acara, jam tiba, alamat lengkap, dan catatan khusus menu.
2. **Validasi & Kalkulasi Server-Side:** Sistem secara otomatis memverifikasi ketersediaan paket, mengunci harga resmi dari basis data, menghitung estimasi subtotal, dan mencatat pesanan resmi ke database dengan status awal `PENDING` dan status tagihan `UNPAID`.
3. **Deep Linking WhatsApp Terformat:** Setelah data tersimpan aman di server, browser pelanggan otomatis membuka percakapan resmi WhatsApp admin dengan teks pesan terstruktur yang merangkum nomor referensi pesanan, rincian acara, dan alamat. Chat WA difungsikan khusus sebagai kanal konsultasi personal yang fleksibel, bukan sebagai tempat pencatatan data awal.
4. **Pembaruan Manual oleh Admin:** Jika terdapat kesepakatan perubahan menu atau negosiasi harga saat chat berlangsung, admin memperbarui pesanan secara resmi melalui Admin Panel.

---

### B. Konsep *Dual-Status Lifecycle* pada Modul Katering
Sistem memisahkan secara tegas antara **Status Progres Pengerjaan** dan **Status Pembayaran Finansial** karena keduanya berjalan pada siklus independen:

* **Siklus Progres Fisik Pesanan (`status`):**
  $$\text{PENDING} \longrightarrow \text{CONFIRMED} \longrightarrow \text{IN\_PROGRESS} \longrightarrow \text{READY} \longrightarrow \text{DELIVERING} \longrightarrow \text{COMPLETED}$$
  *(Status `DELIVERING` sengaja dipisahkan dari `READY` agar admin dan dapur dapat membedakan pesanan yang sudah rampung dikemas di dapur dengan pesanan yang sedang berada dalam perjalanan armada kurir).*

* **Siklus Pembayaran Tagihan (`payment_status`):**
  $$\text{UNPAID} \longrightarrow \text{DP (Uang Muka)} \longrightarrow \text{PAID (Lunas)}$$

> **Aturan Keuangan:** Status pesanan `COMPLETED` tidak pernah secara otomatis mengubah status pembayaran menjadi `PAID`. Pelunasan katering wajib melalui pencatatan resmi transaksi uang masuk di modul pembayaran dengan proteksi pencegahan kelebihan bayar (*overpayment protection*).

---

### C. Alur Point of Sale (POS) & Keamanan Kasir
Sistem kasir POS dirancang untuk operasional cepat pada gerai fisik atau dapur langsung:
1. **Penyajian Produk Aktif:** Hanya produk berstatus `Sedia` yang ditampilkan pada antarmuka kasir.
2. **Kalkulasi Server Independen:** Perhitungan subtotal, potongan diskon, total belanja, dan nominal kembalian dihitung ulang oleh backend service guna mencegah manipulasi angka melalui inspect element browser.
3. **Penyimpanan Snapshot Historis:** Saat transaksi disimpan, nama produk dan harga satuan disalin permanen ke rincian transaksi sebagai arsip historis. Apabila di kemudian hari harga produk dinaikkan di katalog, seluruh struk transaksi lama tidak akan berubah nilainya.
4. **Pencetakan Struk Fleksibel:** Menghasilkan pratinjau struk thermal kasir (58mm/80mm) dan tiket dapur tanpa menyertakan harga untuk kebutuhan juru masak.

---

### D. Konsep Laba Bersih Sederhana (*Simple Net Profit*)
Sistem keuangan bisnis Yan's Food mengintegrasikan pemasukan harian dan seluruh pengeluaran operasional secara terpusat:
$$\text{Laba Bersih Sederhana} = \Big(\text{Total Penjualan POS Kasir} + \text{Realisasi Uang Masuk Katering}\Big) - \text{Total Biaya Operasional}$$

- **Realisasi Uang Masuk Katering:** Hanya menghitung uang kas yang benar-benar telah diterima melalui pencatatan pembayaran DP atau pelunasan, bukan total nilai kontrak pesanan yang belum dibayarkan.
- **Biaya Operasional:** Menampung 9 pos pengeluaran harian dan berkala (Bahan Baku, Gas Dapur, Listrik, Air, Kemasan/Packaging, Transportasi Pengantaran, Peralatan, Pemeliharaan/Maintenance, dan Biaya Lain-lain).

---

## 🏛️ 3. Struktur & Arsitektur Aplikasi (Software Architecture)

Proyek ini dibangun menggunakan arsitektur berlapis (*multi-tiered architecture*) yang rapi, memisahkan secara jelas antara antarmuka pengguna, panel manajemen, logika bisnis, dan model data.

```
┌────────────────────────────────────────────────────────────────────────┐
│                        PRESENTATION & UI LAYER                         │
├───────────────────────────────────┬────────────────────────────────────┤
│       Website Publik (Blade)      │     Admin Panel (Filament v3)      │
│  - Home, About, Menu, Pesan, etc. │  - Dashboard, POS, Catalog, etc.   │
└─────────────────┬─────────────────┴──────────────────┬─────────────────┘
                  │                                    │
                  ▼                                    ▼
┌────────────────────────────────────────────────────────────────────────┐
│                   APPLICATION LOGIC & CONTROLLER LAYER                 │
├───────────────────────────────────┬────────────────────────────────────┤
│   Public Order HTTP Controllers   │     Filament Resources & Pages     │
└─────────────────┬─────────────────┴──────────────────┬─────────────────┘
                  │                                    │
                  ▼                                    ▼
┌────────────────────────────────────────────────────────────────────────┐
│                      ENTERPRISE SERVICE LAYER                          │
├────────────────────────────────────────────────────────────────────────┤
│ • TransactionService   : Validasi kasir, transaksi belanja, stok       │
│ • CateringService      : Validasi pesanan acara, pembuatan URL WA      │
│ • PaymentService       : Rekonsiliasi pembayaran DP/Lunas, sisa tagihan│
│ • ReportService        : Agregasi performa finansial, grafik, ekspor   │
│ • ReceiptService       : Format struk kasir & tiket dapur              │
│ • ThermalPrinterService: Abstraksi perintah cetak USB/Bluetooth/LAN    │
└───────────────────────────────────┬────────────────────────────────────┘
                                    │
                                    ▼
┌────────────────────────────────────────────────────────────────────────┐
│                 DOMAIN MODELS & DATABASE REPOSITORIES                  │
├────────────────────────────────────────────────────────────────────────┤
│ User, Product, Category, Recipe, Transaction, Catering, Expense, dsb.  │
└────────────────────────────────────────────────────────────────────────┘
```

---

### A. Lapisan Antarmuka Publik (Public Website Layer)
Halaman depan berorientasi pada kenyamanan konsumen dengan antarmuka cepat, responsif, dan kaya sentuhan visual:
- **`pages.home`:** Menampilkan identitas visual dapur, keunggulan bahan baku segar, cuplikan menu favorit, dan testimoni pelanggan.
- **`pages.menu`:** Menampilkan katalog kuliner dinamis yang dikelompokkan berdasarkan kategori produk (Makanan Ringan, Makanan Berat, Mie Instan, Minuman Segar, dan Paket Katering).
- **`pages.pesan`:** Pusat pemesanan terintegrasi yang memuat opsi pemesanan instan online delivery (ShopeeFood, GoFood, GrabFood) dan formulir reservasi katering acara.
- **`pages.about` & `pages.contact`:** Menyajikan narasi perjalanan dapur rumahan, alamat lengkap, fasilitas, peta interaktif, dan kanal narahubung resmi.
- **Persistent Global Components:** Navbar dengan indikator halaman aktif, Footer dengan motto rasa rumahan dan strip *trust signal* 100% Halal, tombol scroll halus ke atas (*Back to Top*), dan dialog pemesanan kilat.

---

### B. Lapisan Panel Admin (Back-Office Layer - Filament v3)
Panel administrasi dikelompokkan ke dalam 6 modul kerja hierarkis pada sidebar navigasi:

1. **MAIN:**
   - **Dashboard:** Pusat pemantauan performa bisnis harian melalui kartu statistik interaktif (KPI omset POS hari ini, struk transaksi, total pengeluaran belanja dapur, laba bersih sederhana, pesanan katering belum lunas, dan katering selesai).
2. **TRANSACTION:**
   - **POS (Kasir):** Antarmuka kasir layar penuh (`PosPage`) untuk transaksi cepat, dilengkapi pemilihan kategori, pencarian instan, manajemen keranjang, input uang diterima, perhitungan kembalian otomatis, dan cetak struk thermal kasir.
   - **Transaksi:** Arsip seluruh transaksi kasir historis beserta rincian item, identitas kasir bertugas, dan tombol cetak ulang nota.
3. **CATALOG:**
   - **Produk:** Manajemen katalog kuliner (nama menu, kategori dengan fitur tambah kategori instan langsung dari modal, harga, stok fisik, satuan, foto menu, dan sakelar status `Sedia` / `Tidak Tersedia`).
   - **Resep & BOM:** Dokumentasi standar resep dapur (*Bill of Materials*) yang mengaitkan menu jadi dengan daftar bahan baku, jumlah takaran, yield porsi, dan petunjuk memasak.
4. **CATERING:**
   - **Pesanan Catering:** Manajemen daftar pemesanan katering dengan rincian pemesan, tanggal acara, breakdown menu, kontrol progres produksi, dan aksi langsung hubungi nomor WhatsApp pemesan.
   - **Pembayaran Catering:** Pencatatan bertahap transaksi uang muka (DP), pelunasan, atau pembayaran tunai penuh dengan verifikasi batas sisa tagihan.
   - **Penghasilan Catering:** Halaman khusus analisis realisasi kas yang menyaring uang nyata yang sudah diterima dari katering berdasarkan rentang tanggal.
5. **FINANCE:**
   - **Pengeluaran:** Pencatatan biaya operasional dapur pada 9 pos pengeluaran, pemilihan jenis belanja (*One-time* atau *Recurring* rutin bulanan), dan pengarsipan foto fisik struk belanja.
   - **Laporan:** Pusat analisis analitik performa penjualan dengan pemisahan tab POS Reguler vs Katering, filter rentang waktu, pemeringkat produk terlaris, serta tombol **Export CSV**.
6. **SYSTEM:**
   - **Printer:** Konfigurasi perangkat keras printer thermal kasir (tipe antarmuka USB/Bluetooth/LAN dan spesifikasi kertas 58mm atau 80mm).
   - **Pengguna:** Manajemen akun staf dengan pemisahan hak akses peran Administrator (akses penuh) dan Kasir (khusus operasional POS dan transaksi).

---

### C. Lapisan Layanan Bisnis (Service Layer Architecture)
Seluruh logika bisnis kompleks diisolasi ke dalam direktori `app/Services/` agar kode tetap bersih (*clean code*), mudah diuji (*testable*), dan tidak menduplikasi logika antara Controller web publik dan Panel Admin:

* **`TransactionService`:** Mengelola alur transaksi POS kasir secara atomik menggunakan database transaction (`BEGIN`, `COMMIT`, `ROLLBACK`) untuk memastikan bahwa pemotongan stok dan penyimpanan struk berhasil secara serentak tanpa anomali data.
* **`CateringService`:** Menangani validasi pemesanan katering, kalkulasi subtotal dan diskon di server, serta penyusunan format pesan deep link WhatsApp.
* **`PaymentService`:** Memvalidasi batas sisa tagihan pesanan katering sebelum pembayaran dicatat, serta secara otomatis memperbarui status tagihan dari `UNPAID` menjadi `DP` atau `PAID`.
* **`ReportService`:** Bertanggung jawab atas query analitik KPI dashboard, kalkulasi laba bersih, rangkuman penghasilan katering, peringkat penjualan produk terlaris, dan penyiapan data ekspor CSV.
* **`ReceiptService`:** Merakit struktur data nota pelanggan (header, rincian produk, subtotal, pembayaran, footer) dan tiket pesanan dapur.
* **`ThermalPrinterService`:** Mengabstraksikan perintah cetak teks dan pemotongan kertas sesuai standar format ESC/POS.

---

## 📁 4. Struktur Direktori Proyek

```text
yans-food/
├── app/
│   ├── Filament/                       # Modul Panel Administrasi Filament v3
│   │   ├── Pages/                      # Halaman Khusus (PosPage, CateringIncomePage, ReportPage)
│   │   ├── Resources/                  # Resource CRUD (Product, Recipe, Transaction, Catering, Expense, Printer, User)
│   │   │   ├── ...Resource.php         # Definisi Formulir, Tabel, dan Filter
│   │   │   └── ...Resource/Pages/      # Halaman List, Create, Edit, View
│   │   └── Widgets/                    # Widget KPI Dashboard (StatsOverviewWidget)
│   │
│   ├── Http/Controllers/               # HTTP Controller Web & Integrasi Form Publik
│   │   └── PublicCateringOrderController.php
│   │
│   ├── Models/                         # Domain Entities & Relasi Eloquent
│   │   ├── User.php                    # Akun Pengguna & Otorisasi Akses Panel
│   │   ├── Product.php                 # Katalog Menu Kuliner
│   │   ├── ProductCategory.php         # Kategori Menu
│   │   ├── Recipe.php                  # Header Resep Dapur
│   │   ├── RecipeIngredient.php        # Rincian Bahan Baku Resep
│   │   ├── Transaction.php             # Header Transaksi Kasir POS
│   │   ├── TransactionItem.php         # Snapshot Item Belanja Kasir
│   │   ├── CateringOrder.php           # Pesanan Katering Acara
│   │   ├── CateringOrderItem.php       # Snapshot Menu Katering
│   │   ├── CateringPayment.php         # Riwayat Pembayaran DP/Pelunasan
│   │   ├── Expense.php                 # Pengeluaran Operasional
│   │   ├── ExpenseCategory.php         # Kategori Biaya Operasional
│   │   └── Printer.php                 # Konfigurasi Printer Kasir
│   │
│   ├── Providers/                      # Service Provider Aplikasi
│   │   └── Filament/AdminPanelProvider.php  # Konfigurasi Tema, Warna, & Navigasi Panel
│   │
│   └── Services/                       # Enterprise Business Logic Layer
│       ├── CateringService.php
│       ├── PaymentService.php
│       ├── ReceiptService.php
│       ├── ReportService.php
│       ├── ThermalPrinterService.php
│       └── TransactionService.php
│
├── database/
│   ├── migrations/                     # Skema Pembentukan Tabel & Database Engine
│   └── seeders/                        # Pengisian Data Awal (Akun Default & Produk Dummy)
│
├── resources/
│   ├── css/app.css                     # Konfigurasi Styling Desain Tailwind CSS
│   └── views/
│       ├── components/                 # Komponen Antarmuka Reusable (Navbar, Footer, CateringForm, Struk)
│       ├── filament/                   # Tampilan Kustom Halaman Panel Admin (POS Kasir, Laporan, dsb.)
│       └── pages/                      # Halaman Tampilan Web Publik (Home, About, Menu, Pesan, Contact)
│
├── routes/
│   └── web.php                         # Definisi Rute Navigasi Web Publik & Endpoint Reservasi
│
└── README.md                           # Dokumentasi Konseptual & Arsitektur Sistem
```

---

## 👥 5. Manajemen Hak Akses & Peran Pengguna (Role-Based Access)

Sistem membedakan batasan wewenang pengguna secara jelas untuk menjaga integritas data keuangan:

| Peran (Role) | Ruang Lingkup Wewenang | Tujuan Penggunaan |
| :--- | :--- | :--- |
| **Administrator (`admin`)** | Akses penuh ke seluruh menu sistem: Dashboard KPI, Katalog Menu, Standar Resep, Kelola Seluruh Pesanan Katering, Pengeluaran Dapur, Laporan Finansial Komprehensif, Konfigurasi Printer, dan Manajemen Akun Pengguna. | Digunakan oleh pemilik bisnis atau manajer operasional untuk pengawasan strategis dan pembukuan menyeluruh. |
| **Kasir (`cashier`)** | Terbatas pada antarmuka operasional: Sistem Kasir POS Mandiri (`/admin/pos-page`), Riwayat Transaksi Penjualan, dan Pengaturan Printer. Menu laporan keuangan rahasia, pengaturan staf, dan pengeluaran tidak dapat diakses. | Digunakan oleh staf kasir gerai untuk melayani transaksi belanja konsumen sehari-hari. |

---

## ⚡ 6. Panduan Menjalankan Sistem Secara Lokal

### Prasyarat Perangkat Lunak:
- **PHP:** Versi 8.2 atau lebih baru (dengan ekstensi `pdo_mysql`, `mbstring`, `intl`, `curl`, `gd`)
- **Composer:** Versi 2.x
- **Node.js:** Versi 18+ & NPM
- **Basis Data:** MySQL 8.x (dapat menggunakan XAMPP, Laragon, atau MySQL Server standalone)

### Langkah Konfigurasi:

1. **Persiapan Dependensi:**
   ```bash
   composer install
   npm install
   ```

2. **Pengaturan Berkas Konfigurasi (`.env`):**
   Salin berkas template dan sesuaikan kredensial basis data MySQL Anda:
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

3. **Inisialisasi Kunci & Penyimpanan Aset:**
   ```bash
   php artisan key:generate
   php artisan storage:link
   ```

4. **Eksekusi Migrasi & Data Percontohan:**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```
   *Perintah ini akan secara otomatis membuat seluruh struktur data, mengaktifkan logika pemicu database, serta memasukkan akun bawaan dan 10 produk kuliner siap pakai.*

5. **Kompilasi Antarmuka & Menjalankan Server:**
   Buka dua jendela terminal untuk menjalankan kompilasi aset dan server lokal:
   ```bash
   # Terminal 1: Kompilasi frontend aktif
   npm run dev

   # Terminal 2: Server aplikasi Laravel
   php artisan serve --port=8002
   ```

6. **Akses Sistem:**
   - **Website Publik:** `http://localhost:8002`
   - **Panel Admin & Kasir POS:** `http://localhost:8002/admin`
   - **Akun Masuk Bawaan:**
     - *Admin:* `admin@yansfood.id` / Sandi: `password`
     - *Kasir:* `kasir@yansfood.id` / Sandi: `password`

---

## 📜 7. Integritas & Standar Kualitas Perangkat Lunak

Aplikasi Yan's Food dikembangkan dengan mematuhi prinsip rekayasa perangkat lunak modern:
- **Server-Side Authoritative:** Seluruh kalkulasi rupiah, diskon, stok, dan validasi uang kembalian dieksekusi di server guna meniadakan celah kecurangan transaksi.
- **Auditable History:** Tidak melakukan penghapusan data secara destruktif (*No Hard Delete*) pada entitas yang memiliki jejak transaksi historis.
- **Separation of Concerns:** Pemisahan ketat antara tampilan visual, penanganan rute, dan logika pemrosesan data bisnis melalui pola Service Layer.

---

<p align="center">
  <strong>Yan's Food Digital System</strong> — Menggabungkan Cita Rasa Tradisi dengan Ketepatan Teknologi Modern.<br>
  © 2026 Yan's Food. Hak Cipta Dilindungi Undang-Undang.
</p>
