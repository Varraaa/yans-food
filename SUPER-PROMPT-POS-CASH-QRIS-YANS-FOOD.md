# SUPER PROMPT — POS: Metode Pembayaran Cash & QRIS, Pencatatan, Struk, dan Laporan
**Proyek:** Yan's Food — Admin Web (Laravel 13, Blade + Tailwind CSS v4 + komponen Flowbite, MySQL)
**Untuk:** Antigravity (agent coding)
**Cakupan:** Admin → POS (Transaksi), Struk, Riwayat Transaksi, Laporan, Pengaturan QRIS. Website publik **tidak** disentuh.

---

## 0. PERAN & CARA KERJA

Kamu adalah senior Laravel engineer. Kerjakan fitur di bawah ini **di dalam repository yang sudah ada**, mengikuti konvensi yang sudah dipakai di dalamnya. Kamu **belum melihat** kode admin saya, jadi **Langkah 0 (investigasi) wajib dikerjakan lebih dulu**. Jangan menebak nama class, tabel, atau route. Temukan dulu, lalu sesuaikan instruksi ini dengan kenyataan di kode.

Bila instruksi ini bertentangan dengan kode yang ada, **pertahankan perilaku yang sudah benar**, sesuaikan implementasi, dan catat penyesuaiannya di laporan akhir.

Kerjakan bertahap sesuai fase di §14. Buat satu git commit per fase dengan pesan yang jelas.

---

## 1. KONTEKS PROYEK (prinsip yang sudah berlaku dan WAJIB dipertahankan)

1. **Server adalah sumber kebenaran transaksi.** Subtotal, total, kembalian selalu dihitung ulang di server dari harga di database. Angka dari browser hanya tampilan.
2. **Snapshot historis.** `transaction_items` menyimpan `product_name` dan `unit_price` saat transaksi. Jangan diubah ke join langsung.
3. **Tanpa hard delete** pada data transaksi/produk. Transaksi dibatalkan lewat `status`, bukan dihapus.
4. **Integritas atomik.** Pembuatan transaksi + item + pemotongan stok harus satu DB transaction (atau stored procedure `sp_process_pos_sale` bila sudah dipakai). Rollback penuh bila gagal.
5. **Service layer.** Logika bisnis di Service class, Controller tipis, validasi di FormRequest.
6. **Admin memakai Blade + Tailwind + komponen Flowbite**, tanpa Filament. Pola layout, sidebar, tabel, modal, badge yang sudah ada **dipakai ulang**.
7. Data skema relevan (dari dokumen pemodelan): `transactions` (`transaction_number` unique, `transaction_date`, `transaction_time`, `cashier_id`, `subtotal`, `discount`, `total`, `payment_method` enum saat ini hanya `CASH`, `amount_paid`, `change`, `status` completed/cancelled), `transaction_items`, `printers` (`paper_width` 58mm/80mm), `users.role` admin/cashier.

---

## 2. TUJUAN

### 2.1 Yang harus tercapai
1. Metode pembayaran di POS **hanya dua**: **CASH** dan **QRIS**.
2. Pembayaran Cash dan QRIS **tercatat terpisah** per transaksi, dan Laporan menampilkan **tiga catatan**:
   - **Catatan 1: Pembayaran Cash** (jumlah transaksi + total rupiah)
   - **Catatan 2: Pembayaran QRIS** (jumlah transaksi + total rupiah)
   - **Catatan 3: Total Gabungan** = Cash + QRIS, dipakai sebagai **dasar perhitungan laba bersih**
3. Alur pembayaran **QRIS** persis seperti ini:
   1. Admin memasukkan produk yang dipesan pelanggan ke keranjang.
   2. Admin memilih metode **QRIS** (total yang harus dibayar sudah tampil).
   3. Admin menekan tombol **Bayar QRIS**.
   4. Admin diarahkan ke halaman yang menampilkan **gambar QR code QRIS Yan's Food**, untuk ditunjukkan ke pelanggan.
   5. Di bagian bawah halaman itu ada tombol **Next**.
   6. Klik **Next** → diarahkan ke halaman **struk pembayaran** yang punya tombol **Cetak Thermal** dan **Selesai Transaksi**.
4. Alur **Cash** tetap seperti sekarang (input uang diterima, hitung kembalian), dengan tambahan pencatatan metode dan tampilan di struk/laporan.

### 2.2 Di luar cakupan (JANGAN dikerjakan)
- Integrasi payment gateway (Midtrans, Xendit, dll.), QRIS dinamis, atau verifikasi otomatis pembayaran masuk.
- Pembayaran campuran (sebagian cash, sebagian QRIS) dalam satu transaksi.
- Perubahan pada website publik, modul Pengeluaran, dan Resep.
- ESC/POS langsung atau agent printer baru (lihat §9.4).
- Penghapusan modul/tabel katering yang mungkin masih ada di repo (lihat §2.3). Itu pekerjaan terpisah.

### 2.3 Sistem katering TIDAK dipakai lagi
Yan's Food **tidak jadi memakai sistem katering**. Akibatnya untuk tugas ini:
- **Tidak ada pilihan/opsi katering** di POS, struk, Riwayat Transaksi, maupun Laporan. Satu-satunya sumber pendapatan yang dicatat adalah **penjualan POS** (Cash dan QRIS).
- **Laba bersih = Total Gabungan POS (Cash + QRIS) − Pengeluaran.** Komponen katering (Penghasilan Catering, pembayaran katering, filter laporan katering) **tidak boleh ikut** dihitung atau ditampilkan di Laporan.
- Bila di repo masih ada kode, tabel, menu sidebar, atau halaman katering, **jangan dihapus dalam tugas ini**. Cukup pastikan semuanya **tidak memengaruhi** POS dan Laporan, lalu **laporkan** daftar sisa komponen katering di laporan akhir agar bisa dibersihkan lewat tugas terpisah.

---

## 3. KEPUTUSAN DESAIN (sudah diputuskan, ikuti)

| # | Keputusan | Alasan |
|---|---|---|
| D1 | **QRIS memakai gambar QR statis** yang diunggah admin di Pengaturan (bukan hardcode di kode/Blade). | QRIS toko biasanya statis. Pelanggan memasukkan nominal sendiri, jadi halaman QR wajib menampilkan **total besar dan jelas**. |
| D2 | **Transaksi QRIS baru dibuat saat tombol Next ditekan**, bukan saat Bayar QRIS. Antara dua langkah itu data keranjang disimpan di **sesi checkout sementara** di server (cache/session, TTL 15 menit, terikat ke user). | Halaman QR yang ditinggalkan atau dibatalkan tidak boleh meninggalkan transaksi "menggantung" atau memotong stok. Tidak perlu status `pending` baru. |
| D3 | Tombol **Next = konfirmasi bahwa admin sudah melihat pembayaran masuk**. Sistem **tidak** memverifikasi otomatis. | QRIS statis tidak punya callback. Ini keterbatasan yang harus dinyatakan di UI (teks bantu kecil di halaman QR). |
| D4 | **Tiga catatan laporan diturunkan dari `transactions`** (agregasi query), **bukan tabel baru**. | Satu transaksi = satu metode, jadi kolom `payment_method` sudah cukup. Agregasi query selalu konsisten dan tidak bisa selisih dengan data transaksi. |
| D5 | Konfirmasi QRIS bersifat **idempoten**: token yang sudah dipakai tidak membuat transaksi kedua. | Cegah dobel transaksi karena klik ganda, refresh, atau tombol Back browser. |

---

## 4. LANGKAH 0 — INVESTIGASI WAJIB (sebelum menulis kode)

Cari dan baca, lalu rangkum temuan singkat di awal laporanmu:

1. Controller/Service/route **POS** dan cara keranjang disimpan (state Alpine? localStorage? session?).
2. Migration `transactions` dan **tipe kolom `payment_method` sebenarnya** (enum atau string). Apakah masih berisi hanya `CASH`.
3. Apakah ada **stored procedure** (`sp_process_pos_sale`), **trigger** (`trg_reduce_product_stock_pos`, `trg_restore_stock_on_cancel`), atau **function** (`fn_calculate_net_profit`) di migration/SQL. Bila ada: apakah mereka menyebut `payment_method` atau memfilter `'CASH'`.
4. Halaman/Service **Laporan**: rumus laba bersih saat ini, filter tanggal, dan export CSV. **Catat apakah rumus/halaman/export sekarang memuat komponen katering** (Penghasilan Catering, pembayaran katering, filter laporan katering). Itu harus dikeluarkan (lihat §2.3 dan §12.2). Cari juga sisa referensi katering di POS, sidebar, dashboard, dan `fn_calculate_net_profit`.
5. Halaman **Riwayat Transaksi** dan **Struk/cetak** yang sudah ada (apakah sudah ada cetak thermal, CSS print, atau pemakaian tabel `printers`).
6. Modul **Pengaturan** (`SettingController`) dan apakah ada tabel `settings`.
7. **API mobile** (`app/Http/Controllers/Api/*`) yang memakai `payment_method` atau memanggil proses POS yang sama. Perubahan **harus kompatibel mundur**: default tetap `CASH` bila tidak dikirim.
8. Framework test yang dipakai (Pest atau PHPUnit) dan factory yang tersedia.
9. Konvensi CSS: semua CSS khusus ditaruh di `resources/css/app.css` (atau file yang di-`@import` ke sana). **Blade hanya berisi class Tailwind/Flowbite dan class semantik dari CSS.** Tanpa blok `<style>` dan tanpa JS inline panjang di Blade. JS ditaruh di `resources/js/modules/*`.

Hasil investigasi menentukan bagaimana §5 dan seterusnya diterapkan.

---

## 5. DATABASE & MODEL

> Semua perubahan skema lewat **migration baru**. Jangan mengedit migration lama.

### 5.1 Migration: `transactions`
- Ubah `payment_method` menjadi **enum (`CASH`,`QRIS`)**, `NOT NULL`, default `CASH`. Data lama (semua `CASH`) tetap valid. Gunakan cara yang didukung versi Laravel/DB repo ini (`->change()` atau `DB::statement`). Pastikan `down()` bisa dijalankan.
- Tambah `paid_at` (nullable timestamp). Diisi saat transaksi selesai dibayar (Cash: saat bayar; QRIS: saat Next ditekan). Untuk data lama boleh diisi dari `transaction_date` + `transaction_time`.
- Tambah **index** `idx_transactions_report` pada (`status`, `transaction_date`, `payment_method`) untuk mempercepat laporan.
- Aturan data: untuk QRIS `amount_paid = total` dan `change = 0`.

### 5.2 Bila ada stored procedure `sp_process_pos_sale`
Perbarui lewat migration baru (DROP + CREATE) agar menerima parameter metode pembayaran. Pertahankan logika transaksi atomik, cek stok, dan potong stok. Bila prosedur memfilter `'CASH'` di mana pun, perbaiki.

### 5.3 Bila ada `fn_calculate_net_profit`
Pastikan fungsi **menjumlahkan semua transaksi `completed` tanpa memfilter metode** (Cash + QRIS). Bila memfilter `CASH`, perbaiki lewat migration.
Karena katering tidak dipakai lagi, fungsi ini harus menghitung **hanya** `SUM(total)` transaksi POS `completed` **dikurangi** pengeluaran pada rentang tanggal. Bila saat ini fungsi menambahkan pendapatan/pembayaran katering, **keluarkan komponen itu** lewat migration baru (DROP + CREATE). Jangan menghapus tabel katering.

### 5.4 Pengaturan QRIS
- Bila tabel `settings` sudah ada, pakai. Bila belum, buat tabel key-value (`key` unique, `value` text, timestamps) dan model/Service kecil untuk membacanya (dengan cache singkat).
- Key: `qris_image_path` (path file di storage publik), `qris_merchant_name` (opsional, default "Yan's Food").

### 5.5 Model / Enum
- Buat `App\Enums\PaymentMethod` (backed enum: `CASH`, `QRIS`) dengan method `label()` ("Cash", "QRIS") dan `badgeClass()` bila perlu. Cast `payment_method` di model `Transaction`.
- Tambah scope di `Transaction`: `completed()`, `paidWith(PaymentMethod $m)`, `betweenDates($from, $to)`.

---

## 6. BACKEND

### 6.1 Rute (nama final boleh disesuaikan dengan penamaan repo)

| Method | URI | Nama | Fungsi |
|---|---|---|---|
| GET | `/admin/pos` | `pos.index` | Halaman POS |
| POST | `/admin/pos/pay-cash` | `pos.pay-cash` | Buat transaksi Cash → redirect ke struk |
| POST | `/admin/pos/qris/prepare` | `pos.qris.prepare` | Validasi keranjang, hitung total di server, buat sesi checkout → redirect ke halaman QR |
| GET | `/admin/pos/qris/{token}` | `pos.qris.show` | Halaman QR |
| POST | `/admin/pos/qris/{token}/confirm` | `pos.qris.confirm` | Buat transaksi QRIS (tombol **Next**) → redirect ke struk |
| POST | `/admin/pos/qris/{token}/cancel` | `pos.qris.cancel` | Buang sesi checkout, kembali ke POS dengan keranjang utuh |
| GET | `/admin/transactions/{transaction}/receipt` | `transactions.receipt` | Halaman struk |

Semua rute di dalam grup `auth` yang sudah ada. Peran **admin dan cashier** boleh memakai POS. Upload gambar QRIS hanya **admin**.

### 6.2 Service
Buat/ubah satu **`PosCheckoutService`** (atau pakai service POS yang sudah ada, jangan duplikasi):

- `buildCart(array $items): CartResult`: memuat produk dari DB, menolak produk tidak ada/`unavailable`, memeriksa stok, menghitung subtotal/diskon/total **di server**.
- `payCash(array $items, int $amountPaid, User $cashier): Transaction`: validasi `amountPaid >= total`, hitung `change`, buat transaksi (§6.4).
- `prepareQris(array $items, User $cashier): string $token`: panggil `buildCart`, simpan di cache `pos:qris:{uuid}` berisi: items (product_id + qty), total yang ditampilkan, `user_id`, `created_at`. TTL 15 menit. Kembalikan token.
- `confirmQris(string $token, User $cashier): Transaction`:
  1. Ambil sesi; bila tidak ada → `SessionExpired`.
  2. Bila sesi sudah punya `transaction_id` → **kembalikan transaksi itu** (idempoten, tidak membuat baru).
  3. Pastikan `user_id` sesi = user yang login.
  4. **Hitung ulang** keranjang dari DB. Bila total sekarang ≠ total yang ditampilkan di halaman QR (harga berubah) → lempar exception khusus; UI menampilkan "Harga berubah, total baru Rp X" dan mengembalikan admin ke POS untuk membuka QR ulang.
  5. Buat transaksi (§6.4) dengan `payment_method=QRIS`, `amount_paid=total`, `change=0`.
  6. Simpan `transaction_id` ke sesi (tandai terpakai).
- `cancelQris(string $token)`: hapus sesi.

### 6.3 FormRequest & validasi
- `PayCashRequest`: `items` array minimal 1, tiap item `product_id` exists, `quantity` integer ≥ 1; `amount_paid` integer ≥ 0.
- `PrepareQrisRequest`: `items` sama seperti di atas. **Tidak menerima total dari klien.** Bila ada kolom total di payload, abaikan.
- Metode pembayaran tidak boleh dipilih bebas dari klien untuk endpoint yang salah (endpoint cash selalu CASH, endpoint QRIS selalu QRIS).

### 6.4 Pembuatan transaksi (satu tempat saja)
Satu method privat yang dipakai Cash dan QRIS, di dalam `DB::transaction` (atau memanggil stored procedure bila ada):
1. Buat nomor transaksi dengan generator yang sudah ada.
2. Simpan `transactions` (cashier_id = user login, tanggal/jam sekarang, `paid_at = now()`).
3. Simpan `transaction_items` dengan **snapshot** nama dan harga.
4. Potong stok sesuai mekanisme yang sudah ada (trigger atau kode). **Jangan memotong dua kali.**
5. Cek stok dengan **row lock** (`lockForUpdate`) agar dua kasir tidak menjual stok terakhir bersamaan.
6. Gagal di langkah mana pun → rollback penuh; tampilkan pesan yang jelas ("Stok {produk} tidak cukup").

### 6.5 Keamanan
- CSRF di semua POST. Token checkout memakai UUID acak dan dicek kepemilikan user.
- Rate limit ringan (`throttle:30,1`) pada `prepare` dan `confirm`.
- Upload gambar QRIS: hanya `png,jpg,jpeg,webp`, maks 2 MB, verifikasi MIME sebenarnya, simpan dengan nama acak di `storage/app/public/qris`, pastikan `storage:link` ada. Hapus file lama saat diganti.
- Tidak ada angka uang dari klien yang dipercaya.

---

## 7. FRONTEND POS (Blade + Tailwind + Flowbite)

Pertahankan layout POS yang sudah ada (daftar produk + keranjang). Ubah **bagian pembayaran** menjadi seperti ini.

### 7.1 Pemilih metode pembayaran
- Dua pilihan berdampingan (segmented card atau radio card Flowbite): **Cash** dan **QRIS**, masing-masing dengan ikon dan label. Hanya satu aktif. Default **Cash**.
- Pilihan metode **tidak mengosongkan** keranjang. Saat berpindah metode, nilai input metode lain direset.
- Total **Rp** selalu terlihat besar di atas area pembayaran, apa pun metodenya.

### 7.2 Saat metode = Cash
- Input **Uang Diterima** (format rupiah, `inputmode="numeric"`).
- Tombol cepat: **Uang Pas**, 50.000, 100.000 (nilai tombol boleh disesuaikan dengan kebiasaan di UI yang sudah ada).
- **Kembalian** tampil real-time (hanya tampilan; server hitung ulang).
- Tombol **Bayar Cash** nonaktif sampai uang diterima ≥ total dan keranjang tidak kosong. Setelah diklik: tombol loading + dikunci (cegah klik ganda).

### 7.3 Saat metode = QRIS
- **Tidak ada** input uang diterima atau kembalian.
- Tampil ringkasan: "Total yang harus dibayar pelanggan: **Rp X**".
- Tombol **Bayar QRIS** (primary). Nonaktif bila keranjang kosong **atau** gambar QRIS belum diunggah. Bila gambar belum ada, tampil pesan inline + tautan "Unggah QRIS di Pengaturan" (hanya untuk admin; untuk cashier tampil "Hubungi admin untuk mengunggah QRIS").
- Klik → `POST pos.qris.prepare` → redirect ke halaman QR (§8). Tombol loading + dikunci.

### 7.4 Responsif (admin harus nyaman di tablet dan HP)
- Desktop/tablet: dua kolom (produk | keranjang+pembayaran).
- Mobile: keranjang + pembayaran jadi bottom sheet atau section di bawah daftar produk, dengan bar total yang menempel di bawah layar. Semua target sentuh ≥ 44px.

### 7.5 Keranjang tidak boleh hilang
- Bila admin menekan **Kembali** dari halaman QR, keranjang harus **pulih utuh** (dari sesi checkout di server atau localStorage, ikuti cara keranjang saat ini disimpan).
- Keranjang **dikosongkan** setelah transaksi tersimpan (Cash sukses, atau QRIS konfirmasi sukses) dan tidak muncul lagi saat admin kembali ke POS dari struk.

---

## 8. HALAMAN QR QRIS (`pos.qris.show`)

Halaman fokus (satu tujuan), boleh memakai layout admin tanpa sidebar atau dengan sidebar yang diringkas. Layar ini **ditunjukkan ke pelanggan**, jadi harus bersih dan terbaca dari jarak.

**Isi (atas ke bawah):**
1. Judul: "Pembayaran QRIS" + nama toko.
2. **Total yang harus dibayar** dalam angka besar (`tabular-nums`). Teks bantu: "Masukkan nominal sesuai total di atas saat membayar."
3. **Gambar QR code QRIS Yan's Food**, persegi, `object-contain`, latar putih dengan padding, ukuran responsif (maks ±360px di desktop, ±80% lebar layar di HP), kontras tinggi. Jangan di-blur, di-rotate, atau diberi efek.
4. Teks kecil untuk admin: "Pastikan pembayaran sudah masuk di aplikasi bank/e-wallet toko sebelum menekan Next."
5. **Bagian bawah:** tombol **Next** (primary, lebar penuh di HP, menempel di bawah layar pada mobile) dan tombol sekunder **Kembali ke Keranjang**.

**Perilaku:**
- **Next** → `POST pos.qris.confirm`. Saat diklik: loading + dikunci. Sukses → redirect ke struk. Error stok/harga → kembali ke POS dengan pesan jelas, keranjang utuh.
- **Kembali ke Keranjang** → `POST pos.qris.cancel` lalu redirect ke POS dengan keranjang pulih.
- Token kedaluwarsa/tidak valid → redirect ke POS dengan pesan "Sesi pembayaran kedaluwarsa, silakan ulangi."
- Token sudah dipakai (karena Back browser) → redirect ke struk transaksi yang sudah dibuat. **Tidak** membuat transaksi baru.
- Bila gambar QRIS hilang dari storage → tampil state kosong yang jelas, tombol Next dinonaktifkan.

---

## 9. HALAMAN STRUK (`transactions.receipt`)

### 9.1 Tampilan
Preview struk dalam wadah selebar kertas thermal (lebar mengikuti `paper_width` printer aktif; default 58mm bila belum ada setting), di tengah halaman. Di sekitarnya (di luar area cetak) ada aksi.

**Isi struk:** nama usaha, alamat/telepon (ambil dari pengaturan bila ada), nomor transaksi, tanggal & jam, nama kasir, daftar item (nama, qty × harga, subtotal), subtotal, diskon (bila ada), **TOTAL**, lalu blok pembayaran:
- **Cash:** `Metode: CASH`, `Tunai: Rp …`, `Kembali: Rp …`
- **QRIS:** `Metode: QRIS`, `Dibayar: Rp total` (tanpa baris tunai/kembali)
- Footer ucapan terima kasih.

### 9.2 Tombol
- **Cetak Thermal**
- **Selesai Transaksi**: kembali ke POS dengan keranjang kosong dan toast "Transaksi selesai".

Urutan alur dari POS: setelah Cash sukses atau Next QRIS sukses, admin selalu mendarat di halaman ini (pola Post-Redirect-Get: refresh tidak membuat transaksi baru).

### 9.3 Akses ulang
Struk juga bisa dibuka dari **Riwayat Transaksi** (tombol "Struk"/"Cetak ulang"). Cetak ulang tidak mengubah data apa pun.

### 9.4 Cetak thermal
- **Bila repo sudah punya mekanisme cetak thermal**, pakai dan hubungkan ke tombol ini.
- **Bila belum**, implementasikan cetak via browser (`window.print()`) dengan CSS print yang hanya mencetak area struk, tanpa margin, lebar 58mm atau 80mm sesuai `paper_width`. Pakai `@page` bernama (`receipt58`, `receipt80`) dan properti `page` pada kelas struk. CSS ini ditaruh di `resources/css/app.css` (bagian `@media print`), **bukan** di Blade.
- Jangan membangun ESC/POS langsung atau agent lokal. Catat sebagai saran lanjutan di laporan bila relevan.

---

## 10. PENGATURAN QRIS (Admin saja)

Di halaman Pengaturan (`SettingController`), tambah kartu **"QRIS Pembayaran"**:
- Pratinjau gambar QRIS saat ini (atau state kosong).
- Input unggah (drag-and-drop Flowbite atau input file), validasi §6.5, tombol **Simpan**, tombol **Ganti**.
- Opsional: input nama merchant yang tampil di halaman QR.
- Pesan sukses/error jelas. Setelah ganti, file lama dihapus.
- Peringatan kecil: "Gunakan QRIS statis resmi toko Anda. Pastikan nama merchant sesuai."

---

## 11. RIWAYAT TRANSAKSI

- Tambah kolom **Metode** dengan badge (Cash dan QRIS berbeda jelas, ikuti sistem badge/warna yang sudah ada, tidak memakai merah alarm).
- Tambah **filter Metode** (Semua / Cash / QRIS) dan gabungkan dengan filter tanggal yang sudah ada.
- Halaman detail/struk menampilkan metode sesuai §9.
- Transaksi yang dibatalkan tetap tampil dengan metode aslinya, tetapi **dikecualikan dari semua agregasi laporan**.

---

## 12. LAPORAN (inti permintaan: 3 catatan)

Lokasi: halaman Laporan yang sudah ada. Semua angka mengikuti **filter tanggal** yang sudah ada (preset hari ini / 7 hari / bulan ini / rentang kustom bila sudah tersedia).

### 12.1 Tiga kartu ringkasan (di bagian atas)
| Kartu | Isi |
|---|---|
| **Pembayaran Cash** | Total rupiah Cash + jumlah transaksi Cash + persentase dari total gabungan |
| **Pembayaran QRIS** | Total rupiah QRIS + jumlah transaksi QRIS + persentase dari total gabungan |
| **Total Gabungan** | Cash + QRIS (rupiah) + total jumlah transaksi |

Di bawah kartu: **bar proporsi** sederhana (dua segmen Cash vs QRIS) memakai div Tailwind, tanpa library chart baru.

### 12.2 Laba bersih
- **Total Gabungan** (Catatan 3) adalah **dasar pendapatan penjualan POS** untuk laba bersih.
- Rumus laba bersih **final**: `Laba Bersih = Total Gabungan (Cash + QRIS, status completed) − Total Pengeluaran` pada rentang tanggal yang dipilih.
- **Tidak ada komponen katering** di rumus, kartu, tabel, filter, maupun export (§2.3). Bila rumus/halaman Laporan yang ada sekarang memuat Penghasilan Catering, **keluarkan** dari perhitungan dan tampilan, dan catat perubahan itu di laporan akhir.
- Tampilkan rincian rumus secara eksplisit di UI: `Pendapatan POS (Cash + QRIS) − Pengeluaran = Laba Bersih`.
- Verifikasi: angka laba bersih di Laporan harus **sama** dengan hasil `fn_calculate_net_profit` (bila fungsi itu dipakai) untuk rentang tanggal yang sama.

### 12.3 Tabel rincian per hari
Kolom: Tanggal · Trx Cash · Total Cash · Trx QRIS · Total QRIS · **Total Gabungan**. Baris **TOTAL** di bawah tabel harus sama persis dengan tiga kartu di atas.

### 12.4 Query (satu query agregasi, bukan N+1)
Hanya transaksi `status = 'completed'` dalam rentang tanggal. Contoh pendekatan:

```php
Transaction::query()
    ->completed()
    ->betweenDates($from, $to)
    ->selectRaw("
        transaction_date,
        SUM(payment_method = 'CASH')                               AS cash_count,
        COALESCE(SUM(CASE WHEN payment_method = 'CASH' THEN total END), 0) AS cash_total,
        SUM(payment_method = 'QRIS')                               AS qris_count,
        COALESCE(SUM(CASE WHEN payment_method = 'QRIS' THEN total END), 0) AS qris_total,
        COALESCE(SUM(total), 0)                                    AS combined_total
    ")
    ->groupBy('transaction_date')
    ->orderBy('transaction_date')
    ->get();
```
Letakkan di `ReportService` (method khusus laporan pembayaran), bukan di Blade/Controller. Hitung total keseluruhan dari hasil yang sama (atau satu query tanpa `groupBy`) agar konsisten.

### 12.5 Export CSV
Perbarui export CSV yang sudah ada:
- Tambahkan kolom **Metode Pembayaran** pada data transaksi.
- Tambahkan bagian ringkasan: total Cash, total QRIS, **total gabungan**, dan laba bersih.
- UTF-8 dengan BOM agar terbuka rapi di Excel. Format angka tanpa pemisah ribuan di CSV (angka mentah).

### 12.6 Dashboard
Hanya ubah dashboard **bila** ia membaca `payment_method` atau akan error karena perubahan enum. Bila tidak, jangan disentuh. (Memecah "Penjualan hari ini" menjadi Cash/QRIS adalah usulan lanjutan, bukan bagian tugas ini.)

---

## 13. ATURAN TEKNIS UMUM

1. **CSS:** semua CSS khusus (print struk, animasi kecil, state) di `resources/css/app.css`. Blade hanya class Tailwind/Flowbite dan class semantik. Tanpa `<style>`, tanpa atribut `style=""` (kecuali nilai dinamis lewat CSS variable).
2. **JS:** logika interaksi POS (pilih metode, hitung kembalian tampilan, kunci tombol saat submit) di `resources/js/modules/`. Tanpa library baru kecuali Flowbite yang sudah ada.
3. **Tailwind v4:** pakai sintaks yang sudah dipakai repo. Jangan mencampur gaya v3.
4. **Format uang:** semua tampilan `Rp 12.500` (titik ribuan, tanpa desimal), angka memakai `tabular-nums`.
5. **Bahasa UI:** Indonesia, singkat, kata kerja jelas. Pesan error menjelaskan cara memperbaiki.
6. **Aksesibilitas:** label pada input, fokus terlihat, `aria-busy` saat loading, `aria-live` untuk kembalian/total, kontras cukup. Tidak mengandalkan warna saja untuk membedakan Cash dan QRIS (ikon + teks).
7. **Desain:** ikuti pola admin yang sudah ada. Hindari tampilan template generik (gradient mencolok, bayangan berlebihan, ikon emoji). Prioritaskan keterbacaan di kasir: angka besar, kontras tinggi, tombol besar.
8. **Kompatibilitas:** API mobile dan data lama tetap berfungsi (default `CASH`). 

---

## 14. FASE KERJA

| Fase | Isi | Berhenti dan laporkan bila |
|---|---|---|
| **0** | Investigasi §4, ringkasan temuan | Ada hal yang bertentangan dengan asumsi di dokumen ini |
| **1** | Migration + Enum + model + settings (§5) | Migration gagal/rollback bermasalah |
| **2** | Service + FormRequest + rute + test backend (§6) | — |
| **3** | UI POS: pemilih metode, alur Cash, tombol Bayar QRIS (§7) | — |
| **4** | Halaman QR + Pengaturan QRIS (§8, §10) | — |
| **5** | Struk + cetak thermal + akses dari riwayat (§9, §11) | — |
| **6** | Laporan 3 catatan + laba bersih + CSV (§12) | Rumus laba bersih lama tidak jelas |
| **7** | Test lengkap + QA manual + laporan akhir (§15, §16) | — |

Satu commit per fase.

---

## 15. PENGUJIAN

### 15.1 Feature test otomatis (minimal)
1. Cash: bayar dengan uang cukup → transaksi `CASH`, `change` benar, stok berkurang, item snapshot benar.
2. Cash: uang kurang → ditolak, tidak ada transaksi, stok tidak berubah.
3. QRIS prepare: keranjang valid → token + total sama dengan hitungan server. Klien mengirim total palsu → diabaikan.
4. QRIS confirm: membuat transaksi `QRIS`, `amount_paid = total`, `change = 0`, stok berkurang **sekali**.
5. QRIS confirm dua kali dengan token sama → **satu** transaksi saja, redirect ke struk yang sama.
6. QRIS confirm dengan token milik user lain → ditolak (403/redirect).
7. QRIS token kedaluwarsa → redirect ke POS dengan pesan.
8. Harga produk berubah antara prepare dan confirm → confirm ditolak, tidak ada transaksi.
9. Stok habis saat confirm → rollback penuh, pesan jelas, tidak ada transaksi.
10. QRIS tanpa gambar terunggah → prepare ditolak.
11. Laporan: dataset campuran (Cash, QRIS, 1 transaksi `cancelled`) → Cash, QRIS, Gabungan benar dan transaksi batal **tidak** ikut; Gabungan = Cash + QRIS; baris TOTAL tabel = kartu ringkasan.
12. Laba bersih = Gabungan (Cash + QRIS) − pengeluaran, **tanpa komponen katering**, dan sama dengan `fn_calculate_net_profit` bila dipakai. Tambahkan satu test: data katering yang masih ada di database (bila ada) **tidak** memengaruhi laba bersih.
13. Filter tanggal memengaruhi ketiga catatan secara konsisten.
14. Upload QRIS: file bukan gambar / terlalu besar ditolak; cashier tidak boleh mengunggah.
15. API mobile lama (tanpa `payment_method`) tetap membuat transaksi `CASH`.

### 15.2 QA manual
- [ ] Tidak ada opsi, label, filter, atau angka katering di POS, struk, Riwayat Transaksi, Laporan, dan export CSV.
- [ ] Alur QRIS 6 langkah berjalan persis seperti §2.1.
- [ ] Tombol Back browser di halaman QR/struk tidak membuat transaksi ganda.
- [ ] Keranjang pulih saat "Kembali ke Keranjang", kosong setelah transaksi selesai.
- [ ] Struk Cash menampilkan Tunai & Kembali; struk QRIS menampilkan "Dibayar via QRIS" tanpa kembalian.
- [ ] Cetak thermal hanya mencetak area struk pada 58mm dan 80mm.
- [ ] POS, halaman QR, struk, dan Laporan nyaman di HP (360px), tablet (768px), dan desktop (1280px), tanpa scroll horizontal.
- [ ] Gambar QRIS terlihat jelas dan terpindai oleh aplikasi pembayaran nyata dari layar.

---

## 16. KRITERIA SELESAI & FORMAT LAPORAN AKHIR

Pekerjaan selesai bila semua butir §2.1 terpenuhi, semua test §15.1 lulus, dan `npm run build` serta test suite berjalan tanpa error.

**Laporan akhir** (singkat, tanpa mengulang langkah kerja):
1. Ringkasan temuan Langkah 0 dan penyesuaian yang dibuat terhadap dokumen ini.
2. Daftar file yang dibuat/diubah, dikelompokkan per fase.
3. Hasil test (jumlah lulus/gagal) dan hal yang **belum** bisa diverifikasi, beserta alasannya.
4. Keterbatasan yang diketahui (khusus: QRIS statis tidak terverifikasi otomatis).
5. Daftar sisa komponen katering yang masih ada di repo (route, controller, tabel, menu sidebar, halaman, kolom dashboard) beserta apakah ada yang masih memengaruhi POS/Laporan, untuk tugas pembersihan terpisah.
6. Saran lanjutan (opsional): konfirmasi dua langkah sebelum Next, pemecahan Cash/QRIS di dashboard, cetak ESC/POS langsung.

Jangan menandai sesuatu "selesai" bila belum benar-benar dijalankan dan diuji.
