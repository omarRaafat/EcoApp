@extends('layouts.dashapp')
@php
        $route = 'reports.platformSales';
        $name = 'مبيعات المنصة';
@endphp
@push('page_title')   {{$name}} @endpush

@section('styles')
    <style>
        .dt-buttons{
            text-align: left;
            margin-bottom: 5px;
        }
    </style>
@endsection

@section('content')
<div class="container" style="">
    <div class="showdata">
        <div class="row">
            <div class="col-md-6">
             <div class="title_pagge">
                 <a href="{{ route('dash.home') }}">الرئيسية</a>
                 <i class="fas fa-chevron-left"></i>
                 <a href="{{ route('dash.'.$route) }}" class="acitve"> {{$name}}   </a>
             </div>
            </div>
        </div>
     <br>
     <div class="">
        <form class="row text-right" action="{{ route('dash.'.$route) }}" method="GET" id="formsearch">
            <div class="col-md-3"></div>
            <div class="col-md-3">
                <label>من تاريخ</label>
                <input type="date" name="date" class="form-control" value="{{ request()->get('date') }}" >
            </div>
            <div class="col-md-3">
                <label>إلى تاريخ</label>
                <input type="date" name="date_to" class="form-control" value="{{ request()->get('date_to') }}" >
            </div>
            <div class="col-md-3">
               <button type="submit" class="btn btn-success mt-4" style="width: 100%">بحث</button>
            </div>
        </form>
        <br><br>

        <div class="row">
            <div class="col-md-3">
                <div class="box shadow px-2 pt-3 pb-2">
                    <h5> عدد الطلبات الناجحة </h5>
                    <h6>{{ $count }}</h6>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box shadow px-2 pt-3 pb-2">
                    <h5> إجمالي قيمة الطلبات</h5>
                    <h6>{{ number_format($orders_total,2,'.',',') }}</h6>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box shadow px-2 pt-3 pb-2">
                    <h5> إجمالي المبيعات منتجات</h5>
                    <h6>{{ number_format($products_sells,2,'.',',') }}</h6>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box shadow px-2 pt-3 pb-2">
                    <h5> إجمالي قيمة التوصيل</h5>
                    <h6>{{ number_format($shipping_total,2,'.',',') }}</h6>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
             <div class="col-md-3">
                <div class="box shadow px-2 pt-3 pb-2">
                    <h5> إجمالي مبالغ البائعين الباقية </h5>
                    <h6>{{ $sold_vendors  - $sold_vendors_withdraw}}</h6>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box shadow px-2 pt-3 pb-2">
                    <h5> إجمالي مبالغ البائعين المحولة </h5>
                    <h6>{{ $sold_vendors_withdraw }}</h6>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box shadow px-2 pt-3 pb-2">
                    <h5> إجمالي مبالغ المسوقين الباقية </h5>
                    <h6>{{ $sold_affiliaters  - $sold_affiliaters_withdraw}}</h6>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box shadow px-2 pt-3 pb-2">
                    <h5> إجمالي مبالغ المسوقين المحولة </h5>
                    <h6>{{ $sold_affiliaters_withdraw }}</h6>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-3">
                <div class="box shadow px-2 pt-3 pb-2">
                    <h5> إجمالي قيمة الإيداعات </h5>
                    <h6> {{ $amount }} </h6>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box shadow px-2 pt-3 pb-2">
                    <h5> إجمالي قيمة  محافظ العملاء </h5>
                    <h6> {{ $walletSoldamount }} </h6>
                </div>
            </div> 
            <div class="col-md-3">
                <div class="box shadow px-2 pt-3 pb-2">
                    <h5> إجمالي قيمة الرجيع </h5>
                    <h6> {{ $ordersAmount }} </h6>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box shadow px-2 pt-3 pb-2">
                    <h5> إجمالي  المنصرف  لارضاء العملاء </h5>
                    <h6> {{ $satisfactionClientWalletAmount }} </h6>
                </div>
            </div> 
        </div>
        <br>
        <div class="row text-right">
            <div class="col-md-6 px-3">

            </div>
            <div class="col-md-6 px-3">
                <div class="card" >
                        <div class="card-header bg-white">
                            الساعات الأكثر طلبا
                        </div>
                        <ul class="list-group list-group-flush" style="height: 279px;overflow-y: auto;padding:0">
                            @foreach ($orders_hours as $orders_hours_item)
                                <li class="list-group-item">
                                    <i class="fas fa-globe-africa"></i> &nbsp; {{ ( strlen($orders_hours_item->hour) == 1) ? '0'.$orders_hours_item->hour : $orders_hours_item->hour }}  
                                    <span class="d-block badge badge-success float-left" title="عد طلبات">{{ $orders_hours_item->total }} </span>
                                </li>
                            @endforeach
                        </ul>
                  </div>         
            </div>
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
        searching:false,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'excel', 'print',
        ],
        "pageLength": 100,
        "order": [[ 0, "desc" ]],
        bSort: false,
        "scrollX": true,
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
