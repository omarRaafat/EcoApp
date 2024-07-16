<?php

namespace App\Repositories\Admin;

use App\Models\VendorWarehouseRequest;
use App\Repositories\Api\BaseRepository;

class VendorWarehouseRequestRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return VendorWarehouseRequest::class;
    }
}
