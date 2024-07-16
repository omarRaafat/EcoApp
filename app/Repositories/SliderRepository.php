<?php

namespace App\Repositories;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Repositories\Api\BaseRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;

class SliderRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return Slider::class;
    }
}
