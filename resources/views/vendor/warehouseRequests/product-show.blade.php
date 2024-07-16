@extends('vendor.layouts.master')
@section('title')
@lang('translation.customers')
@endsection
@section('css')
<link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="card-header  border-0">
            <div class="d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">
                    @lang("admin.wareHouseRequests.show"): {{ $vendorRequest->name }}
                </h5>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-xxl-5">
            <div class="card">
                <div class="row g-0">
                    <div class="col-lg-12">
                        <div class="card-body border-end">
                            <b>@lang("admin.wareHouseRequests.id")</b> {{ $vendorRequest->id }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.wareHouseRequests.vendor")</b> {{ $vendorRequest->request->vendor->name }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.wareHouseRequests.name_ar")</b> {{ $vendorRequest->product->getTranslation('name', 'ar') }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.wareHouseRequests.name_en")</b> {{ $vendorRequest->product->getTranslation('name', 'en') }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.wareHouseRequests.qnt")</b> {{ $vendorRequest->qnt }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.wareHouseRequests.mnfg_date")</b> {{ $vendorRequest->mnfg_date }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.wareHouseRequests.expire_date")</b> {{ $vendorRequest->expire_date }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/list.js/list.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.js.min.js') }}"></script>

    <!--ecommerce-customer init js -->
    <script src="{{ URL::asset('assets/js/pages/ecommerce-order.init.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
@endsection
