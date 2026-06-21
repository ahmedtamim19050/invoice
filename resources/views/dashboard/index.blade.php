@extends('layouts.app')

@section('title', 'Dashboard')

@section('header-actions')
    <a href="{{ route('invoices.create') }}" class="inline-flex items-center gap-1.5 rounded-xl bg-gradient-to-r from-sky-600 to-blue-700 px-3 py-2 text-xs font-semibold text-white shadow-sm transition hover:from-sky-500 hover:to-blue-600 sm:px-4 sm:text-sm">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Invoice
    </a>
@endsection

@section('content')
    <div class="mb-6 sm:mb-8">
        <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">Dashboard</h1>
        <p class="mt-1 text-sm text-slate-500">Manage and track all your invoices</p>
    </div>

    <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Total Invoices</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">{{ $stats['total'] }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">This Month</p>
            <p class="mt-2 text-3xl font-bold text-sky-600">{{ $stats['this_month'] }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Total Amount</p>
            <p class="mt-2 text-2xl font-bold text-emerald-600 sm:text-3xl">৳ {{ format_taka($stats['total_amount']) }}</p>
        </div>
    </div>

    <div class="mb-4 flex items-center justify-between">
        <h2 class="text-lg font-semibold text-slate-900">Recent Invoices</h2>
    </div>

    @if ($invoices->isEmpty())
        <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center">
            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-sky-50 text-sky-600">
                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <h3 class="text-lg font-semibold text-slate-900">No invoices yet</h3>
            <p class="mt-2 text-sm text-slate-500">Create your first invoice to get started.</p>
            <a href="{{ route('invoices.create') }}" class="mt-6 inline-flex rounded-xl bg-sky-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-sky-500">
                Create Invoice
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($invoices as $invoice)
                <article class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:border-sky-200 hover:shadow-md">
                    <div class="border-b border-slate-100 bg-gradient-to-r from-sky-50 to-blue-50 px-5 py-4">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <p class="text-xs font-medium text-sky-700">{{ $invoice->invoice_number }}</p>
                                <h3 class="mt-1 line-clamp-1 font-semibold text-slate-900">{{ $invoice->recipient_name }}</h3>
                            </div>
                            <span class="shrink-0 rounded-full bg-white px-2.5 py-1 text-xs font-medium text-slate-600 shadow-sm">
                                {{ $invoice->items->count() }} item{{ $invoice->items->count() !== 1 ? 's' : '' }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-3 px-5 py-4">
                        <p class="line-clamp-2 text-sm text-slate-600">{{ $invoice->subject }}</p>
                        <div class="flex items-center justify-between">
                            <p class="text-xs text-slate-400">{{ $invoice->created_at->format('M d, Y') }}</p>
                            <p class="text-lg font-bold text-emerald-600">৳ {{ format_taka($invoice->total_amount) }}</p>
                        </div>
                    </div>

                    <div class="flex gap-2 border-t border-slate-100 bg-slate-50/50 px-5 py-3">
                        <a href="{{ route('invoices.show', $invoice) }}" class="flex-1 rounded-lg bg-white px-3 py-2 text-center text-xs font-semibold text-slate-700 ring-1 ring-slate-200 transition hover:bg-slate-50 sm:text-sm">
                            View
                        </a>
                        <a href="{{ route('invoices.print', $invoice) }}" target="_blank" class="flex-1 rounded-lg bg-sky-600 px-3 py-2 text-center text-xs font-semibold text-white transition hover:bg-sky-500 sm:text-sm">
                            Print PDF
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $invoices->links() }}
        </div>
    @endif
@endsection
