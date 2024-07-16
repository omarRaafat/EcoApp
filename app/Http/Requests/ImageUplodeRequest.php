<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageUplodeRequest extends FormRequest
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
            'file' => ['image','dimensions:min_width=800,min_height=800','max:1500']

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
            'file.image' => __('admin.products.image'),
            'file.dimensions' => __('admin.products.image-validation'),
            'file.max' => __('admin.products.image-validation-max'),
        ];
        }

  
}
