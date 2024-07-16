@extends('admin.layouts.master')

@section('title')
    @lang('admin.transaction_invoice.header_title') #{{ $transaction->code }}
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-xxl-9">
        <div class="card" id="demo">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-header border-bottom-dashed p-4">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h6>
                                    <span class="text-muted fw-normal">
                                        <b style="font-size: 18px"> @lang("admin.transaction_invoice.app_name") </b>
                                    </span>
                                </h6>
                                <h6>
                                    <span class="text-muted fw-normal">
                                        @lang("admin.transaction_invoice.invoice_no"):
                                    </span>
                                    <span id="transaction_id">
                                        #{{ $transaction->code ?? "" }}
                                    </span>
                                </h6>
                                <h6 class="mb-0">
                                    <span class="text-muted fw-normal">
                                        @lang("admin.transaction_invoice.date"):
                                    </span>
                                    <span id="contact-no">
                                        {{ \Carbon\Carbon::parse($transaction->date)->format("d-m-Y H:i") }}
                                    </span>
                                </h6>
                            </div>
                            <div class="flex-shrink-0 mt-sm-0 mt-3">
                                <img src="{{asset('images/logo.png')}}" class="card-logo" height="90">
                            </div>
                        </div>
                        <h4 class="text-center" style="padding-right:51px">
                            @lang("admin.transaction_invoice.invoice_brif")
                        </h4>
                    </div>

                </div>
                <div class="card-body p-4 border-top border-top-dashed">
                    <div class="row g-3">
                        <div class="col-lg-10">
                            <p class="text-muted mb-2 text-uppercase fw-semibold">بيانات المشتري</p>
                            <p class="text-muted mb-2 text-uppercase fw-semibold"> المشتري : {{$transaction->client->name}}</p>
                            <p class="text-muted mb-2 text-uppercase fw-semibold"> الجوال : {{$transaction->client->phone}}</p>
                        </div><!--end col-->
                        <div class="col-2">
                            <p class="text-muted mb-2 text-uppercase fw-semibold">@lang("admin.payment_method")</p>
                            <span class="badge badge-soft-success fs-11" id="payment-status">
                                {{ $transaction->getPaymentMethod() }}
                            </span>
                        </div><!--end col-->

                    </div>
                    <!--end row-->
                </div>


                <div class="col-lg-12">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            @if($transaction->orderServices->count() > 0)
                                @foreach ($transaction->orderServices as $order)
                                    <div class="row">
                                        <div class="col-md-6">
                                            @lang("admin.vendor_name"): {{ $order->vendor->name }}
                                        </div>
                                        <div class="col-md-4">
                                            @lang("translation.tax_num"): {{ $order->vendor->tax_num }}
                                        </div>
                                        <div class="col-md-2">
                                            @lang("admin.transaction_invoice.invoice_no"): #{{ $order->code }}
                                        </div>
                                    </div>
                                    <br>
                                    <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                        <thead>
                                            <tr class="table-active">
                                                <th
                                                style="width: 100px; white-space: normal;"
                                                scope="col">@lang("admin.transaction_invoice.services_table_header.service_details")</th>
                                                <th
                                                style="width: 100px; white-space: normal;"
                                                scope="col">@lang("admin.transaction_invoice.services_table_header.rate")</th>
                                                <th
                                                style="width: 100px; white-space: normal;"

                                                scope="col">@lang("admin.transaction_invoice.services_table_header.quantity")</th>
                                                <th
                                                style="width: 100px; white-space: normal;"

                                                scope="col">@lang("admin.transaction_invoice.services_table_header.amount")</th>
                                                <th
                                                style="width: 100px; white-space: normal;"
                                                scope="col">@lang("admin.transaction_invoice.services_table_header.tax_value")</th>
                                                <th
                                                style="width: 100px; white-space: normal;"
                                                scope="col">@lang("admin.transaction_invoice.services_table_header.total_with_tax")</th>
                                            </tr>
                                        </thead>
                                        <tbody id="services-list">
                                                @foreach ($order->orderServices as $serviceItem)
                                                    <tr>
                                                        <td

                                                        style="max-width: 100px"
                                                        class="text-start">
                                                            <span class="fw-medium" style="white-space: normal;">{{ $serviceItem->service?->name }}</span>
                                                        </td>
                                                        <td>{{ $serviceItem->unit_price  }} @lang("translation.sar")</td>
                                                        <td>{{ $serviceItem->quantity }}</td>
                                                        <td>{{ $order->sub_total}} @lang("translation.sar")</td>

                                                        {{-- $vatRate = round($serviceItem->total - ($serviceItem->total / "1.$serviceItem->vat_percentage"),2); --}}

                                                        <td>{{ round($serviceItem->total - ($serviceItem->total / "1.$serviceItem->vat_percentage"),2)}} @lang("translation.sar") ({{ $serviceItem->vat_percentage }}%)</td>
                                                        <td>{{ $serviceItem->total }} @lang("translation.sar")</td>
                                                    </tr>
                                                @endforeach
                                        </tbody>
                                    </table><!--end table-->
                                    <br>
                                @endforeach
                            @else
                                <center>
                                    @lang("admin.transaction_invoice.not_found")
                                </center>
                            @endif
                        </div>

                        <div class="border-top border-top-dashed mt-2">
                            <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" style="width:250px">
                                <tbody>
                                    <tr>
                                        <td>
                                            @lang("admin.transaction_invoice.sub_total")
                                        </td>
                                        <td class="text-end">
                                            {{ $transaction->sub_total ?? 0}} @lang("translation.sar")
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @lang("admin.transaction_invoice.estimated_tax") ({{ $transaction->vat_percentage }}%)
                                        </td>
                                        <td class="text-end">
                                            {{ $transaction->total_vat ?? 0}} @lang("translation.sar")
                                        </td>
                                    </tr>
                                    @if($transaction->discount)
                                        <tr>
                                            <td>
                                                @lang("admin.transaction_invoice.discount") <small class="text-muted"></small>
                                            </td>
                                            <td class="text-end">-
                                                {{ $transaction->discount ?? 0}} @lang("translation.sar")
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td>
                                            @lang("admin.transaction_invoice.sub_total_without_vat") <small class="text-muted"></small>
                                        </td>
                                        <td class="text-end">
                                            {{ $transaction->sub_total ?? 0}} @lang("translation.sar")
                                        </td>
                                    </tr>
                                    {{-- @if($transaction->wallet_amount > 0) --}}
                                        <tr>
                                            <td>
                                                @lang("admin.transaction_invoice.sub_from_wallet") <small class="text-muted"></small>
                                            </td>
                                            <td class="text-end">
                                                {{ $transaction->orderServices()->sum('wallet_amount') ?? 0}} @lang("translation.sar")
                                            </td>
                                        </tr>
                                    {{-- @endif/ --}}
                                    {{-- @if($transaction-totalWithoutVat) --}}

                                    {{-- @endif --}}
                                    <tr class="border-top border-top-dashed fs-15">
                                        <td scope="row">
                                            @lang('admin.transaction_invoice.total_amount')
                                        </td>
                                        <td class="text-end">
                                            {{ $transaction->total  }} @lang("translation.sar")
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

            </div><!--end row-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
