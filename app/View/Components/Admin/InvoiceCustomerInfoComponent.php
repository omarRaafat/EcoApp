<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class InvoiceCustomerInfoComponent extends Component
{
    public $transaction;

    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    public function render()
    {
        return view('components.admin.invoice-customer-info-component' , get_defined_vars());
    }
}
