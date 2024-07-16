@extends('admin.layouts.master')
@section('title')
    @lang('admin.vendor_users_create')
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"
          type="text/css"/>
@endsection
@section('content')
    <div class="row">
        <form class="needs-validation row" novalidate method="POST" action="{{ route("admin.vendor-users.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                <img src="{{ URL::asset('images/nologo.png') }}" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image" id="profile-image">
                                <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                    <input id="profile-img-file-input" type="file" name="image" class="profile-img-file-input">
                                    <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                        <span class="avatar-title rounded-circle bg-light text-body">
                                            <i class="ri-camera-fill"></i>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">@lang('admin.vendor_user_name')</label>
                            <input value="{{ old('name') }}" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="" id="name">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">@lang('admin.customer_phone')</label>
                            <input value="{{ old('phone') }}" type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="" id="phone">
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">@lang('admin.vendor_user_email')</label>
                            <input value="{{ old('email') }}" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="" id="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="vendor_id" class="form-label @error('role_id') is-invalid @enderror @error('vendor_id') is-invalid @enderror">@lang('admin.vendor_name')</label>
                            <select onchange="getVendorRoles(this);" class="form-control" name="vendor_id" id="vendor_id" data-choices data-choices-sorting-false>
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
                            @error('role_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3" style="display: none;" id="roleSelect">
                            <label for="role" class="form-label @error('role_id') is-invalid @enderror">@lang('admin.vendor_user_role')</label>
                            <select class="form-select" name="role_id" id="role">

                            </select>
                        </div>
                        @error('role_id')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <div class="col-md-6 mb-3">
                            <label for="password">@lang('admin.vendor_user_password')</label>
                            <input value="{{ old('password') }}" type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password-confirm">@lang('admin.vendor_user_password_confirm')</label>
                            <input value="{{ old('password_confirmation') }}" id="password-confirm" type="password" name="password_confirmation" class="form-control" placeholder="@lang('admin.vendor_user_password_confirm')">
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">@lang('admin.save')</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
@endsection
@section('script-bottom')
    <script>
        function getVendorRoles(item)
        {
            $('#roleSelect').fadeOut('slow');
            $('#role').empty();
            let vendorId = $(item).val();
            $.post("{{ URL::asset('/admin') }}/vendor-users/roles/" + vendorId, {
                id: vendorId,
                "_token": "{{ csrf_token() }}"
            }, function (data) {
                if (data.status == 'success')
                {
                    $.each(data.data, function(key,option){
                        $('<option/>', {
                            'value': option.id,
                            'text': option.text
                        }).appendTo('#role');
                        $('#roleSelect').fadeIn('slow');
                    });
                }
            }, "json");
        }
    </script>
@endsection
