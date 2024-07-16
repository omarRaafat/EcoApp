@extends('admin.layouts.master')
@section('title')
    @lang('admin.customer_finances.wallets.title')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="wallets">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">@lang('admin.customer_finances.wallets.title')</h5>
                        <div class="flex-shrink-0">
                            <div class="d-flex gap-1 flex-wrap">
                                {{-- <a href="{{ route("admin.wallets.create") }}" class="btn btn-primary add-btn" id="create-btn">
                                    <i class="ri-add-line align-bottom me-1"></i>  @lang("admin.customer_finances.wallets.create")
                                </a> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form action="{{ route("admin.wallets.index") }}" method="get">
                        <div class="row g-3">
                            <div class="col-xxl-5 col-sm-6">
                                <div class="search-box">
                                    <input type="text" name="search" class="form-control search" value="{{ request()->get('search') }}"
                                           placeholder="@lang("admin.customer_finances.wallets.search")">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select name="is_active" class="form-control" data-choices data-choices-search-false  id="idStatus">
                                        <option @selected(request()->get('is_active') == 'all') value="all" selected>@lang("admin.customer_finances.wallets.all")</option>
                                        <option @selected(request()->get('is_active') == '1') value="1">@lang("admin.customer_finances.wallets.active")</option>
                                        <option @selected(request()->get('is_active') == '0') value="0">@lang("admin.customer_finances.wallets.inactive")</option>
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
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <div class="card-body pt-0">
                    <div>
                        <ul class="nav nav-tabs nav-tabs-custom nav-primary mb-3" role="tablist">
                            <li class="nav-item">
                                <form action="{{ route("admin.wallets.index") }}" method="get">
                                    <button class="nav-link py-3 {{ empty(request()->query()) ? 'active' : '' }}" data-bs-toggle="tab" id="active" role="tab" aria-selected="false">
                                    <i class="ri-store-2-fill me-1 align-bottom"></i> @lang("admin.customer_finances.wallets.all_wallets")
                                    </button>
                                </form>
                            </li>
                            <li class="nav-item">
                                <form action="{{ route("admin.wallets.index") }}" method="get">
                                    <input type="hidden" name="is_active" value="1">
                                    <button class="nav-link py-3 {{ request()->has("is_active") && request()->is_active ==  1 ? 'active' : '' }}" data-bs-toggle="tab" id="active" role="tab" aria-selected="false">
                                        <i class="ri-checkbox-circle-line me-1 align-bottom"></i> @lang("admin.customer_finances.wallets.active")
                                        <span class="badge bg-secondary align-middle ms-1">
                                            {{ $activeWalletsCount }}
                                        </span>
                                    </button>
                                </form>
                            </li>
                            <li class="nav-item">
                                <form action="{{ route("admin.wallets.index") }}" method="get">
                                    <input type="hidden" name="is_active" value="0">
                                    <button type="submit" class="nav-link py-3 {{ request()->has("is_active") && request()->is_active ==  0 ? 'active' : '' }}" data-bs-toggle="tab" id="inactive" role="tab" aria-selected="false">
                                        <i class="ri-truck-line me-1 align-bottom"></i> @lang("admin.customer_finances.wallets.inactive")
                                            <span class="badge bg-secondary align-middle ms-1">
                                            {{ $inactiveWalletsCount }}
                                        </span>
                                    </button>
                                </form>
                            </li>
                        </ul>

                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="walletsTable">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th>@lang('admin.customer_finances.wallets.id')</th>
                                    <th>@lang('admin.customer_finances.wallets.customer_name')</th>
                                    <th>@lang('admin.customer_finances.wallets.amount')</th>
                                    <th>@lang('admin.customer_finances.wallets.reason')</th>
                                    <th>@lang('admin.customer_finances.wallets.attachments')</th>
                                    <th>@lang('admin.customer_finances.wallets.is_active')</th>
                                    <th>@lang('admin.customer_finances.wallets.by_admin')</th>
                                    <th>@lang('admin.customer_finances.wallets.last_update')</th>
                                    <th>@lang('translation.actions')</th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach($wallets as $wallet)
                                    <tr>
                                        <td class="id">
                                            <a href="{{ route("admin.wallets.show", $wallet->id) }}"class="fw-medium link-primary">
                                                #{{$wallet->id}} 
                                            </a>
                                        </td>
                                        <td class="customer_id">{{ $wallet->customer?->name }}</td>
                                        <td class="amount">{{ $wallet->amount_with_sar  . ' ' . __('translation.sar') }}</td>
                                        <td class="reason">{{ $wallet->reason }}</td>
                                        <td class="attachments">
                                            <a href="{{ $wallet->attachment_url }}" target="{{ $wallet->is_has_attachment == true ? "blanck" : "" }}">
                                                <span class="{{ \App\Enums\WalletAttachmentsStatus::getStatusWithClass($wallet->is_has_attachment)["class"] }}">
                                                    {{ \App\Enums\WalletAttachmentsStatus::getStatusWithClass($wallet->is_has_attachment)["name"] }}
                                                </span>                                            
                                            </a>
                                        </td>
                                        <td class="is_active">
                                            <span class="{{ \App\Enums\WalletStatus::getStatusWithClass($wallet->is_active)["class"] }}">
                                                {{ \App\Enums\WalletStatus::getStatusWithClass($wallet->is_active)["name"] }}
                                            </span>
                                        </td>
                                        <td class="admin_id">{{ $wallet->admin?->name }}</td>
                                        <td class="date">{{ $wallet->updated_at?->diffForHumans() }}</td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="@lang('admin.customer_finances.wallets.manage')">
                                                    <a href="{{ route("admin.wallets.show", $wallet->id) }}"
                                                       class="text-primary d-inline-block">
                                                        <i class="ri-eye-fill fs-16"></i>
                                                    </a>
                                                </li>
                                            </ul>
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
                                    <h5 class="mt-2">@lang('admin.customer_finances.wallets.no_result_found')</h5>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                {{ $wallets->appends(request()->query())->links("pagination::bootstrap-4") }}
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
