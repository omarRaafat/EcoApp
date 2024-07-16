<?php

namespace App\Services\Api;

use App\Enums\OrderStatus;
use App\Http\Requests\Api\AddServiceToCart;
use App\Http\Resources\Api\CartProductServiceResource;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\ProductWarehouseStock;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Repositories\Api\CartRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Api\CartResource;
use App\Http\Resources\Api\ServiceCartResource;
use App\Http\Resources\Api\ServiceResource;

use App\Models\CartProductServiceField;
use App\Models\CartVendorShipping;
use App\Models\City;
use App\Models\DomesticZone;
use App\Models\DomesticZoneMeta;
use App\Models\DomesticZoneShippingMethod;
use App\Models\GuestCustomer;
use App\Models\LineShippingPrice;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use App\Models\WarehouseCity;
use App\Repositories\Api\TransactionRepository;
use App\Services\Eportal\Connection;
use App\Services\Order\OrderProcess;
use Closure;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\PostHarvestServicesDepartment;
use App\Models\Service;
use App\Models\ServiceField;
use App\Models\UrwayTransaction;
use App\Models\TabbyTransaction;
use App\Services\Payments\Urway\Constants as UrwayConstants;

class CartService
{
    private $ssoAuthWallet;

    /**
     * Cart Service Constructor.
     *
     * @param CartRepository $repository
     */
    public function __construct(
        public CartRepository        $repository,
        public TransactionRepository $transactionRepository,
        public VendorService         $vendorService,
        public ProductService        $productService,
        // public AddressService        $addressService,
    ) {
        if(auth()->guard('api_client')->check()){
            $res =  Connection::userAuthWallet(request());
            $this->ssoAuthWallet = collect($res ? ($res->json()['data'] ?? []) : []);

        }
    }


    /**
     * Get carts.
     *
     * @return Collection
     */
    public function getAllcarts(): Collection
    {
        return $this->repository->all()->get();
    }

    /**
     * Get Categories with pagination.
     *
     * @param integer $perPage
     * @return LengthAwarePaginator
     */
    public function getAllCartsWithPagination(int $perPage = 10): LengthAwarePaginator
    {
        return $this->repository->all()->paginate($perPage);
    }

    /**
     * Get Cart using ID.
     *
     * @param integer $id
     * @return Cart
     */
    public function getCartUsingID(int $id , $model_type = Client::class): Cart|null
    {
        return $this->repository->getModelUsingID($id);
    }

    /**
     * @param Request $request
     * @param integer $customerId
     * @return array
     */
    public function addOrEditProduct(Request $request, int $customerId , $model_type): array
    {
        $cart = $this->getCurrentUserActiveCartOrCreate($customerId , request()->city_id ,$model_type);
        if($cart->cartProducts()->where('service_id','!=',null)->exists()){
            return [
                'success' => false,
                'status' => 400,
                'data' => [],
                'message' => trans('cart.api.service_exist_in_cart')
            ];
        }
        $handled = $this->handleCardProductChange($request->toArray(),$cart);
        if ($handled === false) {
            return [
                'success' => false,
                'status' => Response::HTTP_NOT_ACCEPTABLE,
                'data' => [],
                'message' => __('cart.api.cannot_checkout_product_missing')
            ];
        }
        return  $this->getCartProductGroupedByVendor(
            $customerId,
            function () use ($cart, $request , $model_type) {
                return (new OrderProcess($cart, $request , $model_type))
                    ->getCalculatorComponent()
                    ->getTransactionTotalsInHalala();
            }
        , $model_type);
    }

    public function addServicesToCart($request)
    {
            $cart = $this->getCurrentUserActiveServicesCartOrCreate($request);
            // dd($cart);
            if($cart->cartProducts()->where('product_id','!=',null)->exists()){
                return response()->json([
                    'success' => false,
                    'status' => 400,
                    'data' => [],
                    'message' => trans('cart.api.product_exist_in_cart')
                ],400);
            }
            $handled = $this->handleCardServiceChange($request,$cart);
            if ($handled === false) {
                return [
                    'success' => false,
                    'status' => Response::HTTP_NOT_ACCEPTABLE,
                    'data' => [],
                    'message' => __('cart.api.cannot_checkout_product_missing')
                ];
            }
            return $this->getCartServiceGroupedByVendor($request);
    }
    /**
     * @param array $LocalCartProducts
     * @param integer $customerId
     * @return void
     */
    public function newSyncCart(array $LocalCartProducts, int $customerId , $type = Client::class)
    {

        $shippingFees = 0;
        $city_id = $LocalCartProducts['city_id'] ?? null ;
        $cart = $this->getCurrentUserActiveCartOrCreate($customerId , $city_id  , $type);
        if($cart){

            #when refresh cart, disabled currect proccess paying
            $UrwayTransaction = UrwayTransaction::where('statusCallback',null)->where('status',UrwayConstants::pending)->where('cart_id',$cart->id)->update(['status' => UrwayConstants::failed, 'statusCallback'=>'refreshCart']);
            $TabbyTransaction = TabbyTransaction::where('statusCallback',null)->where('status',UrwayConstants::pending)->where('cart_id',$cart->id)->update(['status' => UrwayConstants::failed, 'statusCallback'=>'refreshCart']);

            $cart->cartVendorShippings()->delete();
            $cart->cartProducts()?->delete();

            // CartProduct::where('cart_id', $cartId)->delete();
            // $cart->cartProducts()?->delete();
            // $cart->cartProducts()?->delete();

        }
        $missingProducts = false;
        // dd($LocalCartProducts);
        // $cartVendorShippings = CartVendorShipping::where('cart_id' , $cart->id)->get();
        // foreach($cartVendorShippings as $cartVendorShipping){
        //     $cartVendorShipping?->delete();
        // }
        foreach($LocalCartProducts['vendors'] as $vendor) {
            // dd($vendor);
            $products_id = [];
            $quantity = 0;
            $total_weight = 0 ;
            foreach($vendor['products'] as $product){
                $products_id[] = $product['product_id'];
                $quantity += $product['quantity'];
                $handled = $this->handleCardProductChange($product,$cart, false , $city_id);
                if($handled === false) $missingProducts =true;
                $total_weight += Product::find($product['product_id'])->totalWeightByKilo * $product['quantity'];
            }
            // dd($total_weight);
            // calculate shipping fees of each product if shipping type == deliver
            $total_weight = $total_weight >= 0 && $total_weight < 1  ? ceil($total_weight) : $total_weight;
                if($vendor['shipping_type_id'] == 2){
                    if($vendor['shipping_method_id'] == 1){
                        if(($total_weight / 1000) > 5){
                            // dd('and hena y kareem');
                            $cartVendorShipping = $this->calculateShippingFees($cart , $vendor  , $total_weight , $city_id , $quantity , $customerId , $type);
                            $shippingFees +=  $cartVendorShipping->total_shipping_fees;
                        }else{
                            $cartVendorShipping = $this->calculateShippingAramex($cart , $vendor ,$total_weight , $quantity , $city_id , $customerId , $type);
                            $shippingFees += $cartVendorShipping->total_shipping_fees;
                        }
                    }else{
                        $cartVendorShipping =  $this->calculateShippingFeesForGeneralShipping($cart , $vendor  , $total_weight , $city_id , $quantity , $customerId , $type);
                        $shippingFees += $cartVendorShipping->total_shipping_fees;
                    }
                }
                elseif($city_id){
                    $cartVendorShipping = $this->updateShippingCartIfChangeShippingTypeToReceive($cart , $vendor ,$total_weight , $city_id , $customerId , $type);
                }
        }

        $cartRersponse = $this->getCartProductGroupedByVendor($customerId ,null, $type);
        $cart->update(['total_shipping_fees' => $shippingFees]);

        if ($missingProducts) $cartRersponse['message'] = __('cart.api.cart_updated_with_missings');
        return $cartRersponse;
    }
    public function newSyncCartService($LocalCartProducts, int $customerId , $type = Client::class)
    {
        $shippingFees = 0;
        $city_id = $LocalCartProducts['city_id'] ?? null ;
        $cart = $this->getCurrentUserActiveServicesCartOrCreate($customerId , $city_id  , $type);
        if($cart){

            #when refresh cart, disabled currect proccess paying
            $UrwayTransaction = UrwayTransaction::where('statusCallback',null)->where('status',UrwayConstants::pending)->where('cart_id',$cart->id)->update(['status' => UrwayConstants::failed, 'statusCallback'=>'refreshCart']);
            $TabbyTransaction = TabbyTransaction::where('statusCallback',null)->where('status',UrwayConstants::pending)->where('cart_id',$cart->id)->update(['status' => UrwayConstants::failed, 'statusCallback'=>'refreshCart']);

            // $cart->cartVendorShippings()->delete();
            $cart->cartProducts()?->delete();

            // CartProduct::where('cart_id', $cartId)->delete();
            // $cart->cartProducts()?->delete();
            // $cart->cartProducts()?->delete();

        }
        $missingServices = false;
        // dd($LocalCartProducts);
        // $cartVendorShippings = CartVendorShipping::where('cart_id' , $cart->id)->get();
        // foreach($cartVendorShippings as $cartVendorShipping){
        //     $cartVendorShipping?->delete();
        // }
        foreach($LocalCartProducts->vendors as $vendor) {
            // dd($vendor);
            $services_id = [];
            $quantity = 0;
            $total_weight = 0 ;
            foreach($vendor['vendorServices'] as $product){
                $services_id[] = $product['service_id'];
                $quantity += $product['quantity'];
                $handled = $this->handleCardServiceChange($product,$cart, false , $city_id);
                if($handled === false) $missingServices =true;
                $total_weight += Service::find($product['service_id'])->calculateTotalPrice * $product['quantity'];
            }
            // dd($total_weight);
            // calculate shipping fees of each product if shipping type == deliver
            $total_weight = $total_weight >= 0 && $total_weight < 1  ? ceil($total_weight) : $total_weight;
                // if($vendor['shipping_type_id'] == 2){
                //     if($vendor['shipping_method_id'] == 1){
                //         if(($total_weight / 1000) > 5){
                //             // dd('and hena y kareem');
                //             $cartVendorShipping = $this->calculateShippingFees($cart , $vendor  , $total_weight , $city_id , $quantity , $customerId , $type);
                //             $shippingFees +=  $cartVendorShipping->total_shipping_fees;
                //         }else{
                //             $cartVendorShipping = $this->calculateShippingAramex($cart , $vendor ,$total_weight , $quantity , $city_id , $customerId , $type);
                //             $shippingFees += $cartVendorShipping->total_shipping_fees;
                //         }
                //     }else{
                //         $cartVendorShipping =  $this->calculateShippingFeesForGeneralShipping($cart , $vendor  , $total_weight , $city_id , $quantity , $customerId , $type);
                //         $shippingFees += $cartVendorShipping->total_shipping_fees;
                //     }
                // }
                // elseif($city_id){
                //     $cartVendorShipping = $this->updateShippingCartIfChangeShippingTypeToReceive($cart , $vendor ,$total_weight , $city_id , $customerId , $type);
                // }
        }

        $cartRersponse = $this->getCartServiceGroupedByVendor($customerId ,null, $type);
        $cart->update(['total_shipping_fees' => $shippingFees]);

        if ($missingServices) $cartRersponse['message'] = __('cart.api.cart_updated_with_missings');
        return $cartRersponse;
    }

    public function addOrUpdateWareHousesAtCart($cart){

    }
    public function calculateShippingFeesForGeneralShipping(Cart $cart , array $vendorOfRequest, float $total_weight , int $city_id , int $quantity, int $customerId , $model_type = Client::class)
    {
           $city = City::find($city_id);
           $getDomesticIdsRelatedToShippingMethod = DomesticZoneShippingMethod::where('shipping_method_id' , $vendorOfRequest['shipping_method_id'])->pluck('domestic_zone_id')->toArray();
           $getDomesticIdDepandOnCity = DomesticZoneMeta::whereIn('domestic_zone_id' , $getDomesticIdsRelatedToShippingMethod)->where('related_model' , City::class)->where('related_model_id' , $city_id)->first()?->domestic_zone_id;
           $total_fees = 0;
           $base_fees = 0;
           $calculateAdditionalKilos = 0;
           if($getDomesticIdDepandOnCity){
               $getDomesticZone = DomesticZone::find($getDomesticIdDepandOnCity);
               $percentage = ($getDomesticZone->fuelprice / 100) ?? 0;

                if( (int) $getDomesticZone->delivery_fees_covered_kilos >= ceil($total_weight)){
                  // Weight less than 15kg has a different price (SPL only id=2)
                  if(ceil($total_weight) <= 15 && $getDomesticZone->id == 2){
                    $base_fees = 28.75  + (28.75  * $percentage);
                    $total_fees = 28.75  + (28.75  * $percentage);
                  }else{
                    $base_fees = $getDomesticZone->delivery_fees + ($getDomesticZone->delivery_fees * $percentage);
                    $total_fees = $getDomesticZone->delivery_fees + ($getDomesticZone->delivery_fees * $percentage) ;
                  }
                }
                elseif((int)  $getDomesticZone->delivery_fees_covered_kilos < ceil($total_weight)){
                    $additionalKilos = ceil($total_weight) - $getDomesticZone->delivery_fees_covered_kilos;
                    $overweightPrice = ($additionalKilos * $getDomesticZone->additional_kilo_price);
                    // $percentage = $getDomesticZone->fuelprice / 100;
                    $calculateAdditionalKilos = $getDomesticZone->additional_kilo_price *  $additionalKilos ;
                    $base_fees = $getDomesticZone->delivery_fees;
                    $total_fees_kilos        =  $calculateAdditionalKilos + $base_fees;
                    $total_fees = $total_fees_kilos + ( $total_fees_kilos * $percentage );
               }
           }

           $data = [
                'van_type' => null ,
                'total_weight' => $total_weight,
                'cart_id' => $cart?->id ,
                'vendor_id' => $vendorOfRequest['vendor_id'] ,
                'total_shipping_fees' => $total_fees,
                'shipping_type_id' => $vendorOfRequest['shipping_type_id'],
                'shipping_method_id' => $vendorOfRequest['shipping_method_id'],
                'city_id' => null,
                'to_city_id' => $city_id,
                'city_name' => null,
                'to_city_name' => $city->name,
                'user_id' =>$model_type == Client::class ? $customerId : null,
                'guest_customer_id' =>$model_type == GuestCustomer::class ? $customerId : null,
                'no_of_products' => $quantity,
                'base_shipping_fees' => $base_fees ,
                'extra_shipping_fees' => $calculateAdditionalKilos ,

            ];

            return CartVendorShipping::updateOrCreate(['vendor_id' => $data['vendor_id'] , 'cart_id' => $data['cart_id']] , $data);
            // return $total_fees;

    }


    public function calculateShippingFees(Cart $cart , array $vendorOfRequest, float $total_weight , int $city_id , int $quantity, int $customerId , $model_type = Client::class)
    {
        // dd('ww');
            $vendor = Vendor::find($vendorOfRequest['vendor_id']);
            $deliverWarehouseOfVendor = $vendor->warehousesDeliver()->first();
            $wareHouseCity = WarehouseCity::where('warehouse_id' , $deliverWarehouseOfVendor?->id)->first();
            $search_in_cities_shipping = LineShippingPrice::where(function ($query) use ($wareHouseCity, $city_id) {
                $query->where('city_id', $wareHouseCity->city_id)
                    ->where('city_to_id', $city_id);
            })->orWhere(function ($query) use ($wareHouseCity, $city_id) {
                $query->where('city_to_id', $wareHouseCity->city_id)
                    ->where('city_id', $city_id);
            })->first();
            // dd($search_in_cities_shipping , $wareHouseCity);
            if(is_null($search_in_cities_shipping)){
                $this->calculateShippingAramex($cart , $vendorOfRequest ,$total_weight , $quantity , $city_id , $customerId);
            }else{
                $total_weight = $total_weight  / 1000;
                // try{
                    foreach(config('trucks-load') as $key => $value){
                    if($total_weight >= $value['min'] && $total_weight <= $value['max']){
                            $city=City::find($city_id);
                            $data = [
                                'van_type' => $key ,
                                'total_weight' => $total_weight,
                                'cart_id' => $cart?->id ,
                                'vendor_id' => $vendorOfRequest['vendor_id'],
                                'total_shipping_fees' => $search_in_cities_shipping->{$key},
                                'shipping_type_id' => $vendorOfRequest['shipping_type_id'],
                                'city_id' => $wareHouseCity->city_id,
                                'to_city_id' => $city_id,
                                'city_name' => $wareHouseCity->city->name,
                                'to_city_name' => $city->name,
                                'user_id' =>$model_type == Client::class ? $customerId : null,
                                'guest_customer_id' =>$model_type == GuestCustomer::class ? $customerId : null,
                                'no_of_products' => $quantity,
                                'shipping_method_id' => 1
                            ];
                        }
                    }
                    return CartVendorShipping::updateOrCreate(['vendor_id' => $data['vendor_id'] , 'cart_id' => $data['cart_id']] , $data);

                // }catch(Exception $e){
                //     new exception( 'please make sure from config file of your truck');
                // }
             // return $data['total_shipping_fees'];
        }
    }


    public function calculateShippingAramex(Cart $cart , array $vendorOfRequest , $total_weight , $quantity , int $city_id , int $customerId , $model_type = Client::class){
       return $this->calculateShippingFeesForGeneralShipping($cart , $vendorOfRequest  , $total_weight , $city_id , $quantity , $customerId , $model_type);
    }




    public function updateShippingCartIfChangeShippingTypeToReceive(Cart $cart , array $vendor , $total_weight  , int $city_id , int $customerId , $model_type = Client::class){
        $city = City::find($city_id);

        $data = [
            'van_type' => null ,
            'total_weight' => $total_weight,
            'cart_id' => $cart?->id ,
            'vendor_id' => $vendor['vendor_id'] ,
            'total_shipping_fees' => null,
            'shipping_type_id' => $vendor['shipping_type_id'],
            'shipping_method_id' => $vendor['shipping_method_id'] ?? null,
            'delivery_warehouse_id' => null,
            'city_id' => null,
            'to_city_id' => $city_id,
            'city_name' => null,
            'to_city_name' => $city->name,
            'user_id' =>$model_type == Client::class ? $customerId : null,
            'guest_customer_id' =>$model_type == GuestCustomer::class ? $customerId : null,
            // 'no_of_products' => $quantity

        ];

        return CartVendorShipping::updateOrCreate(['vendor_id' => $data['vendor_id'] , 'cart_id' => $data['cart_id']] , $data);

        // return $data['total_shipping_fees'];

    }


    /**
     * @param integer $customerId
     * @return Cart
     */

    public function getCurrentUserActiveCartOrCreate(int $customerId ,int $city_id = null , $type = Client::class) : Cart
    {
        return $this->repository->curretUserCart($customerId , $city_id , $type);
    }
    public function getCurrentUserActiveServicesCartOrCreate($request)
    {
        $auth = request()->header('X-Guest-Token');
        if(auth('api_client')->check())
            $auth = auth('api_client')->user()->id;
        else
            $guest = GuestCustomer::whereToken($auth)->first();
            if(auth('api_client')->user())
            {
                $cart = Cart::where('user_id', $auth)->withSum('cartProducts', 'quantity')->first();
                if (!$cart) $cart = Cart::create(['user_id' => $auth, 'is_active' => 1 , 'city_id' => request()->city_id,'service_address' => request()->serviceAddress,'service_date' => request()->serviceDate] );
                else if ($cart->is_active != 1) $cart->update(['is_active' => 1]);
                else if(request()->has('city_id')  && $cart->city_id != request()->get('city_id') )  $cart->update(['city_id' => request()->city_id]);
                else if(request()->has('serviceAddress')  && $cart->service_address != request()->get('serviceAddress') )  $cart->update(['service_address' => request()->serviceAddress]);
                else if(request()->has('serviceDate')  && $cart->service_date != request()->get('serviceDate') )  $cart->update(['service_date' => request()->serviceDate]);
            }else{
                $cart = Cart::where('guest_customer_id', $guest->id)->withSum('cartProducts', 'quantity')->first();
                if (!$cart) $cart = Cart::create(['guest_customer_id' => $guest->id, 'is_active' => 1 , 'city_id' => request()->city_id,'service_address' => request()->serviceAddress,'service_date' => request()->serviceDate] );
                else if ($cart->is_active != 1) $cart->update(['is_active' => 1]);
                else if(request()->has('city_id')  && $cart->city_id != request()->get('city_id') )  $cart->update(['city_id' => $request['city_id']]);
                else if(request()->has('serviceAddress')  && $cart->service_address != request()->get('serviceAddress') )  $cart->update(['service_address' => request()->serviceAddress]);
                else if(request()->has('serviceDate')  && $cart->service_date != request()->get('serviceDate') )  $cart->update(['service_date' => request()->serviceDate]);
            }
            // dd($cart);
            return $cart;
    }

    /**
     * @param array $request
     * @param Model $cart
     * @param boolean $append
     * @return boolean|null
     */
    public function handleCardProductChange(array $request, Model $cart, bool $append = false , $city_id = null) : bool|null {
        if($request['quantity'] < 1) return false;

        #get cartProduct
        $cartProduct = $cart->cartProducts()->where('product_id',$request['product_id'])->first();

        #chec product is available  //use 1 istead of request['quantity'] beacause we update qnt in line 437
        $product = $this->productService->repository->getProductIfAvailableWithQuantity($request['product_id'], 1 );
        if(!$product){
            if($cartProduct) $cartProduct->delete();
            return false;
        }

        #create
        if(!$cartProduct) return $this->_addProductToCart($request, $cart, $product);

        #checkDuplicate
        $checkDuplicate = $cart->cartProducts()->where('product_id',$request['product_id'])->count();
        if($checkDuplicate > 1) $cart->cartProducts()->where('product_id', $request['product_id'])->where('id','!=',$cartProduct->id)->delete();

        if($cartProduct->quantity > $product->stock){
            $cartProduct->update([
                'quantity' => $product->stock
            ]);
        }

        #update
        return $this->_editProductInCart($request, $cartProduct, $cart ,$product,$append);
    }

    private function handleCardServiceChange($request, Model $cart, bool $append = false , $city_id = null)
    {
        if($request['quantity'] < 1) return false;

        #get cartProduct
        $cartProduct = $cart->cartProducts()->where('service_id',$request['service_id'])->first();
        #create
        if(!$cartProduct) return $this->_addServicesToCart($request, $cart);

        #checkDuplicate
        $checkDuplicate = $cart->cartProducts()->where('service_id',$request['service_id'])->count();
        if($checkDuplicate > 1) $cart->cartProducts()->where('service_id', $request['service_id'])->where('id','!=',$cartProduct->id)->delete();

        #update
        return $this->_editServicesInCart($request, $cartProduct, $cart,$append);
    }

    /**
     * @param integer $customerId
     * @return array
     */
    public function getCartProductGroupedByVendor(int $customerId, Closure $totalsCalculation = null , $type): array
    {
        $cart = $this->repository->curretUserCart($customerId ,null, $type);
        if (!$cart || CartProduct::where('cart_id',$cart->id)->where('service_id','!=',null)->exists()) {return ['success' => true, 'status' => 400, 'data' => [], 'message' => __('cart.api.cart_is_empty')];}
        $cartId = $cart?->id;
        $orderProcess = new OrderProcess($cart, request() , $type);
        $cartComponent = $orderProcess->getCartComponent();
        #check cart quantity is >= product stock
        $missedStock =  $cartComponent->cartProductsMissedStock();
        if(!empty($missedStock)){
            #delete when product stock is zero
            CartProduct::where('cart_id', $cartId)
            ->where('service_id',null)
            ->whereIn('product_id', collect($missedStock)->where('stock','<=',0)->pluck('product_id')->toArray())
            ->delete();

            #update cart quantity when product stock > zero
            foreach (collect($missedStock)->where('stock','>',0) as $key => $missedStockItem) {
                $product = Product::available()->find($missedStockItem['product_id']);
                if(!$product){
                    CartProduct::where('cart_id', $cartId)->where('product_id', $missedStockItem['product_id'])
                    ->where('service_id',null)
                    ->get()->each->delete();
                }else{
                    CartProduct::where('cart_id', $cartId)->where('product_id', $missedStockItem['product_id'])
                    ->where('service_id',null)
                    ->update([
                        'quantity' => $missedStockItem['stock'],
                        'total_price' => $product->price *  $missedStockItem['stock'],
                        'total_weight' => $product->totalWeightByKilo * $missedStockItem['stock']
                    ]);
                }

            }

            $cartComponent->refreshCart();
        }
        $missedProducts = $cartComponent->cartProductsMissedPrice();
        if ($missedProducts->isNotEmpty()) {
            CartProduct::where('cart_id', $cartId)
                ->whereIntegerInRaw('product_id', $missedProducts->map(fn($p) => $p['id'])->toArray())
                ->delete();
            $cartComponent->refreshCart();
        }

        #delete cartVendorShippings not used
        $cart->cartVendorShippings()->whereNotIn('vendor_id',$cart->cartProducts()->pluck('vendor_id')->toArray())->delete();

        if ($cartComponent->isCartEmpty()) {
            return ['success' => true, 'status' => 200, 'data' => [], 'message' => __('cart.api.cart_is_empty')];
        }


        foreach (array_unique($cart->cartProducts()->pluck('vendor_id')->toArray())  as $key => $vendor_id) {
            $shippingFees = 0;
            $quantity = 0;
            $total_weight = 0 ;
            foreach($cart->cartProducts()->where('vendor_id',$vendor_id)->get() as $cartProduct){
                $products_id[] = $cartProduct->product_id;
                $quantity += $cartProduct->quantity;
                $total_weight += $cartProduct->product?->totalWeightByKilo * $cartProduct->quantity;
            }
            $total_weight = ($total_weight >= 0 && $total_weight < 1)  ? ceil($total_weight) : $total_weight;
            $ExitCartVendorShipping = $cart->cartVendorShippings()->where('vendor_id' ,$vendor_id)->first();
            if($ExitCartVendorShipping && $cart->city_id){
                if($ExitCartVendorShipping->shipping_type_id == 2){
                    if($ExitCartVendorShipping->shipping_method_id == 1){
                        if(($total_weight / 1000) > 5){
                            $cartVendorShipping = $this->calculateShippingFees($cart , $ExitCartVendorShipping->toArray()  , $total_weight , $cart->city_id , $quantity , $customerId , $type);
                            $shippingFees +=  $cartVendorShipping->total_shipping_fees;
                        }else{
                            $cartVendorShipping = $this->calculateShippingAramex($cart , $ExitCartVendorShipping->toArray() ,$total_weight , $quantity , $cart->city_id , $customerId , $type);
                            $shippingFees += $cartVendorShipping->total_shipping_fees;
                        }
                    }else{
                        $cartVendorShipping =  $this->calculateShippingFeesForGeneralShipping($cart , $ExitCartVendorShipping->toArray()  , $total_weight , $cart->city_id , $quantity , $customerId , $type);
                        $shippingFees += $cartVendorShipping->total_shipping_fees;
                    }
                }else{
                    $cartVendorShipping = $this->updateShippingCartIfChangeShippingTypeToReceive($cart , $ExitCartVendorShipping->toArray() ,$total_weight , $cart->city_id , $customerId , $type);
                }
            }

        }

        if($cart->total_price != $cart->cartProducts()->sum('total_price') || $cart->total_weight != $cart->cartProducts()->where('service_id',null)->sum('total_weight')){
            $cart->update([
                'total_weight' => $cart->cartProducts()->sum('total_weight') ,
                'total_price' => $cart->cartProducts()->sum('total_price') ,
                'products_count' => $cart->cartProducts()->sum('quantity') ,
                'total_shipping_fees' => $shippingFees
            ]);
            $cartComponent->refreshCart();
        }

        $cart = $cartComponent->getCart();
        $customer = $cartComponent->getCustomer($type);
        if ($totalsCalculation){
            $cart['totals'] = $totalsCalculation();
        }else{
            $cart['totals'] = $orderProcess->getCalculatorComponent()->getTransactionTotalsInHalala();
        }
        $cart['wallet_amount'] = $customer->ownWallet->amount_with_sar ?? 0;
        $response = [
            'success' => true,
            'status' => 200,
            'data' => new CartResource($cart , $this->ssoAuthWallet),
            'message' => $missedProducts->isNotEmpty() ?
                __('cart.api.product-missed-country-deleted', ['products' => $missedProducts->implode("name", ",")]) :
                __('cart.api.cart_updated')
        ];

        if (isset($cart['totals']['discount']) && $cart['totals']['discount'] > 0) {
            $response["coupon_message"] = __("cart.api.coupon-applied");
            $response["coupon_status"] = true;
        } else {
            try {
                $orderProcess->isDiscountValidToUse();
                $response["coupon_message"] = "";
                $response["coupon_status"] = true;
            } catch (Exception $e) {
                $response["success"] = false;
                $response["status"] = Response::HTTP_NOT_ACCEPTABLE;
                $response["coupon_message"] = $e->getMessage();
                $response["coupon_status"] = false;
            }
        }
        if ($orderProcess->isAddressMatchCountryHeader() === false) {
            $response["success"] = false;
            $response["status"] = Response::HTTP_NOT_ACCEPTABLE;
            $response["address_message"] = __("cart.api.address-out-of-coverage");
            $response["address_status"] = false;
        } else {
            $logisticValidToUse = $orderProcess->isLogisticValidToUse();
            if ($logisticValidToUse && isset($cart['totals']['delivery_fees'])) {   //TODO: you may need to add this: && $cart['totals']['delivery_fees'] > 0
                $response["address_message"] = __("cart.api.address-selected");
                $response["address_status"] = true;
            } else if ($logisticValidToUse === false) {
                $response["success"] = false;
                $response["status"] = Response::HTTP_NOT_ACCEPTABLE;
                $response["address_message"] = __("cart.api.address-out-of-coverage");
                $response["address_status"] = false;
            }
        }

        return $response;
    }

    public function getCartServiceGroupedByVendor() {
        $cart = $this->getCurrentUserActiveServicesCartOrCreate(request());
        if (!$cart) return ['success' => true, 'status' => 200, 'data' => [], 'message' => __('cart.api.cart_is_empty')];
        $cartId = $cart?->id;
        $orderProcess = new OrderProcess($cart, request() , '\App\Models\Client');
        $cartComponent = $orderProcess->getCartComponent();
        if($cart->total_price != $cart->cartProducts()->sum('total_price')){
            $cart->update([
                'total_weight' => $cart->cartProducts()->sum('total_weight') ,
                'total_price' => $cart->cartProducts()->sum('total_price') ,
                'products_count' => $cart->cartProducts()->sum('quantity') ,
                // 'total_shipping_fees' => $shippingFees
            ]);
            $cartComponent->refreshCart();
        }

        $cart = $cartComponent->getCart();
        $customer = $cartComponent->getCustomer(Client::class);
        $cart['wallet_amount'] = $customer->ownWallet?->amount_with_sar ?? 0;
        // $customer = $cartComponent->getCustomer($type = Client::class);
        $response = [
            'success' => true,
            'status' => 200,
            'data' => new ServiceCartResource($cart , $this->ssoAuthWallet),
            'message' => trans('cart.api.service_add_to_cart')
        ];
        return $response;
    }
    public function getProductsInCart($customerId,$type)
    {
        $cart = $this->repository->curretUserCart($customerId ,null, $type);
        $products =CartProduct::where('cart_id',$cart->id)
        ->where('service_id',null)
        ->get();
        if($products->count() > 0){
            $response = [
                'success' => true,
                'status' => 200,
                'data' => new CartResource($cart),
                'message' => 'success message'
            ];
            return $response;
        }
        return response()->json([
            'success' => true,
            'status' => 400,
            'data' => [],
            'message' => 'product_not_found'
        ],400);
    }
    public function getServicesInCart()
    {
        $cart = $this->getCurrentUserActiveServicesCartOrCreate(request());
        $services =CartProduct::where('cart_id',$cart->id)
        ->where('product_id',null)
        ->get();
        if($services->count() > 0){
            $response = [
                'success' => true,
                'status' => 200,
                'data' => new CartProductServiceResource($cart,$this->ssoAuthWallet),
                'message' => 'success message'
            ];
            return $response;
        }
        return response()->json([
            'success' => true,
            'status' => 400,
            'data' => [],
            'message' => trans('cart.api.service_not_found')
        ],400);
    }
    public function deleteService($id)
    {
        $cart = $this->getCurrentUserActiveServicesCartOrCreate(request());
        $service =CartProduct::where('cart_id',$cart->id)->where('service_id',$id)->first();
        // return $cart;
        if($service){
            $service->delete();
            // check items in cart == 0 delete cart
            $cart->cartProducts->count() === 0 ? $cart->delete() : "";
            return response()->json([
                'success' => true,
                'status' => 200,
                'data' => $cart->cartProducts->count() > 0 ?  new CartProductServiceResource($cart) : [],
                'message' => trans('cart.api.service_deleted')
            ],200);
        }
        return response()->json([
            'success' => false,
            'status' => 400,
            'data' => [],
            'message' => trans('cart.api.services_not_found')
        ],400);
    }

    // TODO: Workarround till go production with staging
    private function getCart($cartId): Cart|null
    {
        return Cart::query()->where('id', $cartId)->with([
            'vendors' => function ($vendorQuery) use ($cartId) {
                $vendorQuery->select('vendors.id', 'vendors.name')
                    ->groupBy('vendors.id', 'vendors.name', 'cart_product.cart_id', 'cart_product.vendor_id')
                    ->with([
                        'cartProducts' => fn($q) => $q->where('cart_product.cart_id', $cartId)->withTrashed()
                    ]);
            },
            'user.ownWallet'
        ])
            ->withSum('cartProducts', 'quantity')
            ->first();
    }

    /**
     * @param integer $transaction_id
     * @param integer $customerId
     * @return array
     */
    public function fillCartWithPreviousOrder(int $transaction_id, int $customerId , $model_type): array
    {
        $transaction = $this->transactionRepository->getModelUsingID($transaction_id);

        if ($transaction == null || $transaction->status != OrderStatus::COMPLETED) {
            // dd($transaction);
            return [
                'success' => false,
                'status' => 400,
                'data' => [],
                'message' => __('cart.api.cannot_reorder')
            ];
        }
        $productCount = 0;
        $data = [];
        $getShippings = $transaction->orderVendorShippings;
        foreach($getShippings as $i => $getShipping){
            $data['cart']['city_id'] =  $transaction->city_id ;
            $data['cart']['vendors'][$i]['vendor_id'] = $getShipping->vendor_id;
            $data['cart']['vendors'][$i]['shipping_type_id'] = $getShipping->shipping_type_id;
            $data['cart']['vendors'][$i]['shipping_method_id'] = $getShipping->shipping_method_id;
            foreach($getShipping->orderVendorWarehouses as $i2 => $orderVendorWarehouse){
                $product = Product::find($orderVendorWarehouse->product_id);
                $quantity = $orderVendorWarehouse->order->orderProducts()->where('product_id' ,  $orderVendorWarehouse->product_id)->first()->quantity;
                if($product->stock > $quantity){
                    $data['cart']['vendors'][$i]['products'][$i2]['product_id'] = $orderVendorWarehouse->product_id;
                    $data['cart']['vendors'][$i]['products'][$i2]['warehouse_id'] = $getShipping->shipping_method_id == 2 ? null : $orderVendorWarehouse->warehouse_id;
                    $data['cart']['vendors'][$i]['products'][$i2]['quantity'] = (int)$quantity;
                }else{

                    $isSuccess = false;
                    $statusCode = 422;
                    $cartRersponse['message'] =  __('cart.api.some_products_doesnt_have_stock');
                    $cartRersponse['data'] = [];
                    $cartRersponse['success'] = $isSuccess;
                    $cartRersponse['status'] = $statusCode;

                    return $cartRersponse;

                }

            }

        }
        $isSuccess = true;
        $statusCode = 200;
        $this->newSyncCart($data['cart'] , $transaction->customer_id);
        $cartRersponse['data'] = $this->getCartProductGroupedByVendor($customerId ,  null ,$model_type)['data'];
        $cartRersponse['message'] =  __('cart.api.reorder_successfully');
        $cartRersponse['success'] = $isSuccess;
        $cartRersponse['status'] = $statusCode;
        return $cartRersponse;
    }
    public function fillCartWithPreviousOrderServices(int $transaction_id, int $customerId , $model_type): array
    {
        $transaction = $this->transactionRepository->getModelUsingID($transaction_id);

        if ($transaction == null || $transaction->status != OrderStatus::COMPLETED) {
            // dd($transaction);
            return [
                'success' => false,
                'status' => 400,
                'data' => [],
                'message' => __('cart.api.cannot_reorder')
            ];
        }
        $serviceCount = 0;
        $data = [];
        // $getShippings = $transaction->orderVendorShippings;
        // foreach($getShippings as $i => $getShipping){
        //     $data['cart']['city_id'] =  $transaction->city_id ;
        //     $data['cart']['vendors'][$i]['vendor_id'] = $getShipping->vendor_id;
        //     $data['cart']['vendors'][$i]['shipping_type_id'] = $getShipping->shipping_type_id;
        //     $data['cart']['vendors'][$i]['shipping_method_id'] = $getShipping->shipping_method_id;
        //     foreach($getShipping->orderVendorWarehouses as $i2 => $orderVendorWarehouse){
        //         $product = Product::find($orderVendorWarehouse->product_id);
        //         $quantity = $orderVendorWarehouse->order->orderProducts()->where('product_id' ,  $orderVendorWarehouse->product_id)->first()->quantity;
        //         if($product->stock > $quantity){
        //             $data['cart']['vendors'][$i]['products'][$i2]['product_id'] = $orderVendorWarehouse->product_id;
        //             $data['cart']['vendors'][$i]['products'][$i2]['warehouse_id'] = $getShipping->shipping_method_id == 2 ? null : $orderVendorWarehouse->warehouse_id;
        //             $data['cart']['vendors'][$i]['products'][$i2]['quantity'] = (int)$quantity;
        //         }else{

        //             $isSuccess = false;
        //             $statusCode = 422;
        //             $cartRersponse['message'] =  __('cart.api.some_products_doesnt_have_stock');
        //             $cartRersponse['data'] = [];
        //             $cartRersponse['success'] = $isSuccess;
        //             $cartRersponse['status'] = $statusCode;

        //             return $cartRersponse;

        //         }

        //     }

        // }
        $isSuccess = true;
        $statusCode = 200;
        $this->newSyncCartService($this->getCartServiceGroupedByVendor() , $transaction->customer_id);
        $cartRersponse['data'] = $this->getCartServiceGroupedByVendor($customerId ,  null ,$model_type)['data'];
        $cartRersponse['message'] =  __('cart.api.reorder_successfully');
        $cartRersponse['success'] = $isSuccess;
        $cartRersponse['status'] = $statusCode;
        return $cartRersponse;
    }

    /**
     * @param integer $product_id
     * @param integer $customerId
     * @return array
     */
    public function deleteProductFromCart(int $product_id, int $customerId , $model_type = Client::class): array
    {
        $cart = $this->repository->curretUserCart($customerId , null , $model_type);
        if ($cart) $cart->cartProducts()->where('product_id', $product_id)->delete();
        if($cart->cartProducts()->count() == 0){
            $cart->cartVendorShippings()->delete();
            $cart->delete();
        }
        return $this->getCartProductGroupedByVendor(
            $customerId,
            function () use ($cart , $model_type) {
                return (new OrderProcess($cart, request() , $model_type))
                    ->getCalculatorComponent()
                    ->getTransactionTotalsInHalala();
            }
        , $model_type);
    }

    /**
     * @param array $request
     * @param Cart $cart
     * @param integer $vendor_id
     * @return bool|null
     */
    private function _addProductToCart(array $request, Cart $cart, Product $product): bool|null
    {
        if ($cart == null || $request['quantity'] < 1) return null;

        $cartProduct = $this->repository->createCartProduct($cart, [
            'cart_id' => $cart->id,
            'quantity' => $request['quantity'],
            'vendor_id' => $product->vendor_id,
            'product_id' => $request['product_id'],
            'warehouse_id' => $request['warehouse_id'] ?? null,
            'total_price' => $product->price *  $request['quantity'] ,
            'total_weight' => $product->totalWeightByKilo * $request['quantity'] ?? null
        ]);
        if (!$cartProduct) return false;

        $cart->update([
            'total_weight' => $cart->cartProducts()->sum('total_weight') ,
            'total_price' => $cart->cartProducts()->sum('total_price') ,
            'products_count' => $cart->cartProducts()->sum('quantity') ,
        ]);

        return true;
    }

    /**
     * @param array $request
     * @param CartProduct $cartProduct
     * @param integer $cart_id
     * @param integer $vendor_id
     * @param boolean $append
     * @return bool
     */
    private function _editProductInCart(
        array       $request,
        CartProduct $cartProduct,
        Cart         $cart,
        Product         $product,
        bool        $append = false
    ): bool
    {
        $quantity =$request['quantity'];
        if($append) $quantity+= $cartProduct->quantity;
        $cartProduct = $this->repository->editCartProduct($cartProduct,[
            'cart_id'=>$cart->id,
            'quantity'=>$quantity,
            'city_id'=>request()->city_id ?? null,
            'product_id'=>$request['product_id'],
            'total_price' => $product->price *  $request['quantity'] ,
            'warehouse_id'=>$request['warehouse_id'] ?? null,
            'total_weight' => $product->totalWeightByKilo * $request['quantity'] ?? null,
            'vendor_id'=>$product->vendor_id
        ]);
        $cart->update([
            'total_weight' => $cart->cartProducts()->sum('total_weight') ,
            'total_price' => $cart->cartProducts()->sum('total_price') ,
            'products_count' => $cart->cartProducts()->sum('quantity') ,
        ]);
        return true;
    }

    /**
     * @param array $request
     * @param Cart $cart
     * @param integer $vendor_id
     * @return bool|null
     */
    private function _addServicesToCart($request, Cart $cart)
    {
        if ($cart == null || $request['quantity'] < 1) return null;
        $service =Service::findOrFail($request['service_id']);
        $totalPrice = 0;
        // calc service price
        if($request['service_fields']){
            foreach($request['service_fields'] as $field){
                $price = ServiceField::where('service_id',$request['service_id'])
                ->where('field_name',$field['key'])
                ->where('field_value',$field['value'])
                ->sum('field_price');
                $totalPrice+=$price;
            }
        }
        $cartProduct = $this->repository->createCartProductServices($cart,[
            'cart_id' => $cart->id,
            'quantity' => $request['quantity'],
            'vendor_id' => $service->vendor_id,
            'service_id' => $request['service_id'],
            'total_price' => ($totalPrice * $request['quantity']),
        ]);
        $serviceCartProductCartProduct=CartProduct::where('cart_id',$cart->id)->get();
        foreach($request['service_fields'] as $fields)
        {
            foreach($serviceCartProductCartProduct as $ser){
                CartProductServiceField::create([
                    'cart_product_id' => $ser['id'],
                    'service_id' => $request['service_id'],
                    'key' => $fields['key'],
                    'value' => json_encode($fields['value']),
                    'type' => $fields['type'] ?? "",
                    'price' => $fields['price']
                ]);
            }
        }
        if (!$cartProduct) return false;

        $cart->update([
            // 'total_weight' => $cart->cartProducts()->sum('total_weight') ,
            'total_price' => $cart->cartProducts()->sum('total_price') ,
            'products_count' => $cart->cartProducts()->sum('quantity') ,
        ]);

        return true;
    }

    /**
     * @param array $request
     * @param CartProduct $cartProduct
     * @param integer $cart_id
     * @param integer $vendor_id
     * @param boolean $append
     * @return bool
     */
    private function _editServicesInCart(
        $request,
        CartProduct $cartProduct,
        Cart         $cart,
        bool        $append = false
    )
    {
        $service = Service::findOrFail($request['service_id']);
        $quantity = $request['quantity'];
        if($append) $quantity+= $cartProduct->quantity;
        $totalPrice = 0;
        // calc service price
        // $data = CartProductServiceField::where('service_id',$request['service_id'])->where('cart_product_id',$cartProduct->id)->get();
        if($request['service_fields']){
            foreach($request['service_fields'] as $field){
                $price = ServiceField::where('service_id',$request['service_id'])
                ->where('field_name',$field['key'])
                ->where('field_value',$field['value'])
                ->sum('field_price');
                $totalPrice+=$price;
            }
        }
        $cartProduct = $this->repository->editCartProduct($cartProduct,[
            'cart_id'=>$cart->id,
            'quantity'=>$quantity,
            'city_id'=>request()->city_id ?? null,
            'service_id'=>$request['service_id'],
            'total_price' => ($totalPrice * $quantity) ,
            'warehouse_id'=>$request['warehouse_id'] ?? null,
            // 'total_weight' => $product->totalWeightByKilo * $request['quantity'] ?? null,
            'vendor_id'=>$service->vendor_id
        ]);

        // foreach(request()['service_fields'] as $field){
        //     $fields =CartProductServiceField::create([
        //         'cart_product_id' => $cartProduct->id,
        //         'service_id' => $request['service_id'],
        //         'key' => $field['key'],
        //         'value' => json_encode($field['value']),
        //         'type' => $field['type'] ?? "",
        //         'price' => $field['price']
        //     ]);
        // }
        $cart->update([
            // 'total_weight' => $cart->cartProducts()->sum('total_weight') ,
            'total_price' => $cart->cartProducts()->sum('total_price') ,
            'products_count' => $cart->cartProducts()->sum('quantity') ,
        ]);
        return true;
    }

    public function findCart(int $customerId , $model_type = Client::class){
        if($model_type == Client::class){
            $cart = Cart::where('user_id', $customerId)->first();
            if (!$cart)  return null;
            else if ($cart->is_active != 1) $cart->update(['is_active' => 1]);

        }else{
            $cart = Cart::where('guest_customer_id', $customerId)->first();
            if (!$cart)  return null;
            else if ($cart->is_active != 1) $cart->update(['is_active' => 1]);
        }

        return $cart;
    }
}
