<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\State\InvoiceState\InvoiceState;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\ModelStates\HasStates;

class Invoice extends BaseModel
{
    use HasStates;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'period_start_at' => 'date',
        'period_end_at' => 'date',
        'vendor_data' => 'array',
        'center_data' => 'array',
        'total_without_vat' => MoneyCast::class,
        'vat_amount' => MoneyCast::class,
        'total_with_vat' => MoneyCast::class,
        'status' => InvoiceState::class
    ];

    protected $fillable = [
        'vendor_id',
        'number',
        'period_start_at',
        'period_end_at',
        'vendor_data',
        'total_without_vat',
        'vat_percentage',
        'vat_amount',
        'total_with_vat',
    ];

    protected static function booted()
    {
        static::creating(function (self $invoice) {
            $invoice->uuid = Str::uuid();
        });
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function invoiceLines(): HasMany
    {
        return $this->hasMany(InvoiceLine::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function getQrCode()
    {
        return str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', $this->setQrCode());
    }

    public function setQrCode(): string
    {
        $taxNumber = "310876568300003";
        $created_at = $this->created_at->format('Y-m-d\TH:i:s');
        $totalAmount = $this->total_with_vat;
        $taxAmount = $this->vat_amount;

        $vendorName = "المركز الوطني للنخيل والتمور";

        $qrData = chr(1);
        $qrData .= chr(strlen($vendorName));
        $qrData .= $vendorName;
        $qrData .= chr(2);
        $qrData .= chr(strlen("$taxNumber"));
        $qrData .= "$taxNumber";
        $qrData .= chr(3);
        $qrData .= chr(strlen("$created_at"));
        $qrData .= "$created_at";
        $qrData .= chr(4);
        $qrData .= chr(strlen(round($totalAmount, 2)));
        $qrData .= round($totalAmount, 2);
        $qrData .= chr(5);
        $qrData .= chr(strlen(round($taxAmount, 2)));
        $qrData .= round($taxAmount, 2);

        $qrData = base64_encode($qrData);

        $qrCode = QrCode::encoding('UTF-8')->format('svg')->size(125)->generate($qrData);

        return $qrCode;
    }
}
