<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> Invoice No: {{ $transaction->code }} </title>
</head>

<body>
    <table width="700px">
        <tbody>
            <tr>
                <td>
                    <h2 style="text-align: left">Proforma Invoice</h2>
                </td>
            </tr>
            <tr>
                <td>
                    <span style="font-weight: bold"> No: </span>
                    <span> {{ $transaction->orderShip?->gateway_tracking_id ?? "---" }} </span>
                    <span style="width: 10px; display: inline-block"></span>

                    <span style="font-weight: bold">Invoice Date:</span>
                    <span> {{ $transaction->created_at?->format("Y-m-d") }} </span>
                    <span style="width: 10px; display: inline-block"></span>
                    <span style="font-weight: bold">Invoice No:</span>
                    <span> {{ $transaction->code }} </span>
                </td>
            </tr>
        </tbody>
    </table>

    <table width="700px" style="margin-top: 30px">
        <tbody>
            <tr>
                <td>
                    <span>
                        <h3>Ship From:</h3>
                        <p style="margin: 0; font-size: 16px"> National Center of Palm and Dates </p>
                        <p style="margin: 0; font-size: 16px"> {{ isset($warehouse) ? $warehouse->administrator_name : "" }} </p>
                        <p style="margin: 0; font-size: 16px"> {{ isset($warehouse) ? $warehouse->address : "" }} </p>
                        <p style="margin:24px 0; font-size: 16px"> {{ isset($warehouse) ? $warehouse->address : "" }} </p>
                        <br>
                        <p style="margin: 0; font-size: 16px"> Saudi Arabia </p>
                        <p style="margin: 0; font-size: 16px"> {{ isset($warehouse) ? $warehouse->administrator_phone : "" }} </p>
                        <p style="margin: 0; font-size: 16px"> {{ isset($warehouse) ? $warehouse->administrator_email : "" }} </p>
                        <p style="margin: 0; font-size: 16px"> Trader Type: Business </p>
                        <p style="margin: 0; font-size: 16px"> Vat No: {{ __("admin.tax-invoices.tax-num", [], "ar") }}</p>
                    </span>
                </td>
                <td>
                    <span>
                        <h3>Ship To:</h3>
                        <p style="margin: 0; font-size: 16px"> {{ $transaction->addresses?->first_name .' '. $transaction->addresses?->last_name }} </p>
                        <p style="margin: 0; font-size: 16px;"> {{ $transaction->addresses?->description }} </p>
                        <p style="margin:24px 0; font-size: 16px"> {{ $transaction->addresses?->city?->getTranslation("name", "en") }} </p>
                        <p style="margin: 0; font-size: 16px"> {{ $transaction->addresses?->country?->getTranslation("name", "en") }} </p>
                        <p style="margin: 0; font-size: 16px"> {{ $transaction->addresses?->phone }} </p>
                        <p style="margin: 0; font-size: 16px"> Trader Type: Private </p>
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
    <table width="700px" style="margin-top: 30px">
        <tbody>
            <tr>
                <td>
                    <h4>Remarks:</h4>
                </td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <table style="border-collapse: collapse;" class="table">
        <thead>
            <tr>
                <th style="border: 1px solid #000; padding: 8px">#</th>
                <th style="border: 1px solid #000; padding: 8px">Description</th>
                <th style="border: 1px solid #000; padding: 8px">HS Code</th>
                <th style="border: 1px solid #000; padding: 8px">Weight</th>
                <th style="border: 1px solid #000; padding: 8px">Total Weight</th>
                <th style="border: 1px solid #000; padding: 8px">Qty</th>
                <th style="border: 1px solid #000; padding: 8px">Price</th>
                <th style="border: 1px solid #000; padding: 8px">Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $counter = 1;
            @endphp
            @foreach($transaction->orders ?? [] as $order)
                @foreach($order->orderProducts ?? [] as $orderProduct)
                    <tr>
                        <th style="border: 1px solid #000; padding: 8px" scope="row"> {{ $counter }} </th>
                        <td style="border: 1px solid #000; padding: 8px"> {{ $orderProduct->product?->getTranslation("name", "en") }} </td>
                        <td style="border: 1px solid #000; padding: 8px"> {{ $orderProduct->product?->hs_code }} </td>
                        <td style="border: 1px solid #000; padding: 8px"> {{ $orderProduct->weight_with_kilo }} KG </td>
                        <td style="border: 1px solid #000; padding: 8px"> {{ $orderProduct->weight_with_kilo * $orderProduct->quantity }} KG </td>
                        <td style="border: 1px solid #000; padding: 8px"> {{ $orderProduct->quantity }} </td>
                        <td style="border: 1px solid #000; padding: 8px"> {{ $orderProduct->price_without_vat_in_sar_rounded }} </td>
                        <td style="border: 1px solid #000; padding: 8px"> {{ $orderProduct->total_without_vat_in_sar_rounded }} </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    <table width="700px" style="margin-top: 30px">
        <tbody>
            <tr>
                <td>
                    <p style="margin: 0">
                        <span> Reason For Export: </span>
                        <span> Personal use, Not For Resale </span>
                    </p>
                    <p style="margin: 0">
                        <span> Type Of Export: </span>
                        <span> Personal Belongings/Not For Resale </span>
                    </p>
                    <p style="margin: 0">
                        <span> Total Weight: </span>
                        <span> {{ $transaction->total_weight_in_kilo }} KG </span>
                    </p>
                    <p style="margin: 0">
                        <span> Total Units: </span>
                        <span> {{ $transaction->total_quantities }} </span>
                    </p>
                    <p style="margin: 0">
                        <span> Terms of Trade: </span>
                        <span> Delivered At Place </span>
                    </p>
                </td>
                <td>
                    <p style="margin: 0">
                        <span> Delivery Fees Amount: </span>
                        <span> {{ $transaction->delivery_fees_in_sar_rounded }} SAR </span>
                    </p>
                    <p style="margin: 0">
                        <span> Total Items Amount: </span>
                        <span> {{ $transaction->sub_total_in_sar_rounded }} SAR </span>
                    </p>
                    <p style="margin: 0">
                        <span> Total Vat Amount: </span>
                        <span> {{ $transaction->total_vat_in_sar_rounded }} SAR </span>
                    </p>
                    <p style="margin: 0">
                        <span> Total Invoice Amount: </span>
                        <span>
                            {{ number_format(($transaction->sub_total_in_sar ?? 0) + ($transaction->total_vat_in_sar ?? 0) + ($transaction->delivery_fees_in_sar ?? 0), 2) }} SAR
                        </span>
                    </p>
                    <p style="margin: 0">
                        <span> Currency Code: </span>
                        <span> SAR </span>
                    </p>
                    <p style="margin: 0">
                        <span> Carrier: </span>
                        <span> {{ $transaction->shippingMethod?->getTranslation("name", "en") }} </span>
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
