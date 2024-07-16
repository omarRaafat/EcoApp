<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class IncreaseAndDecreaseWalletBalanceRequest extends FormRequest
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
            "amount" => ["required", "numeric", "min:0.001", "max:1000000"],
            "type" => ["required", "numeric"],
            "transaction_type" => ["required", "numeric"],
        ];
    }

    /**
     * Set new validation messages
     *
     * @return array
     */
    public function messages() : array
    {
        return [
            "amount.required" => trans("admin.customer_finances.wallets.transaction.validations.amount_required"),
            "amount.numeric" => trans("admin.customer_finances.wallets.transaction.validations.amount_numeric"),
            "type.required" => trans("admin.customer_finances.wallets.transaction.validations.type_required"),
            "type.numeric" => trans("admin.customer_finances.wallets.transaction.validations.type_numeric"),
            "transaction_type.required" => trans("admin.customer_finances.wallets.transaction.validations.transaction_type_required"),
            "transaction_type.numeric" => trans("admin.customer_finances.wallets.transaction.validations.transaction_type_numeric"),
        ];
    }
}
