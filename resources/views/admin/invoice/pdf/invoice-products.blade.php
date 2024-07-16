<div style="padding: 1rem;">
    <table style="width: 100%; float: right; margin-top: 1rem; direction: rtl">
        <thead>
        <tr style="background-color: gray;">
            <th style="width: 100px; white-space: normal; padding: 10px" scope="col">
                @lang("admin.transaction_invoice.products_table_header.product_details")
            </th>
            <th style="width: 100px; white-space: normal; padding: 10px" scope="col">
                @lang("admin.transaction_invoice.products_table_header.rate")
            </th>
            <th style="width: 100px; white-space: normal; padding: 10px" scope="col">
                @lang("admin.transaction_invoice.products_table_header.quantity")
            </th>
            <th style="width: 100px; white-space: normal; padding: 10px" scope="col">
                @lang("admin.transaction_invoice.products_table_header.amount")
            </th>
            <th style="width: 100px; white-space: normal; padding: 10px" scope="col">
                @lang("admin.transaction_invoice.products_table_header.tax_value")
            </th>
            <th style="width: 100px; white-space: normal; padding: 10px" scope="col">
                @lang("admin.transaction_invoice.products_table_header.total_with_tax")
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($invoice->invoiceLines as $invoice_line)
            <tr>
                <td style="max-width: 100px" style="text-align: right; padding: 10px">
                        <span style="white-space: normal; padding: 10px font-weight: bold">
                            {{ $invoice_line->description }}
                        </span>
                </td>
                <td style="padding: 10px">
                    {{ number_format($invoice_line->unit_price, 2) }} @lang("translation.sar")
                </td>
                <td style="padding: 10px">
                    {{ $invoice_line->quantity }}
                </td>
                <td style="padding: 10px">
                    {{ number_format($invoice_line->total_without_vat, 2)}} @lang("translation.sar")
                </td>
                <td style="padding: 10px">
                    {{ number_format($invoice_line->vat_amount, 2)}} @lang("translation.sar")
                    ({{ $invoice_line->vat_percentage }}%)
                </td>

                <td style="padding: 10px">
                    {{ number_format($invoice_line->total_with_vat, 2) }} @lang("translation.sar")
                </td>
            </tr>
        @endforeach
        </tbody>
    </table><!--end table-->
    <br>
</div>
