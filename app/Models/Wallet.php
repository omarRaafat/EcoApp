<?php

namespace App\Models;

use App\Models\User;
use Spatie\MediaLibrary\HasMedia;
use App\Models\WalletTransactionHistory;
use App\Traits\ActiveScope;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wallet extends BaseModel implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, ActiveScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        "customer_id",
        "admin_id",
        "is_active",
        "amount",
        "reason"
    ];

    /**
     * Array Of Custom Attributes.
     *
     * @var array
     */
    public $appends = [
        "amount_with_sar",
        "is_has_attachment",
        "attachment_url"
    ];

    /**
     * Return the user(customer) that own this wallet.
     *
     * @return BelongsTo
     */
    public function customer() : BelongsTo
    {
        return $this->belongsTo(Client::class, "customer_id"); //->where("type", "customer");
    }

    /**
     * Return the admin that create this wallet.
     *
     * @return BelongsTo
     */
    public function admin() : BelongsTo
    {
        return $this->belongsTo(User::class, "admin_id")->where("type", "admin");
    }

    /**
     * Get list of all wallets transactions.
     *
     * @return HasMany
     */
    public function transactions() : HasMany
    {
        return $this->hasMany(WalletTransactionHistory::class);
    }

    /**
     * Get the wallet amount with SAR by convert the halal to rial.
     *
     * @return float
     */
    public function getAmountWithSarAttribute() : float
    {
        return $this->amount / 100;
    }

    /**
     * Check if this wallet has attachment.
     *
     * @return bool
     */
    public function getIsHasAttachmentAttribute() : bool
    {
        return $this->media->count() > 0 ?? true;
    }

    /**
     * Get the attachment full url.
     *
     * @return string
     */
    public function getAttachmentUrlAttribute() : string
    {
        return $this->media->count() > 0 ? $this->media->first()->getFullUrl() : "#";
    }

    /**
     * Interact with the wallet amount.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function amount(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value * 100
        );
    }

    /**
     * Active Wallets Count.
     *
     * @return self
     */
    public static function activeWalletsCount()
    {
        return self::where('is_active', true)->count();
    }

    /**
     * Inctive Wallets Count.
     *
     * @return self
     */
    public static function inactiveWalletsCount()
    {
        return self::where('is_active', false)->count();
    }

    public function scopeCustomer(Builder $query ,int $customerId) {
        return $query->where('customer_id', '=', $customerId);
    }
}
