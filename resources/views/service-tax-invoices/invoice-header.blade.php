<div style="padding: 1rem;">
    <div style="width: 100%;height: auto;">
        <div style="width: 50%; float: right; text-align: right">
            <h6>
                <span style="font-weight: normal; color: gray">
                    <b style="font-size: 18px">
                        @lang("admin.tax-invoices.center-name")
                    </b>
                </span>
            </h6>
            <h6>
                <span style="font-weight: normal; color: gray">
                    @lang("admin.tax-invoices.order-code"):
                </span>
                <span>
                    {{-- {{dd($order->transaction)}} --}}
                    #{{ $transaction ? $transaction->code  : ($order ? $order->transaction->code : '') }}
                </span>
            </h6>
            <h6>
                <span style="font-weight: normal; color: gray">
                    @lang("admin.tax-invoices.tax-num-label"):
                </span>
                <span>
{{--                     # {{ $order->vendor->tax_num }}--}}
                    # 310876568300003
                </span>
            </h6>
            <h6>
                <span style="font-weight: normal; color: gray">
                    @lang("admin.transaction_invoice.date"):
                </span>

                <span>
                    {{ \Carbon\Carbon::parse($order->order_date)->format("d-m-Y H:i") ?? ''}}
                </span>
            </h6>

        </div>
        <div style="width: 50%; float: left;text-align: left">
            <img src="{{ $logo }}" style="height: 90px">
        </div>
    </div>
    <h4 style="padding: 0;float: right;width:100%; text-align:center;">@lang("admin.tax-invoices.header-label")</h4>
</div>
