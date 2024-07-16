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
                @lang("admin.tax-invoices.orders.invoice_no"): #{{ $order->code }}
            </td>
        </tr>
    </table>
    <br>
    <table style="width: 100%; float: right; margin-top: 1rem; direction: rtl">
        <thead>
            <tr style="background-color: gray;">
                <th style="width: 100px; white-space: normal; padding: 10px" scope="col">
                    @lang("admin.transaction_invoice.services_table_header.service_details")
                </th>
                <th style="width: 100px; white-space: normal; padding: 10px" scope="col">
                    @lang("admin.transaction_invoice.services_table_header.rate")
                </th>
                <th style="width: 100px; white-space: normal; padding: 10px" scope="col">
                    @lang("admin.transaction_invoice.services_table_header.quantity")
                </th>
                <th style="width: 100px; white-space: normal; padding: 10px" scope="col">
                    @lang("admin.transaction_invoice.services_table_header.amount")
                </th>
                <th style="width: 100px; white-space: normal; padding: 10px" scope="col">
                    @lang("admin.transaction_invoice.services_table_header.tax_value")
                </th>
                <th style="width: 100px; white-space: normal; padding: 10px" scope="col">
                    @lang("admin.transaction_invoice.services_table_header.total_with_tax")
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderServices as $serviceItem)
                <tr>
                    <td style="max-width: 100px" style="text-align: right; padding: 10px">
                        <span style="white-space: normal; padding: 10px font-weight: bold">
                            {{ $serviceItem->service?->name }}
                        </span>
                    </td>
                    <td style="padding: 10px">
                        {{ $serviceItem->unit_price }} @lang("translation.sar")
                    </td>
                    <td style="padding: 10px">
                        {{ $serviceItem->quantity }}
                    </td>
                    <td style="padding: 10px">
                        {{ round(($serviceItem->unit_price *  $serviceItem->quantity) / "1.$serviceItem->vat_percentage",2)}} @lang("translation.sar")
                    </td>
                    <td style="padding: 10px">
                        {{round(($serviceItem->unit_price *  $serviceItem->quantity)- (($serviceItem->unit_price *  $serviceItem->quantity) / "1.$serviceItem->vat_percentage"),2) }}
                        @lang("translation.sar") ({{ $serviceItem->vat_percentage }}%)
                    </td>


                    <td style="padding: 10px">
                        {{ $serviceItem->total }} @lang("translation.sar")
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table><!--end table-->
    <br>
</div>
