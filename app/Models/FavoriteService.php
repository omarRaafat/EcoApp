<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteService extends Model
{
    use HasFactory;

    protected $table = "favorite_services";

    public function service()
    {
        return $this->belongsTo(Service::class , 'service_id');
    }
}
