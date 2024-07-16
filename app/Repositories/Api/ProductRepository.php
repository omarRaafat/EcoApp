<?php

namespace App\Repositories\Api;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Repositories\Api\BaseRepository;


class ProductRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return Product::class;
    }



    public function createReview(Product $product,Array $review)
    {
        try {
            return $product->reviews()->save(new Review($review));
        } catch (\Illuminate\Database\QueryException $ex) {
            return false;
        }
    }

    public function getProductIfAvailable($id)
    {
        return $this->model->where("id", $id)->available()->first();
    }

    public function getProductIfAvailableWithQuantity($id,$quantity)
    {
        return $this->model->where("id", $id)->hasStock($quantity)->available()->first();
    }
}
