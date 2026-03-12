# 🌙 Ramadan Mubarak 1446 H — Halaman Web Interaktif

Halaman web bertema Ramadan yang dibangun dengan **HTML, CSS, JavaScript Native**, dan **Bootstrap 5** — tanpa framework tambahan. Dilengkapi fitur THR interaktif, animasi, jadwal shalat, checklist amalan harian, dan desain responsif untuk mobile.

---

## 📸 Preview

> Buka file `ramadan.html` langsung di browser untuk melihat tampilan penuh.

---

## ✨ Fitur Utama

### 🎨 Tampilan & Animasi
- **Starfield Canvas** — langit berbintang animasi yang berkedip di background
- **Bulan Sabit Animasi** — efek glow yang berdenyut secara terus-menerus
- **Navbar Fixed** — transparan dengan efek blur (`backdrop-filter`)
- **Tema Gelap Elegan** — palet warna deep navy, emas, dan krem

### ⏱️ Countdown Idul Fitri
- Hitung mundur real-time menuju Idul Fitri 1446 H (30 Maret 2025)
- Menampilkan hari, jam, menit, dan detik secara live

### 🎁 Modal THR Interaktif
- **Amplop animasi** — klik untuk membuka, flap terbuka & uang keluar
- **Nominal acak** dari 7 pilihan (Rp 100.000 s/d Rp 5.000.000)
- **Konfeti berjatuhan** setelah amplop dibuka
- **Pesan spesial** menyesuaikan nominal yang didapat
- **Share ke WhatsApp** langsung dari modal
- **Copy teks** hasil THR ke clipboard

### 📅 Jadwal Shalat
- Kartu waktu shalat harian (Subuh, Dzuhur, Ashar, Maghrib, Isya, Imsak)
- Tabel jadwal 10 titik waktu selama Ramadan (Jakarta)

### 📊 Progress Ramadan
- Progress bar otomatis menghitung hari ke berapa saat ini
- Label hari dan persentase progress ditampilkan dinamis

### ✅ Checklist Amalan Harian
- 10 item amalan yang bisa dicentang/uncheck
- Progress bar amalan real-time
- Data tersimpan di `localStorage` (tidak hilang saat refresh)

### 🤲 Doa & Dzikir
- Doa Malam Lailatul Qadar (tulisan Arab + latin + terjemahan)
- Doa Berbuka Puasa (tulisan Arab + latin + terjemahan)

### 📱 Responsif Mobile
- Layout menyesuaikan layar kecil menggunakan grid Bootstrap
- Ukuran font menggunakan `clamp()` agar proporsional di semua layar
- Bulan sabit dan elemen hero menyusut di mobile

---

## 🛠️ Teknologi yang Digunakan

| Teknologi | Versi | Keterangan |
|---|---|---|
| HTML5 | — | Struktur halaman |
| CSS3 (Native) | — | Animasi, CSS Variables, custom styling |
| JavaScript (Native) | — | Countdown, canvas, modal logic, localStorage |
| Bootstrap | 5.3.3 | Layout, komponen (Navbar, Modal, Table, Grid) |
| Bootstrap Icons | 1.11.3 | Ikon-ikon UI |
| Google Fonts | — | Font Amiri (Arab) + Poppins |

> ⚠️ **Tidak menggunakan** framework JS seperti React, Vue, atau jQuery.
