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
