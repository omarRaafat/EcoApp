@extends('layouts.dashapp')
@php
    $route = 'reports.DipositFromEanat';
    $name = '  المستحقين للإعانات  ';
@endphp
@push('page_title')
    {{ $name }}
@endpush

@section('styles')
    <style>
        .dt-buttons {
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
                        <a href="{{ route('dash.' . $route) }}" class="acitve"> {{ $name }} <span
                                class="badge badge-info"> العدد :
                                {{ $clients->total() }}</span> </a>
                    </div>
                </div>
            </div>
            <br>
            <div class="">
                @include('dash.filters.eanatIndex')
                {{-- <form class="row text-right" action=" " method="GET" id="formsearch">
                    <div class="col-md-2">
                        <label>البخث</label>
                        <input type="search" name="search" class="form-control" placeholder="الإسم,الجوال"
                            value="{{ request()->get('search') }}">
                    </div>
                    <div class="col-md-2">
                        <label>تاريخ من</label>
                        <input type="date" name="date" class="form-control" value="{{ request()->get('date') }}">
                    </div>
                    <div class="col-md-2">
                        <label> تاريخ إلى</label>
                        <input type="date" name="date_to" class="form-control" value="{{ request()->get('date_to') }}">
                    </div>
                    <div class="col-md-2">
                        <label> سنة الطلبات</label>
                        <input type="number" name="orderYear" class="form-control" value="{{ date('Y') }}">
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success mt-4" style="width: 100%">بحث</button>
                    </div>
                </form> --}}
                <br><br>
                <table id="exampleee" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>رقم الهوية</th>
                            <th>الإسم</th>
                            <th> عدد الاعانات </th>
                            <th>إجمالي الإعانات</th>
                            <th>عدد الطلبات الرئيسية</th>
                            <th>عدد الطلبات الفرعية</th>
                            <th>عدد الطلبات الملغية الفرعية</th>
                            <th>قيمة الطلبات الفرعية المنصرفة</th>
                            <th>قيمة الطلبات الفرعية الملغية</th>
                            <th>صافي قيمة الطلبات</th>
                            <th>رصيد الاعانات</th>
                            <th>معرفات الطلبات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                            @php 
                                $cart_vendors_canceled_total = 0;
                                $cart_vendors_completed_total = 0 ;
                                foreach ($client->cart_vendors as $cart_vendor){
                                    if($cart_vendor->status == 4){  
                                        foreach ($cart_vendor->orderDetailsVendor  as $key => $valueProduct) {
                                            $cart_vendors_canceled_total += ($valueProduct->price * $valueProduct->quantity);
                                        }
                                        $cart_vendors_canceled_total += $cart_vendor->lineshippingprice;
                                    }else{
                                        foreach ($cart_vendor->orderDetailsVendor  as $key => $valueProduct) {
                                            $cart_vendors_completed_total += ($valueProduct->price * $valueProduct->quantity);
                                        }
                                        $cart_vendors_completed_total += $cart_vendor->lineshippingprice;
                                    }
                                }
                            @endphp
                            <tr>
                                <td>{{ $client->id }}</td>
                                <td>{{ $client->id_number }}</td>
                                <td> 
                                    <a href="{{ route('dash.clients.notajax_show', $client->id) }}">
                                        <span class="badge badge-dark">{{ $client->name }}</span> 
                                    </a>
                                </td>
                                <td>{{ $client->eanat_count }}</td>
                                <td>{{ number_format($client->total_eanat, 2, '.', ',') }}</td>
                                </td>
                                <td>{{ $client->orders_count }}</td>
                                <td>{{ $client->cart_vendors_count }}</td>
                                <td>{{ $client->cart_vendors_canceled_count }}</td>
                                <td>
                                    {{ number_format($cart_vendors_completed_total, 2, '.', ',') }}
                                </td>
                                <td>
                                    {{ number_format($cart_vendors_canceled_total, 2, '.', ',') }}
                                </td>
                                <td>{{ number_format($client->total_purchases  - $client->SatisfactionClientWallet_total(), 2, '.', ',') }}</td>
                                <td>{{ number_format($client->total_eanat - $cart_vendors_completed_total - $client->SatisfactionClientWallet_total(), 2, '.', ',') }}</td>
                                <td>
                                    @if ($client->orders_count)
                                        @foreach ($client->orders as $order)
                                            <a href="{{ route('dash.orders.show', $order->id) }}"><span
                                                    class="badge badge-pill badge-success">{{ $order->id }}</span></a>
                                        @endforeach
                                    @else
                                        <span class="badge badge-pill badge-warning">لا يوجد طلبات</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $clients->withQueryString()->links('pagination.default') }}
            </div>
        </div>
    </div>
@endsection
{{-- 
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
@endsection --}}
