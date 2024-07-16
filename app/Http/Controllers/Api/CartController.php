<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\AddServiceToCart;
use App\Services\Eportal\Connection;

use Illuminate\Http\JsonResponse;
use App\Services\Api\CartService;
use App\Http\Resources\Api\CartResource;
use Illuminate\Http\Request;
use App\Http\Requests\Api\DeleteCartProduct;
use App\Http\Requests\Api\EditCartProduct;
use App\Http\Requests\Api\SyncCartProduct;
use App\Http\Requests\Api\UpdateAddressCartRequest;
use App\Traits\API\APIResponseTrait;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use App\Http\Resources\Api\ShippingMethodResource;
use App\Models\ShippingMethod;
use App\Rules\CheckProductWeightForShippingRule;
use App\Models\CartVendorShipping;
use App\Models\GiftCity;
use App\Models\Warehouse;
use App\Models\ProductWarehouseStock;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class CartController extends ApiController
{
    use APIResponseTrait;

    public $service;
    private $ssoAuthId;
    private $ssoType;

    /**
     * @param CartService $service
     * @param Request $request
     * @param $ssoAuthId
     */

    public function __construct(CartService $service, Request $request, $ssoAuthId = null)
    {
        $this->service = $service;
        $userAuth = Connection::userAuthOrGuestInfo($request, config('app.eportal_url') . 'profile');
        if(empty($userAuth)){
            return response()->json([
                "success" => false,
                "status" => 406,
                "message" => "Guest Token Is Not Found"
            ]);
        }
        $this->ssoAuthId = $userAuth['id'];
        $this->ssoType = $userAuth['model'];
    }

    /**
     * @hint: useless function
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $carts = $this->service->getAllCartsWithPagination();
        return $this->setApiResponse(true, 200, CartResource::collection($carts),
            __('To-Do'));
    }

    /**
     * @hint: useless function
     * @param int $cart_id
     * @return JsonResponse
     */
    public function show(int $cart_id): JsonResponse
    {
        $cart = $this->service->getCartUsingID($cart_id , $this->ssoType);
        return $this->setApiResponse(true, 200, new CartResource($cart),
            __('To-Do'));
    }

    /**
     * @param EditCartProduct $request
     * @return JsonResponse
     */
    public function addOrEditProduct(EditCartProduct $request): JsonResponse
    {
        try{
            $response = $this->service->addOrEditProduct($request, $this->ssoAuthId , $this->ssoType);
            return $this->setApiResponse(
                $response['success'],
                $response['status'],
                $response['data'],
                $response['message']
            );
        } catch(Exception $ex){
            report($ex);
            return $this->errorResponse($ex->getMessage() ,  $ex->getCode() == 0 ? 500 : $ex->getCode() );
        }
    }
    public function addServicesToCart(AddServiceToCart $request)
    {
        return $this->service->addServicesToCart($request->validated());
    }
    /**
     * @param int $transaction_id
     * @return JsonResponse
     */
    public function reorder(int $transaction_id): JsonResponse
    {
        $response = $this->service->fillCartWithPreviousOrder($transaction_id, $this->ssoAuthId , $this->ssoType);

        return $this->setApiResponse(
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }
    public function reorderServices(int $transaction_id): JsonResponse
    {
        $response = $this->service->fillCartWithPreviousOrderServices($transaction_id, $this->ssoAuthId , $this->ssoType);

        return $this->setApiResponse(
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }

    /**
     * @return JsonResponse
     */
    public function getVendorProducts(): JsonResponse
    {
        $response = $this->service->getCartProductGroupedByVendor($this->ssoAuthId , null,$this->ssoType);
        return $this->setApiResponse(
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }
    public function getServicesInCart()
    {
        return $this->service->getServicesInCart();
    }
    public function deleteService($id)
    {
        return $this->service->deleteService($id);
    }

    /**
     * @return JsonResponse
     */
    public function summary(): JsonResponse
    {
        $response = $this->service->getCartProductGroupedByVendor($this->ssoAuthId , null,$this->ssoType);
        $responseData = [
            "success" => $response['success'],
            "status" => $response['status'],
            "message" => $response['message'],
            "coupon_status" => $response['coupon_status'] ?? null,
            "address_status" => $response['address_status'] ?? null,
        ];
        if (isset($response['coupon_message'])) $responseData['coupon_message'] = $response['coupon_message'];

        if (isset($response['address_message'])) $responseData['address_message'] = $response['address_message'];

        $responseData["data"] = $response['data'];
        return new JsonResponse($responseData, $response['status']);
    }

    /**
     * @param DeleteCartProduct $request
     * @return JsonResponse
     */
    public function deleteProduct(DeleteCartProduct $request): JsonResponse
    {
        $response = $this->service->deleteProductFromCart($request->product_id, $this->ssoAuthId , $this->ssoType);
        return $this->setApiResponse(
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }

    #when client change city_id
    public function updateAddress(Request $request){
        try {
            $cart = $this->service->getCurrentUserActiveCartOrCreate($this->ssoAuthId , $request->get('city_id')  , $this->ssoType);

            return $this->setApiResponse(true,Response::HTTP_OK,["city"=> $cart->city]);
        } catch (\Throwable $th) {
            return $this->setApiResponse(false,Response::HTTP_BAD_REQUEST,[], $th->getMessage());
        }
    }
    public function updateServicesAddress(UpdateAddressCartRequest $request)
    {
        try{
            $cart = $this->service->getCurrentUserActiveServicesCartOrCreate($request->validated());
            return $this->setApiResponse(true,200,["servcieAddress"=> $cart->service_address,'servcieDate' => $cart->service_date],'success message');
        }catch (\Exception $ex) {
            return $this->setApiResponse(false,Response::HTTP_BAD_REQUEST,[], $ex->getMessage());
        }
    }

    #update , shipping_type_id , shipping_method_id
    public function updateVendorShippingType(Request $request){
        $validator = Validator::make($request->all(), [
            'vendor_id' => ['required','exists:vendors,id'],
            'shipping_type_id' => ['nullable' ,'exists:shipping_types,id', "in:1,2"],
            'shipping_method_id' => ['nullable' ,'exists:shipping_methods,id',],
        ]);

        if ($validator->fails()) {
            return $this->setApiResponse(false,Response::HTTP_BAD_REQUEST,[], $validator->errors()->first());
        }

        try {
            $cart = $this->service->findCart($this->ssoAuthId, $this->ssoType);
            if (!$cart)  return $this->setApiResponse(false,Response::HTTP_BAD_REQUEST,[], __('cart.api.cart_not_found'));
            if (!$cart->city_id)  return $this->setApiResponse(false,Response::HTTP_BAD_REQUEST,[], __('cart.api.select_city'));

            #check duplicate
            if($cart->cartVendorShippings()->where('vendor_id' ,$request->vendor_id )->count() > 1){
                $firstId = $cart->cartVendorShippings()->where('vendor_id' ,$request->vendor_id)->first()?->id;
                $cart->cartVendorShippings()->where('vendor_id', $request->vendor_id)->where('id','!=',$firstId)->delete();
            }

            $vendorShipping = CartVendorShipping::updateOrCreate([
                'cart_id' => $cart->id,
                'vendor_id' => $request->vendor_id
                ],
                [
                    'shipping_type_id' => $request->shipping_type_id,
                    'shipping_method_id' => $request->shipping_method_id,
                ]
            );

            # update delivery_warehouse_id
            if($request->shipping_type_id == 2 && $request->get('shipping_method_id')){
                foreach ($cart->cartProducts()->where('vendor_id' ,$request->vendor_id)->get() as $key => $cartProduct) {
                    $warehouseProductStock = ProductWarehouseStock::whereHas('WarehouseShippingTypeDeliver')->with('WarehouseShippingTypeDeliver')->where('product_id' , $cartProduct->product_id)->first();
                    if (!$warehouseProductStock) {
                        return $this->setApiResponse(false,Response::HTTP_BAD_REQUEST,[], __('cart.api.product_missing_in_warehouse_stock',['product'=> $cartProduct->product->name ]));
                    }

                    $vendorShipping->update([
                        'delivery_warehouse_id' =>  $warehouseProductStock->WarehouseShippingTypeDeliver->warehouse_id
                    ]);
                }
            }

            $data = $this->service->getCartProductGroupedByVendor($this->ssoAuthId ,  null ,$this->ssoType)['data'];

            return $this->setApiResponse(true,Response::HTTP_OK,$data);
        } catch (\Throwable $th) {
            return $this->setApiResponse(false,Response::HTTP_BAD_REQUEST,[], $th->getMessage());
        }
    }

    public function updateVendorWarehouse(Request $request){
        $validator = Validator::make($request->all(), [
            'vendor_id' => ['required','exists:vendors,id'],
            'product_id' => ['required','exists:products,id'],
            'shipping_type_id' => ['nullable' ,'exists:shipping_types,id', "in:1,2"],
            'warehouse_id' => ['nullable' ,'exists:warehouses,id',],
        ]);

        if ($validator->fails()) {
            return $this->setApiResponse(false,Response::HTTP_BAD_REQUEST,[], $validator->errors()->first());
        }

        try {
            $cart = $this->service->findCart($this->ssoAuthId, $this->ssoType);
            if (!$cart)  return $this->setApiResponse(false,Response::HTTP_BAD_REQUEST,[], __('cart.api.cart_not_found'));

            #check duplicate
            if($cart->cartVendorShippings()->where('vendor_id' ,$request->vendor_id )->count() > 1){
                $firstId = $cart->cartVendorShippings()->where('vendor_id' ,$request->vendor_id)->first()?->id;
                $cart->cartVendorShippings()->where('vendor_id', $request->vendor_id)->where('id','!=',$firstId)->delete();
            }

            #update CartVendorShipping
            $vendorShipping = CartVendorShipping::updateOrCreate([
                'cart_id' => $cart->id,
                'vendor_id' => $request->vendor_id
                ],
                [
                    'shipping_type_id' => $request->shipping_type_id,
                    'shipping_method_id' => $request->shipping_method_id,
                ]
            );

            #update warehouse_id in cartProduct
            $cartProduct = $cart->cartProducts()->where('product_id',$request->product_id)->first();
            if (!$cartProduct)  return $this->setApiResponse(false,Response::HTTP_BAD_REQUEST,[], __('cart.api.cart_updated_some_deleted_products'));

            if($request->get('warehouse_id')){
                $warehouse = Warehouse::where('vendor_id',$cartProduct->vendor_id)->find($request->warehouse_id);
                if (!$warehouse)  return $this->setApiResponse(false,Response::HTTP_BAD_REQUEST,[], __('cart.api.warehouse_not_found'));


                $warehouseStock = ProductWarehouseStock::where('product_id',$cartProduct->product_id)->where('warehouse_id',$request->warehouse_id)->first();
                if (!$warehouseStock || $warehouseStock->stock <= 0)  return $this->setApiResponse(false,Response::HTTP_BAD_REQUEST,[], __("cart.api.no_stock_available_choose_another_warehouse",['product' => $cartProduct->product->name]));

                if($cartProduct->quantity > $warehouseStock->stock && $warehouseStock->stock > 0){
                    return $this->setApiResponse(false,Response::HTTP_BAD_REQUEST,[], __("cart.api.quantity_available_is_less_than_required",['product' => $cartProduct->product->name]));
                }

            }

            $cartProduct->update([
                'warehouse_id' => $request->warehouse_id
            ]);

            return $this->setApiResponse(true,Response::HTTP_OK,[]);
        } catch (\Throwable $th) {
            return $this->setApiResponse(false,Response::HTTP_BAD_REQUEST,[], $th->getMessage());
        }
    }

}
