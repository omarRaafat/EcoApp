@extends('admin.layouts.master-without-nav')
@section('body')
<body style="background-color: #11998E;">
@endsection
@section('title')
    @lang('translation.password-reset')
@endsection
@section('content')
    <div class="auth-page-wrapper pt-5">
        <div class="auth-page-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">
                            <div class="card-header align-self-center d-flex">
                                <div class="flex-grow-1">
                                    <a href="{{ route('admin.home') }}" class="d-inline-block auth-logo">
                                        <img src="{{ URL::asset('images/logo.png') }}" alt="" height="80">
                                    </a>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">@lang('admin.password_reset')</h5>
                                    <lord-icon src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop"
                                               colors="primary:#0ab39c" class="avatar-xl">
                                    </lord-icon>
                                </div>
                                <div class="p-2">
                                    <form class="form-horizontal" method="POST"
                                          action="{{ route('admin.password_reset_post') }}">
                                        @csrf
                                        <input type="hidden" name="token" value="{{ $token }}">
                                        <div class="mb-3">
                                            <label for="useremail" class="form-label">@lang('admin.email')</label>
                                            <input type="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   id="useremail" name="email" placeholder="@lang('admin.email_placeholder')"
                                                   value="{{ $email ?? old('email') }}" id="email">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="userpassword">@lang('admin.new_password')</label>
                                            <input type="password"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   name="password" id="userpassword" placeholder="@lang('admin.password_placeholder')">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="userpassword">@lang('admin.confirm_new_password')</label>
                                            <input id="password-confirm" type="password" name="password_confirmation"
                                                   class="form-control" placeholder="@lang('admin.confirm_new_password_placeholder')">
                                        </div>
                                        <div class="text-end">
                                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit">
                                                @lang('admin.reset')
                                            </button>
                                        </div>
                                    </form><!-- end form -->
                                </div>
                                <div class="mt-4 text-center">
                                    <p class="text-muted mb-0">@lang('admin.remember_login')? <a href="{{ route('admin.login') }}" class="text-primary fw-semibold">@lang('admin.sign_in')</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/particles.js/particles.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/particles.app.js') }}"></script>
@endsection
