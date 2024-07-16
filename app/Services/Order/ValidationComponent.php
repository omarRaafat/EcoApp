<?php

namespace App\Services\Order;

use App\Exceptions\Transactions\PlaceOrderBusinessException;
use App\Http\Resources\Api\CartResource;
use App\Models\Country;
use Exception;

class ValidationComponent
{
    private DiscountComponent $discountComponent;
    private LogisticComponent $logisticComponent;

    public function __construct(
        private CartComponent $cartComponent
    )
    {
    }

    public function setDiscountComponent(
        DiscountComponent $discountComponent
    ): self
    {
        $this->discountComponent = $discountComponent;
        return $this;
    }

    public function setLogisticComponent(
        LogisticComponent $logisticComponent
    ): self
    {
        $this->logisticComponent = $logisticComponent;
        return $this;
    }

    public function validate()
    {
        $discountMessage = $this->validateDiscount();

        $logisticMessage = $this->validateLogistic();

         $cartMessage = $this->validateCart();



        $cart = $this->cartComponent->getCart();

        $cart->wallet_amount = $cart?->user?->ownWallet?->amount_with_sar ?? 0;
        $calc = new CalculatorComponent($this->cartComponent);
        if (isset($this->discountComponent)) $calc = $calc->setDiscountComponent($this->discountComponent);
        if (isset($this->logisticComponent)) $calc = $calc->setLogisticComponent($this->logisticComponent);
        $cart->totals = $calc->getTransactionTotalsInHalala();


//        dd($cartMessage , $this->logisticComponent);
//        if ($cartMessage == "" && isset($this->logisticComponent)) {
//            $transactionTotal = $cart->totals['products_total'] + $cart->totals['vat_rate'] + $cart->totals['delivery_fees'] - $cart->totals['discount'];
//            $transactionTotal = $transactionTotal / 100;
//            $transactionWeight = $this->cartComponent->cartTotalWeightInGram() / 1000;
//
//
//            $address = $this->logisticComponent->getAddress();
//
//            if (
//                $address &&
//               /* $address->is_international &&*/
//                $address->area->country &&
//                $address->area->country->maximum_order_weight &&
//                $address->area->country->minimum_order_weight &&
//                $address->area->country->maximum_order_total
//            ) {
//                if (
//                    $transactionWeight < $address->area->country->minimum_order_weight ||
//                    $transactionWeight > $address->area->country->maximum_order_weight
//                ) {
//                    $cartMessage = __("cart.api.internationl-order.out-of-weight-range", [
//                        'weightFrom' => $address->area->country->minimum_order_weight,
//                        'weightTo' => $address->area->country->maximum_order_weight,
//                    ]);
//                } else if ($transactionTotal > $address->area->country->maximum_order_total) {
//                    $cartMessage = __("cart.api.internationl-order.maximum-amount", [
//                        'amount' => $address->area->country->maximum_order_total
//                    ]);
//                }
//
//
//            }
//        }
//
//        if ($discountMessage != "" || $logisticMessage != "" || $cartMessage != "") {
//
//            throw (new PlaceOrderBusinessException(__('cart.api.cart_wrong')))
//                ->setCartResource(new CartResource($cart))
//                ->setMessages([
//                    "coupon_message" => $discountMessage ? $discountMessage : "",
//                    "address_message" => $logisticMessage ? $logisticMessage : "",
//                    "message" => $cartMessage ? $cartMessage : __('cart.api.cart_wrong'),
//                ]);
//        }
//

    }

    private function validateDiscount(): string
    {
        if (isset($this->discountComponent)) {
            try {
                $this->discountComponent->isValidToUse();
                return "";
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
        return "";
    }

    private function validateLogistic(): string
    {

        if (isset($this->logisticComponent) && (!$this->logisticComponent->isAddressValidForDelivery() || $this->logisticComponent->addressDoesntMatchCountryCode(Country::getHeaderCountryCode()))) {
            return __("cart.api.address-out-of-coverage");
        }
        return "";
    }

    private function validateCart(): string
    {
        if ($this->cartComponent->isCartEmpty()) {
            return __("cart.api.cart_is_empty");
        }

        if (!$this->cartComponent->isProductsAvailable()) {
            return __("cart.api.cannot_checkout_product_missing");
        }

        if (!$this->cartComponent->isProductsHasStock()) {
            return __("cart.api.cannot_checkout_product_missing");
        }

        $missedProducts = $this->cartComponent->cartProductsMissedPrice();
        if ($missedProducts->isNotEmpty()) {
            return __("cart.api.product-missed-country", ['products' => $missedProducts->implode('name', ",")]);
        }
        return "";
    }
}
