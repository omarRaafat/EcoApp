<?php

namespace App\Repositories;

use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Repositories\Api\BaseRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;

class RecipeRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return Recipe::class;
    }
}
