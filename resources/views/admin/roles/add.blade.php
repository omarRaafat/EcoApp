@extends('admin.layouts.master')
@section('title')
    @lang('admin.permission_vendor_roles_create')
@endsection
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form class="needs-validation row" novalidate method="POST" action="{{ route("admin.roles.store") }}" enctype="multipart/form-data">
                        @csrf
                        @foreach(config('app.locales') AS $locale)
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">@lang('admin.permission_vendor_role_name') - {{ $locale }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('name.' . $locale) is-invalid @enderror" name="name[{{ $locale }}]" value="" id="name" required>
                                @error('name.' . $locale)
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        @endforeach
                        <div class="col-md-6 mb-3">
                            <label for="vendor_id" class="form-label @error('vendor_id') is-invalid @enderror">@lang('admin.vendor_name')</label>
                            <select class="form-control" name="vendor_id" id="vendor_id" data-choices data-choices-sorting-false>
                                <option value="">@lang('admin.select')</option>
                                @foreach($vendors AS $vendor)
                                    <option value="{{ $vendor->id }}">{{ $vendor->vendorName }}</option>
                                @endforeach
                            </select>
                            @error('vendor_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="permissions" class="form-label @error('permissions') is-invalid @enderror">@lang('admin.permission_vendor_role_permissions') <span class="text-danger">*</span></label>
                            <select class="form-control" name="permissions[]" id="permissions" data-choices data-choices-removeItem multiple>
                                <option value="">@lang('admin.select')</option>
                                @foreach ($permissions as $permission_value => $permission_title)
                                    <option value="{{ $permission_value }}">{{ $permission_title }}</option>
                                @endforeach
                            </select>
                            @error('permissions')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">@lang('admin.save')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
