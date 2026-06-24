<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bill — {{ $invoice->invoice_number }}</title>
    @include('invoices.partials.invoice-styles')
    @vite(['resources/js/invoice-pdf.js'])
</head>
<body class="invoice-print-page">
    <div class="no-print toolbar">
        <button type="button" onclick="window.print()" class="print-btn">Print</button>
        <button type="button" id="download-pdf-btn" class="download-btn">Download PDF</button>
        <a href="{{ route('invoices.show', $invoice) }}" class="back-btn">Back to Invoice</a>
    </div>

    @include('invoices.partials.document', [
        'invoice' => $invoice,
        'print' => true,
        'watermark' => watermark_data_uri() ?? watermark_url(),
        'logo' => logo_data_uri() ?? logo_url(),
    ])
</body>
</html>
