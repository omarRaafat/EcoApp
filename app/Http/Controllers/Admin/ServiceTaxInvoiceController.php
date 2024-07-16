<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\Invoices\NationalTaxInvoice;
use App\Services\ServiceOrderService;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;

class ServiceTaxInvoiceController extends Controller
{
    public function __construct(public ServiceOrderService $orderService)
    {
    }

    public function printTaxInvoice(Transaction $transaction) {
        $invoiceGenerator = new NationalTaxInvoice;
        $invoiceGenerator->setTransaction($transaction);

        return $invoiceGenerator->getServicesPdf()->stream($invoiceGenerator->getFileName());
    }

    public function printOrderTaxInvoice(int $orderId)
    {
        $order = $this->orderService->getOrderUsingID($orderId);
        try {
            $invoiceGenerator = new NationalTaxInvoice;
            return $invoiceGenerator->getServiceVendorPdf($order)->stream($invoiceGenerator->getFileName());
        }  catch (Exception $e) {
            return redirect()->back()->with("danger", ($e->getMessage() ?? ''));
        }

        Alert::error( __('translation.error') , __('translation.browse_order_you_do_not_own') );
        return back();
    }
}
