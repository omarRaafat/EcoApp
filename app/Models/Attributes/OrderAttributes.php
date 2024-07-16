<?php
namespace App\Models\Attributes;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait OrderAttributes
{
    public function totalInSar() :Attribute
    {
        return Attribute::make(
            get: fn () => ($this->sub_total + $this->vat) / 100
        );
    }

    public function subTotalInSar() : Attribute {
        return Attribute::make(
            get: fn() => $this->sub_total / 100
        );
    }

    public function subTotalInSarRounded() : Attribute {
        return Attribute::make(
            get: fn() => $this->sub_total / 100
        );
    }

    public function deliveryFeesInSarRounded() : Attribute {
        return Attribute::make(
            get: fn() => $this->delivery_fees_in_sar
        );
    }

    public function totalInSarRounded() : Attribute {
        return Attribute::make(
            get: fn() => $this->total_in_sar
        );
    }

    public function vatInSar() : Attribute {
        return Attribute::make(
            get: fn() => $this->vat / 100
        );
    }

    public function vatInSarRounded() : Attribute {
        return Attribute::make(
            get: fn() => $this->vat_in_sar
        );
    }

    public function deliveredAt() : Attribute {
        return Attribute::make(
            get: fn($v) => $v ? Carbon::parse($v) : $this->updated_at,
            set: fn($v) => $v,
        );
    }

    public function companyProfitInSar() : Attribute {
        return Attribute::make(
            get: fn() => $this->company_profit / 100,
        );
    }

    public function companyProfitInSarRounded() : Attribute {
        return Attribute::make(
            get: fn() => $this->company_profit_in_sar,
        );
    }

    public function companyProfitVatRate() : Attribute {
        return Attribute::make(
            get: fn() =>  number_format( ($this->company_profit - ($this->company_profit * (1 / (1 + $this->vat_percentage / 100)))) / 100, 2 ,'.',''),
        );
    }

    public function companyProfitVatRateRounded() : Attribute {
        return Attribute::make(
            get: fn() => $this->company_profit_vat_rate,
        );
    }

    public function companyProfitWithoutVatInSar() : Attribute {
        return Attribute::make(
            get: fn() => $this->company_profit_in_sar - $this->company_profit_vat_rate,
        );
    }

    public function companyProfitWithoutVatInSarRounded() : Attribute {
        return Attribute::make(
            get: fn() => $this->company_profit_without_vat_in_sar,
        );
    }

    public function vendorAmountInSar() : Attribute {
        return Attribute::make(
            get: fn() => ($this->vendor_amount / 100),
        );
    }

    public function vendorAmountInSarRounded() : Attribute {
        return Attribute::make(
            get: fn() => $this->vendor_amount_in_sar,
        );
    }

    public function discountInSar() :Attribute
    {
        return Attribute::make(
            get: fn () => $this->discount / 100
        );
    }

    public function discountInSarRounded() :Attribute
    {
        return Attribute::make(
            get: fn () => number_format($this->discount_in_sar, 2)
        );
    }


    public function getShippingFeesByVendor(int $vendor_id){
        return number_format(($this->orderVendorShippings()->where('vendor_id',  $vendor_id)->first()?->total_shipping_fees  / 100), 2);
    }
}
