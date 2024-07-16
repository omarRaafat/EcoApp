<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StaticContentRequest extends FormRequest
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
            'title.*' => ["required", "string", "min:3",'max:600'],
            // 'title_en' => ["required", "string", "min:3",'max:600'],
            'paragraph.*' => ["required", "string", "min:50",'max:20000'],
            // 'paragraph_ar' => ["required", "string", "min:50",'max:1000'],
        ];
    }

}
