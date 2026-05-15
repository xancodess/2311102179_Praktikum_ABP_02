<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Inventori Toko Wowo') }} — @yield('title')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-ink-50 flex items-center justify-center p-4">

{{-- Background decoration --}}
<div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-jade-100/40 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-ink-200/30 rounded-full blur-3xl"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px]
                bg-jade-50/20 rounded-full blur-3xl"></div>
</div>

<div class="w-full max-w-sm animate-slide-up">
    {{-- Logo / Brand --}}
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-14 h-14 bg-ink-800 rounded-2xl mb-4 shadow-lg">
            <svg class="w-7 h-7 text-jade-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
            </svg>
        </div>
        <h1 class="font-display font-bold text-2xl text-ink-800">Toko Wowo</h1>
        <p class="text-sm text-ink-400 mt-1">Sistem Inventari Digital</p>
    </div>

    {{-- Card --}}
    <div class="card p-7 shadow-lg">
        @yield('content')
    </div>

    {{-- Footer --}}
    <p class="text-center text-xs text-ink-400 mt-6">
        &copy; {{ date('Y') }} Toko Mas Wowo &amp; Pak Cokomi. All rights reserved.
    </p>
</div>

</body>
</html>
