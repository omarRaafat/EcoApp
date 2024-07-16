<?php
namespace App\Services\Api;

class Calculation {
    private float $vat;
    private float $subTotal;
    private float $vatRate;
    private float $deliveryFees;
    private float $discount;

    public function __construct(
        private float $total,
        private float $vatPercentage,
        private float $deliveryAmount = 0,
    ) {
        $this->vat = 1 + ($vatPercentage * 0.01);
        $this->subTotal = 0;
        $this->vatRate = $total - ($total * (1 / $this->vat));
        $this->deliveryFees = $deliveryAmount;
        $this->discount = 0;
    }

    public static function calculate($total, $vatPercentage, $deliveryFees = 0) : self {
        $object = new self($total, $vatPercentage,$deliveryFees);

        $object->subTotal = $object->total - $object->vatRate ;
        $object->deliveryFees = $deliveryFees;
        $object->discount = 0;
        $object->total = $total + $deliveryFees;
        return $object;
    }

    public function asArray() : array {
        return [
            'total_vat' => $this->vatRate,
            'sub_total' => $this->subTotal,
            'total' => $this->total,
            'total_without_vat' => $this->subTotal,
            'vat_rate' => $this->vatRate,
            'vat_percentage' => $this->vatPercentage,
            'delivery_fees' => $this->deliveryFees,
            'discount' => $this->discount,
        ];
    }
}