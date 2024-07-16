@extends('admin.layouts.master')
@section('title')
    @lang("admin.categories.show")
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
                    @lang("admin.categories.show"):
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
                            <b>@lang("admin.categories.image_for_show")</b>
                            @if (!empty($category->media))
                            <a href="{{ $category->image_url }}" target="_blanck">
                                <a href="{{ $category->getFirstMediaUrl('categories', 'cover') }}" target="_blanck">
                                    <img src="{{ $category->getFirstMediaUrl('categories', 'thumb') }}" alt="{{ $category->name }}">
                                </a>
                            @else
                                <img src="{{ url("images/noimage.png") }}" alt="{{ $category->name }}" width="160" height="100">
                            @endif
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.categories.name_ar")</b> {{ $category->getTranslation('name', 'ar') }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.categories.name_en")</b> {{ $category->getTranslation('name', 'en') }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.categories.slug_ar")</b> {{ $category->getTranslation('slug', 'ar') }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.categories.slug_en")</b> {{ $category->getTranslation('slug', 'en') }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.categories.parent_name_ar")</b> {{ $category->parent_category_name_ar != 0 ? $category->parent_category_name_ar : trans('admin.categories.not_found') }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.categories.parent_name_en")</b> {{ $category->parent_category_name_ar != 0 ? $category->parent_category_name_ar : trans('admin.categories.not_found') }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.categories.order")</b> {{ $category->order }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.categories.level")</b> {{ \App\Enums\CategoryLevels::getLevels($category->level) }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.categories.order")</b> {{ $category->order }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.categories.is_active")</b>
                            <span class="{{ \App\Enums\CategoryIsActiveStatus::getStatusWithClass($category->is_active)["class"] }}">
                                {{ \App\Enums\CategoryIsActiveStatus::getStatusWithClass($category->is_active)["name"] }}
                            </span>
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
    <script>
        $(document).ready(function() {
            // Select2 Multiple
            $('.select2_customer').select2({
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
