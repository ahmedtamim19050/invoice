<div class="invoice-document {{ ($print ?? false) ? 'invoice-document--print' : '' }}">
    <div class="invoice-watermark" style="background-image: url('{{ watermark_url() }}');"></div>

    <div class="invoice-content">
        <header class="invoice-header">
            <div class="invoice-logo">
                <svg viewBox="0 0 80 80" class="invoice-logo-svg" aria-hidden="true">
                    <circle cx="40" cy="40" r="36" fill="none" stroke="#1e4d8c" stroke-width="2"/>
                    <circle cx="40" cy="40" r="28" fill="#f59e0b" opacity="0.15"/>
                    <text x="40" y="48" text-anchor="middle" font-family="Georgia, serif" font-size="28" font-weight="bold" fill="#1e4d8c">B</text>
                </svg>
                <div class="invoice-logo-text">
                    <span class="logo-bio">BIO-BEE</span>
                    <span class="logo-health">Healthcare</span>
                </div>
            </div>

            <div class="invoice-company">
                <h1 class="company-name">BIO-BEE HEALTHCARE</h1>
                <p class="company-tagline">(Importers, Suppliers, Medical, Surgical, Hospital Equipment, Diagnostic Products &amp; Consumables)</p>
            </div>
        </header>

        <h2 class="invoice-title">Bill</h2>

        <section class="invoice-to">
            <p><strong>To:</strong></p>
            <p>{{ $invoice->recipient_name }}</p>
            <p>{{ $invoice->recipient_address }}</p>
            <p>{{ $invoice->recipient_contact }}</p>
        </section>

        <p class="invoice-subject"><strong>Subject: {{ $invoice->subject }}</strong></p>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th class="col-sl">SL. No:</th>
                    <th class="col-desc">Description of Equipment:</th>
                    <th class="col-qty">Quantity<br>(Nos):</th>
                    <th class="col-unit">Unit Price:</th>
                    <th class="col-total">Total Price:</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->items as $index => $item)
                    <tr>
                        <td class="text-center">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div class="item-desc">{{ $item->description }}</div>
                            @if ($item->capacity)
                                <div>Capacity: {{ $item->capacity }}</div>
                            @endif
                            @if ($item->brand)
                                <div>Brand: {{ $item->brand }}</div>
                            @endif
                            @if ($item->origin)
                                <div>Origin: {{ $item->origin }}</div>
                            @endif
                        </td>
                        <td class="text-center">{{ str_pad($item->quantity, 2, '0', STR_PAD_LEFT) }}</td>
                        <td class="text-right">{{ format_taka($item->unit_price) }}</td>
                        <td class="text-right">{{ format_taka($item->total_price) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"></td>
                    <td class="total-label text-right"><strong>Total Amount=</strong></td>
                    <td class="text-right total-value"><strong>{{ format_taka($invoice->total_amount) }}</strong></td>
                </tr>
            </tfoot>
        </table>

        <div class="invoice-bottom">
            <p class="amount-words"><strong>In Word:</strong> {{ amount_in_words($invoice->total_amount) }}</p>

          
        </div>

        <footer class="invoice-footer">
            <p>House: 45, Kallyanpur, Mirpur, Dhaka-1207, Bangladesh.</p>
            <p>Mobile: +8801783012185</p>
            <p>Email: biobeehealthcare@gmail.com</p>
        </footer>
    </div>
</div>
