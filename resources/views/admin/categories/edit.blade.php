@extends('admin.layouts.master')
@section('title')
    @lang('admin.categories.update')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />

@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="post" class="needs-validation row"  autocomplete="on" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            @foreach(config('app.locales') AS $locale)
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">@lang('admin.categories.name') -@lang('language.'.$locale)
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('name.'.$locale) is-invalid @enderror" name="name[{{ $locale }}]"
                                value="{{ old('name.'.$locale) ?? $category->getTranslation('name',$locale)}}"

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
                        @if($level == 1)
                        <div class="col-md-6 mb-3">
                            <div class="row">
                                <div class="@if($category->media->count() > 0) col-md-9 @else col-md-12 @endif">
                                    <label for="image" class="form-label">@lang('admin.categories.image') <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image">
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                @if($category->media->count() > 0)
                                <div class="col-md-3">
                                    <div class="d-flex align-items-center mt-4">
                                        <span class="d-flex align-items-center">
                                            <img src="{{ $category->getFirstMediaUrl('categories', 'thumb') }}" alt="{{ $category->name }}">
                                        </span>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                        <div class="col-md-2 mb-3">
                            <label class="form-label" for="is_active">@lang('admin.categories.is_active')</label>
                            <div class="form-check form-switch form-switch-lg" dir="ltr">
                                @if($category->is_active == true)
                                    <input type="checkbox" name="is_active" class="form-check-input" id="is_active" checked>
                                @else
                                    <input type="checkbox" name="is_active" class="form-check-input" id="is_active">
                                @endif
                            </div>
                            @error('is_active')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="d-flex align-items-start gap-3 mt-4">
                            <button type="submit" class="btn btn-success btn-label right ms-auto nexttab nexttab">
                                <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
                                @lang('admin.save')
                            </button>
                        </div>
                    </form>
                </div>
                <!-- end card body -->
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
