<?php

namespace App\Repositories\Api;

use App\Models\CartProduct;
use Illuminate\Http\Request;
use App\Repositories\Api\BaseRepository;


class CartProductRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return CartProduct::class;
    }
}
