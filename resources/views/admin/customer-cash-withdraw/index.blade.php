@extends('admin.layouts.master')
@section('title')
    @lang('admin.customer_finances.customer-cash-withdraw.page-title')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body border border-dashed border-end-0 border-start-0 mb-4">
                    <form>
                        <div class="row g-3">
                            <div class="col-xxl-4 col-sm-6">
                                <div>
                                    <input type="text" name="customer" class="form-control" value="{{ request()->get('customer') }}"
                                           placeholder="@lang("admin.customer_finances.customer-cash-withdraw.customer-name-search")...">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select name="status" class="form-control" data-choices data-choices-search-false  id="idStatus">
                                        <option value="all" selected>@lang("admin.customer_finances.customer-cash-withdraw.all-status")</option>
                                        @foreach ($statuses ?? [] as $status)
                                            <option value="{{ $status }}" @selected($status == request()->get('status'))>
                                                @lang('admin.customer_finances.customer-cash-withdraw.statuses.'. $status)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-12">
                                <div>
                                    <button type="submit" class="btn btn-secondary w-100">
                                        <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                        @lang("translation.filter")
                                    </button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#@lang('admin.customer_finances.customer-cash-withdraw.request-id')</th>
                                <th scope="col">@lang('admin.customer_finances.customer-cash-withdraw.customer-name')</th>
                                <th scope="col">@lang('admin.customer_finances.customer-cash-withdraw.customer-phone')</th>
                                <th scope="col">@lang('admin.customer_finances.customer-cash-withdraw.customer-balance')</th>
                                <th scope="col">@lang('admin.customer_finances.customer-cash-withdraw.status')</th>
                                <th scope="col">@lang('admin.customer_finances.customer-cash-withdraw.request-amount')</th>
                                <th scope="col">@lang('admin.customer_finances.customer-cash-withdraw.request-bank-name')</th>
                                <th scope="col">@lang('admin.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($withdrawRequestCollection ?? [] as $withdrawRequest)
                                <tr>
                                    <td>{{ $withdrawRequest->id }}</td>
                                    <td>{{ $withdrawRequest?->customer?->name }}</td>
                                    <td>{{ $withdrawRequest?->customer?->phone }}</td>
                                    <td>{{ $withdrawRequest?->customer?->ownWallet?->amount_with_sar }} @lang('translation.sar')</td>
                                    <td>
                                        @lang('admin.customer_finances.customer-cash-withdraw.statuses.'. $withdrawRequest?->admin_action)
                                    </td>
                                    <td>{{ $withdrawRequest->amount }}</td>
                                    <td>{{ $withdrawRequest->bank->name ? $withdrawRequest->bank->name : trans("admin.not_found") }}</td>
                                    <td>
                                        <div class="hstack gap-3 flex-wrap">
                                            <a href="{{ route('admin.customer-cash-withdraw.show', ['id' => $withdrawRequest->id]) }}" class="fs-15">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                        </div>
                                    </td>
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
    <script src="{{ URL::asset('assets/libs/list.js/list.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.js.min.js') }}"></script>

    <!--ecommerce-customer init js -->
    <script src="{{ URL::asset('assets/js/pages/ecommerce-order.init.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
@section('script-bottom')
    <script>
    </script>
@endsection
