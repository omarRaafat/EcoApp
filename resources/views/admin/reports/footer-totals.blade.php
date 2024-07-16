<table class="table-card table align-middle" style="margin: 0!important;">
    <thead class="text-muted table-light">
    <tr class="text-uppercase">
        <th>@lang('reports.vendors-orders.sum-total-without-vat')</th>
        <th>@lang('reports.vendors-orders.sum-vat-rate')</th>
        <th>@lang('reports.vendors-orders.sum-total-with-vat')</th>
        <th>@lang('reports.vendors-orders.sum-company-profit-without-vat')</th>
        <th>@lang('reports.vendors-orders.sum-company-profit-vat-rate')</th>
        <th>@lang('reports.vendors-orders.sum-company-profit-with-vat')</th>
        <th>@lang('reports.vendors-orders.sum-vendor-amount')</th>
    </tr>
    </thead>
    <tbody class="list form-check-all">
    <tr>
        <td> {{ number_format($totals['sub_total_in_sar_rounded'] ?? 0 ,2) }} @lang("translation.sar") </td>
        <td> {{ number_format($totals['vat_in_sar_rounded'] ?? 0 ,2) }} @lang("translation.sar") </td>
        <td> {{ number_format($totals['total_in_sar_rounded'] ?? 0 ,2) }} @lang("translation.sar") </td>
        <td> {{ number_format($totals['company_profit_without_vat_in_sar_rounded'] ?? 0 ,2) }} @lang("translation.sar") </td>
        <td> {{ number_format($totals['company_profit_vat_rate_rounded'] ?? 0 ,2) }} @lang("translation.sar") </td>
        <td> {{ number_format($totals['company_profit_in_sar_rounded'] ?? 0 ,2) }} @lang("translation.sar") </td>
        <td> {{ number_format($totals['vendor_amount_in_sar_rounded'] ?? 0 ,2) }} @lang("translation.sar") </td>
    </tr>
    </tbody>
</table>
