// lib/services/camera_service.dart
// Service untuk mengelola pengambilan foto dari kamera dan galeri

import 'package:image_picker/image_picker.dart';

class CameraService {
  // Instance dari ImagePicker
  final ImagePicker _picker = ImagePicker();

  /// Ambil foto langsung dari kamera perangkat
  /// Mengembalikan XFile? (null jika pengguna membatalkan)
  Future<XFile?> pickFromCamera() async {
    try {
      // Buka kamera dan ambil foto dengan kualitas 80%
      final XFile? photo = await _picker.pickImage(
        source: ImageSource.camera,   // Sumber: kamera
        imageQuality: 80,             // Kualitas gambar 80% untuk hemat storage
      );
      return photo;
    } catch (e) {
      // Lempar exception agar bisa ditangani di pemanggil
      rethrow;
    }
  }

  /// Pilih foto dari galeri perangkat
  /// Mengembalikan XFile? (null jika pengguna membatalkan)
  Future<XFile?> pickFromGallery() async {
    try {
      // Buka galeri dan pilih foto dengan kualitas 80%
      final XFile? photo = await _picker.pickImage(
        source: ImageSource.gallery,  // Sumber: galeri
        imageQuality: 80,             // Kualitas gambar 80% untuk hemat storage
      );
      return photo;
    } catch (e) {
      // Lempar exception agar bisa ditangani di pemanggil
      rethrow;
    }
  }
}
