@extends('admin.layouts.master')
@section('title')
    @lang('admin.torodCompanies.update')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">
                            @lang('admin.torodCompanies.edit')
                        </h5>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.torodCompanies.update', $torodCompany->id) }}" method="post" class="form-steps" autocomplete="on" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="{{$torodCompany->id}}">
                                @csrf
                                @method('PUT')
                                <div class="text-center pt-3 pb-4 mb-1">
                                    <img src="assets/images/logo-dark.png" alt="" height="17">
                                </div>
                                <div class="tab-content">
                                    <!-- Start Of Arabic Info tab pane -->
                                    <div class="tab-pane fade active show" id="areas-arabic-info" role="tabpanel" aria-labelledby="areas-arabic-info-tab">
                                        <div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="name_ar">@lang('admin.torodCompanies.name_ar')</label>
                                                        <input type="text" name="name_ar" class="form-control"
                                                            id="name_ar"
                                                            value="{{ $torodCompany->getTranslation('name', 'ar') }}"
                                                            placeholder="{{ trans('admin.torodCompanies.name_ar') }}">
                                                        @error('name_ar')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="name_en">@lang('admin.torodCompanies.name_en')</label>
                                                        <input type="text" name="name_en" class="form-control"
                                                            id="name_en"
                                                            value="{{ $torodCompany->getTranslation('name', 'en') }}"
                                                            placeholder="{{ trans('admin.torodCompanies.name_en') }}">
                                                        @error('name_en')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="desc_ar">@lang('admin.torodCompanies.desc_ar')</label><br>
                                                        <textarea class="form-control" name="desc_ar" id="desc_ar" rows="6" placeholder="{{ trans('admin.torodCompanies.desc_ar') }}">{{ $torodCompany->getTranslation('desc', 'ar') }}</textarea>
                                                        @error('desc_ar')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="desc_en">@lang('admin.torodCompanies.desc_en')</label><br>
                                                        <textarea class="form-control" name="desc_en" id="desc_en" rows="6" placeholder="{{ trans('admin.torodCompanies.desc_en') }}">{{ $torodCompany->getTranslation('desc', 'en') }}</textarea>
                                                        @error('desc_en')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <div class="form-check form-switch form-switch-lg" dir="ltr">
                                                            <input name="active_status" {{ $torodCompany->active_status ? "checked" : "" }} type="checkbox" class="form-check-input" id="customSwitchsizelg">
                                                            <label class="form-check-label form-label" for="customSwitchsizelg">
                                                                @lang("admin.torodCompanies.active_status")
                                                            </label>
                                                        </div>
                                                        @error('active_status')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="delivery_fees">@lang('admin.torodCompanies.delivery_fees') @lang('translation.sar')</label><br>
                                                        <input type="number" name="delivery_fees" class="form-control" step="0.01"
                                                            value="{{ $torodCompany->delivery_fees }}"
                                                            id="delivery_fees"
                                                            placeholder="{{ trans('admin.torodCompanies.delivery_fees') }}">
                                                        @error('delivery_fees')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="torod_courier_id">@lang('admin.torodCompanies.torod_courier_id')</label><br>
                                                        <input type="number" name="torod_courier_id" class="form-control"
                                                            value="{{ $torodCompany->torod_courier_id }}"
                                                            id="torod_courier_id"
                                                            placeholder="{{ trans('admin.torodCompanies.torod_courier_id') }}">
                                                        @error('torod_courier_id')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <label for="domestic_zone_id" class="form-label">
                                                            @lang("admin.torodCompanies.choose_domistic_zone")
                                                        </label>
                                                        <select class="select2 form-control" name="domestic_zone_id" id="select2_domestic_zone_id">
                                                            <option selected value="">
                                                                @lang("admin.torodCompanies.choose_domistic_zone")
                                                            </option>
                                                            @foreach ($domisticZones as $zone)
                                                                <option {{ $torodCompany->domestic_zone_id == $zone["id"] ? "selected" : ""}} value="{{ $zone["id"] }}">
                                                                    {{ $zone["name"] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('domestic_zone_id')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="logo">@lang('admin.torodCompanies.logo')</label><br>
                                                        <input type="file" name="logo" class="form-control" value="{{ old("logo") }}" id="logo" placeholder="{{ trans('admin.torodCompanies.logo') }}">
                                                        @error('logo')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Of Arabic Info tab pane -->
                                </div>
                                <div class="d-flex align-items-start gap-3 mt-4">
                                    <button type="submit"
                                        class="btn btn-success btn-label right ms-auto nexttab nexttab">
                                        <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
                                        @lang('admin.edit')
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
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
    <script>
        $(document).ready(function() {
            $('.select2_country_id').select2({
                placeholder: "Select",
                allowClear: true
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $('.select2_is_active').select2({
                placeholder: "Select",
                allowClear: true
            });

        });
    </script>
@endsection
