<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">{{ $product->sku }}</p>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Edit {{ $product->name }}
                </h2>
            </div>
            <a href="{{ route('products.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                Kembali ke inventari
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-md border border-gray-200 bg-white p-6 shadow-sm">
                @include('products.partials.form', [
                    'action' => route('products.update', $product),
                    'method' => 'PUT',
                    'button' => 'Perbarui Produk',
                ])
            </div>
        </div>
    </div>
</x-app-layout>
