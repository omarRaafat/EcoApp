<?php

namespace App\State\InvoiceState;

class Pending extends InvoiceState
{
    public function title(): string
    {
        return __("Invoice.state.pending.title");
    }

    public function badgeClass(): string
    {
        return __("Invoice.state.pending.badge_class");
    }
}
