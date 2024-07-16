<?php

namespace App\Models;

use App\Models\VendorBeezConfig;
use App\Models\VendorWarehouseRequest;
use App\Enums\WarehouseIntegration as Integration;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WarehouseIntegration extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "vendor_warehouse_request_id",
        "vendor_id",
        "integration_name",
    ];

    /**
     * Get the warehouse request assossiated to this integration record [beez].
     */
    public function beez() : BelongsTo
    {
        return $this->belongsTo(VendorWarehouseRequest::class, "vendor_warehouse_request_id", "id")
                    ->where("integration_name", Integration::BEZZ);
    }

    /**
     * Get vendor beez config to get the vendor.
     */
    public function beezConfig() : HasOne
    {
        return $this->hasOne(VendorBeezConfig::class);
    }
}
