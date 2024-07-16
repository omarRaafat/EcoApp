<?php

namespace App\Repositories;

use App\Models\StaticContent;
use App\Repositories\Api\BaseRepository;

class StaticContentRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return StaticContent::class;
    }
}
