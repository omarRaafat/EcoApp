<tr>
    <td> {{ $row?->vendor?->getTranslation("name", "ar") }} </td>
    <td> {{ amountInSarRounded($row->sum_sub_total) }} @lang("translation.sar") </td>
    <td> {{ amountInSarRounded($row->sum_vat) }} @lang("translation.sar") </td>
    <td> {{ amountInSarRounded($row->sum_sub_total + $row->sum_vat) }} @lang("translation.sar") </td>
    <td> {{ amountInSarRounded($row->sum_company_profit - $row->sum_company_profit_vat_rate) }} @lang("translation.sar") </td>
    <td> {{ amountInSarRounded($row->sum_company_profit_vat_rate) }} @lang("translation.sar") </td>
    <td> {{ amountInSarRounded($row->sum_company_profit) }} @lang("translation.sar") </td>
    <td> {{ amountInSarRounded($row->sum_vendor_amount) }} @lang("translation.sar") </td>
    @if(!$noPrint)
        <td>
            <a class="btn btn-success"
               href="{{ route("admin.reports.vendors-orders.print", ['vendor' => $row->vendor_id, 'from' => request()->get('from'), 'to' => request()->get('to')]) }}"
               target="_blank">
                @lang('reports.print-vendor')
            </a>
        </td>
    @endif
</tr>
