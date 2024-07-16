<?php
namespace App\Services\Invoices;

use App\Models\Transaction;

class InvoiceFactory {
    public static function getInvoiceInstance(
        Transaction $transaction,
        bool $forBackgroundJob = false
    ) : InvoiceInterface {
        if ($transaction->is_international) {
            $instance = new InternationalTaxInvoice;
            $instance->setTransaction($transaction);
        } else {
            $instance = new NationalTaxInvoice;
            $instance->setTransaction($transaction);
            if ($forBackgroundJob) $instance->setLogo(asset("images/logo.png"));
        }
        return $instance;
    }
}
