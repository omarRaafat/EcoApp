<?php

namespace App\Services\Api;

use App\Http\Resources\Api\ProductReviewResource;
use App\Models\Product;
use App\Repositories\Api\ProductRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use App\Services\Eportal\Connection;

class ProductService
{

    /**
     * Product Service Constructor.
     *
     * @param ProductRepository $repository
     */
    public function __construct(public ProductRepository $repository) {

    }

    /**
     * Get Products.
     *
     * @return Collection
     */
    public function getAllProducts() : Collection
    {
        return $this->repository->all()->withAvg('reviews','rate')->available()->with(['quantity_type'])
        ->withCount('reviews')->get();
    }

    /**
     * Get Products with pagination.
     *
     * @param integer $perPage
     * @return LengthAwarePaginator
     */
    public function getAllProductsWithPagination(int $perPage = 10) : LengthAwarePaginator
    {
        return $this->repository->all()->available()->with(['quantity_type'])
        ->paginate($perPage);
    }

        /**
     * Get Products with pagination.
     *
     * @param integer $perPage
     * @return array
     */
    public function getAllProductsInfinityLoad(int $perPage = 10 ) : Array
    {
        $page = (request()->page ?? 1) ;
        $offset = ($page - 1) * $perPage;

        $products = $this->repository->all()->available()->with(['quantity_type'])
        ->when(!empty(request()->get('search')),function($qr){
            $qr->search(request()->get('search'));
        })
        ->when(!empty(request()->get('category_id')),function($qr){
            $qr->where('category_id',intval(request()->get('category_id')));
        })
        ->when(!empty(request()->get('city_id')),function($qr){
            $qr->whereHas('warehouseStock',function($qr2){
                $qr2->whereHas('WarehouseShippingTypeReceive',function($qr3){
                    $qr3->whereHas('warehouse',function($qr4){
                        $qr4->whereHas('cities',function($qr5){
                            $qr5->where('city_id',request()->get('city_id'));
                        });
                    });
                });
            });
        });
        $count = $products->count();

        $products = $products->offset($offset)->take($perPage)->get();

        $next = ($page * $perPage) < $count;

        return [
            'products' => $products,
            'next' => $next,
        ];
    }        /**
     * Get Products with pagination.
     *
     * @param integer $perPage
     * @return array
     */
    public function site_map(int $perPage = 10 ) : Array
    {

        $products_data  = [];
        $products = $this->repository->all()->available()->with(['quantity_type'])->get();
        foreach ($products as $product)
        {
            $products_data[]=
                [
                    'name' => env('WEBSITE_BASE_URL').'/product/'. $product->getTranslation("name", "ar"),
                    'link' => env('WEBSITE_BASE_URL').'/product/'. $product->id .'/'.$product->getTranslation("name", "ar")
                ];

        }

        return [
            'products' => $products_data,
        ];
    }

    /**
     * Get Product using ID.
     *
     * @param integer $id
     * @return Product
     */
    public function getProductUsingID(int $id) : Product|null
    {
        return $this->repository->all()->available()
        ->where('id',$id)->orwhere('slug',$id)
        ->first();

    }

    public function product_related($product)
    {
        return $this->repository->all()->available()
        ->where('id','!=',$product['id'])
            ->where(function ($query) use ($product) {
                $query->where('category_id',$product['category_id'])
                    ->Orwhere('sub_category_id',$product['sub_category_id'])
                    ->Orwhere('final_category_id',$product['final_category_id']);
            })
            ->take(7)->get();

    }
    /**
     * Get Products with pagination By category id.
     *
     * @param integer $category_id
     * @return LengthAwarePaginator
     */
    public function getProductsUsingCategotyID(int $category_id, $perPage=20)
    {
        return $this->repository->all()->available()->with(['quantity_type'])
        ->where('category_id',$category_id)->paginate($perPage);
    }

    public function addProductReview(Request $request){
        $product = $this->getProductUsingID($request->product_id);
        if($product == null)
            return ['success'=>false, 'status'=>404 ,
                   'data'=>[],'message'=>__('products.api.product_not_found')];
        $review = $this->repository->createReview($product,[
                'user_id'=> auth('api_client')->user()->id,
                'rate'=>$request->rate,
                'comment'=>$request->comment,
        ]);

         return [
            'success'=>true,
            'status'=>200 ,
            'data'=>new ProductReviewResource($review),
            'message'=>__('products.api.product_review_created')
        ];
    }



    public function getSortedProducts($vendor_id, $filter,$perPage=10)
    {
        $products = Product::available()->where('vendor_id',$vendor_id)->with(['quantity_type'])
        ->withSum('orderProducts','quantity');

        if(!empty(request()->get('city_id'))){
            $products = $products->whereHas('warehouseStock',function($qr2){
                $qr2->whereHas('WarehouseShippingTypeReceive',function($qr3){
                    $qr3->whereHas('warehouse',function($qr4){
                        $qr4->whereHas('cities',function($qr5){
                            $qr5->where('city_id',request()->get('city_id'));
                        });
                    });
                });
            });
        }

        if($filter == 'best_rate'){
            $products = $products->orderBy('rate','DESC');
        }
        elseif($filter == 'best_selling'){
            $products = $products->orderBy('order_products_sum_quantity','DESC');
        }
        else{
            $products = $products->orderBy('id','DESC');
        }




        return $products->paginate($perPage);

    }

    public function checkAvilablity($id)
    {
        $vendor = $this->repository->getProductIfAvailable($id);
        if($vendor == null)
            return false;
        return true;

    }

}
