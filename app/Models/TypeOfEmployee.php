<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TypeOfEmployee extends Model
{
    use HasFactory;
    protected $fillable = ['name','level','user_id','vendor_id'];
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function vendor() : BelongsTo
    {
        return $this->belongsTo(Vendor::class,'vendor_id');
    }
}
