@extends('layouts.app')

@section('title', 'Create Invoice')

@section('content')
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-sky-600">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Dashboard
        </a>
        <h1 class="mt-3 text-2xl font-bold text-slate-900 sm:text-3xl">Create Invoice</h1>
        <p class="mt-1 text-sm text-slate-500">Fill in customer details and add equipment items</p>
    </div>

    @include('invoices.partials.form', [
        'action' => route('invoices.store'),
        'cancelUrl' => route('dashboard'),
        'submitLabel' => 'Save Invoice',
        'initialItems' => old('items'),
    ])
@endsection

@push('scripts')
    @vite(['resources/js/invoice-form.js'])
@endpush
