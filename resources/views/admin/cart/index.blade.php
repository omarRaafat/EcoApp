@extends('admin.layouts.master')
@section('title')
    @lang('admin.carts_list')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body border-bottom-dashed border-bottom">
                    <div class="row g-3">
                        <div class="col-xl-7 col-lg-9 col-md-9 col-sm-10">
                            <form class="row" method="get" action="{{ URL::asset('/admin') }}/carts/">
                                <div class="col-xl-8 col-lg-7 col-md-7 col-sm-7 me-2">
                                    <div class="search-box">
                                        <input value="{{ request()->get('search') }}" type="search" name="search" class="form-control search" placeholder="@lang('admin.customer_name'), @lang('admin.customer_phone'), @lang('admin.customer_identity')">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-3">
                                    <button type="submit" class="btn btn-secondary w-50">
                                        <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                    </button>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">@lang('admin.cart_customer_name')</th>
                                <th scope="col">@lang('admin.cart_price')</th>
                                <th scope="col">@lang('admin.cart_products_count')</th>
                                <th scope="col">@lang('admin.created_at')</th>
                                <th scope="col">@lang('admin.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($carts as $cart)
                                <tr>
                                    <td>{{ $cart->id }}</td>
                                    <td>{{ $cart->client->name }}</td>
                                    <td>{{ $cart->cart_total .' '. __('translation.sar') }}</td>
                                    <td>{{ $cart->products->count() }}</td>
                                    <td>{{ date('d-m-Y h:i', strtotime($cart->created_at)) }}</td>
                                    <td>
                                        <div class="hstack gap-3 flex-wrap">
                                            <a href="{{ route('admin.carts.show', ['cart' => $cart]) }}" class="fs-15">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="{{ route('admin.carts.delete', ['cart' => $cart]) }}" class="fs-15 link-danger">
                                                <i class="ri-delete-bin-line"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $carts->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
