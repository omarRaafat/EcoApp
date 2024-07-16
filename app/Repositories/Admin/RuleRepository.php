<?php

namespace App\Repositories\Admin;

use App\Models\Rule;
use App\Repositories\Api\BaseRepository;

class RuleRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return Rule::class;
    }
}
