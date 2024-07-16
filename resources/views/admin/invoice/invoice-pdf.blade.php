<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        #header {
            margin-bottom: 2rem;
        }

        #header img {
            display: block;
            margin: 0 auto;
            height: 9.5rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 0px solid #ddd;
            padding: 8px;
            text-align: center;
        }
    </style>
    <title></title>
</head>
<body>
<div id="header">
    <table>
        <tr>
            <td></td>
            <td>
                <img src="{{ asset('images/logo.png') }}" alt="mouzare-logo">
            </td>
            <td></td>
        </tr>
    </table>
    <div class="header-text">
        <table dir="rtl" style="font-weight: 700;">
            <tr>
                <td style="text-align: right;">المركز الوطني للنخيل والتمور</td>
                <td></td>
                <td style="text-align: left;">العميل: {{ $invoice->vendor->owner->name }}</td>
            </tr>
            <tr>
                <td style="text-align: right;">المملكة العربية السعودية - الرياض</td>
                <td></td>
                <td rowspan="2" style="text-align: left;">{{ $invoice->vendor->street }}</td>
            </tr>
            <tr>
                <td style="text-align: right;">طريق الأمير تركي الأول - حي حطين</td>
                <td></td>
            </tr>
            <tr>
                <td style="text-align: right;">الرقم الضريبي 310876568300003</td>
                <td style="width: 15rem"></td>
                <td style="text-align: left;"> الرقم الضريبي
                    {{ $invoice->vendor_data["tax_num"] }}
                </td>
            </tr>
            <tr>
                <td style="text-align: right;">رقم الفاتورة {{ $invoice->id }}</td>
                <td></td>
                <td style="text-align: left;">رقم العميل: {{$invoice->vendor->owner->id}}</td>
            </tr>
            <tr>
                <td style="text-align: right;">تاريخ
                    الفاتورة {{ \Carbon\Carbon::parse($invoice->created_at)->format("d-m-Y H:i") }}</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                {{--                <td></td>--}}
                <td colspan="3" style="text-align: center;">فاتورة ضريبية</td>
                {{--                <td></td>--}}
            </tr>

        </table>
    </div>
</div>
<div>
    <table style="border: 1px solid black;">
        <thead>
        <tr style="border: 1px solid black;">
            <th>البيان</th>
            <th>الكمية</th>
            <th>سعر الوحدة</th>
            <th>نسبة ضريبة القيمة المضافة</th>
            <th>قيمة الضريبة</th>
            <th>الإجمالي</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($invoice->invoiceLines as $invoice_line)
            <tr style="border: 1px solid black;">
                <td>
                    {{ $invoice_line->description }} @lang("Invoice.description_from_to", ["from" => \Carbon\Carbon::parse($invoice->period_start_at)->format("d-m-Y"), "to" => \Carbon\Carbon::parse($invoice->period_end_at)->format("d-m-Y")])
                </td>
                <td>
                    {{ $invoice_line->quantity }}
                </td>
                <td>
                    {{ number_format($invoice_line->unit_price, 2) }} @lang("translation.sar")
                </td>
                <td>
                    {{ $invoice_line->vat_percentage }}%
                </td>
                <td>
                    {{ number_format($invoice_line->vat_amount, 2) }}  @lang("translation.sar")
                </td>
                <td>
                    {{ number_format($invoice_line->total_with_vat, 2) }} @lang("translation.sar")
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div>
    <table dir="rtl">
        <tr>
            <td style="text-align: right;">{!! $invoice->getQrCode() !!}</td>
            <td style="text-align: left;">
                <p>الإجمالي غير شامل الضريبة: <span
                        style="margin-right: 1.5rem">{{ number_format($invoice->total_without_vat, 2) }} @lang("translation.sar")</span>
                </p>
                <p>المبلغ الخاضع للضريبة: <span
                        style="margin-right: 1.5rem">{{ number_format($invoice->total_without_vat, 2) }} @lang("translation.sar")</span>
                </p>
                <p>إجمالي الضريبة ({{ $invoice->vat_percentage }}%): <span
                        style="margin-right: 1.5rem">{{ number_format($invoice->vat_amount, 2) }} @lang("translation.sar")</span>
                </p>
                <p>الإجمالي شامل الضريبة: <span
                        style="margin-right: 1.5rem">{{ number_format($invoice->total_with_vat, 2) }} @lang("translation.sar")</span>
                </p>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
