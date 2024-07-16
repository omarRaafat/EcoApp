<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseSplInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id','branch_id'
    ];
}
