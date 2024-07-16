<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@lang('admin.reports.SalesAllVendors')</title>
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
        <h4> @lang("admin.reports.SalesAllVendors") </h4>
    </div>
    <div>
        <h6>
            @lang("reports.vendors-orders.date"): {{ now()->toDateTimeString() }} <br>
            @if( request()->get('from') )
                @lang("reports.date-range"): {{ request()->get('from') }} / {{ request()->get('to') }}
            @endif
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
                                <th>المتجر</th>
                                <th>مجموع الطلبات بدون VAT</th>
                                <th>قيمة الضريبة</th>
                                <th>مجموع الطلبات مع VAT</th>
                                <th style="width: 15%">عمولة المنصة بدون VAT</th>
                                <th>قيمة ضريبة عمولة المنصة</th>
                                <th>عمولة المنصة مع VAT</th>
                                <th>مستحقات التاجر</th>
                                <th>خصومات التاجر </th>
                                <th>الصافي للتاجر</th>
                        </tr>
                            </thead>
                            <tbody class="list form-check-all">
                            @php
                                $total_without_vat = 0;
                                $total_vat = 0;
                                $total_with_vat = 0;
                                $total_company_profit_without_vat = 0;
                                $value_of_company_profit_vat = 0;
                                $total_company_profit = 0;
                                $total_balance = 0;
                                $vendorOut=0; $vendorNet=0;
                            @endphp

                            @foreach($getOrders as $item)
                                <tr>
                                    <td>{{ $item->vendor->name }}</td>
                                    <td>{{ $item->total_without_vat }}</td>
                                    <td>{{ $item->total_vat }}</td>
                                    <td>{{ $item->total_with_vat }}</td>
                                    <td>{{ $item->total_company_profit_without_vat }}</td>
                                    <td>{{ $item->value_of_company_profit_vat }}</td>
                                    <td>{{ $item->total_company_profit }}</td>
                                    <td>{{ $item->total_balance }}</td>
                                    <td>{{ $item->totalVendorOut()  }}</td>
                                    <td>{{ $item->total_balance - $item->totalVendorOut()  }}</td>

                                </tr>
                                {{-- Update the sums --}}
                                @php
                                    $total_without_vat += $item->total_without_vat;
                                    $total_vat += $item->total_vat;
                                    $total_with_vat += $item->total_with_vat;
                                    $total_company_profit_without_vat += $item->total_company_profit_without_vat;
                                    $value_of_company_profit_vat += $item->value_of_company_profit_vat;
                                    $total_company_profit += $item->total_company_profit;
                                    $total_balance += $item->total_balance;
                                    $vendorOut += $item->totalVendorOut();
                                    $vendorNet += $item->total_balance - $item->totalVendorOut()
                                @endphp
                            @endforeach

                            {{-- Display the sums as the last row --}}
                            <tr>
                                <td><H5>Total:</h5></td>
                                <td>{{ $total_without_vat }}</td>
                                <td>{{ $total_vat }}</td>
                                <td>{{ $total_with_vat }}</td>
                                <td>{{ $total_company_profit_without_vat }}</td>
                                <td>{{ $value_of_company_profit_vat }}</td>
                                <td>{{ $total_company_profit }}</td>
                                <td>{{ $total_balance }}</td>
                                <td>{{ $vendorOut }}</td>
                                <td>{{ $vendorNet }}</td>
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
