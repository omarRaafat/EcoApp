<?php

namespace App\Repositories\Admin;

use App\Models\TorodCompany;
use App\Repositories\Api\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class TorodCompanyRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return TorodCompany::class;
    }
}
