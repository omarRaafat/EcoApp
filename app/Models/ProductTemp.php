<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductTemp extends BaseModel
{
    use HasTranslations, SoftDeletes;


    protected $fillable=[ 'data','name','desc','image','product_id','vendor_id','updated_data','category_id','quantity_type_id','product_class_id','sub_category_id','final_category_id','type_id','approval','note' ];

    protected $dates = ['deleted_at'];

    //Approval Statuses
    const REFUSED='refused';
    const PENDING='pending';
    const ACCEPTED='accepted';

    public $translatable = ['name','desc'];

    public function setImageAttribute($image)
    {
        if (isset($image) && is_file($image)) {
            $image_name=uploadFile($image,'images/products/');
            $this->attributes['image']='images/products/'.$image_name;
        }
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
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
        return ProductImage::whereIn('id',$this->images_array())->select('image')->pluck('image')->toArray();
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(Category::class,'sub_category_id');
    }

    public function finalSubCategory()
    {
        return $this->belongsTo(Category::class,'final_category_id');
    }

    public function quantity_type()
    {
        return $this->belongsTo(ProductQuantity::class,'quantity_type_id');
    }

    public function type()
    {
        return $this->belongsTo(ProductClass::class,'type_id');
    }
}
