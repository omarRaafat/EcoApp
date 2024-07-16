<?php

namespace App\Listeners\Transaction\Created;

use Error;
use Exception;
use App\Events\Transaction;
use Illuminate\Support\Facades\Log;
use App\Models\Transaction as TransactionModel;
use App\Services\Invoices\InvoiceFactory;

class InvoiceListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Handle the event.
     *
     * @param Transaction\Created $event
     * @return void
     */
    public function handle(Transaction\Created $event)
    {
        try {
            $transaction = $event->getTransaction();
            $invoiceGenerator = InvoiceFactory::getInvoiceInstance($transaction);

            $transaction->media()->delete();

                $laravelMpdf = $transaction->type == 'order' ? $invoiceGenerator->getPdf() : $invoiceGenerator->getServicesPdf();

            $fullPath = $invoiceGenerator->getFullPath();
            $fileName = $invoiceGenerator->getFileName();

            $laravelMpdf->save($fullPath);


            $transaction->addMedia($fullPath)
                ->usingName($fileName)
                ->setFileName($fileName)
                ->toMediaCollection(TransactionModel::MEDIA_COLLECTION_NAME);
        } catch (Exception | Error $e) {
            Log::channel("transaction-events-errors")->error("Exception in InvoiceListener: ". $e->getMessage());
        }
    }
}
