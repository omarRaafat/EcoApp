<?php

namespace App\Http\Requests\Admin;

use App\Enums\CouponType;
use Illuminate\Foundation\Http\FormRequest;

class CouponStorFormRequest extends FormRequest
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
        $return = [
            'title.*' => ['required', 'string', 'max:255'],

            'code' => ["required", "min:4",'max:90','unique:coupons,code'],
            'amount' => ["required", "numeric", "min:1",
                function ($attribute, $value, $fail)
                {
                    if(isset(request()->discount_type) &&  request()->discount_type =='percentage' && $value > 100)
                    {
                        $fail(__("admin.coupons.validations.amount_percentage"),);
                    }
                    elseif(isset(request()->discount_type) &&  request()->discount_type =='fixed' && $value > 1000000)
                    {
                        $fail(__("admin.coupons.validations.amount_fixed"),);
                    }
                }
            ],
            'minimum_order_amount' => ["required", "numeric", "min:1",'max:999999.99'],
            'maximum_discount_amount' => ["nullable", "numeric", "min:1",'max:999999.99'],
            'coupon_type' => ["required","in:" . implode(",", CouponType::getCouponTypes())],
            'discount_type' => ["required", "in:percentage,fixed"],
            'maximum_redemptions_per_user' => ["nullable",'integer','max:1000000','min:1', 'lte:maximum_redemptions_per_coupon'],
            'maximum_redemptions_per_coupon' => ["nullable",'integer','max:1000000','min:1'],
            'start_at' => ["nullable",'date','before:expire_at'],
            'expire_at' => ["nullable",'date','after:start_at'],
        ];

        if(request()->coupon_type == 'vendor') {
            $return['vendors'] = ["required","array"];
        }

        if(request()->coupon_type == 'product') {
            $return['products'] = ["required","array"];
        }

        return $return;
    }

    /**
     * Set Custom validation messages.
     *
     *
     * @return array
     *
     */
    public function attributes() : array
    {
        return [
            'title.*' => '('. __('validation.title') .')',
            // 'title_en' => '('. __('admin.coupons.title') .')',
            'code' => '('. __('admin.coupons.code') .')',
            'amount' => '('. __('admin.coupons.amount') .')',
            'minimum_order_amount' => '('. __('admin.coupons.minimum_order_amount') .')',
            'maximum_discount_amount' => '('. __('admin.coupons.maximum_discount_amount') .')',
            'coupon_type' => '('. __('admin.coupons.coupon_type') .')',
            'discount_type' => '('. __('admin.coupons.discount_type') .')',
            'maximum_redemptions_per_user' => '('. __('admin.coupons.maximum_redemptions_per_user') .')',
            'maximum_redemptions_per_coupon' => '('. __('admin.coupons.maximum_redemptions_per_coupon') .')',
            'start_at' => '('. __('admin.coupons.start_at') .')',
            'expire_at' => '('. __('admin.coupons.expire_at') .')',
            'vendors' => '('. __('admin.coupons.vendors') .')',
            'products' => '('. __('admin.coupons.products') .')',
        ];
    }
}
