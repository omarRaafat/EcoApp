@extends('admin.layouts.master')
@section('title')
    @lang('admin.transactions_list')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @include("components.session-alert")
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">@lang('admin.transactions')</h5>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form method="get" action="{{ URL::asset('/admin') }}/service-transactions/">
                        <div class="row g-3">
                            <div class="col-xxl-3 col-sm-4">
                                <div class="search-box">
                                    <input value="{{ request('customer') }}" name="customer" type="text" class="form-control search" placeholder="@lang('admin.transaction_customer_filter_placeholder')">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-sm-4">
                                <div class="search-box">
                                    <input value="{{ request('transaction_id') }}" name="transaction_id" type="text" class="form-control search" placeholder="@lang('admin.transaction_id_filter_placeholder')">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <input value="{{ request('from') }}" name="from" type="text" class="form-control flatpickr-input active" data-provider="flatpickr"  data-maxDate="today" data-date-format="Y-m-d" placeholder="@lang('admin.from')">
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <input value="{{ request('to') }}" name="to" type="text" class="form-control flatpickr-input active" data-provider="flatpickr"  data-maxDate="today" data-date-format="Y-m-d" placeholder="@lang('admin.to')">
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select name="main_status" class="form-control" data-choices data-choices-search-false name="choices-single-defaults" id="idStatus">
                                        <option @if(request('main_status') == '') SELECTED @endif value="">@lang('admin.main_transaction_statuses')</option>
                                        <option @if(request('main_status') == 'completed') SELECTED @endif value="completed">@lang('admin.completed')</option>
                                        <option @if(request('main_status') == 'none_completed') SELECTED @endif value="none_completed">@lang('admin.none_completed')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select name="status" class="form-control" data-choices data-choices-search-false name="choices-single-default" id="idStatus">
                                        <option @if(request('status') == '') SELECTED @endif value="">@lang('admin.transaction_statuses')</option>
                                        @foreach($statuses as $key => $status)
                                            <option @selected(request()->get('status') == $key) value="{{ $key }}"> {{ $status }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-control" data-choices data-choices-search-false name="per_page" id="per_page">
                                        <option @if(blank(request('per_page'))) SELECTED @endif value="">@lang('admin.item_per_page')</option>
                                        @foreach(config("view.items_per_page") as $items_per_page)
                                            <option value="{{ $items_per_page }}" @selected(request()->get('per_page') ==  $items_per_page)>
                                                {{ $items_per_page }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <button type="submit" class="btn btn-secondary w-100">
                                        <i class="ri-equalizer-fill me-1 align-bottom"></i> تصفية
                                    </button>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <a href="{{ route('admin.service_transactions.export' , [
                                        'customer' => request()->get('customer') ,
                                         'transaction_id' => request()->get('transaction_id') ,
                                         'from' => request()->get('from') ,
                                         'to' => request()->get('to') ,
                                         'status' => request()->get('status') ,
                                         'main_status' => request()->get('main_status') ,
                                         ]) }}" class="btn btn-primary"> تصدير Excel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th>@lang('translation.order_id')</th>
                                    <th>@lang('translation.customer')</th>
                                    <th>@lang('translation.phone')</th>
                                    <th>@lang('translation.services')</th>
                                    <th>@lang('admin.payment_method')</th>
                                    <th>@lang('admin.total')</th>
                                    <th>@lang('admin.vendors_count')</th>
                                    <th>@lang('admin.service_shipping_to')</th>
                                    <th>@lang('translation.order_date')</th>
                                    <th>@lang('translation.order_status')</th>
                                    <th>@lang('translation.actions')</th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach($transactions as $key => $transaction)
                                    <tr>
                                        <td>{{ $transaction->code }}</td>
                                        <td>
                                            <a data-bs-toggle="modal" data-bs-target="#exampleModalScrollable{{$key}}" href="#">
                                                {{ $transaction->customer_name ?? null }}
                                            </a>

                                        </td>
                                        <td>{{ $transaction->customer->phone ?? null }}</td>
                                        <td>{{ (int)$transaction->products_count }}</td>
                                        <td> {{$transaction->getPaymentMethod()}} </td>
                                        <td>{{ $transaction->total .'  '. __('translation.sar') }}</td>
                                        <td>{{ $transaction->orderServices->count() }}</td>
                                        <td>{{ $transaction->city->name ?? trans("admin.not_found")}}</td>
                                        <td>{{ \Carbon\Carbon::parse($transaction->created_at)->toFormattedDateString() }}</td>
                                        <td>
                                            <span class="badge {{ ($transaction->status == "canceled") ? 'badge-danger' : 'badge-info' }}">
                                                {{ $transaction->transStatus()  }}
                                            </span>
                                        </td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                    <a href="{{ route('admin.service_transactions.show', ['transaction' => $transaction]) }}" class="text-primary d-inline-block">
                                                        <i class="ri-eye-fill fs-16"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="manage">
                                                    <a href="{{ route('admin.service_transactions.manage', ['transaction' => $transaction]) }}" class="text-primary d-inline-block">
                                                        <i class="ri-edit-2-fill"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="exampleModalScrollable{{$key}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalScrollableTitle">@lang('admin.customer_details')</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="live-preview">
                                                        @include('admin.transaction.include.customer_details')
                                                    </div>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->

                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
