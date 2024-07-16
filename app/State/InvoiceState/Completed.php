<?php

namespace App\State\InvoiceState;

class Completed extends InvoiceState
{
    public function title(): string
    {
        return __("Invoice.state.completed.title");
    }

    public function badgeClass(): string
    {
        return __("Invoice.state.completed.badge_class");
    }
}
