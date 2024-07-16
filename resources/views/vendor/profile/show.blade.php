@extends('vendor.layouts.master')
@section('title')
    @lang('translation.profile')
@endsection
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/libs/swiper/swiper.min.css') }}">
@endsection
@section('content')
    <div class="profile-foreground position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg">
            <img src="{{ URL::asset('assets/images/auth-bg.jpg') }}"  alt="" class="profile-wid-img" />
        </div>
    </div>
    <div class="pt-4 mb-4 mb-lg-3 pb-lg-4">
        <div class="row g-4">
            <div class="col-auto">
                <div class="avatar-lg">
                    <img src="@if ($row->image != '') {{ URL::asset($row->image) }}@else{{ URL::asset('assets/images/users/avatar-1.jpg') }} @endif"
                        alt="user-img" class="img-thumbnail rounded-circle" />
                </div>
            </div>
            <!--end col-->
            <div class="col">
                <div class="p-2">
                    <h3 class="text-white mb-1">{{ $row->name }}</h3>
                    <p class="text-white-75">{{ $row->vendor->name }}</p>
                    <div class="hstack text-white-50 gap-1">
                        @if($row->country)
                            <div class="me-2">
                                <i class="ri-map-pin-user-line me-1 text-white-75 fs-16 align-middle"></i>
                                {{$row->country->name}}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!--end col-->
            @if($row->vendor)
            <div class="col-12 col-lg-auto order-last order-lg-0">
                <div class="row text text-white-50 text-center">
                    <div class="col-lg-6 col-4">
                        <div class="p-2">
                            <h4 class="text-white mb-1">{{$row->vendor->products()->count()}}</h4>
                            <p class="fs-14 mb-0">@lang('translation.products')</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-4">
                        <div class="p-2">
                            <h4 class="text-white mb-1">{{$row->vendor->orders()->count()}}</h4>
                            <p class="fs-14 mb-0">@lang('translation.orders')</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <!--end col-->

        </div>
        <!--end row-->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div>
                <div class="d-flex">
                    <!-- Nav tabs -->
                    <ul class="nav nav-pills animation-nav profile-nav gap-2 gap-lg-3 flex-grow-1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link fs-14 active" data-bs-toggle="tab" href="#overview-tab" role="tab">
                                <i class="ri-airplay-fill d-inline-block d-md-none"></i> <span
                                    class="d-none d-md-inline-block">@lang('translation.overview')</span>
                            </a>
                        </li>
                    </ul>
                    <div class="flex-shrink-0">
                        <a href="{{ route('vendor.edit-profile') }}" class="btn btn-success"><i
                                class="ri-edit-box-line align-bottom"></i> @lang('translation.edit_profile')</a>
                    </div>
                </div>
                <!-- Tab panes -->
                <div class="tab-content pt-4 text-muted">
                    <div class="tab-pane active" id="overview-tab" role="tabpanel">
                        <div class="row">
                            <div class="col-xxl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">@lang('translation.info')</h5>
                                        <div class="table-responsive">
                                            <table class="table table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th class="ps-0" scope="row">@lang('translation.name'):</th>
                                                        <td class="text-muted">{{$row->name}}</td>
                                                    </tr>
                                                    @if($row->phone)
                                                    <tr>
                                                        <th class="ps-0" scope="row">@lang('translation.phone') :</th>
                                                        <td class="text-muted">{{$row->phone}}</td>
                                                    </tr>
                                                    @endif
                                                    @if($row->email)
                                                    <tr>
                                                        <th class="ps-0" scope="row">@lang('translation.email') :</th>
                                                        <td class="text-muted">{{$row->email}}</td>
                                                    </tr>
                                                    @endif
                                                    @if($row->vendor->street)
                                                    <tr>
                                                        <th class="ps-0" scope="row">@lang('translation.address') :</th>
                                                        <td class="text-muted">{{$row->vendor->street}}
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    <tr>
                                                        <th class="ps-0" scope="row">@lang('translation.joining_date')</th>
                                                        <td class="text-muted">{{$row->created_at->toFormattedDateString()}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div>
                            <!--end col-->
                            <div class="col-xxl-9">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">@lang('translation.about')</h5>
                                        {{$row->desc}}
                                        <div class="row">
                                            <div class="col-6 col-md-4">
                                                <div class="d-flex mt-4">
                                                    <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                                        <div
                                                            class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                                            <i class="ri-user-2-fill"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="mb-1">@lang('translation.store_name') :</p>
                                                        <h6 class="text-truncate mb-0">{{ $row->vendor->name }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            {{--<div class="col-6 col-md-4">
                                                <div class="d-flex mt-4">
                                                    <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                                        <div
                                                            class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                                            <i class="ri-global-line"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="mb-1">Website :</p>
                                                        <a href="#" class="fw-semibold">www.velzon.com</a>
                                                    </div>
                                                </div>
                                            </div>--}}
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </div>
                                    <!--end card-body-->
                                </div><!-- end card -->
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                </div>
                <!--end tab-content-->
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/swiper/swiper.min.js') }}"></script>

    <script src="{{ URL::asset('assets/js/pages/profile.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
