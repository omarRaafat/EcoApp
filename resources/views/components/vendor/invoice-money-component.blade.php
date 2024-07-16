<div class="border-top border-top-dashed mt-2">
    <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" style="width:250px">
        <tbody>
        <tr>
            <td>
                @lang("admin.transaction_invoice.sub_total")
            </td>
            <td class="text-end">
                {{ $order->sub_total ?? 0}} @lang("translation.sar")
            </td>
        </tr>
        <tr>
            <td>@lang("admin.tax-invoices.orders.vat") ({{ $order->vat_percentage }}%)</td>
            <td class="text-end">
                {{ $order->vat ?? 0}} @lang("translation.sar")
            </td>
        </tr>
        @if(!is_null($order->discount) && $order->discount > 0)
            <tr>
                <td>
                    @lang("admin.transaction_invoice.discount") <small class="text-muted"></small>
                </td>
                <td class="text-end">-
                    {{ $order->discount }} @lang("translation.sar")
                </td>
            </tr>
        @endif
        @if(!is_null($order->sub_total))
        <tr>
            <td>
                @lang("admin.transaction_invoice.sub_total_without_vat") <small class="text-muted"></small>
            </td>
            <td class="text-end">
                {{ $order->sub_total ?? 0}} @lang("translation.sar")
            </td>
        </tr>
    @endif
        <tr>
            <td>
                @lang("admin.transaction_invoice.sub_from_wallet") <small class="text-muted"></small>
            </td>
            <td class="text-end">
                {{ $order->wallet_amount ?? 0}} @lang("translation.sar")
            </td>
        </tr>

      

        <tr>
            <td>
                @lang("admin.delivery.domestic-zones.deliver-fees") <small class="text-muted"></small>
            </td>
            <td class="text-end">
                {{ $order->orderVendorShippings()->where('vendor_id' , $order->vendor_id)->first()?->total_shipping_fees ?? 0}} @lang("translation.sar")
            </td>
        </tr>


        <tr class="border-top border-top-dashed fs-15">
            <td scope="row">
                @lang('admin.transaction_invoice.total_amount')
            </td>
            <td class="text-end">
                
                {{ $order->total + $order->orderVendorShippings()->where('vendor_id' , $order->vendor_id)->first()?->total_shipping_fees  }} @lang("translation.sar")
            </td>
        </tr>
        </tbody>
    </table>
</div>
