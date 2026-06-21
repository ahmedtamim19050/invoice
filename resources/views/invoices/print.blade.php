<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bill — {{ $invoice->invoice_number }}</title>
    @vite(['resources/css/app.css', 'resources/css/invoice-print.css'])
</head>
<body class="invoice-print-page">
    <div class="no-print toolbar">
        <button type="button" onclick="window.print()" class="print-btn">Print / Save as PDF</button>
        <a href="{{ route('invoices.show', $invoice) }}" class="back-btn">Back to Invoice</a>
    </div>

    @include('invoices.partials.document', ['invoice' => $invoice, 'print' => true])

    <script>
        window.addEventListener('load', () => {
            if (new URLSearchParams(window.location.search).get('auto') === '1') {
                window.print();
            }
        });
    </script>
</body>
</html>
