@extends('layouts.dashapp')
@php
        $route = 'reports.DipositFromEanat';
        $name = '  المستحقين للإعانات  ';
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
        <form class="row text-right" action=" " method="GET" id="formsearch">
            <div class="col-md-2">
                <label>البخث</label>
                <input type="search" name="search" class="form-control" placeholder="الإسم,الجوال" value="{{ request()->get('search') }}" >
            </div>
            <div class="col-md-2">
                <label>تاريخ  من</label>
                <input type="date" name="date" class="form-control" value="{{ request()->get('date') }}" >
            </div>
            <div class="col-md-2">
                <label> تاريخ إلى</label>
                <input type="date" name="date_to" class="form-control" value="{{ request()->get('date_to') }}" >
            </div>
            <div class="col-md-2">
                <label> سنة الطلبات</label>
                <input type="number" name="orderYear" class="form-control" value="{{ date('Y') }}" >
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-success mt-4" style="width: 100%">بحث</button>
            </div>

        </form>
        <br><br>
        @php
            $orders = \App\Models\PaymentClientDiposit::with('client')->where('payment_method','إعانة');
            if(request()->get('search') != null && request()->get('search') != ''){
                $client_ids = \App\Models\Client::where('name','like', '%' . request()->get('search') . '%')->orWhere('phone','like', '%' . request()->get('search') . '%')->pluck('id')->toArray();
                $orders = $orders->whereIn('user_id',$client_ids);
            }
            if(request()->get('date') != null && request()->get('date') != ''){
                $orders = $orders->whereDate('created_at','>=',request()->get('date'));
            }
            if(request()->get('date_to') != null && request()->get('date_to') != ''){
                $orders = $orders->whereDate('created_at','<=',request()->get('date_to'));
            }

            $rows = $orders->paginate(500);
        @endphp

         <table  id="exampleee" class="display" style="width:100%">
            <thead>
                <tr>
                <th>  الإسم</th>
                <th> الإستحقاق </th>
                <th>1 المشتريات </th>
                <th>2 المشتريات </th>
                <th>3 المشتريات </th>
                <th>4 المشتريات </th>
                <th>5 المشتريات </th>
                <th>6 المشتريات </th>
                <th>7 المشتريات </th>
                <th>8 المشتريات </th>
                <th>9 المشتريات </th>
                <th>10 المشتريات </th>
                <th>10 المشتريات </th>
                <th>12 المشتريات </th>
                <th>الباقي </th>
                <th>بتاريخ </th>
            </tr>
            </thead>
            <tbody>
                @foreach ($rows as $item)
                    <tr>
                        <td> {{ $item->client->name }}</td>
                        <td class="px-1"> <span class="badge badge-info">{{ $item->total_amount }}</span> </td>
                        @php
                            $rest = $item->total_amount;
                        @endphp
                        @for ($i = 1; $i <= 12; $i++)
                            @php
                            $calc = \App\Models\Order::where('user_id',$item->user_id)->whereMonth('created_at',$i)->whereYear('created_at',request()->get('orderYear'))->sum('total');
                            $rest -= $calc;
                            @endphp
                            <td>  {{ $calc }} </td>
                        @endfor
                        <td class="px-1"> <span class="badge badge-danger">{{ number_format($rest,2,'.','') }}</span> </td>
                        <td>{{ date('Y-m-d, H:i', strtotime($item->created_at)) }}</td>
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
