<?php

namespace App\Repositories\Admin;

use App\Models\Review;
use App\Repositories\Api\BaseRepository;

class ProductRateRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return Review::class;
    }
}
