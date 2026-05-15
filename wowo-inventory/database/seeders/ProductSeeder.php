<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk mengisi data produk awal.
     *
     * Menghasilkan 60 produk dengan distribusi:
     * - 45 produk normal (aktif/non-aktif)
     * - 8 produk dengan stok menipis
     * - 7 produk tidak aktif
     */
    public function run(): void
    {
        $this->command->info('  Menanam data produk...');

        // Produk reguler
        Product::factory(45)->create();

        // Produk stok menipis (warning)
        Product::factory(8)->lowStock()->create();

        // Produk nonaktif
        Product::factory(7)->inactive()->create();

        $total = Product::count();
        $this->command->info("  ✓ {$total} produk berhasil dibuat.");
    }
}
