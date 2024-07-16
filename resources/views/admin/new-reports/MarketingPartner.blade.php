@extends('layouts.dashapp')
@php
        $route = 'reports.MarketingPartner';
        $name = 'شريك التسويق';

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
                 <a href="{{ route('dash.'.$route) }}" class="acitve"> {{$name}}   <span class="badge badge-info">   العدد :  {{$count}}</span> </a>
             </div>
            </div>
        </div>
     <br>
     <div class="">
        <form class="row" action="{{ route('dash.'.$route) }}" method="GET" id="formsearch">
            <div class="col-md-3">
                <label>البحث</label>
                <input type="search" name="search" class="form-control" value="{{ request()->get('search') }}">
            </div>
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
        <br>
        <table id="exampleee" class="display" style="width:100%">
            <thead>
                <tr>
                <th>#ID</th>
                <th>المسوق</th>
                <th>عدد طلبات</th>
                <th>كوبون عميل جديد</th>
                <th>كوبون عميل قديم</th>
                <th>زيارة عميل جديد</th>
                <th>زيارة عميل قديم</th>
                <th> المبالغ  المتبقية  </th> 
                <th> المبالغ  المحولة  </th>
                <th>أخر تحديث</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>
                            @php 
                             $rowsOrders = \App\Models\Order::where('status',3)->where('status',3)->orderBy('id','desc');
                                if(!empty(request()->get('date')) && !empty(request()->get('date_to')) ){
                                    $from = date('Y-m-d',strtotime(request()->get('date')));
                                    $to = date('Y-m-d',strtotime(request()->get('date_to')));

                                    $rowsOrders->whereBetween('created_at', [$from, $to]);
                                }
                                $rowsOrders =  $rowsOrders->where(function($query) use ($item){
                                    $query->where('affiliatecouponCode',$item->couponCode)
                                    ->orWhere('affiliateVisitCode',$item->urlCode);
                                });
                                $countOrders = $rowsOrders->get()->count();
                            @endphp
                            {{ $countOrders }}
                        </td>
                        <td>{{ $item->radio_coupon }}</td>
                        <td>{{ $item->radioOldCoupon }}</td>
                        <td>{{ $item->radio_newClient }}</td>
                        <td>{{ $item->radio_oldClient }}</td>
                        <td>{{ $item->sold() }}</td>
                        <td>{{ $item->sold_withdraw() }}</td>
                        <td>
                            <small>
                                {{ Carbon\Carbon::parse($item->updated_at)->diffForHumans()}}
                            </small>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $rows->links('pagination.default') }}
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