<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $product->getTranslation('name', 'ar') }}</title>
    <style>
        svg {
            width: 500px
        }
    </style>
</head>
<body style="display:flex; flex-direction: column; align-items:center; justify-content: center; height: 100vh;">
    <svg id="barcode"></svg>
    <h3> {{ $product->getTranslation('name', 'ar') }} </h3>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsbarcode/3.11.5/JsBarcode.all.min.js"></script>
    <script>
        JsBarcode("#barcode", "{{ $product->sku }}", {displayValue: false});
        window.print()
    </script>
</body>
</html>
