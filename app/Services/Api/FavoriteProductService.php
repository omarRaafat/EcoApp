<?php

namespace App\Services\Api;

use App\Http\Resources\Api\ProductResource;
use App\Models\FavoriteProduct;
use App\Models\Product;
use App\Models\User;
use App\Repositories\Api\ProductRepository;
use Illuminate\Support\Facades\DB;

class FavoriteProductService
{
    /**
     * Vendor Service Constructor.
     *
     * @param Vendorepository $repository
     */
   public function __construct(public ProductRepository $repository) {}


   public function getFavoriteProducts()
   {
        $customer_id = auth('api_client')->user()->id;
        $favs = FavoriteProduct::query()->where('user_id' , $customer_id)->get('product_id')->toArray();
       $products = Product::query()->whereIn('id' , array_column($favs , 'product_id' ))->get();
       return [
            'success'=>true,
            'status'=>200 ,
            'data'=> ProductResource::collection($products),
            'message'=>__('products.api.products_retrived')
        ];

   }

   public function addFavoriteProduct($product_id)
   {
        $customer_id = auth('api_client')->user()->id;
        $checkExist = DB::table('favorite_products')->where('user_id' , $customer_id)->where('product_id' , $product_id)->first();

        if(!is_null($checkExist))
            return [
                'success'=>true,
                'status'=>200 ,
                'data'=> [],
                'message'=>__('products.api.favorite.product_already_exists')
            ];

        if(empty($this->repository->getModelUsingID($product_id)))
            return [
                'success'=>false,
                'status'=>404 ,
                'data'=> [],
                'message'=>__('products.api.product_not_found')
            ];

       $products = DB::table('favorite_products')->insert(array(
           'user_id'      => $customer_id,
           'product_id'   => $product_id,
       ));

        // $products = $customer->favorite_products()->attach([$product_id]);
        return [
            'success'=>true,
            'status'=>200 ,
            'data'=> [],
            'message'=>__('products.api.favorite.product_added')
        ];

   }

   public function deleteFavoriteProduct($product_id)
   {
    //$products = $customer->favorite_products()->detach([$product_id]);
       $products = DB::table('favorite_products')->where(array(
           'user_id'      => auth('api_client')->user()->id,
           'product_id'   => $product_id,
       ))->delete();

        return [
            'success'=>true,
            'status'=>200 ,
            'data'=> [],
            'message'=>__('products.api.favorite.product_deleted')
        ];

   }



}
