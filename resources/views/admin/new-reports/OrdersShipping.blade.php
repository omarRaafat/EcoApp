@extends('admin.layouts.master')
@section('title')
    @lang('admin.reports.OrdersShipping')
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
        <div class="card" id="reports">
            <div class="card-body border border-dashed border-end-0 border-start-0">
                <form action="{{ route("admin.reports.OrdersShipping") }}">
                    <div class="row g-3">

                        <div class="col-xxl-3 col-sm-6">
                            <div class="search-box">
                                <input name="from" type="date" class="form-control search"
                                       placeholder="@lang("admin.reports.search_barcode")" value="{{ request('from') }}">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-sm-6">
                            <div class="search-box">
                                <input name="to" type="date" class="form-control search"
                                       placeholder="@lang("admin.reports.search_barcode")" value="{{ request('to') }}">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-xxl-1 col-sm-4">
                            <div>
                                <button type="submit" class="btn btn-secondary w-100" onclick="SearchData();"><i
                                        class="ri-equalizer-fill me-1 align-bottom"></i>
                                        @lang("admin.reports.filter")
                                </button>
                            </div>
                        </div>
                        <div class="col-xxl-1 col-sm-4">
                            <div>
                                <a href="{{route('admin.reports.OrdersShipping')}}" class="btn btn-info w-100"><i
                                        class="ri-equalizer-fill me-1 align-bottom"></i>
                                        @lang("admin.warehouses.reset")
                                </a>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </form>
            </div>


            <div class="card-body border border-dashed border-end-0 border-start-0">
                <div class="row">
                    <div class="col-md-3 float-right">
                        <a href="{{ route('admin.reports.OrdersShipping' , ['export'=>true, 'from' => request()->get('from') , 'to' => request()->get('to') ]) }}" class="btn btn-primary">تصدير Excel</a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div>
                    <div class="table-responsive table-card mb-1">
                        <table class="table table-nowrap align-middle" id="warehousesTable">
                            <thead class="text-muted table-light">
                            <tr class="text-uppercase">
                                <th># المعرف</th>
                                <th>العميل</th>
                                <th>عدد المنتجات</th>
                                <th>قيمه المبيعات</th>
                                <th>الشحن</th>
                                <th>بتاريخ</th>
                            </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach ($paginateOrders as $key=> $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->customer_name }}</td>
                                        <td>{{ count($item->orderProducts) }}</td>
                                        <td>{{ $item->orderProducts()->sum('total') }}</td>
                                        <td>
                                            {{ $item->delivery_fees }}
                                         </td>
                                        <td>
                                            {{ date('d-m-Y, H:i', strtotime($item->created_at)) }}
                                        </td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div>
                <!-- End Delete Modal -->
                    @if($paginateOrders->isEmpty())
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
                    @if ($paginateOrders instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        {{ $paginateOrders->links()}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection


