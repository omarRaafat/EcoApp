@extends('admin.layouts.master')
@section('title')
    @lang("admin.areas.show")
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
                    @lang("admin.areas.show"): {{ $area->name }}
                </h5>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-xxl-3 col-lg-3 col-md-3 col-sm-12">
            <div class="card">
                <div class="row g-0">
                    <div class="col-lg-12">
                        <div class="card-body border-end">
                            <b>@lang("admin.areas.id")</b> {{ $area->id }}
                        </div>
                        <div class="row">
                            @foreach(config('app.locales') AS $locale)
                            <div class="card-body border-end">
                                <b>@lang("admin.productQuantities.name")-@lang('language.'.$locale)</b> {{ $area->getTranslation('name', $locale)}}
                            </div>
                            @endforeach
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.areas.country_id")</b>
                            <a target="_blank" href="{{ route("admin.areas.show", $area->country->id) }}">
                                 {{ $area->country->getTranslation("name", "ar") }} - {{ $area->country->getTranslation("name", "en") }}
                            </a>
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.cities.is_active")</b>
                            <span class="{{ \App\Enums\CityStatus::getStatusWithClass($area->is_active)["class"] }}">
                                {{ \App\Enums\CityStatus::getStatusWithClass($area->is_active)["name"] }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($cities->isNotEmpty())
            <div class="col-xxl-9 col-lg-9 col-md-9 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title mb-0 flex-grow-1">
                                @lang("admin.areas.area_cities"):
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-nowrap align-middle" id="areasTable">
                                    <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th>@lang('admin.cities.id')</th>
                                        <th>@lang('admin.cities.name_ar')</th>
                                        <th>@lang('admin.cities.name_en')</th>
                                        <th>@lang('translation.actions')</th>
                                    </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach($cities as $city)
                                            <tr>
                                                <td class="id">
                                                    <a href="{{ route("admin.cities.show", $city->id) }}"class="fw-medium link-primary">
                                                        #{{$city->id}}
                                                    </a>
                                                </td>
                                                <td class="name_ar">{{ $city->getTranslation('name', 'ar') }}</td>
                                                <td class="name_en">{{ $city->getTranslation('name', 'en') }}</td>
                                                <td>
                                                    <ul class="list-inline hstack gap-2 mb-0">
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="@lang('admin.cities.show')">
                                                            <a target="_blank" href="{{ route("admin.cities.show", $city->id) }}"
                                                            class="text-primary d-inline-block">
                                                                <i class="ri-eye-fill fs-16"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $cities->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-xxl-9 col-lg-9 col-md-9 col-sm-12">
                    <div class="card">
                        <div class="row g-0">
                            <div class="col-lg-12">
                                <div class="card-body border-end">
                                    <p>@lang("admin.countries.not_found")</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
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
