<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id','note'
    ];
}
