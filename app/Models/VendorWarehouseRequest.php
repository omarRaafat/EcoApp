<?php

namespace App\Models;

use App\Models\User;
use App\Models\Vendor;
use App\Models\WarehouseIntegration;
use App\Models\VendorWarehouseRequestProduct;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorWarehouseRequest extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        "vendor_id",
        "status",
        "created_by",
        "created_by_id",
        "start_time",
        "end_time"
    ];

    /**
     * Columns Need To Be Casts.
     *
     * @var array
     */
    public $casts = [
        "start_time" => "date",
        "end_time" => "date",
    ];

    /**
     * Eger Load Relationships.
     *
     * @var array
     */
    public $with = [
        "vendor",
        "createdBy"
    ];

    /**
     * Return vendor assossiated to this request.
     * 
     * @return BelongsTo
     */
    public function vendor() : BelongsTo
    {
        return $this->belongsTo(Vendor::class, "vendor_id", "id");
    }

    /**
     * Return the user that make this request.
     * 
     * @return BelongsTo
     */
    public function createdBy() : BelongsTo
    {
        return $this->belongsTo(User::class, "created_by_id", "id");
    }

    /**
     * Get list of request items.
     *
     * @return HasMany
     */
    public function requestItems() : HasMany
    {
        return $this->hasMany(VendorWarehouseRequestProduct::class,'warehouse_request_id');
    }

    /**
     * The integration warehouse request.
     */
    public function warehouseIntegration() : HasOne
    {
        return $this->hasOne(WarehouseIntegration::class);
    }
}
