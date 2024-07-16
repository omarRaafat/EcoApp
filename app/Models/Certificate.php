<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;

class Certificate extends BaseModel
{
    use HasTranslations;
    protected $fillable=['title' , 'image'];
    public $translatable = ['title'];

    public function setImageAttribute($image)
    {
        if(isset($image) && is_file($image))
        {
            $image_name = uploadFile($image, 'images/certificates/');
            $this->attributes['image'] = 'images/certificates/' . $image_name;
        }
    }

    public function requests()
    {
        return $this->hasMany(CertificateVendor::class);
    }

}
