<?php

namespace App\Http\Requests\Webhook;

use Illuminate\Foundation\Http\FormRequest;

class AramexWebhookRequest extends FormRequest
{
    public function rules(): array
    {

        return [
            "Key"                       => ["required"],
            "Value"                     => ["required", "array"],
            "Value.*.WaybillNumber"     => ["required", "max:250"],
            "Value.*.UpdateCode"        => ["required", "max:250"],
            "Value.*.UpdateDateTime"    => ["required", "max:250"],
            "Value.*.Comments"          => ["nullable", "max:250"],
            "Value.*.ProblemCode"       => ["nullable", "max:250"],
            "Value.*.OrderNumber"       => ["nullable", "max:250"],
        ];
    }
}
