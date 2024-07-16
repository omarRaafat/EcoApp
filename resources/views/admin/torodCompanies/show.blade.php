@extends('admin.layouts.master')
@section('title')
    @lang("admin.torodCompanies.show")
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="card-header  border-0">
            <div class="d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">
                    @lang("admin.torodCompanies.show"): {{ $torodCompany->name }}
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
                            <b>@lang("admin.torodCompanies.id")</b> {{ $torodCompany->id }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.torodCompanies.name_ar")</b> {{ $torodCompany->getTranslation('name', 'ar') }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.torodCompanies.name_en")</b> {{ $torodCompany->getTranslation('name', 'en') }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.torodCompanies.desc_ar")</b> {{ $torodCompany->getTranslation('desc', 'ar') }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.torodCompanies.desc_en")</b> {{ $torodCompany->getTranslation('desc', 'en') }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.torodCompanies.active_status")</b>
                            <span class="{{ \App\Enums\ShippingComapnyAtiveStatus::getStatusWithClass($torodCompany->active_status)["class"] }}">
                                {{ \App\Enums\ShippingComapnyAtiveStatus::getStatusWithClass($torodCompany->active_status)["name"] }}
                            </span>
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.torodCompanies.delivery_fees")</b> {{ $torodCompany->delivery_fees_with_sar  . ' ' . __('translation.sar') }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.torodCompanies.domestic_zone")</b> {{ $torodCompany->domesticZone->name }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.torodCompanies.torod_courier_id")</b> {{ $torodCompany->torod_courier_id }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.torodCompanies.logo")</b><br><br>
                            <a href="{{$torodCompany->logo_url}}" target="blank">
                                <img src="{{$torodCompany->logo_url}}" alt="{{$torodCompany->name}}" width="450px" height="450px">
                            </a>
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
