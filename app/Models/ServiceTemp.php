<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceTemp extends BaseModel
{
    use HasTranslations, SoftDeletes;


    protected $fillable=[ 'data','name','desc','image','service_id','vendor_id','updated_data','approval','note','conditions'];

    protected $dates = ['deleted_at'];

    //Approval Statuses
    const REFUSED='refused';
    const PENDING='pending';
    const ACCEPTED='accepted';

    public $translatable = ['name','desc','conditions'];

    public function setImageAttribute($image)
    {
        if (isset($image) && is_file($image)) {
            $image_name=uploadFile($image,'images/services/');
            $this->attributes['image']='images/services/'.$image_name;
        }
    }

    public function service()
    {
        return $this->belongsTo(Service::class,'service_id');
    }

    public function updated_data()
    {
        return Attribute::make(
            get: fn($value)=>json_decode($value)
        );
    }

    public function images_array()
    {
        $images_array=json_decode($this->data)->images_array;
        if( $images_array!= null)
        {
            $images_array=explode(',', $images_array[0]);
            return $images_array;
        }
        return [];
    }

    public function images()
    {
        return ServiceImage::whereIn('id',$this->images_array())->select('image')->pluck('image')->toArray();
    }
}
