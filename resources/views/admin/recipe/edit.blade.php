@extends('admin.layouts.master')
@section('title')
    @lang('admin.recipes.update')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet"/>
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
                            <form action="{{ route('admin.recipe.update', $recipe->id) }}" method="post" class="form-steps" autocomplete="on" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="tab-content">
                                    <div class="row">
                                        @foreach(config('app.locales') AS $locale)
                                        <div class="col-md-3 mb-3">
                                            <label for="title" class="form-label">@lang('admin.recipes.title') -@lang('language.'.$locale)
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control @error('title.'.$locale) is-invalid @enderror" name="title[{{ $locale }}]"
                                            value="{{ old('title.'.$locale) ?? $recipe->getTranslation('title',$locale)}}"
                                            placeholder="@lang('admin.recipes.title') -@lang('language.'.$locale)"
                                            id="title">
                                            @error('title.'.$locale)
                                            <span class="error text-danger" role="alert"> {{ $message }} </span>
                                             @enderror

                                        </div>

                                          <div class="col-lg-3 mb-3">
                                            <label class="form-label" for="short_desc[{{$locale}}]">@lang('admin.recipes.short_desc')-@lang('language.'.$locale)</label>
                                            <textarea name="short_desc[{{$locale}}]" class="form-control @error('short_desc.'.$locale) is-invalid @enderror" name="short_desc[{{ $locale }}]"
                                                placeholder="@lang('admin.recipes.short_desc')-@lang('language.'.$locale)"> {{ old('short_desc.'.$locale) ?? $recipe->getTranslation('short_desc',$locale)}}</textarea>
                                                @error('short_desc.'.$locale)
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>


                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label"
                                                    for="body[{{ $locale }}]">@lang('admin.recipes.body')-@lang('language.'.$locale)</label>
                                                <textarea type="text" name="body[{{ $locale }}]" class="ckeditor form-control"
                                                    id="body{{$locale}}" rows="5"
                                                    placeholder="@lang('qnas.recipes.body')">{!! old('body.'.$locale) ?? $recipe->getTranslation('body',$locale) !!}</textarea>
                                                @error('body.'.$locale)
                                                <span class="error text-danger" role="alert"> {{ $message }} </span>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="body[{{ $locale }}]">@lang('admin.recipes.body')-@lang('language.'.$locale)</label>
                                                <textarea type="text" name="body[{{ $locale }}]" class="ckeditor form-control
                                                    id="body{{$locale}}" rows="5"
                                                    placeholder="@lang('qnas.admin.body')">{{ old('body.'.$locale) }}</textarea>
                                                    @error('body.'.$locale)
                                                    <span class="error text-danger" role="alert"> {{ $message }} </span>
                                                     @enderror
                                            </div>
                                        </div> --}}
                                        @endforeach

                                    </div>

                                  <ul> <hr>

                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="image">@lang('admin.recipes.image')</label>
                                                <div class="image--root image image-input-multiple image--hopper"
                                                    data-style-button-remove-item-position="left"
                                                    data-style-button-process-item-position="right"
                                                    data-style-load-indicator-position="right"
                                                    data-style-progress-indicator-position="right"
                                                    data-style-button-remove-item-align="false" style="height: 76px;">
                                                    <input class="image--browser" type="file"
                                                        id="image"
                                                        aria-controls="image"
                                                        aria-labelledby="image" multiple=""
                                                        name="image">
                                                    <div class="imag3"
                                                        style="transform: translate3d(0px, 0px, 0px); opacity: 1;">
                                                        <label for="image" id="image"
                                                            aria-hidden="true">
                                                            @lang('admin.recipes.image')
                                                        </label>
                                                    </div>
                                                    <div class="image--list-scroller"
                                                        style="transform: translate3d(0px, 60px, 0px);">
                                                        <ul class="image--list" role="list"></ul>
                                                    </div>
                                                    <div class="image--panel image--panel-root" data-scalable="true">
                                                        <div class="image--panel-top image--panel-root"></div>
                                                        <div class="image--panel-center image--panel-root"
                                                            style="transform: translate3d(0px, 8px, 0px) scale3d(1, 0.6, 1);">
                                                        </div>
                                                        <div class="image--panel-bottom image--panel-root"
                                                            style="transform: translate3d(0px, 68px, 0px);"></div>
                                                    </div><span class="image--assistant" id="image--assistant-gywirtjd3"
                                                        role="status" aria-live="polite" aria-relevant="additions"></span>
                                                    <div class="image--drip"></div>
                                                    <fieldset class="image--data"></fieldset>
                                                    @error("image")
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3" style="padding-top: 30px">
                                            <div class="mb-3">
                                                <div class="form-check form-switch form-switch-lg" dir="rtl">
                                                    <input type="checkbox" {{ $recipe->most_visited == true ? "checked" : false }} name="most_visited" class="form-check-input" id="most_visited">
                                                    <label class="form-check-label" true-value="true" for="most_visited">@lang('admin.recipes.most_visited')</label>
                                                </div>
                                                @error('most_visited')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>
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
    <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>

    <script>
        $(document).ready(function ()
        {
            // Select2 Multiple
            $('.select2_parent_id').select2({
                placeholder: "Select",
                allowClear: true
            });
            $('.ckeditor').ckeditor();
        });
    </script>
@endsection
