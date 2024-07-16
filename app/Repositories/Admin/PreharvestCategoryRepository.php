<?php

namespace App\Repositories\Admin;

use App\Models\Category;
use App\Models\PreharvestCategory;
use Illuminate\Http\Request;
use App\Repositories\Api\BaseRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;

class PreharvestCategoryRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return PreharvestCategory::class;
    }
}
