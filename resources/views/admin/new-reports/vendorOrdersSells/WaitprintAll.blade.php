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
         <div style="text-align: right;display:inline-block;width:33%">
            <h6 class="mb-0">  {{$SellsTaxs->supplier}} </h6>
            <h6>  الرقم الضريبي  :  <b class="en">{{$SellsTaxs->taxNumber}}</b>  </h6>
        </div>
        <div style="text-align: center;display:inline-block;width:33%">
            <h4> تقرير   مبيعات البائع الشحنات الغير مستلمة               
            </h4>
            <p>
                @php
                   $vendor = \App\Models\Vendor::findOrFail(request()->get('vendor_id'));
                @endphp
                {{$vendor->shop_name}}
            </p>
           <h6 style="text-align: center"> 
                 @if(request()->get('date') != null && request()->get('date') != '')
                <span> تاريخ الطلب  من :  {{ request()->get('date') }}</span>
                @endif
                @if(request()->get('date_to') != null && request()->get('date_to') != '')
                <span>إلى  {{ request()->get('date_to') }}</span>
                @endif
                @if(request()->get('completed_date') != null && request()->get('completed_date') != '')
                <br>
                <span> تاريخ التسليم من :  {{ request()->get('completed_date') }}</span>
                @endif
                @if(request()->get('completed_date_to') != null && request()->get('completed_date_to') != '')
                <span>  إلى  {{ request()->get('completed_date_to') }}</span>
                @endif
                 

            </h6>
        </div>
        <div style="text-align: left;display:inline-block;width:33%">
            <h6 class="mb-0">بتاريخ  {{ date('Y-m-d, H:i') }}</h6>
        </div>

        <div style="text-align: left;display:inline-block;width:33%">
            
        </div>
       
        <br><br><br>
        <div style="text-align: right">

            <table id="exampleee" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>رقم الفاتورة الخاص بالتاجر </th>
                        <th>رقم الطلب  </th>
                        <th>تاريخ الطلب</th>
                        <th>كمية المبيعات </th>
                        <th>قيمة المبيعات قبل الضريبة  </th>
                        <th>نسبة الضريبة</th>
                        <th>قيمة الضريبة</th>
                        <th>قيمة المبيعات بعد الضريبة</th>
                        <th> رقم البوليصة  </th>
                        <th> تاريخ الطلب  </th>
                        <th> تاريخ التسليم  </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $orders = [];
                        $vendor = null;
                        if(!empty(request()->get('vendor_id'))){
                            $CartVendor_ids = \App\Models\CartVendor::where('shippingType','Aramex')->where('vendor_id',request()->get('vendor_id'))->where('order_id',"!=",null)->whereNotIn('status',[3,4])->pluck('order_id')->toArray();
                            $orders = \App\Models\Order::whereIn('id',$CartVendor_ids)->orderBy('id','desc');
                            if(request()->get('date') != null && request()->get('date') != ''){
                                $orders = $orders->whereDate('created_at','>=',request()->get('date'));
                            }
                            if(request()->get('date_to') != null && request()->get('date_to') != ''){
                                $orders = $orders->whereDate('created_at','<=',request()->get('date_to'));
                            }
                            $orders = $orders->get();

                            $vendor = \App\Models\Vendor::findOrFail(request()->get('vendor_id'));

                        }

                        $totalqnt =0;
                        $totalsells =0;
                        $clm1 = 0;
                        $clm2 = 0;
                    @endphp
                    @foreach ($orders as $item)
                                @php 
                                    $SellsTaxs = \App\Models\SellsTaxs::find(1);
                                    $products_ids = \App\Models\Product::where('user_id',intval($vendor->id))->pluck('id')->toArray();
                                    $sells = \App\Models\OrderDetail::whereIn('product_id',$products_ids)->orderBy('id','desc')->where('order_id',$item->id);
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
                                    $totalqnt += $dd;
                                    $totalsells += $sells_val;
                                    $vendor_calc  = ($sells_val * $vendor->vendor_percentage) / 100;
                                    $TAXcal = (($sells_val / 1.15) * $SellsTaxs->tva) / 100;
                                    
                                    $tadiracalc =  (floatval($SellsTaxs->tva) *  ($sells_val/1.15) )  /100 ;
                                    $clm1 +=  $sells_val - $tadiracalc;
                                    $clm2 += $tadiracalc;

                                    $CartVendor =  \App\Models\CartVendor::where('vendor_id',intval($vendor->id))->where('order_id',$item->id)->first();
                                    

                                @endphp
                                @if($dd > 0)
                              <tr>
                                <td> <a href="{{ route('dash.orders.show',$item->id) }}" class="badge badge-success" >{{ $vendor->id.$item->id_rand }} </a></td>
                                <td>{{ $item->id }}</td>
                                <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                <td> 
                                    {{ $dd }}
                                </td>
                                <td>
                                    {{ number_format($sells_val - $tadiracalc,2,'.','')  }} ر.س
                                </td>
                                <td>{{ $SellsTaxs->tva }}% </td>
                                 <td>{{ number_format($tadiracalc,2,'.','') }} ر.س </td>
                                <td>  {{ number_format( $sells_val,2,'.','')   }} ر.س</td>
                                <td>  <a href="https://www.aramex.com/track/results?ShipmentNumber={{$CartVendor->tracking}}" class="badge badge-success" target="_blank">
                                        {{$CartVendor->tracking}} 
                                    </a>
                                </td>
                                <td>{{ date('Y-m-d, H:i', strtotime($item->created_at)) }}</td>
                                <td> </td>
                                </tr>
                            @endif
                    @endforeach
                </tbody>
            </table>
          

            <br>
            <div class="">
                <table class="table table-bordered">
                   <thead>
                                <th>  </th>
                                <th> </th>
                                <th>كمية المبيعات </th>
                                <th>قيمة المبيعات قبل الضريبة  </th>
                                <th></th>
                                <th>قيمة الضريبة</th>
                                <th>قيمة المبيعات بعد الضريبة</th>
                   </thead>
                   <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>{{ $totalqnt }}</td>
                            <td>{{ number_format ($clm1,2,'.','') }}</td>
                            <td></td>
                            <td>{{ number_format ($clm2,2,'.','') }}</td>
                            <td>{{ $totalsells }}</td>
                        </tr>
                   </tbody>
                </table>
            </div>
        </div>

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