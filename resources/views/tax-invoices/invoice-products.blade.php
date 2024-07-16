<div style="padding: 1rem;">
    <table style="direction: rtl;width: 100%">
        <tr>
            <td width="33.3%" style="text-align: right">
                @lang("admin.tax-invoices.orders.vendor"): {{ $order->vendor->name }}
            </td>
            <td width="33.3%" style="text-align: center">
                @lang("translation.tax_num"): {{ $order->vendor->tax_num }}
            </td>
            <td dir="ltr" width="33.3%" style="text-align: left">
                @if ($order->status === \App\Enums\OrderStatus::REFUND)
                    @lang("admin.tax-invoices.orders.refund_invoice_no"): {{ $order->code . '-R' }}
                    <br>
                    <br>
                    @lang("admin.tax-invoices.orders.invoice_no"): #{{ $order->code }}
                @else
                    @lang("admin.tax-invoices.orders.invoice_no"): #{{ $order->code }}
                @endif

            </td>
        </tr>
    </table>
    <br>
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
            @foreach ($order->orderProducts as $productItem)
                <tr>
                    <td style="max-width: 100px" style="text-align: right; padding: 10px">
                        <span style="white-space: normal; padding: 10px font-weight: bold">
                            {{ $productItem->product?->name }}
                        </span>
                        <p class="text-muted" style="white-space: normal; padding: 10px">
                            @lang("admin.transaction_invoice.products_table_header.barcode"):
                            {{$productItem->product?->sku}}
                        </p>
                    </td>
                    <td style="padding: 10px">
                        {{ $productItem->unit_price }} @lang("translation.sar")
                    </td>
                    <td style="padding: 10px">
                        {{ $productItem->quantity }}
                    </td>
                    <td style="padding: 10px">
                        {{ round(($productItem->unit_price *  $productItem->quantity) / "1.$productItem->vat_percentage",2)}} @lang("translation.sar")

                        {{-- {{($productItem->unit_price  *   $productItem->quantity) - (($productItem->unit_price  *   $productItem->quantity * $productItem->vat_percentage) / 100) }} @lang("translation.sar") --}}
                    </td>
                    <td style="padding: 10px">
                        {{round(($productItem->unit_price *  $productItem->quantity)- (($productItem->unit_price *  $productItem->quantity) / "1.$productItem->vat_percentage"),2) }}
                        @lang("translation.sar") ({{ $productItem->vat_percentage }}%)
                    </td>


                    <td style="padding: 10px">
                        {{ $productItem->total }} @lang("translation.sar")
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table><!--end table-->
    <br>
</div>
