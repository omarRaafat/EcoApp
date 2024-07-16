<?php

namespace App\View\Components\Vendor;

use Illuminate\View\Component;
use \App\Models\Order;

class invoiceHeaderComponent extends Component
{
    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function render()
    {
        return view('components.vendor.invoice-header-component' ,get_defined_vars());
    }
}
