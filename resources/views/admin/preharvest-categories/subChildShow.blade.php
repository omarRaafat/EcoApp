@extends('admin.layouts.master')
@section('title')
    @lang("admin.categories.show")
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="card">
        <div class="card-header  border-0">
            <div class="d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">
                    @lang("admin.categories.show"):
                </h5>
            </div>
        </div>
        <div class="card-body pt-0">
            <form action="javascript:void(0);" class="row g-3">
                @if($category->media->count() > 0)
                <div class="col-md-6">
                    <label for="inputAddress2" class="form-label">@lang("admin.categories.image_for_show")</label>
                    <span class="d-flex align-items-center">
                        <img src="{{ $category->getFirstMediaUrl('categories', 'thumb') }}" alt="{{ $category->name }}">
                    </span>
                </div>
                @endif
                <div class="col-md-6">
                    <label for="username" class="form-label">@lang("admin.categories.name_ar")</label>
                    <input disabled="disabled" readonly type="text" class="form-control" value="{{ $category->getTranslation('name', 'ar') }}">
                </div>
                <div class="col-md-6">
                    <label for="username" class="form-label">@lang("admin.categories.slug_ar")</label>
                    <input disabled="disabled" readonly type="text" class="form-control" value="{{ $category->getTranslation('slug', 'ar') }}">
                </div>
                <div class="col-md-6">
                    <label for="username" class="form-label">@lang("admin.categories.slug_en")</label>
                    <input disabled="disabled" readonly type="text" class="form-control" value="{{ $category->getTranslation('slug', 'en') }}">
                </div>
                <div class="col-md-6">
                    <label for="username" class="form-label">@lang("admin.categories.order")</label>
                    <input disabled="disabled" readonly type="text" class="form-control" value="{{ $category->order }}">
                </div>
                @if($category->level != 1)
                    <div class="col-md-6">
                        <label for="username" class="form-label">@lang("admin.categories.parent_name_ar")</label>
                        <input disabled="disabled" readonly type="text" class="form-control" value="{{ $category->parent_category_name_ar != 0 ? $category->parent_category_name_ar : trans('admin.categories.not_found') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="username" class="form-label">@lang("admin.categories.level")</label>
                        <input disabled="disabled" readonly type="text" class="form-control" value="{{ \App\Enums\CategoryLevels::getLevels($category->level) }}">
                    </div>
                @endif
                <div class="col-md-6">
                    <label for="username" class="form-label">@lang("admin.categories.is_active")</label>
                    <span class="{{ \App\Enums\CategoryIsActiveStatus::getStatusWithClass($category->is_active)["class"] }}">
                        {{ \App\Enums\CategoryIsActiveStatus::getStatusWithClass($category->is_active)["name"] }}
                    </span>
                </div>
            </form>
        </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
