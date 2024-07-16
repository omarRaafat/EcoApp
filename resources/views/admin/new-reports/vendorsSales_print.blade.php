<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('dash/css/bootstrap.min.css') }}">
    <title>  طباعة الطلب</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal&display=swap');
        html, body{
            font-family: 'Tajawal', sans-serif;
        }
        .table {
            width:100%;
            max-width:100%;
            margin-bottom:1rem;
            background-color:transparent;
            border-top:1px solid #dee2e6;
            border-left:1px solid #dee2e6;
            border-right:1px solid #dee2e6;
            text-align: right;
            direction: rtl;
            line-height: 22px;
            color: #060b26;
            }
            .table td,
            .table th {
            padding:.75rem;
            vertical-align:top;
            border-bottom:1px solid #dee2e6;
            text-align: right !important;
            }
            .table thead th {
            vertical-align:bottom;
            border-bottom:2px solid #dee2e6
            }
            .table tbody+tbody {
            border-top:2px solid #dee2e6
            }
            .table .table {
            background-color:#fff
            }
            .page_tttitle{
                margin-top: 0;
                border: 1px solid #43be9b;padding: 15px 10px 21px 10px;color: #43be9b;
                margin-bottom: 30px;
            }
            body{ /* portrait */
                padding-right: 25px;
                padding-left: 25px;
            }
            @page { size: auto;  margin: 0mm; }
            .row > div{
                display: inline-block;
                margin: 10px 15px
            }
    </style>
    <style>
        #printable{
            display:flex;
            justify-content:center;
            align-items:center;
            height:100%;
        }
        html, body{
            height:100%;
            width:100%;
            text-align:center;    
        }
        .qr_code_div > svg{
            width: 75px;
            height: 75px;
        }
        .tablesum89 tr td{
            padding: 5px 5px;
            line-height: 10px;
            border: none;
        }
    </style>
</head>
<body>
    <div style="height: 995px;position: absolute;left: 20px;right: 20px;top: 0;">
        <div style="position:relative;margin-top:30px;margin-bottom:30px">
            <img src="{{ asset('storage/settings/'. $site_settings->site_logo ) }}" alt="QR" title="QR" style="display:block; margin-left: auto; margin-right: auto;" height="45" data-auto-embed="attachment"/>
        </div>
        @php 
                $SellsTaxs  =  \App\Models\SellsTaxs::find(1);
        @endphp
        <h6 style="text-align: center"> تقرير مبيعات التجار    
        @if(request()->get('date') != null && request()->get('date') != '')
            <span> للفترة من  {{ request()->get('date') }}</span>
            @endif
            @if(request()->get('date_to') != null && request()->get('date_to') != '')
            <span>إلى  {{ request()->get('date_to') }}</span>
            @endif
        </h6>
        <div style="text-align: right;display:inline-block;width:33%">
            <h6 class="mb-0">  {{$SellsTaxs->supplier}} </h6>
            <h6>  الرقم الضريبي  :  <b class="en">{{$SellsTaxs->taxNumber}}</b>  </h6>
            <h6 class="mb-0">بتاريخ  {{ date('Y-m-d, H:i') }}</h6>
        </div>
        <div style="text-align: center;display:inline-block;width:33%">
            <h6>البائع : <b>{{ $item->shop_name }}</b></h6>
            <h6>الرقم الضريبي : <b>{{ $item->taxNumber }}</b></h6>
        </div>
        <div style="text-align: left;display:inline-block;width:33%">
            
        </div>
       
        <br><br><br>
        <div style="text-align: right">
            <table class="table" style="text-align: center">
                <thead>
                    <th>منتج </th>
                    <th>باركود </th>
                    <th>سعر البيع غير شامل الضريبة  </th>
                    <th>كمية المبيعات</th>
                    <th>المجموع  غير شامل الضريبة</th>
                    <th>نسبة الضريبة</th>
                    <th>قيمة الضريبة</th>
                    <th>المجموع شامل الضريبة</th>
                </thead>
                <tbody>
                    @php
                        $vendor_total_products = 0;
                        $totalTaxss = 0;
                    @endphp 
                    @foreach (\App\Models\Product::where('user_id',$item->id)->get() as $detail)
                        @php
                        $CartVendor_ids =  \App\Models\CartVendor::where('vendor_id',$item->id)->whereIn('status',[3])->pluck('order_id')->toArray();
                        $detaissss = \App\Models\OrderDetail::whereIn('order_id',$CartVendor_ids)->where('product_id',$detail->id)->orderBy('id','desc');
                        if(request()->get('date') != null && request()->get('date') != ''){
                                    $detaissss = $detaissss->whereDate('created_at','>=',request()->get('date'));
                                    }

                                    if(request()->get('date_to') != null && request()->get('date_to') != ''){
                                    $detaissss = $detaissss->whereDate('created_at','<=',request()->get('date_to'));
                                    }
                        
                        $detaissss = $detaissss->get();
                        $quantity=  0;
                        $sum = 0;
                        $array_prices = [];
                        foreach ($detaissss as $key => $value) {
                            $quantity += $value->quantity;
                                    $sum += $value->price * $value->quantity;
                                    if(!in_array($value->price,$array_prices)){
                                    array_push($array_prices,$value->price);
                                    }
                                    
                            
                        }
                        @endphp 
                        @if($quantity > 0)
                            @if(count($array_prices) == 1)
                                <tr>
                                    <td style="max-width: 82px;">{{ $detail->name }}</td>
                                    <td>{{ $detail->bar_code }}</td>
                                    @php 
                                    $pricecal = (($array_prices[0] / 1.15) * $SellsTaxs->tva) / 100;
                                    $pricecal = $array_prices[0] - $pricecal;
                                    @endphp
                                    <td>
                                        {{ number_format($pricecal,2,'.','') }}
                                        {{ __('message.sar') }}
                                    </td>
                                    <td>{{ $quantity }}</td>
                                    <td>{{ number_format($pricecal * $quantity,2,'.','') }} {{ __('message.sar') }}</td>
                                    <td>{{ $SellsTaxs->tva }}%</td>
                                    @php 
                                    $TAXcal = ( $pricecal * $SellsTaxs->tva) / 100;
                                    $TAXcal = $TAXcal * $quantity;
                                    $totalTaxss += $TAXcal;
                                    $vendor_total_products += number_format($pricecal * $quantity,2,'.','');
                                    @endphp
                                    <td>{{ number_format($TAXcal ,2,'.','') }}</td>
                                    <td>{{ number_format(($pricecal * $quantity ) +$TAXcal,2,'.','') }} {{ __('message.sar') }}</td>
                                </tr>
                            @else 
                                @foreach($array_prices as $arritteem)
                                    @php 
                                    $sum = 0;
                                    $quantity = 0;
                                        $detaissssTwo = \App\Models\OrderDetail::whereIn('order_id',$CartVendor_ids)->where('price',$arritteem)->where('product_id',$detail->id)->orderBy('id','desc');
                                            if(request()->get('date') != null && request()->get('date') != ''){
                                                $detaissssTwo = $detaissssTwo->whereDate('created_at','>=',request()->get('date'));
                                            }

                                            if(request()->get('date_to') != null && request()->get('date_to') != ''){
                                                $detaissssTwo = $detaissssTwo->whereDate('created_at','<=',request()->get('date_to'));
                                            }
                                
                                            $detaissssTwo = $detaissssTwo->get();
                                            foreach ($detaissssTwo as $key => $value) {
                                            $quantity += $value->quantity;
                                            $sum += $arritteem * $value->quantity;
                                            }
                                    @endphp 
                                    <tr>
                                        <td style="max-width: 82px;">{{ $detail->name }}</td>
                                        <td>{{ $detail->bar_code }}</td>
                                        @php 
                                        $pricecal = (($arritteem / 1.15) * $SellsTaxs->tva) / 100;
                                        $pricecal = $arritteem - $pricecal;
                                        @endphp
                                        <td>
                                            {{ number_format($pricecal,2,'.','') }}
                                            {{ __('message.sar') }}
                                        </td>
                                        <td>{{ $quantity }}</td>
                                        <td>{{ number_format($pricecal * $quantity,2,'.','') }} {{ __('message.sar') }}</td>
                                        <td>{{ $SellsTaxs->tva }}%</td>
                                        @php 
                                        $TAXcal = ($pricecal * $SellsTaxs->tva) / 100;
                                        $TAXcal = $TAXcal * $quantity;
                                        $totalTaxss += $TAXcal;
                                        $vendor_total_products +=  number_format($pricecal * $quantity,2,'.','');
                                        @endphp
                                        <td>{{ number_format($TAXcal ,2,'.','') }}</td>
                                        <td>{{ number_format(($pricecal * $quantity ) +$TAXcal,2,'.','') }} {{ __('message.sar') }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        @endif
                    @endforeach
                </tbody>
            </table>  
        </div>
        <div style="text-align: right">
            <br><br>
            <div style="">
                <div style="float: left;width:310px">
                    <table class="table tablesum89">
                        @php 
                        $sum = $vendor_total_products;
                         $safe_sum= 0;
                            $safe_sum_dash= 0;
                            $safe_sum += ((($sum + ($sum/(floatval($SellsTaxs->tva)/ 100 + 1) - $sum)) - (($sum + ($sum/(floatval($SellsTaxs->tva)/ 100 + 1) - $sum))* (floatval($item->vendor_percentage) / 100)) - ((($sum + ($sum/(floatval($SellsTaxs->tva)/ 100 + 1) - $sum))* (floatval($item->vendor_percentage) / 100)) *  (floatval($SellsTaxs->tva)/ 100))) + ($sum - ($sum + ($sum/(floatval($SellsTaxs->tva)/ 100 + 1) - $sum))));
                            $dash_profit = (($sum + ($sum/(floatval($SellsTaxs->tva)/ 100 + 1) - $sum))*  ($item->vendor_percentage / 100)) + ((($sum + ($sum/(floatval($SellsTaxs->tva)/ 100 + 1) - $sum))* ($item->vendor_percentage / 100)) * (floatval($SellsTaxs->tva) / 100));
                            $dash_profit_vat = (floatval($SellsTaxs->tva) *  $dash_profit)  /100;
                            $safe_sum -= $dash_profit_vat;

                            $safe_sum_dash += $dash_profit_vat;
                            
 
                            $totalwithTax =  number_format($safe_sum,2,'.','') +  number_format($dash_profit,2,'.','') +  number_format($safe_sum_dash,2,'.','');
                            $totalwithTax= number_format($totalwithTax,2,'.','');

                        @endphp
                       
                        <tr>
                            <td>إجمالي  المنتجات بدون ضريبة</td>
                            <td  style="text-align: left">{{ number_format($totalwithTax ,2,'.','') }} {{ __('message.sar') }}</td>
                        </tr>
                        <tr>
                            <td>قيمة الضريبة</td>
                            <td  style="text-align: left">{{ number_format($totalTaxss ,2,'.','') }} {{ __('message.sar') }}</td>
                        </tr>
                      
                        <tr>
                            <td>إجمالي الطلب شامل الضريبة</td>
                            <td> {{ number_format($totalwithTax + $totalTaxss,2,'.','')  }} {{ __('message.sar') }}</td>
                        </tr>
                    </table>
                </div>
                <div style="float: right">   
                    <div class="qr_code_div">
                      
                    </div>
                </div>
            </div>  

            <br><br>

         
        </div>
        <br>
         
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


