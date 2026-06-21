<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bill — {{ $invoice->invoice_number }}</title>
    @include('invoices.partials.invoice-styles')
</head>
<body class="invoice-print-page">
    <div class="no-print toolbar">
        <button type="button" onclick="window.print()" class="print-btn">Print</button>
        <a href="{{ route('invoices.download', $invoice) }}" class="download-btn">Download PDF</a>
        <a href="{{ route('invoices.show', $invoice) }}" class="back-btn">Back to Invoice</a>
    </div>

    @include('invoices.partials.document', [
        'invoice' => $invoice,
        'print' => true,
        'watermark' => watermark_url(),
    ])

    <script>
        window.addEventListener('load', () => {
            if (new URLSearchParams(window.location.search).get('auto') === '1') {
                window.print();
            }
        });
    </script>
</body>
</html>
