<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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

        .table tbody+tbody {
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

        .row>div {
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

        .qr_code_div>svg {
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
                data-auto-embed="attachment" />
        </div>
        @php
            $SellsTaxs = \App\Models\SellsTaxs::find(1);
        @endphp
        <div style="text-align: right;display:inline-block;width:33%">
            <h6 class="mb-0"> {{ $SellsTaxs->supplier }} </h6>
            <h6> الرقم الضريبي : <b class="en">{{ $SellsTaxs->taxNumber }}</b> </h6>
        </div>
        <div style="text-align: center;display:inline-block;width:33%">
            <h6 style="text-align: center"> تقرير مبيعات التجار
                @if (request()->get('deliver_date') != null && request()->get('deliver_date') != '')
                    <span> للطلبات التي تم تسليمها من {{ request()->get('deliver_date') }}</span>
                @endif
                @if (request()->get('deliver_date_to') != null && request()->get('deliver_date_to') != '')
                    <span>إلى {{ request()->get('deliver_date_to') }}</span>
                @endif
            </h6>
        </div>
        <div style="text-align: right;display:inline-block;width:33%">
            <h6 class="mb-0">بتاريخ {{ date('Y-m-d, H:i') }}</h6>
        </div>

        <div style="text-align: left;display:inline-block;width:33%">

        </div>

        <br><br><br>
        <div class="">
            <table id="exampleee" class="table table-border" style="width:100%">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>البائع</th>
                        <th>قيمة مبيعات التجار غير شاملة VAT</th>
                        <th>قيمة الضريبة (15%)</th>
                        <th>قيمة مبيعات التجار شاملة VAT</th>
                        <th>عمولة المنصة غير شاملة VAT</th>
                        <th>قيمة الضريبة على العمولة (15%)</th>
                        <th>قيمة عمولة المنصة شاملة VAT</th>
                        <th>صافي المستحق للتاجر</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($earns as $vendor_earn)
                        <tr>
                            <td>{{ $vendor_earn->vendor_id }}</td>
                            <td>{{ $vendor_earn->shop_name }}</td>

                            <td>{{number_format($vendor_totals[$vendor_earn->vendor_id]["total_without_vat"], 2, ".", ",") }}
                            </td>
                            <td>{{number_format($vendor_totals[$vendor_earn->vendor_id]["total_vat"], 2, ".", ",") }}
                            </td>
                            <td>{{number_format($vendor_totals[$vendor_earn->vendor_id]["total_with_vat"], 2, ".", ",") }}</td>

                            <td>{{number_format($vendor_totals[$vendor_earn->vendor_id]["commission_without_vat"], 2, ".", ",") }}
                            </td>
                            <td>{{number_format($vendor_totals[$vendor_earn->vendor_id]["commission_vat"], 2, ".", ",") }}</td>
                            <td>{{number_format($vendor_totals[$vendor_earn->vendor_id]["commission_with_vat"], 2, ".", ",") }}</td>

                            <td>{{number_format($vendor_totals[$vendor_earn->vendor_id]["total_earn"], 2, ".", ",") }}</td>
                        </tr>
                        @endforeach
                </tbody>
            </table>

            <br>
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
                            {{ number_format($totals["total_without_vat"],2,".",",") }}
                        </td>
                        <td class="text-center">
                            {{ number_format($totals["total_vat"],2,".",",") }}
                        </td>
                        <td class="text-center">
                            {{ number_format($totals["total_with_vat"],2,".",",") }}</td>
                        <td class="text-center">{{ number_format($totals["commission_without_vat"],2,".",",") }}</td>
                        <td class="text-center">
                            {{ number_format($totals["commission_vat"],2,".",",") }}</td>
                        <td class="text-center">{{ number_format($totals["commission_with_vat"],2,".",",") }}</td>

                        <td class="text-center">
                            {{ number_format($totals["total_earn"],2,".",",") }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <br>
            <br>
        </div>

    </div>


    <script src="{{ asset('dash/js/jquery.min.js') }}"></script>
    <script src="{{ asset('dash/js/html2pdf.bundle.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(function() {
                window.print();
            }, 200);
        });
    </script>

</body>

</html>
