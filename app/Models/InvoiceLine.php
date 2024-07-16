<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceLine extends BaseModel
{
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'quantity' => 'integer',
        'vat_percentage' => 'double',
        'unit_price' => MoneyCast::class,
        'total_without_vat' => MoneyCast::class,
        'vat_amount' => MoneyCast::class,
        'total_with_vat' => MoneyCast::class
    ];

    protected $fillable = [
        'description',
        'unit_price',
        'quantity',
        'vat_percentage',
        'total_without_vat',
        'vat_amount',
        'total_with_vat',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
