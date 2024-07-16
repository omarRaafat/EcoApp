<?php

namespace App\Services\Order;

use App\Enums\PaymentMethods;
use App\Enums\ShippingMethodType;
use App\Models\Address;
use App\Models\City;
use App\Models\ShippingMethod;

class LogisticComponent
{
    private $address = null;
    private City $city;
    private ShippingMethod $shippingMethod;
    private float $cartTotalWeightInGram;
    private int $cartProductsQnt;
    private int $paymentId;

    /* public function __construct(
         Address $address,
         float $cartTotalWeightInGram,
         int $shippingMethodId = null,
         int $paymentId = null,
         int $cartProductsQnt = null,
     ) {
         $this->address = $address->load(['city', 'country.warehouseCountry.warehouse']);
         $this->cartTotalWeightInGram = $cartTotalWeightInGram;
         if ($shippingMethodId) $this->setShippingMethodById($shippingMethodId);
         if ($cartProductsQnt) $this->cartProductsQnt = $cartProductsQnt;
         if ($paymentId) $this->paymentId = $paymentId;
     }*/


    public function __construct(City $city , float $cartTotalWeightInGram, int $shippingMethodId = null, int $paymentId = null, int $cartProductsQnt = null)
    {

        $this->city = $city;
         //$this->address = $address;
        $this->cartTotalWeightInGram = $cartTotalWeightInGram;
        if ($shippingMethodId) $this->setShippingMethodById($shippingMethodId);

        if ($cartProductsQnt) $this->cartProductsQnt = $cartProductsQnt;
        if ($paymentId) $this->paymentId = $paymentId;

    }

    public function getAddress(): City
    {
        return $this->city;
    }

    // public function getCity(): City
    // {
    //     return $this->getCity();
    // }

    public function getShippingMethod(): ShippingMethod|null
    {
        return isset($this->shippingMethod) ? $this->shippingMethod : null;
    }

    public function isAddressValidForDelivery(): bool
    {


        if (isset($this->shippingMethod)) {
            if ($this->address->is_international) {
                $this->shippingMethod->load('domesticZones');

                return $this->shippingMethod?->domesticZones?->first()?->countries?->isNotEmpty() ?? false;
            }
            return $this->shippingMethod?->domesticZones?->first()?->cities?->isNotEmpty() ?? false;
        }

        return true;
    }

    public function addressDoesntMatchCountryCode(string $countryCode): bool
    {

        return $this->city->area->country && $this->city->area->country->code != $countryCode;
    }

    public function getDeliveryFeesInHalala(): float
    {
        return $this->getBaseDeliveryFeesInHalala() +
            $this->getCodCollectFeesInHalala() +
            $this->getPackagingPriceInHalala() +
            $this->getExtraWeightDeliveryInHalala();
    }

    public function getPackagingPriceInHalala(): float
    {
        if (!isset($this->cartProductsQnt)) return 0;
        $packagingPrice = $this->address->country->warehouseCountry->warehouse->package_price_halala ?? 0;
        $additionUnitPrice = $this->address->country->warehouseCountry->warehouse->additional_unit_price_halala ?? 0;
        $coveredQnt = $this->address->country->warehouseCountry->warehouse->package_covered_quantity ?? 0;

        if ($this->cartProductsQnt - $coveredQnt <= 0) return $packagingPrice;

        return $packagingPrice + (($this->cartProductsQnt - $coveredQnt) * $additionUnitPrice);
    }

    public function getExtraWeightDeliveryInHalala(): float
    {
        if (!isset($this->shippingMethod)) return 0;
        $domesticZone = $this->shippingMethod->domesticZones?->first();

        if ($domesticZone && $domesticZone->type == ShippingMethodType::NATIONAL) {
            $baseWeightInGram = $domesticZone->delivery_fees_covered_kilos * 1000;
            $extraWeightDeliveryForKilo = $domesticZone->additional_kilo_price;

            if ($this->cartTotalWeightInGram - $baseWeightInGram > 0) {
                return ceil(($this->cartTotalWeightInGram - $baseWeightInGram) / 1000) * $extraWeightDeliveryForKilo * 100;
            }
        }

        return 0;
    }

    public function getBaseDeliveryFeesInHalala(): float
    {
        if (!isset($this->shippingMethod)) return 0;
        if ($domesticZone = $this->shippingMethod->domesticZones?->first()) {
            switch ($domesticZone->type) {
                case ShippingMethodType::INTERNATIONAL:
                    return $domesticZone->deliveryFeeses?->first()?->delivery_fees_in_halala ?? 0;
                case ShippingMethodType::NATIONAL:
                    return $domesticZone->delivery_fees_in_halala ?? 0;
            }
        }

        return 0;
    }

    public function getCodCollectFeesInHalala(): float
    {
        if (isset($this->shippingMethod) && isset($this->paymentId)) {
            return $this->paymentId == PaymentMethods::CASH ? $this->shippingMethod->cod_collect_fees_in_halala : 0;
        }
        return 0;
    }

    private function setShippingMethodById(int $shippingMethodId)
    {

        if (!is_null($this->address)) {
            $cartProductsWeightInKilo = $this->cartTotalWeightInGram / 1000;
            $this->shippingMethod = ShippingMethod::with([
                'domesticZones' => function ($domesticQuery) use ($cartProductsWeightInKilo) {
                    $domesticQuery->with([
                        "deliveryFeeses" => fn($q) => $q->where("weight_from", "<=", $cartProductsWeightInKilo)
                            ->where("weight_to", ">=", $cartProductsWeightInKilo)
                    ])
                        ->when(
                            $this->address->is_international,
                            fn($internationalQ) => $internationalQ->wherehas(
                                'countries',
                                fn($country) => $country->where('countries.id', $this->address->country_id)
                            )
                        )
                        ->when(
                            !$this->address->is_international,
                            fn($internationalQ) => $internationalQ->wherehas(
                                'cities',
                                fn($city) => $city->where('cities.id', $this->address->city_id)
                            )
                        );
                }
            ])
                ->find($shippingMethodId);
            return $this;
        }

    }
}
