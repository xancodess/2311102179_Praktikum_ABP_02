<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Inventori Toko Wowo') }} — @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full bg-ink-50" x-data="{ sidebarOpen: false }">

{{-- ════════════════════════════════════════════════
     LAYOUT UTAMA: Sidebar + Content
════════════════════════════════════════════════ --}}
<div class="flex h-full min-h-screen">

    {{-- ── Overlay mobile ── --}}
    <div
        x-show="sidebarOpen"
        x-transition:enter="transition-opacity ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="sidebarOpen = false"
        class="fixed inset-0 z-30 bg-ink-900/40 backdrop-blur-sm lg:hidden"
        style="display: none;"
    ></div>

    {{-- ── SIDEBAR ─────────────────────────────── --}}
    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-ink-100 flex flex-col
               transition-transform duration-300 ease-in-out lg:static lg:z-auto"
    >
        {{-- Logo --}}
        <div class="flex items-center gap-3 px-5 py-5 border-b border-ink-100">
            <div class="w-9 h-9 bg-ink-800 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-jade-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                </svg>
            </div>
            <div>
                <p class="font-display font-bold text-ink-800 leading-none text-base">Toko Wowo</p>
                <p class="text-xs text-ink-400 mt-0.5">Sistem Inventari</p>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto scrollbar-thin">
            <p class="px-3 pb-2 text-[10px] font-semibold uppercase tracking-widest text-ink-300">Menu</p>

            <a href="{{ route('dashboard') }}"
               class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('products.index') }}"
               class="sidebar-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                </svg>
                Manajemen Produk
                @php $total = \App\Models\Product::count(); @endphp
                @if($total)
                <span class="ml-auto text-[10px] font-semibold px-1.5 py-0.5 bg-ink-100 text-ink-500 rounded-md">
                    {{ $total }}
                </span>
                @endif
            </a>
        </nav>

        {{-- User Info --}}
        <div class="px-3 py-4 border-t border-ink-100">
            <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-ink-50 transition-colors">
                <div class="w-8 h-8 bg-jade-100 rounded-full flex items-center justify-center shrink-0">
                    <span class="text-xs font-semibold text-jade-700">
                        {{ substr(Auth::user()->name, 0, 2) }}
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-ink-700 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-ink-400 truncate">{{ Auth::user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Keluar"
                            class="text-ink-300 hover:text-red-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ── CONTENT AREA ─────────────────────────── --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        {{-- Top Header --}}
        <header class="bg-white border-b border-ink-100 px-4 lg:px-6 py-4 flex items-center gap-4 shrink-0">
            {{-- Mobile toggle --}}
            <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-ink-500 hover:text-ink-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- Breadcrumb --}}
            <div class="flex-1">
                <h1 class="font-display font-bold text-ink-800 text-lg leading-none">@yield('page-title', 'Dashboard')</h1>
                @hasSection('breadcrumb')
                <p class="text-xs text-ink-400 mt-0.5">@yield('breadcrumb')</p>
                @endif
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-2">
                @yield('header-actions')
            </div>
        </header>

        {{-- Flash Messages --}}
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="mx-4 lg:mx-6 mt-4 p-4 bg-jade-50 border border-jade-200 rounded-xl
                    flex items-start gap-3 animate-slide-up">
            <svg class="w-5 h-5 text-jade-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm text-jade-800">{!! session('success') !!}</p>
            <button @click="show = false" class="ml-auto text-jade-500 hover:text-jade-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        @endif

        @if(session('error'))
        <div class="mx-4 lg:mx-6 mt-4 p-4 bg-red-50 border border-red-200 rounded-xl flex items-start gap-3 animate-slide-up">
            <svg class="w-5 h-5 text-red-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <p class="text-sm text-red-800">{!! session('error') !!}</p>
        </div>
        @endif

        {{-- Main Content --}}
        <main class="flex-1 overflow-y-auto px-4 lg:px-6 py-6 scrollbar-thin">
            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
