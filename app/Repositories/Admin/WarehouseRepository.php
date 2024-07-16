<?php

namespace App\Repositories\Admin;

use App\Models\Warehouse;
use App\Repositories\Api\BaseRepository;

class WarehouseRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return Warehouse::class;
    }
}
