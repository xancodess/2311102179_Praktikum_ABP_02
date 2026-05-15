@extends('layouts.auth')
@section('title', 'Lupa Password')

@section('content')
<h2 class="font-display font-bold text-xl text-ink-800 mb-1">Lupa Password?</h2>
<p class="text-sm text-ink-400 mb-6">Masukkan email Anda dan kami akan mengirimkan link reset password.</p>

@if (session('status'))
<div class="mb-4 p-3.5 bg-jade-50 border border-jade-200 rounded-xl">
    <p class="text-sm text-jade-700">{{ session('status') }}</p>
</div>
@endif

@if ($errors->any())
<div class="mb-4 p-3.5 bg-red-50 border border-red-200 rounded-xl">
    <ul class="text-sm text-red-700 space-y-1">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('password.email') }}" class="space-y-4">
    @csrf
    <div>
        <label for="email" class="form-label">Alamat Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}"
               placeholder="nama@toko.com" required autofocus
               class="form-input @error('email') border-red-400 bg-red-50 @enderror">
    </div>
    <button type="submit" class="btn-primary w-full justify-center py-2.5">
        Kirim Link Reset Password
    </button>
</form>

<div class="mt-5 pt-5 border-t border-ink-100 text-center">
    <a href="{{ route('login') }}" class="text-sm text-jade-600 hover:text-jade-700 font-medium flex items-center justify-center gap-1">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke halaman login
    </a>
</div>
@endsection
