<?php
namespace App\Services\Invoices;

use App\Models\Transaction;
use Exception;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;
use Mccarlosen\LaravelMpdf\LaravelMpdf;

class InternationalTaxInvoice implements InvoiceInterface {
    private string $fileName;
    private Transaction $transaction;

    public function setTransaction(Transaction $transaction) {
        $this->transaction = $transaction;
        $this->fileName = "order_invoice_" . $transaction->id . "_" . time() . ".pdf";
    }

    public function getPdf() : LaravelMpdf {
        if (!isset($this->transaction)) throw new Exception("Please set transaction first");

        $transaction = $this->transaction->load(["orders.orderProducts.product"]);
        app()->setLocale("en");

        $pdf = PDF::loadView('international-tax-invoices.invoice-pdf', [
            "transaction" => $transaction,
        ]);

        return $pdf;
    }

    public function getFullPath() : string {
        if (!isset($this->transaction)) throw new Exception("Please set transaction first");

        if(!is_dir(public_path("pdf_temp/"))) {
            mkdir(public_path("pdf_temp/"), 0755, true);
        }

        $path = "pdf_temp/" . $this->fileName;
        return public_path($path);
    }

    public function getFileName() : string {
        return $this->fileName;
    }
}
