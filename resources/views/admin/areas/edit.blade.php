@extends('admin.layouts.master')
@section('title')
    @lang('admin.areas.update')
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
                            @lang('admin.edit')
                        </h5>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.areas.update', $area->id) }}" method="post" class="form-steps" autocomplete="on">
                                @csrf
                                @method('PUT')
                                <div class="text-center pt-3 pb-4 mb-1">
                                    <img src="assets/images/logo-dark.png" alt="" height="17">
                                </div>
                                <div class="tab-content">
                                    <!-- Start Of Arabic Info tab pane -->
                                    <div class="tab-pane fade active show" id="areas-arabic-info" role="tabpanel"
                                        aria-labelledby="areas-arabic-info-tab">
                                        <div>
                                            <div class="row">
                                                @foreach(config('app.locales') AS $locale)
                                                <div class="col-md-6 mb-3">
                                                    <label for="username" class="form-label">@lang('admin.areas.name') -@lang('language.'.$locale)
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control @error('name.'.$locale) is-invalid @enderror" name="name[{{ $locale }}]"
                                                    value="{{ old('name.'.$locale) ?? $area->getTranslation('name',$locale)}}"

                                                    id="category_name">
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
                                                <div class="col-md-6 mb-3">
                                                    <label for="username" class="form-label">@lang('admin.areas.name') -@lang('language.en')
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control @error('name.en') is-invalid @enderror" name="name[en]"
                                                    value="{{ old('name.en') ?? $area->getTranslation('name','en')}}"
                                                    id="area_name_en">
                                                    @error('name.en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>
                                                            {{$message}}
                                                        </strong>
                                                    </span>
                                                    @enderror

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="country_id">@lang('admin.areas.country_id')</label>
                                                        <select class="select2 form-control" name="country_id" id="select2_country_id">
                                                            <option selected value="">
                                                                @lang("admin.areas.choose_country")
                                                            </option>
                                                            @foreach ($countries as $country)
                                                                @if ($area->country->id == $country->id)
                                                                    <option selected value="{{ $country->id }}">
                                                                        {{ $country->getTranslation('name', 'ar') }} - {{ $country->getTranslation('name', 'en') }}
                                                                    </option>
                                                                @endif
                                                                <option value="{{ $country->id }}">
                                                                    {{ $country->getTranslation('name', 'ar') }} - {{ $country->getTranslation('name', 'en') }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('country_id')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="is_active">@lang('admin.areas.is_active')</label>
                                                        <select class="select2 form-control" name="is_active" id="select2_is_active">
                                                            <option value="">
                                                                @lang("admin.areas.choose_state")
                                                            </option>
                                                            @foreach ($stateOfCountry as $state)
                                                                @if($country->is_active == $state["value"])
                                                                    <option selected value="{{ $state["value"] }}">
                                                                        {{ $state["name"] }}
                                                                    </option>
                                                                @else
                                                                    <option value="{{ $state["value"] }}">
                                                                        {{ $state["name"] }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        @error('is_active')
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
            // Select2 Multiple
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
