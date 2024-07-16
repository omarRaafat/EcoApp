<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuantityType extends BaseModel
{
    use HasTranslations,SoftDeletes;
    protected $fillable=['name'];
    public $translatable = ['name'];
}