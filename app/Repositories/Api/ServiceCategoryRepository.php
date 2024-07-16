<?php

namespace App\Repositories\Api;

use App\Models\Category;
use App\Models\PostHarvestServicesDepartment;
use Illuminate\Http\Request;
use App\Repositories\Api\BaseRepository;


class ServiceCategoryRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return PostHarvestServicesDepartment::class;
    }
}
