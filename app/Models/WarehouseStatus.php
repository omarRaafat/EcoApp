<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id','status','note','data'
    ];

    protected $casts = [
        'data' => 'json'
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class , 'warehouse_id');
    }
}
