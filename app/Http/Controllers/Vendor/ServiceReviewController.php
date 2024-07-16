<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\UserVendorRate;
use Illuminate\Http\Request;
use App\DataTables\ServiceReviewDataTable;
use App\Repositories\Vendor\ServiceRepository;

class ServiceReviewController extends Controller
{
    protected $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }
    public function index(Request $request,ServiceReviewDataTable $serviceReviewDataTable)
    {
        $review = UserVendorRate::first();
        $services = $this->serviceRepository->getAll();
        return $serviceReviewDataTable->render('vendor.services.service_reviews.index',compact('request','services'));
    }
}
