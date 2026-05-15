<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Buat tabel produk.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->unique();
            $table->string('category');
            $table->text('description')->nullable();
            $table->decimal('price', 15, 2)->default(0);        // Harga jual
            $table->decimal('cost_price', 15, 2)->default(0);   // Harga beli/modal
            $table->integer('stock')->default(0);
            $table->string('unit', 20)->default('pcs');         // Satuan
            $table->integer('min_stock')->default(5);           // Stok minimum (alert)
            $table->boolean('is_active')->default(true);
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Index untuk performa query
            $table->index(['category', 'is_active']);
            $table->index('stock');
        });
    }

    /**
     * Rollback tabel produk.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
