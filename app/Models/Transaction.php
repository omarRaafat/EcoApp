<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Traits\DbOrderScope;
use Spatie\MediaLibrary\HasMedia;
use App\Models\Scopes\CreatedFromScopes;
use App\Models\Scopes\TransactionScopes;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Models\Attributes\TransactionAttributes;
use App\Services\Eportal\Connection;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\PaymentMethods;
use App\Enums\ServiceOrderStatus;
use App\Services\Invoices\NationalTaxInvoice;

class Transaction extends BaseModel implements HasMedia
{
    use DbOrderScope, InteractsWithMedia, TransactionScopes, CreatedFromScopes, TransactionAttributes, SoftDeletes;

    const REGISTERD = 'registered';
    const SHIPPING_DONE = 'shipping_done';
    const IN_DELEVERY = 'in_delivery';
    const COMPLETED = 'completed';
    const CANCELED = 'canceled';
    const REFUND = 'refund';

    const MEDIA_COLLECTION_NAME = "customer-invoices";

    protected $fillable = [
        'customer_id', 'currency_id', 'date', 'status', 'address_id', 'code', 'products_count',
        'payment_method', 'note', 'coupon_id',
        'total', // is a useless attribute total_amount attribute is the calculated value here
        'sub_total', // product total without vat
        'total_vat', // total vat calculated as amount
        'use_wallet', // is wallet used in this transaction or not
        'wallet_deduction', // the amount used from wallet
        // the reminder amount for customer to pay
        //     (in case there is a wallet deduction this column + wallet_deduction will be the total attribute)
        'reminder',
        'vat_percentage',
        'delivery_fees',
        'discount',
        'base_delivery_fees',
        'cod_collect_fees',
        'packaging_fees',
        'extra_weight_fees',
        'shipping_method_id',
        'is_international',
        'city_id',
        'wallet_amount',
        "paidWithCard",
        "wallet_id",
        "customer_name",
        "refund_status",
        'cart_id', // unique,
        'type',
        'service_address'
    ];

    public $casts = ["date: datetime"];

    //status => registered,shipping_done,in_delivery,completed,canceled,refund

    public function statusText(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => __('translation.order_statuses.' . $this->status)
        );
    }

    public function customer()
    {
        return $this->belongsTo(Client::class, 'customer_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function orderServices() :HasMany
    {
        return $this->hasMany(OrderService::class,'transaction_id');
    }

    public function onlinePayment()
    {
        return $this->hasOne(OnlinePayment::class, 'transaction_id');
    }

    //addresses

    public function addresses()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function transactionStatusLogs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TransactionLog::class, 'transaction_id');
    }

    public function products()
    {
        return $this->hasManyThrough(
            OrderProduct::class,
            Order::class,
            'transaction_id',
            'order_id',
        );
    }
    public function services()
    {
        return $this->hasManyThrough(
            OrderServiceDetail::class,
            OrderService::class,
            'transaction_id',
            'order_service_id',
        );
    }

    /**
     * Get the order ship info assossiated to this transaction.
     */
    public function orderShip(): HasOne
    {
        return $this->hasOne(OrderShip::class, 'reference_model_id', 'id');
    }

    /**
     * Get the warehouse shipping request assossiated to this transaction.
     */
    public function warehouseShippingRequest(): HasOne
    {
        return $this->hasOne(WarehouseShippingRequest::class, 'reference_model_id', 'id');
    }

    public function warnings(): HasMany
    {
        return $this->hasMany(TransactionWarning::class, 'transaction_id');
    }

    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class, 'shipping_method_id');
    }
    public function getStatusesOrderServices() :array
    {
        $statuses = collect([]);

        $statuses->push([
            'name' => ServiceOrderStatus::getWebsiteStatusTranslated(ServiceOrderStatus::REGISTERD),
            'is_selected' => $this->status == ServiceOrderStatus::REGISTERD || $this->status == ServiceOrderStatus::PAID || $this->status == ServiceOrderStatus::CANCELED  || $this->status == ServiceOrderStatus::REFUNDCOMPLETED || $this->status == ServiceOrderStatus::COMPLETED
        ]);

        if($this->status ==  ServiceOrderStatus::CANCELED){
            $statuses->push([
                'name' => ServiceOrderStatus::getWebsiteStatusTranslated(ServiceOrderStatus::CANCELED),
                'is_selected' =>  $this->status == ServiceOrderStatus::CANCELED
            ]);
        }
        elseif ($this->status ==  ServiceOrderStatus::REFUNDCOMPLETED) {
            $statuses->push([
                'name' => ServiceOrderStatus::getWebsiteStatusTranslated(ServiceOrderStatus::REFUNDCOMPLETED),
                'is_selected' =>  $this->status == ServiceOrderStatus::REFUNDCOMPLETED
            ]);
        }
        elseif($this->status ==  ServiceOrderStatus::COMPLETED){
            $statuses->push([
                'name' => ServiceOrderStatus::getWebsiteStatusTranslated(ServiceOrderStatus::COMPLETED),
                'is_selected' =>  $this->status == ServiceOrderStatus::COMPLETED
            ]);
        }


        return $statuses->toArray();
    }
    public function getStatuses(): array
    {
        $statuses = collect([]);

        $statuses->push([
            'name' => OrderStatus::getWebsiteStatusTranslated(OrderStatus::REGISTERD),
            'is_selected' => $this->status == OrderStatus::REGISTERD || $this->status == OrderStatus::PAID || $this->status == OrderStatus::CANCELED  || $this->status == OrderStatus::REFUND || $this->status == OrderStatus::COMPLETED
        ]);

        if($this->status ==  OrderStatus::CANCELED){
            $statuses->push([
                'name' => OrderStatus::getWebsiteStatusTranslated(OrderStatus::CANCELED),
                'is_selected' =>  $this->status == OrderStatus::CANCELED
            ]);
        }
        elseif ($this->status ==  OrderStatus::REFUND) {
            $statuses->push([
                'name' => OrderStatus::getWebsiteStatusTranslated(OrderStatus::REFUND),
                'is_selected' =>  $this->status == OrderStatus::REFUND
            ]);
        }
        elseif($this->status ==  OrderStatus::COMPLETED){
            $statuses->push([
                'name' => OrderStatus::getWebsiteStatusTranslated(OrderStatus::COMPLETED),
                'is_selected' =>  $this->status == OrderStatus::COMPLETED
            ]);
        }


        return $statuses->toArray();
    }

    public function urwayTransaction()
    {
        return $this->hasOne(UrwayTransaction::class, 'transaction_id')->where('status','completed')->latest();
    }

    public function tabbyTransaction()
    {
        return $this->hasOne(TabbyTransaction::class, 'transaction_id')->where('status','completed')->latest();
    }

    public function processRate()
    {
        return $this->hasOne(TransactionProcessRate::class, 'transaction_id');
    }


    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function orderVendorShippings(): HasMany
    {
        return $this->hasMany(OrderVendorShipping::class, 'transaction_id');
    }

    public function orderVendorShippingWarehouses(): HasMany
    {
        return $this->hasMany(OrderVendorShippingWarehouse::class, 'transaction_id');
    }


    public function client(){
        return $this->belongsTo(Client::class, 'customer_id')->withDefault();
    }
    public function orderServiceFields() :HasMany
    {
        return $this->hasMany(OrderServiceFields::class,'transaction_id');
    }
    #scopes
    public function scopeOwClient($query){
        return $query->where('customer_id', auth()->guard('api_client')->user()?->id);
    }

    public function transStatus()
    {
        if($this->status === 'completed'){
            return 'مكتملة';
        }elseif($this->status === 'canceled') {
            return 'ملغى';
        }elseif($this->status === 'refund') {
            return 'مرتجع';
        }else{
            return 'غير مكتملة';
        }
    }

    public function checkTransactionIsPaid(){
        if($this->status == 'paid' || $this->status == 'processing' || $this->status == 'completed' ){
            return true;
        }else{
            return false;
        }
    }

    public function orderProducts()
    {
        return $this->hasManyThrough(
            OrderProduct::class,
            Order::class,
            'transaction_id',
            'order_id',
            'id',
            'id'
        );
    }

    public function orderServicesDetails()
    {
        return $this->hasManyThrough(
            OrderServiceDetail::class,
            OrderService::class,
            'transaction_id',
            'order_service_id',
            'id',
            'id'
        );
    }

    public function getPaymentMethod(){
        $paymentStatus = "";

        $statusList = PaymentMethods::getStatusList();

        if (isset($statusList[$this->payment_method])) {
            $paymentStatus = $statusList[$this->payment_method];
        }

        if ($this->wallet_amount > 0 && $this->payment_method != 3) {
            $paymentStatus .= ' - ' . PaymentMethods::getStatus(3);
        }

        return $paymentStatus;
    }
    public function saveOrderPdfAndReturnPath()
    {
        if($this->media()->first()){
            $this->clearMediaCollection('customer-invoices');
        }
        if(empty($this->media()->first())){
            $invoiceGenerator = new NationalTaxInvoice;
            $invoiceGenerator->setTransaction($this);
            $pdf = $this->type == 'order' ?  $invoiceGenerator->getPdf($this , true) : $invoiceGenerator->getServicesPdf($this,true);
            $fullPath = $invoiceGenerator->getFullPath();
                $fileName = $invoiceGenerator->getFileName();
                $pdf->save($fullPath);
                $this->addMedia($fullPath)
                    ->usingName($fileName)
                    ->setFileName($fileName)
                    ->toMediaCollection('customer-invoices');
            }
            return $this->media()?->latest()->first()?->getFullUrl();
    }
}
