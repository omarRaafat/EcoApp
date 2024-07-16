<?php

namespace App\Models;

use App\Enums\AdminApprovedState;
use App\Models\{User, Vendor};
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Services\Eportal\Connection;

class UserVendorRate extends BaseModel
{
    use SoftDeletes;

    // new filter relation
    const ALLOWED_FILTER_RELATION = ['customer', 'vendor', 'admin', 'client'];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        "user_id",
        "vendor_id",
        "rate",
        "admin_id",
        "admin_comment",
        "admin_approved",
        "transaction_id"
    ];



    public function scopeApproved($query)
    {
        return $query->where('admin_approved', AdminApprovedState::APPROVED);
    }
    
    /**
     * Return the user(customer) that own this rate.
     *
     * @return BelongsTo
     */
    public function customer() : BelongsTo
    {
        return $this->belongsTo(User::class, "user_id")->where("type", "customer");
    }

    /**
     * Return the vendor that associated with this rate.
     *
     * @return BelongsTo
     */
    public function vendor() : BelongsTo
    {
        return $this->belongsTo(Vendor::class, "vendor_id");
    }

    /**
     * Return the user(customer) that own this rate.
     *
     * @return BelongsTo
     */
    public function admin() : BelongsTo
    {
        return $this->belongsTo(User::class, "admin_id");
    }

    public function transaction() {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function client(){
        return $this->belongsTo(Client::class, 'user_id')->withDefault();
     }

    public function scopeFilterPeriod($query){
        $query->when(request()->get('from') && request()->get('to'),function($qr){
            $qr->whereBetween('created_at', [request()->get('from'), request()->get('to')]);        
        });
    }
    
    
    public function scopeFilterAvgRating($query){
        $query->when(request()->get('avgRatingFrom') && request()->get('avgRatingTo'),function($qr){
            $qr->whereRaw('rate BETWEEN ? AND ?', [request()->get('avgRatingFrom'), request()->get('avgRatingTo')]);        
        });
    }
}
