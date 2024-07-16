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
            <img src="{{ asset('storage/settings/'. $site_settings->site_logo ) }}" alt="QR" title="QR"
                style="display:block; margin-left: auto; margin-right: auto;" height="45"
                data-auto-embed="attachment" />
        </div>
        @php
        $SellsTaxs = \App\Models\SellsTaxs::find(1);
        @endphp

        <div style="text-align: right;display:inline-block;width:33%">
            <h6 class="mb-0"> {{$SellsTaxs->supplier}} </h6>
            <h6 class="mb-0">المملكة العربية السعودية - الرياض</h6>
            <h6 class="mb-0">طريق الأمير تركي الأول - حي حطين</h6>
            <h6 class="mb-0"> الرقم الضريبي : <b class="en">{{$SellsTaxs->taxNumber}}</b> </h6>
            @php
            $facture =
            \App\Models\ReportFacture::where('sector','TaxinvoiceCommission')->where('date',request()->get('date'))->where('date_to',request()->get('date_to'))->first();
            @endphp
            <h6 class="mb-0"> رقم الفاتورة {{$vendor->id.'0'.$facture->id}} </h6>
            <h6 class="mb-0">تاريخ الفاتورة {{ date('Y-m-d') }}</h6>
        </div>

        <div style="text-align: center;display:inline-block;width:33%">
            <h6 style="text-align: center"> فاتورة ضريبية (فاتورة العمولة) </h6>
        </div>


        <div style="text-align: left;display:inline-block;width:33%">
            <h6>إسم البائع : <b>{{ $vendor->shop_name }}</b></h6>
            <h6>رقم البائع : <b>{{ $vendor->id }}</b></h6>
            <h6>الرقم الضريبي : <b>{{ $vendor->taxNumber }}</b></h6>
        </div>

        <br><br><br>
        <div style="text-align: right">
            <table class="table" style="text-align: center">
                <thead>
                    <th>البيان </th>
                    <th>الكمية</th>
                    <th>القيمة </th>
                    <th>نسبة ضريبة القيمة المضافة </th>
                    <th>قيمة الضريبة </th>
                    <th>المجموع</th>
                </thead>
                <tbody>
                    @php
                    $products_ids = \App\Models\Product::where('user_id',intval($vendor->id))->pluck('id')->toArray();

                    $order_ids =
                    \App\Models\OrderDetail::whereIn('product_id',$products_ids)->pluck('order_id')->toArray();

                    $doneorders =
                    \App\Models\CartVendor::where('status',3)->whereIn('order_id',$order_ids)->pluck('order_id')->toArray();

                    $sells =
                    \App\Models\OrderDetail::whereIn('product_id',$products_ids)->whereIn('order_id',$doneorders)->orderBy('id','desc');

                    if(request()->get('date') != null && request()->get('date') != ''){
                    $sells = $sells->whereDate('created_at','>=',request()->get('date'));
                    }

                    if(request()->get('date_to') != null && request()->get('date_to') != ''){
                    $sells = $sells->whereDate('created_at','<=',request()->get('date_to'));
                        }

                        $sells = $sells->get();
                        $SellsTaxs = \App\Models\SellsTaxs::find(1);
                        $sells_val = 0;
                        $dd = 0;

                        foreach ($sells as $sell_item) {
                        $dd += intval($sell_item->quantity);
                        $sells_val += $sell_item->price * $sell_item->quantity;
                        }

                        $vendor_calc = ($sells_val * $vendor->vendor_percentage) / 100;

                        $sum = ($sells_val/1.15);
                        $safe_sum = 0;
                        $safe_sum_dash = 0;
                        $SellsTaxs = \App\Models\SellsTaxs::find(1);

                        $safe_sum += ((($sum + ($sum/(floatval($SellsTaxs->tva)/ 100 + 1) - $sum)) - (($sum +
                        ($sum/(floatval($SellsTaxs->tva)/ 100 + 1) - $sum))* (floatval($vendor->vendor_percentage) /
                        100)) - ((($sum + ($sum/(floatval($SellsTaxs->tva)/ 100 + 1) - $sum))*
                        (floatval($vendor->vendor_percentage) / 100)) * (floatval($SellsTaxs->tva)/ 100))) + ($sum -
                        ($sum + ($sum/(floatval($SellsTaxs->tva)/ 100 + 1) - $sum))));

                        $dash_profit = (($sum + ($sum/(floatval($SellsTaxs->tva)/ 100 + 1) - $sum))*
                        ($vendor->vendor_percentage / 100)) + ((($sum + ($sum/(floatval($SellsTaxs->tva)/ 100 + 1) -
                        $sum))* ($vendor->vendor_percentage / 100)) * (floatval($SellsTaxs->tva) / 100));
                        $dash_profit_vat = (floatval($SellsTaxs->tva) * $dash_profit) /100;

                        $safe_sum -= $dash_profit_vat;

                        $safe_sum_dash += $dash_profit_vat;

                        $TAXcal = (($safe_sum / 1.15) * $SellsTaxs->tva) / 100;

                        @endphp
                        <tr>
                            <td>
                                عمولة مبيعات
                                <span>{{ $vendor->vendor_percentage }}% </span>
                                <small>
                                    @if(request()->get('date') != null && request()->get('date') != '')
                                    <span>من تاريخ {{ request()->get('date') }}</span>
                                    @endif
                                    @if(request()->get('date_to') != null && request()->get('date_to') != '')
                                    <span>إلى تاريخ {{ request()->get('date_to') }}</span>
                                    @endif
                                </small>
                            </td>
                            <td>{{$dd}}</td>
                            <td>
                                {{ number_format($dash_profit ,2,'.','') }} {{ __('message.sar') }}
                            </td>
                            <td>{{ $SellsTaxs->tva }}%</td>
                            <td>
                                {{ number_format( $dash_profit_vat ,2,'.','') }} {{ __('message.sar') }}
                            </td>
                            <td>
                                {{ number_format($dash_profit + $dash_profit_vat ,2,'.','') }} {{ __('message.sar') }}
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>
        <div style="text-align: right">
            <br><br>
            <div>
                <div style="float: left;width:310px">
                    <table class="table tablesum89">
                        <tr>
                            <td>اجمالي القيمة قبل الضريبة </td>
                            <td> {{ number_format($dash_profit ,2,'.','') }} {{ __('message.sar') }}</td>
                        </tr>
                        <tr>
                            <td>قيمة الضريبة</td>
                            <td> {{ number_format($dash_profit_vat,2,'.','') }} {{ __('message.sar') }}</td>
                        </tr>
                        <tr>
                            <td>إجمالي القيمة شاملة الضريبة</td>
                            <td> {{ number_format($dash_profit + $dash_profit_vat ,2,'.','') }} {{ __('message.sar') }}
                            </td>
                        </tr>
                    </table>
                </div>
                <div style="float: right">
                    <div class="qr_code_div">
                        @php
                        // qr Code
                        $qrCode = generateQrCode([
                        'seller_name' => $vendor->shop_name,
                        'taxNumber' => $vendor->taxNumber,
                        'created_at' => date('Y-m-d'),
                        'vat' => $SellsTaxs->tva,
                        'totalAmount' => number_format($dash_profit ,2,'.',''),
                        'taxAmount' => number_format($dash_profit_vat,2,'.','')
                        ]);
                        @endphp
                        {{ $qrCode }}
                        {{-- <img src="" alt="QR Code" width="100" height="100" /> --}}
                    </div>
                </div>
            </div>

            <br><br>


        </div>
        <br><br>

    </div>

    <script src="{{ asset('dash/js/jquery.min.js') }}"></script>
    <script src="{{ asset('dash/js/html2pdf.bundle.js') }}"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            setTimeout(function(){
                window.print();
            },200);
        });
    </script>

</body>

</html>
