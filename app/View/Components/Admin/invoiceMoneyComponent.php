<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class invoiceMoneyComponent extends Component
{
    public $transaction;
//    public $productItem;

    public function __construct($transaction  )//, $productItem)
    {
        $this->transaction = $transaction;
//        $this->productItem = $productItem;
    }

    public function render()
    {
        return view('components.admin.invoice-money-component' ,  get_defined_vars());
    }
}
