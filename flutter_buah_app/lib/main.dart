import 'package:flutter/material.dart';

void main() {
  runApp(const BuahApp());
}

class BuahApp extends StatelessWidget {
  const BuahApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Toko Buah Segar',
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
        colorScheme: ColorScheme.fromSeed(seedColor: const Color(0xFF4CAF50)),
        useMaterial3: true,
        fontFamily: 'Roboto',
      ),
      home: const HomePage(),
    );
  }
}

// ─────────────────────────────────────────
// Data model sederhana untuk buah
// ─────────────────────────────────────────
class Buah {
  final String nama;
  final String emoji;
  final String harga;
  final Color warna;

  const Buah({
    required this.nama,
    required this.emoji,
    required this.harga,
    required this.warna,
  });
}

// ─────────────────────────────────────────
// Data array untuk ListView.builder & separated
// ─────────────────────────────────────────
const List<Buah> daftarBuah = [
  Buah(nama: 'Apel Merah',   emoji: '🍎', harga: 'Rp 15.000/kg',  warna: Color(0xFFE53935)),
  Buah(nama: 'Pisang',       emoji: '🍌', harga: 'Rp 8.000/sisir', warna: Color(0xFFFDD835)),
  Buah(nama: 'Mangga',       emoji: '🥭', harga: 'Rp 20.000/kg',  warna: Color(0xFFFF8F00)),
  Buah(nama: 'Semangka',     emoji: '🍉', harga: 'Rp 12.000/kg',  warna: Color(0xFF43A047)),
  Buah(nama: 'Anggur',       emoji: '🍇', harga: 'Rp 35.000/kg',  warna: Color(0xFF7B1FA2)),
  Buah(nama: 'Stroberi',     emoji: '🍓', harga: 'Rp 25.000/cup', warna: Color(0xFFD81B60)),
  Buah(nama: 'Jeruk',        emoji: '🍊', harga: 'Rp 10.000/kg',  warna: Color(0xFFF4511E)),
  Buah(nama: 'Melon',        emoji: '🍈', harga: 'Rp 18.000/buah',warna: Color(0xFF558B2F)),
];

// ─────────────────────────────────────────
// HOME PAGE — satu halaman scrollable
// ─────────────────────────────────────────
class HomePage extends StatelessWidget {
  const HomePage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF1F8E9),
      appBar: AppBar(
        backgroundColor: const Color(0xFF2E7D32),
        title: const Text(
          '🛒 Toko Buah Segar',
          style: TextStyle(color: Colors.white, fontWeight: FontWeight.bold),
        ),
        centerTitle: true,
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // ── 1. CONTAINER ──────────────────────────
            _SectionLabel(label: '1. Container'),
            const ContainerSection(),
            const SizedBox(height: 24),

            // ── 2. STACK ──────────────────────────────
            _SectionLabel(label: '2. Stack'),
            const StackSection(),
            const SizedBox(height: 24),

            // ── 3. GRIDVIEW ───────────────────────────
            _SectionLabel(label: '3. GridView'),
            const GridViewSection(),
            const SizedBox(height: 24),

            // ── 4. LISTVIEW ───────────────────────────
            _SectionLabel(label: '4. ListView'),
            const ListViewSection(),
            const SizedBox(height: 24),

            // ── 5. LISTVIEW.BUILDER ───────────────────
            _SectionLabel(label: '5. ListView.builder'),
            const ListViewBuilderSection(),
            const SizedBox(height: 24),

            // ── 6. LISTVIEW.SEPARATED ─────────────────
            _SectionLabel(label: '6. ListView.separated'),
            const ListViewSeparatedSection(),
            const SizedBox(height: 32),
          ],
        ),
      ),
    );
  }
}

// ─────────────────────────────────────────
// Label tiap section
// ─────────────────────────────────────────
class _SectionLabel extends StatelessWidget {
  final String label;
  const _SectionLabel({required this.label});

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 8),
      child: Row(
        children: [
          Container(
            width: 4,
            height: 20,
            decoration: BoxDecoration(
              color: const Color(0xFF2E7D32),
              borderRadius: BorderRadius.circular(2),
            ),
          ),
          const SizedBox(width: 8),
          Text(
            label,
            style: const TextStyle(
              fontSize: 16,
              fontWeight: FontWeight.bold,
              color: Color(0xFF1B5E20),
            ),
          ),
        ],
      ),
    );
  }
}

// ─────────────────────────────────────────
// 1. CONTAINER
// Menampilkan kotak berwarna dengan teks,
// padding, margin, dan border radius.
// ─────────────────────────────────────────
class ContainerSection extends StatelessWidget {
  const ContainerSection({super.key});

  @override
  Widget build(BuildContext context) {
    return Row(
      children: [
        // Container utama — banner promo
        Expanded(
          child: Container(
            height: 100,
            padding: const EdgeInsets.all(16),
            decoration: BoxDecoration(
              gradient: const LinearGradient(
                colors: [Color(0xFF2E7D32), Color(0xFF81C784)],
                begin: Alignment.topLeft,
                end: Alignment.bottomRight,
              ),
              borderRadius: BorderRadius.circular(16),
            ),
            child: const Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Text('🎉 Promo Hari Ini!',
                    style: TextStyle(color: Colors.white, fontWeight: FontWeight.bold, fontSize: 16)),
                SizedBox(height: 4),
                Text('Diskon 20% semua buah tropis',
                    style: TextStyle(color: Colors.white70, fontSize: 12)),
              ],
            ),
          ),
        ),
        const SizedBox(width: 12),
        // Container kecil — info poin
        Container(
          width: 90,
          height: 100,
          decoration: BoxDecoration(
            color: const Color(0xFFFFF9C4),
            borderRadius: BorderRadius.circular(16),
            border: Border.all(color: const Color(0xFFFDD835), width: 2),
          ),
          child: const Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Text('⭐', style: TextStyle(fontSize: 28)),
              Text('Poin: 120',
                  style: TextStyle(fontSize: 11, fontWeight: FontWeight.bold, color: Color(0xFFF57F17))),
            ],
          ),
        ),
      ],
    );
  }
}

// ─────────────────────────────────────────
// 2. STACK
// Widget bertumpuk: gambar/kotak latar +
// teks di atasnya + badge pojok.
// ─────────────────────────────────────────
class StackSection extends StatelessWidget {
  const StackSection({super.key});

  @override
  Widget build(BuildContext context) {
    return SizedBox(
      height: 140,
      child: Stack(
        children: [
          // Layer 1 — latar belakang kotak hijau
          Container(
            width: double.infinity,
            height: 140,
            decoration: BoxDecoration(
              color: const Color(0xFFA5D6A7),
              borderRadius: BorderRadius.circular(16),
            ),
          ),

          // Layer 2 — lingkaran dekoratif kiri
          Positioned(
            left: -20,
            top: -20,
            child: Container(
              width: 120,
              height: 120,
              decoration: BoxDecoration(
                color: const Color(0xFF81C784).withOpacity(0.5),
                shape: BoxShape.circle,
              ),
            ),
          ),

          // Layer 3 — lingkaran dekoratif kanan
          Positioned(
            right: -30,
            bottom: -30,
            child: Container(
              width: 150,
              height: 150,
              decoration: BoxDecoration(
                color: const Color(0xFF4CAF50).withOpacity(0.3),
                shape: BoxShape.circle,
              ),
            ),
          ),

          // Layer 4 — teks utama di tengah
          const Positioned.fill(
            child: Center(
              child: Column(
                mainAxisSize: MainAxisSize.min,
                children: [
                  Text('🍃', style: TextStyle(fontSize: 36)),
                  Text(
                    'Buah Segar Pilihan',
                    style: TextStyle(
                      fontSize: 18,
                      fontWeight: FontWeight.bold,
                      color: Color(0xFF1B5E20),
                    ),
                  ),
                  Text(
                    'Langsung dari kebun',
                    style: TextStyle(fontSize: 13, color: Color(0xFF388E3C)),
                  ),
                ],
              ),
            ),
          ),

          // Layer 5 — badge "BARU" di pojok kanan atas
          Positioned(
            top: 12,
            right: 12,
            child: Container(
              padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
              decoration: BoxDecoration(
                color: const Color(0xFFE53935),
                borderRadius: BorderRadius.circular(20),
              ),
              child: const Text(
                'BARU',
                style: TextStyle(color: Colors.white, fontSize: 11, fontWeight: FontWeight.bold),
              ),
            ),
          ),
        ],
      ),
    );
  }
}

// ─────────────────────────────────────────
// 3. GRIDVIEW
// Menampilkan 6+ item buah dalam grid 3 kolom.
// Menggunakan GridView dengan shrinkWrap + NeverScrollableScrollPhysics
// agar bisa di dalam SingleChildScrollView.
// ─────────────────────────────────────────
class GridViewSection extends StatelessWidget {
  const GridViewSection({super.key});

  // 6 item untuk grid
  static const List<Map<String, dynamic>> gridItems = [
    {'emoji': '🍎', 'nama': 'Apel',     'warna': Color(0xFFFFCDD2)},
    {'emoji': '🍌', 'nama': 'Pisang',   'warna': Color(0xFFFFF9C4)},
    {'emoji': '🥭', 'nama': 'Mangga',   'warna': Color(0xFFFFE0B2)},
    {'emoji': '🍉', 'nama': 'Semangka', 'warna': Color(0xFFC8E6C9)},
    {'emoji': '🍇', 'nama': 'Anggur',   'warna': Color(0xFFE1BEE7)},
    {'emoji': '🍓', 'nama': 'Stroberi', 'warna': Color(0xFFFCE4EC)},
  ];

  @override
  Widget build(BuildContext context) {
    return GridView.count(
      crossAxisCount: 3,
      shrinkWrap: true,
      physics: const NeverScrollableScrollPhysics(),
      crossAxisSpacing: 10,
      mainAxisSpacing: 10,
      childAspectRatio: 1.0,
      children: gridItems.map((item) {
        return Container(
          decoration: BoxDecoration(
            color: item['warna'] as Color,
            borderRadius: BorderRadius.circular(12),
          ),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Text(item['emoji'] as String, style: const TextStyle(fontSize: 32)),
              const SizedBox(height: 6),
              Text(
                item['nama'] as String,
                style: const TextStyle(fontSize: 12, fontWeight: FontWeight.w600),
              ),
            ],
          ),
        );
      }).toList(),
    );
  }
}

// ─────────────────────────────────────────
// 4. LISTVIEW
// List statis 3 item (A, B, C) — kategori buah.
// ─────────────────────────────────────────
class ListViewSection extends StatelessWidget {
  const ListViewSection({super.key});

  @override
  Widget build(BuildContext context) {
    return SizedBox(
      height: 160,
      child: ListView(
        // ListView horizontal sebagai variasi tampilan
        scrollDirection: Axis.horizontal,
        children: const [
          _KategoriCard(label: 'A', judul: 'Buah Impor',  emoji: '✈️', warna: Color(0xFFBBDEFB)),
          SizedBox(width: 12),
          _KategoriCard(label: 'B', judul: 'Buah Lokal',  emoji: '🌿', warna: Color(0xFFC8E6C9)),
          SizedBox(width: 12),
          _KategoriCard(label: 'C', judul: 'Buah Musiman',emoji: '📅', warna: Color(0xFFFFE0B2)),
        ],
      ),
    );
  }
}

class _KategoriCard extends StatelessWidget {
  final String label;
  final String judul;
  final String emoji;
  final Color warna;

  const _KategoriCard({
    required this.label,
    required this.judul,
    required this.emoji,
    required this.warna,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      width: 130,
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: warna,
        borderRadius: BorderRadius.circular(16),
      ),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          CircleAvatar(
            backgroundColor: Colors.white.withOpacity(0.7),
            radius: 24,
            child: Text(label,
                style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 20)),
          ),
          const SizedBox(height: 10),
          Text(emoji, style: const TextStyle(fontSize: 22)),
          const SizedBox(height: 4),
          Text(judul,
              textAlign: TextAlign.center,
              style: const TextStyle(fontSize: 12, fontWeight: FontWeight.w600)),
        ],
      ),
    );
  }
}

// ─────────────────────────────────────────
// 5. LISTVIEW.BUILDER
// Membuat list secara dinamis dari array daftarBuah.
// Efisien untuk data berjumlah banyak.
// ─────────────────────────────────────────
class ListViewBuilderSection extends StatelessWidget {
  const ListViewBuilderSection({super.key});

  @override
  Widget build(BuildContext context) {
    return SizedBox(
      height: 220,
      child: ListView.builder(
        itemCount: daftarBuah.length,
        itemBuilder: (context, index) {
          final buah = daftarBuah[index];
          return Container(
            margin: const EdgeInsets.only(bottom: 8),
            padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 10),
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(12),
              boxShadow: [
                BoxShadow(
                  color: Colors.black.withOpacity(0.05),
                  blurRadius: 4,
                  offset: const Offset(0, 2),
                ),
              ],
            ),
            child: Row(
              children: [
                // Nomor urut
                Container(
                  width: 28,
                  height: 28,
                  decoration: BoxDecoration(
                    color: buah.warna.withOpacity(0.15),
                    shape: BoxShape.circle,
                  ),
                  child: Center(
                    child: Text(
                      '${index + 1}',
                      style: TextStyle(
                        fontSize: 12,
                        fontWeight: FontWeight.bold,
                        color: buah.warna,
                      ),
                    ),
                  ),
                ),
                const SizedBox(width: 12),
                Text(buah.emoji, style: const TextStyle(fontSize: 24)),
                const SizedBox(width: 12),
                Expanded(
                  child: Text(
                    buah.nama,
                    style: const TextStyle(fontSize: 14, fontWeight: FontWeight.w600),
                  ),
                ),
                Text(
                  buah.harga,
                  style: TextStyle(
                    fontSize: 12,
                    color: buah.warna,
                    fontWeight: FontWeight.w600,
                  ),
                ),
              ],
            ),
          );
        },
      ),
    );
  }
}

// ─────────────────────────────────────────
// 6. LISTVIEW.SEPARATED
// List dengan garis pembatas antar item.
// Menggunakan separatorBuilder untuk menambahkan Divider.
// ─────────────────────────────────────────
class ListViewSeparatedSection extends StatelessWidget {
  const ListViewSeparatedSection({super.key});

  // Data pesanan untuk section ini
  static const List<Map<String, String>> pesanan = [
    {'nama': '🍎 Apel Merah 2kg',    'status': 'Dikirim',  'total': 'Rp 30.000'},
    {'nama': '🍌 Pisang 1 sisir',    'status': 'Selesai',  'total': 'Rp 8.000'},
    {'nama': '🥭 Mangga Harum 3kg',  'status': 'Diproses', 'total': 'Rp 60.000'},
    {'nama': '🍉 Semangka 1 buah',   'status': 'Selesai',  'total': 'Rp 25.000'},
    {'nama': '🍊 Jeruk Mandarin 2kg','status': 'Dikirim',  'total': 'Rp 20.000'},
  ];

  Color _statusColor(String status) {
    switch (status) {
      case 'Selesai':  return const Color(0xFF2E7D32);
      case 'Dikirim':  return const Color(0xFF1565C0);
      case 'Diproses': return const Color(0xFFF57F17);
      default:         return Colors.grey;
    }
  }

  @override
  Widget build(BuildContext context) {
    return Container(
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.06),
            blurRadius: 8,
            offset: const Offset(0, 2),
          ),
        ],
      ),
      child: ClipRRect(
        borderRadius: BorderRadius.circular(16),
        child: SizedBox(
          height: 280,
          child: ListView.separated(
            itemCount: pesanan.length,
            separatorBuilder: (context, index) => const Divider(
              height: 1,
              thickness: 1,
              indent: 16,
              endIndent: 16,
              color: Color(0xFFE8F5E9),
            ),
            itemBuilder: (context, index) {
              final item = pesanan[index];
              return Padding(
                padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
                child: Row(
                  children: [
                    Expanded(
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text(
                            item['nama']!,
                            style: const TextStyle(fontSize: 14, fontWeight: FontWeight.w600),
                          ),
                          const SizedBox(height: 2),
                          Text(
                            item['total']!,
                            style: const TextStyle(fontSize: 12, color: Colors.grey),
                          ),
                        ],
                      ),
                    ),
                    // Badge status
                    Container(
                      padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                      decoration: BoxDecoration(
                        color: _statusColor(item['status']!).withOpacity(0.1),
                        borderRadius: BorderRadius.circular(20),
                        border: Border.all(
                          color: _statusColor(item['status']!).withOpacity(0.3),
                        ),
                      ),
                      child: Text(
                        item['status']!,
                        style: TextStyle(
                          fontSize: 11,
                          fontWeight: FontWeight.w600,
                          color: _statusColor(item['status']!),
                        ),
                      ),
                    ),
                  ],
                ),
              );
            },
          ),
        ),
      ),
    );
  }
}
