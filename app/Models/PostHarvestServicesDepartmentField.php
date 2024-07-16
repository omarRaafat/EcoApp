<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostHarvestServicesDepartmentField extends Model
{
    use HasFactory;
    const ACTIVE = 'active';
    const NOT_ACTIVE = 'not_active';
    protected $fillable = ['name','type','status','is_required','depends_on_price','post_harvest_id','values'];

    protected $appends = ['depends_on_price_text','required'];

    public function postHarvestServicesDepartments() : BelongsTo
    {
        return $this->belongsTo(PostHarvestServicesDepartment::class,'post_harvest_id');
    }
    // Accessor for depends_on_price
    public function getDependsOnPriceAttribute($depends_on_price)
    {
        return $depends_on_price == 1 ? trans('postHarvestServices.interior_construction_fields.yes') : trans('postHarvestServices.interior_construction_fields.no');
    }
    public function getIsRequiredAttribute($is_required)
    {
        return $is_required == 1 ? trans('postHarvestServices.interior_construction_fields.yes') : trans('postHarvestServices.interior_construction_fields.no');
    }
    public function values() :Attribute
    {
        return Attribute::make(get:fn($values) => json_decode($values,true),
        set:fn($values) => json_encode($values));
    }

    public function getDependsOnPriceTextAttribute()
    {
        return $this->attributes['depends_on_price'];
    }

    public function getRequiredAttribute()
    {
        return $this->attributes['is_required'];
    }

}
