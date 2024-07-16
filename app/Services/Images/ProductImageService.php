<?php
namespace App\Services\Images;

use App\Models\Product;
use App\Models\ProductImage;

class ProductImageService {

    /**
     * Undocumented function
     *
     * @param Product $product
     * @return void
     */
    public function handleImages(Product $product, $isStore = false)
    {
        if (request()->hasFile('image')) {
            try {
                $product->clearMediaCollection(auth()->user()->type == "vendor" ? Product::mediaTempCollectionName : Product::mediaCollectionName);
            } catch (\Throwable $th) {
               report($th);
            }
            try {
                $product->addMediaFromRequest('image')->toMediaCollection(auth()->user()->type == "vendor" ? Product::mediaTempCollectionName : Product::mediaCollectionName);   
            } catch (\Throwable $th) {
                report($th);
            }
        }
        if (request()->hasFile('clearance_cert')){
            $totemp= (auth()->user()->type == "vendor" && !$isStore);
            try {
                $product->clearMediaCollection($totemp ? Product::clearanceCertTempCollectionName : Product::clearanceCertCollectionName);
            } catch (\Throwable $th) {
               report($th);
            }
            try {
                $product->addMediaFromRequest('clearance_cert')->toMediaCollection($totemp ? Product::clearanceCertTempCollectionName : Product::clearanceCertCollectionName);   
            } catch (\Throwable $th) {
                report($th);
            }
        }

       /* $product->images->each(
            fn($productImage) => $this->handleProductImages($productImage)
        );
        $this->handleProductImage($product);
        */
    }

    /**
     * Undocumented function
     *
     * @param Product $product
     * @return void
     */
    private function handleProductImage(Product $product) {
        //$product->clearMediaCollection(Product::mediaCollectionName);
        // if ($product->is_image_not_convertable) return;
       /* $product
            ->addMediaFromDisk($product->image, 'root-public')
            ->preservingOriginal()
            ->toMediaCollection(Product::mediaCollectionName);*/
    }

    /**
     * Undocumented function
     *
     * @param ProductImage $productImage
     * @return void
     */
    public function handleProductImages(ProductImage $productImage) {
        if (request()->hasFile('file')) {
            try {
                $productImage->clearMediaCollection(ProductImage::mediaCollectionName);
            } catch (\Throwable $th) {
               report($th);
            }
            try {
                $productImage->addMediaFromRequest('file')->toMediaCollection(ProductImage::mediaCollectionName);   
            } catch (\Throwable $th) {
                report($th);
            }
       }

       /* $productImage->media()?->delete();
        // if ($productImage->is_image_not_convertable) return;
       try {
            $productImage
            ->addMediaFromDisk($productImage->image, 'root-public')
            ->preservingOriginal()
            ->toMediaCollection(ProductImage::mediaCollectionName);
       } catch (\Throwable $th) {
        //throw $th;
       }*/
    }
}
