<?php

namespace App\Repositories\Admin;

use App\Models\ProductQuantity;
use Illuminate\Support\Collection;
use App\Repositories\Api\BaseRepository;

class ProductQuantityRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return ProductQuantity::class;
    }
}
