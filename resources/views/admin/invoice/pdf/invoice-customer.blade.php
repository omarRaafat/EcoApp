<div style="padding: 1rem;">
    <table style="direction: rtl;width: 100%">
        <tr>
            <td width="33.3%" style="text-align: right">
                @lang("admin.transaction_invoice.bill_info")
            </td>
        </tr>
        <tr>
            <td style="text-align: right">
                <p>
                    <span class="text-muted"> @lang("admin.transaction_invoice.client_sale"): </span>
                    {{ $invoice->vendor->owner->name }} </p>
                <p>
                    <span class="text-muted"> العنوان: </span>
                    {{ $invoice->vendor_data["street"] }} </p>
{{--                <p>--}}
{{--                    <span class="text-muted"> السجل التجاري: </span>--}}
{{--                    {{ $invoice->vendor_data["commercial_registration_no"] }} </p>--}}
                <p>
                    <span class="text-muted"> الرقم الضريبي: </span>
                    {{ $invoice->vendor_data["tax_num"] }} </p>
                <p>
                    <span class="text-muted">الجوال : </span>
                    {{ $invoice->vendor_data["second_phone"] }}
                </p>
            </td>

            <td style="text-align: left">
            </td>
        </tr>
    </table>
</div>
