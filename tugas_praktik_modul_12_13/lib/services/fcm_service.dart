import 'package:firebase_core/firebase_core.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter/foundation.dart';
import 'package:flutter_local_notifications/flutter_local_notifications.dart';

import '../firebase_options.dart';

@pragma('vm:entry-point')
Future<void> firebaseMessagingBackgroundHandler(RemoteMessage message) async {
  if (!_isFirebaseConfigured) return;

  await Firebase.initializeApp(options: DefaultFirebaseOptions.currentPlatform);
}

class FcmService extends ChangeNotifier {
  static const AndroidNotificationChannel _androidChannel =
      AndroidNotificationChannel(
        'todo_fcm_channel',
        'To-Do Notifications',
        description: 'Notification channel for To-Do List FCM messages.',
        importance: Importance.high,
      );

  final FlutterLocalNotificationsPlugin _localNotifications =
      FlutterLocalNotificationsPlugin();

  String? _token;
  String _status = _isFirebaseConfigured
      ? 'Menyiapkan Firebase Cloud Messaging...'
      : 'Firebase belum dikonfigurasi.';
  String? _lastMessageTitle;
  String? _lastMessageBody;

  String? get token => _token;
  String get status => _status;
  String? get lastMessageTitle => _lastMessageTitle;
  String? get lastMessageBody => _lastMessageBody;
  bool get isConfigured => _isFirebaseConfigured;

  Future<void> initialize() async {
    if (!_isFcmPlatformSupported) {
      _status = 'FCM hanya diaktifkan untuk Android pada project ini.';
      notifyListeners();
      return;
    }

    if (!_isFirebaseConfigured) {
      return;
    }

    try {
      await Firebase.initializeApp(
        options: DefaultFirebaseOptions.currentPlatform,
      );
      FirebaseMessaging.onBackgroundMessage(firebaseMessagingBackgroundHandler);

      await _setupLocalNotifications();

      final settings = await FirebaseMessaging.instance.requestPermission(
        alert: true,
        badge: true,
        sound: true,
      );

      _token = await FirebaseMessaging.instance.getToken();
      _status = settings.authorizationStatus == AuthorizationStatus.denied
          ? 'Izin notifikasi ditolak.'
          : 'FCM aktif. Token siap dipakai untuk pengujian.';

      FirebaseMessaging.onMessage.listen(_handleForegroundMessage);
      FirebaseMessaging.onMessageOpenedApp.listen(_saveMessage);

      final initialMessage = await FirebaseMessaging.instance
          .getInitialMessage();
      if (initialMessage != null) {
        _saveMessage(initialMessage);
      }
    } catch (error) {
      _status =
          'FCM belum aktif. Jalankan konfigurasi Firebase lalu restart app.';
      debugPrint('FCM initialization error: $error');
    }

    notifyListeners();
  }

  Future<void> _setupLocalNotifications() async {
    const androidSettings = AndroidInitializationSettings(
      '@mipmap/ic_launcher',
    );
    const initializationSettings = InitializationSettings(
      android: androidSettings,
    );

    await _localNotifications.initialize(settings: initializationSettings);

    final androidPlugin = _localNotifications
        .resolvePlatformSpecificImplementation<
          AndroidFlutterLocalNotificationsPlugin
        >();
    await androidPlugin?.createNotificationChannel(_androidChannel);
    await androidPlugin?.requestNotificationsPermission();
  }

  Future<void> _handleForegroundMessage(RemoteMessage message) async {
    _saveMessage(message);

    final notification = message.notification;
    if (notification == null) return;

    await _localNotifications.show(
      id: notification.hashCode,
      title: notification.title,
      body: notification.body,
      notificationDetails: NotificationDetails(
        android: AndroidNotificationDetails(
          _androidChannel.id,
          _androidChannel.name,
          channelDescription: _androidChannel.description,
          importance: Importance.high,
          priority: Priority.high,
          icon: '@mipmap/ic_launcher',
        ),
      ),
    );
  }

  void _saveMessage(RemoteMessage message) {
    _lastMessageTitle = message.notification?.title ?? message.data['title'];
    _lastMessageBody = message.notification?.body ?? message.data['body'];
    notifyListeners();
  }
}

bool get _isFirebaseConfigured {
  if (!_isFcmPlatformSupported) return false;

  try {
    return DefaultFirebaseOptions.currentPlatform.projectId != 'demo-project';
  } catch (_) {
    return false;
  }
}

bool get _isFcmPlatformSupported =>
    !kIsWeb && defaultTargetPlatform == TargetPlatform.android;
