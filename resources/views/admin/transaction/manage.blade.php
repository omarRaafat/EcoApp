@extends('admin.layouts.master')
@section('title')
    @lang('admin.transaction_show')
@endsection
@section('content')
    @if(session()->has('error'))
        <div class="alert alert-danger"> {{ session('error') }} </div>
    @endif
    <form id="transaction-edit" class="needs-validation row" novalidate method="POST"
        action="{{ route('admin.transactions.update', ['transaction' => $transaction->id]) }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                @foreach($transaction->orders As $order)
                    <div class="card" id="order-{{ $order->id }}">
                        <div class="card-header">
                            <h4 class="float-start card-title mb-0 flex-grow-1">{{ __('admin.transaction_vendor_product', ['vendor' => $order->vendor->name]) }}</h4>
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

                             @if($order->refund_status == 'no_found')
                                <mark style="background: rgb(180, 180, 98);color:black;padding:7px">لا يوجد مستحقات</mark>
                            @endif


                                @if($order->refund_status == 'pending')
                                        <mark style="background: red;color:white;padding:7px">يوجد مستحقات معلقه</mark>
                                @endif

                                @if($order->refund_status == 'completed')
                                    <mark style="background: rgb(28, 159, 28);color:white;padding:7px">تم تحويل جميع المستحقات</mark>
                                @endif

                             </p>
                            <div class="float-end">
                                <a href="{{route('admin.get_order_status' , ['order' => $order])}}"  class="text-primary d-inline-block">
                                    <i class="ri-edit-2-fill"></i>
                                </a>
                            </div>
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
                                    {{-- <th scope="col">طريقه الدفع</th> --}}
                                    {{-- <th scope="col">الفيزا المستخدمه</th> --}}
                                    <th scope="col">@lang('admin.last_update')</th>
                                    {{-- <th scope="col">@lang('admin.products.vendor')</th> --}}
                                    {{-- <th scope="col">@lang('admin.actions')</th> --}}
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderProducts As $product)
                                        <tr id="product-{{ $product->product->id  }}">
                                            <th scope="row">{{ $product->id }}</th>
                                            <td>{{ $product->product->name }}</td>
                                            <td>{{ $product->unit_price .'  '. __('translation.sar') }}</td>
                                            <td>
                                                <div class="input-step">
                                                    <input disabled name="quantity[{{ $product->product->id }}]" type="number" class="product-quantity" value="{{ $product->quantity }}" min="1" />
                                                </div>
                                            </td>
                                            <td>{{ $product->total }}</td>
                                            <td>{{ $product->updated_at }}</td>
                                            {{-- <td>{{  $product->product->vendor->name}}</td> --}}
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row gy-4">
            <div class="col-md-12 mb-3">
                <div class="text-end">
                    <button @disabled($transaction->status == \App\ENums\OrderStatus::COMPLETED) type="submit" class="btn btn-primary">@lang('admin.save')</button>
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
        function order_delete(orderId)
        {
            alert("Edit transaction disabled")
            return
            $('<input>').attr({
                type: 'hidden',
                name: 'deletedOrders[]',
                value: orderId
            }).prependTo('#transaction-edit');

            $('#order-'+orderId).fadeOut("slow");
        }

        function product_delete(productOrderId)
        {
            alert("Edit transaction disabled")
            return
            $('<input>').attr({
                type: 'hidden',
                name: 'deletedProducts[]',
                value: productOrderId
            }).prependTo('#transaction-edit');

            $('#product-'+productOrderId).fadeOut("slow");
        }
    </script>
@endsection
