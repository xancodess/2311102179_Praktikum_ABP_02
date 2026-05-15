# 📦 Inventori Toko Wowo
> Sistem Manajemen Inventari Digital untuk Toko Mas Wowo & Pak Cokomi

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat&logo=laravel&logoColor=white)](https://laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38BDF8?style=flat&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-77C1D2?style=flat&logo=alpine.js&logoColor=white)](https://alpinejs.dev)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php&logoColor=white)](https://php.net)

---

## 🧭 Tentang Proyek

**Inventori Toko Wowo** adalah sistem manajemen inventari berbasis web yang dibangun untuk membantu **Mas Wowo** dan **Pak Cokomi** dalam mengelola stok barang toko secara efisien dan terorganisir.

Sistem ini menyediakan:
- 🔐 Autentikasi pengguna (Laravel Breeze)
- 📊 Dashboard ringkasan kondisi inventari real-time
- 📦 CRUD produk lengkap dengan DataTable interaktif
- ⚠️ Notifikasi otomatis untuk stok menipis
- 💰 Kalkulasi margin keuntungan otomatis
- 🌱 Database seeder dengan data produk realistis

---

## 🖥️ Tampilan Aplikasi

| Halaman | Deskripsi |
|---|---|
| **Login** | Halaman masuk dengan hint akun demo |
| **Dashboard** | Statistik inventari, stok menipis, sebaran kategori |
| **Daftar Produk** | DataTable dengan search, filter, sort, dan pagination |
| **Tambah Produk** | Form multi-section dengan kalkulasi margin live |
| **Edit Produk** | Form pre-filled dengan info produk existing |
| **Hapus Produk** | Modal konfirmasi sebelum penghapusan |

---

## ⚙️ Persyaratan Sistem

| Komponen | Versi Minimum |
|---|---|
| PHP | 8.2+ |
| Composer | 2.x |
| Node.js | 18+ |
| MySQL | 8.0+ / MariaDB 10.4+ |
| Laravel | 11.x |

---

## 🚀 Instalasi & Setup

### 1. Clone Repository

```bash
git clone https://github.com/username/wowo-inventory.git
cd wowo-inventory
```

### 2. Install Dependensi PHP

```bash
composer install
```

### 3. Install Dependensi Node.js

```bash
npm install
```

### 4. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env` dan sesuaikan konfigurasi database:

```env
APP_NAME="Inventori Toko Wowo"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wowo_inventory
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Buat Database

```sql
CREATE DATABASE wowo_inventory CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Jalankan Migrasi & Seeder

```bash
# Jalankan migrasi + seed data awal
php artisan migrate --seed

# Atau jika ingin reset total
php artisan migrate:fresh --seed
```

Output seeder akan menampilkan akun yang dibuat:

```
✅ Seeding selesai!

+-----------+------------------+-------------+
| Akun      | Email            | Password    |
+-----------+------------------+-------------+
| Mas Wowo  | wowo@toko.com    | password123 |
| Pak Cokomi| cokomi@toko.com  | password123 |
+-----------+------------------+-------------+
```

### 7. Build Assets

```bash
# Development (dengan hot-reload)
npm run dev

# Production (minified)
npm run build
```

### 8. Jalankan Server

```bash
php artisan serve
```

Aplikasi tersedia di: **http://localhost:8000**

---

## 👤 Akun Default

Setelah menjalankan seeder, dua akun akan tersedia:

| Nama | Email | Password | Peran |
|---|---|---|---|
| Mas Wowo | `wowo@toko.com` | `password123` | Pemilik Toko |
| Pak Cokomi | `cokomi@toko.com` | `password123` | Staff Toko |

> ⚠️ **Penting:** Ganti password default sebelum deploy ke production!

---

## 🗂️ Struktur Proyek

```
wowo-inventory/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                    # Controller autentikasi (Breeze)
│   │   │   │   ├── AuthenticatedSessionController.php
│   │   │   │   ├── RegisteredUserController.php
│   │   │   │   └── ...
│   │   │   ├── DashboardController.php  # Dashboard & statistik
│   │   │   ├── ProductController.php    # CRUD produk
│   │   │   └── ProfileController.php   # Manajemen profil
│   │   └── Requests/
│   │       ├── Auth/LoginRequest.php
│   │       └── ProfileUpdateRequest.php
│   └── Models/
│       ├── Product.php                  # Model produk + accessors
│       └── User.php                     # Model pengguna
│
├── database/
│   ├── factories/
│   │   ├── ProductFactory.php           # 7 kategori, data realistis
│   │   └── UserFactory.php
│   ├── migrations/
│   │   ├── ..._create_users_table.php
│   │   └── ..._create_products_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php           # Entry point seeder
│       └── ProductSeeder.php            # 60 produk (45 normal, 8 low stock, 7 inactive)
│
├── resources/
│   ├── css/
│   │   └── app.css                      # Tailwind + custom components
│   ├── js/
│   │   ├── app.js                       # Alpine.js setup
│   │   └── bootstrap.js
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php            # Layout utama (sidebar + content)
│       │   └── auth.blade.php           # Layout halaman auth
│       ├── auth/
│       │   ├── login.blade.php
│       │   ├── register.blade.php
│       │   └── forgot-password.blade.php
│       ├── products/
│       │   ├── index.blade.php          # DataTable + delete modal
│       │   ├── create.blade.php         # Form tambah produk
│       │   ├── edit.blade.php           # Form edit produk
│       │   └── _form.blade.php          # Shared form partial
│       ├── profile/
│       │   └── edit.blade.php
│       └── dashboard.blade.php
│
├── routes/
│   ├── web.php                          # Route utama
│   ├── auth.php                         # Route autentikasi
│   └── console.php
│
├── tailwind.config.js                   # Konfigurasi Tailwind
├── vite.config.js                       # Konfigurasi Vite
└── README.md
```

---

## 🔌 Fitur Detail

### 📦 Manajemen Produk (CRUD)

| Operasi | Route | Method |
|---|---|---|
| Daftar produk | `GET /products` | `ProductController@index` |
| Form tambah | `GET /products/create` | `ProductController@create` |
| Simpan produk | `POST /products` | `ProductController@store` |
| Form edit | `GET /products/{id}/edit` | `ProductController@edit` |
| Update produk | `PUT /products/{id}` | `ProductController@update` |
| Hapus produk | `DELETE /products/{id}` | `ProductController@destroy` |

### 🔍 Filter & Pencarian

DataTable produk mendukung:
- **Search** — Cari berdasarkan nama, SKU, atau kategori
- **Filter Kategori** — Filter per kategori produk
- **Filter Status** — Aktif / Nonaktif / Semua
- **Sortir Kolom** — Klik header kolom (Nama, Harga, Stok)
- **Pagination** — 10 produk per halaman

### 🏷️ Fitur SKU Otomatis

SKU di-generate otomatis saat produk baru dibuat:

```
Format: [KAT]-[NAMA]-[RAND]
Contoh: ELE-LAMP-0042
        MAK-MIEINS-7391
```

### 📊 Kalkulasi Margin Live

Form produk menampilkan estimasi margin keuntungan secara real-time saat user mengisi harga beli dan harga jual:

- 🔴 **< 15%** — Margin rendah
- 🟡 **15–30%** — Margin menengah
- 🟢 **≥ 30%** — Margin optimal

### ⚠️ Alert Stok Menipis

Sistem otomatis memberi tanda visual ketika `stok ≤ min_stok`:
- Badge kuning di kolom stok pada DataTable
- Widget "Stok Menipis" di dashboard
- Counter di stat card dashboard

---

## 🌱 Data Seeder

Seeder menghasilkan **60 produk** dengan distribusi realistis:

| Tipe | Jumlah | Keterangan |
|---|---|---|
| Produk Normal | 45 | Campuran aktif & nonaktif |
| Stok Menipis | 8 | Stok ≤ 3, min_stok = 5 |
| Nonaktif | 7 | `is_active = false` |
| **Total** | **60** | |

Kategori produk yang tersedia:
- Elektronik
- Makanan & Minuman
- Pakaian
- Peralatan Rumah
- Kosmetik & Kesehatan
- Buku & ATK
- Olahraga

---

## 🗄️ Skema Database

### Tabel `products`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint | Primary key |
| `name` | varchar(255) | Nama produk |
| `sku` | varchar(255) | Kode unik produk |
| `category` | varchar(100) | Kategori produk |
| `description` | text (null) | Deskripsi opsional |
| `price` | decimal(15,2) | Harga jual |
| `cost_price` | decimal(15,2) | Harga beli/modal |
| `stock` | integer | Jumlah stok |
| `unit` | varchar(20) | Satuan (pcs, kg, dll) |
| `min_stock` | integer | Batas minimum stok |
| `is_active` | boolean | Status produk |
| `image` | varchar (null) | Path gambar (opsional) |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |
| `deleted_at` | timestamp (null) | Soft delete |

### Tabel `users`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint | Primary key |
| `name` | varchar(255) | Nama pengguna |
| `email` | varchar(255) | Email unik |
| `password` | varchar(255) | Bcrypt hashed |
| `remember_token` | varchar | Token "ingat saya" |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

---

## 🔒 Keamanan

- Semua route produk dilindungi middleware `auth`
- Password di-hash dengan Bcrypt
- CSRF protection aktif di semua form
- Input validation di semua request
- Soft delete untuk produk (data tidak hilang permanen)
- Rate limiting pada login (5 percobaan / menit)

---

## 🎨 Tech Stack

| Layer | Teknologi |
|---|---|
| Backend | Laravel 11, PHP 8.2+ |
| Auth | Laravel Breeze |
| Frontend | Blade, Tailwind CSS 3, Alpine.js 3 |
| Build Tool | Vite |
| Database | MySQL / MariaDB |
| Font | Syne (display), Plus Jakarta Sans (body) |

---

## 🛠️ Perintah Berguna

```bash
# Reset database + seed ulang
php artisan migrate:fresh --seed

# Buat factory data tambahan
php artisan tinker
>>> App\Models\Product::factory(20)->create()

# Clear cache aplikasi
php artisan optimize:clear

# Cek daftar route
php artisan route:list
```

---

## 📝 Lisensi

Project ini dibuat untuk kebutuhan internal Toko Mas Wowo & Pak Cokomi.

---

*Dibuat dengan ❤️ untuk Mas Wowo & Pak Cokomi — semoga tokonya makin maju!*
