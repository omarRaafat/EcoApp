<?php

namespace App\State\InvoiceState;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class InvoiceState extends State
{
    abstract public function title(): string;
    abstract public function badgeClass(): string;

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Completed::class)
            ->allowTransition(Pending::class, Completed::class);
    }
}
