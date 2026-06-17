# Inventari Toko Cokomi x Wowo

Project Laravel untuk mengelola inventari produk toko milik Pak Cokomi dan Mas Wowo. Aplikasi memakai Laravel Breeze untuk sistem login, lalu menyediakan CRUD produk lengkap dengan data table, form create, form edit, dan modal konfirmasi hapus.

## Fitur

- Login, register, logout, dan profile menggunakan Laravel Breeze.
- CRUD produk dengan field nama, SKU, kategori, harga, stok, supplier, deskripsi, dan status aktif.
- Halaman data table produk dengan ringkasan total produk, produk aktif, dan total stok.
- Form create dan edit dengan validasi server-side Laravel.
- Modal konfirmasi sebelum produk dihapus.
- Factory dan seeder untuk akun demo serta data produk awal.
- Test feature untuk proteksi login dan CRUD produk.

## Teknologi

- Laravel 13
- Laravel Breeze
- Blade
- Tailwind CSS
- SQLite

## Instalasi

Jalankan perintah berikut dari root project.

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan serve
```

Jika memakai Laragon dan `php` belum masuk PATH, gunakan PHP dari folder Laragon, misalnya:

```bash
C:\laragon\bin\php\php-8.3.26-Win32-vs16-x64\php.exe artisan migrate --seed
```

## Akun Demo

Seeder membuat dua akun berikut:

| Nama | Email | Password |
| --- | --- | --- |
| Pak Cokomi | cokomi@example.com | password |
| Mas Wowo | wowo@example.com | password |

## Alur Penggunaan

1. Buka aplikasi di browser.
2. Login memakai salah satu akun demo atau register akun baru.
3. Masuk ke menu `Inventari Produk`.
4. Tambah produk melalui tombol `Tambah Produk`.
5. Edit produk dari kolom aksi.
6. Hapus produk melalui tombol `Hapus`, lalu konfirmasi pada modal.

## Struktur Penting

- `app/Models/Product.php` berisi model produk dan mass assignment.
- `app/Http/Controllers/ProductController.php` berisi logic CRUD dan validasi.
- `database/migrations/*_create_products_table.php` berisi struktur tabel produk.
- `database/factories/ProductFactory.php` berisi generator data produk dummy.
- `database/seeders/DatabaseSeeder.php` berisi akun demo dan produk awal.
- `resources/views/products` berisi halaman data table, create, edit, dan partial form.
- `routes/web.php` berisi route Breeze dan route resource produk yang dilindungi login.

## Testing

```bash
php artisan test
```

Test utama ada di `tests/Feature/ProductManagementTest.php`.
