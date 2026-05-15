<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'sku',
        'category',
        'description',
        'price',
        'cost_price',
        'stock',
        'unit',
        'min_stock',
        'is_active',
        'image',
    ];

    protected $casts = [
        'price'      => 'decimal:2',
        'cost_price' => 'decimal:2',
        'stock'      => 'integer',
        'min_stock'  => 'integer',
        'is_active'  => 'boolean',
    ];

    /**
     * Scope untuk produk aktif.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Cek apakah stok di bawah minimum.
     */
    public function isLowStock(): bool
    {
        return $this->stock <= $this->min_stock;
    }

    /**
     * Hitung margin keuntungan dalam persen.
     */
    public function getProfitMarginAttribute(): float
    {
        if ($this->cost_price <= 0) return 0;
        return round((($this->price - $this->cost_price) / $this->price) * 100, 1);
    }

    /**
     * Format harga jual ke rupiah.
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Format harga beli ke rupiah.
     */
    public function getFormattedCostPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->cost_price, 0, ',', '.');
    }

    /**
     * Daftar kategori tersedia.
     */
    public static function categories(): array
    {
        return [
            'Elektronik',
            'Makanan & Minuman',
            'Pakaian',
            'Peralatan Rumah',
            'Kosmetik & Kesehatan',
            'Otomotif',
            'Olahraga',
            'Buku & ATK',
            'Lainnya',
        ];
    }

    /**
     * Daftar satuan unit.
     */
    public static function units(): array
    {
        return ['pcs', 'lusin', 'kodi', 'kg', 'gram', 'liter', 'ml', 'meter', 'roll', 'box', 'pak', 'botol'];
    }
}
