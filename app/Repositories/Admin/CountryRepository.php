<?php

namespace App\Repositories\Admin;

use App\Models\Country;
use Illuminate\Support\Collection;
use App\Repositories\Api\BaseRepository;

class CountryRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return Country::class;
    }

    /**
     * Get List Of Countries As collection For Select Menu
     * 
     * @return Collection
     */
    public function countriesMenu() : Collection
    {
        return $this->all()->get();
    }
}
