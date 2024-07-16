<?php

namespace App\Rules;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class CheckProductExistInVendorRule implements Rule
{
    private $request;
    private $msg ;
    private $is_sync ;

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
                $indexOfProduct = explode('.', $attribute)[4];
                $productRequest= $this->request['vendors'][$indexOfVendors]['products'][$indexOfProduct] ?? null;
                $vendorRequest= $this->request['vendors'][$indexOfVendors] ?? null;
            }
            $product = Product::findOrFail($productRequest['product_id']);
            if($product->vendor_id !=$vendorRequest['vendor_id']){
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
        return __('validation.vendor_doesnt_have_this_product');
    }
}
