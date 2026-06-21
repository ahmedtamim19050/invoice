<form id="delete-invoice-{{ $invoice->id }}" method="POST" action="{{ route('invoices.destroy', $invoice) }}" class="hidden">
    @csrf
    @method('DELETE')
</form>

<button
    type="button"
    data-delete-invoice="delete-invoice-{{ $invoice->id }}"
    data-invoice-label="{{ $invoice->invoice_number }}"
    class="{{ $class ?? 'delete-invoice-btn inline-flex items-center justify-center gap-1.5 rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-100 sm:text-sm' }}"
>
    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
    {{ $label ?? 'Delete' }}
</button>
