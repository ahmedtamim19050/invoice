@extends('layouts.app')

@section('title', 'Edit Invoice ' . $invoice->invoice_number)

@section('content')
    <div class="mb-6">
        <a href="{{ route('invoices.show', $invoice) }}" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-sky-600">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Invoice
        </a>
        <h1 class="mt-3 text-2xl font-bold text-slate-900 sm:text-3xl">Edit Invoice</h1>
        <p class="mt-1 text-sm text-slate-500">{{ $invoice->invoice_number }} · Update customer details and line items</p>
    </div>

    @include('invoices.partials.form', [
        'invoice' => $invoice,
        'action' => route('invoices.update', $invoice),
        'cancelUrl' => route('invoices.show', $invoice),
        'submitLabel' => 'Update Invoice',
        'initialItems' => old('items', $initialItems),
    ])
@endsection

@push('scripts')
    @vite(['resources/js/invoice-form.js'])
@endpush
