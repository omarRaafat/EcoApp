@extends('admin.layouts.master')
@section('title')
    @lang('admin.countries.create')
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
                            @lang('admin.countries.create')
                        </h5>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.countries.store') }}" method="post" class="form-steps" autocomplete="on">
                                @csrf
                                @method('post')
                                <div class="text-center pt-3 pb-4 mb-1">
                                    <img src="assets/images/logo-dark.png" alt="" height="17">
                                </div>
                                <div class="tab-content">
                                    <!-- Start Of Arabic Info tab pane -->
                                    <div class="tab-pane fade active show" id="countries-arabic-info" role="tabpanel" aria-labelledby="countries-arabic-info-tab">
                                        <div>
                                            <div class="row">
                                                @foreach(config('app.locales') AS $locale)
                                                <div class="col-md-6 mb-3">
                                                    <label for="username" class="form-label">@lang('admin.productQuantities.name') -@lang('language.'.$locale)
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control @error('name.'.$locale) is-invalid @enderror" name="name[{{ $locale }}]"
                                                    value="{{ old('name.'.$locale)}}"

                                                    id="country_name">
                                                    @error('name.' . $locale)
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>
                                                            {{$message}}
                                                        </strong>
                                                    </span>
                                                    @enderror

                                                </div>
                                                @endforeach
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="vat_percentage">@lang('admin.countries.vat_percentage')</label>
                                                        <input type="text" name="vat_percentage" class="form-control"
                                                            value="{{ old("vat_percentage") }}"
                                                            id="vat_percentage"
                                                            placeholder="{{ trans('admin.countries.vat_percentage') }}">
                                                        @error('vat_percentage')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="code">@lang('admin.countries.code')</label>
                                                        <input type="text" name="code" class="form-control"
                                                            value="{{ old("code") }}"
                                                            id="code"
                                                            placeholder="{{ trans('admin.countries.code') }}">
                                                        @error('code')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="is_active">@lang('admin.countries.is_active')</label>
                                                        <select class="select2 form-control" name="is_active" id="select2_is_active">
                                                            <option selected value="">
                                                                @lang("admin.countries.choose_state")
                                                            </option>
                                                            @foreach ($stateOfCountry as $state)
                                                                <option value="{{ $state["value"] }}">
                                                                    {{ $state["name"] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('is_active')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>


                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="is_national">@lang('admin.countries.national')</label>
                                                        <select class="select2 form-control" name="is_national" id="select2_is_active">
                                                            <option value="">
                                                                @lang("admin.countries.is_national")
                                                            </option>

                                                                    <option  value="1">
                                                                        @lang('admin.countries.national')
                                                                    </option>
                                                                    <option  value="0">
                                                                             @lang('admin.countries.not_national')
                                                                    </option>

                                                        </select>
                                                        @error('is_national')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="spl_id">@lang('admin.countries.spl_id')</label>
                                                        <input type="text" name="spl_id" class="form-control"
                                                            value="{{ old("spl_id") }}"
                                                            id="spl_id"
                                                            placeholder="{{ trans('admin.countries.spl_id') }}">
                                                        @error('spl_id')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="minimum_order_weight">
                                                            @lang('admin.countries.minimum_order_weight')
                                                        </label>
                                                        <input type="text" name="minimum_order_weight" class="form-control"
                                                            value="{{ old("minimum_order_weight") }}"
                                                            placeholder="{{ trans('admin.countries.minimum_order_weight') }}">
                                                        @error('minimum_order_weight')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="maximum_order_weight">
                                                            @lang('admin.countries.maximum_order_weight')
                                                        </label>
                                                        <input type="text" name="maximum_order_weight" class="form-control"
                                                            value="{{ old("maximum_order_weight") }}"
                                                            placeholder="{{ trans('admin.countries.maximum_order_weight') }}">
                                                        @error('maximum_order_weight')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="maximum_order_total">
                                                            @lang('admin.countries.maximum_order_total')
                                                        </label>
                                                        <input type="text" name="maximum_order_total" class="form-control"
                                                            value="{{ old("maximum_order_total") }}"
                                                            placeholder="{{ trans('admin.countries.maximum_order_total') }}">
                                                        @error('maximum_order_total')
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
                                        @lang('admin.create')
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
            $('.select2_is_active').select2({
                placeholder: "Select",
                allowClear: true
            });

        });
    </script>
@endsection
