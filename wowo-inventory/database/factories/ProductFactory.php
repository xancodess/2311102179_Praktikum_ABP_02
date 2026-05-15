<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Dataset produk realistis untuk toko serba ada.
     */
    private array $productData = [
        'Elektronik' => [
            ['Lampu LED 10W Philips', 'pcs'],
            ['Kabel USB-C 1 Meter', 'pcs'],
            ['Baterai AA Alkaline Energizer', 'pak'],
            ['Colokan Listrik 3 Lubang', 'pcs'],
            ['Adaptor Power 5V 2A', 'pcs'],
            ['Headphone Bluetooth Generic', 'pcs'],
            ['Memory Card 32GB Class 10', 'pcs'],
            ['Flashdisk 64GB USB 3.0', 'pcs'],
        ],
        'Makanan & Minuman' => [
            ['Mie Instan Goreng', 'pak'],
            ['Kopi Sachet Kapal Api', 'pak'],
            ['Gula Pasir 1kg', 'kg'],
            ['Minyak Goreng Bimoli 2L', 'botol'],
            ['Teh Celup Sariwangi', 'pak'],
            ['Snack Chitato Original', 'pcs'],
            ['Air Mineral Aqua 600ml', 'pcs'],
            ['Susu UHT Full Cream 200ml', 'pcs'],
            ['Beras Premium 5kg', 'pak'],
            ['Kecap Manis Bango 135ml', 'botol'],
        ],
        'Pakaian' => [
            ['Kaos Polos Cotton Combed 30s', 'pcs'],
            ['Celana Cargo Pendek Pria', 'pcs'],
            ['Sandal Jepit Swallow', 'pcs'],
            ['Kaos Kaki Sport Polos', 'pcs'],
            ['Topi Baseball Polos', 'pcs'],
        ],
        'Peralatan Rumah' => [
            ['Sapu Lidi Ijuk', 'pcs'],
            ['Ember Plastik 20L', 'pcs'],
            ['Sabun Cuci Piring Sunlight', 'botol'],
            ['Pel Lantai Gagang Panjang', 'pcs'],
            ['Tempat Sampah 20L', 'pcs'],
            ['Lap Microfiber', 'pcs'],
        ],
        'Kosmetik & Kesehatan' => [
            ['Sabun Mandi Lifebuoy', 'pcs'],
            ['Shampoo Clear Anti Ketombe', 'botol'],
            ['Pasta Gigi Pepsodent 190gr', 'pcs'],
            ['Masker Medis 3 Ply', 'pak'],
            ['Hand Sanitizer 100ml', 'botol'],
            ['Vitamin C 500mg', 'pak'],
        ],
        'Buku & ATK' => [
            ['Bolpoin Pilot G2 Hitam', 'pcs'],
            ['Buku Tulis 58 lembar', 'pcs'],
            ['Staples Kenko', 'pcs'],
            ['Penggaris 30cm', 'pcs'],
            ['Spidol Snowman Hitam', 'pcs'],
        ],
        'Olahraga' => [
            ['Bola Futsal Mikasa', 'pcs'],
            ['Tali Skipping Lompat', 'pcs'],
            ['Sarung Tangan Tinju', 'pasang'],
        ],
    ];

    public function definition(): array
    {
        $category  = $this->faker->randomElement(array_keys($this->productData));
        $products  = $this->productData[$category];
        [$name, $unit] = $this->faker->randomElement($products);

        $costPrice = $this->faker->randomFloat(0, 1000, 500000);
        $margin    = $this->faker->randomFloat(2, 0.1, 0.6); // 10%-60% margin
        $price     = round($costPrice * (1 + $margin), -2);  // Bulatkan ke ratusan

        $stock    = $this->faker->numberBetween(0, 500);
        $minStock = $this->faker->numberBetween(3, 20);

        $prefix = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $category), 0, 3));
        $suffix = strtoupper(substr(preg_replace('/[^a-zA-Z0-9]/', '', $name), 0, 4));
        $rand   = str_pad($this->faker->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT);
        $sku    = "{$prefix}-{$suffix}-{$rand}";

        return [
            'name'        => $name . ' ' . $this->faker->optional(0.3)->word(),
            'sku'         => $sku,
            'category'    => $category,
            'description' => $this->faker->optional(0.7)->sentence(10),
            'price'       => $price,
            'cost_price'  => $costPrice,
            'stock'       => $stock,
            'unit'        => $unit,
            'min_stock'   => $minStock,
            'is_active'   => $this->faker->boolean(85), // 85% aktif
        ];
    }

    /**
     * State produk stok menipis.
     */
    public function lowStock(): static
    {
        return $this->state(fn () => [
            'stock'     => $this->faker->numberBetween(0, 3),
            'min_stock' => 5,
            'is_active' => true,
        ]);
    }

    /**
     * State produk tidak aktif.
     */
    public function inactive(): static
    {
        return $this->state(fn () => ['is_active' => false]);
    }
}
