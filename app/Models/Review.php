<?php

namespace App\Models;

use App\Enums\AdminApprovedState;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Services\Eportal\Connection;

class Review extends BaseModel
{
    const ALLOWED_FILTER_RELATION = ['user', 'product'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "rate",
        "comment",
        "user_id",
        "product_id",
        "reason",
        "admin_id",
        "admin_comment",
        "admin_approved",
        "reporting",
        "transaction_id"
    ];

    public function scopeApproved($query)
    {
        return $query->where('admin_approved', AdminApprovedState::APPROVED);
    }
    /**
     * Get The Customer That Make This Rate.
     *
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(Client::class,'user_id'); // where("type", "customer");
    }

    /**
     * Get The adminThat Approved This Rate.
     *
     * @return BelongsTo
     */
    public function admin() : BelongsTo
    {
        return $this->belongsTo(User::class,'admin_id')->where("type", "admin");
    }

    /**
     * Get The Product.
     *
     * @return BelongsTo
     */
    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function transaction() {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function scopeCustomer(Builder $query, int $customerId) : Builder
    {
        return $query->where('user_id', $customerId);
    }

    public function scopeTransaction(Builder $query, int $transactionId) : Builder
    {
        return $query->where('transaction_id', $transactionId);
    }

    public function getCustomerFromPortal(){
        // dd('ww');
        return Connection::getInfoOfUser($this->user_id , config('app.eportal_url') . 'profileById') ;
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
