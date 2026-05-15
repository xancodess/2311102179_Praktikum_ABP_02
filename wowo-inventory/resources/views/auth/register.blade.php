@extends('layouts.auth')
@section('title', 'Daftar Akun')

@section('content')
<h2 class="font-display font-bold text-xl text-ink-800 mb-1">Buat Akun Baru</h2>
<p class="text-sm text-ink-400 mb-6">Daftarkan akun untuk mengakses sistem inventari</p>

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

<form method="POST" action="{{ route('register') }}" class="space-y-4">
    @csrf

    <div>
        <label for="name" class="form-label">Nama Lengkap</label>
        <input id="name" name="name" type="text" value="{{ old('name') }}"
               placeholder="Mas Wowo" required autofocus autocomplete="name"
               class="form-input @error('name') border-red-400 bg-red-50 @enderror">
    </div>

    <div>
        <label for="email" class="form-label">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}"
               placeholder="nama@toko.com" required autocomplete="username"
               class="form-input @error('email') border-red-400 bg-red-50 @enderror">
    </div>

    <div>
        <label for="password" class="form-label">Password</label>
        <input id="password" name="password" type="password"
               placeholder="Minimal 8 karakter" required autocomplete="new-password"
               class="form-input @error('password') border-red-400 bg-red-50 @enderror">
    </div>

    <div>
        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
        <input id="password_confirmation" name="password_confirmation" type="password"
               placeholder="Ulangi password" required autocomplete="new-password"
               class="form-input">
    </div>

    <button type="submit" class="btn-primary w-full justify-center py-2.5 mt-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
        </svg>
        Daftar Sekarang
    </button>
</form>

<div class="mt-5 pt-5 border-t border-ink-100 text-center">
    <p class="text-sm text-ink-500">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-jade-600 hover:text-jade-700 font-semibold">Masuk di sini</a>
    </p>
</div>
@endsection
