<tr>
    <td> {{ $row->code }} </td>
    <td> {{ $row->id }} </td>
    <td> {{ $row->created_at?->toDateString() }} </td>
    <td> {{ $row->delivered_at?->toDateString() }} </td>
    <td> {{ $row->sub_total }} @lang("translation.sar") </td>
    <td> {{ $row->vat }} @lang("translation.sar") ({{ $row->vat_percentage }}%) </td>
    <td> {{ $row->total }} @lang("translation.sar") </td>




    <td> {{ round($row->getCompanyProfitWithOutVatPecentage() , 2) }} @lang("translation.sar") </td>
    <td> {{ $row->company_profit - round($row->company_profit / "1.$row->vat_percentage" , 2)}} @lang("translation.sar") ({{ $row->vat_percentage }}%) </td>
    <td> {{ $row->company_profit }} @lang("translation.sar") ({{ $row->company_percentage }}%)</td>
    <td> {{ $row->vendor_amount }} @lang("translation.sar") </td>
</tr>
