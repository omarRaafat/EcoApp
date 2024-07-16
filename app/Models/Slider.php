<?php

namespace App\Models;

use App\Traits\DbOrderScope;
use App\Traits\UploadImageTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Slider extends BaseModel implements HasMedia
{
    use SoftDeletes ,InteractsWithMedia ,HasTranslations ,UploadImageTrait ,DbOrderScope;

    public const mediaCollectionName = "sliders-media-images";
    private const coverCollectionName = "cover";
    private const thumbCollectionName = "thumb";

    protected $fillable = [
        'name', 'identifier', 'category', 'offer', 'url', 'image'
    ];

    protected $casts = [
        'name' => 'json',
        'category' => 'json',
        'offer' => 'json',
    ];

    public $translatable = ['name' ,'category' ,'offer'];

    public function setImageAttribute(UploadedFile $image)
    {
        if (isset($image) && is_file($image) && !is_string($image)) {
            $this->attributes['image'] = self::moveFileToPublic($image, "sliders");
        }else{
            $this->attributes['image']=$image;
        }
    }

   /* public function image() : Attribute {
        return Attribute::make(
            set: fn(UploadedFile $i) => self::moveFileToPublic($i, "")
        );
    }*/

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('cover')
            ->format(Manipulations::FORMAT_WEBP)
            ->width(1200)
            ->height(600)
            ->nonQueued();
        $this->addMediaConversion('thumb')
            ->format(Manipulations::FORMAT_WEBP)
            ->width(120)
            ->height(120)
            ->nonQueued();
    }

    public function coverImage() : Attribute {
        return Attribute::make(
            get: fn() => $this->media->first() ?
                $this->getFirstMediaUrl(self::mediaCollectionName, self::coverCollectionName) : url("images/noimage.png")
        );
    }

    public function thumbImage() : Attribute {
        return Attribute::make(
            get: fn() => $this->media->first() ?
                $this->getFirstMediaUrl(self::mediaCollectionName, self::thumbCollectionName) : url("images/noimage-tumb.png")
        );
    }
}
