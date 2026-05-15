@extends('layouts.auth')
@section('title', 'Masuk')

@section('content')
<h2 class="font-display font-bold text-xl text-ink-800 mb-1">Selamat Datang</h2>
<p class="text-sm text-ink-400 mb-6">Masuk untuk mengelola inventari toko</p>

{{-- Validation Errors --}}
@if ($errors->any())
<div class="mb-4 p-3.5 bg-red-50 border border-red-200 rounded-xl">
    <ul class="text-sm text-red-700 space-y-1">
        @foreach ($errors->all() as $error)
            <li class="flex items-center gap-2">
                <span class="w-1 h-1 bg-red-500 rounded-full shrink-0"></span>
                {{ $error }}
            </li>
        @endforeach
    </ul>
</div>
@endif

{{-- Status message --}}
@if (session('status'))
<div class="mb-4 p-3.5 bg-jade-50 border border-jade-200 rounded-xl">
    <p class="text-sm text-jade-700">{{ session('status') }}</p>
</div>
@endif

<form method="POST" action="{{ route('login') }}" class="space-y-4">
    @csrf

    {{-- Email --}}
    <div>
        <label for="email" class="form-label">Email</label>
        <input
            id="email" name="email" type="email"
            value="{{ old('email') }}"
            placeholder="nama@toko.com"
            autocomplete="username"
            required autofocus
            class="form-input @error('email') border-red-400 bg-red-50 @enderror"
        >
    </div>

    {{-- Password --}}
    <div>
        <div class="flex items-center justify-between mb-1.5">
            <label for="password" class="form-label mb-0">Password</label>
            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-xs text-jade-600 hover:text-jade-700 font-medium">
                Lupa password?
            </a>
            @endif
        </div>
        <input
            id="password" name="password" type="password"
            placeholder="••••••••"
            autocomplete="current-password"
            required
            class="form-input @error('password') border-red-400 bg-red-50 @enderror"
        >
    </div>

    {{-- Remember me --}}
    <div class="flex items-center gap-2">
        <input id="remember_me" name="remember" type="checkbox"
               class="w-4 h-4 rounded border-ink-300 text-jade-600 focus:ring-jade-500">
        <label for="remember_me" class="text-sm text-ink-500">Ingat saya</label>
    </div>

    {{-- Submit --}}
    <button type="submit" class="btn-primary w-full justify-center py-2.5 mt-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
        </svg>
        Masuk
    </button>
</form>

{{-- Demo accounts hint --}}
<div class="mt-6 pt-5 border-t border-ink-100">
    <p class="text-[11px] font-semibold uppercase tracking-wider text-ink-400 mb-3">Akun Demo</p>
    <div class="space-y-2">
        <div class="flex items-center justify-between bg-ink-50 rounded-lg px-3 py-2">
            <div>
                <p class="text-xs font-medium text-ink-700">Mas Wowo</p>
                <p class="text-[11px] text-ink-400 font-mono">wowo@toko.com</p>
            </div>
            <span class="text-[11px] font-mono text-ink-400 bg-white px-2 py-0.5 rounded border border-ink-200">password123</span>
        </div>
        <div class="flex items-center justify-between bg-ink-50 rounded-lg px-3 py-2">
            <div>
                <p class="text-xs font-medium text-ink-700">Pak Cokomi</p>
                <p class="text-[11px] text-ink-400 font-mono">cokomi@toko.com</p>
            </div>
            <span class="text-[11px] font-mono text-ink-400 bg-white px-2 py-0.5 rounded border border-ink-200">password123</span>
        </div>
    </div>
</div>
@endsection
