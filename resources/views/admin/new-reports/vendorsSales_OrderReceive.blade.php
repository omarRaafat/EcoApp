<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('dash/css/bootstrap.min.css') }}">
    <title>  نموذج مدفوعات  </title>
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
            @media print {
                th.table_th_coloring {
                    background-color: #25B695 !important;
                    -webkit-print-color-adjust: exact; 
                }
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
        .table th.table_th_coloring{
            text-align: center !important;
            background-color:#25B695;
        }
        .table th.text-center{
            text-align: center !important;
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
       
      
        
         <div style="text-align: right">
            <table class="table" style="text-align: center">
                <tr>
                     <td colspan="2">
                        <h6 style="text-align: center">نموذج مدفوعات منصة مزارع </h6>
                                @php 
                               $facture =  \App\Models\ReportFacture::where('sector','vendorSales')->where('date',request()->get('date'))->where('date_to',request()->get('date_to'))->first();
                                @endphp 
                                <h6 style="text-align: center">  نموذج رقم    :  <b class="en">{{ $facture->id .'000'  }}</b>  </h6>
                     </td>
                       <td>
                           <div style="text-align: left;display:inline-block;width:33%">
           <h6>بتاريخ : {{date('d-m-Y') }}</h6>
        </div>
                     </td>
                </tr>
            </table>
        
        <br><br>
        <table  class="table tale-bordered" >
            <tr>
                <th colspan="2" class="table_th_coloring"  >التفاصيل</th>
            </tr>
            <tr>
                <td class="text-center"> اسم المستفيد  </td>
                <td class="text-center">     منصة   مزارع</td>  
            </tr>
            <tr>
                <td class="text-center"> رقم حساب الإيبان  </td>
                <td class="text-center"> معرف لدى الادارة المالية </td>
            </tr>
            <tr>
                <td class="text-center"> طريقة الدفع  </td>
                <td class="text-center"> ملف مدفوعات مجمعة  </td>
            </tr>
        </table>

        <br><br>
        <table class="table tale-bordered" >
            <tr>
                <th colspan="2" class="table_th_coloring"   > البيان </th>
            </tr>
            <tr>
                <td class="text-center"> مستحقا ت التجار لشهر  </td>
                <td class="text-center">
                    @if(request()->get('date') != null && request()->get('date') != '')
                    <span>من تاريخ {{ request()->get('date') }}</span>
                    @endif
                    @if(request()->get('date_to') != null && request()->get('date_to') != '')
                    <span>إلى تاريخ {{ request()->get('date_to') }}</span>
                    @endif
                </td>
            </tr>
        </table>


        <br><br>
        <table class="table tale-bordered" >
            <tr>
                <th colspan="2" class=" class="text-center""> تفاصيل الدفع </th>
            </tr>
            <tr>
                <th class="text-center"> البند  </th>
                <th class="text-center"> المبلغ  </th>
            </tr>
            <tr>
                <td> منصة مزارع  </td>
                <td>
                    @php
                      $CartVendor_ids =  \App\Models\CartVendor::whereIn('status',[3])->pluck('order_id')->toArray();
                        $OrderDetails = \App\Models\OrderDetail::whereIn('order_id',$CartVendor_ids)->orderBy('id','desc');
                        if(request()->get('date') != null && request()->get('date') != ''){
                            $OrderDetails = $OrderDetails->whereDate('created_at','>=',request()->get('date'));
                        }

                        if(request()->get('date_to') != null && request()->get('date_to') != ''){
                            $OrderDetails = $OrderDetails->whereDate('created_at','<=',request()->get('date_to'));
                        }
                        
                        $products_ids = $OrderDetails->pluck('product_id')->toArray();
                        
                        $vendors_ids = \App\Models\Product::whereIn('id',$products_ids)->pluck('user_id')->toArray();
                        $vendors =  \App\Models\Vendor::whereIn('id',$vendors_ids)->get();
                        
                        $safe_sum = 0 ;

                        foreach($vendors as $vendor){
                           $vendorProducts = \App\Models\Product::where('user_id',$vendor->id)->pluck('id')->toArray();
                           $CartVendor_ids =  \App\Models\CartVendor::where('vendor_id',$vendor->id)->whereIn('status',[3])->pluck('order_id')->toArray();
                           $OrderDetails = \App\Models\OrderDetail::whereIn('order_id',$CartVendor_ids)->whereIn('product_id',$vendorProducts);
                            if(request()->get('date') != null && request()->get('date') != ''){ 
                               $OrderDetails = $OrderDetails->whereDate('created_at','>=',request()->get('date'));
                            }
                            if(request()->get('date_to') != null && request()->get('date_to') != ''){
                                $OrderDetails = $OrderDetails->whereDate('created_at','<=',request()->get('date_to'));
                            }
                            $OrderDetails = $OrderDetails->get();

                            $sum = 0;
                            foreach ($OrderDetails as $key => $value) {
                               $sum += floatval($value->price) * intval($value->quantity);
                            }
                            
                           /* $safe_sum += ((($sum + ($sum/(floatval($SellsTaxs->tva)/ 100 + 1) - $sum)) - (($sum + ($sum/(floatval($SellsTaxs->tva)/ 100 + 1) - $sum))* (floatval($vendor->vendor_percentage) / 100)) - ((($sum + ($sum/(floatval($SellsTaxs->tva)/ 100 + 1) - $sum))* (floatval($vendor->vendor_percentage) / 100)) *  (floatval($SellsTaxs->tva)/ 100))) + ($sum - ($sum + ($sum/(floatval($SellsTaxs->tva)/ 100 + 1) - $sum))));
                            $dash_profit = (($sum + ($sum/(floatval($SellsTaxs->tva)/ 100 + 1) - $sum))*  ($vendor->vendor_percentage / 100)) + ((($sum + ($sum/(floatval($SellsTaxs->tva)/ 100 + 1) - $sum))* ($vendor->vendor_percentage / 100)) * (floatval($SellsTaxs->tva) / 100));
                            $dash_profit_vat = (floatval($SellsTaxs->tva) *  $dash_profit)  /100;
                            $safe_sum -= $dash_profit_vat;*/
                            
                            
                            $vendorradddio = $vendor->vendor_percentage * 0.01;
                            $safe_sum += $sum-(( ($sum / 1.15) * $vendorradddio )*1.15);
                        }
                       


                    @endphp     
                   {{ number_format($safe_sum,2,'.','') }}
                </td>
            </tr>
        </table>

        <br><br>
        <table class="table tale-bordered" >
            <tr>
                <th colspan="3" > خاص بالإدارة المالية: </th>
            </tr>
            <tr>
                <th class="table_th_coloring" style="width:32%";>إعداد </th>
                <th class="table_th_coloring" style="width:32%";>مراجعة  </th>
                <th class="table_th_coloring" style="width:32%";>توصيه (مدير الإدارة المالية والخدمات المساندة) </th>
            </tr>
            <tr>
                <td class="text-center"> الاسم:   </td>
                <td>الاسم:</td>
                <td>الاسم:</td>
            </tr>
            <tr>
                <td class="text-center"> التوقيع:   </td>
                <td>التوقيع:</td>
                <td>التوقيع: </td>
            </tr>
            <tr>
                <td class="text-center"> التاريخ:   </td>
                <td>التاريخ:</td>
                <td>التاريخ: </td>
            </tr>
        </table>
        
        <br><br>
        <table class="table tale-bordered" >
            <tr>
                <th class="table_th_coloring">   موافقة (الرئيس التنفيذي): </th>
            </tr>
            <tr>
                <td class="text-center"> الإسم : د/</td>
            </tr>
            <tr>
                <td>التوقيع:</td>
            </tr>
            <tr>
                <td>التاريخ: </td>
            </tr>
        </table>
        
      
        


        <br><br><br>
        
         
    </div>

    <script src="{{ asset('dash/js/jquery.min.js') }}"></script>
    <script src="{{ asset('dash/js/html2pdf.bundle.js') }}"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            setTimeout(function(){
                var link2 = document.createElement('link');
                link2.innerHTML =
                    '<style>@media print{.table th.table_th_coloring{text-align: center !important;background-color:#25B695  !important;    -webkit-print-color-adjust: exact; } .text-center{ text-align: center !important;}}</style>';
                        
                 document.getElementsByTagName('head')[0].appendChild(link2);
                window.print();

            },200); 
        });
    </script>

</body>
</html>


