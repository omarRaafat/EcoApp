<?php

namespace App\Models;

use App\Models\Product;
use App\Models\VendorWarehouseRequest;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorWarehouseRequestProduct extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        "warehouse_request_id",
        "product_id",
        "qnt",
        "mnfg_date",
        "expire_date"
    ];

    /**
     * Columns Need To Be Casts.
     *
     * @var array
     */
    public $casts = [
        "mnfg_date" => "date",
        "expire_date" => "date",
    ];

    /**
     * Eger Load Relationships.
     *
     * @var array
     */
    public $with = [
        "request",
        "product"
    ];

    /**
     * Return the Vendor Warehouse Request assossiated to this itme.
     * 
     * @return BelongsTo
     */
    public function request() : BelongsTo
    {
        return $this->belongsTo(VendorWarehouseRequest::class, "warehouse_request_id", "id");
    }

    /**
     * Return the product that make this request.
     * 
     * @return BelongsTo
     */
    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class, "product_id", "id");
    }
}
