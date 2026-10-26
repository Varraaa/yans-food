# Panduan Strategis UX & Konsep Animasi Modern — Yan's Food (yansfoods.my.id)

Dokumen ini disusun sebagai panduan arsitektur visual dan pengalaman pengguna (UX) untuk pengembangan platform web kuliner **Yan's Food** pada ekosistem Laravel. Panduan ini berfokus pada penguatan identitas merek kuliner rumahan, kenyamanan alur pemesanan, dan sentuhan visual dinamis tanpa kompromi pada performa.

---

## 1. Audit UX Website Saat Ini

### A. Evaluasi Kekuatan Merek
* **Penyampaian Karakter Kuliner:** Nada visual (*warm cream*, *terracotta*, dan *amber*) sukses menghadirkan suasana dapur rumahan yang hangat, bersih, dan menggugah selera.
* **Kejelasan Nilai Produk:** Poin kepercayaan seperti status 100% Halal, bahan segar harian, dan jaminan higienis disajikan tepat pada area pandang pertama.
* **Navigasi Langsung:** Struktur halaman ringkas, memudahkan audiens langsung mengenali daftar menu dan kontak pesanan.

### B. Titik Friksi & Peluang Optimalisasi
* **Alur Menuju Pemesanan (Conversion Velocity):** Saat ini pengunjung masih perlu membuka kartu atau berpindah ke halaman lain sebelum terhubung ke format pemesanan WhatsApp. Diperlukan jalur pintas pemesanan instan langsung dari kartu menu.
* **Ergonomi Pengguna Ponsel (Thumb-Zone Priority):** Sebagian besar pemesanan makanan berbasis pesan instan terjadi lewat perangkat genggam. Area navigasi bawah layar ponsel perlu dioptimalkan untuk akses tombol pemesanan tanpa harus menjangkau bagian atas layar.
* **Dinamika Halaman:** Halaman beranda masih terasa statis saat digulir. Sentuhan transisi bertingkat (*staggered animations*) akan membuat penjelajahan katalog menu terasa lebih mengalir dan interaktif.

---

## 2. Blueprint Loading Screen (Splash Intro 2–3 Detik)

Tujuan splash screen ini adalah memperkuat pengenalan logo dan identitas merek Yan's Food pada detik pertama kunjungan, memberikan kesan eksklusif sebelum hidangan disajikan.

### A. Tahapan Waktu & Koreografi Visual
* **Fase 1: Kemunculan Logo (0.0s – 0.5s)**
  * Latar belakang transisi membuka dengan warna netral hangat (*soft beige/cream*).
  * Logo Yan's Food muncul di titik tengah layar dengan perbesaran halus (*soft scale-up* dari 90% menuju ukuran proporsional) disertai transisi opasitas bertahap.
* **Fase 2: Interaksi & Indikator (0.5s – 1.8s)**
  * Logo mempertahankan posisi dengan efek denyut lembut (*breathing pulse*) yang tenang.
  * Tepat di bawah logo, sebuah garis progress bar tipis berjalan mengisi ruang secara dinamis menuju 100%.
  * Teks penyerta ringkas seperti *"Menyiapkan Hidangan Hangat..."* tampil dengan kontras lembut di bawah garis progress.
* **Fase 3: Transisi Pembuka / Exit (1.8s – 2.5s)**
  * Seluruh elemen splash screen terangkat ke atas (*smooth curtain-up lift*) atau memudar secara dramatis (*opacity fade-out*).
  * Halaman utama beranda di belakangnya langsung terlihat dalam kondisi sudah ter-render sempurna tanpa jeda gambar kosong.

### B. Aturan UX & Batasan Arsitektur
1. **Pengelolaan Kunjungan Sesi (Session Tracking):**
   * Splash screen berdurasi 2–3 detik hanya boleh dipicu pada kunjungan pertama di sesi browser tersebut.
   * Saat pengguna berpindah antar halaman menu atau memperbarui halaman, splash screen tidak boleh muncul kembali secara penuh agar tidak membuang waktu pengunjung yang ingin segera memesan.
2. **Pintu Keluar Darurat (Fallback Safety Timeout):**
   * Terapkan batas waktu maksimal 3 detik mutlak. Sekalipun ada aset latar belakang atau koneksi seluler pelanggan lambat, layer intro harus dipaksa terbuka otomatis agar konten tidak terblokir.
3. **Penguncian Gulir Sementara:**
   * Saat intro aktif, fungsi pengguliran (*scroll lock*) dinonaktifkan sementara dan dikembalikan otomatis tepat saat animasi keluar dimulai.

---

## 3. Konsep Animasi Modern Tanpa Menurunkan Performa

### A. Hero Section (First Impression)
* **Pintu Masuk Bertingkat (Staggered Entrance):** Elemen judul besar, subjudul deskriptif, tombol tindakan utama (*CTA*), dan lencana sertifikasi masuk berurutan dengan jeda fraksi detik, bukan serentak.
* **Aksen Melayang Halus (Subtle Floating Plate):** Foto hidangan unggulan di area samping hero diberi gerakan mengambang vertikal dengan amplitudo kecil (6–8 pixel) dan tempo lambat, memberi kesan sajian yang baru matang.

### B. Interaksi Kartu Menu (Menu Cards Polish)
* **Respon Kursor Desktop:**
  * Gambar menu sedikit membesar ke dalam bingkai (*zoom-in clip*) saat disorot kursor, mempertahankan proporsi kartu tanpa menggeser tata letak di sekitarnya.
  * Bayangan kartu melembut dan kartu sedikit terangkat, memberi sensasi taktil bahwa kartu siap dipilih.
* **Respon Ketuk Ponsel:**
  * Kompresi skala mikro sesaat saat kartu disentuh, memberikan konfirmasi visual instan pada sentuhan jari sebelum aksi terbuka.

### C. Navigasi & Pengguliran (Scroll Dynamic)
* **Bilah Navigasi Adaptif (Blur Glassmorphism):** Header navigasi berubah dari transparan menjadi berlatar semi-transparan dengan efek kabur halus (*backdrop blur*) begitu halaman digulir melewati area Hero. Ini menjaga keterbacaan teks menu navigasi di atas foto-foto menu.
* **Pemunculan Bertahap (Reveal on Viewport Entry):** Konten cerita dapur, testimoni pelanggan, dan kumpulan katalog menu muncul ke layar hanya saat posisi gulir pengguna mendekati area tersebut.

---

## 4. Matriks Rekomendasi Fitur UX Tambahan

| Area | Konsep Fitur | Dampak terhadap Pengalaman Pengguna |
| :--- | :--- | :--- |
| **Katalog Menu** | Tab Kategori Dinamis | Pengunjung dapat berganti antara *Makanan Ringan*, *Makanan Berat*, dan *Minuman* seketika tanpa memuat ulang seluruh halaman. |
| **Pemesanan Mobile** | Sticky Action Bar | Bilah melayang ringkas di bagian bawah layar ponsel berisi ringkasan menu yang dipilih dan tombol langsung menuju konfirmasi WhatsApp. |
| **Visual Menu** | Label Visual Khusus | Pemasangan lencana kecil seperti *"Paling Laris"*, *"Menu Favorit"*, atau indikator rasa manis/pedas untuk mempermudah keputusan pembelian. |
| **Kinerja Gambar** | Skeleton Loading Placeholder | Kotak bayangan abu-abu berdenyut halus sebagai pengganti sementara sebelum gambar resolusi tinggi selesai diunduh oleh peramban pengguna. |

---

## 5. Rencana Tahapan Eksekusi untuk Tim Frontend

1. **Tahap 1:** Memetakan alur splash screen dan memastikan mekanisme pengecekan sesi browser berjalan dengan tepat.
2. **Tahap 2:** Menstandarkan transisi kartu menu dan hierarki informasi produk (harga, porsi, status ketersediaan).
3. **Tahap 3:** Menerapkan navigasi adaptif serta bilah aksi melayang khusus layar ponsel untuk memaksimalkan rasio konversi pesanan.
4. **Tahap 4:** Audit pengujian aksesibilitas, memastikan transisi visual tetap nyaman dilihat dan mendukung opsi pengurangan gerakan (*prefers-reduced-motion*).