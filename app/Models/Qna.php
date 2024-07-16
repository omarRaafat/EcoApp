<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class Qna extends BaseModel
{
    use  HasTranslations ,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "question",
        "answer"
    ];

    /**
     * Fields that need to be translatable.
     *
     * @var array
     */
    public $translatable = [
        "question",
        "answer"
    ];
}
