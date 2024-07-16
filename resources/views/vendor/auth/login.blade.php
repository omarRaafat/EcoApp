@extends('vendor.layouts.master-without-nav')
@section('title')
@lang('translation.signin')
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
                            <a href="{{ route('vendor.index') }}" class="d-inline-block auth-logo">
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
                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">@lang('translation.welcome_back')</h5>
                                <p class="text-muted">@lang('translation.Sign_in_to_continue_to_suadi_dates').</p>
                            </div>
                            @if(session()->has('success'))
                            <div class="text-center mt-2">
                                <div class="alert alert-success alert-borderless" role="alert">
                                    {{session()->get('success')}}
                                </div>
                            </div>
                            @endif
                            @if(session()->has('inactive'))
                                <div class="text-center mt-2">
                                    <div class="alert alert-danger alert-borderless" role="alert">
                                        {{session()->get('inactive')}}
                                    </div>
                                </div>
                            @endif
                            @error('warning')
                                <div class="text-center mt-2">
                                    <div class="alert alert-danger alert-borderless" role="alert">
                                        {{ $message }}
                                    </div>
                                </div>
                            @enderror
                            <div class="p-2 mt-4">
                                <form action="{{ route('vendor.login') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="username" class="form-label">@lang('translation.phone')</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" id="username" name="phone" placeholder="@lang('translation.phone_placeholder')">
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <div class="float-end">
                                            <a href="{{route('vendor.password.request')}}" class="text-muted">@lang('translation.forgot_password')</a>
                                        </div>
                                        <label class="form-label" for="password-input">@lang('translation.password')</label>
                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                            <input type="password" class="form-control pe-5 password-input @error('password') is-invalid @enderror"
                                                placeholder="@lang('translation.password_placeholder')" name="password" id="password-input">
                                            <button
                                                class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                type="button" id="password-addon"><i
                                                    class="ri-eye-fill align-middle"></i></button>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember_me" value="" name="remember" id="auth-remember-check">
                                        <label class="form-check-label" for="auth-remember-check">@lang('translation.remember_me')</label>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-success w-100" style="background-color: #827e4a;border-color: #827e4a;" type="submit">@lang('translation.sign_in')</button>
                                    </div>

                                    {{--
                                    <div class="mt-4 text-center">
                                        <div class="signin-other-title">
                                            <h5 class="fs-13 mb-4 title">Sign In with</h5>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-facebook-fill fs-16"></i></button>
                                            <button type="button" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-google-fill fs-16"></i></button>
                                            <button type="button" class="btn btn-dark btn-icon waves-effect waves-light"><i class="ri-github-fill fs-16"></i></button>
                                            <button type="button" class="btn btn-info btn-icon waves-effect waves-light"><i class="ri-twitter-fill fs-16"></i></button>
                                        </div>
                                    </div>--}}
                                </form>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->

                    <div class="mt-4 text-center">
                        <p class="mb-0">@lang('translation.not_have_an_account') <a href="{{route('vendor.register')}}" class="fw-semibold text-primary text-decoration-underline"> @lang('translation.signup') </a> </p>
                    </div>

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">&copy; <script>document.write(new Date().getFullYear())</script> @lang('translation.app_name')</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
</div>
@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/particles.js/particles.js.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/particles.app.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/password-addon.init.js') }}"></script>

@endsection
