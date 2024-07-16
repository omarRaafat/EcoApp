<div style="padding: 1rem; margin-top: 5px">
    <table style="direction: rtl; width: 100%">
        <tr>
            <td style="text-align: right">
                {!! $invoice->getQrCode() !!}
            </td>
            <td width="40%" style="text-align: left">
                <table style="direction: rtl; width: 100%">
                    <tr>
                        <td style="text-align: right;">@lang('Invoice.attributes.total_without_vat')</td>
                        <td style="text-align: left;">{{ number_format($invoice->total_without_vat, 2)}} @lang("translation.sar")</td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">@lang('Invoice.attributes.total_without_vat_1')</td>
                        <td style="text-align: left;">{{ number_format($invoice->total_without_vat, 2)}} @lang("translation.sar")</td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">@lang('Invoice.attributes.vat_amount')
                            ({{$invoice->vat_percentage}}%)
                        </td>
                        <td style="text-align: left;">{{number_format($invoice->vat_amount, 2)}} @lang("translation.sar")</td>
                    </tr>
                    <tr class="border-top border-top-dashed fs-15">
                        <td style="text-align: right;">@lang('Invoice.attributes.total_with_vat')</td>
                        <th style="text-align: left;">{{ number_format($invoice->total_with_vat, 2)}} @lang("translation.sar")</th>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
