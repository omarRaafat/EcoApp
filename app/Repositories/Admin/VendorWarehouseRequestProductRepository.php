<?php

namespace App\Repositories\Admin;

use App\Repositories\Api\BaseRepository;
use App\Models\VendorWarehouseRequestProduct;

class VendorWarehouseRequestProductRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return VendorWarehouseRequestProduct::class;
    }
}
