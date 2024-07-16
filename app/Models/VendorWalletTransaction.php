<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpParser\Node\Expr\Instanceof_;

class VendorWalletTransaction extends BaseModel  implements HasMedia
{
    use InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'wallet_id', 'amount', 'operation_type', 'admin_id', 'receipt_url', 'reference', 'reference_id','status', 'reference_num','reason'
    ];

    public $appends = ["attachment_url"];

    public function wallet() {
        return $this->belongsTo(VendorWallet::class, 'wallet_id');
    }

    public function admin() {
        return $this->belongsTo(User::class, 'admin_id')->whereIn('type', ['admin','sub-admin']);
    }

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            $wallet = $model->wallet;
            if ($model->operation_type == 'out') {
                $wallet->balance -= $model->amount;
            }
            // $wallet->last_transaction_at = now();
            $wallet->save();

        });

    }

    /**
     * @param Model $order
     * @param $client_wallet_id
     * @param $amount
     * @param $type
     * @param WalletTransaction|null $parent
     * @return mixed
     */
    public static function withdraw(Order $order , $admin_id = null)
    {
        return static::add($order , 'out' , $admin_id);
    }


    /**
     * @param Model $order
     * @param $client_wallet_id
     * @param $amount
     * @param $type
     * @param WalletTransaction|null $parent
     * @return mixed
     */
    public static function deposit(Order $order , $admin_id = null)
    {
        return static::add($order , 'in', $admin_id);
    }

    public static function depositService(OrderService $order , $admin_id = null)
    {
        return static::add($order , 'in', $admin_id);
    }



    /**
     * @param Model $order
     * @param $direction
     * @param $client_wallet_id
     * @param $amount
     * @param $type
     * @param WalletTransaction|null $parent
     * @return mixed
     */
    public static function add($order , $direction , $admin_id = null)
    {
        if (empty($order->vendor->wallet)) VendorWallet::create(['vendor_id' => $order->vendor->id, 'balance' => 0]);
        return static::create([
            'wallet_id' => VendorWallet::where('vendor_id',$order->vendor->id)->first()->id,
            'operation_type' => $direction,
            'admin_id' => $admin_id ? $admin_id :( auth()->user()?->type == 'admin' || auth()->user()?->type == 'vendor' ? auth()->user()->id : null) ,
            'amount' => $order->vendor_amount,
            // 'receipt_url' => 'completed',
            'reference' => get_class($order),
            'reference_id' => $order->id,
        ]);
    }
     /**
     * Get the par (Order or GIFT ETC).
     */
    public function referenceOrder()
    {
        return $this->morphTo(__FUNCTION__, 'reference', 'reference_id');

    }

    public function amountInSar() : Attribute {
        return Attribute::make(
            get: fn () => $this->amount ,
        );
    }

    /**
     * Get the attachment full url.
     *
     * @return string|null
     */
    public function getAttachmentUrlAttribute() : string|null
    {
        return $this->media->count() > 0 ? $this->media->first()->getFullUrl() : null;
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'reference_id')->where('reference', Order::class);
    }

    public function orderService()
    {
        return $this->belongsTo(OrderService::class, 'reference_id')->where('reference', orderService::class);
    }

    public function scopeCompleted($query){
        return $query->where('status','completed');
    }

    public function scopeFilterVendor($query){
        return $query->when(request()->get('vendor'), function($query) {
            $query->whereHas('wallet',function($qr){
                $qr->where('vendor_id',request()->get('vendor'));
            });
        });
    }

    public function scopeCreatedBetween($query) {
        return $query->when(request()->get('from') && request()->get('to'), function($query) {
            $query->whereDate('created_at', ">=" ,request()->get('from'))->whereDate('created_at' , "<=" ,  request()->get('to'));
        });
    }


}
