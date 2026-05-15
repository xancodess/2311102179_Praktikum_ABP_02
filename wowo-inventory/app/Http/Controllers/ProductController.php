<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Tampilkan daftar semua produk (DataTable).
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Filter kategori
        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        // Filter status
        if ($request->has('status') && $request->input('status') !== '') {
            $query->where('is_active', $request->input('status') === '1');
        }

        // Sort
        $sortBy    = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $allowedSorts = ['name', 'sku', 'category', 'price', 'stock', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder === 'asc' ? 'asc' : 'desc');
        }

        $products   = $query->paginate(10)->withQueryString();
        $categories = Product::categories();
        $stats = [
            'total'    => Product::count(),
            'active'   => Product::active()->count(),
            'low_stock'=> Product::whereColumn('stock', '<=', 'min_stock')->count(),
            'inactive' => Product::where('is_active', false)->count(),
        ];

        return view('products.index', compact('products', 'categories', 'stats'));
    }

    /**
     * Tampilkan form tambah produk baru.
     */
    public function create()
    {
        $categories = Product::categories();
        $units      = Product::units();
        return view('products.create', compact('categories', 'units'));
    }

    /**
     * Simpan produk baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
            'price'       => 'required|numeric|min:0',
            'cost_price'  => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'unit'        => 'required|string|max:20',
            'min_stock'   => 'required|integer|min:0',
            'is_active'   => 'boolean',
        ]);

        // Auto-generate SKU
        $validated['sku']       = $this->generateSku($validated['category'], $validated['name']);
        $validated['is_active'] = $request->has('is_active');

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', "Produk <strong>{$validated['name']}</strong> berhasil ditambahkan.");
    }

    /**
     * Tampilkan form edit produk.
     */
    public function edit(Product $product)
    {
        $categories = Product::categories();
        $units      = Product::units();
        return view('products.edit', compact('product', 'categories', 'units'));
    }

    /**
     * Update data produk.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
            'price'       => 'required|numeric|min:0',
            'cost_price'  => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'unit'        => 'required|string|max:20',
            'min_stock'   => 'required|integer|min:0',
            'is_active'   => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', "Produk <strong>{$product->name}</strong> berhasil diperbarui.");
    }

    /**
     * Hapus produk (soft delete).
     */
    public function destroy(Product $product)
    {
        $name = $product->name;
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', "Produk <strong>{$name}</strong> berhasil dihapus.");
    }

    /**
     * Generate SKU otomatis dari kategori dan nama produk.
     */
    private function generateSku(string $category, string $name): string
    {
        $prefix = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $category), 0, 3));
        $suffix = strtoupper(substr(preg_replace('/[^a-zA-Z0-9]/', '', $name), 0, 4));
        $rand   = str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT);
        return "{$prefix}-{$suffix}-{$rand}";
    }
}
