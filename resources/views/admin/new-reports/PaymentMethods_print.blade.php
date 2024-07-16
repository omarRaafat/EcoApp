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
            <h6 style="text-align: center">وسائل الدفع </h6>
            @if(request()->get('date') != null && request()->get('date') != '')
            <span>من تاريخ {{ request()->get('date') }}</span>
            @endif
            @if(request()->get('date_to') != null && request()->get('date_to') != '')
            <span>إلى تاريخ {{ request()->get('date_to') }}</span>
            @endif
        </div>
        <div style="text-align: left;display:inline-block;width:33%">
            <h6 class="mb-0">بتاريخ  {{ date('Y-m-d, H:i') }}</h6>
        </div>
       
        <br><br><br>
        <div style="text-align: right">
            <table id="exampleee" class="display" style="width:100%">
                <thead>
                    <tr>
                    <th>#ID</th>
                    <th>الإسم</th>
                    <th>عدد طلبات</th>
                    <th>قيم ة طلبات</th>
                    <th>نسبة الوسيلة غير شامل الضريبة</th>
                    <th>نسبة الوسيلة  شامل الضريبة</th>
                    </tr>
                </thead>
                <tbody>
                    @php  $tl_count=0;$tl_val_orders=0;;$tl_calc=0;;$tl_calc2=0;@endphp
                    @foreach ($rows as $index => $item)
                    <tr>
                        <td>{{$index++}}</td>
                        <td>{{ $item }}</td>
                        @php 
                        $CartVendor_ids =  \App\Models\CartVendor::whereIn('status',[3])->pluck('order_id')->toArray();
                        $orders = \App\Models\Order::whereIn('id',$CartVendor_ids)->where('method',$item)->orderBy('id','desc');
                         if(request()->get('date') != null && request()->get('date') != ''){
                                            $orders = $orders->whereDate('created_at','>=',request()->get('date'));
                                        }
                                        if(request()->get('date_to') != null && request()->get('date_to') != ''){
                                            $orders = $orders->whereDate('created_at','<=',request()->get('date_to'));
                                        }
                        $rows = $orders->get();
                        $count = count($rows);
                        $val_orders = $orders->sum('needtopay');
                        $calc = 0;
                        $model = \App\Models\paymentMethods::where('name',$item)->first();
                        if($model != null && in_array($item,['VISA','MASTER','MADA','Tabby']) ){
                            $calc = ($val_orders * $model->radio) / 100;
                            $calc += number_format($count * $model->amount,2,'.','');
                        }
                        
                        if($item != 'COD'){
                            $tl_count += $count;
                            $tl_val_orders += $val_orders;
                            $tl_calc+= number_format($calc,2,'.','');
                            $tl_calc2+= number_format(($calc * 1.15) ,2,'.','');
                        }
                        @endphp
                        <td>{{ $count }}</td>
                        <td>{{ number_format($val_orders,2,'.','') }}</td>
                        @if(in_array($item,['VISA','MASTER','MADA','Tabby']))
                    <td>{{ number_format($calc,2,'.','') }}  @if($model != null ) ({{ '%'.  $model->radio }})+({{ $model->amount.'ر.س' }}) @endif</td>
                    <td>{{ (number_format(($calc* 1.15),2,'.','') ) }}   @if($model != null )({{ '%'.$model->radio }})+({{ $model->amount.'ر.س' }}) @endif </td>
                        @else
                        <td>لا ينطبق</td>
                        <td>لا ينطبق</td>
                        @endif
                    </tr>
                    @endforeach
                     <tr>
                        <td></td>
                        <td>{{ 'Wallet' }}</td>
                        @php 
                    $CartVendor_ids =  \App\Models\CartVendor::whereIn('status',[3])->pluck('order_id')->toArray();
                        $orders = \App\Models\Order::whereIn('id',$CartVendor_ids)->where('method','Wallet')->orderBy('id','desc');
                         if(request()->get('date') != null && request()->get('date') != ''){
                                            $orders = $orders->whereDate('created_at','>=',request()->get('date'));
                                        }
                                        if(request()->get('date_to') != null && request()->get('date_to') != ''){
                                            $orders = $orders->whereDate('created_at','<=',request()->get('date_to'));
                                        }

                        $rows = $orders->get();
                        $count = count($rows);
                        $val_orders = $orders->sum('total');
                        $calc = 0;
                        
                        
                        // دفع جزء بالمحفظة
                        $partwallet = 0;
                        $partwalletCount = 0;
                    $CartVendor_ids =  \App\Models\CartVendor::whereIn('status',[3])->pluck('order_id')->toArray();
                        $orders = \App\Models\Order::whereIn('id',$CartVendor_ids)->where('method','!=','Wallet')->orderBy('id','desc');
                         if(request()->get('date') != null && request()->get('date') != ''){
                                            $orders = $orders->whereDate('created_at','>=',request()->get('date'));
                                        }
                                        if(request()->get('date_to') != null && request()->get('date_to') != ''){
                                            $orders = $orders->whereDate('created_at','<=',request()->get('date_to'));
                                        }

                        $rows = $orders->get();
                        foreach($rows as $row){
                        if($row->total != $row->needtopay){
                            $partwallet += ($row->total - $row->needtopay);
                            $partwalletCount += 1;
                        }
                        }
                        
                        $val_orders += $partwallet;
                        
                        $tl_count += $count;
                        $tl_val_orders += $val_orders;
                         
                        @endphp
                        <td>{{ $count }} <small>({{ $partwalletCount }})</small></td>
                        <td>{{ number_format($val_orders,2,'.','') }}</td>
                        <td>لا ينطبق</td>
                        <td>لا ينطبق</td>
                    </tr>
                     <tr>
                        <td></td>
                        <td>{{ 'المجموع' }}</td>
                        <td>{{ $tl_count }} </td>
                        <td>{{ number_format($tl_val_orders,2,'.','') }}</td>
                        <td>{{ number_format($tl_calc,2,'.','') }}</td>
                        <td>{{ number_format($tl_calc2,2,'.','') }}</td>
                    </tr>
                </tbody>
            </table>
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


