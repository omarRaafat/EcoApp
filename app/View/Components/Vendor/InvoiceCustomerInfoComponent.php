<?php

namespace App\View\Components\Vendor;

use Illuminate\View\Component;

class InvoiceCustomerInfoComponent extends Component
{
    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function render()
    {
        return view('components.vendor.invoice-customer-info-component' , get_defined_vars());
    }
}
