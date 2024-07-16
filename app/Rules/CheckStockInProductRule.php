<?php

namespace App\Rules;

use App\Models\Product;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class CheckStockInProductRule implements Rule
{
    private $request;
    private $msg ; 

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
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
        
        $product = Product::findOrFail($this->request['product_id']);

        if((int) $this->request['quantity'] > $product->stock && $product->stock > 0 ){
            $this->msg = __('validation.product_doesnt_have_stock' , ['available_stock' => $product->stock ?? 0]);
            return false ;
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
