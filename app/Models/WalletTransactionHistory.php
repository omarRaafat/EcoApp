<?php

namespace App\Models;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Models\Audit;

class WalletTransactionHistory extends BaseModel
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        "customer_id",
        "wallet_id",
        "type",
        "amount",
        "is_opening_balance",
        "transaction_type",
        "user_id"
    ];

    /**
     * Load relationships when the model is loaded using eager loading.
     *
     * @var array
     */
    public $with = [
        "customer",
        "wallet"
    ];

    /**
     * Return the user(customer) that own this transaction record.
     *
     * @return BelongsTo
     */
    public function customer() : BelongsTo
    {
        return $this->belongsTo(Client::class, "customer_id"); //->where("type", "customer");
    }

    /**
     * Return the user(customer,admin) that request this transaction.
     *
     * @return BelongsTo
     */
    public function userDoTransaction() : BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }


    /**
     * Return the user(customer,admin) that request this transaction.
     *
     * @return BelongsTo
     */
    public function created_by() : HasOne
    {
        return $this->hasOne(Audit::class, "auditable_id")->where('auditable_type', WalletTransactionHistory::class);
    }


    /**
     * Return the wallet assossiated with this transaction record.
     *
     * @return BelongsTo
     */
    public function wallet() : BelongsTo
    {
        return $this->belongsTo(Wallet::class, "wallet_id");
    }

    /**
     * Interact with the wallet transaction history amount.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function amount(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value 
        );
    }

    public function amountWithSar() : Attribute {
        return Attribute::make(
            get: fn ($v) => $this->amount
        );
    }
}
