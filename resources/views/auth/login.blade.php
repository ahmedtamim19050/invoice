<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — BIO-BEE Invoice</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-white antialiased">
    <div class="relative flex min-h-screen flex-col">
        <div class="absolute inset-0">
            <img src="{{ watermark_url() }}" alt="" class="h-full w-full object-cover opacity-20">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-950/95 via-blue-950/90 to-sky-900/85"></div>
        </div>

        <div class="relative mx-auto flex w-full max-w-md flex-1 flex-col justify-center px-4 py-10 sm:px-6">
            <div class="mb-8 text-center">
                <img src="{{ logo_url() }}" alt="BIO-BEE Healthcare" class="mx-auto mb-4 h-20 w-20 rounded-2xl object-contain shadow-lg shadow-blue-500/20 ring-1 ring-white/20">
                <h1 class="text-2xl font-bold tracking-tight sm:text-3xl">BIO-BEE HEALTHCARE</h1>
                <p class="mt-2 text-sm text-blue-100/80">Invoice Management System</p>
            </div>

            <div class="rounded-2xl border border-white/10 bg-white/10 p-6 shadow-2xl backdrop-blur-xl sm:p-8">
                <h2 class="mb-1 text-lg font-semibold">Welcome back</h2>
                <p class="mb-6 text-sm text-blue-100/70">Sign in to manage your invoices</p>

                @if ($errors->any())
                    <div class="mb-5 rounded-xl border border-red-400/30 bg-red-500/10 px-4 py-3 text-sm text-red-100">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.submit') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-medium text-blue-50">Email</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email', 'admin@admin.com') }}"
                            required
                            autofocus
                            class="w-full rounded-xl border border-white/10 bg-white/10 px-4 py-3 text-sm text-white placeholder:text-white/40 outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-400/30"
                            placeholder="admin@admin.com"
                        >
                    </div>

                    <div>
                        <label for="password" class="mb-1.5 block text-sm font-medium text-blue-50">Password</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            class="w-full rounded-xl border border-white/10 bg-white/10 px-4 py-3 text-sm text-white placeholder:text-white/40 outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-400/30"
                            placeholder="••••••••"
                        >
                    </div>

                    <label class="flex items-center gap-2 text-sm text-blue-100/80">
                        <input type="checkbox" name="remember" class="rounded border-white/20 bg-white/10 text-sky-500 focus:ring-sky-400/30">
                        Remember me
                    </label>

                    <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-sky-500 to-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-500/25 transition hover:from-sky-400 hover:to-blue-500">
                        Sign In
                    </button>
                </form>
            </div>

            <p class="mt-8 text-center text-xs text-blue-100/50">
                Medical, Surgical &amp; Hospital Equipment Invoices
            </p>
        </div>
    </div>
</body>
</html>
