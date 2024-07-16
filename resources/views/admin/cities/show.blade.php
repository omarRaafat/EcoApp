@extends('admin.layouts.master')
@section('title')
    @lang("admin.cities.show")
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
                    @lang("admin.cities.show"): {{ $city->name }}
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
                            <b>@lang("admin.cities.id")</b> {{ $city->id }}
                        </div>
                        <div class="row">
                            @foreach(config('app.locales') AS $locale)
                            <div class="card-body border-end">
                                <b>@lang("admin.productQuantities.name")-@lang('language.'.$locale)</b> {{ $city->getTranslation('name', $locale)}}
                            </div>
                            @endforeach
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.cities.area_id")</b>
                            <a target="_blank" href="{{ route("admin.areas.show", $city->area->id) }}">
                                 {{ $city->area->getTranslation("name", "ar") }}
                            </a>
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.cities.is_active")</b>
                            <span class="{{ \App\Enums\CityStatus::getStatusWithClass($city->is_active)["class"] }}">
                                {{ \App\Enums\CityStatus::getStatusWithClass($city->is_active)["name"] }}
                            </span>
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.cities.torod_city_id")</b> {{ !empty($city->torod_city_id) ? $city->torod_city_id : trans("admin.cities.not_found") }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.countries.spl_id")</b> {{ $city->spl_id ? $city->spl_id : trans("admin.not_found") }}
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
