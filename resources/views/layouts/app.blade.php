<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — BIO-BEE Invoice</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="app-gradient-bg min-h-screen text-slate-800 antialiased">
    <div class="fixed inset-0 -z-10 opacity-[0.035] pointer-events-none">
        <img src="{{ watermark_url() }}" alt="" class="h-full w-full object-cover">
    </div>

    <header class="sticky top-0 z-40 border-b border-white/60 bg-white/70 shadow-sm shadow-slate-200/40 backdrop-blur-xl">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-3 px-4 py-3 sm:px-6">
            <a href="{{ route('dashboard') }}" class="group flex min-w-0 items-center gap-3">
                <div class="relative shrink-0">
                    <div class="absolute -inset-0.5 rounded-2xl bg-gradient-to-br from-sky-400 to-blue-600 opacity-40 blur transition group-hover:opacity-60"></div>
                    <img src="{{ logo_url() }}" alt="BIO-BEE Healthcare" class="relative h-10 w-10 rounded-xl object-contain bg-white ring-1 ring-white/80">
                </div>
                <div class="min-w-0">
                    <p class="truncate text-sm font-bold tracking-tight text-slate-900 sm:text-base">BIO-BEE HEALTHCARE</p>
                    <p class="truncate text-xs font-medium text-slate-500">Invoice Manager</p>
                </div>
            </a>

            <div class="flex items-center gap-2 sm:gap-3">
                @hasSection('header-actions')
                    @yield('header-actions')
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-ghost text-xs sm:text-sm">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-6 sm:px-6 sm:py-10">
        @if (session('success'))
            <div id="flash-success" data-message="{{ session('success') }}" class="hidden"></div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
