import 'package:flutter/material.dart';
import 'package:flutter_test/flutter_test.dart';

import 'package:tugas_praktik_modul_15/main.dart';

void main() {
  testWidgets('can add and remove products from cart', (
    WidgetTester tester,
  ) async {
    await tester.pumpWidget(const ProductCartApp());

    expect(find.text('Daftar Produk'), findsOneWidget);
    expect(find.text('0 item'), findsOneWidget);
    expect(find.text('Di keranjang: 0'), findsWidgets);

    await tester.tap(find.widgetWithText(FilledButton, 'Tambah').first);
    await tester.pump();

    expect(find.text('1 item'), findsOneWidget);
    expect(find.text('Di keranjang: 1'), findsOneWidget);

    await tester.tap(find.widgetWithText(OutlinedButton, 'Hapus').first);
    await tester.pump();

    expect(find.text('0 item'), findsOneWidget);
    expect(find.text('Di keranjang: 0'), findsWidgets);
  });
}
