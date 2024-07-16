@extends('admin.layouts.master')
@section('title')
    @lang("admin.customer_finances.wallets.create")
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
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
                            @lang("admin.customer_finances.wallets.create")
                        </h5>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form action="{{ route('admin.wallets.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method("post")
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="customer_id" class="form-label">
                                    @lang("admin.customer_finances.wallets.customer_name")
                                </label>
                                <select class="select2 form-control" name="customer_id" id="select2_customer">
                                    <option selected value="">
                                        @lang("admin.customer_finances.wallets.choose_customer")
                                    </option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer["id"] }}">
                                            {{ $customer["name"] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="is_active" class="form-label">
                                    @lang("admin.customer_finances.wallets.is_active")
                                </label>
                                <select class="select2 form-control" name="is_active" id="select2_is_active">
                                    <option selected value="">
                                        @lang("admin.customer_finances.wallets.choose_state")
                                    </option>
                                    @foreach ($statusOfWallet as $state)
                                        <option value="{{ $state["value"] }}">
                                            {{ $state["name"] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('is_active')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="reason" class="form-label">
                                    @lang("admin.customer_finances.wallets.reason")
                                </label>
                                <input type="text" name="reason" class="form-control" placeholder="@lang("admin.customer_finances.wallets.reason")"/>
                                @error('reason')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="attachment" class="form-label">
                                    @lang("admin.customer_finances.wallets.attachment")
                                </label>
                                <input type="file" name="attachment" class="form-control" placeholder="@lang("admin.customer_finances.wallets.attachment")"/>
                                @error('attachment')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="hstack gap-2 justify-content-end">
                                <a href="{{ route("admin.wallets.index") }}" class="btn btn-light">
                                    @lang("admin.close")
                                </a>
                                <button type="submit" class="btn btn-primary" id="add-btn">
                                    @lang("admin.create")
                                </button>
                            </div>
                        </div>
                    </form>
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
            // Select2 Multiple
            $('.select2_customer').select2({
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
