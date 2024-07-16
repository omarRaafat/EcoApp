<?php

namespace App\Http\Requests\Admin\Slider;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
        // TODO: must be changed when go live with 5 langs
        $locales = ["ar", "en"];

        $rules = [
            "url" => "nullable|url|max:250",
            "identifier" => "nullable|min:3|max:250",
            "image" => "nullable|image|max:2048",
        ];

        foreach($locales as $locale) {
            $rules["name.$locale"] = "required|min:3|max:250";
            $rules["category.$locale"] = "required|min:3|max:250";
            $rules["offer.$locale"] = "required|min:3|max:250";
        }

        return $rules;
    }

    public function attributes() {
        // TODO: must be changed when go live with 5 langs
        $locales = [
            "ar" => trans("translation.arabic"),
            "en" => trans("translation.english"),
        ];

        $attributes = [
            "url" => __("admin.sliders.url"),
            "identifier" => __("admin.sliders.identifier"),
            "image" => __("admin.sliders.image"),
        ];

        foreach($locales as $locale => $localeName) {
            $attributes["name.$locale"] = trans('admin.sliders.name') .$localeName;
            $attributes["category.$locale"] = trans('admin.sliders.name') .$localeName;
            $attributes["offer.$locale"] = trans('admin.sliders.name') .$localeName;
        }

        return $attributes;
    }
}
