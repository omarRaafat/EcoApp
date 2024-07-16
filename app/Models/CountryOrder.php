<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryOrder extends Model
{
    use HasFactory;

    public $with = ["country"];
    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo(Country::class, "country_id");
    }
}
