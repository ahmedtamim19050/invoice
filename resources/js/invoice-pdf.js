import html2pdf from 'html2pdf.js';

function downloadInvoicePdf(element, filename) {
    const options = {
        margin: 0,
        filename,
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: {
            scale: 2,
            useCORS: true,
            allowTaint: true,
            backgroundColor: '#ffffff',
            logging: false,
        },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
        pagebreak: { mode: ['css', 'legacy'] },
    };

    return html2pdf().set(options).from(element).save();
}

document.addEventListener('DOMContentLoaded', () => {
    const invoice = document.querySelector('.invoice-document--print');

    if (!invoice) {
        return;
    }

    const filename = invoice.dataset.pdfFilename || 'invoice.pdf';

    const runDownload = () => {
        const button = document.getElementById('download-pdf-btn');

        if (button) {
            button.disabled = true;
            button.textContent = 'Generating PDF…';
        }

        return downloadInvoicePdf(invoice, filename).finally(() => {
            if (button) {
                button.disabled = false;
                button.textContent = 'Download PDF';
            }
        });
    };

    const downloadButton = document.getElementById('download-pdf-btn');

    if (downloadButton) {
        downloadButton.addEventListener('click', () => runDownload());
    }

    if (new URLSearchParams(window.location.search).get('download') === '1') {
        runDownload();
    }

    if (new URLSearchParams(window.location.search).get('auto') === '1') {
        window.print();
    }
});
