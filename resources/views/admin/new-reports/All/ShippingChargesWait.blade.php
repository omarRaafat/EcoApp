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
            <h4>            تقرير الشحنات الغير مستلمة               </h4>
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

        @php
            $CartVendor_ids = \App\Models\CartVendor::where('order_id',"!=",null)->where('shippingType','Aramex')->whereNotIn('status',[3,4])->pluck('id')->toArray();
            $orders = \App\Models\CartVendor::where('order_id',"!=",null)->where('shippingType','Aramex')->whereNotIn('status',[3,4]);
            if(request()->get('date') != null && request()->get('date') != ''){
                $orders = $orders->whereDate('created_at','>=',request()->get('date'));
            }
            if(request()->get('date_to') != null && request()->get('date_to') != ''){
                $orders = $orders->whereDate('created_at','<=',request()->get('date_to'));
            }


            $rows = $orders->get();
        @endphp

         <table  id="exampleee" class="display" style="width:100%">
            <thead>
                <tr>
                <th>  تكلفة الشحنة</th>
                <th> وزن الشحنة </th>
                <th> حالة الشحنة </th>
                <th> حالة الرئيسي   </th>
                <th>طريق الشحن</th>
                <th> إسم البائع </th>
                <th> رقم الطلب  </th>
                <th> رقم البوليصة  </th>
                <th> تاريخ الطلب  </th>
                <th> تاريخ التسليم  </th>
                <th> Order Id  </th>
            </tr>
            </thead>
            <tbody>
                @foreach ($rows as $item)
                    @php
                        $shipping_price = 0;
                            $SellsTaxs = \App\Models\SellsTaxs::findOrFail(1);
                            if($item->lineshippingprice > 0){
                                $fuelprice = number_format((number_format($item->lineshippingprice,2,'.','')  * $SellsTaxs->fuelprice ) / 100 ,2,'.','');
                                $shipping_price = $item->lineshippingprice +$fuelprice;
                            }


                            $warehouse = \App\Models\Warehouse::find($item->warehouse_id);
                        $dattee = '';
                        $read = \App\Models\VendorReadOrder::where('user_id',$item->vendor_id)->where('order_id',$item->order_id)->first();
                        if($read != null){
                            $dattee =  date('Y/m/d H:i', strtotime($read->created_at));
                        }

                        $weight= 0;
                        $details = \App\Models\OrderDetail::where('order_id',$item->order_id)->get();
                        foreach ($details as $dettaaill){
                            $Product = \App\Models\Product::find(intval($dettaaill->product_id));
                            if($Product != null){
                                if($Product->user_id == $item->vendor_id){
                                    if(floatval($Product->size_gram) > 0){
                                        $weight += floatval($Product->size_gram) * intval($dettaaill->quantity);
                                    }else{
                                        $weight += 1 * intval($dettaaill->quantity);
                                    }
                                }
                            }
                        }



                        $vendor  = \App\Models\Vendor::find($item->vendor_id);
                        $order = \App\Models\Order::find($item->order_id);
                        $completed_date = '';
                        /*$OrderStatusDate =  \App\Models\OrderStatusDate::where('order_id',$item->id)->first();
                        if($OrderStatusDate != null){
                        $completed_date = $OrderStatusDate->delivered;
                        }*/
                        @endphp
                <tr>
                    <td> {{$shipping_price}} </td>
                    <td> {{$weight}} </td>
                    <td>
                        @if($item->status == 3)
                            <span class="badge badge-success">تم  التسليم</span>
                        @elseif($item->status == 6)
                            <span class="badge badge-warning">تم تجهيز</span>
                        @elseif( $item->status == 4 )
                            <span class="badge badge-danger"> ملغي </span>
                        @else
                            <span class="badge badge-info">تم طلب</span>
                        @endif
                    </td>
                    <td>
                        @if($order != null)
                            <span class="badge badge-dark">
                                @if($order->status == 0)  {{  __('message.order_done') }} @endif
                                @if($order->status == 1) {{  __('message.in_truck') }} @endif
                                @if($order->status == 2)  {{  __('message.in_chipping') }}  @endif
                                @if($order->status == 3) {{  __('message.delivered') }} @endif
                                @if($order->status == 4) {{  __('message.canceled') }} @endif
                                @if($order->status == 5) مرجعة @endif
                                @if($order->status == 6) تم تجهيز @endif
                        </span>
                        @endif

                    </td>
                    <td>
                        @if($item->shippingType == 'Aramex')   Aramex  @else إستلام بنفسي @endif
                    </td>
                    <td> @if($vendor != null) {{$vendor->shop_name}} @endif </td>
                    <td>  @if($order != null) {{ $order->id_rand }}  @endif</td>
                    <td>  <a href="https://www.aramex.com/track/results?ShipmentNumber={{$item->tracking}}" class="badge badge-success" target="_blank">
                                {{$item->tracking}}
                            </a>
                    </td>
                    <td>{{ date('Y-m-d, H:i', strtotime($item->created_at)) }}</td>
                    <td> </td>
                    <td> {{$item->order_id}}  @if($order == null) <small>(محذوف)</small> @endif </td>


                    </tr>
                @endforeach
            </tbody>
        </table>

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
