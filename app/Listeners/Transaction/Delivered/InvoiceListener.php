<?php

namespace App\Listeners\Transaction\Delivered;

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
     * @param Transaction\Delivered $event
     * @return void
     */
    public function handle(Transaction\Delivered $event)
    {
        try {
            $transaction = $event->getTransaction();
            if (!$transaction->inv_url) {
                $invoiceGenerator = InvoiceFactory::getInvoiceInstance($transaction);

                $fullPath = $invoiceGenerator->getFullPath();
                $fileName = $invoiceGenerator->getFileName();

                $pdf = $invoiceGenerator->getPdf();

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
