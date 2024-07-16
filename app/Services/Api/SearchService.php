<?php
namespace App\Services\Api;

use App\Http\Resources\Api\ProductResource;
use App\Repositories\Api\ProductRepository;

class SearchService
{
    public function __construct(
        private ProductRepository $productRepository
    ) {}

    /**
     * @param string $nameKeyword
     * @return array
     */
    public function globalSearch(String $nameKeyword = '') : array {
        if($nameKeyword == '') {
            return [
                'success' => true,
                'status' => 200 ,
                'data' => [
                    "products" => [],
                    "total" => 0
                ],
                'message' => trans("products.api.products_retrived")
            ];
        }
        $products = $this->productRepository->all()
            ->where(
                fn($q) => $q->where('name->ar', 'LIKE', "%{$nameKeyword}%")
                    ->orWhere('name->en', 'LIKE', "%{$nameKeyword}%")
                    ->orWhere('desc->ar', 'LIKE', "%{$nameKeyword}%")
                    ->orWhere('desc->en', 'LIKE', "%{$nameKeyword}%")
            )
            ->available()
            ->paginate(10);
        return [
            'success' => true,
            'status' => 200 ,
            'data' => [
                "products" => ProductResource::collection($products),
                "total" => $products->total(),
            ],
            'message' => trans("products.api.products_retrived")
        ];
    }
}
