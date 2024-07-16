@extends('vendor.layouts.master')

@section('title')
    @lang('admin.transaction_invoice.header_title') #{{ $order->id }}
@endsection

@section('content')
@include('sweetalert::alert')

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
                                        #{{ $order->transaction->code ?? "" }}
                                    </span>
                                </h6>
                                <h6>
                                    <span class="text-muted fw-normal">
                                        @lang("admin.transaction_invoice.tax_no"):
                                    </span>
                                    <span id="tax_no"> {{ $order?->vendor?->tax_num }} </span>
                                </h6>
                                @if (isset($orderShip))
                                    <h6>
                                        <span class="text-muted fw-normal">
                                            @lang("admin.transaction_invoice.shipment_no"):
                                        </span>
                                        310876568300003
                                    </h6>
                                @endif
                                <h6 class="mb-0">
                                    <span class="text-muted fw-normal">
                                        @lang("admin.transaction_invoice.date"):
                                    </span>
                                    <span id="contact-no">
                                        {{ \Carbon\Carbon::parse($order->date)->format("d-m-Y H:i") }}
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
                            <p class="text-muted mb-2 text-uppercase fw-semibold"> المشتري : {{$order->transaction->client->name}}</p>
                            <p class="text-muted mb-2 text-uppercase fw-semibold"> الجوال : {{$order->transaction->client->phone}}</p>
                        </div><!--end col-->


                        <div class="col-lg-2">
                            <p class="text-muted mb-2 text-uppercase fw-semibold">@lang("admin.payment_method")</p>
                            <span class="badge badge-soft-success fs-11" id="payment-status">
                                {{ $order->getPaymentMethod() }}
                            </span>
                        </div><!--end col-->
                    </div>
                    <!--end row-->
                </div>


                <div class="col-lg-12">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <div class="row">
                                <div class="col-md-4">
                                    @lang("admin.vendor_name"): {{ $order->vendor->name }}
                                </div>
                                <div class="col-md-4">
                                    @lang("translation.tax_num"): {{ $order->vendor->tax_num }}
                                </div>
                                <div class="col-md-4">
                                    @lang("admin.transaction_invoice.invoice_name"): #{{ $order->code }}
                                </div>
                            </div>
                            <br>

                            <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                <thead>
                                <tr class="table-active">
                                    <th scope="col" style="width: 100px; white-space: normal;">@lang("admin.transaction_invoice.services_table_header.service_details")</th>
                                    <th scope="col" style="width: 100px; white-space: normal;">@lang("admin.transaction_invoice.services_table_header.rate")</th>
                                    <th scope="col" style="width: 100px; white-space: normal;">@lang("admin.transaction_invoice.services_table_header.quantity")</th>
                                    <th scope="col" style="width: 100px; white-space: normal;">@lang("admin.transaction_invoice.services_table_header.amount")</th>
                                    <th scope="col" style="width: 100px; white-space: normal;">@lang("admin.transaction_invoice.services_table_header.tax_value")</th>
                                    <th scope="col" style="width: 100px; white-space: normal;">@lang("admin.transaction_invoice.services_table_header.total_with_tax")</th>
                                </tr>
                                </thead>
                                <tbody id="services-list">
                                @foreach ($order->orderServices as $serviceItem)
                                    <tr>
                                        <td style="max-width: 100px" class="text-start">
                                            <span class="fw-medium" style="white-space: normal;">{{ $serviceItem->service?->name }}</span>
                                        </td>
                                        <td>{{ $serviceItem->unit_price }} @lang("translation.sar")</td>
                                        <td>{{ $serviceItem->quantity }}</td>

                                        <td>{{ round(($serviceItem->unit_price *  $serviceItem->quantity) / "1.$serviceItem->vat_percentage",2)}} @lang("translation.sar")</td>

                                        {{-- <td>{{ round(($serviceItem->unit_price *  $serviceItem->quantity)- (($serviceItem->unit_price *  $serviceItem->quantity) / "1.$serviceItem->vat_percentage"),2)}} @lang("translation.sar")</td> --}}
                                        {{-- <td>{{ ($serviceItem->unit_price *  $serviceItem->quantity) - (($serviceItem->unit_price *  $serviceItem->quantity * $serviceItem->vat_percentage) / 100)}} @lang("translation.sar")</td> --}}
                                        <td>{{ round(($serviceItem->unit_price *  $serviceItem->quantity)- (($serviceItem->unit_price *  $serviceItem->quantity) / "1.$serviceItem->vat_percentage"),2) }} @lang("translation.sar") ({{ $serviceItem->vat_percentage }}%)</td>
                                        <td>{{ $serviceItem->total }} @lang("translation.sar")</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table><!--end table-->


                            <br>
                        </div>

                        <div class="border-top border-top-dashed mt-2">
                            <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" style="width:250px">
                                <tbody>
                                <tr>
                                    <td>
                                        @lang("admin.transaction_invoice.sub_total")
                                    </td>
                                    <td class="text-end">
                                        {{ $order->sub_total ?? 0}} @lang("translation.sar")
                                    </td>
                                </tr>
                                <tr>
                                    <td>@lang("admin.tax-invoices.orders.vat") ({{ $order->vat_percentage }}%)</td>
                                    <td class="text-end">
                                        {{ $order->vat ?? 0}} @lang("translation.sar")
                                    </td>
                                </tr>
                                @if(!is_null($order->discount) && $order->discount > 0)
                                    <tr>
                                        <td>
                                            @lang("admin.transaction_invoice.discount") <small class="text-muted"></small>
                                        </td>
                                        <td class="text-end">-
                                            {{ $order->discount }} @lang("translation.sar")
                                        </td>
                                    </tr>
                                @endif
                                @if(!is_null($order->sub_total))
                                <tr>
                                    <td>
                                        @lang("admin.transaction_invoice.sub_total_without_vat") <small class="text-muted"></small>
                                    </td>
                                    <td class="text-end">
                                        {{ $order->sub_total ?? 0}} @lang("translation.sar")
                                    </td>
                                </tr>
                            @endif
                                <tr>
                                    <td>
                                        @lang("admin.transaction_invoice.sub_from_wallet") <small class="text-muted"></small>
                                    </td>
                                    <td class="text-end">
                                        {{ $order->wallet_amount ?? 0}} @lang("translation.sar")
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>


                        <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                            <a href="javascript:window.print()" class="btn btn-soft-primary"><i class="ri-printer-line align-bottom me-1"></i> @lang("admin.transaction_invoice.print")</a>
                            {{-- <a href="{{ route("vendor.service_orders.pdf-invoice", $order->id) }}" class="btn btn-soft-primary"><i class="ri-printer-line align-bottom me-1"></i> @lang("admin.transaction_invoice.download")</a> --}}
                        </div>
                    </div>
                    <!--end card-body-->
                </div><!--end col-->
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