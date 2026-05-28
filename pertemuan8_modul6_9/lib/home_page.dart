// lib/home_page.dart
// Halaman utama aplikasi — menampilkan tombol kamera, galeri, dan preview foto

import 'dart:io';
import 'package:flutter/material.dart';
import 'package:permission_handler/permission_handler.dart';

import 'services/camera_service.dart';
import 'services/notification_service.dart';

class HomePage extends StatefulWidget {
  const HomePage({super.key});

  @override
  State<HomePage> createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  // State variable untuk menyimpan file foto yang dipilih
  File? _imageFile;

  // Instance service notifikasi dan kamera
  final NotificationService _notifService = NotificationService();
  final CameraService _cameraService = CameraService();

  @override
  void initState() {
    super.initState();
    // NotificationService sudah diinisialisasi di main.dart (singleton)
    // Tidak perlu inisialisasi ulang di sini
  }

  /// Minta izin kamera sebelum membuka kamera
  Future<bool> _requestCameraPermission() async {
    final status = await Permission.camera.request();
    if (status.isDenied || status.isPermanentlyDenied) {
      _showSnackBar('Izin kamera ditolak. Aktifkan di pengaturan aplikasi.');
      return false;
    }
    return true;
  }

  /// Minta izin penyimpanan/media sebelum membuka galeri
  Future<bool> _requestStoragePermission() async {
    // Android 13+ menggunakan READ_MEDIA_IMAGES, sebelumnya READ_EXTERNAL_STORAGE
    Permission storagePermission;
    if (Platform.isAndroid) {
      // Coba photos permission (Android 13+), fallback ke storage
      storagePermission = Permission.photos;
    } else {
      storagePermission = Permission.storage;
    }

    final status = await storagePermission.request();
    if (status.isDenied || status.isPermanentlyDenied) {
      // Coba storage permission sebagai fallback
      final storageStatus = await Permission.storage.request();
      if (storageStatus.isDenied || storageStatus.isPermanentlyDenied) {
        _showSnackBar('Izin penyimpanan ditolak. Aktifkan di pengaturan aplikasi.');
        return false;
      }
    }
    return true;
  }

  /// Tampilkan SnackBar dengan pesan tertentu
  void _showSnackBar(String message) {
    if (!mounted) return;
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text(message),
        backgroundColor: Colors.redAccent,
        duration: const Duration(seconds: 3),
        behavior: SnackBarBehavior.floating,
      ),
    );
  }

  /// Fungsi untuk mengambil foto dari kamera
  Future<void> _takePhoto() async {
    // Minta izin kamera terlebih dahulu
    final hasPermission = await _requestCameraPermission();
    if (!hasPermission) return;

    try {
      // Panggil service kamera untuk membuka kamera
      final photo = await _cameraService.pickFromCamera();

      if (photo != null) {
        // Jika foto berhasil diambil, update state untuk menampilkan foto
        setState(() {
          _imageFile = File(photo.path);
        });

        // Tampilkan notifikasi lokal setelah foto berhasil diambil
        await _notifService.showNotification();
      }
    } catch (e) {
      // Tampilkan pesan error jika terjadi exception
      _showSnackBar('Gagal membuka kamera: ${e.toString()}');
    }
  }

  /// Fungsi untuk memilih foto dari galeri
  Future<void> _pickFromGallery() async {
    // Minta izin penyimpanan terlebih dahulu
    final hasPermission = await _requestStoragePermission();
    if (!hasPermission) return;

    try {
      // Panggil service kamera untuk membuka galeri
      final photo = await _cameraService.pickFromGallery();

      if (photo != null) {
        // Jika foto berhasil dipilih, update state untuk menampilkan foto
        setState(() {
          _imageFile = File(photo.path);
        });

        // Tampilkan notifikasi lokal setelah foto berhasil dipilih
        await _notifService.showNotification();
      }
    } catch (e) {
      // Tampilkan pesan error jika terjadi exception
      _showSnackBar('Gagal membuka galeri: ${e.toString()}');
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      // AppBar: bilah atas aplikasi
      appBar: AppBar(
        title: const Text(
          'Kamera & Notifikasi',
          style: TextStyle(fontWeight: FontWeight.bold),
        ),
        backgroundColor: Theme.of(context).colorScheme.inversePrimary,
        centerTitle: true,
        elevation: 2,
      ),

      // Body: konten utama
      body: Column(
        children: [
          // Area foto (Expanded agar mengisi ruang tersisa)
          Expanded(
            child: Container(
              width: double.infinity,
              margin: const EdgeInsets.all(16),
              decoration: BoxDecoration(
                color: Colors.grey.shade100,
                borderRadius: BorderRadius.circular(16),
                border: Border.all(
                  color: Colors.grey.shade300,
                  width: 2,
                ),
              ),
              child: _imageFile != null
                  // Tampilkan foto jika sudah ada
                  ? ClipRRect(
                      borderRadius: BorderRadius.circular(14),
                      child: Image.file(
                        _imageFile!,
                        fit: BoxFit.cover,
                        width: double.infinity,
                        height: double.infinity,
                      ),
                    )
                  // Placeholder jika belum ada foto
                  : Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        Icon(
                          Icons.camera_alt_outlined,
                          size: 80,
                          color: Colors.grey.shade400,
                        ),
                        const SizedBox(height: 16),
                        Text(
                          'Belum ada foto dipilih',
                          style: TextStyle(
                            fontSize: 16,
                            color: Colors.grey.shade500,
                            fontWeight: FontWeight.w500,
                          ),
                        ),
                        const SizedBox(height: 8),
                        Text(
                          'Gunakan tombol di bawah untuk\nmengambil atau memilih foto',
                          textAlign: TextAlign.center,
                          style: TextStyle(
                            fontSize: 13,
                            color: Colors.grey.shade400,
                          ),
                        ),
                      ],
                    ),
            ),
          ),

          // Area tombol di bagian bawah
          Padding(
            padding: const EdgeInsets.fromLTRB(16, 0, 16, 24),
            child: Row(
              children: [
                // Tombol "Buka Kamera"
                Expanded(
                  child: ElevatedButton.icon(
                    onPressed: _takePhoto,
                    icon: const Icon(Icons.camera_alt),
                    label: const Text(
                      'Buka Kamera',
                      style: TextStyle(fontSize: 15),
                    ),
                    style: ElevatedButton.styleFrom(
                      padding: const EdgeInsets.symmetric(vertical: 14),
                      backgroundColor:
                          Theme.of(context).colorScheme.primary,
                      foregroundColor: Colors.white,
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(12),
                      ),
                    ),
                  ),
                ),

                const SizedBox(width: 12),

                // Tombol "Pilih Galeri"
                Expanded(
                  child: ElevatedButton.icon(
                    onPressed: _pickFromGallery,
                    icon: const Icon(Icons.photo_library),
                    label: const Text(
                      'Pilih Galeri',
                      style: TextStyle(fontSize: 15),
                    ),
                    style: ElevatedButton.styleFrom(
                      padding: const EdgeInsets.symmetric(vertical: 14),
                      backgroundColor:
                          Theme.of(context).colorScheme.secondary,
                      foregroundColor: Colors.white,
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(12),
                      ),
                    ),
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
