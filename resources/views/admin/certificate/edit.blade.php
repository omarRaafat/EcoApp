@extends('admin.layouts.master')
@section('title')
    @lang('admin.certificate_edit')
@endsection
@section('content')
    <form class="needs-validation row" novalidate method="POST"
        action="{{ route('admin.certificates.update', ['certificate' => $certificate->id]) }}" enctype="multipart/form-data">
        @csrf
        @foreach(config('app.locales') AS $locale)
            <div class="col-md-6 mb-3">
                <label for="username" class="form-label">@lang('admin.certificate_title') -@lang('language.'.$locale)
                    <span class="text-danger">*</span>
                </label>
                <input type="text" class="form-control @error('title.' . $locale) is-invalid @enderror" name="title[{{ $locale }}]" value="{{ $certificate->getTranslation('title',$locale) }}" id="certificate_title" required>
                @error('name.' . $locale)
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }} @lang('language.'.$locale) </strong>
                </span>
                @enderror
                <div class="invalid-feedback">
                    @lang('admin.certificate_please_enter_title')
                </div>
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
                <div class="col-md-3">
                    <img class="img-thumbnail" src="{{ URL::asset($certificate->image) }}" style="width:100px;height: 100px;"/>
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
