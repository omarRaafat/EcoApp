@extends('vendor.layouts.master-without-nav')
@section('title')
    @lang('translation.signup')
@endsection
@section('css')
    <link href="{{ URL::asset('/assets/libs/dateHijry/bootstrap-hijri-datepicker.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')

    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles" style="background-image: url('{{ URL::asset('assets/images/auth-bg.jpg') }}');" >
            <div class="bg-overlay" style="background: -webkit-gradient(linear,left top,right top,from(#11998e),to(#27aa9d));background: linear-gradient(to right,#827e4a,#060606);opacity: .9;"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 1440 120">
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
                                    <img src="{{ URL::asset('images/logo.png') }}" alt="" height="80">
                                </a>
                            </div>
                            <p class="mt-3 fs-17 fw-bold" style="color:aliceblue;">@lang('translation.mercahnt_register_logo_sub_title')</p>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-12 col-lg-12 col-xl-12">
                        <div class="card mt-4">
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">@lang('translation.create_vendor_account')</h5>
                                    <!-- <p class="text-muted">@lang('translation.get_your_free_suadi_dates_account_now')</p> -->
                                </div>
                                <div class="p-2 mt-4">
                                    <form class="row" novalidate method="POST"
                                        action="{{ route('vendor.register') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-md-6 mb-3">
                                            <label for="useremail" class="form-label">@lang('translation.vendor_owner_store_name') <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                name="vendor_name" value="{{ old('vendor_name') }}" id="userowner_store_name"
                                                placeholder="@lang('translation.vendor_owner_store_name')">
                                            @error('vendor_name')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="useremail" class="form-label">@lang('translation.phone') <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                                name="phone" value="{{ old('phone') }}" id="phone"
                                                placeholder="@lang('translation.phone_placeholder')">
                                            @error('phone')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="useremail" class="form-label">@lang('translation.second_phone') <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('second_phone') is-invalid @enderror"
                                                name="second_phone" value="{{ old('second_phone') }}" id="second_phone"
                                                placeholder="@lang('translation.second_phone_placeholder') ">
                                            @error('second_phone')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="useremail" class="form-label">@lang('translation.email') <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                name="email" value="{{ old('email') }}" id="email"
                                                placeholder="@lang('translation.email_placeholder')">
                                            @error('email')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="website" class="form-label">@lang('translation.website')</label>
                                            <input type="text" class="form-control @error('website') is-invalid @enderror"
                                                name="website" value="{{ old('website') }}" id="website"
                                                placeholder="@lang('translation.website_placeholder')">
                                            @error('website')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="street" class="form-label">@lang('translation.address') <span
                                                class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('street') is-invalid @enderror"
                                                name="street" value="{{ old('street') }}" id="address"
                                                placeholder="@lang('translation.enter_address')">
                                            @error('street')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="username" class="form-label">@lang('translation.company_vendor__name') <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('store_name') is-invalid @enderror"
                                                name="store_name" value="{{old('store_name')}}" id="store_name"
                                                placeholder="@lang('translation.company_vendor__name_placeholder')">
                                            @error('store_name')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <div>
                                                <label for="exampleFormControlTextarea5" class="form-label">@lang('translation.desc')<span class="text-danger">*</span></label></label>
                                                <textarea class="form-control" id="exampleFormControlTextarea5" rows="6" name="desc"
                                                >{{old('desc') }}</textarea>

                                                @error('desc')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="username" class="form-label">@lang('translation.vendor_logo') <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                                name="logo" value="{{ old('logo') }}" id="logo"
                                                placeholder="@lang('translation.logo_placeholder')">
                                            @error('logo')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="username" class="form-label">@lang('translation.tax_num') <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('tax_num') is-invalid @enderror"
                                                name="tax_num" value="{{ old('tax_num') }}" id="tax_num"
                                                placeholder="@lang('translation.tax_num_placeholder')">
                                            @error('tax_num')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="username" class="form-label">@lang('translation.crd') <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" class="form-control @error('cr') is-invalid @enderror"
                                                name="cr" id="cr"
                                                placeholder="@lang('translation.cr_placeholder')">
                                            @error('cr')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="iban_certificate" class="form-label">@lang('translation.iban_certificate') <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" class="form-control @error('iban_certificate') is-invalid @enderror"
                                                name="iban_certificate" id="iban_certificate"
                                                placeholder="@lang('translation.iban_certificate_placeholder')">
                                            @error('iban_certificate')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        {{-- <div class="col-md-6 mb-3">
                                            <label for="username" class="form-label">@lang('translation.crd_date') <span
                                                    class="text-danger">*</span></label>
                                            <input type="date"  min="{{date('Y-m-d')}}" class="form-control @error('crd') is-invalid @enderror" name="crd" value="{{ old('crd') }}">
                                            @error('crd')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div> --}}

{{--                                        <div class="col-md-6 mb-3">--}}
{{--                                            <label for="username" class="form-label">@lang('translation.broc')</label>--}}
{{--                                            <input type="file" class="form-control @error('broc') is-invalid @enderror"--}}
{{--                                                name="broc" value="{{ old('broc') }}" id="broc"--}}
{{--                                                placeholder="@lang('translation.broc_placeholder')">--}}
{{--                                            @error('broc')--}}
{{--                                                <span class="invalid-feedback d-block" role="alert">--}}
{{--                                                    <strong>{{ $message }}</strong>--}}
{{--                                                </span>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
                                        <div class="col-md-6 mb-3">
                                            <label for="username" class="form-label">@lang('translation.tax_certificate') <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" class="form-control @error('tax_certificate') is-invalid @enderror"
                                                name="tax_certificate" value="{{ old('tax_certificate') }}" id="tax_certificate"
                                                placeholder="@lang('translation.tax_certificate_placeholder')">
                                            @error('tax_certificate')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="username" class="form-label">@lang('translation.saudia_certificate')<span
                                                    class="text-danger">*</span></label>
                                            <input type="file" class="form-control @error('saudia_certificate') is-invalid @enderror"
                                                   name="saudia_certificate" value="{{ old('saudia_certificate') }}" id="saudia_certificate"
                                                   placeholder="@lang('translation.saudia_certificate')">
                                            @error('saudia_certificate')
                                            <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="username" class="form-label">@lang('translation.subscription_certificate') <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" class="form-control @error('subscription_certificate') is-invalid @enderror"
                                                   name="subscription_certificate" value="{{ old('subscription_certificate') }}" id="subscription_certificate"
                                                   placeholder="@lang('translation.subscription_certificate')">
                                            @error('subscription_certificate')
                                            <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="username" class="form-label">@lang('translation.room_certificate')<span
                                                    class="text-danger">*</span></label>
                                            <input type="file" class="form-control @error('room_certificate') is-invalid @enderror"
                                                   name="room_certificate" value="{{ old('room_certificate') }}" id="room_certificate"
                                                   placeholder="@lang('translation.room_certificate')">
                                            @error('room_certificate')
                                            <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="commercial_registration_no" class="form-label">@lang('admin.commercial_registration_no')<span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('commercial_registration_no') is-invalid @enderror"
                                                   name="commercial_registration_no" value="{{ old('commercial_registration_no') }}" id="commercial_registration_no"
                                                   placeholder="@lang('admin.enter_commercial_registration_no')">
                                            @error('commercial_registration_no')
                                            <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="hijri-date-input" class="form-label">@lang('translation.crd_date') <span
                                                class="text-danger">*</span></label>

                                            <input  autocomplete="off"  onkeydown="return false;" type="text" class="form-control" id="hijri-date-input"
                                            @error('crd') is-invalid @enderror" name="crd" value="{{ old('crd') }}"
                                            />


                                            <input
                                            style="display: none;"
                                            name="crd"
                                            type="text"
                                            class="form-control"
                                            id="HijriInput"
                                            @error('crd') is-invalid @enderror" name="crd" value="{{ old('crd') }}"
                                            />
                                            @error('crd')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>



                                        <input style="display: none;" name="crd_hijry" type="text" class="form-control"
                                        @error('crd_hijry') is-invalid @enderror" name="crd_hijry" value="{{ old('crd_hijry') }}"
                                        id="isHijri" />




{{--
                                        <div class="col-md-6 mb-3">
                                            <label for="bank_name" class="form-label">@lang('translation.bank_name') <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('bank_name') is-invalid @enderror"
                                                name="bank_name" value="{{ old('bank_name') }}" id="bank_name"
                                                placeholder="@lang('translation.bank_name_placeholder')">
                                            @error('bank_name')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div> --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="bank_id" class="form-label">@lang('translation.bank_name')<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control" name="bank_id">
                                                <option selected value="">
                                                    @lang("vendors.registration.choose_bank_name")
                                                </option>
                                                @if ($banks->count() > 0)
                                                    @foreach ($banks as $bank)
                                                        <option value="{{ $bank->id }}"
                                                            {{(old('bank_id')== $bank->id) ? 'selected': null }} > {{ $bank->getTranslation('name', 'ar') }} - {{ $bank->getTranslation('name', 'en') }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('bank_id')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="username" class="form-label">@lang('translation.bank_num')<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('bank_num') is-invalid @enderror"
                                                name="bank_num" value="{{ old('bank_num') }}" id="bank_num"
                                                placeholder="@lang('translation.bank_num_placeholder')">
                                            @error('bank_num')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="username" class="form-label">@lang('translation.ipan')<span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-text">SA</div>
                                                <input type="text" class="form-control @error('ipan') is-invalid @enderror"
                                                       name="ipan" value="{{ old('ipan') }}" id="ipan"
                                                       placeholder="@lang('translation.ipan_placeholder')">

                                                @error('ipan')
                                                <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="name_in_bank" class="form-label">@lang('translation.name_in_bank')<span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control @error('name_in_bank') is-invalid @enderror"
                                                       name="name_in_bank" value="{{ old('name_in_bank') }}" id="name_in_bank"
                                                       placeholder="@lang('translation.name_in_bank_placeholder')">

                                                @error('name_in_bank')
                                                <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">

                                        <div class="col-md-6 mb-2">
                                            <label for="userpassword" class="form-label">@lang('translation.password') <span
                                                    class="text-danger">*</span></label>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                id="password" placeholder="@lang('translation.password_placeholder')">
                                            @error('password')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-4">

                                            <label for="input-password" class="form-label">@lang('translation.confirm_password')
                                                <span
                                                class="text-danger">*</span></label>
                                            <input type="password"
                                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                                name="password_confirmation" id="confirm_password"
                                                placeholder="@lang('translation.confirm_password_placeholder')">
                                                @error('password')
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="services" class="form-label">@lang('translation.service_provided')<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                @php
                                                    $services = ['selling_products' => 'بيع منتجات', 'agricultural_services' => 'خدمات زراعية', 'agricultural_guidance' => 'إرشاد زراعي'];
                                                @endphp

                                                @foreach ($services as $key => $service)
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input @error('services') is-invalid @enderror" type="checkbox" id="service_{{ $key }}" name="services[]" value="{{ $key }}" {{ in_array($key, old('services', [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="service_{{ $key }}">{{ $service }}</label>
                                                    </div>
                                                @endforeach
                                            </div>

                                            @error('services')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        </div>

                                        <div class="col-md-12 mb-4">
                                            <p class="mb-0 fs-12 text-muted fst-italic">@lang('translation.by_registering_you_agree_to_the_suadi_dates') <a href="#"
                                                    class="text-primary text-decoration-underline fst-normal fw-medium" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl">@lang('translation.terms_of_use')</a>

                                            </p>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" style="background-color: #827e4a;border-color: #827e4a;" type="submit">@lang('translation.signup')</button>
                                        </div>

                                        {{--<div class="mt-4 text-center">
                                            <div class="signin-other-title">
                                                <h5 class="fs-13 mb-4 title text-muted">Create account with</h5>
                                            </div>

                                            <div>
                                                <button type="button"
                                                    class="btn btn-primary btn-icon waves-effect waves-light"><i
                                                        class="ri-facebook-fill fs-16"></i></button>
                                                <button type="button"
                                                    class="btn btn-danger btn-icon waves-effect waves-light"><i
                                                        class="ri-google-fill fs-16"></i></button>
                                                <button type="button"
                                                    class="btn btn-dark btn-icon waves-effect waves-light"><i
                                                        class="ri-github-fill fs-16"></i></button>
                                                <button type="button"
                                                    class="btn btn-info btn-icon waves-effect waves-light"><i
                                                        class="ri-twitter-fill fs-16"></i></button>
                                            </div>
                                        </div>--}}

                                    </form>

                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="mt-4 text-center">
                            <p class="mb-0">@lang('translation.already_have_an_account') <a href="login"
                                    class="fw-semibold text-primary text-decoration-underline"> @lang('translation.sign_in') </a> </p>
                        </div>

                    </div>
                </div>
            </div>
                <!-- end row -->
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        {{--<footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> Velzon. Crafted with <i
                                    class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>--}}
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->
    <!--  Extra Large modal example -->
    <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">@lang('translation.terms_of_use')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body overflow-wrap: break-word; word-wrap: break-word; -ms-word-break: break-all; word-break: break-all; word-break: break-word; white-space: pre-line;">
                    @if($vendorTerms != null)

                    <p>  {!! $vendorTerms->value !!} </p>


                    @endif
                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>@lang('translation.close')</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
@section('script')

    <script src="{{ URL::asset('assets/libs/particles.js/particles.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/particles.app.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-validation.init.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>

    <script src="{{ URL::asset('assets/js/pages/bootstrap-hijri-datetimepicker.min.js')}}"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

    <script>

      var date = new Date();
      var month = date.getUTCMonth() + 1; //months from 1-12
      var day = date.getUTCDate();
      var year = date.getUTCFullYear();

      let toDay = year + "-" + month + "-" + day;



    $("#hijri-date-input").hijriDatePicker({
        hijri: true,
        showSwitcher: true,
        minDate:toDay
      });


      </script>

    <script>

    $(function () {
        var isHijiri = true;
        $("#hijri-date-input").on("focus", function () {
          $("a[data-action='switchDate']").on("click", function () {
            isHijiri = !isHijiri;
          });
        });

        $("#hijri-date-input").on("blur", function () {
            var value = $(this).val();


            if (!isHijiri) {
                $('#HijriInput').attr("value", value.split("-").reverse().join("-"));
            }else{
                  $('#HijriInput').attr("value", value);

                }


          $("#isHijri").attr("value", isHijiri);

        });
    });
    </script>
@endsection
