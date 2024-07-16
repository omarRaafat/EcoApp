<?php

namespace App\Http\Requests\Admin;

use App\Enums\CustomerWithdrawRequestEnum;
use Illuminate\Foundation\Http\FormRequest;

class CustomerWithdrawRequestUpdate extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'status' => 'required|in:'.implode(",", CustomerWithdrawRequestEnum::statuses()),
            'reject_reason' => 'required_if:status,'. CustomerWithdrawRequestEnum::NOT_APPROVED,
            'transaction_type' => 'required_if:status,'. CustomerWithdrawRequestEnum::APPROVED,
            'bank_receipt' => 'required_if:status,'. CustomerWithdrawRequestEnum::APPROVED.'|mimes:png,jpg,pdf|max:2048'
        ];
    }

    public function messages() : array {
        return [
            'status.required' => __('admin.customer_finances.customer-cash-withdraw.validations.status-required'),
            'status.in' => __('admin.customer_finances.customer-cash-withdraw.validations.status-in'),
            'reject_reason.required_if' => __('admin.customer_finances.customer-cash-withdraw.validations.reject_reason-required_if'),
            'bank_receipt.required_if' => __('admin.customer_finances.customer-cash-withdraw.validations.bank_receipt-required_if'),
            'bank_receipt.mimes' => __('admin.customer_finances.customer-cash-withdraw.validations.bank_receipt-mimes'),
            'bank_receipt.max' => __('admin.customer_finances.customer-cash-withdraw.validations.bank_receipt-max'),
            'transaction_type.required_if' => __('admin.customer_finances.customer-cash-withdraw.validations.transaction_type-required_if'),
            'transaction_type.in' => __('admin.customer_finances.customer-cash-withdraw.validations.transaction_type-in'),
        ];
    }
}
