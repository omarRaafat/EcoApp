@extends('admin.layouts.master')
@section('title')
    @lang("admin.dispensingOrder.show")
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="card-header  border-0">
            <div class="d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">
                    @lang("admin.vendorWallets.show"): {{ $vendorWallet?->vendor?->owner?->name }}
                </h5>
            </div>
        </div>
    </div>
    <br>
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5>
                        @lang('admin.dispensingOrder.manage')
                    </h5>
                </div>
                <div class="card-footer">
                    <h5>
                        @lang("admin.vendorWallets.current_wallet_balance"): <span>{{ $vendorWallet->balance . ' ' . __('translation.sar')}}</span>
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="wallets">
                <div class="card-header">
                    <h5>
                        @lang('admin.dispensingOrder.transaction.wallet_transactions_log')
                    </h5>
                </div>
                <br>
                <div class="card-body pt-0">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="walletsTable">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th>@lang('admin.vendorWallets.transaction.id')</th>
                                    <th>@lang('admin.vendorWallets.transaction.amount')</th>
                                    <th>@lang('admin.vendorWallets.transaction.operation_type')</th>
                                    <th>@lang('admin.vendorWallets.transaction.reference')</th>
                                    {{-- <th>@lang('admin.vendorWallets.transaction.reference_id')</th> --}}
                                    <th>@lang('admin.vendorWallets.transaction.order_code')</th>
                                    <th>@lang('admin.vendorWallets.transaction.admin_by')</th>
                                    <th>@lang('admin.vendorWallets.transaction.receipt_url')</th>
                                    <th>@lang('admin.vendorWallets.created_at')</th>
                                    <th>@lang('translation.actions')</th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach($transactions as $transactionRecord)
                                    <tr>
                                        <td class="transaction_id">{{ $transactionRecord->id }}</td>
                                        <td class="amount">
                                            {{ $transactionRecord->amount_in_sar   . ' ' . __('translation.sar') }}
                                        </td>
                                        <td class="operation_type">
                                            {{ \App\Enums\VendorWallet::getTypeWithClass($transactionRecord->operation_type)["name"] }}
                                        </td>
                                        <td class="refrence">{{ !empty($transactionRecord->reference) ? $transactionRecord->reference : trans("admin.not_found") }}</td>
                                        {{-- <td class="refrence_id">{{ !empty($transactionRecord->reference_id) ? $transactionRecord->reference_id : trans("admin.not_found") }}</td> --}}
                                        <td class="refrence_id">{{ !empty($transactionRecord->referenceOrder->code) ? $transactionRecord->referenceOrder->code : trans("admin.not_found") }}</td>
                                        <td class="by_admin">{{ !empty($transactionRecord->admin->name) ? $transactionRecord->admin->name : trans("admin.not_found") }}</td>
                                        <td class="receipt">
                                            @if (!empty($transactionRecord->attachment_url))
                                                <a href="{{ $transactionRecord->attachment_url }}" target="_blank">
                                                    @lang("admin.vendorWallets.transaction.receipt_url")
                                                </a>
                                            @else
                                                @lang("admin.not_found")
                                            @endif
                                        </td>
                                        <td class="amount">{{ $transactionRecord->created_at->translatedFormat('d-m-Y h:i A') }}</td>
                                        <td>
                                            <form action="{{ route('admin.dispensingOrder.store')  }}" method="post">
                                                @csrf
                                                <input type="hidden" name="vendor_wallet_transaction_id" value="{{ $transactionRecord->id  }}">
                                                <button type="submit" class="btn btn-primary w-100">
                                                    @lang('admin.dispensingOrder.dispensingOrder')
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                               colors="primary:#25a0e2,secondary:#0ab39c"
                                               style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">@lang('admin.vendorWallets.transaction.no_result_found')</h5>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                {{ $transactions->appends(request()->query())->links("pagination::bootstrap-4") }}
                            </div>
                        </div>
                    </div>
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
@endsection
