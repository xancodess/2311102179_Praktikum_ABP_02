<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_products(): void
    {
        $this->get(route('products.index'))
            ->assertRedirect(route('login', absolute: false));
    }

    public function test_authenticated_user_can_view_products(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['name' => 'Kopi Susu Cokomi']);

        $this->actingAs($user)
            ->get(route('products.index'))
            ->assertOk()
            ->assertSee('Inventari Produk')
            ->assertSee($product->name);
    }

    public function test_authenticated_user_can_create_product(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('products.store'), [
                'name' => 'Teh Kotak Wowo',
                'sku' => 'WOW-001',
                'category' => 'Minuman',
                'price' => 7500,
                'stock' => 24,
                'supplier' => 'Gudang Mas Wowo',
                'description' => 'Produk minuman stok awal.',
                'is_active' => '1',
            ])
            ->assertRedirect(route('products.index'));

        $this->assertDatabaseHas('products', [
            'name' => 'Teh Kotak Wowo',
            'sku' => 'WOW-001',
            'stock' => 24,
            'is_active' => true,
        ]);
    }

    public function test_authenticated_user_can_update_product(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['sku' => 'WOW-002']);

        $this->actingAs($user)
            ->put(route('products.update', $product), [
                'name' => 'Beras Premium Cokomi',
                'sku' => 'WOW-002',
                'category' => 'Sembako',
                'price' => 82500,
                'stock' => 12,
                'supplier' => 'Mitra Cokomi',
                'description' => null,
            ])
            ->assertRedirect(route('products.index'));

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Beras Premium Cokomi',
            'is_active' => false,
        ]);
    }

    public function test_authenticated_user_can_delete_product(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user)
            ->delete(route('products.destroy', $product))
            ->assertRedirect(route('products.index'));

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }
}
