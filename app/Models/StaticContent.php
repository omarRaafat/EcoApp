<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class StaticContent extends BaseModel
{
    use SoftDeletes,HasTranslations;
    protected $fillable=[ 'type', 'title', 'paragraph'];
    public $translatable=['title','paragraph'];

    public function scopeAboutUs($query) {
        return $query->where('type', 'about');
    }

    public function scopeUsageAndAgreement($query) {
        return $query->where('type', 'usage');
    }

    public function scopePrivacyPolicy($query) {
        return $query->where('type', 'policy');
    }
}
