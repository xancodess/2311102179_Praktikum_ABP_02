# To-Do List Provider + FCM

Aplikasi Flutter sederhana untuk tugas praktik modul 12-13.

## Fitur

- Daftar tugas sederhana.
- State management menggunakan Provider.
- Menambah tugas baru.
- Menghapus seluruh tugas.
- Integrasi Firebase Cloud Messaging.
- Menampilkan FCM token untuk pengujian notifikasi.
- Menampilkan notifikasi foreground menggunakan local notification.

## File Utama

- `lib/main.dart`: bootstrap aplikasi dan registrasi Provider.
- `lib/models/todo.dart`: model data tugas.
- `lib/providers/todo_provider.dart`: state management daftar tugas.
- `lib/screens/todo_list_page.dart`: tampilan To-Do List.
- `lib/services/fcm_service.dart`: inisialisasi FCM dan handler notifikasi.
- `lib/firebase_options.dart`: placeholder Firebase, ganti dengan hasil FlutterFire CLI.

## Menjalankan Aplikasi Sebelum Firebase Setup

```bash
flutter pub get
flutter run
```

Sebelum Firebase dikonfigurasi, aplikasi tetap bisa dipakai untuk fitur To-Do List.
Status FCM akan menampilkan bahwa Firebase belum dikonfigurasi.

## Setup Firebase Setelah Kode Siap

1. Buat project di Firebase Console.
2. Tambahkan aplikasi Android dengan package name:

```text
com.example.tugas_praktik_modul_12_13
```

3. Install dan login Firebase CLI jika belum ada.
4. Install FlutterFire CLI.

```bash
dart pub global activate flutterfire_cli
firebase login
```

5. Jalankan konfigurasi dari root project.

```bash
flutterfire configure --platforms=android
```

6. Pastikan file `lib/firebase_options.dart` sudah berisi project Firebase asli,
   bukan lagi `demo-project`.
7. Jalankan ulang aplikasi.

```bash
flutter run
```

## Pengujian Notifikasi

1. Jalankan aplikasi di emulator/perangkat Android.
2. Izinkan permission notifikasi ketika diminta.
3. Salin FCM token yang tampil di aplikasi.
4. Buka Firebase Console.
5. Masuk ke menu Cloud Messaging.
6. Buat notifikasi baru dan kirim test message ke FCM token tersebut.
7. Ambil screenshot ketika notifikasi berhasil diterima.

## Screenshot Untuk Laporan

- Tampilan daftar tugas.
- Proses penambahan tugas.
- Notifikasi yang berhasil diterima aplikasi.

## Verifikasi Developer

```bash
flutter analyze
flutter test
flutter build apk --debug
```
