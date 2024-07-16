<?php

namespace App\Services\Api;

use App\Enums\CategoryLevels;
use App\Http\Resources\Api\ProductResource;
use App\Http\Resources\Api\CategoryResource;
use App\Models\Category;
use App\Repositories\Api\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    /**
     * Category Service Constructor.
     *
     * @param CategoryRepository $repository
     */
    public function __construct(public CategoryRepository $repository) {}


    public function getParents() 
    {
        return Category::active()->whereNull('parent_id')->orderBy('order','asc')->get();

    }

    /**
     * Get Category using ID.
     *
     * @param integer $id
     * @return Category
     */
    public function getCategoryUsingID(int $id) : Category|null
    {
        return $this->repository->getModelUsingID($id);
    }

    /**
     * Get Category Family Tree Parent Categories.
     * @param Category $category
     */
    public function getCategoryTreeAll(Category $category)
    {
        switch($category->level) {
            case CategoryLevels::PARENT:
                return $this->getParentsSubChildCategories($category->id);
            case CategoryLevels::CHILD:
                return $this->getParentsSubChildCategories($category->parent_id);
            case CategoryLevels::SUBCHILD:
                return $this->getParentsSubChildCategories($category->parent->parent_id);
        }

        return collect([]);
    }

    /**
     * Get Main Parent Categories.
     * @return Collection
     */
    public function getParentsSubChildCategories(int $id) : ?Category
    {
        return Category::where('id', $id)
            ->active()
            ->whereNull('parent_id')
            ->with([
                'child' => function($childQuery) {
                    $childQuery->whereHas('subCategoryProduct', fn($q) => $q->available())
                    ->with([
                        'child' => function($leafChildQuery) {
                            $leafChildQuery->whereHas('finalCategoryProduct', fn($q) => $q->available());
                        }
                    ]);
                }
            ])
            ->first();
    }

    /**
     * Get Selected Category with Products.
     * @param Category $category
     * @return array
     */
    public function getCategoryProducts(Category $category,int $perPage = 10) : array
    {
        $page = (request()->page ?? 1) ;
        $offset = ($page - 1) * $perPage;

        switch($category->level) {
            case CategoryLevels::PARENT:
                $products = $category->categoryProduct();
                break;
            case CategoryLevels::CHILD:
                $products = $category->subCategoryProduct();
                break;
            case CategoryLevels::SUBCHILD:
                $products = $category->finalCategoryProduct();
                break;
            default:
                return [];
        }

        $count = $products->count();
        $products = $products->available()->offset($offset)->take($perPage)->get();
        $next = ($page * $perPage) < $count;

        return  [
            'info' => new CategoryResource($category),
            'products' => ProductResource::collection($products),
            'next' => $next

        ];
    }

    public function getHomePageCategory() : Collection
    {
        return $this->repository
            ->all()
            ->without('parent')
            ->where('parent_id', null)
            ->active()
            ->whereHas('categoryProduct', function ($q) {
                $q->whereHas('vendor' , function ($_q){
                    $_q->whereHas('warehouses' , function($query){
                        $query->whereHas('shippingTypes');
                    });
                });
                return $q->available();
            })
            ->orderBy('order','asc')
            ->with("yesterdayBestSales")
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
