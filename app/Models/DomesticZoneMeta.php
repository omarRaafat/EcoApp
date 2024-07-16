<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DomesticZoneMeta extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        "domestic_zone_id", "related_model", "related_model_id",
    ];

    public function domesticZone() : BelongsTo {
        return $this->belongsTo(DomesticZone::class, "domestic_zone_id");
    }

    public function city() : BelongsTo|null {
        if ($this->related_model != City::class) return null;
        return $this->belongsTo(City::class, 'related_model_id');
    }

    public function country() : BelongsTo {
        return $this->belongsTo(Country::class, 'related_model_id');
    }

    public function relatedModel() : BelongsTo {
        return $this->belongsTo($this->related_model == Country::class ? Country::class : City::class, 'related_model_id');
    }
}
