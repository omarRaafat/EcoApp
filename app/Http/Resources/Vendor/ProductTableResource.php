<?php

namespace App\Http\Resources\Vendor;

use Illuminate\Http\Resources\Json\JsonResource;
use \Carbon\Carbon;

class ProductTableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        $category=($this->category) ? $this->category->name:'-';
        $data=[];
        // {
        //     "id": 1,
        //     "product": {
        //         "img": "assets/images/products/img-1.png",
        //         "title": "Half Sleeve Round Neck T-Shirts",
        //         "category": "Fashion"
        //     },
        //     "stock": "12",
        //     "price": "215.00",
        //     "orders": "48",
        //     "rating": "4.2",
        //     "published": {
        //         "publishDate": "12 Oct, 2021",
        //         "publishTime": "10:05 AM",
        //     }
        // },
        $data['id']=$this->id;
        $data['product']=[
            'image'=>$this->square_image,
            'name'=>$this->name,
            'category'=>__('translation.category').' : '.$category
        ];
        $data['stock']=rand(10,1000);
        $data['price']=$this->price/100;
        $data['orders']=rand(10,1000);
        $data['rating']=$this->rate();
        $data['published_date']=Carbon::parse($this->created_at)->toFormattedDateString();
        $data['action']=$this->id;
        return $data;
    }
}
