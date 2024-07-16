<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class ShippingType extends Model
{
    use HasFactory , HasTranslations;

    protected $table = 'shipping_types';

    /**
     * The attributes that needs to be translated.
     *
     * @var array
     */
    public $translatable = ['title'];

    protected $fillable = ['title'];

    /**
     * @return BelongsToMany
     */
    public function warehouses(): BelongsToMany
    {
        return $this->belongsToMany(Warehouse::class , 'warehouse_shipping_types' , 'shipping_type_id' , 'warehouse_id');
    }

}
