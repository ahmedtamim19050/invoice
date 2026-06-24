<?php

namespace App\Support;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoicePdfGenerator
{
    public static function make(Invoice $invoice): \Barryvdh\DomPDF\PDF
    {
        return Pdf::loadView('invoices.document-page', [
            'invoice' => $invoice,
            'watermark' => watermark_data_uri() ?? watermark_url(),
        ])->setPaper('a4', 'portrait');
    }
}
