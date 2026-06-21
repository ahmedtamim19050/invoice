<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Bill — {{ $invoice->invoice_number }}</title>
    @include('invoices.partials.invoice-styles', ['forPdf' => true])
</head>
<body>
    @include('invoices.partials.document', [
        'invoice' => $invoice,
        'print' => true,
        'watermark' => $watermark ?? watermark_url(),
    ])
</body>
</html>
