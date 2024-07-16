@extends('admin.layouts.master')
@section('title')
    @lang("admin.vendorWallets.show")
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
    <div class="row">
        <div class="col-xxl-6">
            <div class="card">
                <div class="row g-0">
                    <div class="col-lg-12">
                        <div class="card-body border-end">
                            <b>@lang("admin.vendorWallets.id")</b> {{ $vendorWallet->id }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.vendorWallets.vendor_name")</b> {{ $vendorWallet?->vendor?->name }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.vendorWallets.user_vendor_name")</b> {{ $vendorWallet?->vendor?->owner?->name }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.vendorWallets.current_wallet_balance")</b>
                            {{ $vendorWallet->balance  . ' ' . __('translation.sar') }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.vendorWallets.last_update")</b> {{ $vendorWallet?->updated_at?->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6">
            <div class="card">
                <div class="card-header">
                    <h5>
                        @lang('admin.vendorWallets.transaction.title')
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route("admin.vendorWallets.update", $vendorWallet->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        <div class="row">
                            <div class="col-md-6">
                                <label for="amount" class="form-label">
                                    @lang("admin.vendorWallets.transaction.amount") <span class="text-danger">*</span>
                                </label>
                                <input type="number" step="0.01" name="amount" class="form-control" />
                                @error('amount')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="order_code" class="form-label"> رقم الطلب الفرعي </label>
                                <input type="text"  name="order_code" class="form-control" placeholder="" />
                            </div>
                            <div class="col-md-6 mt-3">
                                <label class="form-label"> الرقم المرجعي للحوالة  </label>
                                <input type="text" name="reference_num" class="form-control text-left" >
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="receipt" class="form-label">
                                    @lang("admin.vendorWallets.transaction.receipt")
                                </label>
                                <input type="file" name="receipt" id="receipt">
                                @error('receipt')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group mt-3">
                            <label class="form-label"> سبب الخصم  </label>
                            <textarea name="reason" class="form-control" rows="2"></textarea>
                            @error('reason')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <div class="justify-content-end">
                                <label for="" class="form-label"></label>
                                <button type="submit" class="form-control btn btn-primary" id="add-btn">
                                    @lang("admin.vendorWallets.subtract")
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <h5>
                                @lang("admin.vendorWallets.current_wallet_balance"): <span>{{ $vendorWallet->balance . ' '}} {{ __('translation.sar') }}</span>
                            </h5>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <h5 class="text-warning">
                                @lang("admin.vendorWallets.pending_wallet_balance"): <span>{{ $vendorWallet->pendingTransactionAmount() ?? 0 . ' '}} {{ __('translation.sar') }}</span>
                            </h5>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <h5 class="text-success">
                                @lang("admin.vendorWallets.completed_wallet_balance"): <span>{{ $vendorWallet->completedTransactionAmount() ?? 0 . ' '}} {{ __('translation.sar') }}</span>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">

        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="wallets">
                <div class="card-header d-flex justify-content-between">
                    <h5>
                        @lang('admin.vendorWallets.transaction.wallet_transactions_log')
                    </h5>
                    <div>
                        <form class="search-box mb-2" method="GET" action=" ">
                            <input value="{{ request('search') }}" name="search" type="search" class="form-control search" placeholder="@lang('admin.transaction_id_filter_placeholder')">
                            <i class="ri-search-line search-icon"></i>
                        </form>
                    </div>
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
                                    {{-- <th>@lang('admin.vendorWallets.transaction.reference')</th> --}}
                                    {{-- <th>@lang('admin.vendorWallets.transaction.reference_id')</th> --}}
                                    <th>@lang('admin.vendorWallets.transaction.order_code')</th>
                                    <th>@lang('admin.vendorWallets.transaction.admin_by')</th>
                                    <th>@lang('admin.vendorWallets.transaction.receipt_url')</th>
                                    <th>ر.المرجعي للحوالة</th>
                                    <th>@lang('admin.vendorWallets.transaction.status')</th>
                                    <th>سبب الخصم</th>
                                    <th>@lang('admin.vendorWallets.transaction.date')</th>
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
                                        {{-- <td class="refrence">{{ !empty($transactionRecord->reference) ? $transactionRecord->reference : trans("admin.not_found") }}</td> --}}
                                        {{-- <td class="refrence_id">{{ !empty($transactionRecord->reference_id) ? $transactionRecord->reference_id : trans("admin.not_found") }}</td> --}}
                                        <td class="refrence_id">{{ !empty($transactionRecord->referenceOrder->code) ? $transactionRecord->referenceOrder->code : trans("admin.not_found") }}</td>
                                        <td class="by_admin">{{ $transactionRecord->admin->name ?? trans("admin.not_found") }}</td>
                                        <td class="receipt">
                                            @if (!empty($transactionRecord->attachment_url))
                                                <a href="{{ $transactionRecord->attachment_url }}" target="_blank">
                                                    @lang("admin.vendorWallets.transaction.receipt_url")
                                                </a>
                                            @else
                                                @lang("admin.not_found")
                                            @endif
                                        </td>
                                        <td>{{$transactionRecord->reference_num }}</td>
                                        <td class="status">
                                            {{ \App\Enums\VendorWalletTransactionsStatusEnum::getStatus($transactionRecord->status) }}
                                        </td>
                                        <td>
                                            @if($transactionRecord->reason)
                                            <button type="button" class="btn btn-sm btnshowmore" data-reason="{{$transactionRecord->reason}}"> <i class="ri-eye-fill me-1 align-bottom"></i>  </button> 
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

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">التفاصيل: </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalContent">
                    <!-- Content will be inserted here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
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
       $(".btnshowmore").on("click", function() {
            $('#modalContent').html($(this).data('reason'));
            $('#myModal').modal('show');
        });
    </script>
@endsection
