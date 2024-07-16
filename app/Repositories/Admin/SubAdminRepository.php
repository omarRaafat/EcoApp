<?php

namespace App\Repositories\Admin;

use App\Models\User;
use App\Repositories\Api\BaseRepository;

class SubAdminRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return User::class;
    }
}
