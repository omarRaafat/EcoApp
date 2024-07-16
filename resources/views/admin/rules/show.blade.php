@extends('admin.layouts.master')
@section('title')
    @lang("admin.rules.show")
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
                    @lang("admin.rules.show"): {{ $rule->name }}
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
                            <b>@lang("admin.rules.id")</b> {{ $rule->id }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.rules.name_ar")</b> {{ $rule->getTranslation('name', 'ar') }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.rules.name_en")</b> {{ $rule->getTranslation('name', 'en') }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        @if(!empty($permissions))
            @foreach ($permissions as $permissionName => $permissionGroup)
                <div class="card col-lg-2">
                    <div class="card-header  border-0">
                        {{ $permissionName }}
                    </div>
                    <div class="card-body">
                        @foreach ($permissionGroup as $permission)
                            <div class="d-flex align-items-start">
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
