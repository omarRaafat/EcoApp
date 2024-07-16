<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class PalmLength extends BaseModel
{
    use SoftDeletes;

    protected $fillable = ['from','to','is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
