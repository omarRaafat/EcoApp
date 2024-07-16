@extends('layouts.dashapp')
@php
        $route = 'reports.vendorsSales';
        $name = 'مبيعات التجار أمر الصرف';
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
                 <a href="{{ route('dash.'.$route) }}" class="acitve"> {{$name}}  </a>
             </div>
            </div>
            <div class="col-md-6 text-left">
                
            </div>
        </div>
     <br>
     <div class="">
        <form class="row" action="{{ route('dash.'.$route.'.OrderReceive') }}" method="GET" id="formsearch">
            <div class="col-md-3">
                <label>من تاريخ</label>
                <input type="date" name="date" class="form-control" value="{{ request()->get('date') }}" >
            </div>
            <div class="col-md-3">
                <label>إلى تاريخ</label>
                <input type="date" name="date_to" class="form-control" value="{{ request()->get('date_to') }}" >
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-success mt-4" style="width: 100%">أمر صرف <i class="fas fa-file-pdf text-white "></i></button>
             </div>
        </form>
     </div>
     <br>
     <table class="table table-bordered">
         <tr>
            <td>#</td>
            <td>تاريخ من</td>
            <td>تاريخ إلى</td>
            <td></td>
         </tr>
         <tbody>
             @foreach (\App\Models\ReportFacture::where('sector','vendorSales')->get(); as $item)
             <tr>
                <td>{{$item->id.'000'}}</td>
                <td>{{$item->date}}</td>
                <td>{{$item->date_to}}</td>
                <td>
                    <a class="btn btn-info btn-sm" href="{{ route('dash.'.$route.'.OrderReceive') }}?action=print&date={{ $item->date }}&date_to={{ $item->date_to }}">أمر صرف <i class="fas fa-file-pdf text-white "></i></a>
                </td>
             </tr>
             @endforeach
         </tbody>
     </table>
     

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
        bSort: true,
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