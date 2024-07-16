<?php

namespace App\Models;

use App\Models\Vendor;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorBeezConfig extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        "vendor_id",
        "beez_id"
    ];

    /**
     * Return vendor assossiated to this beez id.
     */
    public function vendor() : BelongsTo
    {
        return $this->belongsTo(Vendor::class, "vendor_id");
    }
}
