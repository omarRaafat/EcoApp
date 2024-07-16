@extends('admin.layouts.master-without-nav')
@section('title')
    @lang('translation.password-reset')
@endsection
@section('content')
    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                     viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <div class="auth-page-content">
            <div class="container">
                <div class="row g-0 align-items-center">
                    <div class="row justify-content-center g-0">
                        <div class="col-md-8 col-lg-6 col-xl-5">
                            <div class="card mt-4">
                                <div class="card-header align-self-center d-flex">
                                    <div class="flex-grow-1">
                                        <a href="{{ route('admin.home') }}" class="d-inline-block auth-logo">
                                            <img src="{{ URL::asset('images/logo.png') }}" alt="" height="80">
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="text-center mt-2">
                                        <lord-icon src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop" colors="primary:#0ab39c" class="avatar-xl"></lord-icon>
                                    </div>
                                    <div class="auth-full-page-content rounded d-flex p-3 my-2">
                                        <div class="w-100">
                                            <div class="d-flex flex-column h-100">
                                                <div class="auth-content my-auto">
                                                    <div class="text-center">
                                                        <h5 class="mb-0">@lang('admin.forgot_password')</h5>
                                                    </div>
                                                    <div class="alert alert-success text-center my-4 font-size-12" role="alert">
                                                        @lang('admin.forgot_password_notes')
                                                    </div>
                                                    <div class="mt-4">
                                                        @if (session('status'))
                                                            <div
                                                                class="alert alert-success text-center mb-4"
                                                                role="alert">
                                                                {{ session('status') }}
                                                            </div>
                                                        @endif
                                                        <form class="form-horizontal" method="POST" action="{{ route('admin.forget') }}">
                                                            @csrf
                                                            <div class="mb-3">
                                                                <label for="useremail" class="form-label">@lang('admin.email')</label>
                                                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                                       id="useremail" name="email"
                                                                       placeholder="@lang('admin.email_placeholder')"
                                                                       value="{{ old('email') }}"
                                                                       id="email">
                                                                @error('email')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                            <div class="text-end">
                                                                <button class="btn btn-primary w-md waves-effect waves-light" type="submit">
                                                                    @lang('admin.send')
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="mt-4 pt-3 text-center">
                                                        <p class="text-muted mb-0">@lang('admin.remember_login')? <a href="{{ route('admin.login') }}" class="text-primary fw-semibold">@lang('admin.sign_in')</a></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end auth full page content -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container fluid -->
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/js/pages/eva-icon.init.js') }}"></script>
@endsection
