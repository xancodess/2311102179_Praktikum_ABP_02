<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['Minuman', 'Makanan Ringan', 'Sembako', 'Perawatan', 'Peralatan'];
        $name = $this->faker->randomElement([
            'Kopi Susu Botol',
            'Teh Melati Kotak',
            'Keripik Singkong',
            'Beras Premium',
            'Gula Pasir',
            'Sabun Cuci',
            'Mi Instan',
            'Susu UHT',
            'Kecap Manis',
            'Tisu Dapur',
        ]);

        return [
            'name' => $name.' '.$this->faker->randomElement(['Cokomi', 'Wowo', 'Mantap', 'Hemat']),
            'sku' => strtoupper($this->faker->unique()->bothify('WOW-###??')),
            'category' => $this->faker->randomElement($categories),
            'price' => $this->faker->numberBetween(5000, 250000),
            'stock' => $this->faker->numberBetween(0, 120),
            'supplier' => $this->faker->randomElement(['Gudang Mas Wowo', 'Mitra Cokomi', 'Pasar Pagi Sentosa']),
            'description' => $this->faker->sentence(10),
            'is_active' => $this->faker->boolean(85),
        ];
    }
}
