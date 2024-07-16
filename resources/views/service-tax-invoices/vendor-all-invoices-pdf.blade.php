<!doctype html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .text-muted {
            color: gray;
        }

        @media print {
            .page-break {
                display: block;
                page-break-before: always;
            }
        }
    </style>
</head>

<body style="margin: 0; padding: 0; overflow-y: auto">
    <div>
        <div>
            @foreach ($orders as $order)
                <div>
                    @include('service-tax-invoices.invoice-header')
                    @include('service-tax-invoices.invoice-customer')
                    @include('service-tax-invoices.invoice-products')
                    @include('service-tax-invoices.invoice-footer')
                </div>
                <div @if (!$loop->last) class="page-break" @endif></div>
            @endforeach
        </div>
    </div>
</body>

</html>