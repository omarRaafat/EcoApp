@extends('admin.layouts.master')
@section('title')
    @lang('admin.vendors_edit')
@endsection
@section('css')
    <link href="{{ URL::asset('/assets/libs/dateHijry/bootstrap-hijri-datepicker.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form class="needs-validation row" novalidate method="POST" action="{{ route('admin.vendors.update', ['vendor' => $vendor->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @foreach(config('app.locales') AS $locale)
                            <div class="col-md-6 mb-3">

                                <label for="username" class="form-label">@lang('translation.company_vendor__name'){{---@lang('language.'.$locale)--}}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('name.'.$locale) is-invalid @enderror" name="name[{{ $locale }}]"

                                value="{{ old('name.'.$locale) ?? $vendor->getTranslation('name',$locale)}}"
                                id="store_name" required>
                                @error('name.' . $locale)
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        @endforeach
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">@lang('admin.vendor_address')
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   name="street" value="{{ $vendor->street }}" id="street"
                                   placeholder="@lang('translation.street_placeholder')">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                            @enderror
                            <div class="invalid-feedback">
                                @lang('translation.please_enter_street')
                            </div>
                        </div>


                        <div class="col-md-6 mb-3">
                            <label for="bank_id" class="form-label">@lang('admin.vendor_bank') <span class="text-danger">*</span></label>
                            <select class="form-control" name="bank_id">

                                @if($vendor->bank)
                                    <option selected value="{{ $vendor->bank->id }}">
                                        {{ $vendor->bank->getTranslation('name', 'ar') }} - {{ $vendor->bank->getTranslation('name', 'en') }}
                                    </option>
                                @else

                                <option selected value="">
                                    @lang("vendors.registration.choose_bank_name")
                                </option>
                                @endif

                                @if ($banks->count() > 0)
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}">
                                            {{ $bank->getTranslation('name', 'ar') }} - {{ $bank->getTranslation('name', 'en') }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('bank_id')
                                <span class="invalid-feedback" role="alert">
                                </span>
                                    <strong>{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label  class="form-label">@lang('translation.second_phone') </label>
                            <input type="text" class="form-control @error('second_phone') is-invalid @enderror" name="second_phone" value="{{ $vendor->second_phone }}" >
                            @error('second_phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">@lang('admin.vendor_bank_number') <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('bank_num') is-invalid @enderror" name="bank_num" value="{{ $vendor->bank_num }}" id="bank_num" required>
                            @error('bank_num')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">@lang('admin.vendor_tax_number') <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('tax_num') is-invalid @enderror" name="tax_num" value="{{ $vendor->tax_num }}" id="tax_num" required>
                            @error('tax_num')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>


                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">@lang('admin.vendor_iban') <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-text">SA</div>
                                <input type="text" class="form-control @error('ipan') is-invalid @enderror" name="ipan" value="{{substr($vendor->ipan, 0, 2) == 'SA' ? str_replace('SA','',$vendor->ipan):$vendor->ipan  }}" id="ipan" required>
                                @error('ipan')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">@lang('admin.name_in_bank') <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('name_in_bank') is-invalid @enderror" name="name_in_bank" value="{{$vendor->name_in_bank  }}" id="name_in_bank" required @if(filled($vendor->name_in_bank)) disabled @endif>
                                @error('name_in_bank')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">@lang('admin.commercial_registration_no') <span  class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('commercial_registration_no') is-invalid @enderror" name="commercial_registration_no" value="{{$vendor->commercial_registration_no }}" id="ipan" required>
                                @error('ipan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>

                        {{-- <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">@lang('admin.vendor_commercial_register_date')
                                <span class="text-danger">*</span>
                            </label>
                            <input type="date" value="{{ date('Y-m-d', strtotime($vendor->crd)) }}" class="form-control flatpickr-input active @error('crd') is-invalid @enderror" name="crd" data-provider="flatpickr" data-date-format="Y-m-d">
                            @error('crd')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div> --}}


                        <div class="col-md-6 mb-3">
                            <label for="hijri-date-input" class="form-label">@lang('admin.vendor_commercial_register_date') <span
                                class="text-danger">*</span></label>

                            <input  autocomplete="off"  onkeydown="return false;" type="text" class="form-control" id="hijri-date-input"
                            value="{{Alkoumi\LaravelHijriDate\Hijri::Date('Y-m-d',$vendor->crd)}}"
                            @error('crd') is-invalid @enderror" name="crd" value="{{ old('crd') }}"
                            />


                            <input
                            style="display: none;"
                            name="crd"
                            type="text"
                            class="form-control"
                            id="HijriInput"
                            value="{{Alkoumi\LaravelHijriDate\Hijri::Date('Y-m-d',$vendor->crd)}}"

                            @error('crd') is-invalid @enderror" name="crd" value="{{ old('crd') }}"
                            />
                            @error('crd')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <input style="display: none;" name="crd_hijry" type="text" class="form-control" @error('crd_hijry') is-invalid @enderror" name="crd_hijry" value="true" id="isHijri" />




                        @foreach(config('app.locales') AS $locale)
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">@lang('admin.vendor_description'){{---@lang('language.'.$locale)--}}
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('desc.' . $locale) is-invalid @enderror" name="desc[{{ $locale }}]"
                                id="desc"
                                rows="3"> {{ old('desc.'.$locale) ?? $vendor->getTranslation('desc',$locale)}}</textarea>
                                @error('desc.' . $locale)
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        @endforeach
                        <div class="col-md-6 mb-3">
                            <label for="commission" class="form-label">@lang('admin.vendor_commission') <span
                                        class="text-danger">*</span></label>
                            <input type="text" min=0 oninput="this.value = this.value.replace('-+', '')"class="form-control @error('commission') is-invalid @enderror"
                                   name="commission" value="{{ $vendor->commission }}" id="bank_num" required>
                            @error('commission')
                            <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                            @enderror
                        </div>{{--
                        <div class="col-md-6 mb-3">
                            <label for="beez_id" class="form-label">@lang('admin.beez_id')</label>
                            <input type="text" class="form-control @error('beez_id') is-invalid @enderror"
                                   name="beez_id" value="{{ $vendor->beezConfig ? $vendor->beezConfig->beez_id : "" }}" id="beez_id" required>
                            @error('beez_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>--}}
                        <div class="col-md-6 mb-3">
                            <div class="row">
                                <div class="col-md-9">
                                    <label for="username" class="form-label">@lang('admin.vendor_logo') <span
                                            class="text-danger">*</span></label>
                                    <input type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" id="logo">
                                    @error('logo')
                                    <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <div class="d-flex align-items-center mt-4">
                                        <span class="d-flex align-items-center">
                                            <img class="rounded-circle header-profile-user" src="{{ ossStorageUrl($vendor->logo) }}" alt="Header Avatar">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="row">
                                <div class="col-md-9">
                                    <label for="username" class="form-label">@lang('admin.vendor_commercial_register') <span
                                            class="text-danger">*</span></label>
                                    <input type="file" class="form-control @error('cr') is-invalid @enderror" name="cr" id="cr" required>
                                    @error('cr')
                                    <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <div class="d-flex align-items-center mt-4">
                                        <div class="flex-shrink-0">
                                            <a href="{{ ossStorageUrl($vendor->cr) }}" target="_blank" class="btn btn-info btn-sm"><i class="ri-download-2-fill align-middle me-1"></i>@lang('admin.Showing')</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
{{--                        <div class="col-md-6 mb-3">
                            <div class="row">
                                <div class="col-md-9">
                                    <label for="username" class="form-label">@lang('admin.vendor_broc') <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control @error('broc') is-invalid @enderror" name="broc" id="broc" required>
                                    @error('broc')
                                    <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                    @enderror
                                </div>
                                @if($vendor->broc)

                                    <div class="col-md-3">
                                        <div class="d-flex align-items-center mt-4">
                                            <div class="flex-shrink-0">
                                                <a href="{{ URL::asset($vendor->broc) }}" target="_blank" class="btn btn-info btn-sm"><i class="ri-download-2-fill align-middle me-1"></i>@lang('admin.Showing')</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>--}}
                        <div class="col-md-6 mb-3">
                            <div class="row">
                                <div class="col-md-9">
                                    <label for="username" class="form-label">@lang('admin.vendor_tax_certificate') <span
                                            class="text-danger">*</span></label>
                                    <input type="file" class="form-control @error('tax_certificate') is-invalid @enderror" name="tax_certificate" id="tax_certificate" required>
                                    @error('tax_certificate')
                                    <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                    @enderror
                                </div>
                                @if($vendor->tax_certificate)
                                    <div class="col-md-3">
                                        <div class="d-flex align-items-center mt-4">
                                            <div class="flex-shrink-0">
                                                <a href="{{ ossStorageUrl($vendor->tax_certificate) }}" target="_blank" class="btn btn-info btn-sm"><i class="ri-download-2-fill align-middle me-1"></i>@lang('admin.Showing')</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="row">
                                <div class="col-md-9">
                                    <label for="username" class="form-label">@lang('admin.vendor_iban_certificate') <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control @error('iban_certificate') is-invalid @enderror" name="iban_certificate" id="iban_certificate" required>
                                    @error('iban_certificate')
                                    <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                    @enderror
                                </div>
                                @if($vendor->iban_certificate)

                                <div class="col-md-3">
                                    <div class="d-flex align-items-center mt-4">
                                        <div class="flex-shrink-0">
                                            <a href="{{ ossStorageUrl($vendor->iban_certificate) }}" target="_blank" class="btn btn-info btn-sm"><i class="ri-download-2-fill align-middle me-1"></i>@lang('admin.Showing')</a>
                                        </div>
                                    </div>
                                </div>
                                    @endif

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="row">
                                <div class="col-md-9">
                                    <label for="username" class="form-label">@lang('translation.saudia_certificate') <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control @error('saudia_certificate') is-invalid @enderror" name="saudia_certificate" id="saudia_certificate" required>
                                    @error('saudia_certificate')
                                    <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                    @enderror
                                </div>
                                @if($vendor->saudia_certificate)

                                    <div class="col-md-3">
                                        <div class="d-flex align-items-center mt-4">
                                            <div class="flex-shrink-0">
                                                <a href="{{ ossStorageUrl($vendor->saudia_certificate) }}" target="_blank" class="btn btn-info btn-sm"><i class="ri-download-2-fill align-middle me-1"></i>@lang('admin.Showing')</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="row">
                                <div class="col-md-9">
                                    <label for="username" class="form-label">@lang('translation.subscription_certificate') <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control @error('subscription_certificate') is-invalid @enderror" name="subscription_certificate" id="subscription_certificate" required>
                                    @error('subscription_certificate')
                                    <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                    @enderror
                                </div>
                                @if($vendor->subscription_certificate)
                                    <div class="col-md-3">
                                        <div class="d-flex align-items-center mt-4">
                                            <div class="flex-shrink-0">
                                                <a href="{{ ossStorageUrl($vendor->subscription_certificate) }}" target="_blank" class="btn btn-info btn-sm"><i class="ri-download-2-fill align-middle me-1"></i>@lang('admin.Showing')</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>


                        <div class="col-md-6 mb-3">
                            <div class="row">
                                <div class="col-md-9">
                                    <label for="username" class="form-label">@lang('translation.room_certificate') <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control @error('room_certificate') is-invalid @enderror" name="room_certificate" id="room_certificate" required>
                                    @error('room_certificate')
                                    <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                    @enderror
                                </div>
                                @if($vendor->room_certificate)
                                    <div class="col-md-3">
                                        <div class="d-flex align-items-center mt-4">
                                            <div class="flex-shrink-0">
                                                <a href="{{ ossStorageUrl($vendor->room_certificate) }}" target="_blank" class="btn btn-info btn-sm"><i class="ri-download-2-fill align-middle me-1"></i>@lang('admin.Showing')</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="services" class="form-label">@lang('translation.service_provided')<span class="text-danger">*</span></label>
                            <div class="input-group">
                                @php
                                $services = ['selling_products' => 'بيع منتجات', 'agricultural_services' => 'خدمات زراعية', 'agricultural_guidance' => 'إرشاد زراعي'];
                                $selectedServices = old('services', $vendor->services ?? []);
                                @endphp

                                @foreach ($services as $key => $service)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('services') is-invalid @enderror" type="checkbox" id="service_{{ $key }}" name="services[]" value="{{ $key }}" {{ in_array($key, $selectedServices) ? 'checked' : '' }}>
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
{{--
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">@lang('admin.vendor_is_international')</label>
                            <div class="form-check form-switch form-switch-lg" dir="ltr">
                                <input name="is_international" type="checkbox" class="form-check-input" id="is_international" @if($vendor->is_international == 1) checked="" @endif>
                            </div>
                        </div>--}}
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>

    <script src="{{ URL::asset('assets/js/pages/bootstrap-hijri-datetimepicker.min.js')}}"></script>

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
