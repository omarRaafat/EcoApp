<?php

namespace App\Http\Requests\Admin\PageSeo;

use Illuminate\Foundation\Http\FormRequest;

class Create extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            "page" => "required|unique:page_seos,page"
        ];
        foreach(config("app.locales") as $locale) {
            $rules["tags.$locale"] = "required";
            $rules["description.$locale"] = "required";
        }
        return $rules;
    }

    public function attributes()
    {
        $attributes = [
            "page" => __('page-seo.page-name')
        ];
        foreach(config("app.locales") as $locale) {
            $attributes["tags.$locale"] = __('page-seo.page-tags') ." ". __("page-seo.$locale");
            $attributes["description.$locale"] = __('page-seo.page-description') ." ". __("page-seo.$locale");
        }
        return $attributes;
    }
}
