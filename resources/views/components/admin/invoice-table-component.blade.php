
                <div class="col-lg-12">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            @if($transaction->orders->count() > 0)
                                @foreach ($transaction->orders as $order)
                                    <div class="row">
                                        <div class="col-md-6">
                                            @lang("admin.vendor_name"): {{ $order->vendor->name }}
                                        </div>
                                        <div class="col-md-4">
                                            @lang("translation.tax_num"): {{ $order->vendor->tax_num }}
                                        </div>
                                        <div class="col-md-2">
                                            @lang("admin.transaction_invoice.invoice_no"): #{{ $order->code }}
                                        </div>
                                    </div>
                                    <br>
                                    <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                        <thead>
                                            <tr class="table-active">
                                                <th
                                                style="width: 100px; white-space: normal;"
                                                scope="col">@lang("admin.transaction_invoice.products_table_header.product_details")</th>
                                                <th
                                                style="width: 100px; white-space: normal;"
                                                scope="col">@lang("admin.transaction_invoice.products_table_header.rate")</th>
                                                <th
                                                style="width: 100px; white-space: normal;"

                                                scope="col">@lang("admin.transaction_invoice.products_table_header.quantity")</th>
                                                <th
                                                style="width: 100px; white-space: normal;"

                                                scope="col">@lang("admin.transaction_invoice.products_table_header.amount")</th>
                                                <th
                                                style="width: 100px; white-space: normal;"
                                                scope="col">@lang("admin.transaction_invoice.products_table_header.tax_value")</th>
                                                <th
                                                style="width: 100px; white-space: normal;"
                                                scope="col">@lang("admin.transaction_invoice.products_table_header.total_with_tax")</th>
                                            </tr>
                                        </thead>
                                        <tbody id="products-list">
                                                @foreach ($order->orderProducts as $productItem)
                                                    <tr>
                                                        <td

                                                        style="max-width: 100px"
                                                        class="text-start">
                                                            <span class="fw-medium" style="white-space: normal;">{{ $productItem->product?->name }}</span>
                                                            <p class="text-muted mb-0" style="white-space: normal;">
                                                                @lang("admin.transaction_invoice.products_table_header.barcode"): {{$productItem->product?->sku}}
                                                            </p>
                                                        </td>
                                                        <td>{{ $productItem->unit_price  }} @lang("translation.sar")</td>
                                                        <td>{{ $productItem->quantity }}</td>
                                                        <td>{{ $order->sub_total}} @lang("translation.sar")</td>

                                                        {{-- $vatRate = round($productItem->total - ($productItem->total / "1.$productItem->vat_percentage"),2); --}}

                                                        <td>{{ round($productItem->total - ($productItem->total / "1.$productItem->vat_percentage"),2)}} @lang("translation.sar") ({{ $productItem->vat_percentage }}%)</td>
                                                        <td>{{ $productItem->total }} @lang("translation.sar")</td>
                                                    </tr>
                                                @endforeach
                                        </tbody>
                                    </table><!--end table-->
                                    <br>
                                @endforeach
                            @else
                                <center>
                                    @lang("admin.transaction_invoice.not_found")
                                </center>
                            @endif
                        </div>

                        <x-admin.invoice-money-component :transaction="$transaction"></x-admin.invoice-header-component>

                        {{-- @include("components.order-summary-money", [
                            "subTotal" => $transaction->sub_total_in_sar_rounded,
                            "vatPercentage" => $transaction->vat_percentage,
                            "totalVat" => $transaction->total_vat_in_sar_rounded,
                            "discount" => $transaction->discount ? $transaction->discount_in_sar_rounded : null,
                            "walletDeduction" => $transaction->wallet_deduction ? $transaction->wallet_deduction_in_sar_rounded : null,
                            "totalWithoutVat" => $transaction->total_without_vat_in_sar_rounded,
                            "delivery" => $transaction->delivery_fees_in_sar_rounded,
                            "total" => $transaction->total_amount_rounded,
                        ]) --}}
                        <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                            <a href="javascript:window.print()" class="btn btn-soft-primary"><i class="ri-printer-line align-bottom me-1"></i> @lang("admin.transaction_invoice.print")</a>
                            <a href="{{ route("admin.transactions.pdf-invoice", $transaction->id) }}" class="btn btn-soft-success"><i class="ri-printer-line align-bottom me-1"></i> @lang("admin.transaction_invoice.download")</a>
                        </div>
                    </div>
                    <!--end card-body-->
                </div><!--end col-->