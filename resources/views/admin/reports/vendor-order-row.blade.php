<tr>
    <td> {{ $row?->vendor?->getTranslation("name", "ar") }} </td>
    <td> {{ $row->code }} </td>
    <td> {{ $row->id }} </td>
    <td> {{ $row->created_at?->toDateString() }} </td>
    <td> {{ $row->delivered_at?->toDateString() }} </td>
    <td> {{ $row->sub_total_in_sar_rounded }} @lang("translation.sar") </td>
    <td> {{ $row->vat_in_sar_rounded }} @lang("translation.sar") ({{ $row->vat_percentage }}%) </td>
    <td> {{ $row->total_in_sar_rounded }} @lang("translation.sar") </td>
    <td> {{ $row->company_profit_without_vat_in_sar_rounded }} @lang("translation.sar") </td>
    <td> {{ $row->company_profit_vat_rate_rounded }} @lang("translation.sar") ({{ $row->vat_percentage }}%) </td>
    <td> {{ $row->company_profit_in_sar_rounded }} @lang("translation.sar") ({{ $row->company_percentage }}%)</td>
    <td> {{ $row->vendor_amount_in_sar_rounded }} @lang("translation.sar") </td>
</tr>
