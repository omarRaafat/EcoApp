@extends('vendor.layouts.master')
@section('title')
    @lang('translation.dashboards')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/swiper/swiper.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')

    @if (auth()->user()?->isVendorPermittedTo('statistics'))

        <div class="row">
            <div class="col">
                <div class="h-100">
                    <div class="row">
                        @if(session()->has('error'))
                            <div class="alert alert-danger mb-3"> {{ session()->get("error") }} </div>
                        @endif
                        @if(session()->has('success'))
                            <div class="alert alert-success mb-3"> {{ session()->get("success") }} </div>
                        @endif
                        <div class="row">
                            <div class="col-xl-4 col-md-8">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                    @lang("admin.statistics.admin.total_sub_orders")
                                                </p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                    <span class="counter-value" data-target="{{ $ordersCount }}"></span>
                                                    @lang("admin.statistics.order")
                                                </h4>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-soft-primary rounded fs-3">
                                            <i class="bx bx-shopping-bag text-primary"></i>
                                        </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                            <div class="col-xl-4 col-md-8">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                    @lang("admin.statistics.admin.total_sales")
                                                </p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                    <span class="counter-value"
                                                          data-target="{{ $total_sell  ? $total_sell : 0 }}">0</span>
                                                    @lang("translation.sar")
                                                </h4>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-soft-primary rounded fs-3">
                                            <i class="bx bx-wallet text-primary"></i>
                                        </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                            <div class="col-xl-4 col-md-8">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                    @lang("admin.statistics.admin.total_revenues")
                                                </p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                    <span class="counter-value"
                                                          data-target="{{ $total_earn  ? $total_earn : 0 }}">0</span>
                                                    @lang("translation.sar")
                                                </h4>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-soft-primary rounded fs-3">
                                            <i class="bx bx-wallet text-primary"></i>
                                        </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                        </div>
                    </div> <!-- end row-->

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">
                                        @lang("admin.statistics.admin.best_selling_products")
                                    </h4>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        @if($bestProducts->count() > 0)
                                            @foreach($bestProducts as $bestProduct)
                                                <table
                                                    class="table table-hover table-centered align-middle table-nowrap mb-0">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="avatar-sm bg-light rounded p-1 me-2">
                                                                    <img src="{{ $bestProduct->product ? url($bestProduct->product?->image) : '' }}"
                                                                         alt="" class="img-fluid d-block"/>
                                                                </div>
                                                                <div>
                                                                    <h5 class="fs-14 my-1">
                                                                        <a href="{{ route("vendor.products.show", $bestProduct->product?->id) }}"
                                                                           class="text-reset">
                                                                            {{ $bestProduct->product?->getTranslation('name', 'ar') }}
                                                                        </a>
                                                                    </h5>
                                                                    <span class="text-muted">
                                                                    @lang('translation.published_date')
                                                                        {{ $bestProduct->product?->created_at?->toFormattedDateString() }}
                                                                </span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h5 class="fs-14 my-1 fw-normal">{{ $bestProduct->product?->price }} @lang('translation.sar')</h5>
                                                            <span class="text-muted">@lang('translation.price')</span>
                                                        </td>
                                                        <td>
                                                            <h5 class="fs-14 my-1 fw-normal">{{ $bestProduct->product_sales }}</h5>
                                                            <span
                                                                class="text-muted">@lang('translation.no_orders')</span>
                                                        </td>
                                                        <td>
                                                            <h5 class="fs-14 my-1 fw-normal">{{ $bestProduct->product?->stock }}</h5>
                                                            <span
                                                                class="text-muted">@lang('translation.available_stock')</span>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            @endforeach
                                        @else
                                            @lang("admin.statistics.admin.products_not_found")
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row-->

                    <div class="row">
                        <div class="col-xl-4">
                            <div class="card card-height-100">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">
                                        @lang("admin.statistics.admin.total_requests_according_to_status") ({{ $totalOrdersCount . ' طلب' }})
                                    </h4>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    @if($orders_status_count->count() > 0)
                                        @foreach ($orders_status_count as $orders_status)
                                        <p class="mb-1">{{ $orders_status->status_count }} @lang("admin.statistics.admin.order")
                                            <span
                                                class="float-end"><span class="{{ App\Enums\OrderStatus::getStatusWithClass($orders_status->status)['class'] }}">{{ App\Enums\OrderStatus::getStatusWithClass($orders_status->status)['name'] }}</span></span>
                                        </p>
                                        <div class="progress mt-2" style="height: 6px;">
                                            <div class="progress-bar progress-bar-striped bg-info"
                                                 role="progressbar"
                                                 style="background-color: #827e4a; width: {{ $orders_status->status_count / $totalOrdersCount * 100 }}%"
                                                 aria-valuenow="25"
                                                 aria-valuemin="0" aria-valuemax="25">
                                            </div>
                                        </div>
                                        <br>
                                        @endforeach
                                    @else
                                        @lang("admin.statistics.admin.no_orders_found")
                                    @endif
                                </div>
                            </div> <!-- .card-->
                        </div> <!-- .col-->
                        <div class="col-xl-8">
                            <!-- card -->
                            <div class="card card-height-100">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">
                                        @lang("admin.statistics.admin.total_requests_according_to_country") ({{ $totalTransactionCount . ' طلب رئيسي' }})
                                    </h4>
                                </div><!-- end card header -->

                                <!-- card body -->
                                <div class="card-body">
                                    @if($transactionsCity->count() > 0)
                                        @foreach ($transactionsCity as $order)
                                        <p class="mb-1">{{ $order->transaction_count }} @lang("admin.statistics.admin.order") <span
                                            class="float-end"><span style="background-color: #827e4a" class="badge">{{ $order?->city?->getTranslation('name', 'ar') }}</span></span>
                                    </p>
                                    <div class="progress mt-2" style="height: 6px;">
                                        <div class="progress-bar progress-bar-striped bg-info"
                                             role="progressbar" style="width: {{ $order->transaction_count / $totalTransactionCount * 100 }}%"
                                             aria-valuenow="25"
                                             aria-valuemin="0" aria-valuemax="25">
                                        </div>
                                    </div>
                                    <br>
                                        @endforeach
                                    @else
                                        @lang("admin.statistics.admin.no_orders_found")
                                    @endif
                                    {{--                            <div id="sales-by-locations"--}}
                                    {{--                                data-colors='["--vz-light", "--vz-secondary", "--vz-primary"]'--}}
                                    {{--                                style="height: 269px" dir="ltr"></div>--}}

                                    {{--                            <div class="px-2 py-2 mt-1">--}}
                                    {{--                                @if($ordersByCountries->count() > 0)--}}
                                    {{--                                    @foreach ($ordersByCountries as $order)--}}
                                    {{--                                        <p class="mb-1">{{ $order->country->getTranslation('name', 'ar') }} <span class="float-end">{{ $order->country_sales }} @lang("admin.statistics.admin.order")</span></p>--}}
                                    {{--                                        <div class="progress mt-2" style="height: 6px;">--}}
                                    {{--                                            <div class="progress-bar progress-bar-striped bg-primary"--}}
                                    {{--                                                role="progressbar" style="width: {{ $order->country_sales }}%" aria-valuenow="25"--}}
                                    {{--                                                aria-valuemin="0" aria-valuemax="25">--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    @endforeach--}}
                                    {{--                                @else--}}
                                    {{--                                    @lang("admin.statistics.admin.no_orders_found")--}}
                                    {{--                                @endif--}}
                                    {{--                            </div>--}}
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                </div> <!-- end .h-100-->
                @if(isset($agreement) && $agreement)
                    <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog"
                         aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myExtraLargeModalLabel">
                                        @lang('vendors.agreement-requested')
                                        <a href="{{ $agreement->agreement_pdf }}" download>
                                            @lang('vendors.download-agreement')
                                        </a>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <embed src="{{ $agreement->agreement_pdf }}" type="application/pdf" width="100%"
                                           height="800"/>
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('vendor.agreements.approve') }}" method="post">
                                        @csrf
                                        @method('put')
                                        <button class="btn btn-success" type="submit">
                                            @lang('vendors.agreement-read-and-approve')
                                        </button>
                                    </form>
                                    <a href="javascript:void(0);" class="btn btn-link link-success fw-medium"
                                       data-bs-dismiss="modal">
                                        <i class="ri-close-line me-1 align-middle"></i>@lang('translation.close')
                                    </a>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                @endif
            </div> <!-- end col -->
        </div>
    @else
        <div class="row">
            <div class="card">
                <div class="card-body text-center"><h2> مرحبا بك بمنصه مزارع </h2></div>
            </div>
        </div>
    @endif
@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/swiper/swiper.min.js')}}"></script>
    <!-- dashboard init -->
    <script src="{{ URL::asset('/assets/js/jquery-3.6.3.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/dashboard-vendor-ecommerce.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script>
        @if(isset($agreement) && $agreement)
        $(document).ready(function () {
            $(".bs-example-modal-xl").modal("toggle")
        })
        @endif
    </script>
@endsection
