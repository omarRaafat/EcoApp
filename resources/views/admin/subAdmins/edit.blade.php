@extends('admin.layouts.master')
@section('title')
    @lang('admin.subAdmins.update')
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
                            <form action="{{ route('admin.subAdmins.update', $subAdmin->id) }}" method="post" class="form-steps" autocomplete="on">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="subAdmin_id" value="{{ $subAdmin->id }}">
                                <div class="text-center pt-3 pb-4 mb-1">
                                    <img src="assets/images/logo-dark.png" alt="" height="17">
                                </div>
                                <div class="tab-content">
                                    <!-- Start Of Arabic Info tab pane -->
                                    <div class="tab-pane fade active show" id="areas-arabic-info" role="tabpanel"
                                        aria-labelledby="areas-arabic-info-tab">
                                        <div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="name">@lang('admin.subAdmins.name')</label>
                                                        <input type="text" name="name" class="form-control"
                                                            id="name"
                                                            value="{{ $subAdmin->name }}"
                                                            placeholder="{{ trans('admin.subAdmins.name') }}">
                                                        @error('name')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="email">@lang('admin.subAdmins.email')</label>
                                                        <input type="text" name="email" class="form-control"
                                                            id="email"
                                                            value="{{ $subAdmin->email }}"
                                                            placeholder="{{ trans('admin.subAdmins.email') }}">
                                                        @error('email')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="phone">@lang('admin.subAdmins.phone')</label>
                                                        <input type="text" name="phone" class="form-control"
                                                            id="phone"
                                                            value="{{ $subAdmin->phone }}"
                                                            placeholder="{{ trans('admin.subAdmins.phone') }}">
                                                        @error('phone')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="password">@lang('admin.subAdmins.password')</label>
                                                        <input type="password" name="password" class="form-control"
                                                            id="password"
                                                            placeholder="{{ trans('admin.subAdmins.password') }}">
                                                        @error('password')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    @if(!empty($rules))
                                                        @lang("admin.rules.title")
                                                        <ul class="list-group list-group-flush border-dashed px-3">
                                                            @foreach ($rules as $rule)
                                                                <li class="list-group-item ps-0">
                                                                    <div class="d-flex align-items-start">
                                                                        <div class="form-check ps-0 flex-sharink-0">
                                                                            <input type="checkbox" {{ in_array($rule->id, $subAdmin->rules->pluck("id")->toArray()) ? 'checked' : ''  }} name="rules[]" value="{{ $rule->id }}" class="form-check-input ms-0" id="rule_{{ $rule->id }}">
                                                                        </div>
                                                                        <div class="flex-grow-1">
                                                                            <label class="form-check-label mb-0 ps-2" for="rule_{{ $rule->id }}">
                                                                                {{ $rule->name }}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <h5>@lang("admin.subAdmins.no_rules_found")</h5>
                                                    @endif
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
