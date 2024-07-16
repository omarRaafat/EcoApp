<?php

namespace App\Http\Requests\Admin\ClientMessage;

use Illuminate\Support\Str;
use App\Enums\ClientMessageEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClientMessage extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [];
        foreach(config("app.locales") as $locale) {
            $rules["message.$locale"] = [
                "required",
                function ($attribute, $value, $fail) {
                    $variables = ClientMessageEnum::getMessageVariables($this->client_message->message_for);
                    $missedVariables = collect([]);
                    foreach($variables ?? [] as $variable) {
                        if (!Str::contains($value, $variable)) $missedVariables->push($variable);
                    }
                    if ($missedVariables->isNotEmpty())
                        $fail(
                            __("client-messages.missed-variables", ['variables' => $missedVariables->implode(",")])
                        );
                }
            ];
        }
        return $rules;
    }

    public function attributes() {
        $attributes = [];
        foreach(config("app.locales") as $locale) {
            $attributes["message.$locale"] = __("client-messages.message") ." ". __("languages.$locale");
        }
        return $attributes;
    }
}
