<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderProduct extends BaseModel
{
    protected $fillable=[ 'order_id','product_id','total','quantity','unit_price', 'vat_percentage', 'discount'];

    public $appends = ["weight_with_kilo"];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order() : BelongsTo {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Get Total Weight and convert it to kilo.
     */
    public function getWeightWithKiloAttribute()
    {
        return $this->product->total_weight / 1000;
    }

    public function totalInSar() : Attribute {
        return Attribute::make(
            get: fn() => $this->total / 100
        );
    }

    public function unitPriceInSar() : Attribute {
        return Attribute::make(
            get: fn() => $this->unit_price / 100
        );
    }

    public function totalWithoutVatInSar() : Attribute {
        $totalWithoutVat = ($this->total / (1 + ($this->vat_percentage * 0.01)));
        return Attribute::make(
            get: fn() => $totalWithoutVat / 100
        );
    }

    public function vatRateInSar() : Attribute {
        $vatRate = $this->total - $this->total / (1 + ($this->vat_percentage * 0.01));
        return Attribute::make(
            get: fn() => $vatRate / 100
        );
    }

    public function totalInSarRounded() : Attribute {
        return Attribute::make(
            get: fn() => number_format($this->total_in_sar, 2)
        );
    }

    public function unitPriceInSarRounded() : Attribute {
        return Attribute::make(
            get: fn() => number_format($this->unit_price_in_sar, 2)
        );
    }

    public function totalWithoutVatInSarRounded() : Attribute {
        return Attribute::make(
            get: fn() => number_format($this->total_without_vat_in_sar, 2)
        );
    }

    public function vatRateInSarRounded() : Attribute {
        return Attribute::make(
            get: fn() => number_format($this->vat_rate_in_sar, 2)
        );
    }

    public function priceWithoutVatInSarRounded() : Attribute {
        return Attribute::make(
            get: fn() => number_format(($this->unit_price / (1 + ($this->vat_percentage * 0.01))) / 100, 2)
        );
    }
}
