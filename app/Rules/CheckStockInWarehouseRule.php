<?php

namespace App\Rules;

use App\Models\Product;
use App\Models\Vendor;
use App\Models\Warehouse;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class CheckStockInWarehouseRule implements Rule
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
                $vendorRequest = $this->request['vendors'][$indexOfVendors];
            }
            $product = Product::findOrFail($productRequest['product_id']);
            $stock = $product->stock ?? 0;
            // if(!is_null($productRequest['warehouse_id'])){
                // recieve cases
            if(!is_null($productRequest['warehouse_id']) &&  $this->request['vendors'][$indexOfVendors]['shipping_type_id'] == 1){
                $warehouse = Warehouse::find($productRequest['warehouse_id']);
                if(!$warehouse){
                    $this->msg =  __('validation.warehouse_id_doesnt_exist') ;
                    return false ;
                }

                if($warehouse->vendor_id != $vendorRequest['vendor_id'] ){
                    $this->msg = __('validation.warehouse_doesnt_available_in_this_vendor') ;
                    return false;
                }
                if(! in_array($vendorRequest['shipping_type_id'], $warehouse->shippingTypes()->pluck('shipping_type_id')->toArray())){
                    $this->msg =  __('validation.shipping_type_doesnt_available_in_vendor') ;
                    return false;
                }

                if($productRequest['quantity'] > $stock){
                    $this->msg =  __('validation.product_doesnt_have_stock'  , ['available_stock' => $stock]) ;
                    return false ;
                }

                $warehouse = $product->warehouseStock()->where('warehouse_id' , $productRequest['warehouse_id'])->first() ;
                if(is_null($warehouse)){
                    $this->msg = __('validation.warehouse_doesnt_exist');
                    return false ;
                }

                if($productRequest['quantity'] > $warehouse->stock ){
                    $this->msg = __('validation.warehouse_doesnt_have_stock' , ['available_stock' => $warehouse->stock]);
                    return false ;
                }

                // Deliver cases
            }else if(is_null($productRequest['warehouse_id']) &&  $this->request['vendors'][$indexOfVendors]['shipping_type_id'] == 2){
                $vendor = Vendor::find($vendorRequest['vendor_id']);
                    $vendorDeliverWarehouse = $vendor->warehousesDeliver()?->first();
                    if($vendorDeliverWarehouse){
                        if(in_array($vendorDeliverWarehouse->id , $product->warehouseStock()->pluck('warehouse_id')->toArray() )){
                            $stock = $product->warehouseStock()->where('warehouse_id' , $vendorDeliverWarehouse['id'])->first()?->stock;
                            if($stock < $productRequest['quantity']){
                                $this->msg = __('validation.product_doesnt_have_stock_in_warehouse');
                                return false ;
                            }
                        }else{
                            $this->msg = __('validation.no_quantity_in_stock_with_delivery_warehouse');
                            return false ;
                        }
                    }else{
                        $this->msg = __('validation.vendor_doesnt_have_delivery_method');
                        return false ;
                    }

            }elseif(!is_null($productRequest['warehouse_id']) &&  $this->request['vendors'][$indexOfVendors]['shipping_type_id'] == 2){
                $this->msg = __('validation.warehouse_id_must_be_null');
                return false ;
            }
            // else{
            //     $vendor = Vendor::find($vendorRequest['vendor_id']);
            //     $vendorDeliverWarehouse = $vendor->warehousesDeliver()?->first();
            //     if($vendorDeliverWarehouse){
            //         $stock = $product->warehouseStock()->where('warehouse_id' , $vendorDeliverWarehouse['id'])->first()?->stock;
            //         if($stock < $productRequest['quantity']){
            //             $this->msg = __('validation.warehouse_doesnt_exist');
            //             return false ;
            //         }
            //     }else{
            //         $this->msg = __('validation.vendor_doesnt_have_delivery_method');
            //         return false ;
            //     }
            // }
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
