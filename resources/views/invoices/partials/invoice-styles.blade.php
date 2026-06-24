<style>
{!! file_get_contents(resource_path('css/invoice-document.css')) !!}

@page {
    size: A4 portrait;
    margin: 0;
}

body.invoice-print-page {
    margin: 0;
    padding: 1.25rem;
    background: #e2e8f0;
    min-height: 100vh;
}

.invoice-document--print {
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(15, 23, 42, 0.12);
    margin: 0 auto;
    width: 100%;
    max-width: 210mm;
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
        border-radius: 0 !important;
        box-shadow: none !important;
        min-height: 297mm !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    .invoice-watermark {
        opacity: 0.09 !important;
    }

    .invoice-watermark,
    .invoice-header-box,
    .invoice-table thead th,
    .invoice-table tfoot td,
    .invoice-title,
    .invoice-contact,
    .amount-words,
    .invoice-signature {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
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
    transition: background 0.15s ease;
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
</style>
