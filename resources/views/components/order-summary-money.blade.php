<div class="border-top border-top-dashed mt-2">
    <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" style="width:250px">
        <tbody>
            <tr>
                <td>
                    @lang("admin.transaction_invoice.sub_total")
                </td>
                <td class="text-end">
                    {{ $subTotal ?? 0}} @lang("translation.sar")
                </td>
            </tr>
            <tr>
                <td>
                    @lang("admin.transaction_invoice.estimated_tax") ({{ $vatPercentage }}%)
                </td>
                <td class="text-end">
                    {{ $totalVat ?? 0}} @lang("translation.sar")
                </td>
            </tr>
            @if($discount)
                <tr>
                    <td>
                        @lang("admin.transaction_invoice.discount") <small class="text-muted"></small>
                    </td>
                    <td class="text-end">-
                        {{ $discount ?? 0}} @lang("translation.sar")
                    </td>
                </tr>
            @endif
            @if($walletDeduction)
                <tr>
                    <td>
                        @lang("admin.transaction_invoice.sub_from_wallet") <small class="text-muted"></small>
                    </td>
                    <td class="text-end">
                        {{ $walletDeduction ?? 0}} @lang("translation.sar")
                    </td>
                </tr>
            @endif
            @if($totalWithoutVat)
                <tr>
                    <td>
                        @lang("admin.transaction_invoice.sub_total_without_vat") <small class="text-muted"></small>
                    </td>
                    <td class="text-end">
                        {{ $totalWithoutVat ?? 0}} @lang("translation.sar")
                    </td>
                </tr>
            @endif
            {{-- @if($shipping)
            <tr>
                <td>
                    @lang("admin.transaction_invoice.sub_total_without_vat") <small class="text-muted"></small>
                </td>
                <td class="text-end">
                    {{ $shipping->total_shipping_fees ?? 0}} @lang("translation.sar")
                </td>
            </tr>
             @endif --}}
            {{-- @if($delivery)
                <tr>
                    <td>
                        @lang("admin.transaction_invoice.shipping_charge")
                    </td>
                    <td class="text-end">
                        {{ $delivery ?? 0 }} @lang("translation.sar")
                    </td>
                </tr>
            @endif --}}
            <tr class="border-top border-top-dashed fs-15">
                <td scope="row">
                    @lang('admin.transaction_invoice.total_amount')
                </td>
                <td class="text-end">
                    {{ $total  }} @lang("translation.sar")
                </td>
            </tr>
        </tbody>
    </table>
</div>
