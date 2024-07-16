<div style="padding: 1rem; margin-top: 5px">
    <table style="direction: rtl; width: 100%">
        <tr>
            <td style="text-align: right">
                {!! $order->getQrCode() !!}
            </td>
            <td width="40%" style="text-align: left">
                <table style="direction: rtl; width: 100%">
                    <tr>
                        <td style="text-align: right;">@lang("admin.transaction_invoice.sub_total") </td>
                        <td style="text-align: left;">{{ $order->sub_total}} @lang("translation.sar")</td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">@lang("admin.tax-invoices.orders.vat") ({{ $order->vat_percentage }}%)</td>
                        <td style="text-align: left;">{{ $order->vat}} @lang("translation.sar")</td>
                    </tr>

                    <tr>
                            <td style="text-align: right;">@lang("admin.transaction_invoice.sub_from_wallet")</td>
                            <td style="text-align: left;">{{ $order->wallet_amount ?? 0}} @lang("translation.sar")</td>
                    </tr>

                    <tr>
                        <td style="text-align: right;">@lang("admin.transaction_invoice.sub_total_without_vat")</td>
                        <td style="text-align: left;">{{ $order->sub_total ?? 0}} @lang("translation.sar")</td>
                    </tr>
                    <tr class="border-top border-top-dashed fs-15">
                        <td style="text-align: right;">@lang("admin.tax-invoices.orders.total-amount")</td>
                        <th style="text-align: left;">{{ $order->total}} @lang("translation.sar")</th>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</div>
