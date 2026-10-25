# YAN'S FOOD — WEBSITE SPECIFICATION & TECHNICAL BLUEPRINT

## 1. Konsep & Filosofi Bisnis

**Yan's Food** adalah platform web terpadu berbasis Laravel 12 yang mengintegrasikan **Company Profile Publik** dan **Sistem Manajemen Bisnis Kuliner (Point of Sale / Kasir, Resep BOM, Biaya Operasional & Finansial)** dalam satu ekosistem digital.

- **Sisi Publik:** Digunakan oleh pelanggan untuk mengeksplorasi profil dapur, 40 katalog menu kudapan dan makanan hangat bernutrisi, informasi dapur fisik, serta 2 kanal pemesanan resmi: online delivery (**ShopeeFood, GoFood, GrabFood**) dan datang langsung ke tempat (**Takeaway / Pesan & Bawa Pulang, Tidak Melayani Dine-in**). Serta saluran negosiasi pesanan katering porsi besar via WhatsApp Admin.
- **Sisi Admin & POS:** Digunakan oleh pemilik usaha dan staf kasir untuk operasional harian: kasir kilat Tunai/QRIS, cetak struk thermal fisik RPP02N (Bluetooth & USB), pemotongan stok otomatis, manajemen resep *Bill of Materials*, pencatatan biaya operasional, dan laporan laba bersih riil.

**Kategori Sistem:** Integrated POS, Recipe/BOM Management, Kitchen Operational Accounting & Culinary Company Profile.

---

## 2. Arsitektur Sistem (Single Source of Truth)

```text
┌───────────────────────────────┐     ┌───────────────────────────────────┐
│     Public Website (Blade)    │     │     Admin Panel & Kasir POS       │
└───────────────┬───────────────┘     └─────────────────┬─────────────────┘
                │                                       │
                ▼                                       ▼
┌─────────────────────────────────────────────────────────────────────────┐
│                        Laravel 12 Backend Engine                        │
│   (Controllers, Middlewares, Enums, Form Requests, Routing Security)    │
└───────────────────────────────────┬─────────────────────────────────────┘
                                    │
                                    ▼
┌─────────────────────────────────────────────────────────────────────────┐
│                          Enterprise Service Layer                       │
│    • TransactionService (Kasir & ACID Logic)                            │
│    • ReportService (Agregasi Keuangan & Ekspor CSV)                     │
│    • ReceiptService (Format Struk & ESC/POS Command Builder)            │
│    • ThermalPrinterService (Layout & Pengaturan Cetak)                  │
└───────────────────────────────────┬─────────────────────────────────────┘
                                    │
                                    ▼
┌─────────────────────────────────────────────────────────────────────────┐
│                     MySQL 8.x Database Engine (RDBMS)                   │
│   • Trigger trg_after_transaction_item_insert (Auto Deduct Stock)       │
│   • Stored Function fn_calculate_simple_profit (Net Profit Logic)       │
│   • Stored Procedure sp_get_daily_sales_summary (Daily Sales Recap)     │
│   • ACID Transactions (DB::beginTransaction, Commit, Rollback)          │
└─────────────────────────────────────────────────────────────────────────┘
```

**Prinsip Utama:**
1. Satu backend, satu basis data relasional, satu business logic.
2. **Server-Side Truth:** Seluruh kalkulasi harga, potongan diskon, subtotal, total omset, kembalian, dan potongan stok dikontrol mutlak di server untuk mencegah manipulasi client-side.
3. **Auditable History:** Tidak ada hard-delete pada produk atau transaksi yang memiliki relasi historis.

---

## 3. Tech Stack & Dependensi

- **Backend Framework:** Laravel 12 (PHP 8.2+)
- **Frontend Template:** Laravel Blade Templates
- **CSS Engine:** Tailwind CSS v4 (dengan utility kustom `.admin-filter-scroll` untuk scroll responsif mobile yang nyaman)
- **Javascript Layer:** Vanilla JS interaktif & Vite
- **Database:** MySQL 8.x
- **Hardware Integration:** Thermal Printer **RPP02N (Model: DT-58B, 58mm, 5V-1A)** via **Web Bluetooth API** dan **WebUSB / Web Serial API** langsung dari peramban.

---

## 4. Spesifikasi Halaman Publik (Company Profile)

Navbar utama konsisten: `Home | About | Menu | Pesan | Contact`

- **Identitas Visual Resmi:** Menggunakan logo vector resmi [`public/images/logo/Logo Yans Food.svg`](file:///c:/SEKOLAH/12semester1/PROD%20(PA%20ANGGA)/Yans%20Food/yans-food/public/images/logo/Logo%20Yans%20Food.svg), icon squircle [`public/images/logo/Icon Yans Food.svg`](file:///c:/SEKOLAH/12semester1/PROD%20(PA%20ANGGA)/Yans%20Food/yans-food/public/images/logo/Icon%20Yans%20Food.svg), dan favicon browser [`public/images/logo/Favicon Yans Food.svg`](file:///c:/SEKOLAH/12semester1/PROD%20(PA%20ANGGA)/Yans%20Food/yans-food/public/images/logo/Favicon%20Yans%20Food.svg).
- **Fixed Persistent Navbar:** Melayang konsisten di posisi atas (`z-index: 50`) tanpa perubahan ukuran atau distorsi saat digulir.

### A. Home (`pages.home`)
- Hero section dinamis dengan ajakan aksi (*Call-to-Action*) cepat.
- Penjelasan filosofi dapur: *"Cita Rasa Rumahan Disajikan dengan Hati"*.
- Teaser 2 kanal pemesanan resmi (Delivery & Takeaway).
- Grid menu favorit pilihan pelanggan dengan foto asli 1:1.
- Footer 3 kolom modular dengan info operasional dan tautan navigasi.

### B. About (`pages.about`)
- Kisah berdirinya usaha kuliner rumahan Yan's Food di Soreang, Bandung.
- Nilai higienitas bahan baku, olahan segar tanpa bahan pengawet berbahaya.
- Timeline komitmen menjaga cita rasa autentik dan kepuasan pelanggan.

### C. Menu (`pages.menu`)
- Menampilkan 40 katalog menu resmi yang terbagi ke dalam 4 kategori:
  1. **Kudapan Renyah:** Dimsum Ayam, Dimsum Jamur, Dimsum Udang, Dimsum Mix, Cireng Rujak, Risol Mayo, Ketan Goreng, Kroket, dll.
  2. **Makanan Hangat:** Aneka olahan Nasi Telur, Nasi Sosis, Nasi Nugget, Nasi Chicken Katsu, Nasi Goreng Jadul/Mawut/Cikur.
  3. **Aneka Lauk:** Olahan lauk pauk siap santap.
  4. **Minuman Segar:** Nutrisari Dingin, Extra Joss Dingin, Teh Manis, Susu Milo, Susu Kental Manis, Es Kul-kul Piscok.
- **Dedicated Unique Photos:** Setiap produk memiliki foto unik tersendiri di [`public/images/Menu/`](file:///c:/SEKOLAH/12semester1/PROD%20(PA%20ANGGA)/Yans%20Food/yans-food/public/images/Menu/) (tidak ada foto yang dipakai bersama).
- **Direct WhatsApp Inquiry:** Modal detail produk menyertakan tombol WhatsApp dengan pesan prapopulasi mengecek ketersediaan menu.

### D. Pesan (`pages.pesan`)
- **Kanal 1 — Online Delivery:** Deep linking langsung ke aplikasi mobile (*native app*) mitra:
  - ShopeeFood Official Store
  - GoFood Official Store
  - GrabFood Official Store
- **Kanal 2 — Datang Langsung (Takeaway Only):**
  - Panduan 4 langkah pesan langsung di kasir dapur.
  - Penegasan: **Tidak Menyediakan Tempat Makan (No Dine-In / Hanya Bawa Pulang)**.
  - Jam Operasional Resmi: **08.00 – 22.00 WIB (Setiap Hari)**.
  - Peta Google Maps terintegrasi: `https://maps.app.goo.gl/KnCpj3ViPCHGNmH66`.

### E. Contact (`pages.contact`)
- Alamat fisik: Kp. Ciloa, Soreang, Kabupaten Bandung.
- WhatsApp Resmi: `+62 822-2122-2936`.
- Formulir negosiasi pesanan khusus/katering porsi besar yang langsung memformat teks dan membukanya ke WhatsApp Admin (tidak masuk ke basis data kasir).

---

## 5. Spesifikasi Panel Admin & Kasir POS (Back-Office)

Menggunakan layout terpadu [`resources/views/layouts/admin.blade.php`](file:///c:/SEKOLAH/12semester1/PROD%20(PA%20ANGGA)/Yans%20Food/yans-food/resources/views/layouts/admin.blade.php) dengan sidebar navigasi responsif:
- **MAIN:** Dashboard
- **TRANSACTION:** Kasir (POS), Riwayat Transaksi
- **CATALOG:** Produk, Resep Dapur
- **FINANCE:** Pengeluaran Operasional, Laporan Keuangan
- **SYSTEM:** Printer Kasir, Pengaturan Toko

### 1. Dashboard (`Admin\DashboardController`)
- **Metrik Utama Hari Ini:** Omset Kasir POS, Total Transaksi Kasir, Total Biaya Operasional Disetujui, dan Laba Bersih Sederhana (*Simple Net Profit*).
- **Grafik Tren Penjualan:** Visualisasi grafik omset vs pengeluaran.
- **Peringatan Inventaris:** Daftar produk dengan status stok menipis (`<= 5 pcs`) atau habis (`0 pcs`).

### 2. Kasir POS (`Admin\PosController`)
- **Pencarian Cepat & Filter Kategori:** Dilengkapi scrollbar horizontal halus (`.admin-filter-scroll`) yang nyaman di layar mobile.
- **Keranjang Belanja Real-Time:** Penambahan produk, pengaturan kuantitas, subtotal, dan diskon.
- **Metode Pembayaran:**
  - **Tunai (Cash):** Tombol pecahan nominal uang cepat (*quick cash chips: Rp 10.000, Rp 20.000, Rp 50.000, Rp 100.000, Uang Pas*) dan perhitungan uang kembalian otomatis.
  - **QRIS (Cashless):** Menampilkan QR Code toko yang diambil langsung dari pengaturan toko (`Setting`).
- **Penyimpanan Snapshot Transaksi:** Menyalin nama produk dan harga jual saat itu ke `transaction_items`.
- **Cetak Struk Fisik:** Cetak langsung struk kasir thermal ke RPP02N via Bluetooth atau USB.

### 3. Riwayat Transaksi (`Admin\TransactionController`)
- Riwayat seluruh transaksi kasir berurutan kronologis.
- Pengelompokan arsip transaksi otomatis per bulan.
- Filter tanggal/bulan dengan scrollbar horizontal mobile yang lega dan tidak terpotong.
- Modal rincian nota dan tombol cetak ulang struk kasir (*reprint*).

### 4. Manajemen Produk (`Admin\ProductController`)
- CRUD lengkap untuk 40 master produk makanan dan minuman.
- Pengaturan harga jual, stok kuantitas fisik, satuan (*porsi, pcs, cup*), dan status sedia/tidak tersedia.
- Upload dan ganti foto menu ke penyimpanan publik.
- Perlindungan integritas: Produk yang memiliki relasi transaksi kasir dicegah dari penghapusan keras (*prevent hard-delete*).

### 5. Resep & Inventaris Dapur (`Admin\RecipeController`)
- Penyusunan standar resep dapur (*Bill of Materials / BOM*) untuk setiap produk.
- Rincian bahan baku: nama bahan, takaran kuantitas, satuan (*gram, ml, butir, lembar*), dan catatan olahan.
- **Tampilan Responsif Mobile 2x2 Grid:** Katalog resep di layar smartphone ditampilkan dalam format 2 kolom (`grid-cols-2 lg:grid-cols-3`) agar ringkas, padat, dan mudah dibaca tanpa scrolling vertikal berlebihan.

### 6. Pengeluaran Operasional (`Admin\ExpenseController`)
- Pencatatan biaya operasional harian dapur.
- Kategori pengeluaran: Bahan Baku, Gas Dapur, Listrik, Air, Kemasan/Packaging, Transportasi, Peralatan Dapur, Pemeliharaan, dan Lain-lain.
- Filter waktu lengkap (hari ini, minggu ini, bulan ini, tahun ini, rentang kustom) dengan filter bar horizontal ramah mobile.
- Status persetujuan pengeluaran (*Approved / Pending*) untuk integrasi akurasi laba bersih.

### 7. Laporan Keuangan & Finansial (`Admin\ReportController`)
- **Agregasi Finansial:** Total Pendapatan POS Kasir, Total Biaya Operasional, dan Laba Bersih Sederhana.
- **Rincian Arus Kas Harian:** Tabel kronologis pemasukan vs pengeluaran.
- **Analisis Produk Terlaris:** Peringkat menu berdasarkan kuantitas terjual dan kontribusi omset.
- **Ekspor CSV:** Fitur unduh laporan penjualan dan rekap produk ke file CSV sesuai filter periode yang dipilih.
- Filter bar responsive mobile dengan spacing padding yang rapi.

### 8. Integrasi Printer Thermal Kasir (`Admin\PrinterController`)
- Khusus disiapkan untuk perangkat fisik kasir **RPP02N (Model: DT-58B, 58mm, 5V-1A)**.
- Menghapus sistem CRUD printer lama dan dialog popup print browser.
- Tombol **Uji Cetak Bluetooth (Web Bluetooth API)** dan **Uji Cetak USB (WebUSB / Web Serial API)** langsung dari antarmuka kasir.

### 9. Pengaturan Toko (`Admin\SettingController`)
- Konfigurasi profil usaha: Nama Toko, Nomor WhatsApp, Alamat Gerai, dan Catatan Kaki Struk Kasir.
- Pengaturan tautan platform online delivery: ShopeeFood, GoFood, GrabFood.
- Unggah dan perbarui gambar QRIS resmi kasir.

---

## 6. Penerapan Konsep RDBMS & Konsistensi Data (MySQL 8.x)

Sistem mengimplementasikan 5 komponen standar industri dan akademis basis data relasional:

### 1. Database Trigger (`trg_after_transaction_item_insert`)
```sql
CREATE TRIGGER trg_after_transaction_item_insert
AFTER INSERT ON transaction_items
FOR EACH ROW
BEGIN
    UPDATE products
    SET stock = GREATEST(0, stock - NEW.quantity),
        updated_at = NOW()
    WHERE id = NEW.product_id;
END;
```
*Tujuan:* Menjamin sinkronisasi stok fisik produk seketika saat item transaksi kasir tercatat.

### 2. Stored Function (`fn_calculate_simple_profit`)
```sql
CREATE FUNCTION fn_calculate_simple_profit(p_start_date DATE, p_end_date DATE)
RETURNS DECIMAL(15,2)
DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE v_revenue DECIMAL(15,2) DEFAULT 0.00;
    DECLARE v_expense DECIMAL(15,2) DEFAULT 0.00;

    SELECT COALESCE(SUM(total), 0.00) INTO v_revenue
    FROM transactions
    WHERE status = 'completed'
      AND transaction_date BETWEEN p_start_date AND p_end_date;

    SELECT COALESCE(SUM(amount), 0.00) INTO v_expense
    FROM expenses
    WHERE status = 'approved'
      AND expense_date BETWEEN p_start_date AND p_end_date;

    RETURN (v_revenue - v_expense);
END;
```
*Tujuan:* Komputasi laba bersih langsung di memori database engine untuk kecepatan eksekusi query analitik laporan.

### 3. Stored Procedure (`sp_get_daily_sales_summary`)
```sql
CREATE PROCEDURE sp_get_daily_sales_summary(
    IN p_date DATE,
    OUT p_total_revenue DECIMAL(15,2),
    OUT p_total_transactions INT
)
BEGIN
    SELECT 
        COALESCE(SUM(total), 0.00),
        COUNT(id)
    INTO 
        p_total_revenue,
        p_total_transactions
    FROM transactions
    WHERE status = 'completed'
      AND transaction_date = p_date;
END;
```
*Tujuan:* Menyediakan rekapitulasi penjualan harian kasir melalui parameter output prosedur secara efisien.

### 4. Database Transaction: Commit (`DB::commit()`)
Diterapkan pada [`TransactionService.php`](file:///c:/SEKOLAH/12semester1/PROD%20(PA%20ANGGA)/Yans%20Food/yans-food/app/Services/TransactionService.php) dan [`RecipeController.php`](file:///c:/SEKOLAH/12semester1/PROD%20(PA%20ANGGA)/Yans%20Food/yans-food/app/Http/Controllers/Admin/RecipeController.php). Seluruh modifikasi data (pembuatan nota transaksi, penyimpanan detail item, pemotongan stok) hanya disimpan permanen setelah seluruh tahapan berhasil 100%.

### 5. Database Transaction: Rollback (`DB::rollBack()`)
Diterapkan pada blok penanganan error (`try-catch`). Jika terjadi kegagalan (misalnya stok tidak mencukupi atau kegagalan query), sistem membatalkan seluruh perubahan basis data dan mengembalikannya ke kondisi awal (*atomicity*).

---

## 7. Skema Basis Data Relasional Utama

```text
┌────────────────────┐          ┌───────────────────────┐
│     products       │ 1      N │        recipes        │
├────────────────────┤──────────├───────────────────────┤
│ id (PK)            │          │ id (PK)               │
│ category_id (FK)   │          │ product_id (FK)       │
│ name               │          │ name, description     │
│ price, stock, unit │          └───────────┬───────────┘
│ image, status      │                      │ 1
└─────────┬──────────┘                      │ N
          │ 1                   ┌───────────▼───────────┐
          │ N                   │  recipe_ingredients   │
┌─────────▼──────────┐          ├───────────────────────┤
│ transaction_items  │          │ id (PK)               │
├────────────────────┤          │ recipe_id (FK)        │
│ id (PK)            │          │ ingredient_name       │
│ transaction_id (FK)│          │ quantity, unit        │
│ product_id (FK)    │          └───────────────────────┘
│ product_name       │
│ quantity, unit_price
│ subtotal           │          ┌───────────────────────┐
└─────────▲──────────┘          │       expenses        │
          │ N                   ├───────────────────────┤
          │ 1                   │ id (PK)               │
┌─────────┴──────────┐          │ category_id (FK)      │
│    transactions    │          │ name, amount, date    │
├────────────────────┤          │ status, payment_method│
│ id (PK)            │          └───────────────────────┘
│ transaction_number │
│ total, amount_paid │          ┌───────────────────────┐
│ change, payment_mth│          │       settings        │
│ status             │          ├───────────────────────┤
└────────────────────┘          │ id, key, value        │
                                └───────────────────────┘
```

---

## 8. Panduan Siap Deployment & Kebersihan Repositori

1. **Berkas Sampah & Data Awal:**
   - Berkas `yans_food_data_produk.csv` adalah berkas referensi awal yang datanya telah disemai (*seeded*) permanen ke dalam database. Berkas ini aman untuk dihapus tanpa memengaruhi berjalannya sistem.
   - Script lokal Windows seperti `powershell.bat` dan `powershell.cmd` telah terlindungi di dalam `.gitignore` sehingga tidak akan terunggah ke hosting atau repositori produksi.
2. **Kompilasi Aset Frontend:**
   - Jalankan `npm run build` sebelum mendeploy ke hosting agar direktori `public/build` terisi aset teroptimasi (*minified CSS & JS*).
3. **Konfigurasi Lingkungan Produksi:**
   - Atur `APP_ENV=production` dan `APP_DEBUG=false` pada berkas `.env` server.
   - Jalankan optimasi cache: `php artisan config:cache`, `php artisan route:cache`, `php artisan view:cache`.

---

© 2026 **Yan's Food** — *Dokumentasi Spesifikasi Teknis Resmi Sistem Web & POS Terpadu.*
