<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCity extends BaseModel
{
    protected $guarded = [];

    public function service()
    {
        return $this->belongsTo(Service::class , 'service_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class , 'city_id');
    }
}
