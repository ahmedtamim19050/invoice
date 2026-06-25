document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('invoice-form');
    const container = document.getElementById('items-container');
    const template = document.getElementById('item-row-template');
    const addBtn = document.getElementById('add-item-btn');
    const grandTotalEl = document.getElementById('grand-total');
    const initialItemsEl = document.getElementById('invoice-initial-items');

    if (!form || !container || !template || !addBtn) {
        return;
    }

    const formatMoney = (value) => {
        return new Intl.NumberFormat('en-US').format(Math.round(value));
    };

    const updateRowTotal = (row) => {
        const qty = parseFloat(row.querySelector('[data-field="quantity"]')?.value) || 0;
        const price = parseFloat(row.querySelector('[data-field="unit_price"]')?.value) || 0;
        const total = qty * price;
        const lineTotalEl = row.querySelector('.line-total');

        if (lineTotalEl) {
            lineTotalEl.textContent = `৳ ${formatMoney(total)}`;
        }

        updateGrandTotal();
    };

    const updateGrandTotal = () => {
        let total = 0;

        container.querySelectorAll('.item-row').forEach((row) => {
            const qty = parseFloat(row.querySelector('[data-field="quantity"]')?.value) || 0;
            const price = parseFloat(row.querySelector('[data-field="unit_price"]')?.value) || 0;
            total += qty * price;
        });

        grandTotalEl.textContent = `৳ ${formatMoney(total)}`;
    };

    const syncFieldNames = () => {
        container.querySelectorAll('.item-row').forEach((row, index) => {
            row.querySelector('.item-label').textContent = `Item ${index + 1}`;

            row.querySelectorAll('[data-field]').forEach((input) => {
                const field = input.dataset.field;
                input.name = `items[${index}][${field}]`;
            });

            const removeBtn = row.querySelector('.remove-item-btn');
            removeBtn.style.display = container.querySelectorAll('.item-row').length > 1 ? 'inline' : 'none';
        });
    };

    const bindRowEvents = (row) => {
        row.querySelectorAll('.qty-input, .price-input').forEach((input) => {
            input.addEventListener('input', () => updateRowTotal(row));
        });

        row.querySelector('.remove-item-btn')?.addEventListener('click', () => {
            if (container.querySelectorAll('.item-row').length <= 1) {
                return;
            }

            row.remove();
            syncFieldNames();
            updateGrandTotal();
        });
    };

    const setFieldValue = (row, field, value) => {
        const input = row.querySelector(`[data-field="${field}"]`);

        if (input && value !== null && value !== undefined && value !== '') {
            input.value = value;
        }
    };

    const addItem = (data = {}) => {
        const clone = template.content.cloneNode(true);
        const row = clone.querySelector('.item-row');

        container.appendChild(row);

        const element = container.lastElementChild;

        setFieldValue(element, 'description', data.description);
        setFieldValue(element, 'capacity', data.capacity);
        setFieldValue(element, 'brand', data.brand);
        setFieldValue(element, 'origin', data.origin);
        setFieldValue(element, 'quantity', data.quantity ?? 1);
        setFieldValue(element, 'unit_price', data.unit_price);

        syncFieldNames();
        bindRowEvents(element);
        updateRowTotal(element);
    };

    addBtn.addEventListener('click', () => addItem());

    let initialItems = [];

    if (initialItemsEl?.textContent) {
        try {
            initialItems = JSON.parse(initialItemsEl.textContent);
        } catch {
            initialItems = [];
        }
    }

    if (Array.isArray(initialItems) && initialItems.length > 0) {
        initialItems.forEach((item) => addItem(item));
    } else {
        addItem();
    }
});
