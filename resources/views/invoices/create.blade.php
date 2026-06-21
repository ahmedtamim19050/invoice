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

    <form id="invoice-form" method="POST" action="{{ route('invoices.store') }}" class="space-y-6">
        @csrf

        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
            <h2 class="mb-4 text-lg font-semibold text-slate-900">Customer Details</h2>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">To (Company / Name)</label>
                    <input type="text" name="recipient_name" value="{{ old('recipient_name') }}" required
                        class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20"
                        placeholder="New Medison co.">
                    @error('recipient_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Address</label>
                    <textarea name="recipient_address" rows="2" required
                        class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20"
                        placeholder="22ka topkhana Road, Azmiri complex 2nd floor, Dhaka-1000.">{{ old('recipient_address') }}</textarea>
                    @error('recipient_address')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Contact</label>
                    <input type="text" name="recipient_contact" value="{{ old('recipient_contact') }}" required
                        class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20"
                        placeholder="01711345460">
                    @error('recipient_contact')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Subject</label>
                    <input type="text" name="subject" value="{{ old('subject') }}" required
                        class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20"
                        placeholder="Bill for X-ray Tube Insert.">
                    @error('subject')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">Equipment Items</h2>
                    <p class="text-sm text-slate-500">Add one or more line items</p>
                </div>
                <button type="button" id="add-item-btn"
                    class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-sky-200 bg-sky-50 px-4 py-2.5 text-sm font-semibold text-sky-700 transition hover:bg-sky-100">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add Item
                </button>
            </div>

            <div id="items-container" class="space-y-4"></div>

            <div class="mt-6 flex items-center justify-between rounded-xl bg-slate-50 px-4 py-4">
                <span class="text-sm font-medium text-slate-600">Grand Total</span>
                <span id="grand-total" class="text-xl font-bold text-emerald-600">৳ 0</span>
            </div>
        </section>

        <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('dashboard') }}" class="rounded-xl border border-slate-200 bg-white px-6 py-3 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Cancel
            </a>
            <button type="submit" class="rounded-xl bg-gradient-to-r from-sky-600 to-blue-700 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:from-sky-500 hover:to-blue-600">
                Save Invoice
            </button>
        </div>
    </form>

    <template id="item-row-template">
        <div class="item-row rounded-xl border border-slate-200 bg-slate-50/50 p-4">
            <div class="mb-3 flex items-center justify-between">
                <span class="item-label text-sm font-semibold text-slate-700">Item 1</span>
                <button type="button" class="remove-item-btn text-xs font-medium text-red-600 hover:text-red-700">Remove</button>
            </div>
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                <div class="sm:col-span-2 lg:col-span-3">
                    <label class="mb-1 block text-xs font-medium text-slate-600">Description of Equipment</label>
                    <input type="text" data-field="description" required
                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:border-sky-500"
                        placeholder="Tube Insert">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-medium text-slate-600">Capacity</label>
                    <input type="text" data-field="capacity"
                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:border-sky-500"
                        placeholder="125 kv">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-medium text-slate-600">Brand</label>
                    <input type="text" data-field="brand"
                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:border-sky-500"
                        placeholder="Wanray">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-medium text-slate-600">Origin</label>
                    <input type="text" data-field="origin"
                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:border-sky-500"
                        placeholder="China">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-medium text-slate-600">Quantity (Nos)</label>
                    <input type="number" data-field="quantity" min="1" value="1" required
                        class="qty-input w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:border-sky-500">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-medium text-slate-600">Unit Price</label>
                    <input type="number" data-field="unit_price" min="0" step="0.01" required
                        class="price-input w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:border-sky-500"
                        placeholder="90000">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-medium text-slate-600">Line Total</label>
                    <div class="line-total flex h-[42px] items-center rounded-lg bg-white px-3 text-sm font-semibold text-emerald-600 ring-1 ring-slate-200">৳ 0</div>
                </div>
            </div>
        </div>
    </template>
@endsection

@push('scripts')
    @vite(['resources/js/invoice-form.js'])
@endpush
