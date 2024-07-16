<?php

namespace App\Services\Order;

use App\Enums\ClientMessageEnum;
use App\Enums\CouponType;
use App\Models\Address;
use App\Models\Cart;
use App\Models\City;
use App\Models\ClientMessage;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\GuestCustomer;
use App\Models\User;
use App\Services\ClientMessageService;
use App\Services\Order\Contracts\OrderResponseInterface;
use App\Services\Product\StockDecrement;
use App\Services\SendSms;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Client;

class OrderProcess
{
    private CartComponent $cartComponent;

    private int $shippingMethodId;
    private int $paymentId;
    private int $cityId;
    private bool $usingWallet;
    private Coupon|null $coupon;
    private Address|null $address;
    private City|null $city;
    private LogisticComponent $logisticComponent;
    private DiscountComponent $discountComponent;
    private CalculatorComponent $calculatorComponent;
    private $model_type;

    public function __construct(private Cart $cart, private Request $request , $model_type = Client::class)
    {

        $this->cartComponent = new CartComponent($cart);
        $this->model_type = $model_type;
        if(!is_null($cart->city_id)){
            $this->cityId = $cart->city_id;
            $this->city = City::query()->find($cart->city_id);
        }

        $this->coupon = null;
        if ($request->has('coupon_code') && $request->get('coupon_code')) {
            $coupon = Coupon::where("code", $request->get('coupon_code'))->first();
            if ($coupon) $this->coupon = $coupon;
        }

        if ($request->has('payment_id') && $request->get('payment_id')) {
            $this->paymentId = $request->get('payment_id');
        }

        if ($request->has('shipping_id') && $request->get('shipping_id')) {
            $this->shippingMethodId = $request->get('shipping_id');
        }

        $this->usingWallet = $request->get("use_wallet") == 1;
    }

    public function setPaymentId(int $paymentId): self
    {
        $this->paymentId = $paymentId;
        return $this;
    }

    public function getCalculatorComponent(): CalculatorComponent
    {
        if (isset($this->calculatorComponent) && $this->calculatorComponent instanceof CalculatorComponent)
            return $this->calculatorComponent;
        $calculatorComponent = new CalculatorComponent($this->cartComponent);

        if ($logisticComponent = $this->getLogisticComponent()) {
            $calculatorComponent = $calculatorComponent->setLogisticComponent($logisticComponent);
        }

        if ($discountComponent = $this->getDiscountComponent()) {
            $calculatorComponent = $calculatorComponent->setDiscountComponent($discountComponent);
        }

        $this->calculatorComponent = $calculatorComponent;
        return $this->calculatorComponent;
    }

    public function getCartComponent(): CartComponent
    {
        return $this->cartComponent;
    }

    public function getValidationComponent(): ValidationComponent
    {
        $discountComponent = $this->getDiscountComponent();
        $logisticComponent = $this->getLogisticComponent();
        $validation = new ValidationComponent($this->cartComponent);
        if ($this->request->get('coupon_code') != '' && $discountComponent)
            $validation = $validation->setDiscountComponent($discountComponent);
        if ($logisticComponent) $validation = $validation->setLogisticComponent($logisticComponent);
        return $validation;
    }

    /**
     * @return boolean
     * @throws App\Exceptions\Transactions\Coupons\NotExistsException
     * @throws App\Exceptions\Transactions\Coupons\NotStartedException
     * @throws App\Exceptions\Transactions\Coupons\ExpiredException
     * @throws App\Exceptions\Transactions\Coupons\InactiveException
     * @throws App\Exceptions\Transactions\Coupons\MaxUsageException
     * @throws App\Exceptions\Transactions\Coupons\OrderMinimumException
     * @throws App\Exceptions\Transactions\Coupons\DeliveryFeesMinimumException
     */
    public function isDiscountValidToUse(): bool|null
    {
        if (!$this->request->has('coupon_code') || $this->request->get('coupon_code') == '') return null;
        return $this->getDiscountComponent()->isValidToUse();
    }

    public function isLogisticValidToUse(): bool|null
    {
        if (!$this->request->has('address_id')) return null;
        return isset($this->address) && !is_null($this->address) ? $this->getLogisticComponent()->isAddressValidForDelivery() : false;
    }

    public function isAddressMatchCountryHeader(): bool
    {
        return !(isset($this->address) &&
            $this->getLogisticComponent()->addressDoesntMatchCountryCode(Country::getHeaderCountryCode())
        );
    }

    private function getLogisticComponent(): LogisticComponent|null
    {
        if (isset($this->logisticComponent) && $this->logisticComponent instanceof LogisticComponent)
            return $this->logisticComponent;
        if (!isset($this->city) || is_null($this->city)) return null;

        $this->logisticComponent = new LogisticComponent(
            city: $this->city,
            cartTotalWeightInGram: $this->cartComponent->cartTotalWeightInGram(),
            shippingMethodId: isset($this->shippingMethodId) ? $this->shippingMethodId : null,
            paymentId: isset($this->paymentId) ? $this->paymentId : null,
            cartProductsQnt: $this->cartComponent->cartTotalQuantity(),
        );
        return $this->logisticComponent;
    }


//    private function getLogisticComponent(): LogisticComponent|null
//    {
//        dd("ssssss");
//        if (isset($this->logisticComponent) && $this->logisticComponent instanceof LogisticComponent)
//            return $this->logisticComponent;
//        if (!isset($this->city) || is_null($this->city)) return null;
//
//        $this->logisticComponent = new LogisticComponent(
//            //address: $this->address,
//            city: $this->city,
//            cartTotalWeightInGram: $this->cartComponent->cartTotalWeightInGram(),
//            shippingMethodId: isset($this->shippingMethodId) ? $this->shippingMethodId : null,
//            paymentId: isset($this->paymentId) ? $this->paymentId : null,
//            cartProductsQnt: $this->cartComponent->cartTotalQuantity(),
//        );
//
//        return $this->logisticComponent;
//    }

    private function getDiscountComponent(): DiscountComponent|null
    {
        if (isset($this->discountComponent) && $this->discountComponent instanceof DiscountComponent)
            return $this->discountComponent;
        $totalPaidAmountInHalala = 0;

        if (isset($this->coupon) && $this->coupon->coupon_type == CouponType::GLOBAL) {
            $totalPaidAmountInHalala =
                $this->cartComponent->cartTotalVatInHalala() +
                $this->cartComponent->cartTotalWithoutVatInHalala() +
                ($this->getLogisticComponent()?->getDeliveryFeesInHalala() ?? 0);
        } else if (isset($this->coupon) && $this->coupon->coupon_type == CouponType::FREE) {
            $totalPaidAmountInHalala = $this->getLogisticComponent()?->getDeliveryFeesInHalala() ?? 0;
        }

        $this->discountComponent = new DiscountComponent(
            coupon: isset($this->coupon) ? $this->coupon : null,
            totalPaidAmountInHalala: $totalPaidAmountInHalala,
            customerId: $this->cartComponent->getCustomer($this->model_type)?->id
        );
        return $this->discountComponent;
    }
}
