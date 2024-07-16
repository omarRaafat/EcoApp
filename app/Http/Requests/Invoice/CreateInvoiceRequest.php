<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()?->isAdminPermittedTo('admin.invoices.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "vendor" => [Rule::requiredIf(!$this->all_vendors || blank($this->all_vendors)), "exists:vendors,id"],
            "all_vendors" => ["nullable"],
            "year" => ["required", "numeric"],
            "month" => ["required", "numeric"]
        ];
    }
}
