<?php

namespace App\Repositories\Admin;

use App\Models\Area;
use Illuminate\Support\Collection;
use App\Repositories\Api\BaseRepository;

class AreaRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return Area::class;
    }

    /**
     * Get List Of areas As collection For Select Menu
     * 
     * @return Collection
     */
    public function areasMenu() : Collection
    {
        return $this->all()->get();
    }
}
