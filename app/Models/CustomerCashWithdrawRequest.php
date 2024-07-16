<?php

namespace App\Models;

use App\Models\Bank;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerCashWithdrawRequest extends BaseModel
{
    use SoftDeletes;

    const imagesPath = "public/customers/cash-withdraw-requests";

    protected $fillable = [
        'customer_id', 'admin_id', 'admin_action', 'bank_receipt', 'reject_reason',
        'bank_id', 'amount', 'bank_account_name', 'bank_account_iban',
    ];

    public function customer()
    {
        return $this->belongsTo(Client::class, 'customer_id'); //->where('type', 'customer');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id')->where('type', 'admin');
    }

    public function SetBankReceiptAttribute($file)
    {
        $name = null;
        if (is_file($file)) {
            $name = Str::random(8) ."-receipt-$this->id-$this->customer_id-". Str::random(8) .".{$file->getClientOriginalExtension()}";
            $file->storeAs(self::imagesPath, $name);
        }
        return $this->attributes['bank_receipt'] = $name;
    }

    public function getReceiptUrl() {
        return Storage::url(self::imagesPath."/{$this->bank_receipt}");
    }

    /**
     * Get the bank assossiated to this customer.
     */
    public function bank() : BelongsTo
    {
        return $this->belongsTo(Bank::class, "bank_id");
    }
}
