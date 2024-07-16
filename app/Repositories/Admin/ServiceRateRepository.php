<?php

namespace App\Repositories\Admin;

use App\Models\ServiceReview;
use App\Repositories\Api\BaseRepository;

class ServiceRateRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return ServiceReview::class;
    }
}
