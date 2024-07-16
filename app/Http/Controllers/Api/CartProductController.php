<?php
namespace App\Http\Controllers\Api;

use App\Models\CartProduct;
use Illuminate\Http\JsonResponse;
use App\Services\Api\CartProductService;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Api\CartResource;
use Illuminate\Http\Request;

class CartProductController extends ApiController
{
    /**
     * Cart Controller Constructor.
     *
     * @param CartService $service
     */
    public function __construct(public CartProductService $service) {}

    /**
     * List all Carts.
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $carts = $this->service->getAllCartsWithPagination();
        return $this->setApiResponse(true, 200, CartResource::collection($carts),
        __('To-Do'));
    }

    /**
     * Get Cart using id.
     *
     * @param id $cart_id
     * @return Response
     */
    public function show(int $cart_id) : JsonResponse
    {
        $cart = $this->service->getCartUsingID($cart_id);
        return $this->setApiResponse(true, 200, new CartResource($cart),
            __('To-Do'));
    }

    public function allGroupedByVendor()
    {
        $cartProducts = $this->service->getAllCartProductsGroupByVendor();
        return $cartProducts;
    }
}
