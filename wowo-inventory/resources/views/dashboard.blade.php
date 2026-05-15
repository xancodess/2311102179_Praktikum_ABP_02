@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Ringkasan kondisi inventari toko')

@section('header-actions')
<a href="{{ route('products.create') }}" class="btn-jade btn-sm">
    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
    </svg>
    Tambah Produk
</a>
@endsection

@section('content')

{{-- ── Greeting ─────────────────────────────────── --}}
<div class="mb-6">
    <h2 class="font-display font-bold text-2xl text-ink-800">
        Halo, {{ Auth::user()->name }} 👋
    </h2>
    <p class="text-ink-400 text-sm mt-1">
        {{ now()->translatedFormat('l, d F Y') }} — Berikut ringkasan inventari hari ini.
    </p>
</div>

{{-- ── Stats Grid ───────────────────────────────── --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

    {{-- Total Produk --}}
    <div class="stat-card animate-slide-up" style="animation-delay: 0ms">
        <div class="stat-icon bg-ink-100">
            <svg class="w-5 h-5 text-ink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-ink-400 font-medium">Total Produk</p>
            <p class="font-display font-bold text-2xl text-ink-800 mt-0.5">{{ number_format($stats['total_products']) }}</p>
            <p class="text-[11px] text-ink-400 mt-1">Seluruh item</p>
        </div>
    </div>

    {{-- Aktif --}}
    <div class="stat-card animate-slide-up" style="animation-delay: 60ms">
        <div class="stat-icon bg-jade-50">
            <svg class="w-5 h-5 text-jade-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-ink-400 font-medium">Aktif</p>
            <p class="font-display font-bold text-2xl text-jade-700 mt-0.5">{{ number_format($stats['active_products']) }}</p>
            <p class="text-[11px] text-ink-400 mt-1">Produk tersedia</p>
        </div>
    </div>

    {{-- Stok Menipis --}}
    <div class="stat-card animate-slide-up" style="animation-delay: 120ms">
        <div class="stat-icon bg-amber-50">
            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-ink-400 font-medium">Stok Menipis</p>
            <p class="font-display font-bold text-2xl text-amber-600 mt-0.5">{{ number_format($stats['low_stock']) }}</p>
            <p class="text-[11px] text-ink-400 mt-1">Perlu restock</p>
        </div>
    </div>

    {{-- Nilai Inventari --}}
    <div class="stat-card animate-slide-up" style="animation-delay: 180ms">
        <div class="stat-icon bg-blue-50">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-ink-400 font-medium">Nilai Inventari</p>
            <p class="font-display font-bold text-xl text-blue-700 mt-0.5">
                Rp {{ number_format($stats['total_value'] / 1000000, 1) }}jt
            </p>
            <p class="text-[11px] text-ink-400 mt-1">Total nilai modal</p>
        </div>
    </div>

</div>

<div class="grid lg:grid-cols-3 gap-6">

    {{-- ── Stok Menipis ─────────────────────────── --}}
    <div class="lg:col-span-1">
        <div class="card overflow-hidden h-full">
            <div class="flex items-center justify-between px-5 py-4 border-b border-ink-100">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span>
                    <h3 class="font-semibold text-sm text-ink-700">Stok Menipis</h3>
                </div>
                <a href="{{ route('products.index', ['status' => '1']) }}" class="text-xs text-jade-600 hover:text-jade-700 font-medium">
                    Lihat semua
                </a>
            </div>

            @if($lowStockProducts->isEmpty())
            <div class="px-5 py-10 text-center">
                <svg class="w-10 h-10 text-jade-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm text-ink-400">Semua stok aman! 🎉</p>
            </div>
            @else
            <div class="divide-y divide-ink-50">
                @foreach($lowStockProducts as $product)
                <div class="flex items-center gap-3 px-5 py-3.5">
                    <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-ink-700 truncate">{{ $product->name }}</p>
                        <p class="text-xs text-ink-400">{{ $product->category }}</p>
                    </div>
                    <div class="text-right shrink-0">
                        <span class="badge-yellow text-[11px]">{{ $product->stock }} {{ $product->unit }}</span>
                        <p class="text-[10px] text-ink-400 mt-0.5">min: {{ $product->min_stock }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    {{-- ── Kategori Produk ─────────────────────── --}}
    <div class="lg:col-span-1">
        <div class="card overflow-hidden h-full">
            <div class="flex items-center justify-between px-5 py-4 border-b border-ink-100">
                <h3 class="font-semibold text-sm text-ink-700">Sebaran Kategori</h3>
            </div>
            <div class="divide-y divide-ink-50">
                @php $maxCount = $categoryStats->max('count') ?: 1; @endphp
                @forelse($categoryStats as $cat)
                <div class="px-5 py-3.5">
                    <div class="flex items-center justify-between mb-1.5">
                        <p class="text-sm font-medium text-ink-600 truncate">{{ $cat->category }}</p>
                        <span class="text-xs font-semibold text-ink-500 shrink-0 ml-2">{{ $cat->count }} produk</span>
                    </div>
                    <div class="w-full bg-ink-100 rounded-full h-1.5">
                        <div class="bg-jade-500 h-1.5 rounded-full transition-all duration-700"
                             style="width: {{ ($cat->count / $maxCount) * 100 }}%"></div>
                    </div>
                </div>
                @empty
                <div class="px-5 py-10 text-center">
                    <p class="text-sm text-ink-400">Belum ada data kategori</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ── Produk Terbaru ───────────────────────── --}}
    <div class="lg:col-span-1">
        <div class="card overflow-hidden h-full">
            <div class="flex items-center justify-between px-5 py-4 border-b border-ink-100">
                <h3 class="font-semibold text-sm text-ink-700">Produk Terbaru</h3>
                <a href="{{ route('products.index') }}" class="text-xs text-jade-600 hover:text-jade-700 font-medium">
                    Semua
                </a>
            </div>
            <div class="divide-y divide-ink-50">
                @forelse($recentProducts as $product)
                <div class="flex items-start gap-3 px-5 py-3.5">
                    <div class="w-8 h-8 bg-ink-100 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                        <span class="text-[10px] font-bold text-ink-500">{{ substr($product->category, 0, 2) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-ink-700 truncate">{{ $product->name }}</p>
                        <p class="text-[11px] text-ink-400 font-mono mt-0.5">{{ $product->sku }}</p>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="text-sm font-semibold text-ink-700">{{ $product->formatted_price }}</p>
                        <p class="text-[11px] text-ink-400">{{ $product->stock }} {{ $product->unit }}</p>
                    </div>
                </div>
                @empty
                <div class="px-5 py-10 text-center">
                    <p class="text-sm text-ink-400">Belum ada produk</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
