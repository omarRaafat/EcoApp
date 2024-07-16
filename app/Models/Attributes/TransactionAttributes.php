<?php
namespace App\Models\Attributes;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait TransactionAttributes {
    public function subTotalInSar() : Attribute {
        return Attribute::make(
            get: fn() => $this->sub_total / 100
        );
    }

    public function totalVatInSar() : Attribute {
        return Attribute::make(
            get: fn() => $this->total_vat / 100
        );
    }

    public function totalInSar() : Attribute {
        return Attribute::make(
            get: fn() => ($this->total + $this->total_vat) / 100
        );
    }

    public function deliveryFeesInSar() : Attribute {
        return Attribute::make(
            get: fn() => $this->delivery_fees / 100
        );
    }

    public function subTotalInSarRounded() : Attribute {
        return Attribute::make(
            get: fn() => number_format($this->sub_total_in_sar, 2)
        );
    }

    public function totalVatInSarRounded() : Attribute {
        return Attribute::make(
            get: fn() => number_format($this->total_vat_in_sar, 2)
        );
    }

    public function totalInSarRounded() : Attribute {
        return Attribute::make(
            get: fn() => number_format($this->total_in_sar, 2)
        );
    }

    public function deliveryFeesInSarRounded() : Attribute {
        return Attribute::make(
            get: fn() => number_format($this->delivery_fees_in_sar, 2)
        );
    }

    public function totalAmount() : Attribute {
        return Attribute::make(
            get: fn() => ($this->sub_total + $this->total_vat + $this->delivery_fees - $this->discount) / 100
        );
    }

    public function totalAmountRounded() : Attribute {
        return Attribute::make(
            get: fn() => number_format($this->total_amount, 2)
        );
    }

    public function reminderInSar() : Attribute {
        return Attribute::make(
            get: fn() => $this->reminder / 100
        );
    }

    public function discountInSar() : Attribute {
        return Attribute::make(
            get: fn() => $this->discount / 100
        );
    }

    public function discountInSarRounded() : Attribute {
        return Attribute::make(
            get: fn() => number_format($this->discount_in_sar, 2)
        );
    }

    public function InvUrl() : Attribute {
        return Attribute::make(
            get: function() {
                return !empty($this->media()->first()) ? $this->media()->first()->getFullUrl() : "";
            }
        );
    }

    public function subTotalWithVatInSar() : Attribute {
        return Attribute::make(
            get: fn() => ($this->sub_total + $this->total_vat) / 100
        );
    }

    public function subTotalWithVatInSarRounded() : Attribute {
        return Attribute::make(
            get: fn() => number_format($this->sub_total_with_vat_in_sar, 2)
        );
    }

    public function vatRate() : Attribute {
        return Attribute::make(
            get: fn() => ($this->total_vat)/100
        );
    }
    public function vatRateRounded() : Attribute {
        return Attribute::make(
            get: fn() => number_format($this->vat_rate, 2)
        );
    }

    public function walletDeductionInSarRounded() : Attribute {
        return Attribute::make(
            get: fn() => number_format($this->wallet_deduction / 100, 2)
        );
    }

    public function subTotalAndDeliveryFeesSar() : Attribute {
        return Attribute::make(
            get: fn() => ($this->sub_total + $this->delivery_fees) / 100
        );
    }

    public function subTotalAndDeliveryFeesSarRounded() : Attribute {
        return Attribute::make(
            get: fn() => number_format($this->sub_total_and_delivery_fees_sar, 2)
        );
    }

    public function totalWithoutVatInSar() : Attribute {
        return Attribute::make(
            get: fn() => ($this->sub_total + $this->delivery_fees - $this->discount) / 100
        );
    }

    public function totalWithoutVatInSarRounded() : Attribute {
        return Attribute::make(
            get: fn() => number_format($this->total_without_vat_in_sar, 2)
        );
    }

    // public function baseDeliveryFees() : Attribute {
    //     return $this->base_delivery_fees;
    // }

    public function codCollectFees() : Attribute {
        return Attribute::make(
            get: fn($v) => $v ? $v / 100 : null,
            set: fn($v) => $v ? $v * 100 : null,
        );
    }

    public function packagingFees() : Attribute {
        return Attribute::make(
            get: fn($v) => $v ? $v / 100 : null,
            set: fn($v) => $v ? $v * 100 : null,
        );
    }

    // public function extraWeightFees() : Attribute {
    //     return $this->extra_weight_fees;

    // }

    public function totalWeightInKilo() : Attribute {
        return Attribute::make(
            get: function() {
                return $this->orders->sum(function($o) {
                    return $o->orderProducts->sum("weight_with_kilo");
                });
            }
        );
    }

    public function totalQuantities() : Attribute {
        return Attribute::make(
            get: function() {
                return $this->orders->sum(function($o) {
                    return $o->orderProducts->sum("quantity");
                });
            }
        );
    }
}
