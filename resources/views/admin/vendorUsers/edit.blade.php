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
        <form class="needs-validation row" novalidate method="POST"
            action="{{ route('admin.vendor-users.update', ['user' => $user->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <input type="hidden" name="type" value="{{ $user->type }}">
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                <img src="@if (isset($user) && $user->image != '') {{ URL::asset($user->image) }}@else{{ URL::asset('images/nologo.png') }} @endif"
                                     class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image" id="profile-image">
                                <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                    <input id="profile-img-file-input" type="file" name="image" class="profile-img-file-input">
                                    <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                <span class="avatar-title rounded-circle bg-light text-body">
                                    <i class="ri-camera-fill"></i>
                                </span>
                                    </label>
                                </div>
                            </div>
                            @if(isset($user))
                                <h5 class="fs-16 mb-1">{{ $user->name }}</h5>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">@lang('admin.vendor_user_name')</label>
                            <input value="{{ $user->name }}" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="" id="name">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">@lang('admin.customer_phone')</label>
                            <input value="{{ Illuminate\Support\Str::replace("+966", "", $user->phone) }}" type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="" id="phone">
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">@lang('admin.vendor_user_email')</label>
                            <input value="{{ $user->email }}" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="" id="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        @if($user->type != 'vendor')
                        <div class="col-md-6 mb-3">
                            <label for="vendor_id" class="form-label">@lang('admin.vendor_name')</label>
                            <select onchange="getVendorRoles(this);" cclass="form-control" name="vendor_id" id="vendor_id" data-choices data-choices-sorting-false>
                                <option value="">@lang('admin.select')</option>
                                @foreach($vendors AS $vendor)
                                    <option @if($user->vendor?->id == $vendor?->id) selected @endif value="{{ $vendor->id }}">{{ $vendor->vendorName }}</option>
                                @endforeach
                            </select>
                            @error('vendor_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3" id="roleSelect">
                            <label for="role" class="form-label">@lang('admin.vendor_user_role')</label>
                            <select class="form-select" name="role_id" id="role">
                                @foreach ($roles as $role)
                                    <option @if($user->roles()->first()?->id == $role->id) selected @endif value="{{ $role->id }}">{{ $role->text }}</option>
                                @endforeach
                            </select>
                            @error('role_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        @endif
                        <div class="col-md-6 mb-3">
                            <label for="password">@lang('admin.vendor_user_password')</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password-confirm">@lang('admin.vendor_user_password_confirm')</label>
                            <input id="password-confirm" type="password" name="password_confirmation" class="form-control" placeholder="@lang('admin.vendor_user_password_confirm')">
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
