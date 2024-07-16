@extends('admin.layouts.master')

@section('title')
    @lang('Invoice.label')
@endsection

@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">
                            {{--                            @lang('Invoice.label')--}}
                        </h5>
                        <div class="flex-shrink-0">
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="{{ route('admin.invoices.export-pdf', ["invoice" => $invoice->id]) }}"
                                   class="btn btn-primary add-btn" id="create-btn">
                                    @lang("Invoice.print.label")
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">@lang('Invoice.label')</h5>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <!-- Col Form Label Default -->
                    <div class="row g-3">
                        <div class="col-xxl-3 col-sm-4">
                            <span>@lang('Invoice.attributes.number'):</span>
                            {{$invoice->id}}
                        </div>
                        <div class="col-xxl-3 col-sm-4">
                            <span>@lang('admin.vendor_name'):</span>
                            <a href="{{route("admin.vendors.show", ["vendor" => $invoice->vendor_id])}}">{{ $invoice->vendor->name }}</a>
                        </div>
                        <div class="col-xxl-3 col-sm-4">
                            <span>@lang('Invoice.attributes.period'):</span>
                            {{$invoice->period_start_at->format("Y/m/d") ." - ". $invoice->period_end_at->format("Y/m/d") }}
                        </div>
                        <div class="col-xxl-3 col-sm-4">
                            <span>@lang('Invoice.attributes.created_at'):</span>
                            {{$invoice->created_at->format("Y-m-d H:i")}}
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <!-- Col Form Label Default -->
                    <div class="row g-3">
                        <div class="col-xxl-3 col-sm-4">
                            <span>@lang('Invoice.orders_count'):</span>
                            {{number_format($invoice->orders()->count()), 2}}
                        </div>
                        <div class="col-xxl-3 col-sm-4">
                            <span>@lang('Invoice.attributes.total_without_vat'):</span>
                            {{number_format($invoice->total_without_vat, 2)}} @lang("translation.sar")
                        </div>
                        <div class="col-xxl-3 col-sm-4">
                            <span>@lang('Invoice.attributes.vat_amount'):</span>
                            {{number_format($invoice->vat_amount, 2)}} @lang("translation.sar")
                        </div>
                        <div class="col-xxl-3 col-sm-4">
                            <span>@lang('Invoice.attributes.total_with_vat'):</span>
                            {{number_format($invoice->total_with_vat, 2)}} @lang("translation.sar")
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th>@lang('translation.order_id')</th>
                                    <th>@lang('translation.customer')</th>
                                    <th>@lang('admin.total')</th>
                                    <th>@lang('translation.order_date')</th>
                                    <th>@lang('translation.actions')</th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach($invoice->orders as $key => $transaction)
                                    <tr>
                                        <td>{{ $transaction->code }}</td>
                                        <td>
                                            <a data-bs-toggle="modal" data-bs-target="#exampleModalScrollable{{$key}}"
                                               href="#">
                                                {{ $transaction->customer_name ?? null }}
                                            </a>

                                        </td>
                                        <td>{{ $transaction->total .'  '. __('translation.sar') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($transaction->created_at)->toFormattedDateString() }}</td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                    <a href="{{ route('admin.transactions.show', ['transaction' => $transaction->transaction_id]) }}"
                                                       class="text-primary d-inline-block">
                                                        <i class="ri-eye-fill fs-16"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="exampleModalScrollable{{$key}}" tabindex="-1"
                                         role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="exampleModalScrollableTitle">@lang('admin.customer_details')</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close">
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
                </div>
            </div>
        </div>
    </div>
@endsection
