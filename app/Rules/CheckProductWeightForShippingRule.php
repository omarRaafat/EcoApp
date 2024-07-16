<?php

namespace App\Rules;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class CheckProductWeightForShippingRule implements Rule
{
    private $request , $msg;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
         $this->request = $request->all();
         $this->msg = 'The validation error message.';
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
            if (str_contains($attribute, 'vendors')) {
                $indexOfVendors = explode('.', $attribute)[2];
                $vendorRequest= $this->request['vendors'][$indexOfVendors] ?? null;
            }

            if($vendorRequest['shipping_type_id'] == 1 && !is_null($vendorRequest['shipping_method_id'])){
                $this->msg = __('validation.shipping_method_id_null_validation');
                return false;
            }


            $total_weight = 0;
            foreach($vendorRequest['products'] as $productRequest){
            $product = Product::findOrFail($productRequest['product_id']);
                $total_weight = $product->totalWeightByKilo * $productRequest['quantity'];
            }
           if($total_weight > 30 && $vendorRequest['shipping_method_id'] == 2 && $vendorRequest['shipping_type_id'] == 2){
               $this->msg = __('validation.sobl_not_available');
               return false;
            }


        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->msg;
    }
}
