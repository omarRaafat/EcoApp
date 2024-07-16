@extends('admin.layouts.master')
@section('title')
    @lang("admin.coupons.show")
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="mb-3">
                            <div class="form-check">
                                <select onchange="couponChangeStatus('{{ $coupon->id }}',this)"  class="form-select mb-3">
                                    @foreach(\App\Enums\CouponStatus::getStatusList() As $status_value => $status_title)
                                        <option @if($status_value == $coupon->status) selected @endif value="{{ $status_value }}">{{ $status_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body ">
                <form class="form-steps">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        @foreach(config('app.locales') AS $locale)

                        <div class="col-md-6 mb-6">

                                <label class="form-label" for="code">@lang('admin.coupons.title')-@lang('language.'.$locale)</label>
                                <input disabled readonly type="text" name="title" class="form-control" id="code" value="{{ old('desc.'.$locale) ?? $coupon->getTranslation('title', $locale)}}" placeholder="{{ trans('admin.coupons.title') }}">
                                @error('title.'.$locale)
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>

                        @endforeach


                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="code">@lang('admin.coupons.code')</label>
                                <input disabled readonly type="text" name="code" class="form-control" id="code" value="{{ $coupon->code }}" placeholder="{{ trans('admin.coupons.code') }}">
                                @error('code')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="amount">@lang('admin.coupons.amount')</label>
                                <input disabled readonly type="number" min="1" step="1" name="amount" class="form-control" value="{{ $coupon->amount }}" id="amount" placeholder="{{ trans('admin.coupons.amount') }}">
                                @error('amount')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="minimum_order_amount">@lang('admin.coupons.minimum_order_amount')</label>
                                <input disabled readonly type="number" min="1" step="1" name="minimum_order_amount" class="form-control" value="{{ $coupon->minimum_order_amount }}" id="minimum_order_amount" placeholder="{{ trans('admin.coupons.minimum_order_amount') }}">
                                @error('minimum_order_amount')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="maximum_discount_amount">@lang('admin.coupons.maximum_discount_amount')</label>
                                <input disabled readonly type="number" min="1" step="1" name="maximum_discount_amount" class="form-control" value="{{ $coupon->maximum_discount_amount }}" id="maximum_discount_amount" placeholder="{{ trans('admin.coupons.maximum_discount_amount') }}">
                                @error('maximum_discount_amount')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="discount_type">@lang('admin.coupons.discount_type')</label>
                                <select disabled readonly class="select2 form-control" name="discount_type" id="select2_discount_type">
                                    @foreach ($discountTypes as $type)
                                        <option @if($coupon->discount_type == $type["value"]) selected @endif value="{{ $type["value"] }}"> {{ $type["name"] }} </option>
                                    @endforeach
                                </select>
                                @error('discount_type')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="coupon_type">@lang('admin.coupons.coupon_type')</label>
                                <select disabled readonly onchange="handle_coupon_type(this);" class="select2 form-control" name="coupon_type" id="select2_coupon_type">
                                    @foreach ($couponTypes as $couponType)
                                        <option @if($coupon->coupon_type == $couponType["value"]) selected @endif value="{{ $couponType["value"] }}">{{ $couponType["name"] }}</option>
                                    @endforeach
                                </select>
                                @error('coupon_type')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6" id="couponVendors" @if($coupon->coupon_type != 'vendor') style="display: none;" @endif >
                            <div class="mb-3">
                                <label class="form-label" for="vendors">@lang('admin.vendor_name')</label>
                                <select disabled readonly class="form-control" name="vendors[]" id="vendors" data-choices data-choices-removeItem multiple>
                                    @foreach($vendors AS $vendor)
                                        <option @if($coupon->coupon_type == 'vendor' && in_array($vendor->id,$coupon->CouponMeta->related_ids)) selected @endif value="{{ $vendor->id }}">{{ $vendor->vendorName }}</option>
                                    @endforeach
                                </select>
                                @error('vendors')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6" id="couponProducts" @if($coupon->coupon_type != 'product') style="display: none;" @endif >
                            <div class="mb-3">
                                <label class="form-label" for="products">@lang('admin.products.title')</label>
                                <select disabled readonly class="form-control" name="products[]" id="couponProductsSelect" multiple="multiple">
                                    @foreach($products AS $product)
                                        <option value="{{ $product->id }}" selected>{{ $product->productName }}</option>
                                    @endforeach
                                </select>
                                @error('products')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="maximum_redemptions_per_user">@lang('admin.coupons.maximum_redemptions_per_user')</label>
                                <input disabled readonly type="number" min="0" step="1" name="maximum_redemptions_per_user" class="form-control" value="{{ $coupon->maximum_redemptions_per_user }}" id="maximum_redemptions_per_user" placeholder="{{ trans('admin.coupons.maximum_redemptions_per_user') }}">
                                @error('maximum_redemptions_per_user')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="maximum_redemptions_per_coupon">@lang('admin.coupons.maximum_redemptions_per_coupon')</label>
                                <input disabled readonly type="text" min="0" step="1" name="maximum_redemptions_per_coupon" class="form-control" value="{{ $coupon->maximum_redemptions_per_coupon }}" id="maximum_redemptions_per_coupon" placeholder="{{ trans('admin.coupons.maximum_redemptions_per_coupon') }}">
                                @error('maximum_redemptions_per_coupon')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="start_at">@lang('admin.coupons.start_at')</label>
                                <input disabled readonly value="{{ $coupon->start_at }}" name="start_at" type="text" class="form-control flatpickr-input active" data-provider="flatpickr"  data-minDate="today" data-date-format="Y-m-d" placeholder="@lang('admin.from')">
                                @error('start_at')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="expire_at">@lang('admin.coupons.expire_at')</label>
                                <input disabled readonly value="{{ $coupon->expire_at }}" name="expire_at" type="text" class="form-control flatpickr-input active" data-provider="flatpickr"  data-minDate="today" data-date-format="Y-m-d" placeholder="@lang('admin.to')">
                                @error('expire_at')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="d-flex align-items-start gap-3 mt-4">
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-success btn-label right ms-auto nexttab nexttab">
            <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
            @lang('admin.coupons.list')
    </a>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
@section('script-bottom')
    <script>
        function couponChangeStatus(couponId, item)
        {
            let value = $(item).val();
            $.post("{{ URL::asset('/admin') }}/coupons/status/" + couponId, {
                id: couponId,
                selected: value,
                "_token": "{{ csrf_token() }}"
            }, function (data)
            {
                if (data.status == 'success')
                {
                    Swal.fire({
                        html: '<div class="mt-3">' +
                            '<div class="mt-4 pt-2 fs-15">' +
                            '<h4>' + data.message + '</h4>' +
                            '</div>' +
                            '</div>',
                        showCancelButton: true,
                        showConfirmButton: false,
                        cancelButtonClass: 'btn btn-primary w-xs mb-1',
                        cancelButtonText: '@lang('admin.back')',
                        buttonsStyling: false,
                        showCloseButton: true
                    });
                }
            }, "json");
        }
    </script>
@endsection
