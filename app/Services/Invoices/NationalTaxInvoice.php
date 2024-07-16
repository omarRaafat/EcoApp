<?php
namespace App\Services\Invoices;

use App\Models\Order;
use App\Models\OrderService;
use App\Models\Transaction;
use App\Services\Order\ZakatQrCode;
use App\Services\Order\ZakatQrServices;
use Exception;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;
use Mccarlosen\LaravelMpdf\LaravelMpdf;

class NationalTaxInvoice implements InvoiceInterface {
    private string $fileName;
    private string $logo;
    private Transaction $transaction;

    public function __construct() {
        $this->logo = "images/logo.png";
    }

    public function setTransaction(Transaction $transaction) {
        $folderName = $transaction->type == 'order' ? 'order_invoice_' : 'order_service_invoice_';
        $this->transaction = $transaction;
        $this->fileName = $folderName . $transaction->id . "_" . time() . ".pdf";
    }

    public function setLogo(string $logo) {
        $this->logo = $logo;
    }

    public function getPdf() : LaravelMpdf {
        if (!isset($this->transaction)) throw new Exception("Please set transaction first");

        $transaction = $this->transaction->load(["orders.orderProducts.product"]);
        app()->setLocale("ar");// just for making sure all invoices in arabic lang
        $pdf = PDF::loadView('tax-invoices.invoice-pdf', [
            "logo" => $this->logo,
            "transaction" => $transaction,
            "qrCodeGenerate" => fn(Order $order) => str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', (new ZakatQrCode($order))->getQrCode()),
        ]);

        return $pdf;
    }

    public function getServicesPdf() : LaravelMpdf {
        if (!isset($this->transaction)) throw new Exception("Please set transaction first");

        $transaction = $this->transaction->load(["orderServices.orderServices.service"]);
        app()->setLocale("ar");// just for making sure all invoices in arabic lang

        $pdf = PDF::loadView('service-tax-invoices.invoice-pdf', [
            "logo" => $this->logo,
            "transaction" => $transaction,
            "qrCodeGenerate" => fn(OrderService $order) => str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', (new ZakatQrServices($order))->getQrCode()),
        ]);

        return $pdf;
    }

    public function getVendorPdf(Order $order , $order_invoice = false) : LaravelMpdf {
        if($order_invoice){
            $transaction = Transaction::find($order->transaction->id);
            $this->setTransaction($transaction);
        }else{
            $this->setTransaction($order->transaction);
        }
        $order = $order->load("orderProducts.product");
        app()->setLocale("ar");// just for making sure all invoices in arabic lang
        $pdf = PDF::loadView('tax-invoices.vendor-invoice-pdf', [
            "logo" => $this->logo,
            "transaction" => $this->transaction,
            "order" => $order,
            "qrCodeGenerate" => fn(Order $order) => str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', (new ZakatQrCode($order))->getQrCode())
        ]);
        // return $pdf->stream();
        // dd('www');

        return $pdf;
    }

    public function getServiceVendorPdf(OrderService $order , $order_invoice = false) : LaravelMpdf {

        if($order_invoice){
            $transaction = Transaction::find($order->transaction->id);
            $this->setTransaction($transaction);
        }else{
            $this->setTransaction($order->transaction);
        }
        $order = $order->load("orderServices.service");
        app()->setLocale("ar");// just for making sure all invoices in arabic lang
        $pdf = PDF::loadView('service-tax-invoices.vendor-invoice-pdf', [
            "logo" => $this->logo,
            "transaction" => $this->transaction,
            "order" => $order,
            "qrCodeGenerate" => fn(OrderService $order) => str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', (new ZakatQrServices($order))->getQrCode())
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
