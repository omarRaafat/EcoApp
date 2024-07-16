<?php

namespace App\Repositories\Api;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Repositories\Api\BaseRepository;


class AddressRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return Address::class;
    }

}
