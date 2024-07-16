<?php

namespace App\View\Components\Vendor;

use Illuminate\View\Component;

class invoiceMoneyComponent extends Component
{
    public $order;
//    public $productItem;

    public function __construct($order  )//, $productItem)
    {
        $this->order = $order;
//        $this->productItem = $productItem;
    }

    public function render()
    {
        return view('components.vendor.invoice-money-component' ,  get_defined_vars());
    }
}
