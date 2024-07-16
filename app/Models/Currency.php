<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;

class Currency extends BaseModel
{
    use HasTranslations;
    protected $fillable=['name','code'];
    public $translatable=['name'];
}
