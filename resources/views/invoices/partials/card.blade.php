<article class="invoice-card group">
    <div class="absolute inset-x-0 top-0 h-0.5 bg-gradient-to-r from-sky-400 via-blue-500 to-sky-400 opacity-0 transition duration-300 group-hover:opacity-100"></div>

    <div class="flex items-center justify-between gap-3 px-5 py-4">
        <span class="rounded-lg bg-gradient-to-r from-sky-50 to-blue-50 px-2.5 py-1 text-xs font-bold tracking-wide text-sky-800 ring-1 ring-sky-100/80">
            {{ $invoice->invoice_number }}
        </span>
        <time class="shrink-0 text-xs font-medium text-slate-400">{{ $invoice->created_at->format('M d, Y') }}</time>
    </div>

    <div class="flex flex-1 flex-col px-5 pb-4">
        <h3 class="line-clamp-1 text-base font-bold tracking-tight text-slate-900">{{ $invoice->recipient_name }}</h3>
        <p class="mt-1.5 line-clamp-2 text-sm leading-relaxed text-slate-500">{{ $invoice->subject }}</p>

        <div class="mt-4 flex items-center justify-between gap-3 rounded-2xl bg-gradient-to-br from-slate-50 to-slate-100/80 px-4 py-3.5 ring-1 ring-slate-200/60">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Amount</p>
                <p class="mt-0.5 text-xl font-bold tabular-nums tracking-tight text-emerald-600">৳ {{ format_taka($invoice->total_amount) }}</p>
            </div>
            <span class="shrink-0 rounded-full bg-white px-3 py-1 text-xs font-semibold text-slate-600 shadow-sm ring-1 ring-slate-200/80">
                {{ $invoice->items->count() }} item{{ $invoice->items->count() !== 1 ? 's' : '' }}
            </span>
        </div>
    </div>

    <div class="border-t border-slate-100/80 bg-slate-50/50 px-4 py-3.5">
        <div class="grid grid-cols-4 gap-1 rounded-2xl bg-white/60 p-1 ring-1 ring-slate-200/60">
            <a href="{{ route('invoices.show', $invoice) }}" class="action-pill hover:text-sky-600" title="View invoice">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                View
            </a>
            <a href="{{ route('invoices.edit', $invoice) }}" class="action-pill hover:text-amber-600" title="Edit invoice">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
            <a href="{{ route('invoices.download', $invoice) }}" class="action-pill hover:text-emerald-600" title="Download PDF">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                PDF
            </a>
            <a href="{{ route('invoices.print', $invoice) }}" target="_blank" class="action-pill hover:text-sky-600" title="Print invoice">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Print
            </a>
        </div>

        <div class="mt-2.5">
            @include('invoices.partials.delete-button', [
                'invoice' => $invoice,
                'label' => 'Delete invoice',
                'class' => 'delete-invoice-btn flex w-full items-center justify-center gap-1.5 rounded-xl py-2 text-xs font-semibold text-red-500/90 transition hover:bg-red-50 hover:text-red-600',
            ])
        </div>
    </div>
</article>
