// lib/services/notification_service.dart
// Service untuk mengelola notifikasi lokal menggunakan flutter_local_notifications

import 'dart:io';
import 'package:flutter_local_notifications/flutter_local_notifications.dart';
import 'package:permission_handler/permission_handler.dart';

class NotificationService {
  // Instance dari plugin notifikasi lokal (singleton)
  static final NotificationService _instance = NotificationService._internal();
  factory NotificationService() => _instance;
  NotificationService._internal();

  final FlutterLocalNotificationsPlugin _flutterLocalNotificationsPlugin =
      FlutterLocalNotificationsPlugin();

  bool _isInitialized = false;

  /// Inisialisasi notifikasi service
  /// Harus dipanggil sebelum runApp() di main.dart
  Future<void> initialize() async {
    if (_isInitialized) return;

    // Konfigurasi untuk platform Android menggunakan icon launcher aplikasi
    const AndroidInitializationSettings androidInitializationSettings =
        AndroidInitializationSettings('@mipmap/ic_launcher');

    // Gabungkan pengaturan dari semua platform
    const InitializationSettings initializationSettings =
        InitializationSettings(
      android: androidInitializationSettings,
    );

    // Inisialisasi plugin dengan pengaturan di atas
    await _flutterLocalNotificationsPlugin.initialize(
      initializationSettings,
      onDidReceiveNotificationResponse: (NotificationResponse response) {
        // Callback saat notifikasi ditekan (opsional)
      },
    );

    // Minta izin notifikasi untuk Android 13+ (API 33+)
    await _requestNotificationPermission();

    _isInitialized = true;
  }

  /// Minta izin POST_NOTIFICATIONS untuk Android 13+ secara eksplisit
  Future<void> _requestNotificationPermission() async {
    if (Platform.isAndroid) {
      // Minta izin notifikasi melalui permission_handler
      final status = await Permission.notification.status;
      if (status.isDenied || status.isRestricted) {
        await Permission.notification.request();
      }

      // Minta izin langsung dari plugin untuk Android (diperlukan agar channel terdaftar)
      final androidPlugin = _flutterLocalNotificationsPlugin
          .resolvePlatformSpecificImplementation<
              AndroidFlutterLocalNotificationsPlugin>();
      await androidPlugin?.requestNotificationsPermission();
    }
  }

  /// Tampilkan notifikasi lokal setelah foto berhasil diambil/dipilih
  Future<void> showNotification() async {
    // Pastikan sudah diinisialisasi
    if (!_isInitialized) {
      await initialize();
    }

    // Konfigurasi detail tampilan notifikasi di Android
    const AndroidNotificationDetails androidNotificationDetails =
        AndroidNotificationDetails(
      'photo_channel',          // channelId: ID unik untuk channel notifikasi
      'Photo Notifications',    // channelName: Nama channel yang tampil di pengaturan
      channelDescription: 'Notifikasi saat foto berhasil diambil atau dipilih',
      importance: Importance.max,    // Prioritas tertinggi agar muncul di status bar
      priority: Priority.high,       // Prioritas tinggi untuk notifikasi Android
      icon: '@mipmap/ic_launcher',   // Icon notifikasi
      playSound: true,               // Putar suara saat notifikasi muncul
      enableVibration: true,         // Aktifkan vibration
      channelShowBadge: true,        // Tampilkan badge pada icon aplikasi
    );

    // Gabungkan detail notifikasi dari semua platform
    const NotificationDetails notificationDetails = NotificationDetails(
      android: androidNotificationDetails,
    );

    // Tampilkan notifikasi
    await _flutterLocalNotificationsPlugin.show(
      0,                       // id: ID notifikasi (0 = satu notifikasi aktif sekaligus)
      'SIAP FOTO 📸',          // title: Judul notifikasi
      'Foto berhasil diambil! Lihat hasilnya di aplikasi. ✅', // body: Isi notifikasi
      notificationDetails,
    );
  }
}
