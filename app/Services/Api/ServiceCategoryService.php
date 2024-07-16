<?php

namespace App\Services\Api;

use App\Enums\CategoryLevels;
use App\Http\Resources\Api\ServiceResource;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\Api\ServiceCategoryResource;
use App\Models\Category;
use App\Models\PostHarvestServicesDepartment;
use App\Repositories\Api\CategoryRepository;
use App\Repositories\Api\ServiceCategoryRepository;
use Illuminate\Database\Eloquent\Collection;

class ServiceCategoryService
{
    public function __construct(public ServiceCategoryRepository $repository) {}


    public function getParents()
    {
        return PostHarvestServicesDepartment::active()->orderBy('created_at','asc')->get();

    }

    public function getCategoryUsingID(int $id) : PostHarvestServicesDepartment | null
    {
        return $this->repository->getModelUsingID($id);
    }


    /**
     * Get Selected Category with Services.
     * @param Category $category
     * @return array
     */
    public function getCategoryServices(PostHarvestServicesDepartment $category,int $perPage = 10) : array
    {
        $page = (request()->page ?? 1) ;
        $offset = ($page - 1) * $perPage;

        $services = $category->services();

        $count = $services->count();
        $services = $services->available()->offset($offset)->take($perPage)->get();
        $next = ($page * $perPage) < $count;

        return  [
            'info' => new ServiceCategoryResource($category),
            'services' => ServiceResource::collection($services),
            'next' => $next

        ];
    }

    public function getHomePageCategory() : Collection
    {
        return $this->repository
            ->all()
            ->active()
            ->orderBy('created_at','asc')
            ->get();
    }
    public function site_map() : array
    {

        $cats_data  = [];
        $cats = $this->repository->all()->active()->get();
        foreach ($cats as $cat)
        {
            $cats_data[]=
                [
                    'name' => env('WEBSITE_BASE_URL').'/category/'. $cat->getTranslation("name", "ar"),
                    'link' => env('WEBSITE_BASE_URL').'/category/'. $cat->id .'/'.$cat->getTranslation("name", "ar")
                ];

        }

        return $cats_data;
    }
}
