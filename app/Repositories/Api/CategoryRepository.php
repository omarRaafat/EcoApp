<?php

namespace App\Repositories\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Repositories\Api\BaseRepository;


class CategoryRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return Category::class;
    }
}