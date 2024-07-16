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
                .page-break{
                    display:block;
                    page-break-before:always;
                }
            }
        </style>
    </head>

    <body style="margin: 0; padding: 0; overflow-y: auto">
        <div>
            <div>
                @foreach($transaction->orders->where('status','!=','canceled') as $index => $order)
                    <div>
                        @include("tax-invoices.invoice-header")
                        @include("tax-invoices.invoice-customer")
                        @include("tax-invoices.invoice-products")
                        @include("tax-invoices.invoice-footer")
                    </div>
                    <div @if(!$loop->last) class="page-break" @endif></div>
                @endforeach
            </div>
        </div>
    </body>
</html>
