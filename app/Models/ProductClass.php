<?php

namespace App\Models;

use App\Models\Product;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductClass extends BaseModel
{
    use  HasTranslations ,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name"
    ];

    /**
     * The attributes that needs to be translated.
     *
     * @var array
     */
    public $translatable = ['name'];

    /**
     * Get List Of Prodcuts Assossiated To This Class.
     *
     * @return HasMany
     */
    public function products() : HasMany
    {
        return $this->hasMany(Product::class);
    }

    public static function getProductClasses() : array {
        return self::get()
            ->map(function ($productClass) {
                return [
                    'id' => $productClass->id,
                    'name' => $productClass->getTranslation('name', app()->getLocale() ?? 'ar')
                ];
            })
            ->pluck('name', 'id')
            ->toArray();
    }
}
