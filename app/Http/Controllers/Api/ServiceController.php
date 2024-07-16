<?php
namespace App\Http\Controllers\Api;

use App\Models\Service;
use Illuminate\Http\JsonResponse;
use App\Services\Api\ServiceService;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\AddServiceReviewRequest;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\Api\ServiceCategoryResource;
use App\Http\Resources\Api\ServiceResource;
use App\Http\Resources\Api\SingleServiceResource;

use App\Repositories\Admin\ServiceClassRepository;
use App\Services\Api\CategoryService;
use App\Services\Api\ServiceCategoryService;
use Illuminate\Http\Request;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ServiceController extends ApiController
{
    /**
     * Service Controller Constructor.
     *
     * @param ServiceService $service
     */
    public function __construct(
        public ServiceService $service,
        public ServiceCategoryService $categoryService) {
    }

    /**
     * List all services.
     *
     * @return JsonResponse
     */
    public function index() : ResourceCollection
    {

        $servicesData = $this->service->getAllServicesInfinityLoad();

        return ServiceResource::collection($servicesData['services'])->additional([
            "success" => true,
            "status"  => 200,
            'next'    => $servicesData['next'],
            "message" => trans("services.api.services_retrieved")
        ]);
    }
    /**
     * List all services.
     *
     * @return JsonResponse
     */
    public function site_map()
    {
        $servicesData = $this->service->site_map();
        return $this->setApiResponse(true, 200, $servicesData['services'], trans("services.api.service_retrieved"));
    }

    /**
     * Get Service using id.
     *
     * @param id $service_id
     * @return Response
     */
    public function show($service_id) : JsonResponse
    {
        $service = $this->service->getServiceUsingID(intval($service_id));
        if($service == null){
            return $this->setApiResponse(true, 200, [], trans("services.api.service_not_found"));
        }
        return $this->setApiResponse(true, 200, new SingleServiceResource($service), trans("services.api.service_retrieved"));
    }    /**
     * Get Service using id.
     *
     * @param id $service_id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
 */
    public function service_related($service_id) : \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $service = $this->service->getServiceUsingID(intval($service_id));
        if(!$service){
            return ServiceResource::collection([])->additional(["success" => true,"status"  => 200,"message" => trans("services.api.services_retrieved")]);
        }
        $services_related = $this->service->service_related($service);

        return ServiceResource::collection($services_related)->additional([
            "success" => true,
            "status"  => 200,
            "message" => trans("services.api.services_retrieved")
        ]);
    }

    public function CategoryServices(int $category_id)
    {
        $services = $this->service->getServicesUsingCategoryID($category_id,20);

        $category = $this->categoryService->getCategoryUsingID($category_id);

        $services->withPath("services");
        return ServiceResource::collection($services)->additional([
            "success" => true,
            "status" => 200,
            'category' => new ServiceCategoryResource($category),
            "message"=> trans("api.services-return-success")
        ]);
    }

    public function serviceAddReview(AddServiceReviewRequest $request)
    {
        $response = $this->service->addServiceReview($request->validated());
        return $this->setApiResponse
        (
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }
}
