<?php
namespace App\Services\Images;

use App\Models\Service;
use App\Models\ServiceImage;

class ServiceImageService {

    /**
     * Undocumented function
     *
     * @param Service $service
     * @return void
     */
    public function handleImages(Service $service, $isStore = false)
    {
        if (request()->hasFile('image')) {
            try {
                $service->clearMediaCollection(auth()->user()->type == "vendor" ? Service::mediaTempCollectionName : Service::mediaCollectionName);
            } catch (\Throwable $th) {
               report($th);
            }
            try {
                $service->addMediaFromRequest('image')->toMediaCollection(auth()->user()->type == "vendor" ? Service::mediaTempCollectionName : Service::mediaCollectionName);
            } catch (\Throwable $th) {
                report($th);
            }
        }
        if (request()->hasFile('clearance_cert')){
            $totemp= (auth()->user()->type == "vendor" && !$isStore);
            try {
                $service->clearMediaCollection($totemp ? Service::clearanceCertTempCollectionName : Service::clearanceCertCollectionName);
            } catch (\Throwable $th) {
               report($th);
            }
            try {
                $service->addMediaFromRequest('clearance_cert')->toMediaCollection($totemp ? Service::clearanceCertTempCollectionName : Service::clearanceCertCollectionName);
            } catch (\Throwable $th) {
                report($th);
            }
        }

       /* $service->images->each(
            fn($serviceImage) => $this->handleServiceImages($serviceImage)
        );
        $this->handleServiceImage($service);
        */
    }

    /**
     * Undocumented function
     *
     * @param Service $service
     * @return void
     */
    private function handleServiceImage(Service $service) {
        //$service->clearMediaCollection(Service::mediaCollectionName);
        // if ($service->is_image_not_convertable) return;
       /* $service
            ->addMediaFromDisk($service->image, 'root-public')
            ->preservingOriginal()
            ->toMediaCollection(Service::mediaCollectionName);*/
    }

    /**
     * Undocumented function
     *
     * @param ServiceImage $serviceImage
     * @return void
     */
    public function handleServiceImages(ServiceImage $serviceImage) {
        if (request()->hasFile('file')) {
            try {
                $serviceImage->clearMediaCollection(ServiceImage::mediaCollectionName);
            } catch (\Throwable $th) {
               report($th);
            }
            try {
                $serviceImage->addMediaFromRequest('file')->toMediaCollection(ServiceImage::mediaCollectionName);
            } catch (\Throwable $th) {
                report($th);
            }
       }

       /* $serviceImage->media()?->delete();
        // if ($serviceImage->is_image_not_convertable) return;
       try {
            $serviceImage
            ->addMediaFromDisk($serviceImage->image, 'root-public')
            ->preservingOriginal()
            ->toMediaCollection(ServiceImage::mediaCollectionName);
       } catch (\Throwable $th) {
        //throw $th;
       }*/
    }
}
