<?php

namespace App\Http\Requests\Vendor\TypeOfEmployee;

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
                    'name' => 'required|string',
                    'level' => 'required|in:1,2,3,4',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
//                    'id' => '',
                    'name' => 'required|string',
                    'level' => 'required|in:1,2,3,4',
                ];
            }
            default: break;
        }
    }
}
