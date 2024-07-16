<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@lang('reports.total-vendors-orders.title')</title>
    @include('admin.layouts.head-css')
    <style type="text/css" media="print">
        @page { size: landscape; }
    </style>
</head>
<body class="p-3">
    <div class="d-flex flex-row justify-content-between align-items-end">
        <div>
            <h6> @lang("reports.center-name") </h6>
            <h6> @lang("reports.center-tax-num") </h6>
        </div>
        <div class="text-center">
            <img src="{{ URL::asset('images/logo.png') }}" alt="" height="80">
            <h4> @lang("reports.total-vendors-orders.print-vendors") </h4>
            <span style="font-size: 16px"> @lang("reports.report-date", ['from' => request()->get("from", "---"), 'to' => request()->get("to", "---")]) </span>
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
                <div class="card-body d-flex flex-column">
                    <div>
                        <div class="table-responsive table-card">
                            <table class="table align-middle">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th>@lang('reports.total-vendors-orders.vendor')</th>
                                    <th>@lang('reports.total-vendors-orders.total-without-vat')</th>
                                    <th>@lang('reports.total-vendors-orders.vat-rate')</th>
                                    <th>@lang('reports.total-vendors-orders.total-with-vat')</th>
                                    <th>@lang('reports.total-vendors-orders.company-profit-without-vat')</th>
                                    <th>@lang('reports.total-vendors-orders.company-profit-vat-rate')</th>
                                    <th>@lang('reports.total-vendors-orders.company-profit-with-vat')</th>
                                    <th>@lang('reports.total-vendors-orders.vendor-amount')</th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @php
                                    if($collection instanceof \Illuminate\Database\Eloquent\Builder) {
                                        $collection->lazy()->each(function($row) use (&$totals) {
                                            echo view("admin.reports.totals-vendors-orders.row", ['row' => $row, 'noPrint' => true]);
                                        });
                                    }
                                @endphp
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-5">
                <div class="card-body p-0">
                    @include("admin.reports.footer-totals")
                </div>
            </div>
        </div>
    </div>
    @php
        echo "<script> window.print() </script>"
    @endphp
</body>
</html>
