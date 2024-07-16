<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use App\Services\Api\ProductService;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\AddProductReviewRequest;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\Api\ProductResource;
use App\Http\Resources\Api\SingleProductResource;

use App\Repositories\Admin\ProductClassRepository;
use App\Services\Api\CategoryService;
use Illuminate\Http\Request;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductController extends ApiController
{
    /**
     * Product Controller Constructor.
     *
     * @param ProductService $service
     */
    public function __construct(
        public ProductService $service,
         public CategoryService $categoryService,
         public ProductClassRepository $classesRepo) {
    }

    /**
     * List all products.
     *
     * @return JsonResponse
     */
    public function index() : ResourceCollection
    {

        $productsData = $this->service->getAllProductsInfinityLoad();

        return ProductResource::collection($productsData['products'])->additional([
            "success" => true,
            "status"  => 200,
            'next'    => $productsData['next'],
            "message" => trans("products.api.products_retrived")
        ]);
    }
    /**
     * List all products.
     *
     * @return JsonResponse
     */
    public function site_map() 
    {

        $productsData = $this->service->site_map();
        return $this->setApiResponse(true, 200, $productsData['products'], trans("products.api.product_retrived"));

/*        return ProductResource::collection($productsData['products'])->additional([
            "success" => true,
            "status"  => 200,
            "message" => trans("products.api.products_retrived")
        ]);*/
    }

    /**
     * Get Product using id.
     *
     * @param id $product_id
     * @return Response
     */
    public function show($product_id) : JsonResponse
    {
        $product = $this->service->getProductUsingID(intval($product_id));
        $classes = $this->classesRepo->all()->get();
        if($product == null){
            return $this->setApiResponse(true, 200, [], trans("products.api.product_not_found"));
        }
        $product->product_classes =  $classes;
        return $this->setApiResponse(true, 200, new SingleProductResource($product), trans("products.api.product_retrived"));
    }    /**
     * Get Product using id.
     *
     * @param id $product_id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
 */
    public function product_related($product_id) : \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $product = $this->service->getProductUsingID(intval($product_id));
        if(!$product){
            return ProductResource::collection([])->additional(["success" => true,"status"  => 200,"message" => trans("products.api.products_retrived")]);
        }
        $products_related = $this->service->product_related($product);

        return ProductResource::collection($products_related)->additional([
            "success" => true,
            "status"  => 200,
            "message" => trans("products.api.products_retrived")
        ]);
    }

    public function CategotyProducts(int $category_id)
    {
        $products = $this->service->getProductsUsingCategotyID($category_id,20);

        $category = $this->categoryService->getCategoryUsingID($category_id);

        $products->withPath("products");
        return ProductResource::collection($products)->additional([
            "success" => true,
            "status" => 200,
            'category' => new CategoryResource($category),
            "message"=> trans("api.products-return-success")
        ]);
    }

    public function addReview(AddProductReviewRequest $request)
    {
        $response = $this->service->addProductReview($request);
        return $this->setApiResponse
        (
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }
}
