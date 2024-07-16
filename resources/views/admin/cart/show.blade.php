@extends('admin.layouts.master')
@section('title')
    @lang('admin.cart_show')
@endsection
@section('content')

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">@lang('admin.cart_main_details')</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="row gy-4">
                            <div class="col-md-4">
                                <div>
                                    <label for="BasicInput" class="form-label">@lang('admin.transaction_id')</label>
                                    <input disabled="disabled" readonly type="text" class="form-control" value="{{ $cart->id }}" id="basicInput">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div>
                                    <label for="BasicInput" class="form-label">@lang('admin.cart_date')</label>
                                    <input disabled="disabled" readonly type="text" class="form-control" value="{{ date('d-m-Y h:i', strtotime($cart->created_at)) }}" id="basicInput">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div>
                                    <label for="BasicInput" class="form-label">@lang('admin.cart_last_update')</label>
                                    <input disabled="disabled" readonly type="text" class="form-control" value="@if($cart->updated_at){{ date('d-m-Y h:i', strtotime($cart->updated_at)) }}@else --@endif" id="basicInput">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">@lang('admin.customer_details')</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="row gy-4">
                            <div class="col-md-6">
                                <div>
                                    <label for="BasicInput" class="form-label">@lang('admin.customer_name')</label>
                                    <input disabled="disabled" readonly type="text" class="form-control" value="{{ $cart->client->name }}" id="basicInput">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <label for="BasicInput" class="form-label">@lang('admin.customer_phone')</label>
                                    <input disabled="disabled" readonly type="text" class="form-control" value="{{ $cart->client->phone }}" id="basicInput">
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0 flex-grow-1">@lang('admin.products.title')</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-nowrap">
                            <thead>
                            <tr>
                                <th scope="col">@lang('admin.products.id')</th>
                                <th scope="col">@lang('admin.products.single_title')</th>
                                <th scope="col">@lang('admin.products.unitPrice')</th>
                                <th scope="col">@lang('admin.quantity')</th>
                                <th scope="col">@lang('admin.created_at')</th>
                                <th scope="col">@lang('admin.last_update')</th>
                                <th scope="col">@lang('admin.products.vendor')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cart->products As $product)
                                <tr>
                                    <th scope="row">{{ $product->id }}</th>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ ($product->price) .'  '. __('translation.sar') }}</td>
                                    <td>{{ $product->pivot->quantity }}</td>
                                    <td>{{ date('d-m-Y h:i', strtotime($product->pivot->created_at)) }}</td>
                                    <td>@if($product->pivot->updated_at){{ date('d-m-Y h:i', strtotime($product->pivot->updated_at)) }}@else --@endif</td>
                                    <td>{{ $product->vendor->name }}</td>
                                </tr>
                            @endforeach
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
