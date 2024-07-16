<?php

namespace App\Repositories\Admin;

use App\Models\UserVendorRate;
use App\Repositories\Api\BaseRepository;

class VendorRateRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return UserVendorRate::class;
    }
}
