<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@lang('admin.reports.vendors_sales')</title>
    @include('admin.layouts.head-css')
    <style type="text/css" media="print">
        @page { size: landscape; }
    </style>
</head>
<body class="p-3">
<div class="d-flex flex-row justify-content-between align-items-end">
{{--    <div>--}}
{{--        <h6> @lang("reports.center-name") </h6>--}}
{{--        <h6> @lang("reports.center-tax-num") </h6>--}}
{{--    </div>--}}
    <div class="text-center">
        <img src="{{ URL::asset('images/logo.png') }}" alt="" height="80">
        <h4> @lang('admin.reports.vendors_sales') </h4>
        @if(isset($vendor))
            <h5>@lang('reports.vendors-orders.vendor') : {{$vendor->getTranslation("name", "ar")}} </h5>

        @endif
        @if(request('from') && request('from') != '' && request('to') && request('to') != '' )
            <h5>@lang('admin.from') :  {{ request('from') }}
                @lang('admin.to')  : {{ request('to') }}</h5>

        @endif
    </div>
    <div>
        <h6>
            @lang("reports.vendors-orders.date"): {{ now()->toDateTimeString() }}
        </h6>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card mt-5">
            <div class="card-body d-flex flex-column gap-4">
                <div>
                    <div class="table-responsive table-card">
                        <table class="table align-middle">
                            <thead class="text-muted table-light">
                            <tr class="text-uppercase">
                                <th>@lang('reports.vendors-orders.vendor')</th>
                                <th>@lang('reports.vendors-orders.sub-order-code')</th>
                                <th>@lang('reports.vendors-orders.order-id')</th>
                                <th>@lang('reports.vendors-orders.created-at')</th>
                                <th>@lang('reports.vendors-orders.delivered-at')</th>
                                <th>@lang('reports.vendors-orders.total-without-vat')</th>
                                <th>@lang('reports.vendors-orders.vat-rate')</th>
                                <th>@lang('reports.vendors-orders.total-with-vat')</th>
                                <th>@lang('reports.vendors-orders.company-profit-without-vat')</th>
                                <th>@lang('reports.vendors-orders.company-profit-vat-rate')</th>
                                <th>@lang('reports.vendors-orders.company-profit-with-vat')</th>
                                <th>@lang('reports.vendors-orders.vendor-amount')</th>
                                <th> خصومات التاجر </th>
                            </tr>
                            </thead>
                            <tbody class="list form-check-all">
                            @foreach($collection ?? [] as $row)
                                <tr>
                                    <td> {{ $row->wallet?->vendor?->getTranslation("name", "ar") ?? 'N/A' }} </td>
                                    <td> {{ $row->order?->code ?? 'N/A' }} </td>
                                    <td> {{ $row->order?->id  ?? 'N/A'}} </td>
                                    <td> {{ $row->created_at?->toDateString() }} </td>
                                    <td> {{ $row->order?->delivered_at?->toDateString() }} </td>
                                    <td> {{ $row->order?->sub_total_in_sar_rounded * 100 }} @lang("translation.sar") </td>
                                    <td> {{ $row->order?->vat_in_sar_rounded  * 100}} @lang("translation.sar") ({{ $row->order?->vat_percentage }}%) </td>
                                    <td> {{ $row->order?->total_in_sar_rounded  * 100}} @lang("translation.sar") </td>
                                    <td> {{ $row->order?->company_profit_without_vat_in_sar_rounded * 100 }} @lang("translation.sar") </td>
                                    <td> {{ $row->order?->company_profit_vat_rate_rounded * 100 }} @lang("translation.sar") ({{ $row->order?->vat_percentage }}%) </td>
                                    <td> {{ $row->order?->company_profit_in_sar_rounded * 100 }} @lang("translation.sar") ({{ $row->order?->company_percentage }}%)</td>
                                    <td> {{ $row->operation_type == 'in' ? $row->amount : '0' }}  @lang("translation.sar") </td> 
                                    <td> {{ $row->operation_type == 'out' ? $row->amount : '0' }}  @lang("translation.sar") </td> 
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <table class="table align-middle">
                            <thead class="text-muted table-light">
                            <tr class="text-uppercase">
                                <th>@lang('reports.vendors-orders.sum-total-without-vat')</th>
                                <th>@lang('reports.vendors-orders.sum-vat-rate')</th>
                                <th>@lang('reports.vendors-orders.sum-total-with-vat')</th>
                                <th>@lang('reports.vendors-orders.sum-company-profit-without-vat')</th>
                                <th>@lang('reports.vendors-orders.sum-company-profit-vat-rate')</th>
                                <th>@lang('reports.vendors-orders.sum-company-profit-with-vat')</th>
                                <th>@lang('reports.vendors-orders.sum-vendor-amount')</th>
                                <th>مجموع خصومات التجار</th>
                            </tr>
                            </thead>
                            <tbody class="list form-check-all">
                            <tr>
                                <td>{{$sub_total_in_sar_rounded}}</td>
                                <td>{{$vat_in_sar_rounded}}</td>
                                <td>{{$total_in_sar_rounded}}</td>
                                <td>{{$company_profit_without_vat_in_sar_rounded}}</td>
                                <td>{{$company_profit_vat_rate_rounded}}</td>
                                <td>{{$company_profit_in_sar_rounded}}</td>
                                <td>{{$vendor_amount_in_sar_rounded}}</td>
                                <td>{{$vendor_out_in_sar_rounded}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@php
    echo "<script> window.print() </script>"
@endphp
</body>
</html>
