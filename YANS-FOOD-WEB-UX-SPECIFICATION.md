# YAN'S FOOD — SPESIFIKASI USER EXPERIENCE (UX) WEB COMPANY PROFILE

**Cakupan:** Website publik saja (Home, About, Menu, Pesan, Contact + Footer). Admin panel tidak termasuk.
**Stack:** Laravel 13, Blade, Tailwind CSS, MySQL. Interaksi memakai **Alpine.js** (ringan, cocok dengan Blade) + JavaScript native (IntersectionObserver, Fetch, View Transitions API sebagai progressive enhancement).
**Dokumen pendamping:** `YANS-FOOD-WEB-UIUX-SPECIFICATION.md` (visual & design system) dan `Yans_Food_Web_Specification.md` (fungsional). Dokumen ini **tidak mengubah** warna, font, atau struktur halaman di sana. Dokumen ini menambahkan **lapisan perilaku, interaksi, dan pengalaman**.

---

## DAFTAR ISI
1. [Tujuan & Prinsip UX](#1-tujuan--prinsip-ux)
2. [Pengunjung & Perjalanan Utama (User Journey)](#2-pengunjung--perjalanan-utama-user-journey)
3. [Sistem UX Global](#3-sistem-ux-global)
4. [Katalog Micro-interaction](#4-katalog-micro-interaction)
5. [UX per Halaman](#5-ux-per-halaman)
6. [UX Pemesanan Online & Takeaway (Detail Lengkap)](#6-ux-pemesanan-online--takeaway-detail-lengkap)
7. [Empty, Loading, Error, & Offline State](#7-empty-loading-error--offline-state)
8. [Performa sebagai Bagian dari UX](#8-performa-sebagai-bagian-dari-ux)
9. [Aksesibilitas](#9-aksesibilitas)
10. [SEO & Pengalaman Berbagi (Share)](#10-seo--pengalaman-berbagi-share)
11. [Event Tracking & Pengukuran UX](#11-event-tracking--pengukuran-ux)
12. [Struktur Implementasi (Blade, Alpine, CSS)](#12-struktur-implementasi-blade-alpine-css)
13. [Fase Implementasi & Prioritas](#13-fase-implementasi--prioritas)
14. [Checklist QA UX](#14-checklist-qa-ux)

---

## 1. Tujuan & Prinsip UX

### 1.1 Tujuan
Orang yang membuka website ini harus merasa tiga hal dalam 5 detik pertama:
1. **"Ini usaha yang nyata dan terawat."** Ada foto asli, tampilan rapi, informasi jelas.
2. **"Makanannya bikin lapar."** Foto, copy, dan ritme visual membangkitkan selera.
3. **"Gampang pesannya."** Jalur ke pembelian atau pemesanan tidak pernah lebih dari 2 tap/klik.

### 1.2 Prinsip UX (dipakai sebagai tolok ukur setiap keputusan)

| # | Prinsip | Artinya dalam praktik |
|---|---|---|
| 1 | **Hangat, bukan gimmick** | Animasi memperkuat rasa hangat dan rapi. Dilarang animasi yang hanya pamer (parallax berat, partikel, cursor effect). |
| 2 | **Satu tujuan per layar** | Setiap section punya satu pesan dan paling banyak satu CTA utama. |
| 3 | **Cepat terasa** | Konten muncul dulu, hiasan menyusul. Tidak ada layar kosong menunggu animasi selesai. |
| 4 | **Mobile first yang sebenarnya** | Mayoritas pengunjung UMKM kuliner datang dari HP lewat link Instagram/WhatsApp. Desain dan uji dimulai dari lebar 360px. |
| 5 | **Jangan buat user berpikir** | Label jelas, tombol berkata apa yang terjadi ("Pesan via WhatsApp", bukan "Submit"). |
| 6 | **Selalu ada umpan balik** | Setiap aksi (tap, kirim, gagal) mendapat respons visual dalam ≤100ms. |
| 7 | **Kejujuran** | Produk tidak tersedia ditampilkan apa adanya. Harga dan estimasi tidak menyesatkan. Tidak ada urgensi palsu ("sisa 2!") yang tidak berasal dari data nyata. |
| 8 | **Hormati preferensi user** | `prefers-reduced-motion`, `prefers-color-scheme` (tidak dipakai untuk dark mode publik, lihat 3.9), ukuran teks sistem, koneksi lambat. |

### 1.3 Anti-pola (dilarang)
- Popup newsletter/promo yang muncul otomatis saat halaman dibuka.
- Auto-play carousel yang berpindah sendiri tanpa kontrol.
- Scroll-jacking (mengubah perilaku scroll bawaan browser).
- Preloader layar penuh dengan logo berputar.
- Hover-only information (info penting yang hanya muncul saat hover, tidak ada di mobile).
- Cookie banner besar. Jika analytics tanpa cookie dipakai (lihat §11), banner tidak perlu.
- Counter palsu ("128 orang sedang melihat ini").
- Skeleton/animasi yang berjalan terus setelah konten siap.

---

## 2. Pengunjung & Perjalanan Utama (User Journey)

### 2.1 Tipe pengunjung

| Persona | Konteks | Tujuan | Kebutuhan UX utama |
|---|---|---|---|
| **A. Pelanggan Lapar** | Buka dari HP, sering dari link IG/WA. Sering sedang lapar sekarang. | Lihat menu dan harga, pesan cepat. | Menu cepat dimuat, harga jelas, tombol pesan online (ShopeeFood/GoFood/GrabFood) langsung terlihat. |
| **B. Pembeli Takeaway Dapur** | Ingin memesan makanan/kudapan untuk diambil sendiri langsung ke dapur Yan's Food. | Memesan langsung tanpa perantara kurir, memastikan pesanan siap saat tiba. | Alamat jelas, nomor WhatsApp aktif, format pesan otomatis, instruksi pengambilan transparan. |
| **C. Pengunjung Penasaran** | Diberi link teman atau baru lihat promosi. | Kenal usaha ini. | Cerita singkat, kesan tepercaya, mudah menemukan kontak. |

### 2.2 Perjalanan kunci (harus mulus)

**Journey 1 — Pesan cepat delivery (Persona A)**
`Link IG → Home → (scroll sedikit / tap "Lihat Menu") → Menu → lihat produk → "Pesan Online" → pilih platform → keluar ke ShopeeFood/GoFood/GrabFood`
- Target: dari landing sampai tap platform **≤ 3 tap**.
- Titik rawan: user bingung "beli di mana?". Solusi: CTA "Pesan Sekarang" permanen di navbar, dan di modal detail produk ada tautan "Pesan lewat platform" ke `/pesan#online`.

**Journey 2 — Pesan takeaway dapur (Persona B)**
`Home / Menu / Navbar → Pesan → pilih "Takeaway Dapur" → klik Chat WhatsApp → aplikasi WA terbuka dengan pesan terformat otomatis`
- Target: dari website ke percakapan WhatsApp resmi **≤ 2 tap**.
- Titik rawan: nomor tidak tersimpan atau pesan kosong. Solusi: direct link WhatsApp dengan template teks terisi otomatis berisi nama produk/pesanan.

**Journey 3 — Cek kredibilitas (Persona B/C)**
`Home → About → (galeri / cerita) → Contact → WA`
- Target: user menemukan nomor WA dan lokasi tanpa mencari.

**Journey 4 — Kembali ke website (semua)**
`Buka lagi → melihat menu terbaru → cek status "Tersedia"/"Tidak Tersedia"`
- Data status produk selalu real-time dari database. Tidak di-cache lama (maksimal 60 detik).

---

## 3. Sistem UX Global

Bagian ini berlaku di **semua halaman publik**.

### 3.1 Token Motion (satu sumber kebenaran)

Definisikan sebagai CSS custom property di `resources/css/app.css` dan sebagai `theme.extend` di Tailwind. Semua komponen memakai token ini, bukan angka acak.

```css
:root {
  /* Durasi */
  --dur-instant: 100ms;   /* feedback tap, ripple */
  --dur-fast:    180ms;   /* hover, focus, toggle */
  --dur-base:    280ms;   /* kartu, dropdown, tooltip */
  --dur-slow:    480ms;   /* reveal section, modal besar */
  --dur-hero:    900ms;   /* hanya sekali: intro hero */

  /* Easing */
  --ease-out:    cubic-bezier(0.22, 1, 0.36, 1);   /* masuk, default */
  --ease-in:     cubic-bezier(0.64, 0, 0.78, 0);   /* keluar, lebih cepat */
  --ease-spring: cubic-bezier(0.34, 1.56, 0.64, 1);/* hanya untuk "pop" kecil (badge, centang) */

  /* Jarak gerak */
  --shift-sm: 8px;
  --shift-md: 16px;
  --shift-lg: 32px;

  /* Stagger */
  --stagger: 60ms;        /* jeda antar elemen dalam satu grup */
  --stagger-max: 6;       /* elemen ke-7 dst. muncul bersamaan dengan ke-6 */
}

@media (prefers-reduced-motion: reduce) {
  :root { --dur-fast: 1ms; --dur-base: 1ms; --dur-slow: 1ms; --dur-hero: 1ms; --shift-sm: 0; --shift-md: 0; --shift-lg: 0; }
  html { scroll-behavior: auto !important; }
}
```

**Aturan penggunaan:**
- Hanya animasikan `transform` dan `opacity` (GPU-friendly). Dilarang menganimasikan `width`, `height`, `top`, `left`, `margin`.
- Pengecualian: expand/collapse (accordion) boleh memakai `grid-template-rows: 0fr → 1fr`.
- Gunakan `will-change` hanya sesaat saat animasi berjalan, bukan permanen.
- Setiap elemen yang bergerak punya padanan "tanpa gerak" yang tetap nyaman (fallback reduced-motion = langsung tampil, atau fade pendek).

### 3.2 Scroll Reveal (kemunculan elemen saat di-scroll)

**Mekanisme:** `IntersectionObserver` tunggal untuk seluruh halaman, memantau elemen dengan atribut `data-reveal`.

| Atribut | Efek |
|---|---|
| `data-reveal="up"` | fade-in + naik `--shift-md` (default) |
| `data-reveal="fade"` | fade-in saja (untuk elemen besar/foto penuh) |
| `data-reveal="left"` / `"right"` | masuk dari samping `--shift-lg` (hanya di layout asimetris desktop; di mobile jadi "up") |
| `data-reveal="scale"` | skala 0.96 → 1 + fade (untuk foto/kartu) |
| `data-reveal-group` | container; anak langsung otomatis di-stagger `--stagger` |
| `data-reveal-delay="120"` | delay manual (ms) |

**Aturan:**
- `threshold: 0.15`, `rootMargin: "0px 0px -8% 0px"` supaya elemen mulai muncul sebelum benar-benar di tengah layar.
- **Hanya sekali.** Setelah muncul, observer `unobserve`. Tidak ada animasi mundur saat scroll naik (membuat halaman terasa gelisah).
- Elemen **di atas lipatan (above the fold)** saat halaman dibuka **tidak** memakai scroll reveal. Mereka memakai animasi intro (3.3).
- **Tanpa JavaScript:** semua elemen `data-reveal` tampil normal. Sembunyikan awal hanya jika `<html class="js">` aktif (ditambahkan script inline kecil di `<head>`), agar tidak ada konten hilang bila JS gagal.
- Elemen penting untuk konversi (tombol CTA, harga) memakai reveal **tercepat** (`--dur-base`, tanpa delay), jangan sampai CTA terlambat terlihat.

### 3.3 Animasi Intro Halaman & Transisi Antar Halaman

**Intro (pemuatan awal, hanya Home):**
Urutan, total ≤ 900ms, tidak memblokir interaksi:
1. 0ms: background hero dan teks tampil (teks tidak boleh menunggu gambar).
2. 100ms: foto hero fade-in dari `opacity .0 → 1` + skala `1.06 → 1` (efek "menarik napas", 900ms).
3. 150ms: headline masuk per baris (mask reveal: tiap baris naik dari bawah garis, stagger 80ms).
4. 400ms: subheadline fade-up.
5. 520ms: dua tombol CTA fade-up (stagger 60ms).
6. 800ms: indikator scroll fade-in.

**Transisi antar halaman:**
- Progressive enhancement dengan **View Transitions API** (`@view-transition { navigation: auto; }`). Di browser yang mendukung, antar halaman memakai crossfade 200ms. Elemen navbar diberi `view-transition-name: site-nav` agar tidak ikut berkedip.
- Browser tanpa dukungan: navigasi normal tanpa animasi. **Tidak** memakai library SPA/Turbo hanya untuk transisi.
- Foto produk di grid Menu dan modal detail memakai `view-transition-name` unik per produk (`product-{id}`) agar foto terasa "membesar" menjadi modal (jika didukung browser; jika tidak, modal fade biasa).

### 3.4 Navigasi

**Navbar (desktop ≥ 1024px):**
- Tinggi 80px di atas hero (transparan), **menyusut ke 64px** setelah scroll > 24px, background cream `rgba(251,246,238,.88)` + `backdrop-blur(12px)` + border bawah 1px `rgba(38,32,27,.08)`. Transisi `--dur-base`.
- Logo mengecil dari 40px ke 32px mengikuti penyusutan.
- Link aktif: garis bawah 2px warna primary yang **bergeser (slide) antar link** saat hover, kembali ke link aktif saat mouse keluar (satu elemen indikator, bukan underline per link).
- Link punya area klik padding `12px 16px`. Fokus keyboard: ring 2px primary + offset 2px.
- CTA "Pesan Sekarang": tombol primary. Pada hover, panah kecil `→` bergeser 4px ke kanan.
- **Hide on scroll down, show on scroll up:** saat user scroll turun cepat > 120px dari posisi terakhir, navbar naik tersembunyi (`translateY(-100%)`), muncul lagi segera saat scroll naik sedikit (≥ 8px). Selalu tampil jika di dalam 80px dari atas halaman atau ada menu terbuka. Alasan: memberi ruang baca di layar HP, tapi navigasi tetap 1 gerakan jari.

**Navbar (mobile < 1024px):**
- Bar atas: logo kiri, tombol hamburger kanan (area sentuh 48×48px).
- Hamburger → ikon X dengan morph 180ms (tiga garis berubah jadi X, bukan ganti ikon mendadak).
- Menu terbuka = **overlay layar penuh**, background cream, muncul `opacity 0→1` + `translateY(-8px)→0` (280ms).
- Isi: link besar (Fraunces 28px, jarak antar link 8px, tinggi area sentuh ≥ 56px), muncul **berurutan** stagger 50ms. Di bawah: tombol "Pesan Sekarang" lebar penuh, lalu baris ikon sosial + nomor WA.
- Perilaku wajib: kunci scroll body saat menu terbuka (`overflow:hidden` + kompensasi scrollbar), tutup dengan tombol X, tombol `Esc`, tap link, atau tap area kosong. Fokus berpindah ke link pertama saat dibuka dan kembali ke tombol hamburger saat ditutup (focus trap).
- Link halaman aktif ditandai titik kecil terracotta di kiri teks.

**Tambahan navigasi:**
- **Skip link** "Lewati ke konten" sebagai elemen fokus pertama (terlihat saat difokus).
- **Breadcrumb tidak dipakai** (struktur situs datar, 5 halaman).
- **Tombol "Kembali ke atas"** muncul setelah scroll > 1.5 layar, kecil, kiri-bawah (kanan-bawah dipakai tombol WhatsApp), hanya di halaman panjang (Menu, About).
- **Anchor scroll** (`#online`, `#takeaway`): `scroll-behavior: smooth` dan `scroll-margin-top` sebesar tinggi navbar + 16px agar judul section tidak tertutup navbar.

### 3.5 Tombol WhatsApp Mengambang (Floating Action)

- Posisi kanan-bawah, offset 16px (mobile) / 24px (desktop), memperhitungkan `env(safe-area-inset-bottom)` untuk iPhone.
- Bentuk: lingkaran 56px hijau WhatsApp resmi `#25D366`, ikon putih. Di desktop saat hover, melebar menjadi pil dengan teks "Chat Admin" (280ms).
- **Kemunculan:** tidak muncul di 600px pertama halaman (agar tidak menumpuk dengan hero), fade-in setelahnya.
- Pesan awal otomatis berbeda per halaman (`?text=` terkonfigurasi):
  - Umum: "Halo Yan's Food, saya ingin bertanya."
  - Dari halaman Menu: "Halo Yan's Food, saya ingin bertanya soal menu."
  - Dari modal produk: "Halo Yan's Food, saya ingin pesan *{nama produk}*."
- Tidak berdenyut/berkedip terus-menerus. Satu kali "pulse" lembut (1 siklus) saat pertama muncul, lalu diam.
- Nomor WA dan teks default dikelola dari pengaturan (bukan hardcode di Blade).

### 3.6 Umpan Balik & Notifikasi (Toast)

- Toast kecil di **bawah-tengah** (mobile) / **kanan-bawah** (desktop), di atas tombol WA, muncul `translateY(16px)→0` + fade 280ms, hilang otomatis 4 detik (jeda saat hover/fokus).
- Hanya untuk umpan balik aksi sepele: "Nomor WA disalin", "Link disalin", "Draft dipulihkan".
- **Pesan penting (sukses/gagal kirim form) bukan toast**, tapi blok inline atau halaman sukses (lihat §6).
- `role="status"` + `aria-live="polite"`. Pesan error memakai `role="alert"`.

### 3.7 Pengalaman Sentuh & Pointer

- Semua target sentuh ≥ **48×48px** (jarak antar target ≥ 8px).
- `-webkit-tap-highlight-color: transparent`, diganti efek **press state**: tombol mengecil `scale(.97)` saat ditekan (`--dur-instant`), kembali saat dilepas.
- Hover hanya didefinisikan di dalam `@media (hover: hover) and (pointer: fine)` agar tidak "lengket" di layar sentuh.
- `touch-action: manipulation` pada tombol dan link untuk menghilangkan jeda 300ms tap.
- Chip filter yang bisa digeser horizontal: `scroll-snap-type: x proximity`, `overscroll-behavior-x: contain`, dengan gradient fade 24px di tepi kanan/kiri sebagai petunjuk "masih ada lagi".
- Gesture di galeri/lightbox: geser kiri-kanan untuk berpindah foto, geser ke bawah untuk menutup.

### 3.8 Gambar & Media (bagian dari UX)

- **Rasio konsisten:** foto produk 4:5 (card), 1:1 (thumbnail), hero 16:9 desktop / 4:5 mobile (art direction dengan `<picture>`, bukan sekadar crop otomatis). Pakai `aspect-ratio` CSS supaya tidak ada layout shift.
- **Placeholder saat memuat:** warna dominan foto (disimpan `dominant_color` di DB, jika belum ada pakai `#F1E6D6` Soft Sand) + **blur-up** (versi 24px yang dibesarkan dengan `filter: blur(20px)`, transisi ke gambar penuh 400ms).
- **Format:** WebP (fallback JPG), `srcset` 3 ukuran (480, 800, 1280), `sizes` akurat per layout, `loading="lazy"` untuk semua kecuali gambar hero dan 4 produk pertama (`fetchpriority="high"` hanya untuk gambar LCP).
- **Foto adalah daya tarik utama.** Tidak ada foto stok generik di halaman. Jika foto produk belum ada, gunakan placeholder ilustrasi garis sederhana per kategori (bukan kotak abu kosong).
- **Zoom halus:** hover foto produk `scale(1.04)` di dalam container ber-`overflow:hidden` + radius (500ms). Hanya di perangkat hover.

### 3.9 Tema & Mode Tampilan
- Website publik **tidak memiliki dark mode** di fase ini. Palet hangat/cream adalah bagian identitas dan foto makanan terlihat paling menggugah di latar terang hangat. Menambah dark mode berarti menguji ulang seluruh foto dan kontras, dan itu bukan prioritas.
- Tetap atur `color-scheme: light` agar kontrol form bawaan browser tidak berubah gelap di perangkat dark mode.
- Hormati ukuran font sistem (gunakan `rem`, jangan `px` untuk teks).

### 3.10 Bahasa & Gaya Tulisan (UX Writing)

| Aspek | Aturan |
|---|---|
| Sapaan | Bahasa Indonesia santai-sopan, memakai "kamu" untuk pelanggan, ramah dan hangat khas dapur rumahan. |
| Tombol | Kata kerja + hasil: "Lihat Menu", "Pesan Online", "Pesan Takeaway", "Lanjut ke WhatsApp". Hindari "Klik di sini", "Submit", "Selengkapnya" tanpa konteks. |
| Error | Menjelaskan apa yang salah dan cara memperbaikinya, tanpa menyalahkan: "Nomor WhatsApp belum lengkap. Contoh: 0812 3456 7890". Bukan "Input tidak valid". |
| Angka | Format rupiah `Rp 12.500` (titik pemisah ribuan), tanpa desimal. Angka harga memakai `font-variant-numeric: tabular-nums`. |
| Tanggal | "Sabtu, 24 Oktober 2026" (nama hari + tanggal lengkap) agar tidak ambigu. |
| Waktu | Format 24 jam dengan WIB: "13.00 WIB". |
| Panjang | Judul ≤ 8 kata, paragraf ≤ 3 kalimat, deskripsi produk ≤ 140 karakter di card. |

---

## 4. Katalog Micro-interaction

Daftar lengkap interaksi kecil. Implementasi harus **seragam**: komponen yang sama berperilaku sama di semua halaman.

| ID | Elemen | Pemicu | Perilaku | Durasi / Easing |
|---|---|---|---|---|
| M01 | Tombol primary | Hover | Background `#C1440E → #8F3209`; ikon panah (jika ada) geser +4px | `--dur-fast` / ease-out |
| M02 | Tombol primary | Press | `scale(.97)`, shadow mengecil | `--dur-instant` |
| M03 | Tombol primary | Fokus keyboard | Ring 2px `#D6A253` + offset 2px (kontras ke background) | instan |
| M04 | Tombol outline | Hover | Isi background terisi dari kiri ke kanan (pseudo-element `scaleX`) | `--dur-base` |
| M05 | Tombol saat loading | Submit | Teks diganti spinner kecil + teks "Mengirim…", tombol `disabled` + `aria-busy`, lebar tombol **tidak berubah** (hindari lompatan) | 180ms |
| M06 | Link teks | Hover | Garis bawah tumbuh dari kiri (`background-size 0→100%`) | `--dur-fast` |
| M07 | Card produk | Hover (hover-capable) | `translateY(-4px)`, shadow naik, foto `scale(1.04)` | `--dur-base` |
| M08 | Card produk | Tap (mobile) | Press state `scale(.98)`, lalu buka modal | `--dur-instant` |
| M09 | Card produk "Tidak Tersedia" | Hover/tap | Tanpa angkat. Foto tetap desaturasi. Tooltip/teks kecil: "Sedang tidak tersedia". Tidak ada efek "tombol mati" yang membingungkan. | n/a |
| M10 | Badge "Favorit" | Muncul | "Pop" kecil `scale(.8→1)` dengan `--ease-spring` saat card masuk viewport | 320ms |
| M11 | Chip filter kategori | Tap | Latar chip aktif **meluncur** (satu indikator bergeser) ke chip terpilih, bukan berganti mendadak | `--dur-base` |
| M12 | Grid produk | Ganti kategori | Card lama fade-out 120ms, card baru fade-up dengan stagger 40ms (maks. 8 elemen). Tinggi grid **tidak melompat** (gunakan `min-height` sementara) | 120 + 280ms |
| M13 | Input form | Fokus | Border berubah ke primary, ring halus `0 0 0 4px rgba(193,68,14,.12)`; label tetap terlihat (bukan placeholder-sebagai-label) | `--dur-fast` |
| M14 | Input form | Valid | Ikon centang hijau kecil muncul di kanan input (pop) setelah user meninggalkan field (on blur), bukan saat mengetik | 200ms |
| M15 | Input form | Error | Border `#B3432E`, pesan error masuk dari atas (fade + 4px), **goyang horizontal sekali** 3px (hanya saat submit gagal, bukan setiap ketikan). Dinonaktifkan di reduced-motion. | 240ms |
| M16 | Stepper kuantitas (+/−) | Tap | Angka berganti dengan **roll** vertikal (angka lama naik keluar, baru masuk dari bawah). Tahan tombol = ulang cepat (setelah 400ms, tiap 80ms). Tombol − nonaktif di angka minimum. | 160ms |
| M17 | Total harga | Berubah | Angka **menghitung naik/turun** (count-up 300ms) dan sorot latar kuning lembut `#D6A253` 20% yang memudar, memberi sinyal "total berubah". | 300ms |
| M18 | Checkbox/Radio kustom | Pilih | Centang tergambar (stroke-dashoffset), kotak sedikit "bounce" | 220ms |
| M19 | Modal / Bottom sheet | Buka | Desktop: modal tengah, `scale(.96→1)` + fade + backdrop `rgba(38,32,27,.5)` blur 4px. Mobile: **bottom sheet** naik dari bawah, dapat ditutup dengan geser ke bawah, ada pegangan (handle) 36×4px di atas. | 280ms |
| M20 | Modal | Tutup | Esc, tap backdrop, tombol X, geser ke bawah (mobile). Fokus kembali ke elemen pemicu. Scroll body terkunci selama terbuka. | 200ms (lebih cepat dari buka) |
| M21 | Accordion (FAQ) | Buka | Tinggi mengembang via `grid-template-rows`, ikon `+` berputar jadi `×`/`−` 90° | `--dur-base` |
| M22 | Logo platform (footer/Pesan) | Hover | Grayscale 100% → warna asli, `translateY(-2px)` | `--dur-base` |
| M23 | Salin ke clipboard | Tap | Ikon salin → centang selama 1,5 dtk + toast "Disalin" | 180ms |
| M24 | Tautan eksternal | Tap | Tampil ikon panah-keluar kecil di samping teks; buka tab baru dengan `rel="noopener noreferrer"` | n/a |
| M25 | Scroll indicator hero | Idle | Garis vertikal 40px dengan titik naik-turun lambat (2,4 dtk), **hilang** begitu user scroll > 40px | loop, berhenti saat reduced-motion |
| M26 | Progress baca (opsional) | Scroll | Garis tipis 2px warna gold di bawah navbar mengikuti progres scroll, **hanya halaman About** | linear |
| M27 | Galeri foto | Tap foto | Lightbox: foto membesar dari posisi asalnya (FLIP), swipe kiri/kanan, pinch-zoom, caption di bawah, penghitung "3 / 12" | 320ms |
| M28 | Halaman sukses form | Tampil | Centang besar tergambar (stroke) lalu konfeti halus **sangat singkat** 1x (≤ 1,2 dtk, 18 partikel warna palet), di-skip jika reduced-motion | 1200ms |

---

## 5. UX per Halaman

### 5.1 Home

**Tujuan halaman:** membuat kesan pertama kuat, lalu mengarahkan ke Menu (Persona A) atau Pesan (Persona B).

**Urutan section dan perilaku UX:**

| # | Section | Perilaku UX spesifik |
|---|---|---|
| 1 | **Hero** | Tinggi `100svh` (gunakan `svh`, bukan `vh`, agar tidak tertutup toolbar browser mobile) dengan `min-height: 560px` dan `max-height: 920px`. Intro sesuai §3.3. Foto hero bergerak sangat halus saat scroll (parallax ≤ 40px, hanya desktop dan hanya jika tidak reduced-motion; di mobile statis). Dua CTA: "Lihat Menu" (primary), "Pesan Sekarang" (outline). Di bawah CTA, **baris kepercayaan** kecil: ikon + teks seperti "Dibuat segar tiap hari · Tersedia di ShopeeFood, GoFood, GrabFood" (isi hanya fakta yang benar). |
| 2 | **Pengenalan singkat** | Layout 2 kolom (desktop): foto bergaya "polaroid" sedikit miring (rotate -2°, hanya desktop) dan teks. Reveal "left"/"right". Tautan teks "Baca cerita kami →" ke About. |
| 3 | **Produk Unggulan** | Grid 4 produk (2 kolom di mobile). Data dari produk bertanda "Favorit" di database (maksimal 4). Card memakai M07/M10. Di mobile, **boleh dijadikan carousel horizontal** dengan scroll-snap (card 72% lebar layar supaya card berikutnya "mengintip" sebagai petunjuk bisa digeser). Tombol "Lihat Semua Menu →" di bawah. |
| 4 | **Kenapa Pilih Kami** | 3–4 poin, ikon Lucide stroke 1.5 yang **tergambar** (stroke-dashoffset) saat muncul. Angka (jika ada data nyata) memakai count-up 1,2 dtk saat pertama masuk viewport, sekali. Jika tidak ada angka nyata, jangan karang angka. |
| 5 | **Teaser platform online** | Sejajar horizontal di desktop, stack di mobile. Logo 3 platform (M22). Tautan "Lihat Semua Cara Pesan →" ke `/pesan`. Tidak lebih tinggi dari ±160px di desktop (ini trust signal ringan). |
| 6 | **Galeri (opsional)** | Masonry 2 kolom (mobile) / 3 kolom (desktop), **maks. 6–8 foto** di Home, tombol "Lihat lebih banyak" ke About/galeri. Tap = lightbox (M27). |
| 7 | **Testimoni (opsional, jika ada data nyata)** | Carousel manual (panah + titik + swipe), **tanpa autoplay**. Hanya testimoni asli dengan izin (screenshot chat atau kutipan bernama). Jika belum ada, **lewati section** (jangan palsu). |
| 8 | **CTA penutup** | Background gradient hero (§2.1). Satu kalimat + dua tombol. Satu-satunya section dengan gradient penuh agar terasa "klimaks". |
| 9 | **Footer** | Lihat §5.6. |

**Ritme visual Home:** latar bergantian Cream → Sand → Cream → Surface → Gradient (CTA). Jarak antar section 64px (mobile) / 128px (desktop). Jangan lebih dari 2 section berturut-turut dengan struktur grid yang sama.

### 5.2 About

**Tujuan:** membangun kepercayaan personal. Cerita jujur UMKM rumahan.

- **Header halaman:** judul besar + satu kalimat pembuka. Foto lebar dengan reveal "scale".
- **Cerita bergaya timeline vertikal:** garis tipis gold di tengah (desktop) / kiri (mobile) yang **tergambar mengikuti scroll** (progress line). Tiap tonggak (misal: awal mulai jualan, produk pertama, bergabung ke platform online, pembukaan gerai) muncul bergantian kiri-kanan di desktop, satu sisi di mobile. Hanya tonggak yang benar-benar terjadi yang ditampilkan.
- **Visi, Misi, Nilai:** 3 card, hover M07, ikon tergambar.
- **Proses & dapur:** strip foto (3–5) dengan caption singkat per foto (misal "Mengaduk adonan risol setiap pagi"). Tap membuka lightbox.
- **Pemilik/tim (opsional):** foto + nama + satu kalimat. Wajah manusia meningkatkan kepercayaan secara signifikan pada usaha kuliner rumahan.
- **Garis progres baca** M26 (opsional).
- **CTA akhir:** "Mau cicip? Lihat Menu" + "Mau pesan? Pesan Online & Takeaway".

### 5.3 Menu

**Tujuan:** menemukan produk secepat mungkin dan terdorong memesan.

**Struktur kontrol (atas ke bawah):**
1. **Judul + hitungan hasil** ("24 menu"), diperbarui live saat filter berubah.
2. **Chip kategori** (sticky di bawah navbar saat scroll, agar filter selalu terjangkau): `Semua | Makanan Berat | Makanan Ringan | Mie Instan | Minuman` (dinamis dari DB). Indikator geser M11. Menampilkan jumlah per kategori sebagai angka kecil ("Minuman 6").
3. **Pencarian** (field dengan ikon kaca pembesar): filter live saat mengetik dengan **debounce 150ms**, pencocokan tidak sensitif huruf besar/kecil dan abaikan aksen/spasi ganda. Tombol hapus (×) muncul saat ada teks. Highlight kata yang cocok pada nama produk.
4. **Toggle "Hanya yang tersedia"** (switch). Default: **mati** (tampilkan semua, termasuk yang tidak tersedia, agar katalog terasa lengkap). Pilihan user diingat di `sessionStorage`.
5. **Urutkan** (opsional): Rekomendasi (default), Harga termurah, Harga termahal, Nama A–Z. Tampil sebagai dropdown ringkas.

**Mekanisme filter:**
- Server merender seluruh daftar produk (bagus untuk SEO dan bila JS mati). Alpine.js menyaring dengan atribut `data-category`, `data-name`, `data-available`.
- **URL ikut berubah** tanpa reload (`?kategori=minuman&q=es&tersedia=1` via `history.replaceState`) sehingga hasil filter bisa dibagikan dan tombol Back tidak membingungkan.
- Tanpa JS: chip berupa tautan biasa (`/menu?kategori=minuman`) yang direspons server. Pengalaman tetap berfungsi.

**Card produk:**
- Foto (4:5), badge kategori kecil di pojok kiri-atas foto, badge status di pojok kanan-atas.
- Nama (maks. 2 baris, potong dengan ellipsis), harga (tebal, tabular), satuan kecil ("/ pcs", "/ porsi").
- Hover/tap sesuai M07–M09.
- **Tidak ada tombol "tambah ke keranjang"** (website tidak punya keranjang online; pemesanan lewat platform delivery atau takeaway via WhatsApp). Aksi card = buka detail.

**Modal detail produk (bottom sheet di mobile):**
- Foto besar (swipe jika lebih dari 1 foto), nama, kategori, harga, status, deskripsi lengkap.
- Dua aksi, urutan sesuai konteks:
  - **Produk tersedia:** "Pesan via ShopeeFood/GoFood/GrabFood" (membuka `/pesan#online`) sebagai aksi utama untuk pembelian satuan, dan "Tanya via WhatsApp" (dengan nama produk otomatis di pesan) sebagai aksi sekunder.
  - **Produk tidak tersedia:** satu aksi "Tanya kapan tersedia via WhatsApp" (tidak ada tombol beli).
- Tombol "Bagikan" (Web Share API di mobile; salin link di desktop, toast M23). Setiap produk punya URL sendiri (`/menu/risol-mayo`) yang bisa dibuka langsung dan memunculkan modal yang sama (deep link), dengan `<title>`/OG sesuai produk.
- Navigasi antar produk dalam modal: tombol ‹ › dan swipe/keyboard panah, mengikuti urutan hasil filter saat ini.
- Tutup modal mengembalikan posisi scroll dan fokus ke card asal.

**Penanganan banyak produk:** bila produk > 24, gunakan **tombol "Tampilkan lebih banyak"** (memuat 12 berikutnya), bukan infinite scroll (infinite scroll merusak akses footer dan Back button).

**Hasil kosong:** lihat §7 (ilustrasi + saran: "Coba kata lain atau lihat semua menu" + tombol reset filter).

### 5.4 Pesan

**Tujuan:** satu halaman, dua niat jelas dan tidak tercampur: *makan sekarang* vs *pesan untuk acara*.

**Struktur & perilaku:**

1. **Hero kecil + pemilih niat (intent switcher):**
   Dua kartu besar yang dapat diketuk, tepat di bawah judul:
   - 🛵 "Online Delivery" → scroll halus ke `#online`
   - 🥡 "Takeaway Dapur" → scroll halus ke `#takeaway`
   Fungsi: user langsung sampai ke bagian relevan tanpa menggulung bagian lain. Pada desktop, kedua kartu juga bertindak sebagai **tab penanda posisi** (kartu aktif ditandai sesuai section yang sedang terlihat, memakai IntersectionObserver).

2. **Section A — Pesan Online (`#online`)**
   - Tiga kartu platform (ShopeeFood, GoFood, GrabFood), tiap kartu seluruhnya dapat diklik (bukan hanya tombol di dalamnya).
   - Isi kartu: logo, nama, satu baris keterangan, tombol "Buka di {platform}" dengan ikon panah-keluar.
   - Di mobile, tautan membuka **aplikasi** bila terpasang (gunakan tautan universal resmi toko), jika tidak, membuka web.
   - Pesan kecil "Link akan terbuka di tab baru" tidak perlu ditulis. Cukup ikon panah-keluar (M24).
   - Platform yang belum aktif ditampilkan dengan label "Segera hadir" dan tidak dapat diklik.

3. **Divider:** garis tipis + label "atau pesan langsung untuk diambil" di tengah, jarak ekstra 64px.

4. **Section B — Pesan Takeaway Dapur (`#takeaway`)**
   - **Panduan 3 langkah mudah**: "Pilih Menu → Hubungi via WhatsApp → Ambil di Dapur Yan's Food".
   - **Tombol WhatsApp Utama**: Mengarahkan langsung ke WhatsApp dengan template pesan terformat rapi.
   - **Informasi Dapur**: Alamat lengkap, estimasi waktu penyiapan pesanan, dan jam operasional pengambilan.

**Perilaku deep link:** `/pesan#online` dan `/pesan#takeaway` harus mendarat tepat di section dengan offset navbar.


### 5.5 Contact

- **Split layout:** kiri informasi (alamat, WA, Instagram, jam operasional), kanan peta.
- **Jam operasional dinamis:** badge **"Buka sekarang" / "Tutup · Buka lagi besok 08.00"** dihitung dari jam yang tersimpan dan zona waktu WIB (dihitung di server dan diperbarui di klien). Hari ini disorot di daftar jam. Jika libur/khusus, tampil banner informasi kecil.
- **Aksi satu ketukan** (tombol besar, bukan sekadar teks):
  - "Chat WhatsApp" (buka WA)
  - "Salin nomor" (M23)
  - "Buka di Google Maps" (rute langsung; di iOS/Android membuka aplikasi peta)
  - "Instagram"
- **Peta:** **tidak** memuat iframe Google Maps saat halaman dibuka (berat). Tampilkan gambar statis/placeholder + tombol "Tampilkan peta interaktif"; iframe dimuat setelah diketuk (`loading="lazy"` + facade). Menghemat data dan mempercepat halaman.
- **Form pesan singkat (opsional):** jika ada, nama + pesan + tombol ke WA (bukan sistem email yang berisiko tidak terbaca). Jika tidak perlu, cukup tombol WA.
- Teks sapaan: pernyataan jujur tentang waktu balasan ("Biasanya kami balas dalam 1–2 jam pada jam operasional") **hanya bila benar**.

### 5.6 Footer (semua halaman)

- Struktur sesuai `YANS-FOOD-WEB-UIUX-SPECIFICATION.md §4.7`.
- Tambahan UX: tautan jam operasional singkat dengan indikator "Buka/Tutup" yang sama dengan Contact; logo platform M22; ikon sosial dengan label aksesibel (`aria-label="Instagram Yan's Food"`).
- Footer tidak boleh menutupi atau tertutup tombol WA mengambang: beri `padding-bottom` ekstra di mobile (≥ 72px).
- Ada tautan "Kembali ke atas" di footer (selain tombol mengambang).

---

## 6. UX Pemesanan Online & Takeaway (Detail Lengkap)

Halaman Pesan adalah **titik konversi terpenting** yang menghubungkan pengunjung dengan kanal transaksi nyata.

### 6.1 Arsitektur Halaman Pesan: Dua Kanal Utama

| Kanal | Tujuan | Sasaran Pengguna | Perilaku Utama |
|---|---|---|---|
| **A. Online Delivery Platform** | Pesan antar langsung ke rumah via kurir aplikasi | Konsumen yang ingin diantar segera (ShopeeFood, GoFood, GrabFood) | Card interaktif langsung membuka aplikasi mitra atau website toko resmi |
| **B. Datang Langsung ke Tempat** | Datang langsung, pesan di tempat, tunggu pesanan dibuat hangat, terima, lalu bawa pulang *(drive-thru style, no dine-in)* | Konsumen yang datang langsung ke lokasi dapur | Menampilkan 4 langkah alur pesan di tempat, penegasan takeaway only, dan tombol Google Maps |

### 6.2 UX Online Delivery Platform (`#online`)
- **Tiga Kartu Mitra (ShopeeFood, GoFood, GrabFood):**
  - Desain elevated card dengan logo resmi, nama platform, badge ketersediaan (Aktif / Buka), dan tombol CTA "Buka Aplikasi / Web".
  - Pada perangkat mobile, link menggunakan tautan universal yang otomatis membuka aplikasi native Shopee/Gojek/Grab bila terpasang.
  - Setiap kartu memiliki micro-interaction hover halus (scale 1.02 & shadow terangkat).

### 6.3 UX Datang Langsung ke Tempat (`#langsung` / `#takeaway`)
- **Konsep Drive-Thru / Takeaway Only:**
  - Penegasan bahwa Yan's Food **tidak menyediakan fasilitas meja/kursi untuk makan di tempat (No Dine-In)**. Seluruh pesanan dibungkus rapi khusus untuk dibawa pulang.
- **Panduan 4 Langkah Jelas:**
  1. *Datang ke Tempat*: Kunjungi dapur fisik Yan's Food di Bandung, Kp. Ciloa, RT.04/RW.10, Kec. Soreang (Parkir motor & mobil nyaman tersedia).
  2. *Pesan di Kasir*: Pesan langsung kudapan renyah atau masakan hangat pilihan di kasir dan bayar via Tunai / QRIS.
  3. *Tunggu Disiapkan Hangat*: Pesanan digoreng & dimasak dadakan (10–15 menit) agar cita rasa dan kerenyahan optimal.
  4. *Terima & Bawa Pulang*: Terima pesanan bersegel higienis dan bawa pulang untuk disantap di rumah/kantor.
- **Informasi Transparan & Maps:**
  - Menampilkan alamat lengkap dapur dengan tautan resmi Google Maps: `https://maps.app.goo.gl/KnCpj3ViPCHGNmH66`.
  - Jam operasional datang langsung: 08.00 – 20.00 WIB (Setiap Hari).

### 6.4 Komunikasi & Negosiasi Pesanan Katering Acara (Halaman Contact)
- **Non-Sistem / Jalur WhatsApp:** Pemesanan porsi besar / katering untuk acara tidak diproses via database/sistem otomatis.
- **Formulir Negosiasi:** Form pada halaman Kontak mengarahkan calon pemesan ke WhatsApp Admin Yan's Food dengan data acara lengkap (nama, WA, topik, estimasi porsi, tanggal acara, rincian menu).
- **Hak Penentuan:** Keputusan diterima atau ditolaknya pesanan katering ditentukan oleh Admin Yan's Food di WhatsApp berdasarkan ketersediaan bahan dan kapasitas operasional dapur.

---

## 7. Empty, Loading, Error, & Offline State

| Situasi | Perlakuan UX |
|---|---|
| **Menu memuat** | Skeleton card (foto abu hangat + 2 garis teks) dengan **shimmer halus** hanya selama data belum ada, maksimal 8 card. Skeleton berhenti begitu konten tiba. |
| **Foto memuat** | Blur-up / warna dominan (3.8), tanpa spinner. |
| **Menu kosong (belum ada produk)** | Ilustrasi garis sederhana (piring/wajan), judul "Menu sedang disiapkan", teks ramah, tombol "Chat Admin untuk tanya menu". |
| **Hasil filter/pencarian kosong** | Ilustrasi kecil, "Belum ada yang cocok dengan '{kata}'", tombol "Hapus filter", dan baris "Atau lihat: {2–3 kategori populer}". |
| **Produk tidak tersedia** | Redup + badge abu "Tidak Tersedia" (bukan merah). Tidak ada tombol beli. Tawarkan "Tanya via WhatsApp". |
| **Form: mengirim** | Tombol M05, seluruh form `aria-busy`, tanpa overlay layar penuh. |
| **Form: gagal server (5xx)** | Banner inline: "Maaf, ada gangguan di pihak kami. Data kamu aman. Coba lagi, atau kirim lewat WhatsApp" + tombol WA dengan ringkasan pesanan terformat (**jalur cadangan**: pelanggan tetap bisa memesan walau server bermasalah). |
| **Form: terlalu banyak percobaan (429)** | "Terlalu banyak percobaan. Coba lagi dalam {n} menit atau chat admin langsung." |
| **Offline** | Banner tipis di atas: "Kamu sedang offline. Beberapa fitur mungkin tidak berfungsi." Form tetap menyimpan draft. Halaman yang pernah dibuka tetap terbaca (service worker opsional di fase lanjut). |
| **Halaman 404** | Halaman bermerek: ilustrasi/teks hangat ("Wah, halaman ini sudah habis seperti gorengan sore hari 😄" gaya bahasa boleh disesuaikan), tombol "Ke Beranda" dan "Lihat Menu", kotak pencarian menu. |
| **Halaman 500/503** | Halaman statis ringan bermerek, tanpa ketergantungan DB, berisi tombol WhatsApp dan tautan platform online sebagai jalur alternatif pemesanan. |
| **Peta gagal dimuat** | Tampilkan alamat teks + tombol "Buka di Google Maps". |
| **JavaScript nonaktif/gagal** | Konten, navigasi, daftar menu, dan form tetap berfungsi (lihat prinsip progressive enhancement di tiap bagian). |

---

## 8. Performa sebagai Bagian dari UX

Kecepatan = kesan profesional, terutama untuk pengunjung dari data seluler.

### 8.1 Target (diukur pada profil "Moto G Power, 4G lambat" di Lighthouse/PageSpeed)

| Metrik | Target |
|---|---|
| LCP (Largest Contentful Paint) | ≤ 2,5 dtk (target internal ≤ 2,0 dtk) |
| INP (Interaction to Next Paint) | ≤ 200 ms |
| CLS (Cumulative Layout Shift) | ≤ 0,05 |
| TTFB | ≤ 600 ms |
| Skor Lighthouse mobile | Performance ≥ 90, Accessibility ≥ 95, Best Practices ≥ 95, SEO ≥ 95 |
| Berat halaman Home (awal) | ≤ 1,2 MB total, JS ≤ 90 KB gzip |

### 8.2 Taktik Wajib
- **Font:** self-host Fraunces & Plus Jakarta Sans dalam format `woff2`, subset Latin, `font-display: swap`, `preload` hanya untuk 2 berkas yang dipakai di atas lipatan. Gunakan Fraunces variable font dengan sumbu minimal yang diperlukan (hindari memuat semua gaya). Tentukan font fallback dengan `size-adjust` agar tidak ada lompatan layout saat swap.
- **CSS:** Tailwind di-purge/JIT; CSS kritis inline untuk above-the-fold bila perlu.
- **JS:** Alpine.js dimuat `defer`; script per-halaman dimuat hanya di halaman yang butuh (galeri/lightbox hanya Home/About, kalender hanya Pesan). Tanpa jQuery. Tanpa library animasi berat (GSAP dkk.), cukup CSS + IntersectionObserver.
- **Gambar:** lihat §3.8. Hero memakai `fetchpriority="high"` dan `preload` untuk gambar LCP.
- **Caching:** header cache panjang (`immutable`, 1 tahun) untuk aset ber-hash (Vite); HTML publik di-cache singkat (≤ 60 detik) + cache invalidasi saat admin mengubah produk, agar status "Tersedia/Tidak Tersedia" tetap segar.
- **Prefetch cerdas:** saat user mengarahkan kursor/mulai menyentuh tautan internal (≥ 65ms), `prefetch` halaman tujuan (atau pakai Speculation Rules API bila tersedia). Tidak prefetch di koneksi `saveData`.
- **Hemat data:** hormati `Save-Data` / `navigator.connection.saveData` (gambar lebih kecil, matikan parallax & animasi intro berat).
- **Pihak ketiga:** minimalkan. Peta memakai facade (5.5). Embed Instagram/feeds tidak dimuat otomatis.
- **Anggaran layout shift:** semua gambar/iframe memiliki dimensi atau `aspect-ratio`; area konten dinamis (banner draft, toast) memakai ruang yang disiapkan atau `position: fixed`, tidak mendorong konten.

---

## 9. Aksesibilitas

Standar acuan: **WCAG 2.2 level AA**.

- **Kontras:** teks body `#26201B` pada `#FBF6EE` (±14:1). Teks terracotta `#C1440E` pada cream ±4,9:1 (lolos AA untuk teks normal). Teks putih di atas tombol terracotta ±5,3:1. **Teks di atas gradient hero/foto wajib memakai overlay gelap** hingga rasio ≥ 4,5:1 (uji di titik terang foto). Teks emas `#D6A253` di atas cream **tidak boleh** dipakai untuk teks kecil (kontras rendah), hanya dekoratif/ikon besar/garis.
- **Status tidak hanya dengan warna:** badge selalu punya teks ("Tersedia" / "Tidak Tersedia") dan/atau ikon.
- **Fokus terlihat:** `:focus-visible` ring 2px kontras tinggi di seluruh elemen interaktif (tidak pernah `outline: none` tanpa pengganti). Ring tidak terpotong `overflow:hidden`.
- **Keyboard:** seluruh fungsi dapat dioperasikan keyboard. Urutan fokus mengikuti urutan visual. Modal dan menu mobile memiliki *focus trap* dan mengembalikan fokus.
- **Landmark & struktur:** `<header>`, `<nav aria-label="Utama">`, `<main id="konten">`, `<footer>`. Satu `<h1>` per halaman, hierarki heading tidak melompat.
- **Teks alternatif:** foto produk `alt` deskriptif ("Risol mayo isi telur dan mayones di piring putih"), foto dekoratif `alt=""`. Logo platform `alt="ShopeeFood"` dst.
- **Pembaca layar:** hasil filter menu diumumkan (`aria-live="polite"`: "12 menu ditampilkan"). Perubahan langkah form diumumkan. Ikon-only button memiliki `aria-label`.
- **Gerak:** `prefers-reduced-motion` dihormati penuh (lihat 3.1). Tidak ada konten berkedip > 3 kali/detik. Tidak ada autoplay media dengan suara.
- **Target & zoom:** zoom hingga 200% tanpa kehilangan fungsi, tidak ada scroll horizontal di 320px (reflow WCAG 1.4.10). Jangan menonaktifkan zoom (`user-scalable=no` dilarang).
- **Bahasa:** `<html lang="id">`.
- **Form:** lihat 6.9.
- **Pengujian:** uji dengan keyboard saja, VoiceOver (iOS) / TalkBack (Android), dan axe DevTools sebelum rilis.

---

## 10. SEO & Pengalaman Berbagi (Share)

Banyak pengunjung datang dari hasil pencarian kuliner rumahan dan dari tautan yang dibagikan di WhatsApp/Instagram. **Cara tampilan tautan saat dibagikan adalah bagian dari UX.**

- **Meta per halaman:** `<title>` unik (≤ 60 karakter, "Menu — Yan's Food | Risol Mayo, Nasi Goreng Jadul & Lainnya"), meta description (≤ 155 karakter) yang menjual, canonical URL.
- **Open Graph & Twitter Card:** `og:title`, `og:description`, `og:image` (1200×630, foto makanan menggugah + logo, bukan foto kosong), `og:locale="id_ID"`. Setiap produk memiliki OG sendiri (foto + nama + harga) agar saat dibagikan ke WA terlihat menarik.
- **Structured data (JSON-LD):**
  - `Restaurant`/`FoodEstablishment` (nama, alamat, telepon, jam buka, `servesCuisine`, `priceRange`, `sameAs` ke sosmed & platform).
  - `Menu` / `MenuItem` / `Product` + `Offer` (harga, `availability` sesuai status) untuk halaman Menu/produk.
  - `BreadcrumbList` tidak diperlukan (struktur datar).
- **Google Business Profile:** konsisten (nama, alamat, telepon, jam) dengan data di website.
- **Sitemap.xml & robots.txt** dibuat otomatis; halaman admin `noindex`.
- **Favicon & ikon:** monogram Yan's Food (SVG + PNG 192/512 + apple-touch-icon), `theme-color` terracotta/cream agar bar browser seluruh di HP selaras.
- **Web App Manifest ringan (opsional):** agar bisa "Tambahkan ke layar utama". Tidak perlu fitur offline penuh.

---

## 11. Event Tracking & Pengukuran UX

Tujuan: tahu bagian mana yang berhasil dan mana yang membuat orang pergi, tanpa melacak berlebihan.

- **Alat:** analytics ringan tanpa cookie & ramah privasi (mis. Plausible/Umami self-hosted atau Cloudflare Web Analytics). Tidak memerlukan banner cookie. Jangan kirim data pribadi (nama, nomor WA, alamat) ke analytics.
- **Event kustom yang dicatat:**

| Event | Kapan | Properti |
|---|---|---|
| `cta_click` | Klik CTA utama | lokasi (hero/navbar/footer/section), tujuan |
| `menu_filter` | Ganti kategori/cari | kategori / panjang kata (bukan isi kata bila sensitif) |
| `product_open` | Buka modal produk | slug, kategori, tersedia/tidak |
| `platform_click` | Klik ShopeeFood/GoFood/GrabFood | platform, lokasi |
| `takeaway_click` | Klik pesan takeaway | sumber |
| `wa_click` | Klik WhatsApp | sumber (floating/contact/takeaway/produk) |
| `phone_copy` / `map_open` | Salin nomor / buka peta | – |
| `scroll_depth` | 25/50/75/100% | halaman |

- **Funnel yang dipantau:** Home → Pesan → pilih platform / takeaway → klik WA.
- **KPI UX (tinjau bulanan):**
  - Klik platform online & takeaway per kunjungan Pesan.
  - Rasio pentalan (bounce) Home < 55% (seluler).
  - Waktu rata-rata sampai klik CTA pertama.
  - Skor Core Web Vitals "Good" ≥ 75% kunjungan.
- **Uji kegunaan ringan (wajib sebelum peluncuran):** 5 orang nyata (pembeli kuliner), tugas: (1) cari harga Risol Mayo, (2) pesan takeaway via WhatsApp, (3) temukan nomor WA/alamat. Catat titik bingung, perbaiki, ulangi dengan 3 orang lagi.

---

## 12. Struktur Implementasi (Blade, Alpine, CSS)

### 12.1 Struktur berkas yang disarankan

```
resources/
├── css/
│   ├── app.css                  # @tailwind + token motion (§3.1) + utilitas reveal
│   └── components/              # (opsional) komponen @apply yang berulang
├── js/
│   ├── app.js                   # bootstrap Alpine, init global
│   ├── modules/
│   │   ├── reveal.js            # IntersectionObserver data-reveal (§3.2)
│   │   ├── navbar.js            # shrink, hide-on-scroll, overlay mobile, focus trap
│   │   ├── lightbox.js          # galeri (hanya halaman yang butuh)
│   │   ├── menu-filter.js       # filter/cari/urut + sinkron URL
│   │   ├── contact-hours.js     # status buka/tutup
│   │   └── share-copy.js        # Web Share + salin + toast
│   └── lib/
│       ├── focus-trap.js
│       ├── scroll-lock.js
│       └── format.js            # rupiah, tanggal, normalisasi nomor WA
└── views/
    ├── layouts/public.blade.php # head (meta/OG/JSON-LD), navbar, slot, footer, FAB WA, toast
    ├── public/
    │   ├── home.blade.php
    │   ├── about.blade.php
    │   ├── menu/index.blade.php
    │   ├── menu/show.blade.php  # deep link produk
    │   ├── pesan/index.blade.php
    │   └── contact.blade.php
    └── components/public/
        ├── navbar.blade.php
        ├── footer.blade.php
        ├── button.blade.php        # variant: primary | outline | whatsapp | ghost
        ├── product-card.blade.php
        ├── product-modal.blade.php
        ├── category-chips.blade.php
        ├── platform-card.blade.php
        ├── stepper-quantity.blade.php
        ├── form/input.blade.php, textarea.blade.php, select.blade.php, chips.blade.php
        ├── toast.blade.php
        ├── skeleton-card.blade.php
        ├── empty-state.blade.php
        └── wa-fab.blade.php
```

### 12.2 Konvensi
- **Alpine.js** untuk state UI lokal (menu mobile, modal, filter, form). Tidak memakai framework SPA. Logika yang >50 baris dipindah ke `Alpine.data('namaKomponen', …)` di modul terpisah.
- **Server tetap sumber kebenaran:** harga, status produk, validasi, nomor pesanan, total final, dan template WA dihitung di server. Klien hanya menampilkan dan mempercepat interaksi.
- **Komponen Blade** untuk elemen berulang agar perilaku (M01–M28) konsisten. Dilarang menyalin kelas Tailwind panjang di banyak tempat.
- **Class utilitas gerak**, contoh di Tailwind config: `animate-reveal-up`, `transition-card`, dengan durasi/easing dari token.
- **Tanpa JS tetap berguna:** setiap fitur interaktif memiliki fallback fungsional (lihat tanda "Tanpa JS" di bagian terkait).
- **Endpoint publik yang dibutuhkan UX** (selaras dengan spesifikasi fungsional):
  - `GET /menu` (+ query filter) dan `GET /menu/{slug}`
  - `GET /pesan`
- **Konfigurasi yang dapat diubah admin (disarankan tabel/setting, tanpa hardcode):** nomor WA admin, teks default WA, link platform (ShopeeFood/GoFood/GrabFood) & status aktif, jam operasional & hari libur.

---

## 13. Fase Implementasi & Prioritas

Dibagi supaya hasil terlihat bertahap dan risiko kecil.

### Fase 1 — Fondasi (wajib, dampak terbesar)
- [ ] Token motion + `prefers-reduced-motion` (§3.1)
- [ ] Navbar desktop (shrink, indikator aktif, hide-on-scroll) + menu mobile overlay (§3.4)
- [ ] Tombol primer/outline/press state + fokus terlihat (M01–M06)
- [ ] Scroll reveal (§3.2) + animasi intro hero (§3.3)
- [ ] Gambar responsif, blur-up, rasio konsisten (§3.8)
- [ ] Font self-host + optimasi (§8.2)
- [ ] Footer + tombol WA mengambang + toast (§3.5, 3.6, 5.6)

### Fase 2 — Menu & Konversi Pesan Online
- [ ] Chip kategori sticky + pencarian + sinkron URL (§5.3)
- [ ] Card produk + modal/bottom sheet + deep link produk (§5.3)
- [ ] Halaman Pesan: intent switcher + Section A platform delivery (§5.4)
- [ ] Empty/loading/error state dasar (§7)

### Fase 3 — Pemesanan Takeaway Dapur via WhatsApp
- [ ] Section B Takeaway Dapur: instruksi alur pemesanan takeaway mandiri (§6.1–6.3)
- [ ] Tombol WhatsApp direct link dengan template terformat otomatis (§6.4)
- [ ] Informasi alamat dapur lengkap dan estimasi waktu penyiapan makanan

### Fase 4 — Kredibilitas & Polesan
- [ ] About: timeline progres, galeri + lightbox (§5.2, M27)
- [ ] Contact: status buka/tutup, facade peta (§5.5)
- [ ] Testimoni (bila data nyata ada), FAQ accordion
- [ ] View Transitions, prefetch cerdas, hemat data (§3.3, §8.2)
- [ ] SEO: meta/OG/JSON-LD per produk (§10)

### Fase 5 — Ukur & Iterasi
- [ ] Event tracking (§11) + dashboard funnel
- [ ] Uji kegunaan 5+3 orang, perbaikan
- [ ] Audit Lighthouse, axe, uji perangkat nyata (§14)

---

## 14. Checklist QA UX

**Perangkat & browser (wajib diuji)**
- [ ] Android Chrome (360×800 dan 412×915), Samsung Internet
- [ ] iPhone Safari (375×812 dan 430×932) termasuk safe-area & toolbar dinamis
- [ ] Tablet (768×1024), laptop (1366×768), desktop (1920×1080)
- [ ] Chrome, Safari, Firefox, Edge versi terbaru
- [ ] Koneksi "Slow 4G" dan mode Hemat Data

**Interaksi**
- [ ] Menu mobile: buka/tutup via tombol, Esc, tap link, tap luar; scroll terkunci; fokus kembali
- [ ] Navbar: shrink dan hide/show benar, tidak berkedip, tidak menutupi anchor
- [ ] Semua hover hanya di perangkat hover; tidak ada "hover lengket" di sentuh
- [ ] Press state terasa di semua tombol
- [ ] Filter menu + URL + tombol Back/Forward konsisten
- [ ] Modal produk: deep link, tutup, fokus kembali, geser tutup di mobile

**Pemesanan Online & Takeaway WhatsApp**
- [ ] Tombol platform delivery (ShopeeFood, GoFood, GrabFood) membuka aplikasi/web dengan benar
- [ ] Tombol WhatsApp takeaway membuka percakapan dengan pesan terformat rapi
- [ ] Normalisasi nomor (`08…`, `+62…`, `62…`) benar

**Performa & aksesibilitas**
- [ ] Lighthouse mobile memenuhi target §8.1 untuk Home, Menu, Pesan
- [ ] CLS ≈ 0 saat gambar, font, banner draft, toast muncul
- [ ] Navigasi keyboard penuh, fokus terlihat, tidak ada jebakan fokus
- [ ] VoiceOver/TalkBack: struktur, label tombol, pengumuman hasil filter & error
- [ ] Reduced-motion aktif: tidak ada gerak berlebihan, semua tetap dapat dipakai
- [ ] Zoom 200% dan lebar 320px tanpa scroll horizontal
- [ ] JS dinonaktifkan: konten, menu, navigasi tetap berfungsi

**Konten & kejujuran**
- [ ] Tidak ada angka/testimoni/klaim palsu
- [ ] Status "Tersedia/Tidak Tersedia" sesuai database (maks. 60 dtk tertinggal)
- [ ] Link platform, nomor WA, jam operasional sesuai data terbaru
- [ ] Semua teks UX mengikuti §3.10 (nada, format rupiah/tanggal)

---

## Definisi Selesai (Definition of Done) — UX

Website dianggap memenuhi spesifikasi UX ini bila:
1. Seluruh item **Fase 1–3** selesai dan lolos Checklist QA §14.
2. Target performa & aksesibilitas §8.1 dan §9 tercapai pada perangkat nyata.
3. Perjalanan kunci §2.2 dapat diselesaikan oleh pengguna uji tanpa bantuan.
4. Tidak ada anti-pola §1.3 yang tersisa.
5. Pemilik usaha dapat mengubah nomor WA, link platform, dan jam operasional tanpa menyentuh kode.
