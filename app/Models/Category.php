<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Category extends BaseModel implements HasMedia
{
    use HasTranslations,SoftDeletes,InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'level',
        'is_active',
        'order'
    ];

    /**
     * The attributes that needs to be translated.
     *
     * @var array
     */
    public $translatable = ['name','slug'];

    /**
     * Append Attributes to the orm collection.
     *
     * @var array
     */
    public $appends = [
        "image_url",
        "image_url_thumb"
    ];

    /**
     * Casts Datatypes.
     *
     * @var array
     */
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

    /**
     * Add spatie media library conversions.
     *
     * @param Media|null $media
     * @return void
     * @throws InvalidManipulation
     */
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

    /**
     * Get list of products assossiated to this category.
     * @hint: must be deleted
     * @return HasMany
     */
    public function products() : HasMany
    {
        return $this->HasMany(Product::class);
    }

    public function hasProducts()
    {
        return Product::where(
            fn($q) => $q->where('category_id', $this->id)
                ->orWhere('sub_category_id', $this->id)
                ->orWhere('final_category_id', $this->id)
        )
        ->exists();
    }

    /**
     * Return the parent category.
     *
     * @return BelongsTo
     */
    public function parent() : BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Get list of category childs.
     *
     * @return HasMany
     */
    public function child() : HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function categoryProduct() {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function subCategoryProduct() {
        return $this->hasMany(Product::class, 'sub_category_id');
    }

    public function finalCategoryProduct() {
        return $this->hasMany(Product::class, 'final_category_id');
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

    /**
     * return the category image full url.
     *
     * @return string
     */
    public function getImageUrlAttribute() : string
    {
        if(!empty($this->media->first())) {
            return $this->getFirstMediaUrl('categories', 'cover');
        }
        return url("images/noimage.png");
    }

    /**
     * return the category image thumb url.
     *
     * @return string
     */
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

    /**
     * Scope that make count query over sub-categories.
     *
     * @return integer
     */
    public function scopeSubCategoriesCount() : int
    {
        return $this->child()->count();
    }

    public function yesterdayBestSales() : HasOne {
        return $this->hasOne(ProductSales::class, "category_id", "id")->orderBy("daily_product_sales", "DESC");
    }
}
