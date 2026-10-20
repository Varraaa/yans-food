# YAN'S FOOD — WEBSITE SPECIFICATION

## 1. Konsep

Yan's Food adalah platform web berbasis Laravel yang menggabungkan **company profile publik** dan **sistem manajemen bisnis kuliner terpadu (POS Kasir & Manajemen Produk)** dalam satu sistem. Public website digunakan pelanggan untuk melihat profil, katalog menu kudapan dan makanan hangat, informasi dapur, serta kanal pemesanan online delivery dan takeaway via WhatsApp. Admin website digunakan pemilik usaha dan kasir untuk mengelola operasional harian gerai.

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
Hero, pengenalan dapur Yan's Food, CTA pesan online delivery, menu favorit pilihan pelanggan, filosofi rasa rumahan, kontak cepat, dan footer.

### About
Cerita usaha dapur rumahan, filosofi "Cita Rasa Rumahan Disajikan dengan Hati", komitmen bahan baku segar higienis, dan timeline perjalanan usaha.

### Menu
Katalog kuliner dinamis dari basis data produk dengan filter kategori (Kudapan Renyah, Makanan Hangat, Aneka Lauk, Minuman Segar). Produk berstatus **Sedia** ditampilkan dengan badge hijau; produk **Tidak Tersedia** ditampilkan non-aktif.

### Pesan

Halaman terintegrasi untuk memesan produk Yan's Food melalui dua kanal resmi:

#### A. Pesan Online Delivery (Mitra Platform)
- Menampilkan card interaktif **ShopeeFood**, **GoFood**, dan **GrabFood**, masing-masing clickable menuju toko resmi Yan's Food di aplikasi tersebut untuk pemesanan instan harian dengan kurir platform.
- Transaksi dan pembayaran berlangsung di platform pihak ketiga tersebut.

#### B. Pesan Takeaway Dapur (Ambil Sendiri via WhatsApp)
- Layanan pemesanan langsung untuk diambil di dapur (*self pick-up*).
- Dilengkapi panduan pemesanan, format pesan otomatis ke WhatsApp Admin, serta nomor kontak resmi untuk konfirmasi waktu pengambilan pesanan.

### Contact
Alamat dapur, WhatsApp, email, jam operasional, Google Maps interaktif, dan formulir kontak/pertanyaan.

### Footer
Tampil konsisten di seluruh halaman publik. Memuat navigasi cepat, kontak dapur, jam operasional, tautan media sosial, serta baris **"Tersedia juga di:"** (ShopeeFood, GoFood, GrabFood).

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
→ Input Nominal Uang Tunai Diterima
→ Perhitungan Kembalian Otomatis
→ Simpan Transaksi (Atomic Transaction & Potong Stok Otomatis)
→ Cetak Struk Kasir Thermal
```

Kalkulasi harga, subtotal, total, dan kembalian dihitung ulang oleh backend service. Client tidak menjadi sumber kebenaran transaksi.

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

Nama produk dan harga satuan disimpan sebagai snapshot historis agar nota lama tetap akurat meskipun harga katalog diubah di masa depan.

## 11. Pengeluaran Operasional Dapur

Pencatatan biaya operasional harian dapur:
- Bahan Baku
- Gas Dapur
- Listrik
- Air
- Kemasan / Packaging
- Transportasi
- Peralatan Dapur
- Pemeliharaan / Maintenance
- Biaya Lain-lain

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
receipt_image
status
created_by
created_at
updated_at
```

## 12. Laporan Keuangan & Penjualan

Page Laporan adalah pusat analisis performa finansial dan penjualan produk:
- Ringkasan Finansial: Total Penjualan POS, Total Pengeluaran Operasional, dan Laba Bersih Sederhana.
- Analisis Produk Terlaris: Kuantitas terjual, jumlah transaksi, dan kontribusi omset per item menu.
- Riwayat Transaksi Kasir lengkap dengan filter waktu.
- Filter Rentang Waktu: Hari Ini, Minggu Ini, Bulan Ini, Custom Date, dan Keseluruhan.
- **Export CSV:** Mengunduh data penjualan dan performa produk secara dinamis mengikuti filter yang sedang aktif di layar.

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

## 16. Manajemen Hak Akses Pengguna

Peran pengguna:
- **Admin:** Memiliki akses penuh ke seluruh modul sistem (Dashboard, POS, Transaksi, Produk, Resep, Pengeluaran, Laporan Keuangan, Printer, dan Pengaturan Pengguna).
- **Kasir:** Terbatas pada modul operasional harian (POS Kasir, Riwayat Transaksi Penjualan, dan Konfigurasi Printer).

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
