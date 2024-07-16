<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuestCustomer extends BaseModel
{
    use SoftDeletes;

    protected $fillable = ['token'];

    protected $dates = ['deleted_at'];
    // public function guestCart() {
    //     return $this->hasOne(GuestCart::class, 'guest_id');
    // }

    public function guestCart() {
        return $this->hasOne(Cart::class, 'guest_customer_id');
    }

    public function token() : Attribute {
        return Attribute::make(
            set: fn($t) => Str::uuid() ."-$t-". Str::uuid() ."-$t"
        );
    }

    public function scopeFetchToken(Builder $query, string $token) : Builder {
        return $query->where("token", $token);
    }
}
