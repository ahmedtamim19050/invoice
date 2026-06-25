@extends('layouts.app')

@section('title', 'Dashboard')

@section('header-actions')
    <a href="{{ route('invoices.create') }}" class="btn-primary text-xs sm:text-sm">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Invoice
    </a>
@endsection

@section('content')
    <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-blue-950 to-sky-900 p-6 shadow-xl shadow-slate-900/20 sm:p-8">
        <div class="pointer-events-none absolute -right-16 -top-16 h-56 w-56 rounded-full bg-sky-400/20 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-20 -left-10 h-48 w-48 rounded-full bg-blue-500/15 blur-3xl"></div>

        <div class="relative flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-sky-300/90">Overview</p>
                <h1 class="mt-2 text-2xl font-bold tracking-tight text-white sm:text-3xl">Dashboard</h1>
                <p class="mt-2 max-w-md text-sm leading-relaxed text-slate-300">Track invoices, amounts, and activity at a glance.</p>
            </div>
            <a href="{{ route('invoices.create') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-white/10 px-5 py-2.5 text-sm font-semibold text-white ring-1 ring-white/20 transition hover:bg-white/15 hover:ring-white/30">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Create invoice
            </a>
        </div>
    </div>

    <div class="mb-10 grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="stat-card">
            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-slate-400 to-slate-300"></div>
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Invoices</p>
                    <p class="mt-2 text-3xl font-bold tabular-nums tracking-tight text-slate-900">{{ $stats['total'] }}</p>
                </div>
                <div class="rounded-2xl bg-slate-100 p-3 text-slate-600 ring-1 ring-slate-200/80">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-sky-500 to-blue-500"></div>
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">This Month</p>
                    <p class="mt-2 text-3xl font-bold tabular-nums tracking-tight text-sky-600">{{ $stats['this_month'] }}</p>
                </div>
                <div class="rounded-2xl bg-sky-50 p-3 text-sky-600 ring-1 ring-sky-100">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-emerald-500 to-teal-500"></div>
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Amount</p>
                    <p class="mt-2 text-2xl font-bold tabular-nums tracking-tight text-emerald-600 sm:text-3xl">৳ {{ format_taka($stats['total_amount']) }}</p>
                </div>
                <div class="rounded-2xl bg-emerald-50 p-3 text-emerald-600 ring-1 ring-emerald-100">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <h2 class="section-title">Recent Invoices</h2>
            @if ($invoices->total() > 0)
                <span class="rounded-full bg-slate-900 px-2.5 py-0.5 text-xs font-bold text-white">{{ $invoices->total() }}</span>
            @endif
        </div>
    </div>

    @if ($invoices->isEmpty())
        <div class="glass-panel border-dashed px-6 py-20 text-center">
            <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-500 to-blue-600 text-white shadow-lg shadow-sky-500/30">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900">No invoices yet</h3>
            <p class="mt-2 text-sm text-slate-500">Create your first invoice to get started.</p>
            <a href="{{ route('invoices.create') }}" class="btn-primary mt-8">
                Create Invoice
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($invoices as $invoice)
                @include('invoices.partials.card', ['invoice' => $invoice])
            @endforeach
        </div>

        @if ($invoices->hasPages())
            <div class="mt-10 flex justify-center">
                <div class="glass-panel px-2 py-1">
                    {{ $invoices->links() }}
                </div>
            </div>
        @endif
    @endif
@endsection
