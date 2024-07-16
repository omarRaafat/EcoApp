<div class="border-top border-top-dashed mt-2">
    <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" style="width:250px">
        <tbody>
            <tr>
                <td>
                    @lang("admin.transaction_invoice.sub_total")
                </td>
                <td class="text-end">
                    {{ $transaction->sub_total ?? 0}} @lang("translation.sar")
                </td>
            </tr>
            <tr>
                <td>
                    @lang("admin.transaction_invoice.estimated_tax") ({{ $transaction->vat_percentage }}%)
                </td>
                <td class="text-end">
                    {{ $transaction->total_vat ?? 0}} @lang("translation.sar")
                </td>
            </tr>
            @if($transaction->discount)
                <tr>
                    <td>
                        @lang("admin.transaction_invoice.discount") <small class="text-muted"></small>
                    </td>
                    <td class="text-end">-
                        {{ $transaction->discount ?? 0}} @lang("translation.sar")
                    </td>
                </tr>
            @endif
            <tr>
                <td>
                    @lang("admin.transaction_invoice.sub_total_without_vat") <small class="text-muted"></small>
                </td>
                <td class="text-end">
                    {{ $transaction->sub_total ?? 0}} @lang("translation.sar")
                </td>
            </tr>
            {{-- @if($transaction->wallet_amount > 0) --}}
                <tr>
                    <td>
                        @lang("admin.transaction_invoice.sub_from_wallet") <small class="text-muted"></small>
                    </td>
                    <td class="text-end">
                        {{ $transaction->orders()->sum('wallet_amount') ?? 0}} @lang("translation.sar")
                    </td>
                </tr>
            {{-- @endif/ --}}
            {{-- @if($transaction-totalWithoutVat) --}}

            {{-- @endif --}}
            <tr>
                <td>
                    @lang("admin.delivery.domestic-zones.deliver-fees")  <small class="text-muted"></small>
                </td>
                <td class="text-end">
                    {{ $transaction->orderVendorShippings()->sum('total_shipping_fees') ?? 0}} @lang("translation.sar")
                </td>
            </tr>
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
                    {{ $transaction->total  }} @lang("translation.sar")
                </td>
            </tr>
        </tbody>
    </table>
</div>

        {{-- @include("components.order-summary-money", [
            "subTotal" => $transaction->sub_total_in_sar_rounded,
            "vatPercentage" => $transaction->vat_percentage,
            "totalVat" => $transaction->total_vat_in_sar_rounded,
            "discount" => $transaction->discount ? $transaction->discount_in_sar_rounded : null,
            "walletDeduction" => $transaction->wallet_deduction ? $transaction->wallet_deduction_in_sar_rounded : null,
            "totalWithoutVat" => $transaction->total_without_vat_in_sar_rounded,
            "delivery" => $transaction->delivery_fees_in_sar_rounded,
            "total" => $transaction->total_amount_rounded,
        ]) --}}
