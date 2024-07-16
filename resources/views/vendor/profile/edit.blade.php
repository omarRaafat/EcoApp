@extends('vendor.layouts.master')
@section('title')
    @lang('translation.edit_profile')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('assets/libs/filepond/filepond.min.css') }}" type="text/css" />
    <link rel="stylesheet"
        href="{{ URL::asset('assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}">
    <style type="text/css">
        .invalid-input{
            border-color: #f06548 !important;
            background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23f06548'%3E%3Ccircle cx='6' cy='6' r='4.5'/%3E%3Cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3E%3Ccircle cx='6' cy='8.2' r='.6' fill='%23f06548' stroke='none'/%3E%3C/svg%3E") !important;
        }
    </style>
@endsection
@section('content')
    <div class="position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg profile-setting-img">
            <img src="{{ URL::asset('assets/images/dates_background5415.jpg') }}" class="profile-wid-img" alt="">
            <div class="overlay-content">
                <div class="text-end p-3">
                    {{--
                    <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                        <input id="profile-foreground-img-file-input" type="file" class="profile-foreground-img-file-input">
                        <label for="profile-foreground-img-file-input" class="profile-photo-edit btn btn-light">
                            <i class="ri-image-edit-line align-bottom me-1"></i> Change Cover
                        </label>
                    </div>--}}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xxl-3">
            <div class="card mt-n5">
                <div class="card-body p-4">
                    <div class="text-center">
                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                            <img src="@if ($row->image != '') {{ URL::asset($row->image) }}@else{{ URL::asset('assets/images/users/avatar-1.jpg') }} @endif"
                                class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                <input id="profile-img-file-input" type="file" name="image" form="profile-form" class="profile-img-file-input">
                                <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                    <span class="avatar-title rounded-circle bg-light text-body">
                                        <i class="ri-camera-fill"></i>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <h5 class="fs-16 mb-1">{{$row->name}}</h5>
                        @if($row->my_vendor)
                        <p class="text-muted mb-0">{{$row->my_vendor->name}}</p>
                        @endif

                        @if($errors->has('image'))
                            <div class="alert alert-danger">
                            {{$errors->first('image')}}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
        <div class="col-xxl-9">
            <div class="card mt-xxl-n5">
                <div class="card-header">
                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link @if(session()->get('id') == null && !$errors->has('password') && !$errors->has('old_password')) active @endif" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                <i class="fas fa-home"></i>
                                @lang('translation.personal_details')
                            </a>
                        </li>
                        <li class="nav-item @if(session()->get('id')=='changePassword' || $errors->has('password') || $errors->has('old_password')) active @endif">
                            <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                <i class="far fa-user"></i>
                                @lang('translation.change_password')
                            </a>
                        </li>
                        @if($row->my_vendor)
                        <li class="nav-item @if(session()->get('id') == 'vendorData') active @endif">
                            <a class="nav-link" data-bs-toggle="tab" href="#vendorData" role="tab">
                                <i class="far fa-user"></i>
                                @lang('translation.vendor_data')
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content">
                        <div class="tab-pane @if(session()->get('id') == null && !$errors->has('password') && !$errors->has('old_password')) active show @endif" id="personalDetails" role="tabpanel">
                            @include('vendor.profile.includes.update_profile_form')
                        </div>
                        <!--end tab-pane-->
                        <div class="tab-pane @if(session()->get('id')=='changePassword' || $errors->has('password') || $errors->has('old_password')) active show @endif" id="changePassword" role="tabpanel">
                            @include('vendor.profile.includes.change_password_form')
                        </div>
                        <!--end tab-pane-->
                        @if($row->my_vendor)
                        <div class="tab-pane @if(session()->get('id')=='vendorData') active show @endif" id="vendorData" role="tabpanel">
                            @include('components.session-alert')
                            @include('vendor.profile.includes.vendor_form')
                        </div>
                        <!--end tab-pane-->
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
    <button style="display:none;" id="show-success" type="button" data-toast data-toast-text="{{session()->get('success')}}" data-toast-gravity="top" data-toast-position="center" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs">Top Center</button>

@endsection
@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="{{ URL::asset('assets/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/profile-setting.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/notifications.init.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/filepond/filepond.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}">
    </script>
        <script
        src="{{ URL::asset('assets/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}">
    </script>
    <script
        src="{{ URL::asset('assets/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}">
    </script>
    <script src="{{ URL::asset('assets/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

    <script>
        $(".nav .nav-item .nav-link").on("click", function() {
            var nameHash  = $(this).attr("href")
            var name = nameHash.replace("#", "")
            $("#" + name).addClass("active show").siblings().removeClass("active show")
        })
    </script>

    <script>
        showImage('profile-img-file-input-store','store-profile-image');
        // FilePond
        FilePond.registerPlugin(
            // encodes the file as base64 data
            FilePondPluginFileEncode,
            // validates the size of the file
            FilePondPluginFileValidateSize,
            // corrects mobile image orientation
            FilePondPluginImageExifOrientation,
            // previews dropped images
            FilePondPluginImagePreview
        );
        @if($row->my_vendor != null)
        var vendorFiles=[]; // files with vendor table

        // var vendorFiles=['#broc','#cr','#tax_certificate' , '#saudia_certificate' , '#subscription_certificate' , '#room_certificate']; // files with vendor table
        vendorFiles.forEach((value,index)=>{
            let vendorFile = document.querySelector(value);
            let exsitFile='';
            if (value==='#broc') {
                exsitFile='{{  ossStorageUrl($row->my_vendor->broc) }}';
            }
            if (value==='#saudia_certificate') {
                exsitFile='{{  ossStorageUrl($row->my_vendor->saudia_certificate) }}';
            }
            if (value==='#subscription_certificate') {
                exsitFile='{{  ossStorageUrl($row->my_vendor->subscription_certificate) }}';
            }
            if (value==='#room_certificate') {
                exsitFile='{{  ossStorageUrl($row->my_vendor->room_certificate) }}';
            }
            if (value==='#cr') {
                exsitFile='{{  ossStorageUrl($row->my_vendor->cr) }}';
            }
            if (value==='#tax_certificate') {
                exsitFile='{{  ossStorageUrl($row->my_vendor->tax_certificate) }}';
            }
            let image=FilePond.create(vendorFile,{
                labelIdle:'@lang("translation.drag_or_drop_file") <span class="filepond--label-action"> @lang("translation.browse") </span>'
            });
            image.addFile(exsitFile);
        })
        @endif
    </script>
@endsection
