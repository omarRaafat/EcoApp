<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageUplodeRequest;
use App\Services\Images\ServiceImageService;
use App\Repositories\Vendor\ServiceRepository;
use App\Models\ServiceImage;
use App\Models\Service;

class ServiceImageController extends Controller
{
    private $serviceRepository;
    private $serviceImageService;

    public function __construct( ServiceRepository $serviceRepository,ServiceImageService $serviceImageService ) {
        $this->serviceRepository = $serviceRepository;
        $this->serviceImageService = $serviceImageService;
    }

    public function upload_service_images(ImageUplodeRequest $request) {
        $serviceImage = new ServiceImage;
        $serviceImage->image = "";
        if(auth()->user()->type == 'vendor'){
            $serviceImage->is_accept = 0;
        }
        $serviceImage->save();

        $this->serviceImageService->handleServiceImages($serviceImage);
        return $serviceImage->id;
    }

    public function remove_service_images($id){
        $ServiceImage = ServiceImage::find($id);
        $service= Service::when(auth()->user()->type != 'admin',function($qr){
            $qr->where('user_id',auth()->user()->id);
        })->findOrFail($ServiceImage->service_id);

        $ServiceImage->clearMediaCollection(ServiceImage::mediaCollectionName);
        $ServiceImage->delete();

        return redirect()->back();
    }
}
