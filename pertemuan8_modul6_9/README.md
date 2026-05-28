# 📸 Photo Notif App — Kamera & Notifikasi

Aplikasi Flutter sederhana yang memungkinkan pengguna mengambil foto menggunakan kamera atau memilih foto dari galeri, kemudian secara otomatis menampilkan notifikasi lokal setelah foto berhasil diambil.

---

## ✨ Fitur

| Fitur | Deskripsi |
|---|---|
| 📷 Buka Kamera | Membuka kamera perangkat secara langsung untuk mengambil foto |
| 🖼️ Pilih dari Galeri | Membuka galeri untuk memilih foto yang sudah ada |
| 🔔 Notifikasi Lokal | Menampilkan notifikasi di status bar Android setelah foto berhasil diambil/dipilih |
| 🖼️ Preview Foto | Foto yang diambil/dipilih langsung ditampilkan di halaman utama |
| 🔐 Permission Handling | Meminta izin kamera dan penyimpanan dengan pesan error yang jelas |

---

## 📦 Packages yang Digunakan

| Package | Versi | Fungsi |
|---|---|---|
| `image_picker` | ^1.0.4 | Mengambil foto dari kamera atau galeri |
| `flutter_local_notifications` | ^16.1.0 | Menampilkan notifikasi lokal di Android |
| `permission_handler` | ^11.0.1 | Mengelola izin runtime (kamera, storage) |

---

## 🚀 Cara Menjalankan Aplikasi

### Prasyarat
- Flutter SDK terinstall (versi 3.x ke atas)
- Android Studio atau VS Code dengan Flutter extension
- Android device/emulator dengan API level 21+

### Langkah-langkah

```bash
# 1. Clone repositori
git clone https://github.com/username/pertemuan8_modul6_9.git

# 2. Masuk ke direktori proyek
cd pertemuan8_modul6_9

# 3. Install semua dependencies
flutter pub get

# 4. Jalankan aplikasi (pastikan device/emulator sudah terkoneksi)
flutter run
```

> ⚠️ **Catatan untuk Windows**: Sebelum menjalankan `flutter pub get`, pastikan **Developer Mode** sudah aktif di pengaturan Windows (`Settings > Privacy & Security > For Developers > Developer Mode: ON`). Ini diperlukan untuk dukungan symlink yang digunakan Flutter.

---

## 📁 Struktur Folder

```
pertemuan8_modul6_9/
├── android/
│   └── app/
│       ├── build.gradle.kts          ← Konfigurasi Gradle (minSdk 21, targetSdk 34)
│       └── src/main/
│           ├── AndroidManifest.xml   ← Permissions & FileProvider
│           └── res/xml/
│               └── file_paths.xml    ← Konfigurasi FileProvider paths
├── lib/
│   ├── main.dart                     ← Entry point aplikasi
│   ├── home_page.dart                ← Halaman utama (UI)
│   └── services/
│       ├── camera_service.dart       ← Logika kamera & galeri
│       └── notification_service.dart ← Logika notifikasi lokal
├── pubspec.yaml                      ← Dependencies & konfigurasi project
└── README.md                         ← Dokumentasi ini
```

---

## 🔐 Permissions Android

Berikut permission yang ditambahkan di `AndroidManifest.xml`:

| Permission | Tujuan | SDK |
|---|---|---|
| `CAMERA` | Mengakses kamera perangkat | Semua |
| `READ_EXTERNAL_STORAGE` | Membaca file dari storage | ≤ Android 12 |
| `WRITE_EXTERNAL_STORAGE` | Menulis file ke storage | ≤ Android 9 |
| `READ_MEDIA_IMAGES` | Membaca foto media | Android 13+ |
| `POST_NOTIFICATIONS` | Menampilkan notifikasi | Android 13+ |

---

## 🧩 Penjelasan Widget & Class

| Widget / Class | Fungsi |
|---|---|
| `MaterialApp` | Root widget aplikasi, menyediakan tema Material Design dan routing |
| `Scaffold` | Kerangka halaman standar Material: AppBar, body, dan area konten |
| `AppBar` | Bilah navigasi atas yang menampilkan judul aplikasi |
| `Column` | Widget layout yang menyusun anak-anaknya secara vertikal |
| `Expanded` | Mengisi ruang kosong yang tersisa dalam Row atau Column |
| `Image.file` | Menampilkan gambar dari file lokal di storage perangkat |
| `ElevatedButton.icon` | Tombol Material Design dengan ikon dan label teks |
| `ImagePicker` | Plugin untuk mengambil foto dari kamera atau memilih dari galeri |
| `FlutterLocalNotificationsPlugin` | Plugin untuk membuat dan menampilkan notifikasi lokal di Android |
| `StatefulWidget` | Widget yang memiliki state yang bisa berubah saat runtime |
| `setState()` | Metode untuk memberitahu Flutter bahwa state berubah dan UI perlu di-rebuild |
| `SnackBar` | Widget pop-up kecil di bagian bawah layar untuk menampilkan pesan singkat |
| `Permission` | Class dari permission_handler untuk meminta izin runtime |
| `NotificationService` | Class custom untuk mengelola inisialisasi dan tampilan notifikasi |
| `CameraService` | Class custom yang membungkus logika ImagePicker untuk kamera & galeri |

---

## 📱 Screenshot

[screenshot here]

---

## 🏗️ Konfigurasi Android

**`android/app/build.gradle.kts`:**
```kotlin
minSdk = 21       // Android 5.0 Lollipop (minimum)
targetSdk = 34    // Android 14
compileSdk = 34   // Android 14
```

---

## 👨‍💻 Dibuat untuk

Tugas Pertemuan 8 — Modul 6 & 9 (Flutter Mobile Development)

---

*Dibuat dengan ❤️ menggunakan Flutter*
