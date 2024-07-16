@extends('vendor.layouts.master')
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
                    {{ auth()->user()->vendor->name }}
                </h5>
            </div>
        </div>
    </div>
    <br>

    @include('sweetalert::alert')
    <div class="row">
        <div class="col-xxl-3">
            <div class="card">
                <div class="card-body p-4">
                    <div>
                        <div class="flex-shrink-0 avatar-md mx-auto">
                            <div class="avatar-title bg-light rounded">
                                <img src="{{ ossStorageUrl(auth()->user()->vendor->logo) }}" alt="" height="50" />
                            </div>
                        </div>
                        <div class="mt-4 text-center">
                            <h5 class="mb-1">{{ $vendorWallet?->vendor?->name }}</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table mb-0 table-borderless">
                                <tbody>
                                    <tr>
                                        <th><span class="fw-medium">@lang("admin.vendorWallets.user_vendor_name")</span></th>
                                        <td>{{ $vendorWallet?->vendor?->owner?->name }}</td>
                                    </tr>
                                    <tr>
                                        <th><span class="fw-medium">@lang('translation.email')</span></th>
                                        <td>{{ $vendorWallet?->vendor?->owner?->email }}</td>
                                    </tr>
                                    <tr>
                                        <th><span class="fw-medium">@lang("admin.vendorWallets.amount")</span></th>
                                        <td style="font-weight:bold;color: #35b91e">{{ $vendorWallet->balance  . ' ' . __('translation.sar') }}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    <h5>
                        @lang('admin.vendorWallets.transaction.title')
                    </h5>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <h5>
                                @lang("admin.vendorWallets.current_wallet_balance"): <span>{{ $vendorWallet->balance . ' '}} {{  __('translation.sar') }}</span>
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
            <div class="card" id="wallets">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <h5>
                                @lang('admin.vendorWallets.transaction.wallet_transactions_log')
                            </h5>
                        </div>

                    </div>
                </div>
                <br>
                <div class="card-body mb-3">
                    <form action="{{route('vendor.wallet')}}" >
                        <div class="row g-3">
                            <div class="col-xxl-3 col-sm-6">
                                <div>
                                    <input type="text" name="date_from" class="form-control" data-provider="flatpickr" data-date-format="Y-m-d"  id="demo-datepicker" placeholder="@lang('translation.date_from')" @if(isset($request)) value="{{$request->date_from}}" @endif required>
                                </div>
                            </div>
                            <!--end col-->
                            <!--end col-->
                            <div class="col-xxl-3 col-sm-6">
                                <div>
                                    <input type="text" name="date_to" class="form-control" data-provider="flatpickr" data-date-format="Y-m-d"  id="demo-datepicker" placeholder="@lang('translation.date_to')" @if(isset($request)) value="{{$request->date_to}}" @endif required>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <button type="submit" class="btn btn-info w-100" onclick="SearchData();"> <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                        @lang('translation.filter')
                                    </button>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <a href="{{route('vendor.wallet')}}" type="reset" class="btn btn-secondary w-100"> <i class=" ri-loader-3-line me-1 align-bottom"></i>
                                        @lang('translation.reset')
                                    </a>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <div class="card-body pt-0">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="walletsTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th>@lang('admin.vendorWallets.transaction.id')</th>
                                        <th>@lang('admin.vendorWallets.transaction.amount')</th>
                                        <th>@lang('admin.vendorWallets.transaction.operation_type')</th>
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
                                            {{ $transactionRecord->amount   . ' ' . __('translation.sar') }}
                                        </td>
                                        <td class="operation_type">
                                            {{ \App\Enums\VendorWallet::getTypeWithClass($transactionRecord->operation_type)["name"] }}
                                        </td>
                                        {{-- <td class="refrence_id">{{ isset($transactionRecord->referenceOrder) ? $transactionRecord->referenceOrder->id : trans("admin.not_found") }}</td> --}}
                                        <td class="refrence_id">{{ isset($transactionRecord->referenceOrder) ? $transactionRecord->referenceOrder->code : trans("admin.not_found") }}</td>
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
                                        <td>{{$transactionRecord->reference_num }}</td>
                                        <td class="status">
                                            {{ \App\Enums\VendorWalletTransactionsStatusEnum::getStatus($transactionRecord->status) }}
                                        </td>
                                        <td>
                                            @if($transactionRecord->reason)
                                            <button type="button" class="btn btn-sm btnshowmore" data-reason="{{$transactionRecord->reason}}"> <i class="ri-eye-fill me-1 align-bottom"></i> </button> 
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
