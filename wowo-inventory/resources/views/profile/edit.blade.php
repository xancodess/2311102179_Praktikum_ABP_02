@extends('layouts.app')
@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('breadcrumb', 'Kelola informasi akun Anda')

@section('content')
<div class="max-w-2xl space-y-6">

    {{-- Update Profile --}}
    <div class="card p-6">
        <h3 class="font-semibold text-ink-700 mb-4">Informasi Profil</h3>

        @if (session('status') === 'profile-updated')
        <div class="mb-4 p-3 bg-jade-50 border border-jade-200 rounded-xl">
            <p class="text-sm text-jade-700">✓ Profil berhasil diperbarui.</p>
        </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf @method('PATCH')
            <div>
                <label class="form-label">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                       class="form-input @error('name') border-red-400 @enderror" required>
                @error('name')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                       class="form-input @error('email') border-red-400 @enderror" required>
                @error('email')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
        </form>
    </div>

    {{-- Change Password --}}
    <div class="card p-6">
        <h3 class="font-semibold text-ink-700 mb-4">Ubah Password</h3>
        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="form-label">Password Saat Ini</label>
                <input type="password" name="current_password"
                       class="form-input @error('current_password', 'updatePassword') border-red-400 @enderror">
                @error('current_password', 'updatePassword')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label">Password Baru</label>
                <input type="password" name="password"
                       class="form-input @error('password', 'updatePassword') border-red-400 @enderror">
                @error('password', 'updatePassword')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-input">
            </div>
            <button type="submit" class="btn-primary">Perbarui Password</button>
        </form>
    </div>

    {{-- Delete Account --}}
    <div class="card p-6 border-red-100"
         x-data="{ confirmDelete: false }">
        <h3 class="font-semibold text-red-600 mb-2">Hapus Akun</h3>
        <p class="text-sm text-ink-500 mb-4">Setelah dihapus, semua data akun Anda akan dihapus permanen.</p>

        <button type="button" @click="confirmDelete = true" class="btn-danger btn-sm">
            Hapus Akun Saya
        </button>

        <div x-show="confirmDelete" class="modal-backdrop" style="display:none;"
             x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            <div class="modal-box p-6" @click.outside="confirmDelete = false">
                <h3 class="font-display font-bold text-lg text-ink-800 mb-2">Hapus Akun?</h3>
                <p class="text-sm text-ink-500 mb-4">Masukkan password untuk konfirmasi penghapusan akun.</p>
                <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4">
                    @csrf @method('DELETE')
                    <input type="password" name="password" placeholder="Password Anda"
                           class="form-input @error('password', 'userDeletion') border-red-400 @enderror" required>
                    @error('password', 'userDeletion')<p class="form-error">{{ $message }}</p>@enderror
                    <div class="flex gap-3">
                        <button type="button" @click="confirmDelete = false" class="btn-outline flex-1 justify-center">Batal</button>
                        <button type="submit" class="btn-danger flex-1 justify-center">Ya, Hapus Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
