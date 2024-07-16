<form action="{{route('vendor.update-profile')}}" class="needs-validation was-validated" method="POST" id="profile-form" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-6">
            <div class="mb-3 position-relative">
                <label for="firstnameInput" class="form-label">@lang('translation.name')</label>
                <div class="input-group has-validation">
                    <input type="text" disabled="disabled" readonly  class="form-control @if($errors->has('name'))invalid-input @endif" name="name" id="firstnameInput" aria-describedby="inputGroupPrepend" placeholder="@lang('translation.name_placeholder')" value="{{$row->name}}" required>
                    @if($errors->has('name'))
                    <div class="invalid-tooltip" style="display:inline;">
                        {{$errors->first('name')}}
                    </div>
                    @else
                    <div class="invalid-feedback">
                        @lang('translation.name_required')
                    </div>
                    @endif
                </div>

            </div>
        </div>
        <!--end col-->
        {{-- <div class="col-lg-6">
            <div class="mb-3">
                <label for="countryInput" class="form-label">@lang('translation.country')</label>

                <select class="form-control" id="choices-single-no-sorting" name="country_id" data-choices data-choices-sorting-false
                >
                    <option disabled>@lang('translation.select_country')</option>

                    @foreach($countries as $country)
                    <option value="{{$country->id}}" @if($country->id==$row->country_id) selected @endif>{{$country->name}}</option>
                    @endforeach
                </select>
                @if($errors->has('country_id'))
                <div class="invalid-tooltip" style="display:inline;">
                    {{$errors->first('country_id')}}
                </div>
                @else
                <div class="invalid-feedback">
                    @lang('translation.country_required')
                </div>
                @endif
            </div>
        </div> --}}
        <!--end col-->
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="phonenumberInput" class="form-label">@lang('translation.phone')</label>
                <div class="input-group has-validation">
{{--                    {{ dd($row->phone)  }}--}}
                    <input type="text" disabled="disabled" readonly  class="form-control @if($errors->has('phone'))invalid-input @endif" name="phone" id="phonenumberInput" aria-describedby="inputGroupPrepend"
                    placeholder="@lang('translation.phone_placeholder')" value="{{ explode("+966", $row->phone)[1] }}" required>
                    @if($errors->has('phone'))
                    <div class="invalid-tooltip" style="display:inline;">
                        {{$errors->first('phone')}}
                    </div>
                    @else
                    <div class="invalid-feedback">
                        @lang('translation.phone_required')
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!--end col-->
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="emailInput" class="form-label">@lang('translation.email')</label>

                <!-- <div class="input-group has-validation"> -->
                    <input type="email" disabled="disabled" readonly  class="form-control @if($errors->has('email'))invalid-input @endif" name="email" id="emailInput" aria-describedby="inputGroupPrepend" placeholder="@lang('translation.email_placeholder')" value="{{$row->email}}" required>
                    @if($errors->has('email'))
                    <div class="invalid-feedback" style="display:inline;">
                        {{$errors->first('email')}}
                    </div>
                    @else
                    <div class="invalid-feedback">
                        @lang('translation.email_required')
                    </div>
                    @endif
                <!-- </div> -->
            </div>
        </div>

        <div class="col-lg-12">
            <div class="hstack gap-2 justify-content-end">
                <button type="submit" class="btn btn-primary">@lang('translation.update')</button>
                <button type="button" class="btn btn-soft-secondary">@lang('translation.close')</button>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
</form>
