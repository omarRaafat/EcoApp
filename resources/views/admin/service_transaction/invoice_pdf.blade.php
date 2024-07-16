<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@lang('translation.invoice')</title>
</head>

<body>
    <div>
        <table width="100%" align="center">
            <tbody align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td align="right">
                        <div>
                            <p style="font-weight: bold; color: #9096ab">
                                @lang('admin.transaction_invoice.app_name')
                            </p>
                        </div>
                        <div style="margin-bottom: 5px">
                            <span style="color: #9096ab">@lang('admin.transaction_invoice.invoice_no')</span>
                            <span style="font-weight: bold; color: #333"> #{{ $transaction->code }} </span>
                        </div>
                        <div style="margin-bottom: 5px">
                            <span style="color: #9096ab">@lang('admin.transaction_invoice.tax_no')</span>
                            <span style="font-weight: bold; color: #333">
                                {{ __("admin.tax-invoices.tax-num", [], "ar") }}
                            </span>
                        </div>
                        @if (isset($transactoion->orderShip))
                            <div style="margin-bottom: 5px">
                                <span style="color: #9096ab">@lang('admin.transaction_invoice.shipment_no')</span>
                                <span style="font-weight: bold; color: #333">
                                    {{ isset($transactoion->orderShip) ? $transactoion->orderShip->order_id : null }}
                                </span>
                            </div>
                        @endif
                        <div style="margin-bottom: 5px">
                            <span style="color: #9096ab">@lang('admin.transaction_invoice.date'):</span>
                            <span style="direction: ltr; font-weight: bold; color: #333; text-align: left; display: inline-block;">
                                {{ \Carbon\Carbon::parse($transaction->date)->format('d-m-Y H:i A') }}
                            </span>
                        </div>

                        <div style="margin-bottom: 5px">
                            <span style="color: #9096ab">@lang('admin.transaction_invoice.date'):</span>
                            <span style="direction: ltr; font-weight: bold; color: #333; text-align: left; display: inline-block;">
                                {{ \Carbon\Carbon::parse($transaction->date)->format('d-m-Y H:i A') }}
                            </span>
                        </div>
                    </td>
                    <td align="left">
                        <img style="width: 250px" src="images/logo.png" alt="saudi-dates" data-bit="iit" />
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <table width="100%" align="center">
            <tbody align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr align="center">
                    <td align="center">
                        <div>
                            <p style="text-align: center; font-weight: bold; color: #333">
                                @lang('admin.transaction_invoice.invoice_brif')
                            </p>
                            <br>
                        </div>
                        <hr />
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <table width="100%">
            <tbody align="right" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr width="100%">
                    {{-- <td width="200">
                        <div>
                            <p style="font-weight: bold; color: #9096ab">@lang('admin.transaction_invoice.bill_info')</p>
                        </div>
                        <div style="margin-bottom: 5px">
                            <p class="text-muted mb-1" id="billing-address-line-1">@lang('admin.transaction_invoice.client_sale'):
                                {{ $transaction->customer->name }}
                            </p>
                            <p class="text-muted mb-1">
                                <span> @lang('admin.transaction_invoice.phone'): </span>
                                <span id="billing-phone-no"> {{ $transaction->customer->phone }} </span>
                            </p>
                        </div>
                    </td> --}}
                    <td width="260">
                        <div>
                            <p style="font-weight: bold; color: #9096ab">@lang('admin.transaction_invoice.ship_info')</p>
                        </div>
                        <div style="margin-bottom: 5px">
                            <p class="text-muted mb-1" id="shipping-name">@lang('admin.transaction_invoice.client_name'):
                                {{ $transaction->client->name }}</p>
                            <p class="text-muted mb-1"><span id="shipping-phone-no">@lang('admin.transaction_invoice.phone'):
                                    {{  $transaction->client->phone }}</span></p>
                        </div>
                    </td>
                    <td width="120">
                        <div>
                            <p style="font-weight: bold; white-space:nowrap; color: #9096ab">@lang('admin.payment_method')</p>
                        </div>
                        <div style="margin-bottom: 5px">
                            <span style="background-color: #e5f8f5; padding: 5px 9px; border-radius: 5px; color: #68c9a8;">
                                {{  $transaction->getPaymentMethod()  }}
                            </span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        @if ($transaction->orders->count() > 0)
            @foreach ($transaction->orders as $order)
                <table width="100%" align="center">
                    <tbody align="right" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td>
                                <div>
                                    <span>@lang('admin.vendor_name'):</span>
                                    <span>{{ $order->vendor->name }}</span>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <span>@lang('translation.tax_num'):</span>
                                    <span>{{ $order->vendor->tax_num }}</span>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <span>@lang('admin.transaction_invoice.invoice_no'):</span>
                                    <span>#{{ $order->code }}</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                @foreach ($order->orderProducts as $productItem)
                    <table width="100%" align="center" style="margin-top: 20px">
                        <thead>
                            <tr style="background-color: #eee" align="center" border="0" width="100%">
                                <th style="padding: 5px 10px">@lang('admin.transaction_invoice.products_table_header.product_details')</th>
                                <th style="padding: 5px 10px">@lang('admin.transaction_invoice.products_table_header.rate')</th>
                                <th style="padding: 5px 10px">@lang('admin.transaction_invoice.products_table_header.quantity')</th>
                                <th style="padding: 5px 10px">@lang('admin.transaction_invoice.products_table_header.amount')</th>
                                <th style="padding: 5px 10px">@lang('admin.transaction_invoice.products_table_header.tax_value')</th>
                                <th style="padding: 5px 10px">@lang('admin.transaction_invoice.products_table_header.total_with_tax')</th>
                            </tr>
                        </thead>
                        <tbody align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td>
                                    <div style="text-align: right">{{ $productItem->product?->name }}</div>
                                    <div style="text-align: right">
                                        <span style="color: #9096ab">@lang('admin.transaction_invoice.products_table_header.barcode'):</span>
                                        <span style="color: #9096ab">{{ $productItem->product?->sku }}</span>
                                    </div>
                                </td>
                                <td>{{ $productItem->unit_price }} @lang('translation.sar')</td>
                                <td>{{ $productItem->quantity }}</td>
                                <td>{{ round($productItem->total / "1.$productItem->vat_percentage",2)}} @lang("translation.sar")</td>

                                {{-- <td>{{ $productItem->total  - ($productItem->total * $productItem->vat_percentage/ 100) }} @lang('translation.sar')</td> --}}
                                <td>
                                    {{round($productItem->total - (($productItem->unit_price *  $productItem->quantity) / "1.$productItem->vat_percentage"),2) }}

                                    {{-- {{  $productItem->total * $productItem->vat_percentage / 100}} @lang('translation.sar') --}}
                                    ({{ $productItem->vat_percentage }}%)</td>
                                <td>{{ $productItem->total }} @lang('translation.sar')</td>
                            </tr>
                        </tbody>
                    </table>
                @endforeach
            @endforeach
        @endif
        <br>
        <div style="margin-top: 25px">
            <table style="width: 300px;margin-right: auto; text-align: left;">
                <tr>
                    <td style="text-align: right">
                        @lang('admin.transaction_invoice.sub_total')
                    </td>
                    <td>
                        {{ $transaction->sub_total }} @lang('translation.sar')
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right">
                        @lang('admin.transaction_invoice.estimated_tax') ({{ $transaction->vat_percentage }}%)
                    </td>
                    <td>
                        {{ $transaction->total_vat }}@lang('translation.sar')
                    </td>
                </tr>
                @if ($transaction->discount)
                    <tr>
                        <td style="text-align: right">
                            @lang('admin.transaction_invoice.discount')
                        </td>
                        <td>
                            {{ $transaction->discount }} @lang('translation.sar')
                        </td>
                    </tr>
                @endif
                @if ($transaction->wallet_deduction)
                    <tr>
                        <td style="text-align: right">
                            @lang('admin.transaction_invoice.sub_from_wallet')
                        </td>
                        <td>
                            {{ $transaction->wallet_deduction }} @lang('translation.sar')
                        </td>
                    </tr>
                @endif
                <tr>
                    <td style="text-align: right">
                        @lang('admin.transaction_invoice.sub_total_without_vat')
                    </td>
                    <td>
                        {{  $transaction->total - $transaction->total_vat }} @lang('translation.sar')
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right">
                        @lang('admin.transaction_invoice.shipping_charge')
                    </td>
                    <td>
                        {{ $transaction->delivery_fees }} @lang('translation.sar')
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;border-top: 1px solid #333; padding-top: 15px">
                        @lang('admin.transaction_invoice.total_amount')
                    </td>
                    <td style="border-top: 1px solid #333; padding-top: 15px">
                        {{ $transaction->total}} @lang('translation.sar')
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
