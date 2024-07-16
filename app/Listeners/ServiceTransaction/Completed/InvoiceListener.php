<?php

namespace App\Listeners\Transaction\Completed;

use Error;
use Exception;
use App\Events\Transaction;
use App\Models\Transaction as TransactionModel;
use App\Services\Invoices\InvoiceFactory;
use Illuminate\Support\Facades\Log;

class InvoiceListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param Transaction\Completed $event
     * @return void
     */
    public function handle(Transaction\Completed $event)
    {
        try {
            $transaction = $event->getTransaction();
            if (!$transaction->inv_url) {
                $invoiceGenerator = InvoiceFactory::getInvoiceInstance($transaction);

                $fullPath = $invoiceGenerator->getFullPath();
                $fileName = $invoiceGenerator->getFileName();

                $pdf = $transaction->type == 'order' ? $invoiceGenerator->getPdf() : $invoiceGenerator->getServicesPdf();

                $pdf->save($fullPath);

                $transaction->addMedia($fullPath)
                    ->usingName($fileName)
                    ->setFileName($fileName)
                    ->toMediaCollection(TransactionModel::MEDIA_COLLECTION_NAME);
            }
        } catch (Exception | Error $e) {
            Log::channel("transaction-events-errors")->error("Exception in InvoiceListener: ". $e->getMessage());
        }
    }
}
