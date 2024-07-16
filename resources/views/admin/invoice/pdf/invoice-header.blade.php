<div style="padding: 1rem;">
    <h4 style="padding: 0;float: right;width:100%; text-align:center;">فاتورة ضريبية</h4>
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
                    @lang("Invoice.attributes.number"):
                </span>
                <span>
                    #{{ $invoice->id }}
                </span>
            </h6>
            <h6>
                <span style="font-weight: normal; color: gray">
                    @lang("admin.tax-invoices.tax-num-label"):
                </span>
                <span>
                    # 310876568300003
                </span>
            </h6>
            <h6>
                <span style="font-weight: normal; color: gray">
                        @lang("Invoice.attributes.created_at"):
                </span>
                <span>
                   {{ \Carbon\Carbon::parse($invoice->created_at)->format("d-m-Y H:i") }}
                </span>
            </h6>
            <h6>
                <span style="font-weight: normal; color: gray">
                        @lang("Invoice.attributes.period_start_at"):
                </span>
                <span>
                   {{ \Carbon\Carbon::parse($invoice->period_start_at)->format("d-m-Y") }}
                </span>
            </h6>
            <h6>
                <span style="font-weight: normal; color: gray">
                        @lang("Invoice.attributes.period_end_at"):
                </span>
                <span>
                   {{ \Carbon\Carbon::parse($invoice->period_end_at)->format("d-m-Y") }}
                </span>
            </h6>
        </div>
        <div style="width: 50%; float: left;text-align: left">
            <img src="{{ $logo }}" style="height: 90px">
        </div>
    </div>
</div>
