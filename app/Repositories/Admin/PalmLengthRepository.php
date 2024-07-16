<?php

namespace App\Repositories\Admin;

use App\Models\Category;
use App\Models\PalmLength;
use App\Models\PreharvestCategory;
use App\Models\PreharvestStage;
use Illuminate\Http\Request;
use App\Repositories\Api\BaseRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;

class PalmLengthRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return PalmLength::class;
    }
}
