<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class WarehouseCountry extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        "warehouse_id", "country_id"
    ];

    public function warehouse() {
        return $this->belongsTo(Warehouse::class, "warehouse_id");
    }

    public function country() {
        return $this->belongsTo(Country::class, "country_id");
    }
}
