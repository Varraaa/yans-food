# YAN'S FOOD — WEBSITE SPECIFICATION

## 1. Konsep

Yan's Food adalah platform web berbasis Laravel yang menggabungkan **company profile publik** dan **sistem manajemen bisnis kuliner terpadu (POS Kasir & Manajemen Produk)** dalam satu sistem. Public website digunakan pelanggan untuk melihat profil, katalog menu kudapan dan makanan hangat, informasi dapur, serta 2 kanal pemesanan resmi: online delivery (ShopeeFood, GrabFood, GoFood) dan datang langsung ke tempat (pesan di tempat & bawa pulang, tidak bisa makan di tempat). Admin website digunakan pemilik usaha dan kasir untuk mengelola operasional harian gerai.

**Kategori:** Integrated POS, Product Management & Culinary Company Profile.

## 2. Arsitektur

```text
Public Website ──┐
                 ├── Laravel Backend ── Service Layer ── MySQL/MariaDB
Admin Website ───┘
```

Prinsip:
- satu backend;
- satu database;
- satu business logic;
- data public dan admin berasal dari sumber yang sama.

## 3. Tech Stack

- PHP 8.2+ / Laravel 12
- Laravel Blade (public website & admin panel manual)
- Tailwind CSS v4
- Flowbite & Vanilla JS interaktif
- Vite
- Eloquent ORM
- MySQL 8.x
- Thermal printer 58mm/80mm

## 4. Public Website

Navbar utama:

```text
Home | About | Menu | Pesan | Contact
```

### Home
Hero, pengenalan dapur Yan's Food, teaser 2 kanal pesan resmi (online delivery & datang langsung), menu favorit pilihan pelanggan, filosofi rasa rumahan, kontak cepat, dan footer.

### About
Cerita usaha dapur rumahan, filosofi "Cita Rasa Rumahan Disajikan dengan Hati", komitmen bahan baku segar higienis, dan timeline perjalanan usaha.

### Menu
Katalog kuliner dinamis dari basis data produk dengan filter kategori (Kudapan Renyah, Makanan Hangat, Aneka Lauk, Minuman Segar). Produk berstatus **Sedia** ditampilkan dengan badge hijau; produk **Tidak Tersedia** ditampilkan non-aktif.
- **Tanya via WhatsApp Langsung:** Setiap kartu produk saat dibuka modal detailnya menyediakan tombol aksi "Tanya via WhatsApp" yang langsung membuka chat ke WhatsApp Admin (+62 822-2122-2936) dengan template otomatis:
  > *"Halo Kak, saya ingin pesan \*[Nama Produk]\* apakah masih ready stok nya kak ?"*

### Pesan

Halaman terintegrasi untuk memesan produk Yan's Food melalui dua kanal resmi:

#### A. Pesan Online Delivery (Mitra Platform)
- Menampilkan card interaktif **ShopeeFood**, **GoFood**, dan **GrabFood**, masing-masing clickable menuju toko resmi Yan's Food di aplikasi tersebut untuk pemesanan instan harian dengan kurir platform.
- Transaksi dan pembayaran berlangsung di platform pihak ketiga tersebut.

#### B. Datang Langsung ke Tempat (Pesan di Tempat & Bawa Pulang / Konsep Drive-thru)
- Pelanggan datang langsung ke lokasi dapur Yan's Food, memesan langsung di kasir dapur, menunggu pesanan disiapkan dan digoreng hangat dadakan, menerima pesanan terkemas rapi, lalu membawanya pulang.
- Penegasan: **TIDAK BISA MAKAN DI TEMPAT (No Dine-In / Takeaway Only)**.
- Dilengkapi panduan 4 langkah datang langsung, informasi jam operasional resmi **08.00 – 22.00 WIB (Setiap Hari)**, dan tautan resmi Google Maps: `https://maps.app.goo.gl/KnCpj3ViPCHGNmH66`.

### Contact
Alamat dapur (Kp. Ciloa, Soreang, Bandung), WhatsApp resmi (+62 822-2122-2936), jam operasional resmi (**08.00 - 22.00 WIB Setiap Hari**), peta lokasi interaktif Google Maps, serta formulir komunikasi & negosiasi pesanan khusus / katering acara.
- **Tanpa Akun Media Sosial:** Yan's Food tidak menggunakan Instagram, TikTok, atau akun medsos lainnya. Seluruh interaksi digital resmi berpusat langsung pada WhatsApp Admin.
- **Format Otomatis Negosiasi via WA:** Calon pelanggan yang mengklik tombol *"Lanjutkan Negosiasi via WhatsApp Admin"* akan otomatis diarahkan ke WhatsApp Admin dengan template format:
  ```text
  Halo Kak, saya ingin berkomunikasi & negosiasi pesanan:

  • Nama: [nama]
  • WhatsApp: [wa]
  • Topik / Keperluan: [topik]
  • Estimasi Porsi: [porsi]
  • Rencana Tanggal Acara: [tanggal]
  • Rincian / Catatan Negosiasi: [catatan]

  Catatan: Saya memahami pemesanan katering/acara ini memerlukan konfirmasi dan persetujuan. Mohon informasinya lebih lanjut. Terima kasih!
  ```
- *Catatan Katering:* Pesanan katering acara tidak masuk ke sistem database; komunikasi dan negosiasi dilakukan langsung dengan Admin via WhatsApp, dan Admin yang menentukan apakah pesanan katering diterima atau ditolak sesuai kapasitas dapur.

### Footer
Tampil konsisten di seluruh halaman publik dengan tata letak modular 3 kolom yang seimbang dan bebas dari tautan medsos:
1. **Brand & Motto:** Profil singkat Yan's Food dan dedikasi cita rasa rumahan.
2. **Navigasi Cepat:** Tautan langsung ke Home, About, Menu, Pesan, Contact.
3. **Kontak & Operasional:** Alamat dapur fisik, jam operasional resmi (08.00 - 22.00 WIB), dan WhatsApp Admin (+62 822-2122-2936).
4. **Platform Delivery Resmi:** Baris *"Tersedia juga di:"* (ShopeeFood, GoFood, GrabFood).

## 5. Admin Website

Admin panel dibangun manual dengan Laravel Blade + Tailwind CSS menggunakan satu layout bersama (`layouts/admin.blade.php`).

Sidebar navigasi:

```text
YAN'S FOOD
Admin Panel

MAIN
- Dashboard

TRANSACTION
- POS
- Transaksi

CATALOG
- Produk
- Resep

FINANCE
- Pengeluaran
- Laporan

SYSTEM
- Printer
- Pengguna
- Pengaturan
```

## 6. Dashboard

KPI & Metrik Harian:
- Omset POS Hari Ini
- Total Transaksi Hari Ini
- Pengeluaran Belanja Operasional Hari Ini
- Laba Bersih Sederhana
- Peringatan Stok Produk Menipis / Habis

Formula:
`Laba Bersih Sederhana = Total Penjualan POS Kasir - Total Biaya Operasional Disetujui`

## 7. Produk & Manajemen Katalog

Fitur:
- Manajemen seluruh katalog menu kuliner;
- Pencarian dan filter kategori;
- Tambah, edit, dan hapus produk (dengan proteksi integritas transaksi kasir);
- Upload foto menu kuliner;
- Harga jual, stok fisik, satuan, dan deskripsi menu;
- Sakelar status: `Sedia` (*available*) dan `Tidak Tersedia` (*unavailable*).

### Database

`product_categories`:
```text
id
name
created_at
updated_at
```

`products`:
```text
id
name
category_id
description
price
stock
unit
image
status
created_at
updated_at
```

Relationship: `ProductCategory` 1:N `Product`.

## 8. Resep & Inventaris Dapur

Dokumentasi standar resep dapur (*Bill of Materials*) yang mengaitkan menu jadi dengan daftar bahan baku, takaran per porsi, dan petunjuk masak.

`recipes`:
```text
id
product_id
name
description
yield
notes
created_at
updated_at
```

`recipe_ingredients`:
```text
id
recipe_id
ingredient_name
quantity
unit
notes
created_at
updated_at
```

Relationship:
- `Product` 1:N `Recipe`
- `Recipe` 1:N `RecipeIngredient`

## 9. POS (Point of Sale / Kasir)

Flow:
```text
Pilih Produk Sedia
→ Atur Kuantitas
→ Subtotal
→ Diskon (opsional)
→ Total Tagihan
→ Pilih Metode Pembayaran: Tunai (Cash) atau QRIS
→ Jika Cash: Input Nominal Uang Tunai Diterima → Perhitungan Kembalian Otomatis
→ Jika QRIS: Tampilkan QR Code Resmi Kasir → Konfirmasi Pembayaran
→ Simpan Transaksi (Atomic Transaction & Potong Stok Otomatis)
→ Cetak Struk Kasir Thermal (58mm/80mm)
```

- **UI Ringkas & Efisien:** Tampilan kasir bersih dari petunjuk pintasan keyboard (F2/F4/F9) yang tidak perlu, search bar yang responsif dan leluasa, serta tombol aksi cepat "Bayar Cash" dan "Lanjut ke QRIS".
- Kalkulasi harga, subtotal, total, dan kembalian dihitung ulang oleh backend service. Client tidak menjadi sumber kebenaran transaksi.

## 10. Transaksi Kasir

`transactions`:
```text
id
transaction_number
transaction_date
transaction_time
cashier_id
subtotal
discount
total
payment_method
amount_paid
change
status
created_at
updated_at
```

`transaction_items`:
```text
id
transaction_id
product_id
product_name
quantity
unit_price
subtotal
created_at
updated_at
```

- **Pengelompokan Otomatis Riwayat per Bulan (Include Monthly):** Daftar riwayat transaksi kasir mengelompokkan arsip per bulan secara realtime/otomatis (section khusus per bulan dengan riwayat transaksi lengkap), memudahkan kasir dan pemilik usaha meninjau data historis tanpa kehilangan konteks.
- **Tampilan Bersih & Minimalis:** Menghilangkan badge bulan berjalan berlebih dan angka counter redundan agar interface fokus pada kejelasan data transaksi.
- Nama produk dan harga satuan disimpan sebagai snapshot historis agar nota lama tetap akurat meskipun harga katalog diubah di masa depan.

## 11. Pengeluaran Operasional Dapur

Pencatatan biaya operasional harian dapur dengan fitur manajemen penuh (Full CRUD):
- Kategori pengeluaran: Bahan Baku, Gas Dapur, Listrik, Air, Kemasan/Packaging, Transportasi, Peralatan Dapur, Pemeliharaan/Maintenance, dan Biaya Lain-lain.
- **Filterisasi Rentang Waktu:** Mendukung filter hari ini, minggu ini, bulan ini, tahun ini, dan rentang tanggal kustom (*custom range*).
- **Pengelompokan Riwayat Pengeluaran per Bulan:** Section riwayat pengeluaran otomatis include per bulan untuk memudahkan audit berkala.
- **Proses Cepat & Ringkas:** Menghapus keharusan upload foto nota fisik dan kolom bukti nota di tabel, sehingga kasir/admin dapat mencatat belanja harian secara instan di lapangan.

`expense_categories`:
```text
id
name
created_at
updated_at
```

`expenses`:
```text
id
expense_number
expense_date
expense_type
category_id
name
amount
payment_method
period_start
period_end
description
status
created_by
created_at
updated_at
```

## 12. Laporan Keuangan & Penjualan

Page Laporan adalah pusat analisis performa finansial dan penjualan produk:
- **Ringkasan Finansial:** Total Penjualan POS Kasir, Total Pengeluaran Operasional, dan Laba Bersih Sederhana.
- **Rincian Arus Kas Harian (Akurat & Fixed):** Menampilkan rekap harian kas masuk (penjualan) dan kas keluar (pengeluaran) secara lengkap dan kronologis, termasuk tanggal-tanggal transaksi historis sebelum tanggal berjalan.
- **Komparasi Hasil Uang Bersih (Laba Bersih Dinamis):** Section ringkasan hasil uang bersih per bulan dan per tahun yang dinamis menyesuaikan filter waktu yang sedang aktif (bulan ini, tahun ini, atau semua waktu).
- **Rincian Pengeluaran Dapur per Kategori:** Grafik dan rincian proporsi pengeluaran dapur yang sinkron dengan periode filter aktif.
- **Tab Penjualan Kasir:** Daftar transaksi penjualan kasir otomatis include dan menampilkan label periode waktu aktif (hari, minggu, bulan, tahun, semua waktu).
- **Analisis Produk Terlaris:** Kuantitas terjual, jumlah transaksi, dan kontribusi omset per item menu.
- **Export CSV:** Mengunduh data penjualan dan performa produk secara dinamis mengikuti filter yang sedang aktif di layar.
- **UI Bersih:** Menghapus elemen dekoratif dan badge redundan di samping header laporan agar fokus pada visualisasi metrik bisnis.

## 13. Printer Thermal

`printers`:
```text
id
name
connection_type
paper_width
status
settings
created_at
updated_at
```

- Mendukung cetak nota kasir thermal 58mm dan 80mm.
- Struk pelanggan mencakup nomor transaksi, tanggal/waktu, nama kasir, rincian menu, subtotal, diskon, total, uang diterima, dan kembalian.
- Kegagalan cetak printer fisik tidak menggagalkan penyimpanan transaksi kasir; transaksi dapat dicetak ulang kapan saja.

## 14. Service Layer Architecture

```text
app/Services/
- TransactionService.php
- ReceiptService.php
- ReportService.php
- ThermalPrinterService.php
```

Tanggung jawab:
- `TransactionService`: Alur transaksi kasir, validasi stok, pemotongan stok atomik, dan kalkulasi kembalian.
- `ReceiptService`: Format struk kasir thermal (header, baris item, subtotal, footer).
- `ReportService`: Agregasi performa omset POS, laporan laba bersih, rangkuman biaya operasional, dan penyiapan ekspor CSV.
- `ThermalPrinterService`: Abstraksi perintah printer dan format teks ESC/POS.

## 15. Database Transaction Safety & Triggers

Operasi penyimpanan kasir dan pencatatan belanja dijalankan secara atomik:
```text
DB::beginTransaction()
→ Validasi Data & Ketersediaan Stok
→ Simpan Transaksi Kasir
→ Simpan Snapshot Detail Item
→ Trigger trg_after_transaction_item_insert memotong stok produk
→ DB::commit()
```
Jika terjadi kegagalan: `DB::rollBack()`.

## 16. Manajemen Pengguna & Tata Letak Antarmuka Admin

Peran pengguna:
- **Admin:** Memiliki akses penuh ke seluruh modul sistem (Dashboard, POS, Transaksi, Produk, Resep, Pengeluaran, Laporan Keuangan, Printer, dan Pengaturan Pengguna).
- **Kasir:** Terbatas pada modul operasional harian (POS Kasir, Riwayat Transaksi Penjualan, dan Konfigurasi Printer).
- **Tampilan Bersih:** Menghilangkan teks status hak akses redundan pada halaman pengguna agar antarmuka ringkas dan profesional.

### Desain Responsif & Optimalisasi Ruang (Layout Admin)
- **Navbar Sidebar Optimal:** Posisi navbar samping dinaikkan untuk menghilangkan ruang kosong bagian atas (*whitespace*) sehingga navigasi lebih seimbang dan estetik.
- **Responsif di Semua Perangkat:** Seluruh halaman admin dioptimalkan untuk dapat diakses secara nyaman dan jelas di layar Desktop, Tablet, hingga Ponsel (Mobile).
- **Tata Letak Grid Produk & Resep:** Tampilan foto produk dan kartu resep dapur diatur dengan sistem 2-grid proporsional di perangkat mobile/tablet agar informasi resep dan detail produk terbaca dengan jelas tanpa memakan ruang vertikal berlebih.

## 17. Struktur Folder Proyek

```text
yans-food/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/               (Dashboard, Pos, Transaction, Product, Recipe, Expense, Report, Printer, User, Setting)
│   │   └── PageController.php   (Home, About, Menu, Pesan, Contact)
│   ├── Models/                  (Product, ProductCategory, Recipe, RecipeIngredient, Transaction, TransactionItem, Expense, ExpenseCategory, Printer, User)
│   └── Services/                (TransactionService, ReceiptService, ReportService, ThermalPrinterService)
├── database/
│   ├── migrations/              (Users, Product Categories, Products, Recipes, Expenses, Transactions, Printers, Routines)
│   └── seeders/                 (DatabaseSeeder, ProductCategorySeeder, ProductSeeder, ExpenseCategorySeeder, PrinterSeeder)
├── resources/
│   ├── css/app.css              (Tailwind CSS v4)
│   ├── js/                      (Navbar, Search, Cart, POS, Modal, Analytics)
│   └── views/
│       ├── admin/               (Dashboard, POS, Products, Recipes, Transactions, Expenses, Reports, Printers, Users, Settings)
│       ├── components/          (Public Navbar, Footer, Floating WA, Alert, Confirmation Modal)
│       ├── layouts/             (app.blade.php untuk publik, admin.blade.php untuk admin)
│       └── pages/               (home, about, menu, pesan, contact)
├── routes/
│   └── web.php                  (Rute publik & rute panel admin)
└── README.md
```

## 18. Prinsip Final

1. **One Backend, One Database, One Business Logic.**
2. **Server-Side Truth:** Jangan mempercayai total atau harga dari sisi client.
3. **Auditable History:** Tidak melakukan hard-delete pada data produk yang memiliki riwayat transaksi kasir.
4. **Sinkronisasi Stok:** Pemotongan stok dieksekusi secara real-time via database trigger saat transaksi kasir tersimpan.
5. **Cetak Mandiri & Andal:** Kegagalan perangkat printer tidak membatalkan transaksi kasir; nota dapat dicetak ulang.
6. **Laporan Realistis:** Laba bersih sederhana mencerminkan omset kasir riil dikurangi seluruh pengeluaran operasional dapur yang disetujui.

---

**YAN'S FOOD — POS, PRODUCT MANAGEMENT & COMPANY PROFILE**
