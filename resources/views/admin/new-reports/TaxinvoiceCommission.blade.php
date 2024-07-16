@extends('layouts.dashapp')
@push('page_title') فاتورة ضريبية (فاتورة العمولة) @endpush

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
                    <a href=" " class="acitve"> فاتورة ضريبية (فاتورة العمولة) </a>
                </div>
            </div>
            <div class="col-md-6 text-left">

            </div>
        </div>
        <br>
        <div class="text-right">
            <form action=" " method="get">
                <input type="hidden" name="action" value="print">
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
                        <input type="date" name="date" class="form-control" value="{{ request()->get('date') }}"
                            required>
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="date_to" class="form-control" value="{{ request()->get('date_to') }}"
                            required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-success mt-1 ml-1"> أمر صرف <i
                                class="fas fa-pdf"></i> </button>
                    </div>

                </div>
            </form>
            <br>
            <table class="table table-bordered">
                <tr>
                    <td>#</td>
                    <th>تاجر</th>
                    <td>تاريخ من</td>
                    <td>تاريخ إلى</td>
                    <td></td>
                </tr>
                <tbody>
                    @foreach (\App\Models\ReportFacture::where('sector','TaxinvoiceCommission')->get(); as $item)
                    <tr>
                        <td> {{ $item->vendor_id.'00'.$item->id}}</td>
                        <td>
                            @php
                            $vendor = \App\Models\Vendor::find($item->vendor_id);
                            @endphp
                            @if($vendor !=null) {{ $vendor->shop_name }} @endif
                        </td>
                        <td>{{$item->date}}</td>
                        <td>{{$item->date_to}}</td>
                        <td>
                            <a class="btn btn-info btn-sm"
                                href=" ?action=print&vendor_id={{ $item->vendor_id }}&date={{ $item->date }}&date_to={{ $item->date_to }}">أمر
                                صرف <i class="fas fa-file-pdf text-white "></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

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
        'copy', 'excel', 'print',
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
