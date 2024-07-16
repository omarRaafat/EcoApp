<?php

namespace App\Models;

use App\Traits\UploadImageTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Image\Manipulations;

class ProductImage extends BaseModel implements HasMedia
{
    use InteractsWithMedia, UploadImageTrait;
    
    const mediaCollectionName = "ProductImages";

    protected $fillable=['image','product_id','is_accept'];

    protected $casts = [
        'is_accept'=> 'boolean',
    ];

   
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('small')->format(Manipulations::FORMAT_WEBP)->fit(Manipulations::FIT_MAX, 250, 250)->crop('crop-center',250,250);
        $this->addMediaConversion('medium')->format(Manipulations::FORMAT_WEBP)->fit(Manipulations::FIT_MAX, 640, 640)->crop('crop-center',640,640);
        $this->addMediaConversion('large')->format(Manipulations::FORMAT_WEBP)->fit(Manipulations::FIT_MAX, 800, 800)->crop('crop-center',800,800);
    }

    public function squareImage() : Attribute {

        return Attribute::make(
            get: fn($value) =>
                $this?->media?->first() ?
                    $this->getFirstMediaUrl(self::mediaCollectionName, 'medium')
                    :
                    ($this->image ? ossStorageUrl($this->image) : url("images/noimage-tumb.png"))
        );
    }

    public function isImageNotConvertable() : Attribute {
        return Attribute::make(
            get: fn($value) =>
                Str::contains($this->image, "png", true) ||  //if not background transpaent w - then registerMdia Conversions "Fitt Fill Max" 
                Str::contains($this->image, "gif", true) ||
                Str::contains($this->image, "webp", true)
        );
    }
}
