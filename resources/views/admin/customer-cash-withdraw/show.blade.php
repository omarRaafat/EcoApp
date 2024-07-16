@extends('admin.layouts.master')
@section('title')
    @lang("admin.customer_finances.wallets.manage")
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
    <style>
        #amount {
            direction: {{ app()->getLocale() == "ar" ? 'rtl!important' : 'ltr!important'}} ;
        }
        .font-size-14 {
            font-size: 14px !important;
        }
        .hidden {
            display: none
        }
    </style>
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="card-header  border-0">
            <div class="d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">
                    @lang("admin.customer_finances.customer-cash-withdraw.show-page-title"): {{ $withdrawRequest?->customer?->name }}
                </h5>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-xxl-6">
            <div class="card">
                <div class="row g-0">
                    <div class="col-lg-12">
                        <div class="card-body border-end">
                            <div data-simplebar="init" style="height: auto" class="px-3 mx-n3">
                                <ul class="list-unstyled mb-0 pt-2" id="candidate-list">
                                    @foreach($rows ?? [] as $row)
                                        <li>
                                            <div class="d-flex align-items-center py-2">
                                                <div class="flex-grow-1">
                                                    <h5 class="fs-13 mb-1 text-truncate">
                                                        <span class="candidate-name">
                                                            @lang('admin.customer_finances.customer-cash-withdraw.'. $row['key'])
                                                        </span>
                                                        <span class="{{ $row['class'] ?? 'text-muted fw-normal' }}">
                                                            {{ $row['value'] }}
                                                        </span>
                                                    </h5>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($withdrawRequest->admin_action == \App\Enums\CustomerWithdrawRequestEnum::PENDING)
        <div class="col-xxl-6">
            <div class="card">
                <div class="row g-0">
                    <div class="col-lg-12">
                        <div class="card-body border-end">
                            <div data-simplebar="init" style="height: auto" class="px-3 mx-n3">
                                <form action="{{ route('admin.customer-cash-withdraw.update', ['withdrawRequest' => $withdrawRequest]) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label> @lang("admin.customer_finances.customer-cash-withdraw.status") </label>
                                            <select  name="status"
                                                onchange="changeStatusForm(this)"
                                                class="form-control" data-choices data-choices-search-false>
                                                @foreach ($statuses ?? [] as $status)
                                                    <option value="{{ $status }}" @selected($status == (old('status') ?? $withdrawRequest->admin_action))>
                                                        @lang('admin.customer_finances.customer-cash-withdraw.statuses.'. $status)
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('status')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div id="input-for-not-approved" class="{{ (old('status') ?? '') == \App\Enums\CustomerWithdrawRequestEnum::NOT_APPROVED ? '' : 'hidden' }}">
                                            <div class="form-group mb-3">
                                                <label> @lang("admin.customer_finances.customer-cash-withdraw.reject-reason") </label>
                                                <input type="text" name="reject_reason" class="form-control"
                                                    placeholder="@lang("admin.customer_finances.customer-cash-withdraw.reject-reason")"/>
                                                @error('reject_reason')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div id="input-for-approved" class="{{ (old('status') ?? '') == \App\Enums\CustomerWithdrawRequestEnum::APPROVED ? '' : 'hidden' }}">
                                            <div class="form-group mb-3">
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
                                            <div class="form-group mb-3">
                                                <label> @lang("admin.customer_finances.customer-cash-withdraw.bank-receipt") </label>
                                                <input type="file" name="bank_receipt" class="form-control" id="receipt-input"/>
                                                <img id="preview-image" class="hidden" width="100%"/>
                                                <embed id="preview-pdf" type="application/pdf" width="100%" height="400" class="hidden"/>
                                                @error('bank_receipt')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="submit" class="btn btn-primary" id="change-status-btn">
                                                @lang("admin.customer_finances.customer-cash-withdraw.save-status")
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if($withdrawRequest->bank_receipt)
        <div class="col-xxl-6">
            <div class="card">
                <div class="row g-0">
                    <div class="col-lg-12">
                        <div class="card-body border-end">
                            <div data-simplebar="init" style="height: auto" class="px-3 mx-n3">
                                <h4 class="mb-4"> @lang("admin.customer_finances.customer-cash-withdraw.bank-receipt") </h4>
                                @if (str_contains($withdrawRequest->getReceiptUrl(), "pdf"))
                                    <embed type="application/pdf" width="100%" height="400" src="{{ $withdrawRequest->getReceiptUrl() }}"/>
                                @else
                                    <img src="{{ $withdrawRequest->getReceiptUrl() }}" width="100%"/>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
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
@section('script-bottom')
    <script>
        function changeStatusForm(e) {
            document.getElementById("input-for-not-approved").classList.add('hidden')
            document.getElementById("input-for-approved").classList.add('hidden')
            if (e.value == "{{ \App\Enums\CustomerWithdrawRequestEnum::APPROVED }}") {
                document.getElementById("input-for-approved").classList.remove('hidden')
            } else if (e.value == "{{ \App\Enums\CustomerWithdrawRequestEnum::NOT_APPROVED }}") {
                document.getElementById("input-for-not-approved").classList.remove('hidden')
            }
            console.log(e.value)
        }

        $(document).ready(function () {
            $('#receipt-input').on('change', function (e) {
                const file = e.target.files[0]
                if (file) {
                    let selector = "preview-image"
                    if (file.type == "application/pdf") selector = "preview-pdf"

                    document.getElementById(selector).src = URL.createObjectURL(file)
                    document.getElementById(selector).classList.remove("hidden")
                }
            })
        })
    </script>
@endsection
