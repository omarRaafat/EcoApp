@extends('vendor.layouts.master')
@section('title')
@lang('translation.orders')
@endsection
@section('css')
<link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<!--datatable css-->
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<!--datatable responsive css-->
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />


@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1')
@lang('translation.app_name')
@endslot
@slot('title')
@lang('translation.orders')
@endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card" id="orderList">
            <div class="card-header  border-0">
                <div class="d-flex align-items-center">
                    <!-- <h5 class="card-title mb-0 flex-grow-1">@lang('translation.orders_list')</h5> -->
                    <!-- <div class="flex-shrink-0">
                        <div class="d-flex gap-1 flex-wrap">
                            <button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Create
                                Order</button>
                            <button type="button" class="btn btn-soft-success"><i class="ri-file-download-line align-bottom me-1"></i> Import</button>
                            <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                        </div>
                    </div> -->
                </div>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0">
                <form action="{{route('vendor.orders.index')}}" >
                    <div class="row g-3">
                        <div class="col-xxl-2 col-sm-4">
                            <div>
                                <input class="form-control" type="text" name="customer" value="{{ $request->customer  }}" placeholder="@lang('admin.transaction_customer_filter_placeholder')"/>
                            </div>
                        </div>

                        <div class="col-xxl-2 col-sm-6">
                            <div>
                                <input type="text" name="date_from" class="form-control" data-provider="flatpickr" data-date-format="Y-m-d"  id="demo-datepicker" placeholder="@lang('translation.date_from')" @if(isset($request)) value="{{$request->date_from}}" @endif required>
                            </div>
                        </div>
                        <!--end col-->
                        <!--end col-->
                        <div class="col-xxl-2 col-sm-6">
                            <div>
                                <input type="text" name="date_to" class="form-control" data-provider="flatpickr" data-date-format="Y-m-d"  id="demo-datepicker" placeholder="@lang('translation.date_to')" @if(isset($request)) value="{{$request->date_to}}" @endif required>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-2 col-sm-4">
                            <div>
                                <select class="form-control" data-choices data-choices-search-false name="status" id="idStatus">
                                    <option @if(request('status') == '') SELECTED @endif value="">@lang('admin.transaction_status')</option>
                                    @foreach($statuses as $key => $status)
                                        <option value="{{ $key }}" @selected(request()->get('status') == $key)>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xxl-2 col-sm-4">
                            <div>
                                <select class="form-control" data-choices data-choices-search-false name="shipping_type" id="idStatus">
                                    <option @if(request('shipping_type') == '') SELECTED @endif value="">@lang('admin.shipping_type')</option>
                                    @foreach($shipping_types as $key => $shipping_type)
                                        <option value="{{ $shipping_type->id }}" @selected(request()->get('shipping_type') ==  $shipping_type->id)>
                                            {{ $shipping_type->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xxl-2 col-sm-4">
                            <div>
                                <select class="form-control" data-choices data-choices-search-false name="shipping_method" id="idStatus">
                                    <option @if(request('shipping_method') == '') SELECTED @endif value="">@lang('admin.shipping_method')</option>
                                    @foreach($shipping_methods as $key => $shipping_method)
                                        <option value="{{ $shipping_method->id }}" @selected(request()->get('shipping_method') ==  $shipping_method->id)>
                                            {{ $shipping_method->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-xxl-2 col-sm-4">
                            <div>
                                <input class="form-control" type="text" name="code" value="{{ $request->code  }}" placeholder="@lang('admin.code')"/>
                            </div>
                        </div>

                        <div class="col-xxl-2 col-sm-4">
                            <div>
                                <input class="form-control" type="text" name="track_id" value="{{ $request->track_id  }}" placeholder="@lang('admin.track_id')"/>
                            </div>
                        </div>

                        <div class="col-xxl-1 col-sm-4">
                            <div>
                                <button type="submit" class="btn btn-info w-100" onclick="SearchData();"> <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                    @lang('translation.filter')
                                </button>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-1 col-sm-4">
                            <div>
                                <a href="{{route('vendor.orders.index')}}" type="reset" class="btn btn-secondary w-100"> <i class=" ri-loader-3-line me-1 align-bottom"></i>
                                    @lang('translation.reset')
                                </a>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </form>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">@lang('translation.orders')</h5>
                        </div>
                        <div class="card-body">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!--end col-->
</div>
<!--end row-->
<!-- Modal -->
<div class="modal fade flip" id="deleteOrder" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-5 text-center">
                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#25a0e2,secondary:#00bd9d" style="width:90px;height:90px">
                </lord-icon>
                <div class="mt-4 text-center">
                    <h4>@lang('translation.Are_you_sure')</h4>
                    <p class="text-muted fs-15 mb-4">@lang('translation.Are_you_sure_you_want_to_remove_this_product')</p>
                    <div class="hstack gap-2 justify-content-center remove">
                        <button class="btn btn-link link-primary fw-medium text-decoration-none" data-bs-dismiss="modal" id="deleteRecord-close"><i class="ri-close-line me-1 align-middle"></i>
                            @lang('translation.Close_back')</button>
                        <button class="btn btn-primary" id="delete-record">@lang('translation.yes_delete_it')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end modal -->
@endsection
@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

<!-- <script src="{{ URL::asset('assets/libs/list.js/list.js.min.js') }}"></script> -->
<!-- <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.js.min.js') }}"></script> -->

<!--ecommerce-customer init js -->
<!-- <script src="{{ URL::asset('assets/js/pages/ecommerce-order.init.js') }}"></script> -->
<script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
 {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endsection