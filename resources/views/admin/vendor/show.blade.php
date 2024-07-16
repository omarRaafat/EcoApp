@extends('admin.layouts.master')
@section('title') @lang('admin.vendors_show') @endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('admin.vendors-agreements.index', ['vendor' => $vendor->id]) }}"
                        class="btn btn-light fs-15">
                        @lang('admin.show-vendor-agreements')
                    </a>
                </div>
                <div class="card-body">
                    <form action="javascript:void(0);" class="row g-3">

                        @foreach(config('app.locales') AS $locale)
                        <div class="col-md-6">

                            <label for="username" class="form-label">@lang("translation.vendor_owner_store_name"){{---@lang('language.'.$locale)--}}
                                <span class="text-danger">*</span>
                            </label>
                            <input disabled="disabled" type="text" class="form-control @error('name.'.$locale) is-invalid @enderror" name="name[{{ $locale }}]"

                            value="{{ old('name.'.$locale) ?? $vendor->owner->name}}"
                            id="store_name" required>
                            @error('name.' . $locale)
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        @endforeach



                        {{-- @foreach(config('app.locales') AS $locale) --}}
                            <div class="col-md-6">
                                <label for="username" class="form-label">@lang('translation.company_vendor__name')</label>
                                <input disabled="disabled" readonly type="text" class="form-control" value="{{$vendor->name}}">
                            </div>
                        {{-- @endforeach --}}

                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">@lang('admin.vendor_phone')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" name="street" value="{{ $vendor->owner->phone }}" id="street">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">@lang('admin.vendor_second_phone')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" name="street" value="{{ $vendor->second_phone }}" id="street">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">@lang('admin.email')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" name="street" value="{{ $vendor->owner->email }}" id="street">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">@lang('admin.vendor_website')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" name="street" value="{{ $vendor->website }}" id="street">
                        </div>


                        @foreach(config('app.locales') AS $locale)
                        <div class="col-md-6">
                            <label for="username" class="form-label">@lang('admin.vendor_description'){{---@lang('language.'.$locale)--}}
                                <span class="text-danger">*</span>
                            </label>
                            <textarea disabled="disabled" readonly class="form-control" name="desc" > {{ old('desc.'.$locale) ?? $vendor->getTranslation('desc',$locale)}}</textarea>

                        </div>
                    @endforeach

                        {{-- <div class="col-md-6">
                            <label for="username" class="form-label">@lang('admin.vendor_description')</label>
                            <textarea disabled="disabled" readonly class="form-control" name="desc" rows="3">{{ $vendor->desc}}</textarea>
                        </div> --}}

                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">@lang('admin.vendor_address')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" name="street" value="{{ $vendor->street }}" id="street">
                        </div>
                        <div class="col-md-6">
                            <label for="inputAddress2" class="form-label">@lang('admin.vendor_bank')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" value="{{ $vendor->bank?->name }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="inputAddress2" class="form-label">@lang('admin.vendor_bank_number')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" value="{{ $vendor->bank_num }}">
                        </div>
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">@lang('admin.vendor_iban') <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-text">SA</div>
                                    <input disabled="disabled" readonly type="text" class="form-control" value="{{substr($vendor->ipan, 0, 2) == 'SA' ? str_replace('SA','',$vendor->ipan):$vendor->ipan }}" >

                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">@lang('admin.name_in_bank') <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input disabled="disabled" readonly type="text" class="form-control" value="{{$vendor->name_in_bank }}" >
                                </div>
                            </div>

                        <div class="col-md-6 mb-3">
                            <label for="inputAddress2" class="form-label">@lang('admin.commercial_registration_no')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" value="{{ $vendor->commercial_registration_no }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="inputAddress2" class="form-label">@lang('admin.vendor_tax_number')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" value="{{ $vendor->tax_num }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="inputAddress2" class="form-label">@lang('admin.vendor_commercial_register_date')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" @if(!empty($vendor->crd)) value="{{Alkoumi\LaravelHijriDate\Hijri::Date('Y-m-d',$vendor->crd)}}" @endif>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">@lang('admin.vendor_commission')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" value="{{ $vendor->commission }}">
                        </div>
                        {{--
                        <div class="col-md-6 mb-3">
                            <label for="inputAddress2" class="form-label">@lang("admin.beez_id")</label>
                            <input disabled="disabled" readonly type="text" class="form-control" value="{{ $vendor->beezConfig ? $vendor->beezConfig->beez_id : trans("admin.not_found") }}">
                        </div>--}}
                        {{--
                        <div class="col-md-6 mb-3">
                            <label for="inputAddress2" class="form-label">@lang('admin.vendor_is_international')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" value="@if($vendor->is_international == 1) @lang('admin.yes') @else @lang('admin.no') @endif">
                        </div>--}}


                        <div class="col-md-6 mb-3">
                            <label for="inputAddress2" class="form-label">@lang('admin.vendor_logo')</label>
                            <div class="d-flex align-items-center mt-4">
                                <div class="flex-shrink-0">
                                    <a href="{{ ossStorageUrl($vendor->logo) }}" target="_blank" class="btn btn-info btn-sm"><i class="ri-download-2-fill align-middle me-1"></i>@lang('admin.Showing')</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="inputAddress2" class="form-label">@lang('admin.vendor_commercial_register')</label>
                            <div class="d-flex align-items-center mt-4">
                                <div class="flex-shrink-0">
                                    <a href="{{ ossStorageUrl($vendor->cr) }}" target="_blank" class="btn btn-info btn-sm"><i class="ri-download-2-fill align-middle me-1"></i>@lang('admin.Showing')</a>
                                </div>
                            </div>
                        </div>
                        {{--<div class="col-md-6 mb-3">
                            <label for="inputAddress2" class="form-label">@lang('admin.vendor_broc')</label>
                            <div class="d-flex align-items-center mt-4">
                                @if($vendor->broc)

                                <div class="flex-shrink-0">
                                    <a href="{{ URL::asset($vendor->broc) }}" target="_blank" class="btn btn-info btn-sm"><i class="ri-download-2-fill align-middle me-1"></i>@lang('admin.Showing')</a>
                                </div>

                                @else
                                    لا يوجد
                                @endif
                            </div>
                        </div>--}}
                        <div class="col-md-6 mb-3">
                            <label for="inputAddress2" class="form-label">@lang('admin.vendor_tax_certificate')</label>
                            <div class="d-flex align-items-center mt-4">
                                @if($vendor->tax_certificate)

                                <div class="flex-shrink-0">
                                    <a href="{{ ossStorageUrl($vendor->tax_certificate) }}" target="_blank" class="btn btn-info btn-sm"><i class="ri-download-2-fill align-middle me-1"></i>@lang('admin.Showing')</a>
                                </div>

                                @else
                                    لا يوجد
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="inputAddress2" class="form-label">@lang('admin.vendor_iban_certificate')</label>
                            <div class="d-flex align-items-center mt-4">
                                @if($vendor->iban_certificate)
                                <div class="flex-shrink-0">
                                    <a href="{{ ossStorageUrl($vendor->iban_certificate) }}" target="_blank" class="btn btn-info btn-sm"><i class="ri-download-2-fill align-middle me-1"></i>@lang('admin.Showing')</a>
                                </div>
                                @else
                                    لا يوجد
                                @endif
                            </div>
                        </div>


                            <div class="col-md-6 mb-3">
                                <label for="inputAddress2" class="form-label">@lang('translation.saudia_certificate')</label>
                                <div class="d-flex align-items-center mt-4">
                                    @if($vendor->saudia_certificate)
                                    <div class="flex-shrink-0">
                                        <a href="{{ ossStorageUrl($vendor->saudia_certificate) }}" target="_blank" class="btn btn-info btn-sm"><i class="ri-download-2-fill align-middle me-1"></i>@lang('admin.Showing')</a>
                                    </div>
                                    @else
                                        لا يوجد
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="inputAddress2" class="form-label">@lang('translation.subscription_certificate')</label>
                                <div class="d-flex align-items-center mt-4">
                                    @if($vendor->subscription_certificate)

                                    <div class="flex-shrink-0">
                                        <a href="{{ ossStorageUrl($vendor->subscription_certificate) }}" target="_blank" class="btn btn-info btn-sm"><i class="ri-download-2-fill align-middle me-1"></i>@lang('admin.Showing')</a>
                                    </div>
                                    @else
                                        لا يوجد
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="inputAddress2" class="form-label">@lang('translation.room_certificate')</label>
                                <div class="d-flex align-items-center mt-4">
                                    @if($vendor->room_certificate)
                                    <div class="flex-shrink-0">
                                        <a href="{{ ossStorageUrl($vendor->room_certificate) }}" target="_blank" class="btn btn-info btn-sm"><i class="ri-download-2-fill align-middle me-1"></i>@lang('admin.Showing')</a>
                                    </div>
                                    @else
                                    لا يوجد
                                    @endif
                                </div>
                            </div>

                    </form>
                </div>
            </div>
            <br>
            <div class="card mt-5">
                <div class="card-header">
                    طلباته
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <th>@lang('translation.order_id')</th>
                            <th>@lang('translation.customer')</th>
                            <th>@lang('translation.products')</th>
                            <th>@lang('admin.payment_method')</th>
                            <th>@lang('admin.shipping_to')</th>
                            <th>@lang('translation.order_date')</th>
                            <th>@lang('translation.order_status')</th>
                            <th>@lang('translation.shipping_method')</th>
                            <th>@lang('translation.shipping_type')</th>
                            <th>@lang('translation.track_order')</th>
                        </thead>
                        <tbody>
                            @forelse($orders as $transaction)
                            <tr>
                                <td>{{ $transaction->code }}</td>
                                <td>
                                    {{--<a data-bs-toggle="modal" data-bs-target="#exampleModalScrollable{{$key}}"
                                       href="#">--}}
                                        {{ $transaction->customer_name ?? null }}
                                    {{--</a>--}}

                                </td>
                                <td>{{ (int)$transaction->num_products }}</td>
                                <td>
                                    @php
                                        $checkWallet = $transaction->wallet_amount;
                                        $checkVisa = $transaction->visa_amount;
                                        $paymentId = $transaction->payment_id ?? null;
                                    @endphp
                                    @if($checkWallet > 0 && $paymentId != 3)
                                        {{ \App\Enums\PaymentMethods::getStatusList()[$paymentId] }}
                                        - {{ \App\Enums\PaymentMethods::getStatus(3) }}
                                    @else
                                        {{ \App\Enums\PaymentMethods::getStatusList()[$paymentId] }}
                                    @endif
                                </td>
                                <td>{{ $transaction->orderVendorShippings[0]->to_city_name?? trans("admin.not_found")}}</td>
                                <td>{{ \Carbon\Carbon::parse($transaction->created_at)->toFormattedDateString() }}</td>
                                <td>
                                    <span class="badge badge-info">{{ \App\Enums\OrderStatus::getStatus($transaction->status) }}</span>
                                </td>
                                <td>
                                    @foreach($transaction->orderVendorShippings()->where('vendor_id' , $vendor->id)->get()->unique('shipping_method_id')->pluck('shipping_method_id') as $trans)
                                        @if($trans == 1)
                                            <span class="badge badge-info">أرامكس</span>
                                        @elseif($trans == 2)
                                            <span class="badge badge-info">سبل</span>
                                        @else
                                            <span class="badge badge-info">استلام بنفسي</span>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($transaction->orderVendorShippings()->where('vendor_id' , $vendor->id)->get()->unique('shipping_type_id')->pluck('shipping_type_id') as $trans)
                                        @if($trans == 1)
                                            <span class="badge badge-info">استلام</span>
                                        @elseif($trans == 2)
                                            <span class="badge badge-info">توصيل</span>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @forelse($transaction->orderVendorShippings()->where('vendor_id' , $vendor->id)->where('shipping_type_id' , 2)->get() as $trans)
                                        @if(!empty($trans->order->orderShip?->gateway_tracking_id))
                                            @if($trans->shipping_method_id == 1)
                                                <a href="{{ env('ARAMEX_TRACKING_URL') . $trans->order->orderShip?->gateway_tracking_id  }}" target="_blank">
                                                    <span class="badge badge-info">@lang('translation.track_aramex' , ['order_code' => $trans->order->orderShip?->gateway_tracking_id])</span>
                                                </a>
                                            @else
                                                <a href="{{ env('SPL_TRACKING_URL') . $trans->order->orderShip?->gateway_tracking_id  }}" target="_blank">
                                                    <span class="badge badge-info">@lang('translation.track_spl' , ['order_code' => $trans->order->orderShip?->gateway_tracking_id])</span>
                                                </a>
                                            @endif
                                        @endif
                                    @empty
                                        <span class="badge badge-info">لا يوجد</span>
                                    @endforelse
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan = "10">
                                    <center>
                                        @lang('admin.statistics.admin.no_orders_found')
                                    </center>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $orders->appends(request()->query())->links()  }}
                </div>
            </div>
            <br>
            <div class="card mt-5">
                <div class="card-header">
                    <span>المستودعات</span>
                </div>
                <div class="card-body">
                    <table class="table table-nowrap align-middle" id="warehousesTable">
                        <thead class="text-muted table-light">
                        <tr class="text-uppercase">
                            <th>@lang('admin.warehouses.id')</th>
                            <th>@lang('admin.warehouse_name')</th>
                            <th>@lang('admin.warehouse_type')</th>
                            <th>@lang('admin.warehouses.administrator_name')</th>
                        </tr>
                        </thead>
                        <tbody class="list form-check-all">
                            @forelse($warehouses as $warehouse)
                                <tr>
                                    <td class="id">
                                        <a href="{{ route("admin.warehouses.show", $warehouse->id) }}"class="fw-medium link-primary">
                                            #{{$warehouse->id}}
                                        </a>
                                    </td>
                                    <td class="name">{{ $warehouse->name }}</td>
                                    <td class="torod_warehouse_name">
                                        @foreach($warehouse->shippingTypes as $shipping_type)
                                            <span class="badge badge-info text-uppercase">
                                                    {{ $shipping_type->title }}
                                                </span>
                                        @endforeach
                                    </td>
                                    <td class="administrator_name">{{ $warehouse->administrator_name }} / {{ $warehouse->administrator_phone }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan = "4">
                                        <center>
                                            @lang('admin.warehouses.not_found')
                                        </center>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
