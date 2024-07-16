<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;

class ProductQuantity extends BaseModel
{
    use HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        "name",
        "is_active"
    ];

    /**
     * Columns need to be translated.
     * @var array
     */
    public $translatable = ['name'];

    public function scopeActive($query) {
        return $query->where('is_active', 1);
    }

    public static function getProductQuantityTypes() : array {
        return self::active()->get()->map(function ($productQuantityType) {
            return [
                'id' => $productQuantityType->id,
                'name' => $productQuantityType->getTranslation('name', app()->getLocale() ?? 'ar')
            ];
        })
        ->pluck('name', 'id')
        ->toArray();
    }

    public function products() {
        return $this->hasMany(Product::class, 'quantity_type_id');
    }
}