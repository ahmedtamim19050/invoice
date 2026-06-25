@extends('layouts.app')

@section('title', 'Invoice ' . $invoice->invoice_number)

@section('header-actions')
    <a href="{{ route('invoices.edit', $invoice) }}"
        class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 sm:text-sm">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        Edit
    </a>
    <a href="{{ route('invoices.download', $invoice) }}"
        class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-600 px-3 py-2 text-xs font-semibold text-white hover:bg-emerald-500 sm:text-sm">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
        Download
    </a>
    <a href="{{ route('invoices.print', $invoice) }}" target="_blank"
        class="inline-flex items-center gap-1.5 rounded-xl bg-sky-600 px-3 py-2 text-xs font-semibold text-white hover:bg-sky-500 sm:text-sm">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
        Print
    </a>
    @include('invoices.partials.delete-button', ['invoice' => $invoice])
@endsection

@section('content')
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-sky-600">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Dashboard
        </a>
        <h1 class="mt-3 text-2xl font-bold text-slate-900">Invoice Details</h1>
        <p class="mt-1 text-sm text-slate-500">{{ $invoice->invoice_number }} · {{ $invoice->created_at->format('F d, Y') }}</p>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 bg-slate-50 px-5 py-4 sm:px-6">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <p class="text-xs font-medium uppercase text-slate-500">Bill To</p>
                    <p class="mt-1 font-semibold text-slate-900">{{ $invoice->recipient_name }}</p>
                    <p class="mt-1 text-sm text-slate-600">{{ $invoice->recipient_address }}</p>
                    <p class="mt-1 text-sm text-slate-600">{{ $invoice->recipient_contact }}</p>
                </div>
                <div class="sm:col-span-2 lg:col-span-3">
                    <p class="text-xs font-medium uppercase text-slate-500">Subject</p>
                    <p class="mt-1 font-semibold text-slate-900">{{ $invoice->subject }}</p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-900 text-left text-white">
                    <tr>
                        <th class="px-4 py-3 font-semibold">SL</th>
                        <th class="px-4 py-3 font-semibold">Description</th>
                        <th class="px-4 py-3 font-semibold">Qty</th>
                        <th class="px-4 py-3 font-semibold">Unit Price</th>
                        <th class="px-4 py-3 font-semibold">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($invoice->items as $index => $item)
                        <tr>
                            <td class="px-4 py-3 align-top text-slate-600">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-4 py-3 align-top">
                                <p class="font-medium text-slate-900">{{ $item->description }}</p>
                                @if ($item->capacity)
                                    <p class="text-slate-600">Capacity: {{ $item->capacity }}</p>
                                @endif
                                @if ($item->brand)
                                    <p class="text-slate-600">Brand: {{ $item->brand }}</p>
                                @endif
                                @if ($item->origin)
                                    <p class="text-slate-600">Origin: {{ $item->origin }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-3 align-top text-slate-700">{{ str_pad($item->quantity, 2, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-4 py-3 align-top text-slate-700">{{ format_taka($item->unit_price) }}</td>
                            <td class="px-4 py-3 align-top font-semibold text-slate-900">{{ format_taka($item->total_price) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-slate-50 font-semibold">
                        <td colspan="3" class="px-4 py-3"></td>
                        <td class="px-4 py-3 text-right text-slate-700">Total Amount =</td>
                        <td class="px-4 py-3 text-emerald-600">৳ {{ format_taka($invoice->total_amount) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="border-t border-slate-100 px-5 py-4 sm:px-6">
            <p class="text-sm text-slate-700"><span class="font-semibold">In Word:</span> {{ amount_in_words($invoice->total_amount) }}</p>
        </div>
    </div>

    <div class="mt-6 flex justify-center">
        @include('invoices.partials.document-preview', ['invoice' => $invoice])
    </div>
@endsection
