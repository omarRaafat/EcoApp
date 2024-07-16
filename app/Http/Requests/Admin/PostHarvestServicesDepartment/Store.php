<?php

namespace App\Http\Requests\Admin\PostHarvestServicesDepartment;

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
    public function rules() : array
    {
        switch ($this->method()) {
            case 'POST':
            {
                return [
                    'name' =>'required|string',
                    'image' => 'nullable|image|mimes:png,jpg|max:4000',
                    'status' => 'nullable|in:active,in_active'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    // 'id' => '',
                    'name' =>'required|string',
                    'image' => 'image|mimes:png,jpg|max:4000',
                    'status' => 'nullable|in:active,in_active'
                ];
            }
            default: break;
        }
    }
}
