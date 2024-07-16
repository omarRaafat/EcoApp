<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\InteractsWithMedia;

class PreharvestCategory extends BaseModel implements HasMedia
{
    use HasTranslations,SoftDeletes,InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'level',
        'is_active',
        'order'
    ];

    public $translatable = ['name','slug'];


    public $appends = [
        "image_url",
        "image_url_thumb"
    ];

    public $casts = [
        'is_active' => "boolean"
    ];

    protected $withCount = [
//        "categoryProduct",
//        "subCategoryProduct",
//        "finalCategoryProduct",
    ];

    protected $with = [
        "parent",
    ];

    protected static function boot() {
        parent::boot();

        static::deleting(function ($category) {
          $children =  $category->child();
          foreach( $children->get() as  $sub_children)
          {
            $sub_children->child()->delete();
          }
          $children->delete();
        });
      }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('cover')
            // ->format(Manipulations::FORMAT_WEBP)
            ->nonQueued();


        $this->addMediaConversion('thumb')
            // ->format(Manipulations::FORMAT_WEBP)
            ->width(160)
            ->height(100)
            ->nonQueued();
    }

    public function parent() : BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function child() : HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function parentCategoryNameAr() : Attribute
    {
        return Attribute::make(
            get: fn() => $this->parent ? $this->parent->getTranslation('name', 'ar') : ""
        );
    }

    public function parentCategoryNameEn() : Attribute
    {
        return Attribute::make(
            get: fn() => $this->parent ? $this->parent->getTranslation('name', 'en') : ""
        );
    }

    public function getImageUrlAttribute() : string
    {
        if(!empty($this->media->first())) {
            return $this->getFirstMediaUrl('categories', 'cover');
        }
        return url("images/noimage.png");
    }

    public function getImageUrlThumbAttribute() : string
    {
        if(!empty($this->media->first())) {
            return $this->getFirstMediaUrl('categories', 'thumb');
        }
        return url("images/noimage-tumb.png");
    }

    public function getUniqueIdentifier() {
        return "$this->id-$this->slug_en";
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSubCategoriesCount() : int
    {
        return $this->child()->count();
    }
}
