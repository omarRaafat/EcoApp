<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateBlogPostRequest extends FormRequest
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
            'title.*' => ["required", "string", "min:3",'max:600'],
            'body.*' => ["required", "string", "min:3",'max:10000'],
            'short.*' => ["required", "string", "min:3",'max:600'],
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
            "title_ar.required"  => trans("admin.recipes.validations.title_ar_required"),
            "title_ar.string"    => trans("admin.recipes.validations.title_ar_string"),
            "title_ar.min"       => trans("admin.recipes.validations.title_ar_min"),

            "title_en.required"  => trans("admin.recipes.validations.title_en_required"),
            "title_en.string"    => trans("admin.recipes.validations.title_en_string"),
            "title_en.min"       => trans("admin.recipes.validations.title_en_min"),

            "body_ar.required"  => trans("admin.recipes.validations.body_ar_required"),
            "body_ar.string"    => trans("admin.recipes.validations.body_ar_string"),
            "body_ar.min"       => trans("admin.recipes.validations.body_ar_min"),

            "body_en.required"  => trans("admin.recipes.validations.body_en_required"),
            "body_en.string"    => trans("admin.recipes.validations.body_en_string"),
            "body_ar.min"       => trans("admin.recipes.validations.body_en_min"),

            "short_desc_ar.required"  => trans("admin.recipes.validations.short_desc_ar_required"),
            "short_desc_ar.string"    => trans("admin.recipes.validations.short_desc_ar_string"),
            "short_desc_ar.min"       => trans("admin.recipes.validations.short_desc_ar_min"),

            "short_desc_en.required"  => trans("admin.recipes.validations.short_desc_en_required"),
            "short_desc_en.string"    => trans("admin.recipes.validations.short_desc_en_string"),
            "short_desc_en.min"       => trans("admin.recipes.validations.short_desc_en_min"),



        ];
    }
}
