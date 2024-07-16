<div style="padding: 1rem;">
    <table style="direction: rtl;width: 100%">
        <tr>
            <td width="33.3%" style="text-align: right">
                @lang('admin.tax-invoices.orders.vendor'): {{ $order->vendor->name }}
            </td>
            <td width="33.3%" style="text-align: center">
                @lang('translation.tax_num'): {{ $order->vendor->tax_num }}
            </td>
            <td dir="ltr" width="33.3%" style="text-align: left">
                @if ($order->status === \App\Enums\OrderStatus::REFUND)
                    @lang('admin.tax-invoices.orders.refund_invoice_no'): {{ $order->code . '-R' }}
                    <br>
                    <br>
                    @lang('admin.tax-invoices.orders.invoice_no'): #{{ $order->code }}
                @else
                    @lang('admin.tax-invoices.orders.invoice_no'): #{{ $order->code }}
                @endif

            </td>
        </tr>
    </table>
    <br>
    <table style="width: 100%; float: right; margin-top: 1rem; direction: rtl">
        <thead>
            <tr style="background-color: gray;">
                <th style="width: 100px; white-space: normal; padding: 10px" scope="col">
                    @lang('admin.transaction_invoice.services_table_header.service_details')
                </th>
                <th style="width: 100px; white-space: normal; padding: 10px" scope="col">
                    @lang('admin.transaction_invoice.services_table_header.rate')
                </th>
                <th style="width: 100px; white-space: normal; padding: 10px" scope="col">
                    @lang('admin.transaction_invoice.services_table_header.quantity')
                </th>
                <th style="width: 100px; white-space: normal; padding: 10px" scope="col">
                    @lang('admin.transaction_invoice.services_table_header.amount')
                </th>
                <th style="width: 100px; white-space: normal; padding: 10px" scope="col">
                    @lang('admin.transaction_invoice.services_table_header.tax_value')
                </th>
                <th style="width: 100px; white-space: normal; padding: 10px" scope="col">
                    @lang('admin.transaction_invoice.services_table_header.total_with_tax')
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderServices as $servicetItem)
                <tr>
                    <td style="max-width: 100px" style="text-align: right; padding: 10px">
                        <span style="white-space: normal; padding: 10px font-weight: bold">
                            {{ $servicetItem->service?->name }}
                        </span>
                    </td>
                    <td style="padding: 10px">
                        {{ $servicetItem->unit_price }} @lang('translation.sar')
                    </td>
                    <td style="padding: 10px">
                        {{ $servicetItem->quantity }}
                    </td>
                    <td style="padding: 10px">
                        {{ round(($servicetItem->unit_price * $servicetItem->quantity) / "1.$servicetItem->vat_percentage", 2) }}
                        @lang('translation.sar')
                    </td>
                    <td style="padding: 10px">
                        {{ round($servicetItem->unit_price * $servicetItem->quantity - ($servicetItem->unit_price * $servicetItem->quantity) / "1.$servicetItem->vat_percentage", 2) }}
                        @lang('translation.sar') ({{ $servicetItem->vat_percentage }}%)
                    </td>


                    <td style="padding: 10px">
                        {{ $servicetItem->total }} @lang('translation.sar')
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table><!--end table-->
    <br>
</div>
