<?php
namespace App\Models;

use App\Traits\DbOrderScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class PageSeo extends BaseModel
{
    use HasTranslations, DbOrderScope;

    protected $fillable = [
        'page', 'tags', 'description', 'created_by', 'edited_by'
    ];

    public $translatable = [
        'tags', 'description'
    ];

    public function createdBy() : BelongsTo {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editedBy() : BelongsTo {
        return $this->belongsTo(User::class, 'edited_by');
    }
}
