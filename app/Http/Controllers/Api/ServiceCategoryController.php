<?php
namespace App\Http\Controllers\Api;

use App\Enums\CategoryLevels;
use App\Http\Resources\Api\CategoryResources\CategoryHomeResource;
use Illuminate\Http\JsonResponse;
use App\Services\Api\CategoryService;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Api\ServiceCategoryHomeResource;
use App\Http\Resources\Api\CategoryWithProductsResource;
use App\Services\Api\ServiceCategoryService;

class ServiceCategoryController extends ApiController
{
    public function __construct(public ServiceCategoryService $service) {}

    public function index()
    {
        $categories = $this->service->getParents();
        return $this->setApiResponse(true, 200,$categories, __("api.categories-return-success"));
    }

    public function show($category_id) : JsonResponse
    {
        $category = $this->service->getCategoryUsingID(intval($category_id));
        if(!$category){
            return $this->setApiResponse(true,200,[], __("api.categories-return-success"));
        }
        return $this->setApiResponse(true, 200, new CategoryResource($category), __('api.category-return-success'));
    }

    public function getCategoryServicesAll($category_id): JsonResponse
    {
        $category = $this->service->getCategoryUsingID(intval($category_id));
        if(!$category){
            return $this->setApiResponse(true,200,[], __("api.categories-return-success"));
        }
        $services = $this->service->getCategoryServices($category);
        return $this->setApiResponse
        (
            true,
            200,
            $services,
            __("api.categories-return-success")
        );
    }

    public function homePageCategory() : JsonResponse
    {
        $categories = $this->service->getHomePageCategory();
        return $this->setApiResponse(true, 200, ServiceCategoryHomeResource::collection($categories),
            __('api.categories-return-success'));
    }
    public function site_map()
    {

        $vendorsData = $this->service->site_map();
        return $this->setApiResponse(true, 200, $vendorsData, trans("products.api.vendors_retrived"));

    }

}
