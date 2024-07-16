<?php

namespace App\Models;

use App\Models\Vendor;
use Spatie\Translatable\HasTranslations;
use App\Models\CustomerCashWithdrawRequest;
use App\Traits\ActiveScope;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bank extends BaseModel
{
    use HasTranslations ,SoftDeletes ,ActiveScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'swift_code',
        'is_active'
    ];

    /**
     * The attributes that needs to be translated.
     *
     * @var array
     */
    public $translatable = ['name'];

    /**
     * Get List of vendors assossiated to this bank.
     */
    public function vendor() : HasMany
    {
        return $this->hasMany(Vendor::class);
    }

    /**
     * Get List of customers assossiated to this bank.
     */
    public function cashWithDrowRequest() : HasMany
    {
        return $this->hasMany(CustomerCashWithdrawRequest::class);
    }
}
