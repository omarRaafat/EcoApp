@extends('admin.layouts.master')
@section('title')
    @lang('admin.canceled_orders')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @include("components.session-alert")
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">@lang('admin.canceled_orders')</h5>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form method="get" action="{{ URL::asset('/admin') }}/service-transactions/canceled_orders/">
                        <div class="row g-3">
                            <div class="col-xxl-2 col-sm-4">
                                <div class="search-box">
                                    <input value="{{ request('customer') }}" name="customer" type="text" class="form-control search" placeholder="@lang('admin.transaction_customer_filter_placeholder')">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <div class="search-box">
                                    <input value="{{ request('code') }}" name="code" type="text" class="form-control search" placeholder="@lang('admin.sub_transaction_id_filter_placeholder')">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-control" data-choices data-choices-search-false name="dues" id="dues">
                                        <option @if(request('dues') == '') SELECTED @endif value="">@lang('admin.dues')</option>

                                        <option value="pending" @selected(request()->get('dues') ==  'pending')>معلق</option>
                                        <option value="completed" @selected(request()->get('dues') ==  'completed')>تم ارجاع جميع المستحقات </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <button type="submit" class="btn btn-secondary w-100">
                                        <i class="ri-equalizer-fill me-1 align-bottom"></i> تصفية
                                    </button>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <a href="{{ route('admin.transactions.canceled_export' , [
                                        'customer' => request()->get('customer') ,
                                         'code' => request()->get('code') ,
                                         'shipping_method' => request()->get('shipping_method') ,
                                         ]) }}" class="btn btn-primary"> تصدير Excel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th>@lang('translation.sub_order_id')</th>
                                    <th>@lang('translation.customer')</th>
                                    <th>@lang('translation.services')</th>
                                    <th>@lang('admin.payment_method')</th>
                                    <th>@lang('admin.total')</th>
                                    <th>@lang('admin.services.vendor_id')</th>
                                    <th>@lang('translation.order_date')</th>
                                    <th>@lang('translation.order_status')</th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach($transactions as $key => $transaction)
                                    <tr>
                                        <td>{{ $transaction->code }}</td>
                                        <td>
                                            {{--<a data-bs-toggle="modal" data-bs-target="#exampleModalScrollable{{$key}}" href="#">--}}
                                                {{ $transaction->customer_name ?? null }}
                                            {{--</a>--}}

                                        </td>
                                        <td>{{ (int)$transaction->num_services }}</td>
                                        <td>
                                            @php
                                                $checkWallet = $transaction->wallet_amount;
                                                $checkVisa = $transaction->visa_amount;
                                                $paymentId = $transaction->payment_id ?? null;
                                            @endphp
                                            @if($checkWallet > 0 && $paymentId != 3)
                                                {{ \App\Enums\PaymentMethods::getStatusList()[$paymentId] }} - {{ \App\Enums\PaymentMethods::getStatus(3) }}
                                            @else
                                                {{ \App\Enums\PaymentMethods::getStatusList()[$paymentId] }}
                                            @endif
                                        </td>
                                        <td>{{ $transaction->total .'  '. __('translation.sar') }}</td>
                                        <td>{{ $transaction->vendor->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($transaction->created_at)->toFormattedDateString() }}</td>
                                        <td>
                                            <span class="badge badge-info">{{ \App\Enums\OrderStatus::getStatus($transaction->status) }}</span>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="exampleModalScrollable{{$key}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalScrollableTitle">@lang('admin.customer_details')</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="live-preview">
                                                       {{-- @include('admin.transaction.include.customer_details')--}}
                                                    </div>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->

                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $transactions->appends(request()->query())->links()  }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
