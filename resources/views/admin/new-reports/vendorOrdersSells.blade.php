@extends('layouts.dashapp')
@push('page_title') تقارير مبيعات البائع @endpush

@section('styles')
<style>
    .dt-buttons {
        text-align: left;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="showdata">
        <div class="row pt-2 pb-2">
            <div class="col-md-6">
                <div class="title_pagge">
                    <a href="{{ route('vendor.dashboard') }}">الرئيسية</a>
                    <i class="fas fa-chevron-left"></i>
                    <a href=" " class="acitve"> تقارير مبيعات البائع </a>
                </div>
            </div>
            <div class="col-md-6 text-left">

            </div>
        </div>
        <br>
        <div class="text-right">
            <form action=" " method="get">
                <div class="row">
                    <div class="col-md-2">
                        <select name="vendor_id" class="form-control" required>
                            <option value="" selected disabled>إختر البائع</option>
                            @foreach (\App\Models\Vendor::orderBy('shop_name','asc')->get() as $item)
                            <option value="{{$item->id}}" @if($item->id == request()->get('vendor_id')) selected
                                @endif>{{$item->shop_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="date" class="form-control" value="{{ request()->get('date') }}">
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="date_to" class="form-control" value="{{ request()->get('date_to') }}">
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-sm btn-success mt-1 ml-1"> <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div class="col-md-3 text-left">
                        @if($vendor != null)
                        <a class="btn-prinnt btn btn-info text-white btn-sm pt-1"
                            href=" ?action=print&vendor_id={{ request()->get('vendor_id') }}&date={{ request()->get('date') }}&date_to={{ request()->get('date_to') }}">طباعة
                            <i class="fas fa-file-pdf text-white "></i></a>
                        @endif
                    </div>
                </div>
            </form>
            <table id="exampleee" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>رقم الفاتورة الخاص بالتاجر </th>
                        <th>رقم الطلب </th>
                        <th>تاريخ الطلب</th>
                        <th>كمية المبيعات </th>
                        <th>قيمة المبيعات قبل الضريبة </th>
                        <th>نسبة الضريبة</th>
                        <th>قيمة الضريبة</th>
                        <th>قيمة المبيعات بعد الضريبة</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $totalqnt =0;
                    $totalsells =0;
                    $clm1 = 0;
                    $clm2 = 0;
                    @endphp
                    @foreach ($orders as $item)

                    @php
                    $SellsTaxs = \App\Models\SellsTaxs::find(1);
                    $products_ids = \App\Models\Product::where('user_id',intval($vendor->id))->pluck('id')->toArray();
                    $sells =
                    \App\Models\OrderDetail::whereIn('product_id',$products_ids)->orderBy('id','desc')->where('order_id',$item->id);
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
                        $vendor_calc = ($sells_val * $vendor->vendor_percentage) / 100;
                        $TAXcal = (($sells_val / 1.15) * $SellsTaxs->tva) / 100;

                        $tadiracalc = (floatval($SellsTaxs->tva) * ($sells_val/1.15) ) /100 ;
                        $clm1 += $sells_val - $tadiracalc;
                        $clm2 += $tadiracalc;
                        @endphp
                        @if($dd > 0)
                        <tr>
                            <td> <a href="{{ route('dash.orders.show',$item->id) }}" class="badge badge-success">{{
                                    $vendor->id.$item->id_rand }} </a></td>
                            <td>{{ $item->id }}</td>
                            <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                            <td>
                                {{ $dd }}
                            </td>
                            <td>
                                {{ number_format($sells_val - $tadiracalc,2,'.','') }} ر.س
                            </td>
                            <td>{{ $SellsTaxs->tva }}% </td>
                            <td>{{ number_format($tadiracalc,2,'.','') }} ر.س </td>
                            <td> {{ number_format( $sells_val,2,'.','') }} ر.س</td>
                        </tr>
                        @endif
                        @endforeach
                </tbody>
            </table>

            <br>
            <div class="">
                <table class="table table-bordered">
                    <thead>
                        <th> </th>
                        <th> </th>
                        <th>كمية المبيعات </th>
                        <th>قيمة المبيعات قبل الضريبة </th>
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
</div>


@endsection


@section('javascripts')
<script src="{{ asset('dash/js/datatablell/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('dash/js/datatablell/buttons.flash.min.js') }}"></script>
<script src="{{ asset('dash/js/datatablell/jszip.min.js') }}"></script>
<script src="{{ asset('dash/js/datatablell/pdfmake.min.js') }}"></script>
<script src="{{ asset('dash/js/datatablell/vfs_fonts.js') }}"></script>
<script src="{{ asset('dash/js/datatablell/buttons.html5.min.js') }}"></script>
<script src="{{ asset('dash/js/datatablell/buttons.print.min.js') }}"></script>

<script>
    $('#exampleee').DataTable({
    responsive: true,
      "paging": true,
    "lengthMenu": [ 50,  75, 100,200 ],
    dom: 'Bfrtip',
    buttons: [
        'copy', 'excel',
    ],
    "order": false,
    "language": {
        "lengthMenu": "عرض _MENU_ عنصر للصفحة",
        "zeroRecords": "لا يوجد اي بيانات  ",
        "info": "إظهار الصفحة _PAGE_ نمن _PAGES_",
        "infoEmpty": "لا يوجد اي بيانات لعرضها",
        "infoFiltered": "(فلتر من _MAX_ total عنصر)",
        "sLengthMenu":   	"_MENU_ Einträge anzeigen",
        "sLoadingRecords": 	"جاري التحميل...",
        "sProcessing":   	"جاري االعرض...",
        "sSearch":       	"البحث:",
        "sZeroRecords":  	"لا مداخل المتاحة.",
        "oPaginate": {
            "sFirst":    	"الأول",
            "sPrevious": 	"السابق",
            "sNext":     	"القادم",
            "sLast":     	"الأخر"
        },
        "oAria": {
            "sSortAscending":  ": تمكين لفرز العمود في ترتيب تصاعدي",
            "sSortDescending": ": تمكين لفرز العمود في ترتيب تنازلي"
        },
    },
});
</script>

@endsection
