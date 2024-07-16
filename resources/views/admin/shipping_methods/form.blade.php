<div class="row">
    <div class="col-lg-12">
        <div>
            <label for="formFile" class="form-label">@lang('admin.shippingMethods.logo')</label>
            <input class="form-control" name="logo" type="file" id="formFile">
            @error('logo')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
<!-- Name Arabic & English -->
<div class="row" style="margin-top: 10px;">
    @foreach(config('app.locales') AS $locale)
        <div class="col-lg-6 mb-10">
            <div class="mb-3">
                <label class="form-label" for="name_ar">@lang('admin.shippingMethods.name') -@lang('language.'.$locale)</label>
                <input type="text" class="form-control @error('name.'.$locale) is-invalid @enderror"
                    name="name[{{ $locale }}]"
                    value="{{ isset($shippingMethod) ? $shippingMethod->getTranslation("name", $locale) : old("name.$locale") }}"
                    id="category_name">
                @error('name.' . $locale)
                    <span class="invalid-feedback" role="alert">
                        <strong> {{$message}} </strong>
                    </span>
                @enderror
            </div>
        </div>
    @endforeach
</div>
<div class="row" style="margin-top : 10px;">
    <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label" for="cod_collect_fees">@lang('admin.shippingMethods.cod_collect_fees')  @lang('translation.sar')</label>
            <input type="text"
                name="cod_collect_fees"
                class="form-control"
                value="{{ isset($shippingMethod) ? $shippingMethod->cod_collect_fees : old("cod_collect_fees") }}"
                id="cod_collect_fees"
                placeholder="{{ trans('admin.shippingMethods.cod_collect_fees') }}  @lang('translation.sar')"
                step=".01">
            @error('cod_collect_fees')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label" for="integration_key">@lang('admin.shippingMethods.integration_key')</label>
            <select class="select2 form-control" name="integration_key" id="select2_is_active">
                <option selected value="">
                    @lang("admin.shippingMethods.choose_key")
                </option>
                @foreach ($integrationKeys as $key => $integrationKey)
                    <option value="{{$key}}" @selected((isset($shippingMethod) ? $shippingMethod->integration_key : old('integration_key')) == $key)>
                        {{ $integrationKey }}
                    </option>
                @endforeach
            </select>
            @error('integration_key')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label" for="integration_key">@lang('admin.shipping_type')</label>
            <select class="select2 form-control" name="type" id="select2_is_active">
                <option selected value="">
                    @lang("admin.shippingMethods.choose_type")
                </option>
                @foreach ($shipping_types as $key => $type)
                    <option value="{{$key}}" @selected((isset($shippingMethod) ? $shippingMethod->type : old('type')) == $key)>
                        {{ $type }}
                    </option>
                @endforeach
            </select>
            @error('type')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <label class="form-label" for="is_active">@lang('admin.categories.is_active')</label>
        <div class="form-check form-switch form-switch-lg" dir="ltr">
            <input type="checkbox" name="is_active" class="form-check-input" {{isset($shippingMethod) &&  $shippingMethod->is_active == true ? 'checked' : ''}}>
        </div>
        @error('is_active')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>
