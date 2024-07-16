<?php

namespace App\Services\Invoices;

use App\Models\Invoice;
use Exception;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;
use Mccarlosen\LaravelMpdf\LaravelMpdf;

class CommissionTaxInvoice implements InvoiceInterface
{
    private string $fileName;
    private string $logo;
    private Invoice $invoice;

    public function __construct()
    {
        $this->logo = "images/logo.png";
    }

    public function setTransaction(Invoice $invoice)
    {
        $this->invoice = $invoice;
        $this->fileName = "order_invoice_".$invoice->id."_".time().".pdf";
    }

    public function setLogo(string $logo)
    {
        $this->logo = $logo;
    }

    public function getPdf(): LaravelMpdf
    {
        if (!isset($this->invoice)) {
            throw new Exception("Please set invoice first");
        }

        $invoice = $this->invoice->load(["vendor", "invoiceLines"]);
        app()->setLocale("ar");// just for making sure all invoices in arabic lang
        $pdf = PDF::loadView('admin.invoice.invoice-pdf', [
            "logo" => $this->logo,
            "invoice" => $invoice,
            /*            "qrCodeGenerate" => fn(Order $order) => str_replace('<?xml version="1.0" encoding="UTF-8"?>', '',*/
//                (new ZakatQrCode($order))->getQrCode()),
        ]);

        return $pdf;
    }

    public function getFullPath(): string
    {
        if (!isset($this->invoice)) {
            throw new Exception("Please set transaction first");
        }

        if (!is_dir(public_path("pdf_temp/"))) {
            mkdir(public_path("pdf_temp/"), 0755, true);
        }

        $path = "pdf_temp/".$this->fileName;
        return public_path($path);
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }
}
