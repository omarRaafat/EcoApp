<table class="table table-borderless text-center table-nowrap align-middle mb-0">
    <thead>
    <tr class="table-active">
        <th scope="col" style="width: 100px; white-space: normal;">@lang("admin.transaction_invoice.products_table_header.product_details")</th>
        <th scope="col" style="width: 100px; white-space: normal;">@lang("admin.transaction_invoice.products_table_header.rate")</th>
        <th scope="col" style="width: 100px; white-space: normal;">@lang("admin.transaction_invoice.products_table_header.quantity")</th>
        <th scope="col" style="width: 100px; white-space: normal;">@lang("admin.transaction_invoice.products_table_header.amount")</th>
        <th scope="col" style="width: 100px; white-space: normal;">@lang("admin.transaction_invoice.products_table_header.tax_value")</th>
        <th scope="col" style="width: 100px; white-space: normal;">@lang("admin.transaction_invoice.products_table_header.total_with_tax")</th>
    </tr>
    </thead>
    <tbody id="products-list">
    @foreach ($order->orderProducts as $productItem)
        <tr>
            <td style="max-width: 100px" class="text-start">
                <span class="fw-medium" style="white-space: normal;">{{ $productItem->product?->name }}</span>
                <p class="text-muted mb-0" style="white-space: normal;">
                    @lang("admin.transaction_invoice.products_table_header.barcode"): {{$productItem->product?->sku}}
                </p>
            </td>
            <td>{{ $productItem->unit_price }} @lang("translation.sar")</td>
            <td>{{ $productItem->quantity }}</td>
            
            <td>{{ round(($productItem->unit_price *  $productItem->quantity) / "1.$productItem->vat_percentage",2)}} @lang("translation.sar")</td>

            {{-- <td>{{ round(($productItem->unit_price *  $productItem->quantity)- (($productItem->unit_price *  $productItem->quantity) / "1.$productItem->vat_percentage"),2)}} @lang("translation.sar")</td> --}}
            {{-- <td>{{ ($productItem->unit_price *  $productItem->quantity) - (($productItem->unit_price *  $productItem->quantity * $productItem->vat_percentage) / 100)}} @lang("translation.sar")</td> --}}
            <td>{{ round(($productItem->unit_price *  $productItem->quantity)- (($productItem->unit_price *  $productItem->quantity) / "1.$productItem->vat_percentage"),2) }} @lang("translation.sar") ({{ $productItem->vat_percentage }}%)</td>
            <td>{{ $productItem->total }} @lang("translation.sar")</td>
        </tr>
    @endforeach
    </tbody>
</table><!--end table-->
