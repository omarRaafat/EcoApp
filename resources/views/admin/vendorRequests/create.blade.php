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
                            <form action="{{ route("admin.wareHouseRequests.store") }}" method="post" class="form-steps" autocomplete="on">
                                @csrf
                                @method('post')
                                <div class="text-center pt-3 pb-4 mb-1">
                                    <img src="assets/images/logo-dark.png" alt="" height="17">
                                </div>
                                <div class="tab-content">
                                    <!-- Start Of Arabic Info tab pane -->
                                    <div class="tab-pane fade active show" id="areas-arabic-info" role="tabpanel" aria-labelledby="areas-arabic-info-tab">
                                        <div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="vendor_id">@lang('admin.wareHouseRequests.vendor')</label>
                                                        <select onchange="changeVendor(this)" class="select2 form-control" name="vendor_id" id="select2_vendor_id">
                                                            <option selected value="">
                                                                @lang("admin.wareHouseRequests.choose_vendor")
                                                            </option>
                                                            @if($vendors->count() > 0)
                                                                @foreach ($vendors as $vendor)
                                                                    <option value="{{ route('admin.vendor-warehouse-request', ['id' => $vendor->id]) }}">
                                                                        {{ $vendor->name }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        @error('vendor_id')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Of Arabic Info tab pane -->
                                </div><br>
                                <div class="tab-content">
                                    <!-- Start Of Arabic Info tab pane -->
                                    <div class="tab-pane fade active show" id="areas-arabic-info" role="tabpanel" aria-labelledby="areas-arabic-info-tab">
                                        <div>
                                            <div class="row">
                                                <div class="card-body pt-0">
                                                    <div>
                                                        <div class="table-responsive table-card mb-1">
                                                            <table class="table table-nowrap align-middle" id="tableItems">
                                                                <thead class="text-muted table-light">
                                                                    <tr class="text-uppercase">
                                                                        <th>@lang('admin.wareHouseRequests.product')</th>
                                                                        <th>@lang('admin.wareHouseRequests.qnt')</th>
                                                                        <th>@lang('admin.wareHouseRequests.mnfg_date')</th>
                                                                        <th>@lang('admin.wareHouseRequests.expire_date')</th>
                                                                        <th>#</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Of Arabic Info tab pane -->
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
        function changeVendor(e) {
            window.location = e.value
        }
    </script>
@endsection
