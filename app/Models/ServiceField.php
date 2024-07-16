<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceField extends Model
{
    protected $fillable = [
        'service_id',
        'field_name',
        'field_value',
        'field_type',
        'field_price',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
