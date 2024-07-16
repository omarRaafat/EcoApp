<?php

namespace App\Integrations\Shipping\Integrations\Traits;

use Illuminate\Support\Facades\Log;

trait Logger {
    /**
     * Shipping Integrations Logger
     */
    private function logger(string $channel, string $message = '', array $context, bool $fail) : void
    {
        if($fail) {
            Log::channel($channel)->error($message,$context);
        } else {
            Log::channel($channel)->info($message,$context);
        }
    }
}