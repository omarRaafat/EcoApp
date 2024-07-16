<?php

namespace App\Repositories\Admin;

use App\Models\ProductClass;
use Illuminate\Http\Request;
use App\Repositories\Api\BaseRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ProductClassRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return ProductClass::class;
    }
}
