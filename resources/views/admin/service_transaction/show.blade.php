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
                            {{ \App\Enums\ServiceOrderStatus::getStatus($transaction->status) }}
                            <a href="{{ route('admin.service_transactions.invoice', $transaction->id) }}"
                               class="btn btn-primary btn-sm">
                                <i class="ri-download-2-fill align-middle me-1"></i> @lang('admin.transaction_invoice.invoice_brif')
                            </a>
                            @if (
                                $transaction->status == \App\Enums\ServiceOrderStatus::COMPLETED)
                                <a href="{{ route('admin.' . ($transaction->is_international ? 'international-' : '') . 'service-tax-invoices.print', ['transaction' => $transaction]) }}"
                                   class="btn btn-primary btn-sm" target="_blank">
                                    <i class="ri-download-2-fill align-middle me-1"></i> @lang('admin.tax-invoices.print')
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body px-2 pt-2 pb-2">


                @foreach ($transaction->orderServices as $order)
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
                                            دفع بالمحفظه: {{ $order->wallet_amount }} @lang('translation.sar')
                                        </small>
                                    </div>
                                    <div class="col-md-4 text-left">
                                        @if($order->isAdminCanCancel())
                                            <button type="button" class="btn btn-sm btn-danger btnIconCancel" data-id="{{$order->id}}" title="إلغاء">
                                                <i class="ri-close-fill align-middle me-1"></i>
                                            </button>
                                            <div class="divOrderCancel id{{$order->id}} d-none">
                                                <form action="{{ route('admin.service_transactions.cancelOrder', $order->id) }}" method="post" class="d-inline-block text-left mt-2 pt-2 pb-2 px-1 border">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        إلغاء الطلب  الفرعي
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                        {{ \App\Enums\ServiceOrderStatus::getStatus($order->status) }}
                                        @endif

                                        @if ($order->status == \App\Enums\ServiceOrderStatus::COMPLETED)
                                            <a href="{{ route('admin.' . ($transaction->is_international ? 'international-' : '') . 'service-order-tax-invoices.print', ['order' => $order->id]) }}"
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
                                    @if ($transaction->status == \App\Enums\ServiceOrderStatus::COMPLETED)
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table class="table table-nowrap align-middle table-borderless mb-0">
                                    <thead class="table-light text-muted">
                                    <tr>
                                        <th scope="col">@lang('admin.services.service_details')</th>
                                        <th scope="col">@lang('admin.services.service_price')</th>
                                        <th scope="col">@lang('admin.services.service_quantity')</th>
                                        <th scope="col">@lang('admin.services.service_reviews')</th>
                                        <th scope="col" class="text-end">@lang('admin.services.service_price_final')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {{-- @foreach ($transaction->orderServices as $order) --}}
                                    @foreach ($order->orderServices as $orderService)
                                        <tr>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                                        <img src="{{ $orderService->service?->square_image }}"
                                                             class="img-fluid d-block">
                                                    </div>
                                                    <div class="flex-grow-1 ms-3" style="max-width: 110px;overflow: hidden;">
                                                        <h5 class="fs-15">
                                                            @if(!empty($orderService->service))
                                                                <a href="{{ route('admin.services.show', $orderService->service->id) }}"
                                                                   class="link-primary fs-10">
                                                                    {{ $orderService->service?->name }}
                                                                </a>
                                                            @endif
                                                        </h5>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $orderService?->unit_price }} @lang('translation.sar')</td>
                                            <td>{{ $orderService?->quantity }}</td>
                                            <td>
                                                <div class="text-warning fs-15">
                                                        <?php
                                                        $avg = round($orderService->service?->reviews()->avg('rate')); ?>
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
                                            <td class="fw-medium text-end">{{ $orderService?->total }} @lang('translation.sar')
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
                                                                @if ($step->new_status == \App\Enums\ServiceOrderStatus::CANCELED)
                                                                    <i class="ri-close-circle-fill"></i>
                                                                @endif
                                                                @if ($step->new_status == \App\Enums\ServiceOrderStatus::COMPLETED)
                                                                    <i class="ri-checkbox-circle-fill"></i>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h6 class="fs-15 mb-0 fw-semibold">
                                                                {{ \App\Enums\ServiceOrderStatus::getStatus($step->new_status) }}
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
                                <li>@lang('admin.cities.service_address') : {{ $transaction?->service_address }}</li>
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
                                        $checkWallet = $transaction->orderServices()->sum('wallet_amount');
                                        $checkVisa = $transaction->orderServices()->sum('visa_amount');
                                        $paymentId = $transaction
                                            ->orderServices()
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
                                    <h6 class="mb-0">{{ $transaction->orderServices()->sum('wallet_amount') }}
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
                                    <p class="text-muted mb-0">@lang('admin.service_total') : </p>
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
            <div class="card">
                <div class="card-header">
                    <span>سجل حالة الطلب</span>
                </div>
                <div class="card-body">
                    @foreach ($transaction->orderServices as $order)
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
                                        {{ __("vendors.service_shipping_status.$statusLog->status") }}
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
