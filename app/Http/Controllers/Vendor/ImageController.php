<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageUplodeRequest;
use App\Services\Images\ProductImageService;
use App\Repositories\Vendor\ProductRepository;
use App\Models\ProductImage;
use App\Models\Product;

class ImageController extends Controller
{
    private $productRepository;
    private $productImageService;

    public function __construct( ProductRepository $productRepository,ProductImageService $productImageService ) {
        $this->productRepository = $productRepository;
        $this->productImageService = $productImageService;
    }

    public function upload_product_images(ImageUplodeRequest $request) {
        $productImage = new ProductImage;
        $productImage->image = "";
        if(auth()->user()->type == 'vendor'){
            $productImage->is_accept = 0;
        }
        $productImage->save();

        $this->productImageService->handleProductImages($productImage);
        return $productImage->id;
    }

    public function remove_product_images($id){
        $ProductImage = ProductImage::find($id);
        $product= Product::when(auth()->user()->type != 'admin',function($qr){
            $qr->where('user_id',auth()->user()->id);
        })->findOrFail($ProductImage->product_id);
        
        $ProductImage->clearMediaCollection(ProductImage::mediaCollectionName);
        $ProductImage->delete();

        return redirect()->back(); 
    }
}
