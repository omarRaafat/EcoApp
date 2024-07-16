@extends('layouts.dashapp')
@php
    $route = 'reports.vendorsSales';
    $name = 'مبيعات التجار';
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
                                class="badge badge-info"> العدد : {{ $earns->count() }}</span> </a>
                    </div>
                </div>
                <div class="col-md-6 text-left">

                </div>
            </div>
            <br>
            <div class="">
                <form action="{{ route('dash.' . $route) }}" method="GET" id="formsearch">
                    <div class="row">
                        <div class="col-md-2">
                            <label>بحث</label>
                            <input type="search" name="search" class="form-control" value="{{ request()->get('search') }}"
                                placeholder="البحث">
                        </div>
{{--                        <div class="col-md-2">--}}
{{--                            <label>تاريخ انشاء الطلب من</label>--}}
{{--                            <input type="date" name="date" class="form-control" value="{{ request()->get('date') }}">--}}
{{--                        </div>--}}
{{--                        <div class="col-md-2">--}}
{{--                            <label>تاريخ انشاء الطلب الى</label>--}}
{{--                            <input type="date" name="date_to" class="form-control"--}}
{{--                                value="{{ request()->get('date_to') }}">--}}
{{--                        </div>--}}
                        <div class="col-md-2">
                            <label>تاريخ تسليم الطلب من</label>
                            <input type="date" name="deliver_date" class="form-control"
                                value="{{ request()->get('deliver_date') }}">
                        </div>
                        <div class="col-md-2">
                            <label>تاريخ تسليم الطلب الى</label>
                            <input type="date" name="deliver_date_to" class="form-control"
                                value="{{ request()->get('deliver_date_to') }}">
                        </div>
                        <div class="col-md-2 mb-2">
                            <button type="submit" class="btn btn-success mt-4">بحث</button>
                            <a class="btn-prinnt btn btn-info text-white btn-sm pt-1 mt-4"
                                href=" ?action=printAll&page={{ request()->get('page') }}&&search={{ request()->get('search') }}&date={{ request()->get('date') }}&date_to={{ request()->get('date_to') }}&deliver_date={{ request()->get('deliver_date') }}&deliver_date_to={{ request()->get('deliver_date_to') }}">طباعة
                                الجميع <i class="fas fa-file-pdf text-white "></i></a>
                        </div>
                    </div>
                </form>
                <table id="exampleee" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>البائع</th>
                            <th>قيمة مبيعات التجار غير شاملة VAT</th>
                            <th>قيمة الضريبة (15%)</th>
                            <th>قيمة مبيعات التجار شاملة VAT</th>
                            <th>عمولة المنصة غير شاملة VAT</th>
                            <th>قيمة الضريبة على العمولة (15%)</th>
                            <th>قيمة عمولة المنصة شاملة VAT</th>
                            <th>صافي المستحق للتاجر</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($earns as $vendor_earn)
                        <tr>
                            <td>{{ $vendor_earn->vendor_id }}</td>
                            <td>{{ $vendor_earn->shop_name }}</td>

                            <td>{{number_format($vendor_totals[$vendor_earn->vendor_id]["total_without_vat"], 2, ".", ",") }}
                            </td>
                            <td>{{number_format($vendor_totals[$vendor_earn->vendor_id]["total_vat"], 2, ".", ",") }}
                            </td>
                            <td>{{number_format($vendor_totals[$vendor_earn->vendor_id]["total_with_vat"], 2, ".", ",") }}</td>

                            <td>{{number_format($vendor_totals[$vendor_earn->vendor_id]["commission_without_vat"], 2, ".", ",") }}
                            </td>
                            <td>{{number_format($vendor_totals[$vendor_earn->vendor_id]["commission_vat"], 2, ".", ",") }}</td>
                            <td>{{number_format($vendor_totals[$vendor_earn->vendor_id]["commission_with_vat"], 2, ".", ",") }}</td>

                            <td>{{number_format($vendor_totals[$vendor_earn->vendor_id]["total_earn"], 2, ".", ",") }}</td>
                            <td>
                                <a class="btn-prinnt btn btn-info text-white btn-sm pt-1"
                                    href="{{ route('dash.reports.vendorOrdersSellsCompleted') }}?action=printAll&&vendor_id={{ $vendor_earn->vendor_id }}&page={{ request()->get('page') }}&search={{ request()->get('search') }}&date={{ request()->get('date') }}&date_to={{ request()->get('date_to') }}&completed_date={{ request()->get('deliver_date') }}&completed_date_to={{ request()->get('deliver_date_to') }}">طباعة
                                    <i class="fas fa-file-pdf text-white "></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <br>
                <table class="table table-bordered">
                    <thead>
                    <th>قيمة المبيعات غير شامل VAT</th>
                    <th>قيمة VAT (15%)</th>
                    <th>قيمة المبيعات شامل VAT</th>
                    <th>عمولة المنصة غير شامل VAT</th>
                    <th>قيمة VAT (15%) على عمولة المنصة</th>
                    <th>عمولة المنصة شامل VAT</th>
                    <th>صافي مستحقات التجار</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">
                                {{ number_format($totals["total_without_vat"],2,".",",") }}
                            </td>
                            <td class="text-center">
                                {{ number_format($totals["total_vat"],2,".",",") }}
                            </td>
                            <td class="text-center">
                                {{ number_format($totals["total_with_vat"],2,".",",") }}</td>
                            <td class="text-center">{{ number_format($totals["commission_without_vat"],2,".",",") }}</td>
                            <td class="text-center">
                                {{ number_format($totals["commission_vat"],2,".",",") }}</td>
                            <td class="text-center">{{ number_format($totals["commission_with_vat"],2,".",",") }}</td>

                            <td class="text-center">
                                {{ number_format($totals["total_earn"],2,".",",") }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                {{ $earns->links('pagination.default') }}

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
            searching: false,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel',
            ],
            "pageLength": 100,
            "order": [
                [0, "desc"]
            ],
            bSort: true,
            "scrollX": true,
            "language": {
                "lengthMenu": "عرض _MENU_ عنصر للصفحة",
                "zeroRecords": "لا يوجد اي بيانات  ",
                "info": "إظهار الصفحة _PAGE_ نمن _PAGES_",
                "infoEmpty": "لا يوجد اي بيانات لعرضها",
                "infoFiltered": "(فلتر من _MAX_ total عنصر)",
                "sLengthMenu": "_MENU_ Einträge anzeigen",
                "sLoadingRecords": "جاري التحميل...",
                "sProcessing": "جاري االعرض...",
                "sSearch": "البحث:",
                "sZeroRecords": "لا مداخل المتاحة.",
                "oPaginate": {
                    "sFirst": "الأول",
                    "sPrevious": "السابق",
                    "sNext": "القادم",
                    "sLast": "الأخر"
                },
                "oAria": {
                    "sSortAscending": ": تمكين لفرز العمود في ترتيب تصاعدي",
                    "sSortDescending": ": تمكين لفرز العمود في ترتيب تنازلي"
                },
            },
        });
    </script>
@endsection
