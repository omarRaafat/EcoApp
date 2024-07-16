<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class Recipe extends BaseModel implements HasMedia
{
    use SoftDeletes,HasTranslations,InteractsWithMedia;
    protected $fillable=['title', 'body', 'short_desc','most_visited'];
    public $translatable=['title' , 'body','short_desc'];

    public $casts = [
        'most_visited' => "boolean",
    ];
    public $appends = [
        "image_url",
        'image_url_cover',
        "image_url_thumb"
    ];


    public function registerMediaConversions(Media $media = null): void
    {
        
        $this->addMediaConversion('cover')
            ->format(Manipulations::FORMAT_WEBP)
            ->fit(Manipulations::FIT_CROP, 1200, 600)

            ->width(1200)
            ->height(600)
            ->nonQueued();
            
        $this->addMediaConversion('thumb')
            ->format(Manipulations::FORMAT_WEBP)
            ->fit(Manipulations::FIT_CROP, 600, 600)
            ->width(600)
            ->height(600)
            ->nonQueued();
    }

    /**
     * return the category image full url.
     *
     * @return string
     */
    public function getImageUrlAttribute() : string
    {
        if(!empty($this->media->first())) {
            return $this->getFirstMediaUrl('recipes', 'cover');
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
            return $this->getFirstMediaUrl('recipes', 'thumb');
        }
        return url("images/noimage-tumb.png");
    }
    public function getImageUrlCoverAttribute() : string
    {
        if(!empty($this->media->first())) {
            return $this->getFirstMediaUrl('recipes', 'cover');
        }
        return url("images/noimage-tumb.png");
    }
}
