<?php

namespace App\Repositories\Admin;

use App\Models\ProductPrice;
use App\Repositories\Api\BaseRepository;

class ProductCountryPricesRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return ProductPrice::class;
    }

  
}
