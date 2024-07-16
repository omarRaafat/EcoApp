<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostHarvestServicesDepartment extends Model
{
    use HasFactory;
    protected $fillable = ['name','image','status'];
    const ACTIVE = 'active';
    const NOT_ACTIVE = 'not_active';

    protected $withCount = [
        "services",
    ];

    public function post_harvest_services_department_fields() : HasMany
    {
        return $this->hasMany(PostHarvestServicesDepartmentField::class,'post_harvest_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function services() : HasMany
    {
        return $this->hasMany(Service::class,'category_id');
    }
}
