@extends('admin.layouts.master')
@section('title')
    @lang('admin.sliders.edit')
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
                            @lang('admin.sliders.edit')
                        </h5>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.slider.update', ['slider' => $model]) }}" method="post" class="form-steps" autocomplete="on" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-lg-6 offset-3">
                                        <div class="mb-3">
                                            <img width="100%" src="{{ ossStorageUrl($model->image) }}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="url">@lang('admin.sliders.image')</label>
                                            <input type="file" name="image" class="form-control" placeholder="{{ trans('admin.sliders.image') }}">
                                            @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                @foreach ($locales as $locale => $localeName)
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="name">
                                                    {{ trans('admin.sliders.name') .$localeName }}
                                                </label>
                                                <input
                                                    type="text"
                                                    name="name[{{$locale}}]"
                                                    class="form-control"
                                                    value="{{ $model->getTranslation("name", $locale) ?? '' }}"
                                                    placeholder="{{ trans('admin.sliders.name') .$localeName }}">
                                                @error("name.$locale")
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="category">
                                                    {{ trans('admin.sliders.category') .$localeName }}
                                                </label>
                                                <input
                                                    type="text"
                                                    name="category[{{$locale}}]"
                                                    class="form-control"
                                                    value="{{ $model->getTranslation("category", $locale) ?? '' }}"
                                                    placeholder="{{ trans('admin.sliders.category') .$localeName }}">
                                                @error("category.$locale")
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="offer">
                                                    {{ trans('admin.sliders.offer') .$localeName }}
                                                </label>
                                                <input
                                                    type="text"
                                                    name="offer[{{$locale}}]"
                                                    class="form-control"
                                                    value="{{ $model->getTranslation("offer", $locale) ?? '' }}"
                                                    placeholder="{{ trans('admin.sliders.offer') .$localeName }}">
                                                @error("offer.$locale")
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                @endforeach
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="url">@lang('admin.sliders.url')</label>
                                            <input type="text" name="url" class="form-control" id="url"
                                            placeholder="{{ trans('admin.sliders.url') }}" value="{{ $model->url }}">
                                            @error('url')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="identifier">@lang('admin.sliders.identifier')</label>
                                            <input type="text" name="identifier" class="form-control" id="identifier"
                                            placeholder="{{ trans('admin.sliders.identifier') }}" value="{{ $model->identifier }}">
                                            @error('identifier')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start gap-3">
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
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

@endsection
