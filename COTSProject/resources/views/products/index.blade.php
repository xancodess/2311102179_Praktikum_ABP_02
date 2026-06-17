<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-emerald-700">Toko Mas Wowo</p>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Inventari Produk
                </h2>
            </div>
            <a href="{{ route('products.create') }}" class="inline-flex items-center justify-center rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
                Tambah Produk
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-6 grid gap-4 sm:grid-cols-3">
                <div class="rounded-md border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Total Produk</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $products->total() }}</p>
                </div>
                <div class="rounded-md border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Produk Aktif</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $activeProducts }}</p>
                </div>
                <div class="rounded-md border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Total Stok</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ number_format($totalStock, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="overflow-hidden rounded-md border border-gray-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Produk</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">SKU</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Kategori</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Harga</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Stok</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($products as $product)
                                <tr>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="font-medium text-gray-900">{{ $product->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $product->supplier ?: 'Supplier belum diisi' }}</div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">{{ $product->sku }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">{{ $product->category }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium text-gray-900">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-gray-700">{{ number_format($product->stock, 0, ',', '.') }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold {{ $product->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                                            {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-3">
                                            <a href="{{ route('products.edit', $product) }}" class="text-indigo-700 hover:text-indigo-900">Edit</a>
                                            <button type="button" class="text-red-600 hover:text-red-800" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-product-deletion-{{ $product->id }}')">
                                                Hapus
                                            </button>
                                        </div>

                                        <x-modal name="confirm-product-deletion-{{ $product->id }}" focusable>
                                            <form method="POST" action="{{ route('products.destroy', $product) }}" class="p-6 text-left">
                                                @csrf
                                                @method('DELETE')

                                                <h2 class="text-lg font-medium text-gray-900">
                                                    Hapus {{ $product->name }}?
                                                </h2>

                                                <p class="mt-2 text-sm text-gray-600">
                                                    Produk ini akan dihapus dari inventari toko Mas Wowo. Pastikan Pak Cokomi tidak sedang memasukkannya ke daftar belanja.
                                                </p>

                                                <div class="mt-6 flex justify-end gap-3">
                                                    <x-secondary-button x-on:click="$dispatch('close')">
                                                        Batal
                                                    </x-secondary-button>

                                                    <x-danger-button>
                                                        Hapus Produk
                                                    </x-danger-button>
                                                </div>
                                            </form>
                                        </x-modal>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-sm text-gray-500">
                                        Belum ada produk. Tambahkan stok pertama untuk toko Mas Wowo.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
