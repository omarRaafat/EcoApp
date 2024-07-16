@extends('admin.layouts.master')
@section('title')
    @lang('admin.permission_vendor_roles_edit')
@endsection
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form class="needs-validation row" novalidate method="POST"
                        action="{{ route('admin.roles.update', ['role' => $role->id]) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="vendor_id" value="{{ $role->vendor_id }}">
                        @foreach(config('app.locales') AS $locale)
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">@lang('admin.permission_vendor_role_name') - {{ $locale }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input value="{{ $role->getTranslation('name',$locale) }}" type="text" class="form-control @error('name.' . $locale) is-invalid @enderror" name="name[{{ $locale }}]" value="" id="name" required>
                                @error('name.' . $locale)
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        @endforeach
                        <div class="col-md-6 mb-3">
                            <label for="permissions" class="form-label @error('permissions') is-invalid @enderror">@lang('admin.permission_vendor_role_permissions') <span class="text-danger">*</span></label>
                            <select id="permissions" name="permissions[]" class="form-select" id="choices-multiple-remove-button" data-choices data-choices-removeItem multiple>
                                @foreach ($permissions as $permission_value => $permission_title)
                                    <option @if(in_array($permission_value,$role->permissions)) selected @endif value="{{ $permission_value }}">{{ $permission_title }}</option>
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
