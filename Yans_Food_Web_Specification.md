# YAN'S FOOD — WEBSITE SPECIFICATION

## 1. Konsep

Yan's Food adalah website berbasis Laravel yang menggabungkan **company profile** dan **sistem manajemen bisnis kuliner** dalam satu platform. Public website digunakan pelanggan untuk melihat profil, produk, catering, dan kontak. Admin website digunakan untuk mengelola operasional bisnis.

POS adalah salah satu modul, bukan keseluruhan sistem.

**Kategori:** Integrated Food Business Management System.

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

- PHP / Laravel
- Laravel Blade
- Tailwind CSS
- Vite
- Filament
- Eloquent ORM
- MySQL/MariaDB
- REST API
- Thermal printer 58mm/80mm

## 4. Public Website

Navbar utama:

```text
Home | About | Menu | Pesan | Contact
```

Penamaan "Menu" (menggantikan "Products") dan "Pesan" (menggantikan "Catering") digunakan konsisten di navbar, judul halaman, dan URL publik — selaras dengan dokumentasi UI/UX.

Gallery bersifat opsional.

### Home
Hero, pengenalan Yan's Food, CTA produk/catering, produk unggulan, keunggulan bisnis, highlight catering, optional gallery, contact CTA, footer.

### About
Cerita usaha, visi, misi, nilai, kualitas, kebersihan, dan pelayanan.

### Menu
*(sebelumnya "Products")*

Menampilkan produk dari database dengan filter kategori. Produk berstatus **Sedia** dapat ditampilkan sebagai tersedia; produk **Tidak Tersedia** tidak boleh dipresentasikan sebagai produk yang dapat dibeli.

### Pesan
*(sebelumnya "Catering"; halaman ini menggabungkan dua kanal pemesanan — Pesan Online & Pesan Katering — karena keduanya sama-sama menjawab pertanyaan "bagaimana cara membeli Yan's Food")*

#### A. Pesan Online

Bagian ini menjelaskan bahwa Yan's Food tersedia di layanan pesan-antar pihak ketiga untuk pembelian harian (bukan acara/event):

- Menampilkan logo **ShopeeFood**, **GoFood**, **GrabFood**, masing-masing clickable menuju link/aplikasi resmi toko Yan's Food di platform tersebut.
- Bersifat konten statis/konfigurasi (link platform), tidak memerlukan tabel database baru — tiga link tersebut cukup disimpan sebagai pengaturan sederhana (lihat §17 Pengaturan/Settings, atau bisa di-hardcode di konfigurasi environment bila jarang berubah).
- Tidak melibatkan `catering_orders` atau proses checkout apa pun di sisi Yan's Food — transaksi dan pembayaran sepenuhnya berlangsung di platform pihak ketiga tersebut.

#### B. Pesan Katering

Menjelaskan layanan, paket, menu, dan form pemesanan katering.

Alur pemesanan (bukan chat manual bebas di WA):
1. Pelanggan mengisi **form terstruktur** di website: nama, alamat, pilih produk (dropdown dari database) + qty, tanggal & jam acara, keperluan, catatan.
2. Saat submit, Laravel menyimpan data ke `catering_orders` **dan** menghitung total harga otomatis dari harga produk di database (bukan input manual pelanggan).
3. Data pesanan (termasuk total harga) langsung tersimpan dan tampil di Admin Web pada page Pesanan Catering.
4. Pelanggan di-redirect ke WhatsApp Admin (`wa.me` dengan pesan terformat otomatis berisi ringkasan pesanan) untuk melanjutkan **konsultasi/komunikasi** — nego menu, detail tambahan, atau perubahan request.
5. Jika hasil konsultasi WA mengubah pesanan (misal qty nambah, request custom di luar form), admin memperbarui data terkait secara manual di Admin Web — WA tetap jadi kanal komunikasi final yang fleksibel/manusiawi, form hanya starting point yang mempercepat proses.

Form tidak menggantikan peran WhatsApp sebagai kanal komunikasi personal; form berfungsi sebagai pintu masuk terstruktur agar data awal & estimasi harga otomatis tervalidasi sebelum percakapan berlangsung.

Tampilan: dua bagian (A dan B) dipisahkan jelas secara visual pada halaman yang sama (Pesan Online ditampilkan lebih dulu, diikuti Pesan Katering), bukan dua page terpisah.

### Contact
Alamat, WhatsApp, Instagram, jam operasional, Maps, dan CTA kontak.

### Gallery
Opsional; dapat menjadi section Home jika foto belum cukup.

### Footer
Tampil konsisten di semua halaman publik (bukan hanya Home). Selain navigasi, kontak, dan sosial media, footer menampilkan baris **"Tersedia juga di:"** berisi logo ShopeeFood, GoFood, dan GrabFood (link sama seperti pada bagian Pesan Online) — berfungsi sebagai trust signal persisten bahwa Yan's Food sudah tersedia di platform pesan-antar.

## 5. Admin Website

Sidebar final:

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

CATERING
- Pesanan Catering
- Pembayaran Catering
- Penghasilan Catering

FINANCE
- Pengeluaran
- Laporan

SYSTEM
- Printer
- Pengguna
- Pengaturan
```

## 6. Dashboard

KPI:
- Pendapatan hari ini
- Transaksi hari ini
- Pengeluaran hari ini
- Laba bersih sederhana
- Catering belum lunas
- Catering selesai

Formula awal:

`Laba Bersih Sederhana = Total Pemasukan - Total Pengeluaran`

## 7. Produk

Hanya satu page **Produk**. Tidak ada page kategori terpisah.

Fitur:
- semua produk;
- search;
- filter kategori;
- create/read/update/delete;
- foto;
- harga;
- stock;
- unit;
- status.

Status wajib:
- `Sedia`
- `Tidak Tersedia`

Status berbeda dengan stock. Produk Tidak Tersedia tidak boleh dijual di POS.

Kategori dapat dikelola langsung dari form/modal produk.

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

Relationship: Product Category 1:N Product.

## 8. Resep

Hanya satu page **Resep**. Detail resep berisi bahan.

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
- Product 1:N Recipe
- Recipe 1:N RecipeIngredient

## 9. POS

Flow:

```text
Pilih Produk
→ Quantity
→ Subtotal
→ Total
→ Cash
→ Amount Received
→ Change
→ Confirm
→ TransactionService
→ Database
→ Payment Success
→ Print Receipt
```

Tahap awal pembayaran: CASH.

Laravel wajib menghitung ulang harga, subtotal, total, dan kembalian. Client tidak boleh menjadi sumber kebenaran transaksi.

## 10. Transaksi

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

Nama dan harga disimpan sebagai snapshot historis agar transaksi lama tetap terbaca.

Produk yang sudah pernah dipakai transaksi sebaiknya tidak di-hard-delete; gunakan status/soft delete.

## 11. Catering

Pesanan, pembayaran, dan penghasilan adalah page terpisah.

### 11.1 Alur Masuknya Pesanan (Form Publik → Admin)

Pesanan katering **tidak diinput manual oleh admin dari chat WA**. Sumber data resmi adalah form pemesanan di halaman publik (lihat §4 Pesan — bagian B. Pesan Katering):

```text
Pelanggan isi form (Nama, Alamat, Produk+Qty, Tanggal/Jam, Keperluan, Catatan)
→ Submit
→ CateringService: validasi input, ambil harga produk dari database
→ Hitung subtotal & total otomatis (server-side, bukan dari input pelanggan)
→ Simpan ke `catering_orders` dengan status default PENDING, payment_status UNPAID
→ Data & total harga langsung tampil di Admin Web (page Pesanan Catering)
→ Generate pesan WA terformat → redirect pelanggan ke WhatsApp Admin
   (kanal ini dipakai untuk konsultasi/komunikasi lanjutan, bukan sumber data)
```

Jika hasil konsultasi WA mengubah detail pesanan (menu, qty, tanggal), **admin memperbarui data tersebut secara manual** melalui page Pesanan Catering di Admin Web — form publik hanya jadi entry point awal yang mempercepat proses, bukan satu-satunya titik update. WA tetap menjadi kanal komunikasi final yang fleksibel/manusiawi antara admin dan pelanggan.

### 11.2 Status

Status order:
- PENDING
- CONFIRMED
- IN_PROGRESS
- READY
- **DELIVERING** (dikirim — pesanan sedang diantar ke lokasi acara)
- COMPLETED
- CANCELLED

Payment status:
- UNPAID
- DP
- PAID

Admin mengubah status order melalui dropdown/select di page Pesanan Catering (tidak melalui form terpisah), sesuai progres pesanan: PENDING → CONFIRMED → IN_PROGRESS → READY → DELIVERING → COMPLETED.

Status DELIVERING eksplisit dipisah dari READY karena "siap" (bahan/produk selesai disiapkan) dan "sedang diantar" adalah dua kondisi berbeda yang perlu diketahui admin maupun pelanggan — terutama untuk pesanan yang diantar ke lokasi acara, bukan diambil sendiri oleh pelanggan. Untuk pesanan yang diambil sendiri (self pick-up), admin dapat melewati status ini langsung dari READY ke COMPLETED.

### 11.3 Struktur Data

`catering_orders`:
```text
id
order_number
customer_name
customer_phone
customer_address
event_date
event_time
event_purpose
notes
subtotal
discount
total
status
payment_status
created_by
created_at
updated_at
```

`catering_order_items`:
```text
id
catering_order_id
product_id
product_name
quantity
unit_price
subtotal
created_at
updated_at
```

Payment:
- CASH
- DP
- PELUNASAN

`catering_payments`:
```text
id
catering_order_id
payment_number
payment_type
amount
payment_method
payment_date
received_by
notes
created_at
updated_at
```

Formula:

`Total Dibayar = SUM(payment.amount)`

`Sisa = Total Pesanan - Total Dibayar`

Pembayaran yang melebihi sisa harus ditolak. Order COMPLETED tidak otomatis berarti PAID.

### 11.4 Penghasilan Catering (Page Baru)

Page khusus untuk melihat rekap **uang yang benar-benar diterima** dari pesanan katering — berbeda dari page Pesanan Catering (fokus status order) dan Pembayaran Catering (fokus input transaksi DP/pelunasan per order).

Tidak memerlukan tabel baru — data diagregasi dari `catering_payments` (join ke `catering_orders` untuk info order terkait).

Fitur:
- Filter rentang tanggal (Hari Ini, Minggu Ini, Bulan Ini, Custom, Keseluruhan) berdasarkan `payment_date`
- Ringkasan: total penghasilan catering pada periode terpilih, jumlah pembayaran diterima, jumlah order terkait
- Tabel rincian: tanggal bayar, order terkait, nama pelanggan, jenis pembayaran (DP/Pelunasan), nominal
- Nilai mengikuti filter aktif, konsisten dengan pola filter yang sudah dipakai di page Laporan (§13)

`ReportService` bertanggung jawab menyediakan data agregat ini (lihat §15), tidak perlu service baru. 

## 12. Pengeluaran

Kategori:
- Bahan Baku
- Gas
- Listrik
- Air
- Kemasan
- Transportasi
- Peralatan
- Maintenance
- Lain-lain

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

## 13. Laporan

Page Laporan adalah pusat analisis transaksi dan performa bisnis.

Ringkasan:
- Pendapatan
- Transaksi
- Total Semua Transaksi

Filter:
- Hari Ini
- Minggu Ini
- Bulan Ini
- Custom Date
- Keseluruhan

Filter tanggal memengaruhi summary dan riwayat transaksi.

**Keseluruhan** berarti seluruh data sejak sistem mulai mencatat transaksi sampai sekarang.

### Filter Produk

Admin dapat memilih produk tertentu. Hasil menampilkan:
- quantity terjual;
- jumlah transaksi;
- pendapatan produk;
- riwayat transaksi terkait.

Filter tanggal + produk dapat dipakai bersamaan.

Tujuan analisis:
- mengetahui produk sering dibeli;
- mengetahui produk jarang dibeli;
- mengetahui quantity terjual;
- mengetahui pendapatan per produk.

Contoh:
```text
Produk       Terjual     Pendapatan
Nasi Box       185       Rp2.775.000
Gorengan       520       Rp1.040.000
Es Teh         310       Rp1.240.000
```

Laporan Web dan Mobile harus menggunakan definisi dan sumber data yang sama.

### Filter Laporan Catering

Section terpisah (tab/switch) di page Laporan, khusus menganalisis performa penjualan katering — terpisah dari laporan penjualan POS reguler karena sifat datanya beda (order berbasis event, bukan transaksi harian).

Menggunakan filter yang sama seperti laporan reguler:
- Hari Ini / Minggu Ini / Bulan Ini / Custom / Keseluruhan (berdasarkan `event_date` atau `payment_date`, dapat dipilih sesuai kebutuhan analisis)

Menampilkan:
- Total order catering pada periode terpilih
- Total penghasilan catering (dari `catering_payments`, sinkron dengan page Penghasilan Catering §11.4)
- Breakdown per status order (berapa PENDING, COMPLETED, CANCELLED, dst.)
- Rincian order: nomor order, pelanggan, tanggal acara, total, status, payment status

### Export CSV

Berlaku di seluruh page Laporan (baik laporan penjualan reguler maupun section Laporan Catering):
- Tombol "Export CSV" mengekspor data **sesuai filter yang sedang aktif** (rentang tanggal, produk, atau kombinasi keduanya untuk laporan reguler; rentang tanggal & status untuk laporan catering)
- Kolom export mengikuti kolom yang ditampilkan di tabel pada tampilan aktif, agar hasil unduhan konsisten dengan apa yang dilihat admin di layar
- Proses export tidak menghitung ulang di sisi client — data diambil dari hasil query `ReportService` yang sama dengan yang menampilkan angka di layar

## 14. Printer

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

Mendukung Bluetooth/USB/Network sesuai printing layer. Jangan mengasumsikan browser/Laravel dapat mengontrol Bluetooth secara langsung.

Receipt customer berisi nomor transaksi, tanggal/waktu, kasir, item, qty, harga, subtotal, total, payment, change, dan footer.

Order/kitchen note dapat berisi customer, order, tanggal acara, item, quantity, dan catatan tanpa harga.

Jika printer gagal, transaksi tetap sukses dan dapat dicetak ulang.

## 15. Service Layer

```text
app/Services/
- CateringService.php
- PaymentService.php
- TransactionService.php
- ReceiptService.php
- ReportService.php
- ThermalPrinterService.php
```

Tanggung jawab:
- TransactionService: transaksi, validasi, total, change.
- CateringService: order dan status.
- PaymentService: DP, pelunasan, sisa, payment status.
- ReceiptService: data receipt/order note.
- ReportService: sales, catering, expenses, profit, filter tanggal/produk.
- ThermalPrinterService: data/command printing.

## 16. Database Transaction Safety

Operasi penting:

```text
BEGIN
→ Validate
→ Save
→ Update
→ COMMIT
```

Jika gagal:

```text
ROLLBACK
```

## 17. Authentication

Role awal:
- Admin
- Cashier

Authorization harus diterapkan di backend.

## 18. Folder Structure

```text
yans-food/
├── app/
│   ├── Enums/
│   ├── Filament/
│   │   ├── Resources/
│   │   ├── Pages/
│   │   └── Widgets/
│   ├── Http/
│   ├── Models/
│   ├── Services/
│   └── Providers/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── public/
│       ├── layouts/
│       ├── components/
│       ├── catering/
│       └── printing/
├── routes/
│   ├── web.php
│   └── api.php
├── storage/app/public/
│   ├── products/
│   ├── recipes/
│   └── expenses/
├── public/
├── tests/
└── README.md
```

## 19. Migration Order

```text
users
product_categories
products
recipes
recipe_ingredients
expense_categories
expenses
transactions
transaction_items
catering_orders
catering_order_items
catering_payments
printers
```

## 20. Development Roadmap

```text
Foundation
→ Public Website
→ Product
→ Recipe
→ POS
→ Catering
→ Catering Payment
→ Expense
→ Report
→ Printing
→ Testing
```

Implement per module:

`DATABASE → MODEL → MIGRATION → RELATIONSHIP → SERVICE → FILAMENT RESOURCE → VALIDATION → UI → REPORT → PRINTING → TESTING`

## 21. Git

Branches:
```text
main
develop
feature/*
fix/*
```

Examples:
```text
feature/product-crud
feature/pos
feature/catering-payment
feature/thermal-print
fix/payment-validation
```

## 22. Definition of Done

Setiap modul harus memiliki:
- database;
- model;
- relationship;
- CRUD;
- validation;
- authorization;
- responsive UI;
- error handling;
- testing;
- dokumentasi;
- tidak ada duplikasi data yang tidak diperlukan.

## 23. Prinsip Final

1. One backend, one database, one business logic.
2. Jangan percaya total dari client.
3. Jangan hard-delete data histori.
4. Status produk berbeda dari stock.
5. Order status berbeda dari payment status.
6. Printer gagal tidak menghapus transaksi.
7. Laporan mengikuti filter yang dipilih.
8. Filter produk digunakan untuk analisis performa produk.
9. Web dan Mobile harus membaca sumber data yang sama.
10. Pesanan catering masuk melalui form publik terstruktur (server menghitung total), bukan diketik manual dari chat WA; WhatsApp tetap menjadi kanal komunikasi/konsultasi, bukan sumber data. Perubahan hasil konsultasi WA diupdate manual oleh admin di Admin Web.
11. Export CSV laporan (reguler maupun catering) selalu mengikuti filter yang sedang aktif di layar, tidak pernah mengekspor seluruh data di luar konteks filter.

## 24. Target

```text
Company Profile
+ Product Management
+ Recipe Management
+ POS
+ Transaction Management
+ Catering
+ Catering Payment
+ Catering Income (Penghasilan Catering)
+ Expense
+ Reporting
+ Product Analysis
+ Thermal Printing
+ User Management
=
YAN'S FOOD INTEGRATED FOOD BUSINESS MANAGEMENT SYSTEM
```
