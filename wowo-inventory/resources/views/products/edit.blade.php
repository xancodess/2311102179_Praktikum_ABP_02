@extends('layouts.app')
@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')
@section('breadcrumb', 'Perbarui data produk ' . $product->name)

@section('header-actions')
<a href="{{ route('products.index') }}" class="btn-outline btn-sm">
    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
    </svg>
    Kembali
</a>
@endsection

@section('content')

@if($errors->any())
<div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl flex items-start gap-3 animate-slide-up">
    <svg class="w-5 h-5 text-red-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
    </svg>
    <div>
        <p class="text-sm font-medium text-red-700 mb-1">Terdapat kesalahan dalam isian form:</p>
        <ul class="text-sm text-red-600 space-y-0.5 list-disc list-inside">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

{{-- Product header info --}}
<div class="mb-5 p-4 bg-white border border-ink-100 rounded-2xl flex items-center gap-4 shadow-card animate-slide-up">
    <div class="w-12 h-12 bg-ink-100 rounded-xl flex items-center justify-center shrink-0">
        <span class="text-sm font-bold text-ink-600">{{ strtoupper(substr($product->name, 0, 2)) }}</span>
    </div>
    <div class="flex-1">
        <p class="font-semibold text-ink-800">{{ $product->name }}</p>
        <div class="flex items-center gap-2 mt-1">
            <code class="font-mono text-xs text-ink-500">{{ $product->sku }}</code>
            <span class="text-ink-300">·</span>
            <span class="badge-gray text-xs">{{ $product->category }}</span>
            @if($product->is_active)
            <span class="badge-green text-xs">Aktif</span>
            @else
            <span class="badge-gray text-xs">Nonaktif</span>
            @endif
        </div>
    </div>
    <div class="text-right hidden sm:block">
        <p class="text-xs text-ink-400">Ditambahkan</p>
        <p class="text-sm font-medium text-ink-700">{{ $product->created_at->format('d M Y') }}</p>
    </div>
</div>

<form method="POST" action="{{ route('products.update', $product) }}" x-data>
    @csrf
    @method('PUT')
    @include('products._form', ['product' => $product, 'categories' => $categories, 'units' => $units])
</form>
@endsection
