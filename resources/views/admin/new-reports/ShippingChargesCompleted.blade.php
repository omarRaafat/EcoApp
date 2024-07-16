@extends('admin.layouts.master')
@section('title')
    @lang('admin.reports.ShippingChargesCompleted')
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
                <form action="{{ route("admin.reports.ShippingChargesCompleted") }}">
                    <div class="row g-3">
                        <div class="col-xxl-3 col-sm-6">
                            <div class="search-box">
                                <input value="{{ request('gateway_tracking_id') }}" name="gateway_tracking_id" type="text" class="form-control search" placeholder="@lang('admin.transaction_gateway_tracking_id_filter_placeholder')">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-sm-6">
                            <div class="search-box">
                                <input name="from" type="date" class="form-control search"
                                       placeholder="@lang("admin.reports.from")" value="{{ request('from') }}">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-sm-6">
                            <div class="search-box">
                                <input name="to" type="date" class="form-control search"
                                       placeholder="@lang("admin.reports.to")" value="{{ request('to') }}">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-sm-6">
                            <div>
                                <select class="form-control" data-choices data-choices-search-false name="shipping_method" id="shipping_method">
                                    <option @if(request('shipping_method') == '') SELECTED @endif value="">@lang('admin.shipping_method')</option>
                                    @foreach($shipping_methods as $key => $shipping_method)
                                        <option value="{{ $shipping_method->id }}" @selected(request()->get('shipping_method') ==  $shipping_method->id)>
                                            {{ $shipping_method->name }}
                                        </option>
                                    @endforeach
                                </select>
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
                                <a href="{{route('admin.reports.ShippingChargesCompleted')}}" class="btn btn-info w-100"><i
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
                <div class="col-md-3 float-right">
                    <a href="{{ route('admin.reports.ShippingChargesCompleted' , ['export_excel'=>true, 'from' => request()->get('from') , 'to' => request()->get('to') ]) }}" class="btn btn-primary">تصدير Excel</a>
                </div>
            </div>
            <div class="card-body ">
                <div>
                    <div class="table-responsive table-card mb-1">
                        <table class="table table-nowrap align-middle" id="warehousesTable">
                            <thead class="text-muted table-light">
                            <tr class="text-uppercase">
                                <th># المعرف</th>
                                <th>رقم البوليصة</th>
                                <th>رقم الطلب الفرعي</th>
                                <th>تاريخ الطلب</th>
                                <th>تاريخ التقاط الطلب</th>
                                <th>إسم البائع</th>
                                <th>شركة الشحن</th>
                                <th>وزن الشحنة <small>(كجم)</small> </th>
                                <th>تكلفة الشحنة</th>
                                <th>حالة الشحنة</th>
                            </tr>
                            </thead>
                            <tbody class="list form-check-all">
                            @foreach ($orders as $key=> $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>
                                        @if($item->orderShipping->shipping_method_id == 1)
                                            @if($item->orderShip?->gateway_tracking_id)
                                                <a href="{{ env('ARAMEX_TRACKING_URL') . $item->orderShip?->gateway_tracking_id  }}" target="_blank">
                                                    <span class="badge badge-info">@lang('translation.track_aramex' , ['order_code' => $item->orderShip?->gateway_tracking_id])</span>
                                                </a>
                                            @else
                                                <span class="badge badge-info">لا يوجد</span>
                                            @endif
                                        @elseif($item->orderShipping?->shipping_method_id == 2)
                                            @if($item->orderShip?->gateway_tracking_id)
                                                <a href="{{ env('SPL_TRACKING_URL') . $item->orderShip?->gateway_tracking_id  }}" target="_blank">
                                                    <span class="badge badge-info">@lang('translation.track_spl' , ['order_code' => $item->orderShip?->gateway_tracking_id])</span>
                                                </a>
                                            @else
                                                <span class="badge badge-info">لا يوجد</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td> {{ $item->code }} </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') }}
                                    </td>
                                    <td>
                                        {{ $item->pickup_at ? \Carbon\Carbon::parse($item->pickup_at)->format('d-m-Y H:i') : 'N/A' }}
                                    </td>
                                    <td> {{ $item->vendor->name }} </td>
                                    <td>
                                        @if($item->orderShipping->shipping_method_id == 1)   اراميكس  @else  سبل @endif
                                    </td>
                                    <td>{{ $item->orderShipping->total_weight }}</td>
                                    <td>{{ $item->orderShipping->total_shipping_fees}}</td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ \App\Enums\OrderStatus::getStatus($item->status)}}
                                        </span>
                                    </td>


                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div>
                <!-- End Delete Modal -->
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
                </div>
                @endif
                @if ($orders instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    {{ $orders->links() }}
                @endif
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
