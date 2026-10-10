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

- PHP / Laravel 11
- Laravel Blade
- Tailwind CSS (Warm Artisanal Design Tokens)
- Google Fonts (`Outfit` untuk headings, `Plus Jakarta Sans` untuk body/UI)
- Google Material Symbols (Outlined & Rounded)
- Vite
- Filament (Admin Panel)
- Eloquent ORM
- MySQL/MariaDB
- REST API
- Thermal printer 58mm/80mm

## 4. Public Website (Company Profile)

Public website Yan's Food dirancang dengan pendekatan visual **"Warm Artisanal Culinary"** (mengacu pada [DESIGN.md](file:///c:/SEKOLAH/12semester1/PROD%20%28PA%20ANGGA%29/Yans%20Food/yans-food/DESIGN.md)), merefleksikan kehangatan dapur rumahan yang bersih, higienis, terpercaya, dan profesional tanpa kesan korporat yang kaku.

### 4.1 Desain & Karakteristik Visual
- **Palet Warna Utama:**
  - *Primary (Terakota):* `#C1440E` / `#9B3100` (Brand utama, tombol CTA primer, aksen aktif).
  - *Tertiary (Warm Gold):* `#D6A253` (Aksen bintang rating, border paket katering terpopuler, highlight).
  - *Base Background (Cream):* `#FBF6EE` / `#FFF8F3` (Latar kanvas utama).
  - *Background Alt (Soft Sand):* `#F1E6D6` (Latar selang-seling section & banner).
  - *Surface Warm:* `#FFFDF9` (Card container elevated, modal, drawer).
  - *Charcoal Text:* `#26201B` / `#655D57` (Tipografi kontras tinggi & nyaman dibaca).
  - *Success (Halal & Sedia):* `#3F7D53` (Badge status "Sedia" & jaminan halal).
  - *Muted (Habis):* `#9C9284` (Badge status "Tidak Tersedia / Habis").
- **Tipografi:**
  - *Display / Headings / Brand:* `Outfit` (Modern, proporsional, ramah selera makan).
  - *Body / Content / UI / Numerik:* `Plus Jakarta Sans` (Jernih, proporsi bersih, tabular numerals untuk harga).
- **Iconography & Micro-interactions:**
  - Google Material Symbols Outlined & Rounded.
  - Micro-animations halus (150–250ms `cubic-bezier(0.22, 1, 0.36, 1)`).

---

### 4.2 Struktur Navigasi & Header
Fixed header dengan efek `backdrop-blur-md bg-cream-bg/95`:
- **Navbar Utama:**
  ```text
  Home | About | Menu | Pesan | Contact
  ```
- **Desktop Navigation:**
  - Dilengkapi **animated underline indicator** (`bg-gradient-to-r from-primary to-primary-container`) yang mengembang halus dari tengah saat hover dan aktif solid pada route yang sesuai (menggantikan kotak warna kaku).
- **Header Actions:**
  - **Tombol CTA "Pesan Sekarang":** Tombol aksi utama pada navbar yang langsung mengarahkan pengunjung ke halaman Pesan (`/pesan`) untuk memilih kanal pemesanan (Online Delivery mitra atau Formulir Reservasi Katering terstruktur). Barisan navbar tidak menggunakan keranjang belanja agar fokus company profile tetap sederhana, bersih, dan langsung terarah ke halaman pemesanan resmi.
  - **Mobile Drawer Hamburger Button:** Membuka slide-over menu navigasi pada resolusi mobile/tablet dengan backdrop gelap transparan (`backdrop-blur-xs`).

---

### 4.3 Halaman Home (Beranda) — `pages/home.blade.php`
1. **Hero Section:**
   - Review pill badge kredibel: Rating 4.9/5 dari 500+ Pelanggan Puas.
   - Headline utama: *"Rasa Rumahan, Disajikan dengan Hati"*.
   - Subheadline tentang dapur rumahan yang bersih, higienis, dan penuh dedikasi.
   - Tombol CTA ganda: *"Lihat Menu Lengkap"* (`/menu`) dan *"Pesan Sekarang"* (`/pesan`).
   - 3 Trust Badges: *100% Bahan Segar Alami*, *Fresh Dibuat Hari Ini*, *Halal Higienis & Amanah*.
   - Visual Collage: Foto kuliner otentik rasio 4:5 dengan floating pill *"Kudapan & Makanan Hangat — Resep Asli Racikan Keluarga"*.
2. **Pengenalan Singkat Dapur Bersih:**
   - Cerita komitmen kebersihan dapur dan pengolahan higienis Yan's Food.
3. **6 Keunggulan Utama Bisnis (Pillar of Excellence):**
   - Bahan Alami Pilihan (tanpa pengawet buatan).
   - Higienis & 100% Halal.
   - Dibuat Fresh Harian (bukan frozen stok lama).
   - Kemasan Rapi & Higienis (food-grade).
   - Layanan Ramah Kekeluargaan.
   - Harga Jujur & Terjangkau.
4. **Highlight Menu Favorit:**
   - Menampilkan hidangan unggulan (*Risol Mayo Beef & Egg*, *Pisang Coklat Crispy*, *Nasi Goreng Jadul Yan's*, *Tahu Bakso Kukus/Goreng*).
   - CTA langsung menuju katalog lengkap di `/menu`.
5. **Highlight Layanan Katering Acara:**
   - Banner penjelasan katering rumahan (Snack Box, Nasi Kotak Nusantara, Prasmanan Mini) beserta CTA menuju form di `/pesan`.
6. **Banner Kontak & Lokasi Dapur:**
   - Informasi alamat, jam operasional, dan ajakan mampir langsung ke dapur.

---

### 4.4 Halaman About (Tentang Kami) — `pages/about.blade.php`
1. **Header Editorial Sub-Hero:**
   - Judul: *"Dapur Rumahan yang Tumbuh Bersama Kehangatan & Kejujuran Rasa"*.
2. **Kisah Usaha (Brand Story):**
   - Perjalanan dari dapur kecil keluarga dan racikan risol mayo legendaris.
   - Filosofi utama: *"Bukan Pabrik Makanan, Kami Memasak Seperti untuk Keluarga Sendiri"*.
   - Highlight Quote Dapur Utama Yan's Food bergaris aksen Warm Gold.
   - Stat Metrik: *100% Bebas Pengawet*, *15+ Varian Resep*, *500+ Acara Terlayani*.
3. **4 Nilai Utama Usaha:**
   - *Kejujuran Rasa:* Rempah asli utuh tanpa pemalsuan atau jalan pintas.
   - *Higienitas Tanpa Kompromi:* Standar kebersihan dapur setara rumah makan modern.
   - *Pelayanan Penuh Hati:* Melayani setiap pesanan selayaknya menjamu tamu di rumah.
   - *Tumbuh Bersama Komunitas:* Menjadi bagian dari momen kebersamaan pelanggan.
4. **4 Standar Kualitas Dapur Bersih:**
   - *Seleksi Bahan Pagi Hari:* Sayuran, daging, dan telur segar setiap subuh.
   - *Minyak & Penggorengan Terkontrol:* Minyak jernih berkala, tidak menggunakan jelantah hitam.
   - *Dapur Terbuka & Bersih:* Sanitasi alat masak dan area kerja terjadwal ketat.
   - *Kemasan Food-Grade Ramah Konsumsi:* Kotak dan wadah aman, rapi, dan menjaga kerenyahan makanan.

---

### 4.5 Halaman Menu (Katalog Menu) — `pages/menu.blade.php`
1. **Top Banner & Quick Metrics:**
   - Headline: *"Daftar Menu Yan's Food"*.
   - Metric strip: *100% Halal — Masakan Higienis* dan *Fresh Cooked — Dibuat Sesuai Order*.
2. **Category Filter Ribbon & Live Search (`category-filter`):**
   - Filter chips pill: *Semua*, *Makanan Ringan*, *Makanan Berat*, *Mie Instan*, *Minuman Segar*.
   - Input pencarian real-time dengan ikon filter yang responsif.
3. **Product Catalog Grid (`food-card`):**
   - Menampilkan produk dari database.
   - Card produk: Foto rasio 1:1 (*square* hover-zoom), badge status (*"Sedia"* warna hijau atau *"Tidak Tersedia"* warna abu-abu netral), label kategori, harga dengan angka tabular tebal.
   - Tombol Aksi: Tombol Pesan Cepat (*Quick Order* via WhatsApp) atau diarahkan ke `/pesan`.
   - **Aturan Sistem:** Produk berstatus **Sedia** dapat dipesan; produk **Tidak Tersedia** tidak boleh dipresentasikan sebagai produk yang dapat dibeli (tombol dinonaktifkan).
4. **Quick Order Modal (`quick-order-modal`):**
   - Modal popup interaktif untuk pemesanan instan 1 menu via WhatsApp secara langsung.

---

### 4.6 Halaman Pesan (Cara Pesan) — `pages/pesan.blade.php`
Menggabungkan dua kanal pemesanan dalam satu halaman dengan pembagian visual yang tegas:

#### A. Bagian Pesan Online (Santapan Harian Praktis)
- Menjelaskan ketersediaan Yan's Food di aplikasi pesan-antar pihak ketiga untuk pembelian harian:
  - **ShopeeFood:** Voucher promo ongkir & diskon merchant mingguan.
  - **GoFood:** Pengiriman cepat armada gesit & kemasan tersegel higienis.
  - **GrabFood:** Promo langganan hemat & rating dapur bintang 4.9.
- Dilengkapi jam operasional layanan delivery: **09.00 – 19.30 WIB**.
- Konten bersifat tautan konfigurasi statis/eksternal, tidak melibatkan database `catering_orders` atau checkout sistem internal.

#### Visual Divider Ornamen Kuliner
Pemisah section anggun beraksen wajan & sendok garpu bernuansa Warm Gold dan Terakota.

#### B. Bagian Pesan Katering (Layanan Acara & Event)
- **3 Paket Katering Utama:**
  1. *Paket Snack Box Manis & Gurih:* Mulai Rp 12.000 / box (Min. 15 box). Kudapan gurih (Risol Mayo/Tahu Bakso) + manis (Pisang Coklat) + air mineral & tisu basah.
  2. *Paket Nasi Kotak Nusantara (Best Seller - Aksen Warm Gold):* Mulai Rp 28.000 / box (Min. 20 box). Nasi putih/kuning, ayam bakar/lengkuas, sambal korek, lalapan, tahu tempe, buah segar.
  3. *Paket Prasmanan Mini Rumahan:* Mulai Rp 45.000 / porsi (Min. 25 porsi). Solusi hidangan prasmanan hangat untuk acara keluarga atau kantor.
- **Formulir Reservasi Katering Terstruktur (`catering-form`):**
  - Input field wajib:
    - Nama Lengkap Pemesan.
    - Nomor WhatsApp Aktif.
    - Tanggal Acara & Waktu Pengantaran Tiba (Validasi min. H-2 acara).
    - Pilihan Paket Katering.
    - Jumlah Porsi / Box (Minimum 15 porsi).
    - Alamat Pengiriman Lengkap (beserta patokan lokasi).
    - Catatan Khusus (request alergi, pemisahan sambal, dll.).
- **Alur Sistem & Sinkronisasi Data (Backend & WhatsApp):**
  1. Pelanggan mengisi form terstruktur di website.
  2. Saat disubmit, Laravel (`CateringService`) memvalidasi input, mengambil harga produk/paket dari database, dan menghitung total harga secara aman di server (client tidak boleh memanipulasi total harga).
  3. Data tersimpan ke tabel `catering_orders` dengan status default `PENDING` dan payment status `UNPAID`.
  4. Data pesanan langsung muncul di Admin Panel pada halaman **Pesanan Catering**.
  5. Sistem men-generate tautan WhatsApp Admin (`wa.me`) dengan pesan terformat otomatis berisi ringkasan pesanan.
  6. Pelanggan melanjutkan konsultasi di WhatsApp untuk finalisasi detail atau negosiasi.
  7. Jika ada perubahan detail pesanan dari hasil chat WA, Admin memperbarui data secara manual di Admin Web (WhatsApp adalah kanal komunikasi manusiawi, form web adalah entry point terstruktur).

---

### 4.7 Halaman Contact (Kontak & Lokasi) — `pages/contact.blade.php`
1. **Header Sub-Hero:**
   - Judul: *"Pintu Dapur Kami Selalu Terbuka untuk Anda"*.
2. **4 Kartu Informasi Kontak:**
   - *Alamat & Pick-up:* Jl. Melati No. 14, Jakarta Selatan (200m timur Masjid At-Taqwa, parkir tersedia).
   - *Jam Buka Dapur:* Dapur & Ambil: 08.00 - 20.00 WIB | Delivery Online: 09.00 - 19.30 WIB (Buka Setiap Hari).
   - *WhatsApp Resmi:* +62 812-3456-7890 (Layanan CS & reservasi katering).
   - *Surel & Medsos:* `halo@yansfood.id` dan Instagram `@yansfood.official`.
3. **Formulir Tanya Cepat ke Dapur:**
   - Input nama, nomor kontak, topik pertanyaan, dan isi pesan yang terintegrasi langsung dengan WhatsApp Customer Service.
4. **Peta Interaktif & Petunjuk Rute:**
   - Embed Google Maps interaktif dengan card panduan rute dan fasilitas parkir.
5. **FAQ Dapur (Frequently Asked Questions):**
   - Tanya jawab seputar pemesanan mendadak, jaminan kehalalan, dan ketentuan DP katering.

---

### 4.8 Komponen Footer Persisten (`footer.blade.php`)
Tampil konsisten di semua halaman publik:
- **Kolom 1:** Logo brand monogram, motto rasa rumahan, dan badge *100% Halal & Fresh Cooked*.
- **Kolom 2:** Tautan navigasi internal (Home, About, Menu, Pesan, Contact).
- **Kolom 3:** Alamat lengkap, jam operasional, dan kontak nomor WhatsApp resmi.
- **Kolom 4:** Tautan media sosial resmi (Instagram, TikTok, Surel).
- **Strip Delivery Persisten:** Baris *"Tersedia juga di: ShopeeFood, GoFood, GrabFood"* sebagai trust signal persisten.
- **Copyright Bar:** `© 2026 Yan's Food. Semua hak cipta dilindungi.`

---

### 4.9 Komponen Global Lainnya
- **Back to Top Button (`back-to-top.blade.php`):** Tombol scroll halus dengan animasi transisi saat pengguna menggulir halaman.
- **Modal Pemesanan Cepat (`quick-order-modal.blade.php`):** Dialog responsif dengan backdrop blur untuk pemesanan produk tunggal via WhatsApp.

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
│       ├── layouts/
│       │   └── app.blade.php
│       ├── pages/
│       │   ├── home.blade.php
│       │   ├── about.blade.php
│       │   ├── menu.blade.php
│       │   ├── pesan.blade.php
│       │   └── contact.blade.php
│       ├── components/
│       │   ├── navbar.blade.php
│       │   ├── footer.blade.php
│       │   ├── food-card.blade.php
│       │   ├── category-filter.blade.php
│       │   ├── catering-form.blade.php
│       │   ├── quick-order-modal.blade.php
│       │   └── back-to-top.blade.php
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
