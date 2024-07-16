@extends('admin.layouts.master')
@section('title')
    @lang('admin.dashboard')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/swiper/swiper.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @include('sweetalert::alert')

    @if (auth()->user()->isAdminPermittedToGroup('statistics'))
        <div class="row">
            <div class="col">
                <div class="h-100">
                    <div class="row">
                        <div class="row">
                            <div class="col-xl-4 col-md-8">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                    @lang('admin.statistics.admin.total_customers')
                                                </p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                    <span> {{ $customers }} </span>
                                                    @lang('admin.statistics.customer')
                                                </h4>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-soft-primary rounded fs-3">
                                                    <i class="bx bx-user-circle text-primary"></i>
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
                                                    @lang('admin.statistics.admin.total_sub_orders')
                                                </p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                    <span class="counter-value"
                                                        data-target="{{ $ordersCount ? $ordersCount : 0 }}"></span>
                                                    @lang('admin.statistics.order')
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
                                                    @lang('admin.statistics.admin.total_vendors')
                                                </p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                    <span class="counter-value"
                                                        data-target="{{ $vendorsCount ? $vendorsCount : 0 }}"></span>
                                                    @lang('admin.statistics.vendors')
                                                </h4>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-soft-primary rounded fs-3">
                                                    <i class="bx bx-user-circle text-primary"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                        </div>

                        <div class="row">
                            <div class="col-xl-4 col-md-8">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                    @lang('admin.statistics.admin.total_sales')
                                                </p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                    <span class="counter-value" data-target="{{ $sales }}">0</span>
                                                    @lang('translation.sar')
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
                                                    @lang('admin.statistics.admin.total_revenues')
                                                </p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                    <span class="counter-value" data-target="{{ $company_profit }}">0</span>
                                                    @lang('translation.sar')
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
                                                    @lang('admin.statistics.admin.products_count')
                                                </p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                    <span class="counter-value"
                                                        data-target="{{ $products ? $products : 0 }}">0</span>
                                                    @lang('admin.statistics.admin.product')
                                                </h4>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-soft-primary rounded fs-3">
                                                    <i class="bx bx-scatter-chart text-primary"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                        </div>
                    </div> <!-- end row-->

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">
                                        @lang('admin.statistics.admin.best_selling_products')
                                    </h4>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        @if ($bestProducts->count() > 0)
                                            @foreach ($bestProducts as $bestProduct)
                                                <table
                                                    class="table table-hover table-centered align-middle table-nowrap mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar-sm bg-light rounded p-1 me-2">
                                                                        <img src="{{ $bestProduct->product ? $bestProduct->product?->square_image : null }}"
                                                                            alt="" class="img-fluid d-block" />
                                                                    </div>
                                                                    <div>
                                                                        <h5 class="fs-14 my-1">
                                                                            <a href="{{ route('admin.products.show', $bestProduct->product->id) }}"
                                                                                class="text-reset">
                                                                                {{ $bestProduct->product->getTranslation('name', 'ar') }}
                                                                            </a>
                                                                        </h5>
                                                                        <span class="text-muted">
                                                                            @lang('translation.published_date')
                                                                            {{ $bestProduct->product->created_at?->toFormattedDateString() }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <h5 class="fs-14 my-1 fw-normal">
                                                                    {{ $bestProduct->product->price }} @lang('translation.sar')
                                                                </h5>
                                                                <span class="text-muted">@lang('translation.price')</span>
                                                            </td>
                                                            <td>
                                                                <h5 class="fs-14 my-1 fw-normal">
                                                                    {{ $bestProduct->product_sales }}</h5>
                                                                <span class="text-muted">@lang('translation.no_orders')</span>
                                                            </td>
                                                            <td>
                                                                <h5 class="fs-14 my-1 fw-normal">
                                                                    {{ $bestProduct->product->stock }}</h5>
                                                                <span class="text-muted">@lang('translation.available_stock')</span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            @endforeach
                                        @else
                                            @lang('admin.statistics.admin.products_not_found')
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="card card-height-100">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">
                                        @lang('admin.statistics.admin.best_selling_vendors')
                                    </h4>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        @if ($vendors->count() > 0)
                                            @foreach ($vendors as $vendor)
                                                <table
                                                    class="table table-centered table-hover align-middle table-nowrap mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0 me-2">
                                                                        @if ($vendor->vendor?->logo)
                                                                            <img src="{{ ossStorageUrl($vendor->vendor->logo) }}"
                                                                                alt="" class="avatar-sm p-2" />
                                                                        @endif
                                                                    </div>
                                                                    <div>
                                                                        <h5 class="fs-14 my-1 fw-medium">
                                                                            <a href="{{ route('admin.vendors.show', $vendor->vendor->id) }}"
                                                                                class="text-reset">
                                                                                {{ $vendor->vendor->getTranslation('name', 'ar') }}
                                                                            </a>
                                                                        </h5>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <p class="mb-0">{{ $vendor->vendor->products->count() }}
                                                                </p>
                                                                <span class="text-muted">@lang('translation.available_stock')</span>
                                                            </td>
                                                        </tr><!-- end -->
                                                    </tbody>
                                                </table><!-- end table -->
                                            @endforeach
                                        @else
                                            @lang('admin.not_found')
                                        @endif
                                    </div>
                                </div> <!-- .card-body-->
                            </div> <!-- .card-->
                        </div> <!-- .col-->
                    </div> <!-- end row-->

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">
                                        @lang('admin.statistics.admin.total_selling_categories')
                                    </h4>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        @if ($categories->count() > 0)
                                            @foreach ($categories as $category)
                                                <table
                                                    class="table table-hover table-centered align-middle table-nowrap mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div>
                                                                        <h5 class="fs-14 my-1">
                                                                            <a href="{{ route('admin.categories.show', $category->category->id) }}"
                                                                                class="text-reset">
                                                                                {{ $category->category->getTranslation('name', 'ar') }}
                                                                            </a>
                                                                        </h5>
                                                                        <span class="text-muted">@lang('admin.categories.name_ar')</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <h5 class="fs-14 my-1 fw-normal">
                                                                    {{ $category->category->products->count() }}</h5>
                                                                <span class="text-muted">
                                                                    @lang('admin.statistics.admin.products_count')
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <h5 class="fs-14 my-1 fw-normal">
                                                                    {{ $category->category->child->count() }}</h5>
                                                                <span class="text-muted">@lang('admin.categories.child_count')</span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            @endforeach
                                        @else
                                            @lang('admin.not_found')
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row-->

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card card-height-100">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">
                                        @lang('admin.statistics.admin.total_requests_according_to_status') ({{ $totalOrdersCount . ' طلب' }})
                                    </h4>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    @if ($orders_status_count->count() > 0)
                                        @foreach ($orders_status_count as $orders_status)
                                            <p class="mb-1">{{ $orders_status->status_count }} @lang('admin.statistics.admin.order')
                                                <span class="float-end"><span
                                                        class="{{ App\Enums\OrderStatus::getStatusWithClass($orders_status->status)['class'] }}">{{ App\Enums\OrderStatus::getStatusWithClass($orders_status->status)['name'] }}</span></span>
                                            </p>
                                            <div class="progress mt-2" style="height: 6px;">
                                                <div class="progress-bar progress-bar-striped bg-info" role="progressbar"
                                                    style="background-color: #827e4a; width: {{ ($orders_status->status_count / $totalOrdersCount) * 100 }}%"
                                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="25">
                                                </div>
                                            </div>
                                            <br>
                                        @endforeach
                                    @else
                                        @lang('admin.statistics.admin.no_orders_found')
                                    @endif
                                </div>
                            </div> <!-- .card-->
                        </div> <!-- .col-->
                        <div class="col-xl-6">
                            <!-- card -->
                            <div class="card card-height-100">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">
                                        @lang('admin.statistics.admin.total_requests_according_to_country') ({{ $totalTransactionCount . ' طلب رئيسي' }})
                                    </h4>
                                </div><!-- end card header -->

                                <!-- card body -->
                                <div class="card-body">
                                    {{--                            <div data-colors='["--vz-light", "--vz-secondary", "--vz-primary"]' style="height: 269px" dir="ltr"></div> --}}
                                    {{--                                <div class="px-2 py-2 mt-1"> --}}
                                    @if ($transactionsCity->count() > 0)
                                        @foreach ($transactionsCity as $order)
                                            <p class="mb-1">{{ $order->transaction_count }} @lang('admin.statistics.admin.order') <span
                                                    class="float-end"><span style="background-color: #827e4a"
                                                        class="badge">{{ $order?->city?->getTranslation('name', 'ar') }}</span></span>
                                            </p>
                                            <div class="progress mt-2" style="height: 6px;">
                                                <div class="progress-bar progress-bar-striped bg-info" role="progressbar"
                                                    style="width: {{ ($order->transaction_count / $totalTransactionCount) * 100 }}%"
                                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="25">
                                                </div>
                                            </div>
                                            <br>
                                        @endforeach
                                    @else
                                        @lang('admin.statistics.admin.no_orders_found')
                                    @endif
                                    {{--                                </div> --}}
                                    {{--                            </div> --}}
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                </div> <!-- end .h-100-->

            </div> <!-- end col -->
        </div>
    @else
        <div class="row">
            <div class="card">
                <div class="card-body"> مرحبا بك</div>
            </div>
        </div>
    @endif

@endsection
@section('script')
    <script>
        window.setInterval("reloadIFrame();", 50000);

        function reloadIFrame() {
            document.getElementById("dashboard-statistics").src =
                "https://dash.ncpd.io/public/dashboard/0b8751d3-c164-40c0-b208-342054a899d0";
        }
    </script>
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/swiper/swiper.min.js') }}"></script>
    <!-- dashboard init -->
    <script src="{{ URL::asset('/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
