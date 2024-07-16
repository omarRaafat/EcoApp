@extends('admin.layouts.master')
@section('title')
    @lang('admin.sub_orders')
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
                        <h5 class="card-title mb-0 flex-grow-1">@lang('admin.sub_orders')</h5>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <div class="row">
                        <div class="col-sm-9">
                            <form method="get" action="{{ URL::asset('/admin') }}/client-sms/">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div>
                                            <select name="status" class="form-control" data-choices data-choices-search-false
                                                    name="choices-single-default" id="idStatus">
                                                <option @if(request('status') == '') SELECTED
                                                        @endif value="">@lang('admin.transaction_statuses')</option>
                                                @foreach($statuses as $key => $status)
                                                    <option
                                                        @selected(request()->get('status') == $key) value="{{ $key }}"> {{ $status }} </option>
                                                @endforeach
                                                <option @if(request('status') == 'paid') SELECTED
                                                        @endif value="paid">@lang('orderStatus.website.paid')</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div>
                                            <input value="{{ request('from') }}" name="from" type="text"
                                                   class="form-control flatpickr-input active" data-provider="flatpickr"
                                                   data-maxDate="today" data-date-format="Y-m-d"
                                                   placeholder="@lang('admin.from')">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div>
                                            <input value="{{ request('to') }}" name="to" type="text"
                                                   class="form-control flatpickr-input active" data-provider="flatpickr"
                                                   data-maxDate="today" data-date-format="Y-m-d"
                                                   placeholder="@lang('admin.to')">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div>
                                            <select class="form-control" data-choices data-choices-search-false
                                                    name="shipping_type" id="shipping_type">
                                                <option @if(request('shipping_type') == '') SELECTED
                                                        @endif value="">@lang('admin.shipping_type')</option>
                                                @foreach($shipping_types as $key => $shipping_type)
                                                    <option
                                                        value="{{ $shipping_type->id }}" @selected(request()->get('shipping_type') ==  $shipping_type->id)>
                                                        {{ $shipping_type->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div>
                                            <select class="form-control" data-choices data-choices-search-false
                                                    name="shipping_method" id="shipping_method">
                                                <option @if(request('shipping_method') == '') SELECTED
                                                        @endif value="">@lang('admin.shipping_method')</option>
                                                <option @if(request('shipping_method') == 'none') SELECTED
                                                        @endif value="none">استلام بنفسي
                                                </option>
                                                @foreach($shipping_methods as $key => $shipping_method)
                                                    <option
                                                        value="{{ $shipping_method->name }}" @selected(request()->get('shipping_method') ==  $shipping_method->name)>
                                                        {{ $shipping_method->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="p-2">
                                            <button type="submit" class="btn btn-secondary w-100">
                                                <i class="ri-equalizer-fill me-1 align-bottom"></i> تصفية
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-1" >
                        </div>
                        <div class="col-sm-2" >
                            <form method="post" action="{{ URL::asset('/admin') }}/client-sms/sendsms">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-10">
                                        <div>
                                            <select name="msg_type" class="form-control" data-choices data-choices-search-false
                                                    name="choices-single-default" id="msg_type" required>
                                                <option value="">Select</option>
                                                @foreach($collection as $model)
                                                    <option
                                                        @selected(request()->get('status') == $key) value="{{ $model->message_for }}"> @lang("client-messages.". $model->message_for) </option>
                                                @endforeach
                                            </select>
{{--                                            <label for="comment">Write Message:</label>--}}
{{--                                            <textarea class="form-control" rows="3" id="message" name="message" required></textarea>--}}
                                            <input type="hidden" name="status" value="{{ request()->get('status') }}">
                                            <input type="hidden" name="from" value="{{ request()->get('from') }}">
                                            <input type="hidden" name="to" value="{{ request()->get('to') }}">
                                            <input type="hidden" name="shipping_type" value="{{ request()->get('shipping_type') }}">
                                            <input type="hidden" name="shipping_method" value="{{ request()->get('shipping_method') }}">
                                        </div>
                                        <div class="p-2">
                                            <button type="submit" class="btn btn-primary w-100">
                                                @lang('client-messages.sms_title')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th>#</th>
                                    <th>@lang('translation.order_id')</th>
                                    <th>@lang('translation.customer')</th>
                                    <th>@lang('translation.products')</th>
                                    <th>@lang('admin.payment_method')</th>
                                    <th>@lang('admin.total')</th>
                                    <th>@lang('admin.shipping_to')</th>
                                    <th>@lang('translation.order_date')</th>
                                    <th>@lang('translation.order_status')</th>
                                    <th>@lang('translation.shipping_method')</th>
                                    <th>@lang('translation.shipping_type')</th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @if(count($main_transactions) > 0)
                                    @foreach($main_transactions as $order)
                                        <tr>
                                            <td>{{$order->id}} </td>
                                            <td>{{ $order->code }}</td>
                                            <td>{{ $order->customer_name ?? null }} ({{ $order->transaction->customer->phone}})</td>
                                            <td>{{ (int)$order->num_products }}</td>
                                            <td>{{ $order->getPaymentMethod() }}</td>
                                            <td>{{ $order->total .'  '. __('translation.sar') }}</td>
                                            <td>{{ $order->orderVendorShippings[0]->to_city_name?? trans("admin.not_found")}}</td>
                                            <td>{{ \Carbon\Carbon::parse($order->created_at)->toFormattedDateString() }}</td>
                                            <td><span class="badge {{ ($order->status == "canceled") ? 'badge-danger' : 'badge-info' }}">{{ \App\Enums\OrderStatus::getStatus($order->status) }}</span></td>
                                            <td>
                                                @foreach($order->orderVendorShippings()->get()->unique('shipping_method_id')->pluck('shipping_method_id') as $trans)
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
                                                @foreach($order->orderVendorShippings()->get()->unique('shipping_type_id')->pluck('shipping_type_id') as $trans)
                                                    @if($trans == 1)
                                                        <span class="badge badge-info">استلام</span>
                                                    @elseif($trans == 2)
                                                        <span class="badge badge-info">توصيل</span>
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
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
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script>
        $(".btnshowmore").on("click", function() {
            $('#modalContent').html($(this).data('content'));
            $('#myModal').modal('show');
        });
    </script>
@endsection
