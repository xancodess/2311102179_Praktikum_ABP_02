@extends('layouts.app')
@section('title', 'Manajemen Produk')
@section('page-title', 'Manajemen Produk')
@section('breadcrumb', 'Kelola seluruh produk inventari toko')

@section('header-actions')
<a href="{{ route('products.create') }}" class="btn-jade">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
    </svg>
    Tambah Produk
</a>
@endsection

@section('content')

{{-- ── Stats Row ────────────────────────────────── --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
    <div class="card px-4 py-3 flex items-center gap-3">
        <div class="w-8 h-8 bg-ink-100 rounded-lg flex items-center justify-center shrink-0">
            <svg class="w-4 h-4 text-ink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
            </svg>
        </div>
        <div>
            <p class="text-[11px] text-ink-400">Total</p>
            <p class="font-display font-bold text-lg text-ink-800 leading-none">{{ $stats['total'] }}</p>
        </div>
    </div>
    <div class="card px-4 py-3 flex items-center gap-3">
        <div class="w-8 h-8 bg-jade-50 rounded-lg flex items-center justify-center shrink-0">
            <svg class="w-4 h-4 text-jade-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-[11px] text-ink-400">Aktif</p>
            <p class="font-display font-bold text-lg text-jade-700 leading-none">{{ $stats['active'] }}</p>
        </div>
    </div>
    <div class="card px-4 py-3 flex items-center gap-3">
        <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center shrink-0">
            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <div>
            <p class="text-[11px] text-ink-400">Stok Menipis</p>
            <p class="font-display font-bold text-lg text-amber-600 leading-none">{{ $stats['low_stock'] }}</p>
        </div>
    </div>
    <div class="card px-4 py-3 flex items-center gap-3">
        <div class="w-8 h-8 bg-ink-100 rounded-lg flex items-center justify-center shrink-0">
            <svg class="w-4 h-4 text-ink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
            </svg>
        </div>
        <div>
            <p class="text-[11px] text-ink-400">Nonaktif</p>
            <p class="font-display font-bold text-lg text-ink-500 leading-none">{{ $stats['inactive'] }}</p>
        </div>
    </div>
</div>

{{-- ── Main Table Card ──────────────────────────── --}}
<div class="card overflow-hidden"
     x-data="{
        deleteModal: false,
        deleteId: null,
        deleteName: '',
        openDelete(id, name) {
            this.deleteId = id;
            this.deleteName = name;
            this.deleteModal = true;
        }
     }">

    {{-- Toolbar --}}
    <div class="px-5 py-4 border-b border-ink-100">
        <form method="GET" action="{{ route('products.index') }}" class="flex flex-wrap gap-2.5 items-center">

            {{-- Search --}}
            <div class="relative flex-1 min-w-52">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-ink-400 pointer-events-none"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                </svg>
                <input
                    type="text" name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama, SKU, kategori..."
                    class="form-input pl-9 py-2"
                >
            </div>

            {{-- Filter Kategori --}}
            <select name="category" class="form-select py-2 w-44">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>
                    {{ $cat }}
                </option>
                @endforeach
            </select>

            {{-- Filter Status --}}
            <select name="status" class="form-select py-2 w-36">
                <option value="">Semua Status</option>
                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif</option>
            </select>

            <button type="submit" class="btn-primary py-2">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                </svg>
                Filter
            </button>

            @if(request()->hasAny(['search', 'category', 'status']))
            <a href="{{ route('products.index') }}" class="btn-ghost py-2">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Reset
            </a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="w-8">
                        <span class="text-ink-300">#</span>
                    </th>
                    <th>
                        <a href="{{ route('products.index', array_merge(request()->except(['sort_by','sort_order','page']), ['sort_by' => 'name', 'sort_order' => request('sort_by') === 'name' && request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}"
                           class="flex items-center gap-1 hover:text-ink-700 transition-colors">
                            Produk
                            @if(request('sort_by') === 'name')
                            <svg class="w-3 h-3 {{ request('sort_order') === 'asc' ? '' : 'rotate-180' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5 10l5-5 5 5H5z"/>
                            </svg>
                            @endif
                        </a>
                    </th>
                    <th>SKU</th>
                    <th>Kategori</th>
                    <th>
                        <a href="{{ route('products.index', array_merge(request()->except(['sort_by','sort_order','page']), ['sort_by' => 'price', 'sort_order' => request('sort_by') === 'price' && request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}"
                           class="flex items-center gap-1 hover:text-ink-700 transition-colors">
                            Harga Jual
                            @if(request('sort_by') === 'price')
                            <svg class="w-3 h-3 {{ request('sort_order') === 'asc' ? '' : 'rotate-180' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5 10l5-5 5 5H5z"/>
                            </svg>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ route('products.index', array_merge(request()->except(['sort_by','sort_order','page']), ['sort_by' => 'stock', 'sort_order' => request('sort_by') === 'stock' && request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}"
                           class="flex items-center gap-1 hover:text-ink-700 transition-colors">
                            Stok
                            @if(request('sort_by') === 'stock')
                            <svg class="w-3 h-3 {{ request('sort_order') === 'asc' ? '' : 'rotate-180' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5 10l5-5 5 5H5z"/>
                            </svg>
                            @endif
                        </a>
                    </th>
                    <th>Margin</th>
                    <th>Status</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $i => $product)
                <tr class="animate-fade-in group" style="animation-delay: {{ $i * 30 }}ms">
                    {{-- No --}}
                    <td class="text-ink-300 text-xs">
                        {{ $products->firstItem() + $i }}
                    </td>

                    {{-- Produk --}}
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-ink-100 rounded-xl flex items-center justify-center shrink-0
                                        group-hover:bg-jade-50 transition-colors">
                                <span class="text-xs font-bold text-ink-500 group-hover:text-jade-700">
                                    {{ strtoupper(substr($product->name, 0, 2)) }}
                                </span>
                            </div>
                            <div>
                                <p class="font-medium text-ink-800 leading-snug">{{ $product->name }}</p>
                                @if($product->description)
                                <p class="text-xs text-ink-400 truncate max-w-48">{{ $product->description }}</p>
                                @endif
                            </div>
                        </div>
                    </td>

                    {{-- SKU --}}
                    <td>
                        <code class="font-mono text-xs bg-ink-100 text-ink-600 px-2 py-0.5 rounded-md">
                            {{ $product->sku }}
                        </code>
                    </td>

                    {{-- Kategori --}}
                    <td>
                        <span class="badge-gray">{{ $product->category }}</span>
                    </td>

                    {{-- Harga --}}
                    <td>
                        <p class="font-semibold text-ink-800 text-sm">{{ $product->formatted_price }}</p>
                        <p class="text-[11px] text-ink-400">Modal: {{ $product->formatted_cost_price }}</p>
                    </td>

                    {{-- Stok --}}
                    <td>
                        @if($product->isLowStock())
                        <span class="badge-yellow">
                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01"/>
                            </svg>
                            {{ $product->stock }} {{ $product->unit }}
                        </span>
                        @else
                        <span class="text-sm font-medium text-ink-700">{{ $product->stock }} {{ $product->unit }}</span>
                        @endif
                        <p class="text-[11px] text-ink-400 mt-0.5">Min: {{ $product->min_stock }}</p>
                    </td>

                    {{-- Margin --}}
                    <td>
                        @php $margin = $product->profit_margin; @endphp
                        <div class="flex items-center gap-2">
                            <div class="flex-1 bg-ink-100 rounded-full h-1.5 w-16">
                                <div class="h-1.5 rounded-full {{ $margin >= 30 ? 'bg-jade-500' : ($margin >= 15 ? 'bg-amber-400' : 'bg-red-400') }}"
                                     style="width: {{ min($margin, 100) }}%"></div>
                            </div>
                            <span class="text-xs font-medium {{ $margin >= 30 ? 'text-jade-700' : ($margin >= 15 ? 'text-amber-600' : 'text-red-600') }}">
                                {{ $margin }}%
                            </span>
                        </div>
                    </td>

                    {{-- Status --}}
                    <td>
                        @if($product->is_active)
                        <span class="badge-green">
                            <span class="w-1.5 h-1.5 bg-jade-500 rounded-full"></span>
                            Aktif
                        </span>
                        @else
                        <span class="badge-gray">
                            <span class="w-1.5 h-1.5 bg-ink-400 rounded-full"></span>
                            Nonaktif
                        </span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-1.5">
                            <a href="{{ route('products.edit', $product) }}"
                               class="btn-ghost btn-sm p-2 rounded-lg" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>

                            <button type="button"
                                    @click="openDelete({{ $product->id }}, '{{ addslashes($product->name) }}')"
                                    class="btn-ghost btn-sm p-2 rounded-lg text-red-400 hover:text-red-600 hover:bg-red-50"
                                    title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-16 h-16 bg-ink-100 rounded-2xl flex items-center justify-center">
                                <svg class="w-8 h-8 text-ink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-ink-700">Tidak ada produk ditemukan</p>
                                <p class="text-xs text-ink-400 mt-1">Coba ubah filter atau tambahkan produk baru</p>
                            </div>
                            <a href="{{ route('products.create') }}" class="btn-jade btn-sm mt-1">
                                Tambah Produk
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($products->hasPages())
    <div class="px-5 py-3.5 border-t border-ink-100 flex items-center justify-between gap-4">
        <p class="text-xs text-ink-400">
            Menampilkan <span class="font-medium text-ink-600">{{ $products->firstItem() }}–{{ $products->lastItem() }}</span>
            dari <span class="font-medium text-ink-600">{{ $products->total() }}</span> produk
        </p>
        <div class="flex items-center gap-1">
            {{-- Prev --}}
            @if($products->onFirstPage())
            <span class="btn-outline btn-sm opacity-40 cursor-not-allowed">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </span>
            @else
            <a href="{{ $products->previousPageUrl() }}" class="btn-outline btn-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            @endif

            {{-- Pages --}}
            @foreach($products->getUrlRange(max(1, $products->currentPage()-2), min($products->lastPage(), $products->currentPage()+2)) as $page => $url)
            <a href="{{ $url }}"
               class="btn-sm rounded-xl font-medium min-w-[32px] justify-center
                      {{ $page === $products->currentPage() ? 'bg-ink-800 text-white' : 'btn-outline' }}">
                {{ $page }}
            </a>
            @endforeach

            {{-- Next --}}
            @if($products->hasMorePages())
            <a href="{{ $products->nextPageUrl() }}" class="btn-outline btn-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            @else
            <span class="btn-outline btn-sm opacity-40 cursor-not-allowed">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </span>
            @endif
        </div>
    </div>
    @else
    <div class="px-5 py-3 border-t border-ink-100">
        <p class="text-xs text-ink-400">
            Menampilkan {{ $products->count() }} dari {{ $products->total() }} produk
        </p>
    </div>
    @endif

    {{-- ══ DELETE CONFIRMATION MODAL ══ --}}
    <div x-show="deleteModal"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="modal-backdrop"
         @keydown.escape.window="deleteModal = false"
         style="display: none;">
        <div class="modal-box p-6"
             @click.outside="deleteModal = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">

            {{-- Icon --}}
            <div class="w-14 h-14 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>

            {{-- Text --}}
            <h3 class="font-display font-bold text-lg text-ink-800 text-center">Hapus Produk?</h3>
            <p class="text-sm text-ink-500 text-center mt-2">
                Produk <span class="font-semibold text-ink-700" x-text="'&quot;' + deleteName + '&quot;'"></span>
                akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.
            </p>

            {{-- Buttons --}}
            <div class="flex gap-3 mt-6">
                <button type="button" @click="deleteModal = false" class="btn-outline flex-1 justify-center">
                    Batal
                </button>
                <form :action="'/products/' + deleteId" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger w-full justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
