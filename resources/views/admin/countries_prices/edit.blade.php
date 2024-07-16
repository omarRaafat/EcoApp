@extends('admin.layouts.master')
@section('title')
    @lang('admin.countries_prices.title')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-body">
                    <form action="{{ route('admin.products.prices.update',['id' => $countryPrice->id]) }}" method="post" class="form-steps"autocomplete="on">
                        @csrf
                        @method('put')
                        <input name="product_id" type="hidden" value="{{ $countryPrice->product_id }}">
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">@lang('admin.countries_prices.country')</label>

                            <select class="form-select mb-3 @error('country_id') is-invalid @enderror" aria-label="Default select example" name="country_id">
                                <option value="">@lang('admin.select')</option>
                                @foreach($availableCountry As $country)
                                    <option @selected($country->id == $countryPrice->country_id)
                                        value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                                @error('country_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">@lang('translation.price') @lang('translation.sar')</label>
                            <input value="{{ $countryPrice->priceInSar }}"
                                type="text" step=".01" min="0.01"
                                oninput="validatePrice(this)"
                                name="price_with_vat"
                                placeholder="@lang('translation.price_placeholder')"
                                class="form-control @error('price_with_vat') is-invalid @enderror"
                                aria-label="Price" aria-describedby="product-price-addon">
                            @error('price_with_vat')
                            <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">@lang('translation.price_before_offer') @lang('translation.sar')</label>
                            <input value="{{ $countryPrice->priceBeforeInSar }}"
                                type="text" step=".01" min="0.01"
                                oninput="validatePrice(this)"
                                name="price_before_offer_in_halala"
                                placeholder="@lang('translation.price_before_offer_placeholder')"
                                class="form-control @error('price_before_offer_in_halala') is-invalid @enderror"
                                aria-label="Price" aria-describedby="product-price-addon">
                            @error('price_before_offer_in_halala')
                            <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
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
@endsection
@section('script-bottom')
    <script>
        var validatePrice = function(e) {
            var t = e.value;
            e.value = (t.indexOf(".") >= 0) ? (t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 3)) : t;
        }
    </script>
@endsection
