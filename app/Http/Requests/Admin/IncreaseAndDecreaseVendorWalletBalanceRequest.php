<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class IncreaseAndDecreaseVendorWalletBalanceRequest extends FormRequest
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
            "amount" => ["required", "numeric","min:1"],
            "order_code" => "nullable",
            "receipt" => "nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048",
            "reference_num" => "nullable|string",
            "reason" => "nullable|string",
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
            "amount.required" => trans("admin.vendorWallets.transaction.validations.amount_required"),
            "amount.numeric" => trans("admin.vendorWallets.transaction.validations.amount_numeric"),
            "receipt_url.required" => trans("admin.vendorWallets.transaction.validations.receipt_url_required"),
            "receipt_url.image" => trans("admin.vendorWallets.transaction.validations.receipt_url_image"),
        ];
    }
}
