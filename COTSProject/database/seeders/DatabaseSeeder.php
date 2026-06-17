<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Pak Cokomi',
            'email' => 'cokomi@example.com',
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'Mas Wowo',
            'email' => 'wowo@example.com',
            'password' => Hash::make('password'),
        ]);

        \App\Models\Product::factory(18)->create();
    }
}
