<div style="padding: 1rem;">
    <table style="direction: rtl;width: 100%">
        <tr>
            <td width="33.3%" style="text-align: right">
                @lang("admin.transaction_invoice.bill_info")
            </td>
            <td width="33.3%" style="text-align: left">
                @lang("admin.payment_method")
            </td>
        </tr>
        <tr >
            <td style="text-align: right">
                <p>
                <span class="text-muted"> @lang("admin.transaction_invoice.client_sale"): </span>
                {{ $order->customer_name ?? null }} </p>
                <p>
                <span class="text-muted">الجوال : </span>
                {{ $order->transaction?->customer?->phone ?? null }}
                </p>
            </td>

            <td style="text-align: left">
                <span style="background-color: lightgreen; color: gray; font-size: 16px; padding:5px; border-radius: 5px">
                    {{ $order->getPaymentMethod() }}
                </span>
            </td>
        </tr>
    </table>
</div>
