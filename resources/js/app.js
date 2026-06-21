import Swal from 'sweetalert2';

document.addEventListener('DOMContentLoaded', () => {
    const flash = document.getElementById('flash-success');

    if (flash?.dataset.message) {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: flash.dataset.message,
            timer: 2500,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
        });
    }

    document.querySelectorAll('[data-delete-invoice]').forEach((button) => {
        button.addEventListener('click', () => {
            const formId = button.dataset.deleteInvoice;
            const label = button.dataset.invoiceLabel || 'this invoice';
            const form = document.getElementById(formId);

            if (!form) {
                return;
            }

            Swal.fire({
                title: 'Delete invoice?',
                text: `Are you sure you want to delete ${label}? This action cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                focusCancel: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
