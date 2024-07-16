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
    </style>
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="card-header  border-0">
            <div class="d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">
                    @lang("admin.customer_finances.wallets.manage"): {{ $wallet->customer?->name }}
                </h5>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-xxl-5">
            <div class="card">
                <div class="row g-0">
                    <div class="col-lg-6">
                        <div class="card-body border-end">
                            <div data-simplebar="init" style="max-height: 222px" class="px-3 mx-n3"><div class="simplebar-wrapper" style="margin: 0px -16px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px 16px;">
                                <ul class="list-unstyled mb-0 pt-2" id="candidate-list">
                                    <li>
                                        <a href="javascript:void(0);" class="d-flex align-items-center py-2">
                                            <div class="flex-grow-1">
                                                <h5 class="fs-13 mb-1 text-truncate">
                                                    <span class="candidate-name">
                                                        @lang('admin.admin')
                                                    </span>
                                                    <span class="text-muted fw-normal">
                                                        {{ $wallet->admin?->name }}
                                                    </span>
                                                </h5>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="d-flex align-items-center py-2">
                                            <div class="flex-grow-1">
                                                <h5 class="fs-13 mb-1 text-truncate">
                                                    <span class="candidate-name">
                                                        @lang('admin.customer_finances.wallets.amount')
                                                    </span>
                                                    <span class="text-muted fw-normal">
                                                        {{ $wallet->amount_with_sar  . ' ' . __('translation.sar') }}
                                                    </span>
                                                </h5>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="d-flex align-items-center py-2">
                                            <div class="flex-grow-1">
                                                <h5 class="fs-13 mb-1 text-truncate">
                                                    <span class="candidate-name">
                                                        @lang('admin.customer_finances.wallets.reason')
                                                    </span>
                                                    <span class="text-muted fw-normal">
                                                        {{ $wallet->reason }}
                                                    </span>
                                                </h5>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $wallet->attachment_url }}" target="{{ $wallet->is_has_attachment == true ? "blanck" : "" }}" class="d-flex align-items-center py-2">
                                            <div class="flex-grow-1">
                                                <h5 class="fs-13 mb-1 text-truncate">
                                                    <span class="candidate-name">
                                                        @lang('admin.customer_finances.wallets.attachments')
                                                    </span>
                                                    <span class="text-muted fw-normal">
                                                        <span class="{{ \App\Enums\WalletAttachmentsStatus::getStatusWithClass($wallet->is_has_attachment)["class"] }}">
                                                            {{ \App\Enums\WalletAttachmentsStatus::getStatusWithClass($wallet->is_has_attachment)["name"] }}
                                                        </span>
                                                    </span>
                                                </h5>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="d-flex align-items-center py-2">
                                            <div class="flex-grow-1">
                                                <h5 class="fs-13 mb-1 text-truncate">
                                                    <span class="candidate-name">
                                                        @lang('admin.customer_finances.wallets.is_active')
                                                    </span>
                                                    <span class="text-muted fw-normal">
                                                        <span class="{{ \App\Enums\WalletStatus::getStatusWithClass($wallet->is_active)["class"] }}">
                                                            {{ \App\Enums\WalletStatus::getStatusWithClass($wallet->is_active)["name"] }}
                                                        </span>
                                                    </span>
                                                </h5>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="d-flex align-items-center py-2">
                                            <div class="flex-grow-1">
                                                <h5 class="fs-13 mb-1 text-truncate">
                                                    <span class="candidate-name">
                                                        @lang('admin.customer_finances.wallets.last_update')
                                                    </span>
                                                    <span class="text-muted fw-normal">
                                                        {{ $wallet->created_at?->diffForHumans() }}
                                                    </span>
                                                </h5>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div><div class="simplebar-placeholder" style="width: auto; height: 248px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 145px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card-body text-center">
                            <div class="avatar-md mb-3 mx-auto">
                                <img src="{{ url($wallet->customer?->avatar) }}" alt="{{ $wallet->customer?->name }} avatar" id="candidate-img" class="img-thumbnail rounded-circle shadow-none">
                            </div>

                            <h5 id="candidate-name" class="mb-0">
                                {{ $wallet->customer?->name }}
                            </h5>
                            <br>
                            <p id="candidate-position" class="text-muted">
                                @lang("admin.customer_finances.wallets.customer_info.email"): {{ $wallet->customer?->email }}
                            </p>

                            <p id="candidate-position" class="text-muted">
                                @lang("admin.customer_finances.wallets.customer_info.phone"): {{ $wallet->customer?->phone ?? trans("admin.not_found") }}
                            </p>
                            <div>
                                <a href="{{ route("admin.wallets.manageWalleBalance", $wallet->id) }}" class="btn btn-success rounded-pill w-sm">
                                    <i class="ri-add-fill me-1 align-bottom"></i> @lang("admin.customer_finances.wallets.manage_wallet_balance")
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">
                            @lang("admin.customer_finances.wallets.change_status")
                        </h5>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form action="{{ route('admin.wallets.update', $wallet->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method("put")
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="is_active" class="form-label">
                                    @lang("admin.customer_finances.wallets.is_active")
                                </label>
                                <select class="select2 form-control" name="is_active" id="select2_is_active">
                                    <option value="">
                                        @lang("admin.customer_finances.wallets.choose_state")
                                    </option>
                                    @foreach ($statusOfWallet as $state)
                                        @if($wallet->is_active == $state["value"])
                                            <option selected value="{{ $state["value"] }}">
                                                {{ $state["name"] }}
                                            </option>
                                        @else
                                            <option value="{{ $state["value"] }}">
                                                {{ $state["name"] }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('is_active')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="hstack gap-2 justify-content-end">
                                <a href="{{ route("admin.wallets.index") }}" class="btn btn-light">
                                    @lang("admin.back")
                                </a>
                                <button type="submit" class="btn btn-primary" id="add-btn">
                                    @lang("admin.edit")
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
