<?php

namespace App\Http\Requests\Vendor;

use App\Enums\UserTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->check() ? auth()->user() : null;
        return $user ? ($user->type == UserTypes::VENDOR || $user->type == UserTypes::SUBVENDOR) : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = app('request')->segment(3);
        return [
            "category_id" => "required|exists:categories,id",
/*             "sub_category_id" => [
                 "required",
                 Rule::exists('categories', 'id')->where('parent_id', request()->get('category_id'))
             ],
             "final_category_id" => [
                 Rule::exists('categories', 'id')->where('parent_id', request()->get('sub_category_id'))
             ],*/
            "name.*" => "required|string|min:3|max:250",
            "desc.*" => "required",
            // "name.en" => "required|string|min:3|max:250",
//             "desc.ar" => "required|min:100",
            // "desc.en" => "required|min:100",
            "total_weight" => "required|numeric|min:0.1",
            "net_weight" => "required|numeric|min:0.1",
            "length" => "nullable|numeric|min:0.1",
            "width" => "nullable|numeric|min:0.1",
            "height" => "nullable|numeric|min:0.1",
            "is_visible" => "required|in:0,1",
            "price" => "required|numeric|min:0.1|max:1000000",
            "price_before_offer" => "nullable|numeric|max:1000000",
            // "order" => "required|numeric|min:1|max:10000",
            "quantity_type_id" => [
                "required",
                Rule::exists('product_quantities', 'id')->where('is_active', 1)
            ],
            "type_id" => "nullable|exists:product_classes,id",
            "quantity_bill_count" => "nullable|min:0|max:10000",
            "bill_weight" => "nullable|min:0|max:10000",
            // "expire_date" => "required|date_format:Y-m-d",
            "image" => "nullable|image|dimensions:min_width=800,min_height=800|max:1500",
            "hs_code" => "nullable|min:3|max:250|string",
            "sku" => "required|unique:products,sku,". $id,
        ];
    }

    public function attributes()
    {
        return [
            "category_id" => __('translation.main_category'),
/*            "sub_category_id" => __('translation.sub_category'),
            "final_category_id" => __('translation.final_category'),*/
            "name.ar" => __('translation.product_name') .' '. __('translation.arabic'),
            "name.en" => __('translation.product_name') .' '. __('translation.english'),
            "desc.ar" => __('translation.product_desc') .' '. __('translation.arabic'),
            "desc.en" => __('translation.product_desc') .' '. __('translation.english'),
            "total_weight" => __('translation.total_weight'),
            "net_weight" => __('translation.net_weight'),
            "length" => __('translation.length'),
            "width" => __('translation.width'),
            "height" => __('translation.height'),
            "is_visible" => __('translation.is_visible'),
            "price" => __('translation.price'),
            "price_before_offer" => __('translation.price_before_offer'),
            // "order" => __('translation.product_order_sort'),
            "quantity_type_id" => __('translation.quantity_type'),
            "type_id" => __('translation.type'),
            "quantity_bill_count" => __('translation.quantity_bill_count'),
            "bill_weight" => __('translation.bill_weight'),
            "expire_date" => __('translation.product_expire_date'),
            "image" => __('translation.product_image'),
            'hs_code' => __('translation.hs_code'),
        ];
    }

    public function messages()
    {
        return [
            'image.dimensions' => __('admin.products.image-validation'),
        ];
    }
}
