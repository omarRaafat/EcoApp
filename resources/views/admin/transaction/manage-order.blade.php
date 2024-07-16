@extends('admin.layouts.master')
@section('title')
    @lang('admin.order_update')
@endsection
@section('content')
@include('sweetalert::alert')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    {{-- {{dd($errors->any())}} --}}
    {{-- {{dd('ww')}} --}}
    <form id="transaction-edit" class="needs-validation row" novalidate method="POST"
        action="{{ route('admin.update_order_status', ['order' => $order->id]) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">@lang('admin.transaction_main_details')</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="row gy-4">
                            <div class="col-md-4">
                                <div>

                                    <label for="placeholderInput" class="form-label">@lang('admin.transaction_status')</label>
                                    <select @disabled($order->status == \App\ENums\OrderStatus::CANCELED || $order->status == \App\ENums\OrderStatus::COMPLETED || $order->status == \App\ENums\OrderStatus::REFUND) name="status" class="form-select rounded-pill mb-3" id="statusDropdown" onchange="toggleInputField()">
                                        @foreach ($statuses as $status => $statusText)
                                            @if($order->status == \App\ENums\OrderStatus::REGISTERD || $order->status == \App\ENums\OrderStatus::PAID)
                                                @if ( $status == \App\ENums\OrderStatus::REGISTERD || $status == \App\ENums\OrderStatus::PAID  || $status == \App\ENums\OrderStatus::PROCESSING )
                                                    <option @if( $status ==  \App\ENums\OrderStatus::REGISTERD || $status ==  \App\ENums\OrderStatus::PAID  ) disabled selected @endif   value="{{ $status }}">
                                                        {{ $statusText }}
                                                    </option>
                                                @endif
                                            @endif

                                            @if ($order->status == \App\ENums\OrderStatus::PROCESSING)
                                                    @if ($status == \App\ENums\OrderStatus::PROCESSING || $status == \App\ENums\OrderStatus::IN_SHIPPING  )
                                                        <option @if( $status == 'processing' ) disabled selected @endif   value="{{ $status }}">
                                                            {{ $statusText }}
                                                        </option>
                                                    @endif
                                            @endif

                                            @if ($order->status == \App\ENums\OrderStatus::IN_SHIPPING)
                                                @if ($status == \App\ENums\OrderStatus::IN_SHIPPING || $status == \App\ENums\OrderStatus::COMPLETED)
                                                    <option @if( $status == 'in_shipping' ) disabled selected @endif   value="{{ $status }}">
                                                        {{ $statusText }}
                                                    </option>
                                                @endif
                                            @endif

                                            @if ($order->status == \App\ENums\OrderStatus::COMPLETED )
                                                @if ($status == \App\ENums\OrderStatus::COMPLETED)
                                                    <option @if( $status == 'completed' ) disabled selected @endif value="{{ $status }}">
                                                        {{ $statusText }}
                                                    </option>
                                                @endif
                                            @endif
                                            @if ($order->status == \App\ENums\OrderStatus::CANCELED )
                                                <option value="canceled">
                                                    ملغي
                                                </option>
                                            @endif
                                            @if ($order->status == \App\ENums\OrderStatus::REFUND )
                                                <option value="refund">
                                                    مرتجع
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>

                                    {{-- <div class="col-md-4" > --}}
                                        <div id="inputField" style="display: none;">
                                            <label for="placeholderInput" class="form-label">عدد القطع</label>
                                            <input type="number" min=1 name="no_packages" value="{{$order->no_packages}}" class="form-control">
                                        </div>
                                        @if($order->status == 'processing')
                                        <div >
                                            <label for="placeholderInput" class="form-label">عدد القطع</label>
                                            <input type="number" disabled min=1 name="no_packages" value="{{$order->no_packages}}" class="form-control" required>
                                        </div>
                                        @endif
                                    {{-- <input type="text" id="inputField" style="display: none;"> --}}




                                    @if ($order->status == \App\ENums\OrderStatus::CANCELED)
                                        <label for="placeholderInput" class="form-label">حاله ارجاع الاموال</label>
                                        {{-- {{dd($order->refund_status)}} --}}
                                        {{-- <select @disabled($order->status == \App\ENums\OrderStatus::COMPLETED) --}}
                                        <select @disabled($order->refund_status == 'no_found' || $order->refund_status == 'completed') name="refund_status"
                                            class="form-select rounded-pill mb-3">

                                            @foreach ($refundStatuses as $status => $statusText)
                                                @if ($order->refund_status == 'pending')
                                                    @if ($status != 'no_found')
                                                        <option @selected($order->refund_status == $status) value="{{ $status }}">
                                                            {{ $statusText }}
                                                        </option>
                                                    @endif
                                                @else
                                                    <option @selected($order->refund_status == $status) value="{{ $status }}">
                                                        {{ $statusText }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @endif

                                </div>
                            </div>
                            <div class="col-md-8">
                                <div>
                                    <label for="placeholderInput" class="form-label">@lang('admin.transaction_note')</label>
                                    {{-- <select @disabled($order->status == \App\ENums\OrderStatus::COMPLETED  ||  $order->status ==\App\ENums\OrderStatus::CANCELED) --}}
                                    <textarea @disabled($order->status == \App\ENums\OrderStatus::CANCELED || $order->status == \App\ENums\OrderStatus::REFUND) name="note" class="form-control" rows="3">{{ $order->note }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- @if (session()->has('error'))

            <div class="alert alert-danger"> {{ session('error') }} </div>
        @endif --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="order-{{ $order->id }}">
                    <div class="card-header">
                        <h4 class="float-start card-title mb-0 flex-grow-1">
                            {{ __('admin.transaction_vendor_product', ['vendor' => $order->vendor->name]) }}</h4>
                            <span style="margin: 1px">  <span>
                                <p> نوع التوصيل : {{$order->orderShipping?->shippingType?->title}}
                               @if($order->orderShipping->shipping_type_id == 2)
                               - طريقه الشحن : {{$order->orderShipping?->shippingMethod?->name}}
                               @endif
                               @if($order->wallet_amount > 0 && $order->payment_id != 3)
                                  -  @lang('translation.payment_method') :  {{ \App\Enums\PaymentMethods::getStatusList()[$order->payment_id] }} - {{ \App\Enums\PaymentMethods::getStatus(3) }}
                               @else
                                  -  @lang('translation.payment_method') : {{ \App\Enums\PaymentMethods::getStatusList()[$order->payment_id] }}
                               @endif
                                </p>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-nowrap">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('admin.products.id')</th>
                                    <th scope="col">@lang('admin.products.single_title')</th>
                                    <th scope="col">@lang('admin.products.unitPrice')</th>
                                    <th scope="col">@lang('admin.quantity')</th>
                                    <th scope="col">@lang('admin.products.total')</th>
                                    {{-- <th scope="col">الفيزا المستخدمه</th> --}}
                                    <th scope="col">@lang('admin.last_update')</th>
                                    {{-- <th scope="col">@lang('admin.products.vendor')</th> --}}
                                    {{-- <th scope="col">@lang('admin.actions')</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderProducts as $product)
                                    <tr id="product-{{ $product->product->id }}">
                                        <th scope="row">{{ $product->id }}</th>
                                        <td>{{ $product->product->name }}</td>
                                        <td>{{ $product->unit_price . '  ' . __('translation.sar') }}</td>
                                        <td>
                                            <div class="input-step">
                                                <input disabled name="quantity[{{ $product->product->id }}]" type="number"
                                                    class="product-quantity" value="{{ $product->quantity }}"
                                                    min="1" />
                                            </div>
                                        </td>
                                        <td>{{ $product->total }}</td>
                                        <td>{{ $product->updated_at }}</td>
                                        {{-- <td>{{ $product->product->vendor->name }}</td> --}}

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gy-4">
            <div class="col-md-12 mb-3">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">@lang('admin.save')</button>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
@section('script-bottom')
<script>
function toggleInputField() {
  var dropdown = document.getElementById('statusDropdown');
  var inputField = document.getElementById('inputField');

  if (dropdown.value === 'processing') {
    inputField.style.display = 'block';
  } else {
    inputField.style.display = 'none';
  }
}
    </script>
    <script>
        function order_delete(orderId) {
            alert("Edit transaction disabled")
            return
            $('<input>').attr({
                type: 'hidden',
                name: 'deletedOrders[]',
                value: orderId
            }).prependTo('#transaction-edit');

            $('#order-' + orderId).fadeOut("slow");
        }

        function product_delete(productOrderId) {
            alert("Edit transaction disabled")
            return
            $('<input>').attr({
                type: 'hidden',
                name: 'deletedProducts[]',
                value: productOrderId
            }).prependTo('#transaction-edit');

            $('#product-' + productOrderId).fadeOut("slow");
        }
    </script>
@endsection
