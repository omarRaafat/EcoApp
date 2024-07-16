<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;
use \App\Models\Order;
use App\Models\Setting;

class invoiceHeaderComponent extends Component
{
    public $transaction;

    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    public function render()
    {
        $settings = Setting::whereIn("key", $this->_invoiceHeaderInfo())->pluck("value", "key")->toArray();
        return view('components.admin.invoice-header-component' ,get_defined_vars());
    }

    private function _invoiceHeaderInfo() : array
    {
        return [
            "site_logo",
            "address",
            "zip_code",
            "legal_registration_no",
            "email",
            "website",
            "phone",
            "tax_no"
        ];
    }
}
