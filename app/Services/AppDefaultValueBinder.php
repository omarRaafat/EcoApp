<?php

namespace App\Services;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class AppDefaultValueBinder extends \Maatwebsite\Excel\DefaultValueBinder {
    /**
     * @throws \JsonException
     */
    public function bindValue(\PhpOffice\PhpSpreadsheet\Cell\Cell $cell, $value): bool
    {
        if (is_array($value)) {
            $value = \json_encode($value, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
        }

        return parent::bindValue($cell, $value);
    }
}
