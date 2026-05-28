// lib/main.dart
// Entry point aplikasi Flutter — Kamera & Notifikasi

import 'package:flutter/material.dart';

import 'services/notification_service.dart';
import 'home_page.dart';

/// Entry point aplikasi
/// Inisialisasi Flutter binding dan NotificationService sebelum runApp
Future<void> main() async {
  // Pastikan Flutter binding sudah siap sebelum inisialisasi plugin
  WidgetsFlutterBinding.ensureInitialized();

  // Inisialisasi NotificationService sebelum runApp agar siap digunakan
  final notificationService = NotificationService();
  await notificationService.initialize();

  // Jalankan aplikasi
  runApp(const MyApp());
}

/// Root widget aplikasi
class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      // Judul aplikasi (tampil di task manager)
      title: 'Kamera & Notifikasi',

      // Sembunyikan banner "DEBUG" di pojok kanan atas
      debugShowCheckedModeBanner: false,

      // Tema aplikasi menggunakan Material 3
      theme: ThemeData(
        colorScheme: ColorScheme.fromSeed(
          seedColor: Colors.deepPurple,
          brightness: Brightness.light,
        ),
        useMaterial3: true,
      ),

      // Halaman utama aplikasi
      home: const HomePage(),
    );
  }
}
