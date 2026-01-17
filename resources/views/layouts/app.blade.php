<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Cafe Management') }}{{ isset($title) ? ' - ' . $title : '' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full font-sans antialiased bg-slate-50" x-data="{ sidebarOpen: false }">
    <div class="min-h-full">
        <!-- Mobile sidebar backdrop -->
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 bg-slate-900/60 lg:hidden"
            @click="sidebarOpen = false">
        </div>

        <!-- Mobile sidebar -->
        <aside x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed inset-y-0 left-0 z-50 w-72 bg-white shadow-soft-xl lg:hidden flex flex-col">

            <!-- Mobile sidebar header -->
            <div class="flex h-16 items-center justify-between px-4 border-b border-slate-100 shrink-0">
                <x-cafe-logo class="h-8 w-auto" />
                <button @click="sidebarOpen = false"
                    class="p-2 text-slate-500 hover:text-slate-700 rounded-lg hover:bg-slate-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Mobile nav (scrollable) -->
            <nav class="flex-1 overflow-y-auto p-4 space-y-1">
                @include('layouts.partials.nav-items')
            </nav>

            <!-- Mobile user section (fixed bottom) -->
            <div class="shrink-0 border-t border-slate-200 p-4 bg-slate-50">
                <div class="flex items-center gap-3 mb-3">
                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-rose-100 text-rose-700 text-sm font-semibold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-900 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-500 capitalize">{{ Auth::user()->role }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <a href="{{ route('profile.edit') }}" class="btn btn-ghost btn-sm justify-center text-slate-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profil
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="contents">
                        @csrf
                        <button type="submit" class="btn btn-ghost btn-sm justify-center text-red-600 hover:bg-red-50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Desktop sidebar -->
        <aside class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-64 lg:flex-col">
            <div class="flex grow flex-col border-r border-slate-200 bg-white">
                <!-- Logo (fixed top) -->
                <div class="flex h-16 shrink-0 items-center px-6 border-b border-slate-100">
                    <x-cafe-logo class="h-8 w-auto" />
                </div>

                <!-- Navigation (scrollable middle) -->
                <nav class="flex-1 overflow-y-auto px-4 py-4">
                    <ul role="list" class="space-y-1">
                        @include('layouts.partials.nav-items')
                    </ul>
                </nav>

                <!-- User section (fixed bottom) -->
                <div class="shrink-0 border-t border-slate-200 p-4 bg-slate-50/80">
                    <div class="flex items-center gap-3 mb-3">
                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-rose-100 text-rose-700 text-sm font-semibold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-900 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-500 capitalize">{{ Auth::user()->role }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-medium text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profil
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="contents">
                            @csrf
                            <button type="submit"
                                class="flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-medium text-red-600 bg-white border border-red-200 rounded-lg hover:bg-red-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main content area -->
        <div class="lg:pl-64">
            <!-- Top navbar (mobile) -->
            <header
                class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-slate-200 bg-white/95 backdrop-blur px-4 shadow-sm lg:hidden">
                <button @click="sidebarOpen = true"
                    class="p-2 -ml-2 text-slate-500 hover:text-slate-700 rounded-lg hover:bg-slate-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="flex-1 flex justify-center lg:justify-start">
                    <x-cafe-logo class="h-7 w-auto" />
                </div>

                <!-- Mobile user avatar -->
                <div
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-rose-100 text-rose-700 text-sm font-medium">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </header>

            <!-- Page Header -->
            @isset($header)
                <header class="bg-white border-b border-slate-200">
                    <div class="px-4 sm:px-6 lg:px-8 py-6">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Main content -->
            <main class="py-6">
                <div class="px-4 sm:px-6 lg:px-8">
                    <!-- Flash messages -->
                    @if(session('success'))
                        <x-ui.alert type="success" class="mb-6" dismissible>
                            {{ session('success') }}
                        </x-ui.alert>
                    @endif

                    @if(session('error'))
                        <x-ui.alert type="danger" class="mb-6" dismissible>
                            {{ session('error') }}
                        </x-ui.alert>
                    @endif

                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>

</html>