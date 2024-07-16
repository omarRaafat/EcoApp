<?php

namespace App\Models;

use App\Traits\DbOrderScope;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends BaseModel
{
    use HasTranslations, DbOrderScope, SoftDeletes;

    protected $fillable = [
        'name', 'permissions', 'vendor_id'
    ];

    // protected $casts = [
    //     'permissions' => 'array', // assuming permissions are stored as a JSON array in the database
    // ];

    public $translatable = ['name'];

    protected function permissions(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => (array)json_decode($value),
        );
    }

    public function vendor()
    {
        return $this->hasOne(Vendor::class, 'id', 'vendor_id');
    }

    public function scopeVendorId(Builder $query, mixed $vendorId) : Builder
    {
        return $query->where("vendor_id", $vendorId);
    }
}
