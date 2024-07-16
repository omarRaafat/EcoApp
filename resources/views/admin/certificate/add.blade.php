@extends('admin.layouts.master')
@section('title')
    @lang('admin.certificate_edit')
@endsection
@section('content')
    <form class="needs-validation row" novalidate method="POST" action="{{ route("admin.certificates.store") }}" enctype="multipart/form-data">
        @csrf
        @foreach(config('app.locales') AS $locale)
            <div class="col-md-6 mb-3">
                <label for="username" class="form-label">@lang('admin.certificate_title') -@lang('language.'.$locale)
                    <span class="text-danger">*</span>
                </label>
                <input type="text" class="form-control @error('title.' . $locale) is-invalid @enderror" name="title[{{ $locale }}]"
                value="{{ old('title.'.$locale)}}"
                 id="certificate_title" required>
                @error('title.' . $locale)
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        @endforeach
        <div class="col-md-6 mb-3">
            <div class="row">
                <div class="col-md-9">
                    <label for="certificate_image" class="form-label">@lang('admin.certificate_image') <span class="text-danger">*</span></label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image" required>
                    @error('cr')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <div class="invalid-feedback">
                        @lang('admin.certificate_please_enter_image')
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-3">
            <div class="text-end">
                <button type="submit" class="btn btn-primary">@lang('admin.save')</button>
            </div>
        </div>
    </form>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
