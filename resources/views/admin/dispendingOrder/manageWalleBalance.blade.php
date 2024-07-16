@extends('admin.layouts.master')
@section('title')
    @lang('admin.customer_finances.wallets.transaction.title')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5>
                        @lang('admin.customer_finances.wallets.transaction.title')
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route("admin.wallets.increaseAndDecreaseAmount", $wallet->id) }}" method="post">
                        @csrf
                        @method("POST")
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="amount" class="form-label">
                                    @lang("admin.customer_finances.wallets.transaction.amount")
                                </label>
                                <input type="number" name="amount" class="form-control" placeholder="@lang("admin.customer_finances.wallets.transaction.amount")"/>
                                @error('amount')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-3">
                                <label for="type" class="form-label">
                                    @lang("admin.customer_finances.wallets.transaction.type")
                                </label>
                                <select class="select2 form-control" name="type" id="select2_type">
                                    <option value="">
                                        @lang("admin.customer_finances.wallets.transaction.choose_type")
                                    </option>
                                    @foreach ($statusOfWalletTransactionsHistory as $state)
                                        <option value="{{ $state["value"] }}">
                                            {{ $state["name"] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-3">
                                <label for="type" class="form-label">
                                    @lang("admin.customer_finances.wallets.transaction.transaction_type.title")
                                </label>
                                <select class="select2 form-control" name="transaction_type" id="select2_type">
                                    <option value="">
                                        @lang("admin.customer_finances.wallets.transaction.transaction_type.choose_transaction_type")
                                    </option>
                                    @foreach (\App\Enums\WalletTransactionTypes::getTypesListWithClass() as $state)
                                        <option value="{{ $state["value"] }}">
                                            {{ $state["name"] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('transaction_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-3">
                                <div class="justify-content-end">
                                    <label for="" class="form-label"></label>
                                    <button type="submit" class="form-control btn btn-primary" id="add-btn">
                                        @lang("admin.edit")
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <h5>
                        @lang("admin.customer_finances.wallets.current_wallet_balance"): <span>{{ $wallet->amount_with_sar . ' ' . __('translation.sar')}}</span>
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
                        @lang('admin.customer_finances.wallets.transaction.wallet_transactions_log')
                    </h5>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form action="{{ route("admin.wallets.manageWalleBalance", $wallet->id) }}" method="get">
                        <div class="row g-3">
                            <div class="col-xxl-2 col-sm-6">
                                <div>
                                    <input name="created_at" type="text" class="form-control" data-provider="flatpickr"
                                           data-date-format="d M, Y" data-range-date="true" id="demo-datepicker"
                                           placeholder="@lang("admin.customer_finances.wallets.created_at_select")">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-control" data-choices data-choices-search-false
                                            name="type" id="type">
                                        <option value="all" selected>@lang("admin.customer_finances.wallets.all")</option>
                                        <option value="1">@lang("admin.customer_finances.wallets.transaction.add")</option>
                                        <option value="0">@lang("admin.customer_finances.wallets.transaction.sub")</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="submit" class="btn btn-secondary w-100" onclick="SearchData();"><i
                                            class="ri-equalizer-fill me-1 align-bottom"></i>
                                            @lang("admin.customer_finances.wallets.filter")
                                    </button>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <a href="{{ route("admin.wallets.manageWalleBalance", $wallet->id) }}" type="submit" class="btn btn-secondary w-100" onclick="SearchData();"><i
                                        class="ri-equalizer-fill me-1 align-bottom"></i>
                                        @lang("admin.customer_finances.wallets.all")
                                    </a>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <br>
                <div class="card-body pt-0">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="walletsTable">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th>@lang('admin.customer_finances.wallets.transaction.id')</th>
                                    <th>@lang('admin.customer_finances.wallets.transaction.type')</th>
                                    <th>@lang('admin.customer_finances.wallets.transaction.amount')</th>
                                    <th>@lang('admin.customer_finances.wallets.transaction.transaction_type.title')</th>
                                    <th>@lang('admin.customer_finances.wallets.transaction.user_id')</th>
                                    <th>@lang('admin.customer_finances.wallets.transaction.date')</th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach($transactions as $transactionRecord)
                                    <tr>
                                        <td class="transaction_id">{{ $transactionRecord->id }}</td>
                                        <td class="is_active">
                                            <span class="{{ \App\Enums\WalletHistoryTypeStatus::getStatusWithClass($transactionRecord->type)["class"] }}">
                                                {{ \App\Enums\WalletHistoryTypeStatus::getStatusWithClass($transactionRecord->type)["name"] }}
                                            </span>
                                        </td>
                                        <td class="amount">
                                            {{ $transactionRecord->amount_with_sar   . ' ' . __('translation.sar') }}
                                            @if ($transactionRecord->is_opening_balance)
                                                <span class="badge badge-soft-success text-uppercase">
                                                    @lang("admin.customer_finances.wallets.transaction.opening_balance")
                                                </span>
                                            @endif
                                        </td>
                                        <td class="charging_type">
                                            
                                            {{ \App\Enums\WalletTransactionTypes::getTypes($transactionRecord->transaction_type) }}
                                        </td>
                                        <td class="amount">
                                            @if (!empty($transactionRecord->userDoTransaction))
                                                {{ $transactionRecord->userDoTransaction->name . "-" . $transactionRecord->userDoTransaction->type }}   
                                            @else
                                                @lang("admin.not_found")
                                            @endif
                                        </td>
                                        <td class="amount">{{ $transactionRecord->created_at->translatedFormat('d-m-Y h:i A') }}</td>
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
                                    <h5 class="mt-2">@lang('admin.customer_finances.wallets.transaction.no_result_found')</h5>
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
@endsection
