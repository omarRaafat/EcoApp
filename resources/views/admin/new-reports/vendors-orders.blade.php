@extends('admin.layouts.master')
@section('title')
    @lang('admin.reports.vendors_sales')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet"/>
@endsection

@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row g-3">
                            <div class="col-xxl-2 col-sm-6">
                                <div class="search-box">
                                    <select name="vendor" class="form-select" dir="rtl" data-choices data-choices-removeItem >
                                        <option value="">@lang('reports.select-vendor')</option>
                                        @foreach($vendors ?? [] as $vendor)
                                            <option value='{{ $vendor['id'] }}' @selected($vendor['id'] == request()->get('vendor'))> {{ $vendor['name'] }} </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback" id="vendor-id-error" role="alert">
                                        <strong> @lang("admin.required") </strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-6">
                                <div class="search-box">
                                    <input name="from" type="date" class="form-control flatpickr-input active" value="{{ request()->get('from') }}"
                                           data-provider="flatpickr" data-date-format="Y-m-d"
                                           placeholder="@lang('reports.date-from')">
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-6">
                                <div class="search-box">
                                    <input name="to" type="date" class="form-control flatpickr-input active" value="{{ request()->get('to') }}"
                                           data-provider="flatpickr" data-date-format="Y-m-d"
                                           placeholder="@lang('reports.date-to')">
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="submit" class="btn btn-secondary w-100" >
                                        <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                        تصفية
                                    </button>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <a href="{{route('admin.reports.vendors_sales')}}" class="btn btn-info w-100"><i class="ri-equalizer-fill me-1 align-bottom"></i>
                                        إعادة                                 </a>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <a href="{{ route('admin.reports.vendors_sales' , [
                                         'vendor' => request()->get('vendor') ,
                                         'from' => request()->get('from') ,
                                         'to' => request()->get('to') ,
                                         'all_export_excel'=>true
                                         ]) }}" class="btn btn-primary"> تصدير Excel</a>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <a class="btn btn-success"
                                   href="{{ route('admin.reports.vendors_sales_print' , [
                                         'vendor' => request()->get('vendor') ,
                                         'from' => request()->get('from') ,
                                         'to' => request()->get('to') ,
                                         ]) }}" target="_blank">
                                    طباعة التقرير</a>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
            </div>
            <div class="card mt-5">
                @if(session()->has('error'))
                    <div class="alert alert-danger"> {{ session('error') }} </div>
                @endif
                <div class="card-body d-flex flex-column gap-4">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th>@lang('reports.vendors-orders.vendor')</th>
                                    <th>@lang('reports.vendors-orders.sub-order-code')</th>
                                    <th>@lang('reports.vendors-orders.order-id')</th>
                                    <th>@lang('reports.vendors-orders.created-at')</th>
                                    <th>@lang('reports.vendors-orders.delivered-at')</th>
                                    <th>@lang('reports.vendors-orders.total-without-vat')</th>
                                    <th>@lang('reports.vendors-orders.vat-rate')</th>
                                    <th>@lang('reports.vendors-orders.total-with-vat')</th>
                                    <th>@lang('reports.vendors-orders.company-profit-without-vat')</th>
                                    <th>@lang('reports.vendors-orders.company-profit-vat-rate')</th>
                                    <th>@lang('reports.vendors-orders.company-profit-with-vat')</th>
                                    <th>@lang('reports.vendors-orders.vendor-amount')</th>
                                    <th> خصومات التاجر </th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach($collection ?? [] as $row)
                                    <tr>
                                        <td> {{ $row->wallet?->vendor?->getTranslation("name", "ar") ?? 'N/A' }} </td>
                                        <td> {{ $row->order?->code ?? 'N/A' }} </td>
                                        <td> {{ $row->order?->id  ?? 'N/A'}} </td>
                                        <td> {{ $row->created_at?->toDateString() }} </td>
                                        <td> {{ $row->order?->delivered_at?->toDateString() }} </td>
                                        <td> {{ $row->order?->sub_total_in_sar_rounded * 100 }} @lang("translation.sar") </td>
                                        <td> {{ $row->order?->vat_in_sar_rounded  * 100}} @lang("translation.sar") ({{ $row->order?->vat_percentage }}%) </td>
                                        <td> {{ $row->order?->total_in_sar_rounded  * 100}} @lang("translation.sar") </td>
                                        <td> {{ $row->order?->company_profit_without_vat_in_sar_rounded * 100 }} @lang("translation.sar") </td>
                                        <td> {{ $row->order?->company_profit_vat_rate_rounded * 100 }} @lang("translation.sar") ({{ $row->order?->vat_percentage }}%) </td>
                                        <td> {{ $row->order?->company_profit_in_sar_rounded * 100 }} @lang("translation.sar") ({{ $row->order?->company_percentage }}%)</td>
                                        <td> {{ $row->operation_type == 'in' ? $row->amount : '0' }}  @lang("translation.sar") </td> 
                                        <td> {{ $row->operation_type == 'out' ? $row->amount : '0' }}  @lang("translation.sar") </td> 

                                    </tr>
                                @endforeach
                                @if($collection->isEmpty())
                                    <tr>
                                        <td colspan = "12">
                                            <center>
                                                @lang('reports.vendors-orders.no-orders')
                                            </center>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                {{-- check instance only for making sure it has a pagination, collection can be an empty support collection --}}
                                @if($collection instanceof Illuminate\Contracts\Pagination\LengthAwarePaginator)
                                    {{ $collection->appends(request()->query()) }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="{{ URL::asset('assets/libs/list.js/list.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
