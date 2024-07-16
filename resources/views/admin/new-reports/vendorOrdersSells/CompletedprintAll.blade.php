<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('dash/css/bootstrap.min.css') }}">
    <title> طباعة الطلب</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal&display=swap');

        html,
        body {
            font-family: 'Tajawal', sans-serif;
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-top: 1px solid #dee2e6;
            border-left: 1px solid #dee2e6;
            border-right: 1px solid #dee2e6;
            text-align: right;
            direction: rtl;
            line-height: 22px;
            color: #060b26;
        }

        .table td,
        .table th {
            padding: .75rem;
            vertical-align: top;
            border-bottom: 1px solid #dee2e6;
            text-align: right !important;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6
        }

        .table tbody + tbody {
            border-top: 2px solid #dee2e6
        }

        .table .table {
            background-color: #fff
        }

        .page_tttitle {
            margin-top: 0;
            border: 1px solid #43be9b;
            padding: 15px 10px 21px 10px;
            color: #43be9b;
            margin-bottom: 30px;
        }

        body {
            /* portrait */
            padding-right: 25px;
            padding-left: 25px;
        }

        @page {
            size: auto;
            margin: 0mm;
        }

        .row > div {
            display: inline-block;
            margin: 10px 15px
        }
    </style>
    <style>
        #printable {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        html,
        body {
            height: 100%;
            width: 100%;
            text-align: center;
        }

        .qr_code_div > svg {
            width: 75px;
            height: 75px;
        }

        .tablesum89 tr td {
            padding: 5px 5px;
            line-height: 10px;
            border: none;
        }
    </style>
</head>

<body>

<div style="height: 995px;position: absolute;left: 20px;right: 20px;top: 0;">
    <div style="position:relative;margin-top:30px;margin-bottom:30px">
        <img src="{{ asset('storage/settings/' . $site_settings->site_logo) }}" alt="QR" title="QR"
             style="display:block; margin-left: auto; margin-right: auto;" height="45"
             data-auto-embed="attachment"/>
    </div>
    @php
        $SellsTaxs = \App\Models\SellsTaxs::find(1);
    @endphp
    <div style="text-align: right;display:inline-block;width:33%">
        <h6 class="mb-0"> {{ $SellsTaxs->supplier }} </h6>
        <h6> الرقم الضريبي : {{ $SellsTaxs->taxNumber }}</h6>
    </div>
    <div style="text-align: center;display:inline-block;width:33%">
        <h4> تقرير مبيعات البائع الشحنات المستلمة </h4>
        <p>
            @php
                $vendor = \App\Models\Vendor::findOrFail(request()->get('vendor_id'));
            @endphp
            {{ $vendor->shop_name }}
            <br>
            الرقم الضريبي:
           {{ $vendor->taxNumber}}
        </p>
        <p>
        </p>
        <h6 style="text-align: center">
            @if (request()->get('date') != null && request()->get('date') != '')
                <span> تاريخ الطلب من : {{ request()->get('date') }}</span>
            @endif
            @if (request()->get('date_to') != null && request()->get('date_to') != '')
                <span>إلى {{ request()->get('date_to') }}</span>
            @endif
            @if (request()->get('completed_date') != null && request()->get('completed_date') != '')
                <br>
                <span> تاريخ التسليم من : {{ request()->get('completed_date') }}</span>
            @endif
            @if (request()->get('completed_date_to') != null && request()->get('completed_date_to') != '')
                <span> إلى {{ request()->get('completed_date_to') }}</span>
            @endif


        </h6>
    </div>
    <div style="text-align: left;display:inline-block;width:33%">
        <h6 class="mb-0">بتاريخ {{ date('Y-m-d, H:i') }}</h6>
    </div>

    <div style="text-align: left;display:inline-block;width:33%">

    </div>

    <br><br><br>

                @php
                    $vendor_total_witout_vat = 0;
                    $vendor_total_with_vat = 0;
                    $vendor_total_vat = 0;
                    $vendor_total_earn = 0;
                    $sys_commission_without_vat = 0;
                    $sys_commission_vat = 0;
                    $sys_commission_with_vat = 0;
                @endphp
    <div class="text-right">

        <table id="exampleee" class="display table table-bordered" style="width:100%">
            <thead>
            <tr>
                <th>رقم الفاتورة الخاص بالتاجر</th>
                <th>رقم الطلب</th>
                <th>تاريخ انشاء الطلب</th>
                <th>تاريخ التسليم</th>

                <th>قيمة مبيعات التجار غير شاملة VAT</th>
                <th>قيمة الضريبة (15%)</th>
                <th>قيمة مبيعات التجار شاملة VAT</th>

                <th>عمولة المنصة غير شاملة VAT</th>
                <th>قيمة الضريبة على العمولة (15%)</th>
                <th>قيمة عمولة المنصة شاملة VAT</th>
                <th>صافي المستحق للتاجر</th>

                {{--                <th> رقم البوليصة</th>--}}
                {{--                <th> تاريخ الطلب</th>--}}
                {{--                <th> تاريخ التسليم</th>--}}
            </tr>
            </thead>
            <tbody>

            @foreach ($earns as $earn)
                <tr>
                    <td class="text-center">
                        <a href="{{ route('dash.orders.show', $earn->globalorder_id) }}">{{ $earn->vendor_id . $earn->id_rand }}</a>
                    </td>
                    <td class="text-center">{{ $earn->globalorder_id }}</td>
                    <td class="text-center">{{ $earn->order_created_at }}</td>
                    <td class="text-center">{{ $earn->cart_vendor_earns_created_at }}</td>

                    <td class="text-center">
                        {{ number_format($total_without_vat = bcdiv($earn->products_price, 1.15, 4), 2, '.', ',') }}
                        ر.س
                    </td>
                    <td class="text-center">
                        {{ number_format($total_vat = bcmul($total_without_vat ,0.15, 4), 2, '.', ',') }}
                        ر.س
                    </td>
                    <td class="text-center"> {{ number_format($total_with_vat = bcadd($total_without_vat, $total_vat,4), 2, '.', ',') }}
                        ر.س
                    </td>

                    <td class="text-center">
                        {{ number_format($commission_without_vat = bcdiv($earn->dash_earn, 1.15, 4), 2, '.', ',') }}
                    </td>
                    <td class="text-center">
                        {{ number_format($commission_vat = bcmul($commission_without_vat, 0.15, 4), 2, '.', ',') }}</td>
                    <td class="text-center">{{ number_format($commission_with_vat = bcadd($commission_without_vat, $commission_vat, 4), 2, '.', ',') }}</td>
                    <td>{{ number_format($total_earn = bcsub($total_with_vat, $commission_with_vat, 4), 2, '.', ',') }}</td>

                    @php
                        $vendor_total_witout_vat = bcadd($total_without_vat, $vendor_total_witout_vat,4);
                        $vendor_total_vat = bcadd($total_vat, $vendor_total_vat,4);
                        $vendor_total_with_vat = bcadd($total_with_vat, $vendor_total_with_vat, 4);
                        $vendor_total_earn = bcadd($total_earn, $vendor_total_earn,4);
                        $sys_commission_without_vat = bcadd($commission_without_vat, $sys_commission_without_vat,4);
                        $sys_commission_vat = bcadd($commission_vat, $sys_commission_vat,4);
                        $sys_commission_with_vat = bcadd($commission_with_vat, $sys_commission_with_vat, 4);
                    @endphp
{{--                    <td class="text-center">--}}
{{--                        @if (count($earn->cartVendors))--}}
{{--                            <a--}}
{{--                                href="https://www.aramex.com/track/results?ShipmentNumber={{ $earn->cartVendors[0]->tracking }}"--}}
{{--                                target="_blank">--}}
{{--                                {{ $earn->cartVendors[0]->tracking }}--}}
{{--                            </a>--}}
{{--                        @endif--}}
{{--                    </td>--}}
{{--                    <td class="text-center">{{ date('Y-m-d, H:i', strtotime($earn->created_at)) }}</td>--}}
{{--                    <td class="text-center">--}}
{{--                        @if (count($earn->cartVendorEarn))--}}
{{--                            {{ date('Y-m-d, H:i', strtotime($earn->cartVendorEarn[0]->created_at)) }}--}}
{{--                        @else--}}
{{--                            <p class="badge badge-info">{{ $earn->getStatus() }}</p>--}}
{{--                        @endif--}}
{{--                    </td>--}}
                </tr>
            @endforeach
            </tbody>
        </table>
{{--        @if (count($earns))--}}
{{--            {{ $earns->links('pagination.default') }}--}}
{{--        @endif--}}
        <br>
        <div class="">
            <table class="table table-bordered">
                <table class="table table-bordered">
                    <thead>
                    <th>قيمة المبيعات غير شامل VAT</th>
                    <th>قيمة VAT (15%)</th>
                    <th>قيمة المبيعات شامل VAT</th>

                    <th>عمولة المنصة غير شامل VAT</th>
                    <th>قيمة VAT (15%) على عمولة المنصة</th>
                    <th>عمولة المنصة شامل VAT</th>

                    <th>صافي مستحقات التجار</th>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="text-center">
                            {{ number_format($vendor_total_witout_vat, 2, '.', ',') }}
                        </td>
                        <td class="text-center">
                            {{ number_format($vendor_total_vat, 2, '.', ',') }}
                        </td>
                        <td class="text-center">
                            {{ number_format($vendor_total_with_vat, 2, '.', ',') }}</td>
                        <td class="text-center">{{ number_format($sys_commission_without_vat, 2, '.', ',') }}</td>
                        <td class="text-center">
                            {{ number_format($sys_commission_vat, 2, '.', ',') }}</td>
                        <td class="text-center">{{ number_format($sys_commission_with_vat, 2, '.', ',') }}</td>

                        <td class="text-center">
                            {{ number_format($vendor_total_earn, 2, '.', ',') }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </table>
        </div>

    </div>

</div>

<script src="{{ asset('dash/js/jquery.min.js') }}"></script>
<script src="{{ asset('dash/js/html2pdf.bundle.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        setTimeout(function () {
            window.print();
        }, 200);
    });
</script>

</body>

</html>
