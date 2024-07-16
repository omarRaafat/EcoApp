<?php

namespace App\Repositories\Admin;

use App\Models\City;
use Illuminate\Support\Collection;
use App\Repositories\Api\BaseRepository;

class CityRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return City::class;
    }

    /**
     * Get List Of cities As collection For Select Menu
     * 
     * @return Collection
     */
    public function citiesMenu() : Collection
    {
        return $this->all()->get();
    }
}
