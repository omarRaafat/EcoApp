<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CertificateVendor extends Pivot
{
    use HasFactory;
    protected $fillable=[ 'vendor_id' , 'certificate_id', 'certificate_file', 'approval','expire_date'];

    public function certificate()
    {
        return $this->belongsTo(Certificate::class,'certificate_id');
    }

    public function setCertificateFileAttribute($certificate_file)
    {
        if (isset($certificate_file) && is_file($certificate_file)) {
            $certificate_file_name=uploadFile($certificate_file,'certificate_files/');
            $this->attributes['certificate_file']='certificate_files/'.$certificate_file_name;
        }
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
