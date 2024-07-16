@extends('admin.layouts.master-without-nav')
@section('title')
    @lang('admin.sign_in')
@endsection
@section('content')
    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg"  id="auth-particles" style="background-image: url('{{ URL::asset('assets/images/auth-bg.jpg') }}');">
            <div class="bg-overlay" style="background: -webkit-gradient(linear,left top,right top,from(#11998e),to(#27aa9d));background: linear-gradient(to right,#827e4a,#060606);opacity: .9;"></div>
            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>
        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="{{ route('admin.home') }}" class="d-inline-block auth-logo">
                                    <img src="{{ URL::asset('images/logo.png') }}" alt="" height="120">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">
                            {{--<div class="card-header align-self-center d-flex">
                                <div class="flex-grow-1">
                                    <a href="{{ route('admin.home') }}" class="d-inline-block auth-logo">
                                        <img src="{{ URL::asset('images/logo.png') }}" alt="" height="80">
                                    </a>
                                </div>
                            </div>--}}
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    {{-- <img src="{{asset('images/logo.png')}}"> --}}
                                    <h5 class="text-primary">{{ __('admin.sign_in') }}</h5>
                                </div>
                                <div class="p-2 mt-4">
                                    <form action="{{ route('admin.loginPost') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="email" class="form-label">{{ __('admin.email') }}</label>
                                            <input type="text" class="form-control @error('email') is-invalid @enderror" value="{{  old('email') }}" id="email" name="email" placeholder="{{ __('admin.email_placeholder') }}">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <div class="float-end">
                                                <a href="{{ route('admin.forget') }}" class="text-muted">{{ __('admin.forgot_password') }}</a>
                                            </div>
                                            <label class="form-label" for="password-input">{{ __('admin.password') }}</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" class="form-control pe-5 @error('password') is-invalid @enderror" name="password" placeholder="{{ __('admin.password_placeholder') }}" id="password-input" value="">
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                                            <label class="form-check-label" for="auth-remember-check">{{ __('admin.remember_me') }}</label>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit" style="background-color: #827e4a;border-color: #827e4a;">{{ __('admin.sign') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        {{--<footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">&copy; <script>document.write(new Date().getFullYear())</script>  Copyright - All Rights Reserved </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>--}}
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/particles.js/particles.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/particles.app.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/password-addon.init.js') }}"></script>
@endsection
