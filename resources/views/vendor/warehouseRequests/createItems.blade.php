@extends('admin.layouts.master')
@section('title')
    @lang('admin.wareHouseRequests.create')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">
                            @lang('admin.wareHouseRequests.create')
                        </h5>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ url('admin/wareHouseRequests/storeRequest') }}" method="post" class="form-steps" autocomplete="on">
                                @csrf
                                @method('post')
                                <input type="hidden" name="products_count" value="{{ $count }}">
                                <input type="hidden" name="vendor_id" value="{{ $vendor->id }}">
                                <div class="text-center pt-3 pb-4 mb-1">
                                    <img src="assets/images/logo-dark.png" alt="" height="17">
                                </div>
                                <div class="tab-content">
                                    <!-- Start Of Arabic Info tab pane -->
                                    <div class="tab-pane fade active show" id="areas-arabic-info" role="tabpanel" aria-labelledby="areas-arabic-info-tab">
                                        <div>
                                            <div class="row">
                                                <div class="card-body pt-0">
                                                    <div>
                                                        <div class="table-responsive table-card mb-1">
                                                            <table class="table table-nowrap align-middle" id="tableItem">
                                                                <thead class="text-muted table-light">
                                                                    <tr class="text-uppercase">
                                                                        <th>@lang('admin.wareHouseRequests.product')</th>
                                                                        <th>@lang('admin.wareHouseRequests.qnt')</th>
                                                                        <th>@lang('admin.wareHouseRequests.mnfg_date')</th>
                                                                        <th>@lang('admin.wareHouseRequests.expire_date')</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="list form-check-all">
                                                                    @for($i = 0; $i < $count; $i++)
                                                                    <tr>
                                                                        <td>
                                                                            <select class="select2 form-control" name="requestItems[{{ $i }}]['product_id']" id="select2_product_id">
                                                                                <option selected value="">
                                                                                    @lang("admin.wareHouseRequests.choose_product")
                                                                                </option>
                                                                                @if($products->count() > 0)
                                                                                    @foreach ($products as $product)
                                                                                        <option value="{{ $product->id }}">
                                                                                            {{ $product->name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                            @error('product_id')
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" class="form-control" name="requestItems[{{ $i }}]['qnt']" placeholder="{{ trans("admin.wareHouseRequests.qnt")}}">
                                                                            @error('qnt')
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </td>
                                                                        <td>
                                                                            <input type="date" class="form-control" name="requestItems[{{ $i }}]['mnfg_date']">
                                                                            @error('mnfg_date')
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </td>
                                                                        <td>
                                                                            <input type="date" class="form-control" name="requestItems[{{ $i }}]['expire_date']">
                                                                            @error('expire_date')
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </td>
                                                                    </tr>
                                                                    @endfor
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Of Arabic Info tab pane -->
                                </div>
                                <div class="d-flex align-items-start gap-3 mt-4">
                                    <button type="submit"
                                        class="btn btn-success btn-label right ms-auto nexttab nexttab">
                                        <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
                                        @lang('admin.create')
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/list.js/list.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.js.min.js') }}"></script>

    <!--ecommerce-customer init js -->
    <script src="{{ URL::asset('assets/js/pages/ecommerce-order.init.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2_country_id').select2({
                placeholder: "Select",
                allowClear: true
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $('.select2_is_active').select2({
                placeholder: "Select",
                allowClear: true
            });

        });
    </script>
@endsection
