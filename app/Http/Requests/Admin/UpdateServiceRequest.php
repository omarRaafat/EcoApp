<?php

namespace App\Http\Requests\Admin;

use App\Models\PostHarvestServicesDepartment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateServiceRequest extends FormRequest
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
        $rules = [];

        $category = PostHarvestServicesDepartment::find($this->category_id);

        if ($category) {
            foreach ($category->post_harvest_services_department_fields->where('status', 'active')->where('depends_on_price_text', true) as $field) {
                // Add rule for price if field depends on price text
                if ($field->type !== 'dropdown-list' && $field->depends_on_price_text) {
                    $rules['fields.' . $field->name . '.price'] = 'required|numeric|min:1';
                } elseif($field->type === 'dropdown-list' && $field->depends_on_price_text) {
                    $rules['fields.' . $field->name . '.price.*'] = 'nullable|numeric|min:1';
                }

                // Get field-specific rules
                $fieldRules = $this->getFieldRule($field);
                $rules = array_merge($rules, $fieldRules);
            }
        }

        // Define additional rules
        $additionalRules = [
            "category_id" => "required|exists:post_harvest_services_departments,id",
            "vendor_id" => "required|exists:vendors,id",
            "name.*" => "required|string|min:3|max:250",
            "desc.*" => "required",
            "conditions.*" => "required",
            "is_visible" => "required|in:0,1",
            "image" => "nullable|image|dimensions:min_width=800,min_height=800|max:1500",
            'cities' => 'required|array',
            'cities.*' => 'exists:cities,id',
        ];

        // Merge field-specific and additional rules
        $rules = array_merge($rules, $additionalRules);

        return $rules;
    }

    private function getFieldRule($field)
    {
        // Define the basic type rules
        $typeRules = [
            'text-area' => ['fields.' . $field->name . '.value' => 'string'],
            'checkbox' => ['fields.' . $field->name . '.value' => 'array'],
            'dropdown-list' => ['fields.' . $field->name . '.value' => 'string'],
            'integer' => ['fields.' . $field->name . '.value' => 'integer'],
        ];

        // Handle 'from-to' field type
        if ($field->required && $field->type == 'from-to') {
            $typeRules["fields.{$field->name}.value.from"] = 'required|integer|min:1';
            $typeRules["fields.{$field->name}.value.to"] = 'required|integer|min:1';
        }

        if ($field->type == 'from-to') {
            $typeRules["fields.{$field->name}.value.from"] = 'nullable|integer|min:1';
            $typeRules["fields.{$field->name}.value.to"] = 'nullable|integer|min:1';
        }

        // Add 'required' rule if the field is mandatory and not 'from-to'
        if ($field->required && $field->type != 'from-to') {
            $typeRules['fields.' . $field->name . '.value'][] = 'required';
        }

        return $typeRules;
    }

    public function attributes()
    {
        $category = PostHarvestServicesDepartment::find($this->category_id);
        $attributes = [];

        if ($category) {
            foreach ($category->post_harvest_services_department_fields as $field) {
                // Map attribute names for fields
                $attributes["fields.{$field->name}.value"] = $field->name;
                $attributes["fields.{$field->name}.price"] = "سعر {$field->name}";

                // Add attributes for 'from-to' fields
                if ($field->type == 'from-to') {
                    $attributes["fields.{$field->name}.value.from"] = "من {$field->name}";
                    $attributes["fields.{$field->name}.value.to"] = "الى {$field->name}";
                }
            }
        }

        // Additional attribute mappings
        $additionalAttributes = [
            "category_id" => __('translation.main_category'),
            "vendor_id" => __('admin.products.vendor'),
            "name.ar" => __('translation.service_name') .' '. __('translation.arabic'),
            "name.en" => __('translation.service_name') .' '. __('translation.english'),
            "desc.ar" => __('translation.service_desc') .' '. __('translation.arabic'),
            "desc.en" => __('translation.service_desc') .' '. __('translation.english'),
            "conditions.ar" => __('translation.service_conditions') .' '. __('translation.arabic'),
            "conditions.en" => __('translation.service_conditions') .' '. __('translation.english'),
            "is_visible" => __('translation.is_visible'),
            "price" => __('translation.price'),
            "image" => __('translation.service_image'),
            "cities" => __('translation.cities'),
        ];

        // Merge field-specific and additional attributes
        return array_merge($attributes, $additionalAttributes);
    }
}
