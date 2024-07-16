<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebHook extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'payload',
        'dataUpdated',
    ];

    protected $casts = [
        'dataUpdated' => 'json'
    ];

}
