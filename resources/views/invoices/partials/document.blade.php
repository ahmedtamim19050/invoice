<div
    class="invoice-document {{ ($print ?? false) ? 'invoice-document--print' : '' }}"
    @if ($print ?? false) data-pdf-filename="{{ str_replace('/', '-', $invoice->invoice_number) }}.pdf" @endif
>
    <img
        class="invoice-watermark"
        src="{{ $watermark ?? watermark_data_uri() ?? watermark_url() }}"
        alt=""
        aria-hidden="true"
    >

    <div class="invoice-content">
        <header class="invoice-header">
            <div class="invoice-header-box">
                <table class="invoice-header-table" cellpadding="0" cellspacing="0" align="center">
                    <tr>
                        <td class="invoice-logo-cell">
                            <div class="invoice-logo">
                                <img
                                    src="{{ $logo ?? logo_data_uri() ?? logo_url() }}"
                                    alt="BIO-BEE Healthcare"
                                >
                            </div>
                        </td>
                        <td class="invoice-company-cell">
                            <div class="invoice-company">
                                <h1 class="company-name">BIO-BEE HEALTHCARE</h1>
                                <p class="company-tagline">Importers, Suppliers, Medical, Surgical, Hospital Equipment, Diagnostic Products &amp; Consumables</p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </header>

        <div class="invoice-title-wrap">
            <h2 class="invoice-title">Bill</h2>
        </div>

        <table class="invoice-meta" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td class="invoice-to" width="58%" valign="top">
                    <p><strong>To:</strong></p>
                    <p>{{ $invoice->recipient_name }}</p>
                    <p>{{ $invoice->recipient_address }}</p>
                    <p>{{ $invoice->recipient_contact }}</p>
                </td>
                <td class="invoice-meta-side" width="42%" valign="top" align="right">
                    <p><strong>Invoice No:</strong> {{ $invoice->invoice_number }}</p>
                    <p><strong>Date:</strong> {{ $invoice->created_at->format('d M, Y') }}</p>
                </td>
            </tr>
        </table>

        <p class="invoice-subject"><strong>Subject: {{ $invoice->subject }}</strong></p>

        <div class="invoice-table-wrap">
            <table class="invoice-table" width="100%">
                <colgroup>
                    <col class="col-sl" style="width:8%">
                    <col class="col-desc" style="width:40%">
                    <col class="col-qty" style="width:11%">
                    <col class="col-unit" style="width:18%">
                    <col class="col-total" style="width:19%">
                </colgroup>
                <thead>
                    <tr>
                        <th class="col-sl">SL. No</th>
                        <th class="col-desc">Description of Equipment</th>
                        <th class="col-qty">Quantity<br>(Nos)</th>
                        <th class="col-unit">Unit Price</th>
                        <th class="col-total">Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->items as $index => $item)
                        <tr>
                            <td class="text-center">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div class="item-desc">{{ $item->description }}</div>
                                @if ($item->capacity)
                                    <div class="item-meta">Capacity: {{ $item->capacity }}</div>
                                @endif
                                @if ($item->brand)
                                    <div class="item-meta">Brand: {{ $item->brand }}</div>
                                @endif
                                @if ($item->origin)
                                    <div class="item-meta">Origin: {{ $item->origin }}</div>
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
                        <td class="total-label text-right"><strong>Total Amount</strong></td>
                        <td class="text-right total-value"><strong>{{ format_taka($invoice->total_amount) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="invoice-bottom">
            <p class="amount-words"><span class="amount-words-label">In Word:</span> {{ amount_in_words($invoice->total_amount) }}</p>

            <div class="invoice-signature">
                <img src="{{ asset('signeture.png') }}" alt="" class="invoice-signature-img">
                <div class="invoice-signature-line"></div>
                <p class="invoice-signature-name">Eng. Sakil Sikder</p>
            </div>
        </div>
    </div>

    <footer class="invoice-contact">
        <p>House: 45, Kallyanpur, Mirpur, Dhaka-1207, Bangladesh.</p>
        <p>Mobile: +8801783012185 · Email: biobeehealthcare@gmail.com</p>
    </footer>
</div>
