@extends('admin.layouts.master')
@section('title')
    @lang('admin.rules.update')
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
                            <form action="{{ route('admin.rules.update', $rule->id) }}" method="post" class="form-steps" autocomplete="on">
                                @csrf
                                @method('PUT')
                                <div class="text-center pt-3 pb-4 mb-1">
                                    <img src="assets/images/logo-dark.png" alt="" height="17">
                                </div>
                                <div class="tab-content">
                                    <!-- Start Of Arabic Info tab pane -->
                                    <div class="tab-pane fade active show" id="rules-arabic-info" role="tabpanel"
                                        aria-labelledby="rules-arabic-info-tab">
                                        <div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="name_ar">@lang('admin.rules.name_ar')</label>
                                                        <input type="text" name="name_ar" class="form-control"
                                                            id="name_ar"
                                                            value="{{ $rule->getTranslation('name', 'ar') }}"
                                                            placeholder="{{ trans('admin.rules.name_ar') }}">
                                                        @error('name_ar')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="name_en">@lang('admin.rules.name_en')</label>
                                                        <input type="text" name="name_en" class="form-control"
                                                            id="name_en"
                                                            value="{{ $rule->getTranslation('name', 'en') }}"
                                                            placeholder="{{ trans('admin.rules.name_en') }}">
                                                        @error('name_en')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @if(!empty($permissions))
                                            @foreach ($permissions as $permissionName => $permissionGroup)
                                                @if($permissionName == 'طلبات التخزين') @continue @endif
                                                <div class="card col-lg-2">
                                                    <div class="card-header  border-0">
                                                        {{ $permissionName }}
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($permissionGroup as $permission)
                                                            <div class="d-flex align-items-start">
                                                                <div class="form-check ps-0 flex-sharink-0">
                                                                    <input type="checkbox" name="permissions[]" {{ in_array($permission->id, $rule->permissions->pluck("id")->toArray()) ? 'checked' : ''  }} value="{{ $permission->id }}" class="form-check-input ms-0" id="permission_{{ $permission->id }}">
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <label class="form-check-label mb-0 ps-2" for="rule_{{ $permission->id }}">
                                                                        {{ $permission->name }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <h5>@lang("admin.rules.permissions.no_permissions_found")</h5>
                                        @endif
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
