@extends('admin.layouts.master')
@section('title')
    @lang('admin.reports.SalesAllVendors')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    @include('sweetalert::alert')
    @if(session()->has('error'))
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-danger">{{ session("error") }}</div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="wallets">
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form method="get" action="{{ URL::asset('/admin') }}/reports/SalesAllVendors/">

                        <div class="row">
                            <div class="col-xxl-3 col-sm-4">
                            <select name="vendor" class="form-select" dir="rtl" data-choices data-choices-removeItem >
                                <option value="">@lang('reports.select-vendor')</option>
                                @foreach($vendors ?? [] as $vendor)
                                    <option value='{{ $vendor['id'] }}' @selected($vendor['id'] == request()->get('vendor'))> {{ $vendor['name'] }} </option>
                                @endforeach
                            </select>
                            </div>
                            <div class="col-xxl-3 col-sm-4">
                                <div>
                                    <input value="{{ request('from') }}"  name="from" type="date" class="form-control flatpickr-input active" data-provider="flatpickr"  data-maxDate="today" data-date-format="Y-m-d" placeholder="@lang('admin.from')">
                                </div>
                            </div>
                            <div class="col-xxl-3 col-sm-4">
                                <div>
                                    <input value="{{ request('to') }}" name="to" type="date" class="form-control flatpickr-input active" data-provider="flatpickr"  data-maxDate="today" data-date-format="Y-m-d" placeholder="@lang('admin.to')">
                                </div>
                            </div>

                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="submit" class="btn btn-secondary w-100">
                                        <i class="ri-equalizer-fill me-1 align-bottom"></i> تصفية
                                    </button>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <a href="{{ route('admin.reports.SalesAllVendors' , [
                                     'from' => request()->get('from') ,
                                     'to' => request()->get('to') ,
                                     'vendor' => request()->get('vendor') ,
                                     'all_export_excel'=>true
                                     ]) }}" class="btn btn-primary">تصدير Excel</a>
                                </div>
                            </div>
                            <div class="col-xxl-1">

                                <a href="{{ route('admin.reports.SalesAllVendors.print', ['all_print'=>true, 'from' => request()->get('from') ,
                                    'to' => request()->get('to') ,    'vendor' => request()->get('vendor') ]) }}" class="btn btn-success" target="_blank">
                                    طباعة التقرير
                                </a>
        {{--                        <a href="{{ route('admin.reports.SalesAllVendors' , ['all_export_pdf'=>true]) }}" class="btn btn-primary">--}}
        {{--                            تصدير PDF--}}
        {{--                        </a>--}}
                            </div>

                        </div>
                    </form>

                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-body ">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="warehousesTable">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th># المعرف</th>
                                    <th>المتجر</th>
                                    <th>مجموع الطلبات بدون VAT</th>
                                    <th>قيمة الضريبة</th>
                                    <th>مجموع الطلبات مع VAT</th>
                                    <th style="width: 15%">عمولة المنصة بدون VAT</th>
                                    <th>قيمة ضريبة عمولة المنصة</th>
                                    <th>عمولة المنصة مع VAT</th>
                                    <th>مستحقات التاجر</th>
                                    <th>خصومات التاجر </th>
                                    <th>الصافي للتاجر</th>
                                    <th>الإجراءات</th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach ($orders as $key=> $item)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $item->vendor->name }}</td>
                                        <td>{{ $item->total_without_vat  }}</td>
                                        <td>{{ $item->total_vat }}</td>
                                        <td>{{ $item->total_with_vat  }}</td>
                                        <td>{{ $item->total_company_profit_without_vat  }}</td>
                                        <td>{{ $item->value_of_company_profit_vat  }}</td>
                                        <td>{{ $item->total_company_profit  }}</td>
                                        <td>{{ $item->total_balance  }}</td>
                                        <td>{{ $item->totalVendorOut()  }}</td>
                                        <td>{{ $item->total_balance - $item->totalVendorOut()  }}</td>
                                        <td>
                                            <a href="{{ route('admin.reports.SalesAllVendors.print' ,  $item->id ) }}"  class="btn btn-info" target="_blank">
                                                طباعة التقرير
                                            </a>
{{--                                            <a href="{{ route('admin.reports.mostSellingProducts' , ['created_at'=>true, 'barcode' => request()->get('barcode') , 'name' => request()->get('name') ]) }}" class="btn btn-primary">--}}
{{--                                                تنزيل التقرير PDF--}}
{{--                                            </a>--}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @if($orders->isEmpty())
                                <div class="noresult">
                                    <div class="text-center">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                                   colors="primary:#25a0e2,secondary:#0ab39c"
                                                   style="width:75px;height:75px">
                                        </lord-icon>
                                        <h5 class="mt-2">@lang('admin.reports.no_result_found')</h5>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                {{ $orders->appends(request()->query())->links("pagination::bootstrap-4") }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
