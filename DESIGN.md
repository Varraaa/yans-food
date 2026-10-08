# YAN'S FOOD — DESIGN SYSTEM & SPECIFICATION (DESIGN.md)

Dokumen ini merupakan acuan resmi styling, layout, dan komponen UI/UX untuk website **Yan's Food**, diekstrak secara presisi dari project Google Stitch: **"YANS FOOD UI UX"** (Project ID: `9239896704767677521`).

---

## 1. Filosofi & Arah Desain

**Konsep Utama:** *"Warm Artisanal Culinary"* / *"Warm Artisanal Premium"*
- **Esensi:** Kesan dapur kuliner rumahan yang hangat, bersih, rapi, higienis, dan profesional. 
- **Karakter:** Membumi, dipercaya, jujur, dan berkelas tanpa terkesan kaku atau dingin seperti korporat.
- **Anti "AI Slop":**
  - Tidak menggunakan gradien neon biru-ungu sintetis; gunakan warna bumi (*earthy*) alami seperti terakota, gading, dan emas hangat.
  - Memprioritaskan fotografi kuliner nyata dengan pencahayaan hangat alami.
  - Tipografi ekspresif dengan paduan serif editorial berkelas dan sans-serif geometris modern.
  - Animasi halus (*subtle micro-animations* dengan durasi 150–250ms `cubic-bezier(0.22, 1, 0.36, 1)`).

---

## 2. Token Desain (Design Tokens)

### 2.1 Palet Warna (Color Palette)

| Nama Token | Hex Code | Role / Penggunaan |
|---|---|---|
| **Primary** | `#9B3100` / `#C1440E` | Warna brand utama, tombol CTA primer, aksen penting |
| **Primary Container** | `#C1440E` | Background tombol aktif, pill highlight |
| **Primary Dark** | `#8F3209` | Hover state tombol primer, aksen kontras |
| **Primary Fixed / Dim** | `#FFDBCF` / `#FFB59C` | Badge aksen terang, background icon lembut |
| **Secondary (Charcoal)** | `#26201B` / `#655D57` | Teks judul/body, border struktural halus |
| **Secondary Container** | `#EADDD5` | Background badge netral, tab inaktif |
| **Tertiary (Warm Gold)** | `#D6A253` / `#754D00` | Border paket terpopuler, bintang rating, aksen mewah |
| **Tertiary Fixed / Dim** | `#FFDDB1` / `#F4BD6B` | Background ikon tertiary, highlight badge |
| **Base Background (Cream)** | `#FBF6EE` / `#FFF8F3` | Background kanvas utama halaman |
| **Background Alt (Soft Sand)**| `#F1E6D6` | Background section selang-seling & banner |
| **Surface Warm** | `#FFFDF9` | Card produk, elevated container, modal |
| **Surface Container Low** | `#FEF2E2` | Section container sekunder |
| **Surface Container High**| `#F3E6D6` | State hover elemen netral |
| **Inverse Surface** | `#362F25` | Footer background, dark floating card |
| **Inverse On Surface** | `#FCEFDF` | Teks kontras pada background gelap |
| **Success / Available** | `#3F7D53` | Badge status "Sedia" / "100% Halal" |
| **Success Surface** | `#E7F2EA` | Background pill status sedia |
| **Muted / Unavailable** | `#9C9284` | Badge status "Tidak Tersedia / Habis" |
| **Neutral Surface** | `#F1EEE8` | Background pill menu habis |
| **Danger / Error** | `#B3432E` | Validasi error & peringatan penting |

---

### 2.2 Tipografi (Typography)

Menggunakan perpaduan font Google Fonts premium yang jernih, nyaman dibaca, dan anti-"AI Slop":
- **Display / Headings / Brand:** `Outfit` (Modern, proporsional, ramah selera makan, elegan tanpa distorsi serif yang kaku)
- **Body / Content / UI / Numerik:** `Plus Jakarta Sans` (Jernih, proporsi bersih, nyaman dibaca dalam paragraf panjang)

```css
/* Skala Tipografi */
display-hero: 64px / line-height 72px / font-weight 700 / tracking -0.02em
headline-lg : 48px / line-height 56px / font-weight 700 / tracking -0.015em
headline-md : 36px / line-height 44px / font-weight 600 / tracking -0.01em
headline-sm : 24px / line-height 32px / font-weight 600 / tracking 0em
body-lg     : 18px / line-height 28px / font-weight 400
body-md     : 16px / line-height 24px / font-weight 400
body-sm     : 14px / line-height 20px / font-weight 400
label-md    : 14px / line-height 20px / font-weight 600 / tracking 0.02em
label-sm    : 12px / line-height 16px / font-weight 600 / tracking 0.04em
currency    : 20px / line-height 26px / font-weight 700 (tabular-nums)
```

---

### 2.3 Ukuran, Spacing & Breakpoint

- **Base Unit:** 4px
- **Container Max Width:** `1280px` (`max-w-7xl`)
- **Horizontal Gutters:**
  - Mobile (`< 640px`): `16px` (`px-4`)
  - Tablet (`640px - 1024px`): `24px` (`px-6`)
  - Desktop (`> 1024px`): `48px` - `64px` (`lg:px-12`)
- **Vertical Spacing:**
  - Antar section mobile: `48px` - `64px` (`py-12` - `py-16`)
  - Antar section desktop: `80px` - `96px` (`py-20` - `py-24`)

---

### 2.4 Radius, Shadow, & Border

```css
/* Corner Radius */
rounded-sm : 4px   /* Tag kecil */
rounded-md : 8px   /* Tombol & input field */
rounded-xl : 16px  /* Card produk, modal, badge */
rounded-2xl: 24px  /* Hero image frame, banner section */
rounded-full: 9999px /* Pill badges, search pill, avatar */

/* Shadows */
shadow-soft: 0 2px 8px rgba(38, 32, 27, 0.05), 0 8px 24px rgba(38, 32, 27, 0.03);
shadow-card: 0 2px 12px rgba(38, 32, 27, 0.06);
shadow-hover: 0 8px 24px rgba(38, 32, 27, 0.10);

/* Borders */
border-hairline: 1px solid rgba(38, 32, 27, 0.08);
border-focus: 2px solid #C1440E;
```

---

## 3. Komponen Desain Utama

1. **Brand Logo:**
   - Monogram wajan uap artisanal berbalut warna terakota `#C1440E` dan aksen gold `#D6A253`.
   - Disertai wordmark *"Yan's Food"* (serif) dan subline *"DAPUR KULINER RUMAHAN"*.

2. **Navbar & Navigasi Responsif:**
   - Fixed header dengan efek `backdrop-blur-md bg-cream-bg/95`.
   - Desktop & Tablet Navigasi: Navigasi modern dengan **animated underline indicator** (`bg-gradient-to-r from-primary to-tertiary`) yang mengembang halus dari tengah saat di-hover dan menetap solid dengan aksen gold dot saat halaman aktif (menggantikan hover kotak warna).
   - Mobile & Tablet Drawer: Sidebar slide-over dengan backdrop gelap transparan (`backdrop-blur-xs`), link beraksen garis vertikal di sebelah kiri saat aktif, info dapur & media sosial.
   - Pemicu Keranjang & Kasir terintegrasi dengan badge jumlah pesanan real-time.

3. **Food Product Card:**
   - Wadah `bg-surface-warm rounded-2xl p-4 shadow-sm`.
   - Foto rasio 1:1 (*square*) dengan efek hover zoom lembut.
   - Badge status: Hijau lembut "Sedia" atau Abu-abu "Tidak Tersedia / Habis".
   - Kategori label kecil uppercase di atas judul serif.
   - Harga dengan angka tabular bold dan tombol aksi (+ / Pesan).

4. **Category Ribbon & Search:**
   - Filter chips pill-shaped: `Semua`, `Makanan Ringan`, `Makanan Berat`, `Mie Instan`, `Minuman Segar`.
   - Real-time search bar dengan ikon pencarian bersih.

5. **Pesan / Catering Order Form:**
   - Section Delivery Online: Card interaktif ShopeeFood, GoFood, GrabFood.
   - Section Paket Katering: 3 Paket (Snack Box, Nasi Kotak Nusantara beraksen Gold, Prasmanan Mini).
   - Form Pemesanan Acara: Nama, Nomor WA, Tanggal Acara, Waktu, Paket, Porsi, Alamat, Catatan Khusus dengan generator pesan WhatsApp otomatis.

6. **Footer Persisten:**
   - 4 Kolom: Brand info, Navigasi, Kontak & Jam operasional, Media sosial.
   - Strip terintegrasi "Tersedia juga di: ShopeeFood, GoFood, GrabFood".
   - Hak cipta © 2026 Yan's Food.
