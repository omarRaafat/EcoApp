<?php
namespace App\Services\Order;

class CalculatorComponent {
    private DiscountComponent $discountComponent;
    private LogisticComponent $logisticComponent;

    public function __construct(
        private CartComponent $cartComponent
    ) {}

    public function setDiscountComponent(
        DiscountComponent $discountComponent
    ) : self {
        $this->discountComponent = $discountComponent;
        return $this;
    }

    public function setLogisticComponent(
        LogisticComponent $logisticComponent
    ) : self {
        $this->logisticComponent = $logisticComponent;
        return $this;
    }

    public function getTransactionTotalsInHalala() : array {
        $total_products = $this->cartComponent->cartTotalWithoutVatInHalala();
        $vat_percentage =  $this->cartComponent->firstVatPercentage();
        $percentage = "1.$vat_percentage";
        $vatRate = round($total_products - ($total_products / $percentage),2);
        $cartTotalWithoutVat = $total_products -  $vatRate;
        $deliveryFeesDetails = $this->getDeliveryFees();

        return [
            "products_total" => $cartTotalWithoutVat ,
            "vat_rate" => $vatRate,
            "vat_percentage" => $vat_percentage,
            "delivery_fees" => $deliveryFeesDetails['total_delivery_fees'],
            "delivery_fees_details" => $deliveryFeesDetails,
            "discount" => isset($this->discountComponent) ? $this->discountComponent->getDiscount() : 0,
        ];
    }

    public function getVendorTotalsInHalala(int $vendorId) : array {
        $cartTotalVatInHalala = $this->cartComponent->vendorCartTotalVatInHalala($vendorId);
        $cartTotalWihtoutVatInHalala = $this->cartComponent->vendorCartTotalWithoutVatInHalala($vendorId);

        $deliveryFees = $this->cartComponent->getCart()->cartVendorShippings()->where('vendor_id' ,$vendorId )->first()?->total_shipping_fees ?? 0;

        return [
            "products_total" => $cartTotalWihtoutVatInHalala,
            "vat_rate" => $cartTotalVatInHalala,
            "vat_percentage" => $this->cartComponent->firstVatPercentage(),
            "delivery_fees" => $deliveryFees,
            "discount" => isset($this->discountComponent) ? $this->discountComponent->getDiscount() : 0,
        ];
    }

    private function getDeliveryFees() : array {
        $deliveryFeesDetails = [
            'total_delivery_fees' => 0,
            'cod_collect' => 0,
            'packaging' => 0,
            'extra_weight' => 0,
        ];

        if(isset($this->logisticComponent)) {
            $deliveryFeesDetails = [
                'total_delivery_fees' => $this->logisticComponent->getDeliveryFeesInHalala(),
                'cod_collect' => $this->logisticComponent->getCodCollectFeesInHalala(),
                'packaging' => $this->logisticComponent->getPackagingPriceInHalala(),
                'extra_weight' => $this->logisticComponent->getExtraWeightDeliveryInHalala(),
            ];
        }

        return $deliveryFeesDetails;
    }
}
