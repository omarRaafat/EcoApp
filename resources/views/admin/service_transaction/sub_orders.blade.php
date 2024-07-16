@extends('admin.layouts.master')
@section('title')
    @lang('admin.sub_orders')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
<link  href="{{ URL::asset('assets/libs/bootstrap-select/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />


@endsection

@section('content')
    @include("components.session-alert")
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">@lang('admin.sub_orders')</h5>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form method="get" action="{{ URL::asset('/admin') }}/service-transactions/sub_orders/">
                        <div class="row g-3">
                            <div class="col-xxl-2 col-sm-4">
                                <div class="search-box">
                                    <input value="{{ request('customer') }}" name="customer" type="text"
                                           class="form-control search"
                                           placeholder="@lang('admin.transaction_customer_filter_placeholder')">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <div class="search-box">
                                    <input value="{{ request('code') }}" name="code" type="text"
                                           class="form-control search"
                                           placeholder="@lang('admin.transaction_id_filter_placeholder')">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <input value="{{ request('from') }}" name="from" type="text"
                                           class="form-control flatpickr-input active" data-provider="flatpickr"
                                           data-maxDate="today" data-date-format="Y-m-d"
                                           placeholder="@lang('admin.from')">
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <input value="{{ request('to') }}" name="to" type="text"
                                           class="form-control flatpickr-input active" data-provider="flatpickr"
                                           data-maxDate="today" data-date-format="Y-m-d"
                                           placeholder="@lang('admin.to')">
                                </div>
                            </div>

                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select name="status[]" class="form-control selectpicker status-selectpicker form-select-sm" data-choices multiple    data-choices-search-false data-none-selected-text="@lang('admin.transaction_statuses')"
                                            name="choices-single-default" id="idStatus">

                                        @foreach($statuses as $key => $status)
                                            <option
                                                @selected(request()->get('status') == $key) value="{{ $key }}"> {{ $status }} </option>
                                        @endforeach
                                        <option @if(request('status') == 'paid') SELECTED
                                                @endif value="paid">@lang('orderStatus.website.paid')</option>
                                    </select>
                                </div>

                            </div>

                            {{--
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-control" data-choices data-choices-search-false name="dues"
                                            id="dues">
                                        <option @if(request('dues') == '') SELECTED
                                                @endif value="">@lang('admin.dues')</option>
                                        <option value="pending" @selected(request()->get('dues') ==  'pending')>معلق
                                        </option>
                                        <option value="completed" @selected(request()->get('dues') ==  'completed')>تم
                                            ارجاع جميع المستحقات
                                        </option>
                                    </select>
                                </div>
                            </div>--}}

                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <button type="submit" class="btn btn-secondary w-100">
                                        <i class="ri-equalizer-fill me-1 align-bottom"></i> تصفية
                                    </button>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <a href="{{ route('admin.service_transactions.sub_orders_export' , [
                                        'customer' => request()->get('customer') ,
                                         'code' => request()->get('code') ,
                                         'from' => request()->get('from') ,
                                         'to' => request()->get('to') ,
                                         'status' => request()->get('status') ,
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
                                    <th>#</th>
                                    <th>@lang('translation.order_id')</th>
                                    <th>@lang('translation.sub_order_id')</th>
                                    <th>@lang('translation.customer')</th>
                                    <th>@lang('translation.services')</th>
                                    <th>@lang('admin.payment_method')</th>
                                    <th>@lang('admin.total')</th>
                                    <th>@lang('admin.services.vendor_id')</th>
                                    <th>@lang('admin.service_shipping_to')</th>
                                    <th>@lang('translation.order_date')</th>
                                    <th>@lang('translation.order_status')</th>
                                    <th>@lang('translation.vendor_note')</th>
                                    <th>@lang('translation.service_order_send_otp')</th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @if(count($main_transactions) > 0)
                                @foreach($main_transactions as $order)
                                    <tr>
                                        <td>{{$order->id}} </td>
                                        <td><a href="{{ route('admin.service_transactions.show', ['transaction' => $order->transaction->id]) }}"> {{$order->transaction->code}} </a> </td>
                                        <td>{{ $order->code }}</td>
                                        <td>
                                            <a href="{{ route('admin.customers.show', ['user' => $order->transaction->customer]) }}"
                                               class="fs-15">
                                                {{ $order->customer_name ?? null }}
                                            </a>
                                        </td>
                                        <td>{{ (int)$order->num_services }}</td>
                                        <td>
                                            {{ $order->getPaymentMethod() }}
                                        </td>
                                        <td>{{ $order->total .'  '. __('translation.sar') }}</td>
                                        <td>
                                            <a href="{{ route('admin.vendors.show', ['vendor' => $order->vendor]) }}"
                                               class="fs-15">
                                                {{ $order->vendor->name }}
                                            </a>
                                        </td>
                                        <td>{{ $order->transaction->city->name ?? trans("admin.not_found")}}</td>
                                        <td>{{ \Carbon\Carbon::parse($order->created_at)->toFormattedDateString() }}</td>
                                        <td>
                                            <span
                                                class="badge {{ ($order->status == "canceled") ? 'badge-danger' : 'badge-info' }}">{{ \App\Enums\ServiceOrderStatus::getStatus($order->status) }}</span>
                                        </td>
                                        <td>
                                            @if($order->orderNote->note)
                                            <button type="button" class="btn btn-sm btnshowmore" data-content="{{$order->orderNote->note}}">  <i class="ri-eye-fill fs-16"></i> </button>
                                            @endif
                                        </td>
                                        <td>
                                            @if($order->status == 'processing')
                                            <span class="d-block badge badge-info">
                                                {{"رمز:".$order->receive_order_code}}
                                                <a href="{{ route('admin.service_transactions.sub_orders.resend_receive_code',$order->id) }}"
                                                   class="btn btn-sm btn-warning" title="إعادة إرسال الرمز">
                                                    <i data-feather="refresh-cw"
                                                       style="width: 13px;height: 13px;"></i>
                                                </a>
                                            </span>
                                            @endif
                                        </td>

                                    </tr>

                                    {{--      <div class="modal fade" id="exampleModalScrollable{{$key}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                              <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                  <div class="modal-content">
                                                      <div class="modal-header">
                                                          <h5 class="modal-title" id="exampleModalScrollableTitle">@lang('admin.customer_details')</h5>
                                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                          </button>
                                                      </div>
                                                      <div class="modal-body">
                                                          <div class="live-preview">
                                                              --}}{{--@include('admin.transaction.include.customer_details')--}}{{--
                                                          </div>
                                                      </div>
                                                  </div><!-- /.modal-content -->
                                              </div><!-- /.modal-dialog -->
                                          </div><!-- /.modal -->--}}
                                @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $main_transactions->appends(request()->query())->links()  }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('translation.vendor_note')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalContent">
                    <!-- Content will be inserted here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/bootstrap-select.min.js') }}"></script>

    <script src="{{ URL::asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/bootstrap-select.min.js') }}"></script>
    <script>
        $(".btnshowmore").on("click", function() {
            $('#modalContent').html($(this).data('content'));
            $('#myModal').modal('show');
            });
    </script>

    <script>
        $('selectpicker').selectpicker();
        </script>

@endsection
