@extends('admin.layouts.master')
@section('title')
    @lang('page-seo.show')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="productClasses">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">@lang('page-seo.show')</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="page" class="form-label">@lang('page-seo.page-name')</label>
                            <h5> {{ $model->page }} </h5>
                        </div>
                    </div>
                    @foreach (config("app.locales") as $locale)
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="tags[{{ $locale }}]">@lang('page-seo.page-tags') @lang("page-seo.$locale")</label>
                                    <h5> {{ $model->getTranslation("tags", $locale) }} </h5>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="description[{{ $locale }}]">@lang('page-seo.page-description') @lang("page-seo.$locale")</label>
                                    <h5> {{ $model->getTranslation("description", $locale) }} </h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
