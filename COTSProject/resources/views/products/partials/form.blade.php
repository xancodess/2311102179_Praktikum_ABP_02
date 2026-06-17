<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="grid gap-6 sm:grid-cols-2">
        <div>
            <x-input-label for="name" value="Nama Produk" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $product->name)" required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="sku" value="SKU" />
            <x-text-input id="sku" name="sku" type="text" class="mt-1 block w-full" :value="old('sku', $product->sku)" required />
            <x-input-error class="mt-2" :messages="$errors->get('sku')" />
        </div>

        <div>
            <x-input-label for="category" value="Kategori" />
            <x-text-input id="category" name="category" type="text" class="mt-1 block w-full" :value="old('category', $product->category)" required />
            <x-input-error class="mt-2" :messages="$errors->get('category')" />
        </div>

        <div>
            <x-input-label for="supplier" value="Supplier" />
            <x-text-input id="supplier" name="supplier" type="text" class="mt-1 block w-full" :value="old('supplier', $product->supplier)" />
            <x-input-error class="mt-2" :messages="$errors->get('supplier')" />
        </div>

        <div>
            <x-input-label for="price" value="Harga" />
            <x-text-input id="price" name="price" type="number" min="0" step="100" class="mt-1 block w-full" :value="old('price', $product->price)" required />
            <x-input-error class="mt-2" :messages="$errors->get('price')" />
        </div>

        <div>
            <x-input-label for="stock" value="Stok" />
            <x-text-input id="stock" name="stock" type="number" min="0" step="1" class="mt-1 block w-full" :value="old('stock', $product->stock)" required />
            <x-input-error class="mt-2" :messages="$errors->get('stock')" />
        </div>
    </div>

    <div>
        <x-input-label for="description" value="Deskripsi" />
        <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $product->description) }}</textarea>
        <x-input-error class="mt-2" :messages="$errors->get('description')" />
    </div>

    <label for="is_active" class="flex items-center gap-3">
        <input id="is_active" name="is_active" type="checkbox" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" @checked(old('is_active', $product->is_active ?? true))>
        <span class="text-sm font-medium text-gray-700">Produk aktif dan bisa dijual</span>
    </label>

    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('products.index') }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            Batal
        </a>
        <x-primary-button>
            {{ $button }}
        </x-primary-button>
    </div>
</form>
