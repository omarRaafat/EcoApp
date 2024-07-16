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
                    <x-vendor.invoice-header-component :order="$order"></x-vendor.invoice-header-component>
                </div>

                <div class="card-body p-4 border-top border-top-dashed">
                    <div class="row g-3">

                        <x-vendor.invoice-customer-info-component :order="$order" ></x-vendor.invoice-customer-info-component>

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

                            <x-vendor.invoice-table-component :order="$order" ></x-vendor.invoice-table-component>

                            <br>
                        </div>

                        <x-vendor.invoice-money-component :order="$order"></x-vendor.invoice-money-component>

                        <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                            <a href="javascript:window.print()" class="btn btn-soft-primary"><i class="ri-printer-line align-bottom me-1"></i> @lang("admin.transaction_invoice.print")</a>
                            <a href="{{ route("vendor.orders.pdf-invoice", $order->id) }}" class="btn btn-soft-primary"><i class="ri-printer-line align-bottom me-1"></i> @lang("admin.transaction_invoice.download")</a>
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
