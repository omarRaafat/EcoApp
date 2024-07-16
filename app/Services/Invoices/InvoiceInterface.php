<?php
namespace App\Services\Invoices;

use Mccarlosen\LaravelMpdf\LaravelMpdf;

interface InvoiceInterface {
    public function getFileName() : string;
    public function getFullPath() : string;
    public function getPdf() : LaravelMpdf;
    public function getServicesPdf() : LaravelMpdf;
}
