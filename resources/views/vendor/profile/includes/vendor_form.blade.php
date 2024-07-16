<form action="{{route('vendor.update-vendor')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">



        <div class="col-lg-6">
            <div class="mb-3">
                <label for="firstnameInput" class="form-label">@lang('translation.company_vendor__name')<span
                        class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" id="firstnameInput"
                       placeholder="@lang('translation.store_name_placeholder')" value="{{$row->my_vendor->name}}"
                       >
            </div>
        </div>



        <div class="col-lg-6">
            <div class="mb-3">
                <label for="firstnameInput" class="form-label">@lang('translation.second_phone')<span
                        class="text-danger">*</span></label>
                <input type="text" class="form-control" name="second_phone" id="firstnameInput" style="direction: ltr;"
                       placeholder="@lang('translation.second_phone_placeholder')"
                       value="{{$row->my_vendor->second_phone}}" >
            </div>
        </div>



        <div class="col-lg-6">
            <div class="mb-3">
                <label for="firstnameInput" class="form-label">@lang('translation.website')</label>
                <input type="text" class="form-control" name="website" id="firstnameInput"
                       placeholder="@lang('translation.website_placeholder')" value="{{$row->my_vendor->website}}"
                       >
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <label for="username" class="form-label">@lang('translation.address')</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                   name="street" value="{{ old('name',$row->my_vendor->street) }}" id="street"
                   placeholder="@lang('translation.enter_address')" >
            @error('name')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="invalid-feedback">
                @lang('translation.please_enter_street')
            </div>
        </div>

        <div class="col-md-6">
            <label for="username" class="form-label">@lang('translation.desc')</label>
            <textarea   class="form-control" name="desc"
                      rows="3">{{ $row->my_vendor->desc}}</textarea>
        </div>

        {{-- <div class="col-md-4 mb-3">
            <label for="username" class="form-label">@lang('translation.bank_name') <span
                    class="text-danger">*</span></label>
            <input type="text" class="form-control @error('bank_name') is-invalid @enderror"
                name="bank_name" value="{{ old('bank_name',$row->my_vendor->bank_name) }}" id="bank_name"
                placeholder="@lang('translation.bank_name_placeholder')" required >
            @error('bank_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="invalid-feedback">
                @lang('translation.please_enter_bank_name')
            </div>
        </div> --}}

        <div class="col-md-6 mb-3">
            <label for="bank_id" class="form-label">@lang('admin.vendor_bank') <span
                    class="text-danger">*</span></label>
            <select class="form-control" name="bank_id" >

                @if($row->my_vendor->bank)
                    <option selected value="{{ $row->my_vendor->bank->id }}">
                        {{ $row->my_vendor->bank->getTranslation('name', 'ar') }}
                        - {{ $row->my_vendor->bank->getTranslation('name', 'en') }}
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

        {{-- <div class="col-md-6 mb-3">
            <label for="bank_id" class="form-label">@lang('translation.bank_name') <span class="text-danger">*</span></label>
            <select class="form-control" name="bank_id" >
                <option selected value="">
                    @lang("vendors.registration.choose_bank_name")
                </option>
                @if ($banks->count() > 0)
                    @foreach ($banks as $bank)
                        @if($row->vendor->bank_id && $row->vendor->bank_id == $bank->id)
                            <option selected value="{{ $bank->id }}">
                                {{ $bank->getTranslation('name', 'ar') }} - {{ $bank->getTranslation('name', 'en') }}
                            </option>
                        @else
                            <option value="{{ $bank->id }}">
                                {{ $bank->getTranslation('name', 'ar') }} - {{ $bank->getTranslation('name', 'en') }}
                            </option>
                        @endif
                    @endforeach
                @endif
            </select>
            @error('bank_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div> --}}


        <div class="col-md-6 mb-3">
            <label for="username" class="form-label">@lang('translation.bank_num') <span
                    class="text-danger">*</span></label>
            <input type="text" class="form-control @error('bank_num') is-invalid @enderror"
                   name="bank_num" value="{{ old('bank_num',$row->my_vendor->bank_num) }}" id="bank_num"
                   placeholder="@lang('translation.bank_num_placeholder')" required >
            @error('bank_num')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="invalid-feedback">
                @lang('translation.please_enter_bank_num')
            </div>
        </div>


        <div class="col-md-6 mb-3">
            <label for="username" class="form-label">@lang('translation.ipan') <span
                    class="text-danger">*</span></label>
            <div class="input-group">
                <div class="input-group-text">SA</div>
                <input   type="text" class="form-control" name="ipan" value="{{substr($row->my_vendor->ipan, 0, 2) == 'SA' ? str_replace('SA','',$row->my_vendor->ipan):$row->my_vendor->ipan }}">

                @error('ipan')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <div class="invalid-feedback">
                    @lang('translation.please_enter_ipan')
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <label for="name_in_bank" class="form-label">@lang('translation.name_in_bank') <span
                    class="text-danger">*</span></label>
            <div class="input-group">
                <input type="text" class="form-control" name="name_in_bank" value="{{$row->my_vendor->name_in_bank }}" required @if(filled($row->my_vendor->name_in_bank)) disabled @endif>
                @error('name_in_bank')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <div class="invalid-feedback">
                    @lang('translation.please_enter_name_in_bank')
                </div>
            </div>
        </div>


        <div class="col-md-6 mb-3">
            <label for="tax_num" class="form-label">@lang('translation.tax_num') <span
                    class="text-danger">*</span></label>
            <input type="number" class="form-control @error('tax_num') is-invalid @enderror"
                   name="tax_num" value="{{ old('tax_num',$row->my_vendor->tax_num) }}" id="tax_num"
                   placeholder="@lang('translation.tax_num_placeholder')" required >
            @error('tax_num')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="invalid-feedback">
                @lang('translation.please_enter_ipan')
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="inputAddress2d" class="form-label">@lang('admin.commercial_registration_no')</label>
            <input   type="text" class="form-control" name="commercial_registration_no" value="{{ $row->my_vendor->commercial_registration_no }}">
        </div>
        <div class="col-md-6 mb-3">
            <label for="inputAddress2" class="form-label">@lang('translation.crd_date')</label>
            <input   type="date" class="form-control" name="crd" value="{{ date('Y-m-d', strtotime($row->my_vendor->crd)) }}">
        </div>


        <div class="row justify-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <label for="username" class="form-label">@lang('translation.logo') <span
                                class="text-danger">*</span></label>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                            <img
                                src="@if ($row->my_vendor->logo != '') {{ ossStorageUrl($row->my_vendor->logo) }}@else{{ URL::asset('assets/images/users/avatar-1.jpg') }} @endif"
                                class="rounded-circle avatar-xl img-thumbnail store-profile-image"
                                alt="user-profile-image" style="width: 244px;height: 202px;">
                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                <input id="profile-img-file-input-store" name="logo" style="display:none;" type="file"
                                       class="profile-img-file-input-store"
                                       onchange="showImage('profile-img-file-input-store','store-profile-image')">
                                <label for="profile-img-file-input-store" class="profile-photo-edit avatar-xs">
                                    <span class="avatar-title rounded-circle bg-light text-body">
                                        <i class="ri-camera-fill"></i>
                                    </span>
                                </label>
                            </div>
                        </div>
                        @if($errors->has('logo'))
                            <div class="invalid-tooltip" style="display:block;width: 100%">
                                {{$errors->first('logo')}}
                            </div>
                        @endif
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>

{{--            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">@lang('translation.broc')</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <p class="text-muted"></p>
                        <input type="file" id="broc" class="filepond filepond-input" name="broc"
                               data-allow-reorder="true" data-max-file-size="3MB" data-max-files="3">
                    </div>

                    @if($row->my_vendor->broc)
                        <a href="{{ URL::asset($row->my_vendor->broc) }}" target="_blank"
                           class="btn btn-secondary btn-sm"><i
                                class="ri-download-2-fill align-middle me-1"></i>@lang('admin.Showing')</a>
                    @endif
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>--}}
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">@lang('translation.cr')</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <label for="username" class="form-label">@lang('translation.crd') <span
                                class="text-danger">*</span></label>
                        {{--                    <input type="date" class="form-control flatpickr-input active" name="crd" data-provider="flatpickr" value="{{ old('crd',\Carbon\Carbon::parse($row->my_vendor->crd)->toDateString()) }}" data-date-format="d.m.y"  >--}}
                        @error('crd')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <div class="invalid-feedback">
                            @lang('translation.please_enter_crd')
                        </div>
                        <p class="text-muted"></p>
                        <input type="file" id="cr" class="filepond filepond-input" name="cr"
                               data-allow-reorder="true" data-max-file-size="3MB" data-max-files="3">
                        @if($errors->has('cr'))
                            <div class="invalid-tooltip" style="display:block;width: 100%">
                                {{$errors->first('cr')}}
                            </div>
                        @endif
                    </div>
                    @if($row->my_vendor->cr)
                        <a href="{{ ossStorageUrl($row->my_vendor->cr) }}" target="_blank" class="btn btn-secondary btn-sm"><i
                                class="ri-download-2-fill align-middle me-1"></i>@lang('admin.Showing')</a>
                    @endif

                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div> <!-- end col -->
        </div>



        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">@lang('translation.tax_certificate')</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    {{--                    <label for="username" class="form-label">@lang('translation.tax_num') <span--}}
                    {{--                    class="text-danger">*</span></label>--}}
                    {{--                    <input type="number" class="form-control @error('tax_num') is-invalid @enderror"--}}
                    {{--                        name="tax_num" value="{{ old('tax_num',$row->my_vendor->tax_num) }}" id="tax_num"--}}
                    {{--                        placeholder="@lang('translation.tax_num_placeholder')" required >--}}
                    @error('tax_num')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="invalid-feedback">
                        @lang('translation.please_enter_tax_num')
                    </div>
                    <p class="text-muted"></p>
                    <input type="file" id="tax_certificate" class="filepond filepond-input" name="tax_certificate"
                           data-allow-reorder="true" data-max-file-size="3MB" data-max-files="3">
                    @if($errors->has('tax_certificate'))
                        <div class="invalid-tooltip" style="display:block;width: 100%">
                            {{$errors->first('tax_certificate')}}
                        </div>
                    @endif
                </div>

                @if($row->my_vendor->tax_certificate)
                    <a href="{{ ossStorageUrl($row->my_vendor->tax_certificate) }}" target="_blank"
                       class="btn btn-secondary btn-sm"><i
                            class="ri-download-2-fill align-middle me-1"></i>@lang('admin.Showing')</a>
                @endif
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">@lang('admin.vendor_iban_certificate')</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    @error('ipan')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="invalid-feedback">
                        @lang('admin.vendor_iban')<
                    </div>
                    <p class="text-muted"></p>
                    <input type="file" id="iban_certificate" class="filepond filepond-input" name="iban_certificate"
                           data-allow-reorder="true" data-max-file-size="3MB" data-max-files="3">
                    @if($errors->has('iban_certificate'))
                        <div class="invalid-tooltip" style="display:block;width: 100%">
                            {{$errors->first('iban_certificate')}}
                        </div>
                    @endif
                </div>

                @if($row->my_vendor->iban_certificate)
                    <a href="{{ ossStorageUrl($row->my_vendor->iban_certificate) }}" target="_blank"
                       class="btn btn-secondary btn-sm"><i
                            class="ri-download-2-fill align-middle me-1"></i>@lang('admin.Showing')</a>
                @endif
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>


        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">@lang('translation.saudia_certificate')</h4>
                </div><!-- end card header -->
                <div class="card-body">

                    @error('saudia_certificate')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="invalid-feedback">
                        @lang('translation.saudia_certificate')
                    </div>
                    <p class="text-muted"></p>
                    <input type="file" id="saudia_certificate" class="filepond filepond-input" name="saudia_certificate"
                           data-allow-reorder="true" data-max-file-size="3MB" data-max-files="3">
                    @if($errors->has('saudia_certificate'))
                        <div class="invalid-tooltip" style="display:block;width: 100%">
                            {{$errors->first('saudia_certificate')}}
                        </div>
                    @endif
                </div>
                @if($row->my_vendor->saudia_certificate)
                    <a href="{{ ossStorageUrl($row->my_vendor->saudia_certificate) }}" target="_blank"
                       class="btn btn-secondary btn-sm"><i
                            class="ri-download-2-fill align-middle me-1"></i>@lang('admin.Showing')</a>
                @endif
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div> <!-- end col -->


        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">@lang('translation.subscription_certificate')</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    @error('subscription_certificate')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="invalid-feedback">
                        @lang('translation.subscription_certificate')
                    </div>
                    <p class="text-muted"></p>
                    <input type="file" id="subscription_certificate" class="filepond filepond-input"
                           name="subscription_certificate"
                           data-allow-reorder="true" data-max-file-size="3MB" data-max-files="3">
                    @if($errors->has('subscription_certificate'))
                        <div class="invalid-tooltip" style="display:block;width: 100%">
                            {{$errors->first('subscription_certificate')}}
                        </div>
                    @endif
                </div>

                @if($row->my_vendor->subscription_certificate)
                    <a href="{{ ossStorageUrl($row->my_vendor->subscription_certificate) }}" target="_blank"
                       class="btn btn-secondary btn-sm"><i
                            class="ri-download-2-fill align-middle me-1"></i>@lang('admin.Showing')</a>
                @endif
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div> <!-- end col -->

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">@lang('translation.room_certificate')</h4>
                </div><!-- end card header -->

                <div class="card-body">

                    @error('room_certificate')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="invalid-feedback">
                        @lang('translation.room_certificate')
                    </div>
                    <p class="text-muted"></p>
                    <input type="file" id="room_certificate" class="filepond filepond-input" name="room_certificate"
                           data-allow-reorder="true" data-max-file-size="3MB" data-max-files="3">
                    @if($errors->has('room_certificate'))
                        <div class="invalid-tooltip" style="display:block;width: 100%">
                            {{$errors->first('room_certificate')}}
                        </div>
                    @endif
                </div>
                @if($row->my_vendor->room_certificate)
                    <a href="{{ ossStorageUrl($row->my_vendor->room_certificate) }}" target="_blank"
                       class="btn btn-secondary btn-sm"><i
                            class="ri-download-2-fill align-middle me-1"></i>@lang('admin.Showing')</a>
                @endif
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div> <!-- end col -->


        <div class="col-lg-12">
            <div class="hstack gap-2 justify-content-end">
                <button type="submit" class="btn btn-primary">@lang('translation.update')</button>
                <button type="button" class="btn btn-soft-secondary">@lang('translation.cancel')</button>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
</form>
