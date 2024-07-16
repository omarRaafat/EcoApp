<?php

namespace App\Repositories\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Repositories\Api\BaseRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;

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
