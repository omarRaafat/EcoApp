<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateWalletRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "customer_id" => [
                "required",
                Rule::unique('wallets', 'customer_id')->ignore(request()->get('customer_id'), 'customer_id')->where('deleted_at', NULL),
                "integer",
                "exists:users,id"
            ],
            "is_active" => ["nullable", "boolean"],
            "reason" => ["nullable", "string"]
        ];
    }

    /**
     * Set Custom validation messages.
     *
     * @return array
     */
    public function messages() : array
    {
        return [
            "customer_id.required" => trans("admin.customer_finances.wallets.validations.customer_id_required"),
            "customer_id.unique" => trans("admin.customer_finances.wallets.validations.customer_id_unique")
        ];
    }
}
