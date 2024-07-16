<?php

namespace App\Console\Commands\DataMigration;

use App\Enums\OrderStatus;
use App\Models\Transaction;
use App\Services\Invoices\InvoiceFactory;
use Error;
use Exception;
use Illuminate\Console\Command;

class FillCustomerInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customers:fill-invoices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command to regenerate customer invoices to apply the updates';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Transaction::statuses([OrderStatus::COMPLETED, OrderStatus::SHIPPING_DONE])
        ->lazy()
        ->each(function(Transaction $transaction) {
            $this->info("working on transaction: {$transaction->id}, status: {$transaction->status}");
            $invoiceGenerator = InvoiceFactory::getInvoiceInstance($transaction);
            try {
                $transaction->media()->delete();

                $laravelMpdf = $invoiceGenerator->getPdf();

                $fullPath = $invoiceGenerator->getFullPath();
                $fileName = $invoiceGenerator->getFileName();

                $laravelMpdf->save($fullPath);


                $transaction->addMedia($fullPath)
                    ->usingName($fileName)
                    ->setFileName($fileName)
                    ->toMediaCollection(Transaction::MEDIA_COLLECTION_NAME);
            } catch (Exception | Error $e) {
                $this->info("Exception in generate invoice transaction: {$transaction->id}, message: {$e->getMessage()}");
            }
            $this->info("**********************************************");
        });
        return Command::SUCCESS;
    }
}
