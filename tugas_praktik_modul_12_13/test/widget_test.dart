import 'package:flutter/material.dart';
import 'package:flutter_test/flutter_test.dart';
import 'package:provider/provider.dart';
import 'package:tugas_praktik_modul_12_13/main.dart';
import 'package:tugas_praktik_modul_12_13/providers/todo_provider.dart';
import 'package:tugas_praktik_modul_12_13/services/fcm_service.dart';

void main() {
  testWidgets('adds a task to the todo list', (WidgetTester tester) async {
    await tester.pumpWidget(
      MultiProvider(
        providers: [
          ChangeNotifierProvider(create: (_) => TodoProvider()),
          ChangeNotifierProvider(create: (_) => FcmService()),
        ],
        child: const MyApp(),
      ),
    );

    expect(
      find.text('Belum ada tugas. Tambahkan tugas pertama kamu.'),
      findsOneWidget,
    );

    await tester.enterText(
      find.byKey(const Key('taskField')),
      'Belajar Provider',
    );
    await tester.tap(find.byKey(const Key('addTaskButton')));
    await tester.pump();

    expect(find.text('Belajar Provider'), findsOneWidget);
    expect(find.text('1 tugas tersimpan'), findsOneWidget);
  });
}
