<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::query()
            ->latest()
            ->paginate(10);

        return view('products.index', [
            'products' => $products,
            'activeProducts' => Product::where('is_active', true)->count(),
            'totalStock' => Product::sum('stock'),
        ]);
    }

    public function create(): View
    {
        return view('products.create', [
            'product' => new Product(['is_active' => true]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Product::create($this->validatedProduct($request));

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan ke inventari.');
    }

    public function show(Product $product): RedirectResponse
    {
        return redirect()->route('products.edit', $product);
    }

    public function edit(Product $product): View
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $product->update($this->validatedProduct($request, $product));

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil dihapus dari inventari.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedProduct(Request $request, ?Product $product = null): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sku' => [
                'required',
                'string',
                'max:50',
                Rule::unique('products', 'sku')->ignore($product),
            ],
            'category' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
            'stock' => ['required', 'integer', 'min:0', 'max:999999'],
            'supplier' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }
}
