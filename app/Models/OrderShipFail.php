<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderShipFail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id','orderVendorShipping_id','shipping','req','res','is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function scopeActive($query){
        $query->where('is_active',1);
    }

}
