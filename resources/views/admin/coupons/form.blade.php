<div class="row">
    {{-- <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label" for="title_ar">@lang('admin.coupons.title_ar')</label>
            <input type="text" name="title_ar" class="form-control"
                value="{{ isset($coupon) ? $coupon->getTranslation('title', 'ar') : old("title_ar") }}"
                id="name_ar" placeholder="{{ trans('admin.coupons.title_ar') }}">
            @error('title_ar')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label" for="title_en">@lang('admin.coupons.title_en')</label>
            <input type="text" name="title_en" class="form-control"
                value="{{ isset($coupon) ? $coupon->getTranslation('title', 'en') : old("title_en") }}"
                id="title_en" placeholder="{{ trans('admin.coupons.title_en') }}">
            @error('title_en')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div> --}}
    @foreach(config('app.locales') AS $locale)
    <div class="col-md-6 mb-3">
        <label for="username" class="form-label">@lang('admin.coupons_title') -@lang('language.'.$locale)
            <span class="text-danger">*</span>
        </label>
        <input type="text" class="form-control @error('title.' . $locale) is-invalid @enderror" name="title[{{ $locale }}]"
        value="{{  isset($coupon) ? $coupon->getTranslation('title',$locale) : old('title.'.$locale)}}"
        id="certificate_title">
        @error('title.' . $locale)
        <span class="invalid-feedback" role="alert">
            <strong>
                {{$message}} @lang('language.'.$locale)
            </strong>
        </span>
        @enderror

    </div>
    @endforeach
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label" for="code">@lang('admin.coupons.code')</label>
            <input type="text" name="code" class="form-control"
                value="{{ isset($coupon) ? $coupon->code : old("code") }}" id="code" placeholder="{{ trans('admin.coupons.code') }}">
            @error('code')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label" for="status">@lang('admin.coupons.coupon_type')</label>
            <select onchange="handle_coupon_type(this);" class="select2 form-control" name="coupon_type" id="select2_coupon_type">
                <option selected value=""> @lang("admin.coupons.coupon_type")</option>
                @foreach ($couponTypes as $couponType)
                <option @selected((isset($coupon) ? $coupon->coupon_type : old('coupon_type')) == $couponType["value"])
                    value="{{ $couponType["value"] }}">{{ $couponType["name"] }}</option>
                @endforeach
            </select>
            @error('coupon_type')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label" for="start_at">@lang('admin.coupons.start_at')</label>
            <input value="{{ isset($coupon) ? $coupon->start_at?->format("Y-m-d") : old('start_at') }}"
                name="start_at" type="text" class="form-control flatpickr-input active"
                data-provider="flatpickr"  data-minDate="today" data-date-format="Y-m-d" placeholder="@lang('admin.from')">
            @error('start_at')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label" for="expire_at">@lang('admin.coupons.expire_at')</label>
            <input value="{{ isset($coupon) ? $coupon->expire_at?->format("Y-m-d") : old('expire_at') }}"
                name="expire_at" type="text" class="form-control flatpickr-input active"
                data-provider="flatpickr"  data-minDate="today" data-date-format="Y-m-d" placeholder="@lang('admin.to')">
            @error('expire_at')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label" for="discount_type">@lang('admin.coupons.discount_type')</label>
            <select class="select2 form-control" name="discount_type" id="select2_discount_type">
                <option selected value="">@lang("admin.coupons.discount_type")</option>
                @foreach ($discountTypes as $type)
                    <option @selected((isset($coupon) ? $coupon->discount_type : old('discount_type')) == $type["value"])
                        value="{{ $type["value"] }}">{{ $type["name"] }}</option>
                @endforeach
            </select>
            @error('discount_type')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label" for="amount">@lang('admin.coupons.amount')</label>
            <input min="1" step="0.01" name="amount" class="form-control"
                value="{{ isset($coupon) ? $coupon->amount : old("amount") }}" id="amount" placeholder="{{ trans('admin.coupons.amount') }}">
            @error('amount')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label" for="minimum_order_amount">@lang('admin.coupons.minimum_order_amount')</label>
            <input min="1" step="0.01" name="minimum_order_amount" class="form-control"
                value="{{ isset($coupon) ? $coupon->minimum_order_amount : old("minimum_order_amount") }}"
                id="minimum_order_amount" placeholder="{{ trans('admin.coupons.minimum_order_amount') }}">
            @error('minimum_order_amount')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-lg-6 percentage-fields"
        style="display:{{ (isset($coupon) ? $coupon->discount_type : old('discount_type')) == \App\Enums\CouponDiscountType::PERCENTAGE ? 'block' : 'none' }}">
        <div class="mb-3">
            <label class="form-label" for="maximum_discount_amount">@lang('admin.coupons.maximum_discount_amount')</label>
            <input min="1" step="0.01" name="maximum_discount_amount" class="form-control"
                value="{{ isset($coupon) ? $coupon->maximum_discount_amount : old("maximum_discount_amount") }}"
                id="maximum_discount_amount" placeholder="{{ trans('admin.coupons.maximum_discount_amount') }}">
            @error('maximum_discount_amount')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6" id="couponVendors" @if(old('coupon_type') != 'vendor') style="display: none;" @endif >
        <div class="mb-3">
            <label class="form-label" for="vendors">@lang('admin.vendor_name')</label>
            <select class="form-control" name="vendors[]" id="vendors" data-choices data-choices-removeItem multiple>
                <option value="">@lang('admin.select')</option>
                @foreach($vendors AS $vendor)
                    <option value="{{ $vendor->id }}">{{ $vendor->vendorName }}</option>
                @endforeach
            </select>
            @error('vendors')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-lg-6" id="couponProducts" @if(old('coupon_type') != 'product') style="display: none;" @endif >
        <div class="mb-3">
            <label class="form-label" for="products">@lang('admin.products.title')</label>
            <select class="form-control" name="products[]" id="couponProductsSelect" multiple="multiple">
                {{--@foreach($products AS $product)
                    <option value="{{ $product->id }}">{{ $product->productName }}</option>
                @endforeach--}}
            </select>
            @error('products')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label" for="maximum_redemptions_per_user">@lang('admin.coupons.maximum_redemptions_per_user')</label>
            <input min="0" name="maximum_redemptions_per_user" class="form-control"
                value="{{ isset($coupon) ? $coupon->maximum_redemptions_per_user : old("maximum_redemptions_per_user") }}"
                id="maximum_redemptions_per_user" placeholder="{{ trans('admin.coupons.maximum_redemptions_per_user') }}">
            @error('maximum_redemptions_per_user')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label" for="maximum_redemptions_per_coupon">@lang('admin.coupons.maximum_redemptions_per_coupon')</label>
            <input min="0" name="maximum_redemptions_per_coupon" class="form-control"
                value="{{ isset($coupon) ? $coupon->maximum_redemptions_per_coupon : old("maximum_redemptions_per_coupon") }}"
                id="maximum_redemptions_per_coupon" placeholder="{{ trans('admin.coupons.maximum_redemptions_per_coupon') }}">
            @error('maximum_redemptions_per_coupon')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
