<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatisitcsCount extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "vendor_id",
        "orders",
        "sales",
        "profits"
    ];

//    public function sales() : Attribute {
//        return Attribute::make(
//            get: fn($value) => $value > 0 ? $value / 100 : 0
//        );
//    }

//    public function profits() : Attribute {
//        return Attribute::make(
//            get: fn($value) => $value > 0 ? $value / 100 : 0
//        );
//    }
}
