@extends('admin.layouts.master')
@section('title')
    @lang('page-seo.edit')
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
                        <h5 class="card-title mb-0 flex-grow-1">@lang('page-seo.edit')</h5>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.page-seo.update', ['page_seo' => $model]) }}" method="POST">
                        @csrf
                        @method("PUT")
                        <div class="alert alert-warning"> @lang('page-seo.hint') </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="page" class="form-label">@lang('page-seo.page-name')</label>
                                <select name="page" class="form-select" dir="rtl" data-choices data-choices-removeItem>
                                    <option value=''> @lang('translation.select-option') </option>
                                    @foreach($pages as $page)
                                    <option value='{{ $page }}' @selected($model->page == $page)>
                                        {{ $page }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('page')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        @foreach (config("app.locales") as $locale)
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="tags[{{ $locale }}]">@lang('page-seo.page-tags') @lang("page-seo.$locale")</label>
                                        <textarea name="tags[{{ $locale }}]" class="form-control"
                                            placeholder="">{{ $model->getTranslation("tags", $locale) }}</textarea>
                                        @error("tags.$locale")
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="description[{{ $locale }}]">@lang('page-seo.page-description') @lang("page-seo.$locale")</label>
                                        <textarea name="description[{{ $locale }}]" class="form-control"
                                            placeholder="">{{ $model->getTranslation("description", $locale) }}</textarea>
                                        @error("description.$locale")
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="d-flex align-items-start gap-3 mt-4">
                            <button type="submit"
                                class="btn btn-success btn-label right ms-auto nexttab nexttab">
                                <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
                                @lang('page-seo.edit')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
