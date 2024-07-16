<?php

namespace App\Http\Requests\Admin\PostHarvestServicesDepartmentFeild;

use App\Models\PostHarvestServicesDepartmentField;
use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
            {
                return [
                    'name' =>['required','string','unique:post_harvest_services_department_fields,name'],
                    'type' => 'required|in:text-area,dropdown-list,checkbox,integer,from-to',
                    'is_required' => 'required|in:0,1',
                    'depends_on_price' => 'required|in:0,1',
                    'post_harvest_id' => 'required|exists:post_harvest_services_departments,id',
                    'status' => 'nullable|in:active,in_active',
                    'values' => 'nullable|array|min:1'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    // 'id' => '',
                    'name' =>'required|string',
                    'type' => 'nullable|in:text-area,dropdown-list,checkbox,integer,from-to',
                    'is_required' => 'required|in:0,1',
                    'depends_on_price' => 'required|in:0,1',
                    // 'post_harvest_id' => 'required|exists:post_harvest_services_departments,id',
                    'status' => 'nullable|in:active,in_active',
                    'values' => 'nullable|array|min:1',
                ];
            }
            default: break;
        }
    }
}
