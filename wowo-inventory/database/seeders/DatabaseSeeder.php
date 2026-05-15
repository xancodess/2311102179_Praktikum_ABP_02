<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed database aplikasi Inventori Toko Wowo.
     *
     * Akun default yang dibuat:
     * - Mas Wowo (Admin)  : wowo@toko.com  / password123
     * - Pak Cokomi (Staff): cokomi@toko.com / password123
     */
    public function run(): void
    {
        $this->command->info('🌱 Menanam data awal Inventori Toko Wowo...');
        $this->command->newLine();

        // ── Buat akun default ──────────────────────────────
        $this->command->info('  Membuat akun pengguna...');

        User::factory()->create([
            'name'     => 'Mas Wowo',
            'email'    => 'wowo@toko.com',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name'     => 'Pak Cokomi',
            'email'    => 'cokomi@toko.com',
            'password' => Hash::make('password123'),
        ]);

        $this->command->info('  ✓ 2 akun berhasil dibuat.');
        $this->command->newLine();

        // ── Seed produk ────────────────────────────────────
        $this->call(ProductSeeder::class);

        $this->command->newLine();
        $this->command->info('✅ Seeding selesai!');
        $this->command->newLine();
        $this->command->table(
            ['Akun', 'Email', 'Password'],
            [
                ['Mas Wowo',   'wowo@toko.com',   'password123'],
                ['Pak Cokomi', 'cokomi@toko.com', 'password123'],
            ]
        );
    }
}
