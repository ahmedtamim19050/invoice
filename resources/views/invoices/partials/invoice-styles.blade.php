<style>
{!! file_get_contents(resource_path('css/invoice-document.css')) !!}

@page {
    size: A4;
    margin: 12mm;
}

@if ($forPdf ?? false)
    html,
    body {
        margin: 0;
        padding: 0;
        background: #fff;
    }

    .invoice-document,
    .invoice-document--print {
        max-width: none;
        min-height: auto;
        margin: 0;
        width: 100%;
        box-shadow: none;
    }

    .invoice-header {
        display: table;
        width: 100%;
    }

    .invoice-logo {
        display: table-cell;
        width: 90px;
        vertical-align: top;
    }

    .invoice-company {
        display: table-cell;
        vertical-align: top;
    }
@else
    body.invoice-print-page {
        margin: 0;
        padding: 1rem;
        background: #e2e8f0;
        min-height: 100vh;
    }

    .invoice-document--print {
        box-shadow: none;
        margin: 0 auto;
        width: 100%;
        max-width: none;
    }

    @media print {
        body.invoice-print-page {
            margin: 0;
            padding: 0;
            background: #fff;
        }

        .no-print {
            display: none !important;
        }

        .invoice-document--print {
            margin: 0 !important;
            width: 100% !important;
            max-width: none !important;
        }
    }

    .toolbar {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .print-btn,
    .download-btn,
    .back-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.75rem;
        padding: 0.625rem 1.25rem;
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        border: none;
    }

    .print-btn {
        background: #0284c7;
        color: #fff;
    }

    .print-btn:hover {
        background: #0369a1;
    }

    .download-btn {
        background: #059669;
        color: #fff;
    }

    .download-btn:hover {
        background: #047857;
    }

    .back-btn {
        background: #fff;
        color: #334155;
        border: 1px solid #cbd5e1;
    }

    .back-btn:hover {
        background: #f8fafc;
    }
@endif
</style>
