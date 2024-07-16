@extends('admin.layouts.master')
@section('title')
    @lang('postHarvestServices.create')
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
                    <form action="{{ route('admin.post-harvest-services-departments.store') }}" method="post"
                        class="needs-validation row" autocomplete="on" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">@lang('admin.categories.name')
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="image" class="form-label">@lang('admin.categories.image')</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image"
                                id="image">
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="status">@lang('admin.categories.is_active')</label>
                            <div class="form-check form-switch form-switch-lg" dir="ltr">
                                <input type="checkbox" name="status" class="form-check-input" id="is_active" value="active"
                                    @if (old('status') == 'active') checked @endif>
                            </div>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="d-flex align-items-start gap-3 mt-4">
                            <button type="submit" class="btn btn-success btn-label right ms-auto nexttab nexttab">
                                <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
                                @lang('admin.create')
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
