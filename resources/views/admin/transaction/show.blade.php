@extends('admin.layouts.master')
@section('title')
    @lang('admin.transaction_show')
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-9">
            <div class="card">
                <div class="card-header mb-3">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title flex-grow-1 mb-0">
                            #{{ $transaction->id }} | {{ $transaction->code }}
                        </h5>
                        <div class="flex-grow-1 text-left">
                            {{ \App\Enums\OrderStatus::getStatus($transaction->status) }}
                            <a href="{{ route('admin.transactions.invoice', $transaction->id) }}"
                               class="btn btn-primary btn-sm">
                                <i class="ri-download-2-fill align-middle me-1"></i> @lang('admin.transaction_invoice.invoice_brif')
                            </a>
                            @if (
                                $transaction->status == \App\Enums\OrderStatus::COMPLETED ||
                                    $transaction->status == \App\Enums\OrderStatus::SHIPPING_DONE ||
                                    $transaction->status == \App\Enums\OrderStatus::REFUND)
                                <a href="{{ route('admin.' . ($transaction->is_international ? 'international-' : '') . 'tax-invoices.print', ['transaction' => $transaction]) }}"
                                   class="btn btn-primary btn-sm" target="_blank">
                                    <i class="ri-download-2-fill align-middle me-1"></i> @lang('admin.tax-invoices.print')
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body px-2 pt-2 pb-2">


                @foreach ($transaction->orders as $order)
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h5 class="card-title flex-grow-1 mb-0">
                                   <div class="row">
                                    <div class="col-md-6">
                                        <small>
                                            #{{$order->id}} &nbsp; | {{$order->code}} &nbsp; |  @lang('admin.vendor'):
                                            <a href="{{ route('admin.vendors.show', ['vendor' => $order->vendor]) }}" class="fs-15">
                                                {{ $order->vendor->name }}
                                            </a>
                                        </small>
                                        <small class="d-block">
                                            {!! $order->getShippingMethodSpans() !!}
                                            | &nbsp;
                                            تكلفة الشحن: {{ $order->delivery_fees }} @lang('translation.sar')
                                            | &nbsp;
                                            دفع بالمحفظه: {{ $order->wallet_amount }} @lang('translation.sar')
                                        </small>
                                    </div>
                                    <div class="col-md-4 text-left">
                                        @if($order->isAdminCanCancel())
                                            <button type="button" class="btn btn-sm btn-danger btnIconCancel" data-id="{{$order->id}}" title="إلغاء">
                                                <i class="ri-close-fill align-middle me-1"></i>
                                            </button>
                                            <div class="divOrderCancel id{{$order->id}} d-none">
                                                <form action="{{ route('admin.transactions.cancelOrder', $order->id) }}" method="post" class="d-inline-block text-left mt-2 pt-2 pb-2 px-1 border">
                                                    @csrf
                                                    <label>
                                                        <input type="radio" name="withShipping" value="yes">
                                                        مع شحن
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="withShipping" value="no">
                                                        بدون شحن
                                                    </label>
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        إلغاء الطلب  الفرعي
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                        {{ \App\Enums\OrderStatus::getStatus($order->status) }}
                                        @endif


                                        {{-- Refund Sub Order --}}
                                        @if($order->isAdminCanRefund())
                                        <button type="button" class="btn btn-sm btn-info btnIconCancel" data-id="{{$order->id}}" title="إرجاع">
                                            {{ __('translation.refund_order') }} <i class="ri-arrow-left-line align-middle me-1"></i>
                                        </button>
                                        <div class="divOrderCancel id{{$order->id}} d-none">
                                            <br>
                                            <div class="card">
                                                <div class="card-body">
                                                    <form action="{{ route('admin.transactions.refundOrder', $order->id) }}" method="post" class="mt-2 pt-2 pb-2 px-1">
                                                        @csrf
                                                        @if ($order->orderShipping->shipping_type_id == 2 && $order->orderShipping->shipping_method_id == 1)
                                                            <div class="mb-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="withAramex" id="withAramex1" value="yes" checked>
                                                                    <label class="form-check-label" for="withAramex1">
                                                                    مع أرامكس
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="withAramex" id="withAramex2" value="no">
                                                                    <label class="form-check-label" for="withAramex2">
                                                                        بدون أرامكس
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="mb-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="withShipping" id="withShipping1" value="yes" checked>
                                                                <label class="form-check-label" for="withShipping1">
                                                                  مع الشحن
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="withShipping" id="withShipping2" value="no">
                                                            <label class="form-check-label" for="withShipping2">
                                                                بدون الشحن
                                                            </label>
                                                            </div>
                                                        </div>
                                                        <div style="text-align: right" class="form-group mb-3">
                                                            <label for="refund_reason">{{ __('translation.refund_reason') }}</label>
                                                            <input type="text" name="refund_reason" class="form-control" id="refund_reason" placeholder="ادخل سبب استرجاع الطلب">
                                                        </div>
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            ارجاع الطلب
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        @if (
                                            $order->status == \App\Enums\OrderStatus::REFUND ||
                                            $order->status == \App\Enums\OrderStatus::COMPLETED
                                            )
                                            <a href="{{ route('admin.' . ($transaction->is_international ? 'international-' : '') . 'order-tax-invoices.print', ['order' => $order->id]) }}"
                                                class="btn btn-primary btn-sm" target="_blank">
                                                 <i class="ri-download-2-fill align-middle me-1"></i> @lang('admin.tax-invoices.print')
                                             </a>
                                        @endif
                                    </div>
                                    <br>
                                    <br>

                                   </div>
                                </h5>
                                <div class="flex-shrink-0">
                                    @if (
                                        $transaction->status == \App\Enums\OrderStatus::COMPLETED ||
                                            $transaction->status == \App\Enums\OrderStatus::SHIPPING_DONE)
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table class="table table-nowrap align-middle table-borderless mb-0">
                                    <thead class="table-light text-muted">
                                    <tr>
                                        <th scope="col">@lang('admin.products.product_details')</th>
                                        <th scope="col">@lang('admin.products.product_price')</th>
                                        <th scope="col">@lang('admin.products.product_quantity')</th>
                                        <th scope="col">@lang('admin.products.product_reviews')</th>
                                        <th scope="col" class="text-end">@lang('admin.products.product_price_final')</th>
                                        <th>@lang('translation.warehouse')</th>
                                        <th>@lang('translation.warehouse_city')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {{-- @foreach ($transaction->orders as $order) --}}
                                    @foreach ($order->orderProducts as $orderProduct)
                                        <tr>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                                        <img src="{{ $orderProduct->product?->square_image }}"
                                                             class="img-fluid d-block">
                                                    </div>
                                                    <div class="flex-grow-1 ms-3" style="max-width: 110px;overflow: hidden;">
                                                        <h5 class="fs-15">
                                                            @if(!empty($orderProduct->product))
                                                                <a href="{{ route('admin.products.show', $orderProduct->product->id) }}"
                                                                   class="link-primary fs-10">
                                                                    {{ $orderProduct->product?->name }}
                                                                </a>
                                                            @endif
                                                        </h5>
                                                        <p class="text-muted mb-0">
                                                            @lang('translation.quantity_type'): <span
                                                                class="fw-medium">{{ $orderProduct->product?->quantity_type?->name }}</span>
                                                        </p>
                                                        <p class="text-muted mb-0">
                                                            @lang('translation.type'): <span
                                                                class="fw-medium">{{ $orderProduct->product?->type?->name }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $orderProduct?->unit_price }} @lang('translation.sar')</td>
                                            <td>{{ $orderProduct?->quantity }}</td>
                                            <td>
                                                <div class="text-warning fs-15">
                                                        <?php
                                                        $avg = round($orderProduct->product?->reviews()->avg('rate')); ?>
                                                        <?php
                                                        $non_avg = 5 - $avg; ?>
                                                    @for ($i = 0; $i < $avg; $i++)
                                                        <i class="ri-star-fill"></i>
                                                    @endfor
                                                    @for ($i = 0; $i < $non_avg; $i++)
                                                        <i class="ri-star-line"></i>
                                                    @endfor
                                                </div>
                                            </td>
                                            <td class="fw-medium text-end">{{ $orderProduct?->total }} @lang('translation.sar')
                                            </td>
                                            <td>
                                                @php
                                                    $warehouse = \App\Models\Warehouse::find($order->orderVendorShippingWarehouses()->where('product_id',$orderProduct->product_id)->first()?->warehouse_id);
                                                @endphp
                                                @if($warehouse)
                                                    {{ $warehouse->getTranslation('name', 'ar') }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($warehouse)
                                                {{$warehouse->cities->first()?->name ?? "-"}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    {{-- @endforeach     --}}
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-danger px-5 mt-3">
                                {{$order->orderNote->note ? 'ملاحظة البائع: '.$order->orderNote->note : ''}}
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col-md-{{ $transaction->warnings->isNotEmpty() ? '7' : '12' }}">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="card-title flex-grow-1 mb-0">@lang('admin.transaction_status')</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="profile-timeline">
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item border-0">
                                        <div class="accordion-header" id="headingOne">
                                            <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse"
                                               href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 avatar-xs">
                                                        <div class="avatar-title bg-primary rounded-circle">
                                                            <i class="ri-shopping-bag-line"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="fs-15 mb-0 fw-semibold">@lang('admin.order_placed') -
                                                            <span
                                                                class="fw-normal">{{ $transaction->created_at->toFormattedDateString() }}
                                                                <small
                                                                    class="text-muted">{{ $transaction->created_at->format('g:i A') }}</small></span>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div id="collapseOne" class="accordion-collapse collapse show"
                                             aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body ms-2 ps-5 pt-0">
                                                <h6 class="mb-1">@lang('admin.an_order_has_been_placed')</h6>
                                                <p class="text-muted">{{ $transaction->created_at->format('l') }},
                                                    {{ $transaction->created_at->toFormattedDateString() }} -
                                                    {{ $transaction->created_at->format('g:i A') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach ($transaction->transactionStatusLogs as $step)
                                        <div class="accordion-item border-0">
                                            <div class="accordion-header" id="headingOne">
                                                <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse"
                                                   href="#collapseOne{{ $step->id }}" aria-expanded="true"
                                                   aria-controls="collapseOne{{ $step->id }}">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 avatar-xs">
                                                            <div class="avatar-title bg-primary rounded-circle">
                                                                @if ($step->new_status == \App\Enums\OrderStatus::SHIPPING_DONE)
                                                                    <i class="mdi mdi-package-variant"></i>
                                                                @endif
                                                                @if ($step->new_status == \App\Enums\OrderStatus::IN_DELEVERY)
                                                                    <i class="ri-takeaway-fill"></i>
                                                                @endif
                                                                @if ($step->new_status == \App\Enums\OrderStatus::CANCELED)
                                                                    <i class="ri-close-circle-fill"></i>
                                                                @endif
                                                                @if ($step->new_status == \App\Enums\OrderStatus::COMPLETED)
                                                                    <i class="ri-checkbox-circle-fill"></i>
                                                                @endif
                                                                @if ($step->new_status == \App\Enums\OrderStatus::REFUND)
                                                                    <i class=" ri-refund-2-line"></i>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h6 class="fs-15 mb-0 fw-semibold">
                                                                {{ \App\Enums\OrderStatus::getStatus($step->new_status) }}
                                                                -
                                                                <span class="fw-normal">
                                                                    {{ $transaction->created_at->format('l') }} ,
                                                                    {{ $step->created_at->toFormattedDateString() }}
                                                                    <small
                                                                        class="text-muted">{{ $step->created_at->format('g:i A') }}</small>
                                                                </span>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!--end accordion-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">@lang('admin.customer_details')</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0 vstack gap-3">
                                <li>
                                    <a href="{{ route('admin.customers.show', ['user' => $transaction->customer]) }}" class="fs-15">
                                        <i class="ri-user-line me-2 align-middle text-muted fs-16"></i>  {{ $transaction->customer_name ?? null }}
                                    </a>

                                    </li>
                                    <li>

                                        {{ str_replace("+966","",$transaction->customer->phone) ?? null }}
                                        <i class="ri-phone-line me-2 align-middle text-muted fs-16"></i>
                                    </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i
                                    class="ri-map-pin-line align-middle me-1 text-muted"></i>@lang('admin.address_data')
                            </h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled vstack gap-2 fs-13 mb-0">
                                <li>@lang('admin.cities.single_title') : {{ $transaction?->city?->name }}</li>
                            </ul>
                        </div>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i
                                    class="ri-secure-payment-line align-bottom me-1 text-muted"></i>@lang('admin.payment_data')
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0">
                                    <p class="text-muted mb-0">@lang('admin.transaction_id') : </p>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0">#{{ $transaction->id }}</h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0">
                                    <p class="text-muted mb-0">@lang('admin.payment_method') : </p>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    @php
                                        $checkWallet = $transaction->orders()->sum('wallet_amount');
                                        $checkVisa = $transaction->orders()->sum('visa_amount');
                                        $paymentId = $transaction
                                            ->orders()
                                            ->distinct('payment_id')
                                            ->first()->payment_id;
                                    @endphp
                                    @if ($checkWallet > 0 && $paymentId != 3)
                                        <h6 class="mb-0"> {{ \App\Enums\PaymentMethods::getStatusList()[$paymentId] }} -
                                            {{ \App\Enums\PaymentMethods::getStatus(3) }} </h6>
                                    @else
                                        <h6 class="mb-0">{{ \App\Enums\PaymentMethods::getStatusList()[$paymentId] }}
                                        </h6>
                                    @endif


                                    {{-- @if ((!is_null($transaction->wallet_amount) || $transaction->wallet_amount != 0) && $transaction->payment_method != 3)
                                        <h6 class="mb-0">{{ App\Enums\PaymentMethods::getStatus($transaction->payment_method) }} - {{ App\Enums\PaymentMethods::getStatus(3) }} </h6>
                                    @else
                                        <h6 class="mb-0">{{ App\Enums\PaymentMethods::getStatus($transaction->payment_method) }}</h6>
                                    @endif --}}

                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0">
                                    <p class="text-muted mb-0">المبلغ المدفوع من خلال المحفظه : </p>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0">{{ $transaction->orders()->sum('wallet_amount') }}
                                        @lang('translation.sar')</h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0">
                                    <p class="text-muted mb-0">المبلغ المدفوع من خلال الفيزا : </p>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0">{{ $transaction->paidWithCard }} @lang('translation.sar') </h6>
                                </div>
                            </div>

                            @if ($transaction->payment_method == \App\Enums\PaymentMethods::VISA)
                                <div class="d-flex align-items-center mb-2">
                                    <div class="flex-shrink-0">
                                        <p class="text-muted mb-0">@lang('admin.transaction_gateway_id') : </p>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-0"> {{ $transaction->urwayTransaction?->urway_payment_id }} </h6>
                                    </div>
                                </div>
                            @endif

                            @if ($transaction->payment_method == \App\Enums\PaymentMethods::TABBY)
                                <div class="d-flex align-items-center mb-2">
                                    <div class="flex-shrink-0">
                                        <p class="text-muted mb-0">@lang('admin.transaction_gateway_id') : </p>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-0"> {{ $transaction->tabbyTransaction?->tabby_payment_id }} </h6>
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0">
                                    <p class="text-muted mb-0">@lang('admin.product_total') : </p>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0">{{ $transaction->sub_total }} @lang('translation.sar')</h6>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0">
                                    <p class="text-muted mb-0">@lang('admin.total_vat') : </p>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0">{{ $transaction->total_vat }} @lang('translation.sar')</h6>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0">
                                    <p class="text-muted mb-0">@lang('admin.delivery_fees') : </p>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0">
                                        {{ $transaction->orderVendorShippings()->sum('total_shipping_fees') }}
                                        @lang('translation.sar')</h6>
                                </div>
                            </div>
                            @if ($transaction->discount)
                                <div class="d-flex align-items-center mb-2">
                                    <div class="flex-shrink-0">
                                        <p class="text-muted mb-0">@lang('admin.coupon-discount') : </p>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-0">{{ $transaction->discount_in_sar_rounded }} @lang('translation.sar')
                                        </h6>
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0">
                                    <p class="text-muted mb-0">@lang('admin.total') : </p>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0">{{ $transaction->total }} @lang('translation.sar')</h6>
                                </div>
                            </div>

                            @if ($transaction->note)
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0">
                                    <p class="text-muted mb-0">ملاحظة : </p>
                                </div>
                                <div class="flex-grow-1 ms-2" style="max-width: 210px;text-align: left;direction: ltr;">
                                    <p class="mb-0">{{ $transaction->note }} </p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            @foreach ($transaction->orderVendorShippings as $orderVendorShipping)
                @if ($orderVendorShipping?->shipping_type_id == 1)
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0"><i
                                        class="mdi mdi-truck-fast-outline align-middle me-1 text-muted"></i>
                                    @lang('admin.shipping_info')
                                    ({{ $orderVendorShipping->vendor->name }})
                                </h5>
                                <div class="flex-shrink-0">
                                    {{ $orderVendorShipping->shippingType->title }}
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <p><label for="">@lang('vendors.shipping_info.status')</label> :
                                    {{ __("vendors.shipping_status.$orderVendorShipping->status") }}</p>
                            </div>
                        </div>
                        @if ($orderVendorShipping->status == 'processing')
                            <div class="card-footer">
                                <div class="text-center">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#exampleModalScrollable">@lang('admin.check_otp')</button>
                                </div>
                            </div>
                        @endif
                    </div>
                    <!--end card-->
                @else
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0"><i
                                        class="mdi mdi-truck-fast-outline align-middle me-1 text-muted"></i>
                                    @lang('admin.shipping_info')
                                    ({{ $orderVendorShipping->vendor->name }})
                                </h5>
                                <div class="flex-shrink-0">
                                    {{ $orderVendorShipping->shippingType->title }}
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="text-center">
                                @if ($orderVendorShipping?->shipping_type_id == 2 &&  $orderVendorShipping->order?->orderShip?->gateway_tracking_url)
                                    <div>

                                        @if ($orderVendorShipping?->shipping_method_id == 2)
                                        <a href="{{ $orderVendorShipping->order?->orderShip?->gateway_tracking_url }}"
                                            target="_blank" class="btn btn-soft-primary btn-sm mt-2 mt-sm-0">
                                                @lang('translation.polica')</a>

                                            <a href="{{ env('SPL_TRACKING_URL') . $orderVendorShipping->order?->orderShip?->gateway_tracking_id }}"
                                                target="_blank" class="btn btn-soft-primary btn-sm mt-2 mt-sm-0"><i
                                                    class="ri-map-pin-line align-middle me-1"></i>
                                                @lang('translation.track_order')</a>
                                        @elseif($orderVendorShipping?->shipping_method_id == 1)
                                            <a href="{{ route('admin.transactions.PrintLabel',$orderVendorShipping->order?->orderShip?->gateway_tracking_id) }}"
                                            target="_blank" class="btn btn-soft-primary btn-sm mt-2 mt-sm-0">
                                                @lang('translation.polica')</a>

                                            <a href="{{ env('ARAMEX_TRACKING_URL') . $orderVendorShipping->order?->orderShip?->gateway_tracking_id }}"
                                                target="_blank" class="btn btn-soft-primary btn-sm mt-2 mt-sm-0"><i
                                                    class="ri-map-pin-line align-middle me-1"></i>
                                                @lang('translation.track_order')</a>
                                        @endif
                                    </div>
                                @endif
                                <lord-icon src="https://cdn.lordicon.com/uetqnvvg.json" trigger="loop"
                                           colors="primary:#25a0e2,secondary:#00bd9d"
                                           style="width:80px;height:80px"></lord-icon>
                                <h5 class="fs-16 mt-2">@lang('vendors.shipping_info.title')
                                    ({{ $orderVendorShipping->vendor->name }})</h5>
                                <p class="text-muted mb-0">@lang('vendors.shipping_info.shipping_method'):
                                    {{ $orderVendorShipping->shippingMethod->name ?? null }}</p>
                                <p class="text-muted mb-0">@lang('المدينة'):
                                    {{ $orderVendorShipping->transaction->city->name ?? null }}</p>

                                <p class="text-muted mb-0">@lang('vendors.shipping_info.total_weight')
                                    : {{ $orderVendorShipping->total_weight }}
                                </p>
                                <p class="text-muted mb-0">@lang('vendors.shipping_info.base_shipping_fees'):
                                    {{ $orderVendorShipping->extra_shipping_fees == 0 || is_null($orderVendorShipping->extra_shipping_fees) ? $orderVendorShipping->total_shipping_fees : $orderVendorShipping->base_shipping_fees ?? 0 }}
                                </p>
                                <p class="text-muted mb-0">@lang('vendors.shipping_info.extra_shipping_fees'):
                                    {{ $orderVendorShipping->extra_shipping_fees ?? 0 }}</p>
                                <p class="text-muted mb-0">@lang('vendors.shipping_info.total_shipping_fees'):
                                    {{ $orderVendorShipping->total_shipping_fees }}
                                </p>

                                @if ($checkWallet > 0 && $paymentId != 3)
                                    <p class="text-muted mb-0">@lang('translation.payment_method') :
                                        {{ \App\Enums\PaymentMethods::getStatusList()[$paymentId] }} -
                                        {{ \App\Enums\PaymentMethods::getStatus(3) }}</p>
                                @else
                                    <p class="text-muted mb-0">@lang('translation.payment_method') :
                                        {{ \App\Enums\PaymentMethods::getStatusList()[$paymentId] }}</p>
                                @endif

                                <p><label for="">@lang('vendors.shipping_info.status')</label>
                                    :{{ __("vendors.shipping_status.$orderVendorShipping->status") }}</p>
                                <div class="d-sm-flex align-items-center">
                                    @if ($orderVendorShipping->order?->orderShip?->gateway_tracking_id)
                                        @if ($orderVendorShipping->shipping_type_id == 2)
                                            <h5 class="card-title flex-grow-1 mb-0">@lang('translation.track_id') :
                                                {{ $orderVendorShipping->order?->orderShip?->gateway_tracking_id }}</h5>
                                        @endif
                                    @endif
                                </div>

                                @if($orderVendorShipping->order->statusIsClosed() == false && $orderVendorShipping->order?->orderShip?->gateway_tracking_id)
                                    <button type="button" class="btn btn-primary btnShowAramexStatus mt-3 mb-3" data-id="{{$orderVendorShipping->order->id}}" >
                                        إستعلام عن الحالة
                                    </button>
                                    <h6 class="UpdateDescriptionLabel"></h6>
                                @endif


                                <!--end card-->
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            <br>
            <div class="card">
                <div class="card-header">
                    <span>سجل حالة الطلب</span>
                </div>
                <div class="card-body">
                    @foreach ($transaction->orders as $order)
                        <table class="table table-bordered">
                            <thead>
                            <th>طلب #</th>
                            <th>حالة</th>
                            <th>بواسطة</th>
                            <th>تاريخ</th>
                            </thead>
                            <tbody>
                            @foreach ($order->statusLogs()->with('user')->latest()->get() as $statusLog)
                                <tr>
                                    <td>{{$statusLog->orderType()}}</td>
                                    <td>
                                        {{ __("vendors.shipping_status.$statusLog->status") }}
                                    </td>
                                    <td>{{$statusLog->user->name}}
                                        <small>({{ $statusLog->userTypeLabel() }})</small>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($statusLog->created_at)->format('Y-m-d H:i') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endforeach
                </div>
            </div>
        </div>


    </div>


@endsection
@section('script')
    <script src="{{ url('assets/js/app.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('.btnIconCancel').on('click', function () {
                let id = $(this).data('id');
                $('.divOrderCancel.id' + id).toggleClass('d-none');
            });

            $('.btnShowAramexStatus').on('click', function () {
                let id = $(this).data('id');
                $.ajax({
                    url:  "{{ route('admin.aramexTrackShipments') }}?id="+id,
                    type: 'get',
                    success: function(res){
                        $(".UpdateDescriptionLabel").html(res.status);
                        if(res.status == null){
                            $(".UpdateDescriptionLabel").html(res.message);
                        }
                    }, error: function(err){
                        console.log(err);
                    }
                });

            });
        });
    </script>
@endsection
