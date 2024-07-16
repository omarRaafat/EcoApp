<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BestSellingProduct extends Model
{
    use HasFactory;

    public $with = ["product"];
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, "product_id");
    }
}
