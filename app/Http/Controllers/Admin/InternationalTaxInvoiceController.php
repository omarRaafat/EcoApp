<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\Invoices\InternationalTaxInvoice;
use Illuminate\Http\Response;

class InternationalTaxInvoiceController extends Controller
{
    public function printTaxInvoice(Transaction $transaction) : Response {
        $transaction = $transaction->load([
            'addresses' => fn($a) => $a->with(['country.warehouseCountry.warehouse', 'city']),
            'orderShip',
            'shippingMethod',
            'orders.orderProducts.product'
        ]);
        $invoiceGenerator = new InternationalTaxInvoice;
        $invoiceGenerator->setTransaction($transaction);

        return $invoiceGenerator->getPdf()->stream($invoiceGenerator->getFileName());
    }
}
