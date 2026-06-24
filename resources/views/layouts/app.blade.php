<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — BIO-BEE Invoice</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">
    <div class="fixed inset-0 -z-10 opacity-[0.04] pointer-events-none">
        <img src="{{ watermark_url() }}" alt="" class="h-full w-full object-cover">
    </div>

    <header class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/90 backdrop-blur-md">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-3 px-4 py-3 sm:px-6">
            <a href="{{ route('dashboard') }}" class="flex min-w-0 items-center gap-3">
                <img src="{{ logo_url() }}" alt="BIO-BEE Healthcare" class="h-10 w-10 shrink-0 rounded-xl object-contain shadow-sm ring-1 ring-slate-200/80">
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-slate-900 sm:text-base">BIO-BEE HEALTHCARE</p>
                    <p class="truncate text-xs text-slate-500">Invoice Manager</p>
                </div>
            </a>

            <div class="flex items-center gap-2 sm:gap-3">
                @hasSection('header-actions')
                    @yield('header-actions')
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-600 transition hover:border-slate-300 hover:bg-slate-50 sm:text-sm">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-5 sm:px-6 sm:py-8">
        @if (session('success'))
            <div id="flash-success" data-message="{{ session('success') }}" class="hidden"></div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
