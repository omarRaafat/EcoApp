<?php

namespace App\Models;

class VendorWarnings extends BaseModel
{
    protected $fillable     = ['vendor_id','body'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class,'vendor_id');
    }
}
