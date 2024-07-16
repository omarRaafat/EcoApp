<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartProductServiceField extends Model
{
    use HasFactory;
    protected $fillable = ['cart_product_id','service_id','key','value','type','price'];
    public function cartProduct() : BelongsTo
    {
        return $this->belongsTo(CartProduct::class,'cart_product_id');
    }
    public function service() : BelongsTo
    {
        return $this->belongsTo(Service::class,'service_id');
    }
}
