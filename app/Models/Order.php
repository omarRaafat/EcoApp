<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethods;
use App\Enums\ShippingMethods;
use App\Models\Attributes\OrderAttributes;
use App\Models\Scopes\CreatedFromScopes;
use App\Services\Invoices\NationalTaxInvoice;
use App\Traits\DbOrderScope;
use App\Traits\OrderModelScope;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\Order\ZakatQrCode;

class Order extends BaseModel implements HasMedia
{
    use DbOrderScope, OrderModelScope, CreatedFromScopes, OrderAttributes, InteractsWithMedia, SoftDeletes;

    const REGISTERD = 'registered';
    const SHIPPING_DONE = 'shipping_done';
    const IN_DELEVERY = 'in_delivery';
    const COMPLETED = 'completed';
    const CANCELED = 'canceled';
    const REFUND = 'refund';

    protected $primaryKey = 'id';

    protected $fillable = [
        'transaction_id', 'vendor_id', 'date', 'status', 'delivery_type', 'total', 'sub_total',
        'vat', 'tax', 'vendor_amount', 'company_profit', 'company_percentage', 'code',
        'vat_percentage', 'delivery_fees', 'discount', "delivered_at", "invoice_number", 'total_weight',
        "customer_name", "invoice_id",
        "refund_status",
        'wallet_id' , 'wallet_amount' , 'visa_amount' , 'use_wallet' , 'payment_id' , 'note' , 'num_products' , 'no_packages', 'refund_reason','pickup_at'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function statusLogs()
    {
        return $this->hasMany(OrderStatusLog::class, 'order_id');
    }

    public function customer()
    {
        return $this->transaction?->customer;
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')
            ->withPivot('id', 'quantity', 'unit_price', 'total', 'updated_at');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function steps()
    {
        return $this->hasMany(OrderLog::class, 'order_id');
    }

    /**
     * Get the order ship info assossiated to this order.
     */
    public function orderShip(): HasOne
    {
        return $this->hasOne(OrderShip::class, 'gateway_order_id')->latestOfMany();
    }

    /**
     * Get the warehouse shipping request assossiated to this order.
     */
    public function warehouseShippingRequest(): HasOne
    {
        return $this->hasOne(WarehouseShippingRequest::class);
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }

    public function scopeVendor(Builder $query, int $vendorId) : Builder {
        return $query->where("vendor_id", $vendorId);
    }

    public function scopeOwnVendor($query) {
        return $query->where("vendor_id", auth()->user()->vendor->id);
    }

    public function scopeDelivered(Builder $query) : Builder
    {
        return $query->whereIn("status", [OrderStatus::COMPLETED, OrderStatus::SHIPPING_DONE]);
    }

    public function scopeNotCancelled(Builder $query) : Builder
    {
        return $query->whereNotIn("status", [OrderStatus::WAITINGPAY, OrderStatus::CANCELED]);
    }

    public function scopeDeliveredBetween(Builder $query, Carbon $dateFrom, Carbon $dateTo) : Builder {
        if ($dateFrom > $dateTo) throw new Exception(__("admin.date-range-invalid"));
        return $query->where("delivered_at", ">=", $dateFrom->startOfDay()->toDateTimeString())
            ->where("delivered_at", "<=", $dateTo->endOfDay()->toDateTimeString());
    }

    public function scopeCreatedBetween($query) {
        return $query->when(request()->get('date_from') && request()->get('date_to'), function($query) {
            $query->whereDate('created_at', ">=" ,request()->get('date_from'))->whereDate('created_at' , "<=" ,  request()->get('date_to'));
        });
    }

    public function scopeTransactionId(Builder $query, int $transactionId) : Builder {
        return $query->where("transaction_id", $transactionId);
    }

    public function  orderVendorShippings()
    {
        return $this->hasMany(OrderVendorShipping::class , 'order_id');
    }

    public function  orderVendorShippingWarehouses()
    {
        return $this->hasMany(OrderVendorShippingWarehouse::class , 'order_id');
    }

    public function receiveOrderVendorWarehouse(){
        return $this->hasOne(OrderVendorShippingWarehouse::class , 'order_id','id')->where('shipping_type_id',1)->withDefault();
    }

    public function  orderShipping()
    {
        return $this->hasOne(OrderVendorShipping::class , 'order_id')->withDefault();
    }

    public function statusText(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => __('translation.order_statuses.' . $this->status)
        );
    }


    public function getStatuses(): array
    {
        $statuses = collect([]);

        if(in_array($this->status, [OrderStatus::CANCELED, OrderStatus::REFUND])){
            $statuses->push([
                'name' => OrderStatus::getWebsiteStatusTranslated(OrderStatus::REGISTERD),
                'is_selected' => true,
            ]);
            $statuses->push([
                'name' => OrderStatus::getWebsiteStatusTranslated($this->status),
                'is_selected' => true,
            ]);
        }
        else{

            $statuses->push([
                'name' => OrderStatus::getWebsiteStatusTranslated(OrderStatus::REGISTERD ),
                'is_selected' => $this->status == OrderStatus::REGISTERD || $this->status == OrderStatus::PICKEDUP || $this->status == OrderStatus::IN_SHIPPING ||  $this->status == OrderStatus::PAID ||$this->status == OrderStatus::PROCESSING|| $this->status == OrderStatus::COMPLETED
            ]);

            $statuses->push([
                'name' => OrderStatus::getWebsiteStatusTranslated(OrderStatus::PROCESSING),
                'is_selected' => $this->status == OrderStatus::PROCESSING || $this->status == OrderStatus::PICKEDUP ||  $this->status == OrderStatus::IN_SHIPPING || $this->status == OrderStatus::COMPLETED
            ]);

            $statuses->push([
                'name' => "مع شركة الشحن",
                'is_selected' => $this->status == OrderStatus::PICKEDUP ||  $this->status == OrderStatus::IN_SHIPPING || $this->status == OrderStatus::COMPLETED
            ]);


            $statuses->push([
                'name' => OrderStatus::getWebsiteStatusTranslated(OrderStatus::IN_SHIPPING),
                'is_selected' => $this->status == OrderStatus::IN_SHIPPING || $this->status == OrderStatus::COMPLETED
            ]);

            $statuses->push([
                'name' => OrderStatus::getWebsiteStatusTranslated(OrderStatus::COMPLETED),
                'is_selected' => $this->status ==  OrderStatus::COMPLETED
            ]);
        }
        return $statuses->toArray();
    }

    public function checkOrderIsPaid(){
        if($this->status == 'paid' || $this->status == 'confirmed' || $this->status == 'processing' || $this->status == 'completed'
        || $this->status == 'registered'  ){
            return true;
        }else{
            return false;
        }
    }

    public function saveOrderPdfAndReturnPath(){
        // dd('www');
        if($this->media()->first()){
            $this->clearMediaCollection('invoice');
        }
        if(empty($this->media()->first())){
            $invoiceGenerator = new NationalTaxInvoice;
            $pdf = $invoiceGenerator->getVendorPdf($this , true);
            $fullPath = $invoiceGenerator->getFullPath();
                $fileName = $invoiceGenerator->getFileName();
                $pdf->save($fullPath);
                $this->addMedia($fullPath)
                    ->usingName($fileName)
                    ->setFileName($fileName)
                    ->toMediaCollection('invoice');
            }
            return $this->media()?->latest()->first()?->getFullUrl() ;
            // return null;
    }


    public function getCompanyProfitWithOutVatPecentage(){
        $vat = 1 + ($this->vat_percentage / 100);
        $profit = $this->company_profit / $vat;
        return $profit;
    }

    /**
     * @return HasMany
     */
    public function dispensingOrder(): HasMany
    {
        return $this->hasMany('App\Models\DispensingOrder' , 'order_id');
    }

    public function hasBeenSeen():bool{
        return $this->statusLogs()->where('status', 'seen')->exists();
    }

    public function orderNote(){
        return $this->hasOne(OrderNote::class,'order_id','id')->withDefault();
    }

    public function cancelType(){
        return $this->hasOne(OrderCancelType::class,'order_id','id')->latest()->withDefault();
    }


    public function getPaymentMethod(){
        if($this->wallet_amount > 0 && $this->payment_id != 3){
            return PaymentMethods::getStatusList()[$this->payment_id] .' - '.PaymentMethods::getStatus(3);
        }
        if(empty($this->payment_id)) return '';

        return PaymentMethods::getStatusList()[$this->payment_id];
    }

    public function processRate()
    {
        return $this->hasOne(OrderProcessRate::class, 'order_id');
    }


    public function vendorWalletTransactions()
    {
        return $this->hasMany(VendorWalletTransaction::class, 'reference_id')
            ->where('vendor_wallet_transactions.reference', Order::class);
    }

    public function isAdminCanCancel(){
        return !in_array($this->status,['completed','canceled','refund']) && in_array($this->transaction->payment_method,[2,3]) && auth()->user()?->isAdminPermittedTo('admin.transactions.cancel');
    }

    public function isAdminCanRefund(){
        return $this->status == 'completed' && in_array($this->transaction->payment_method,[2,3]) && $this->delivered_at > now()->subDays(3) && auth()->user()?->isAdminPermittedTo('admin.transactions.cancel');
    }

    public function statusIsClosed(){
        return in_array($this->status,[OrderStatus::REFUND,OrderStatus::COMPLETED,OrderStatus::CANCELED]);
    }

    public function getShippingMethodSpans()
    {
        $output = '';
        if($this->orderVendorShippings[0]->shipping_type_id == 2){
            if ($this->orderVendorShippings[0]->shipping_method_id == ShippingMethods::ARAMEX) {
                $output .= '<span class="badge badge-info">أرامكس</span>';
            } elseif ($this->orderVendorShippings[0]->shipping_method_id == ShippingMethods::SPL) {
                $output .= '<span class="badge badge-info">سبل</span>';
            }
        }
        else{
            $output .= '<span class="badge badge-info">استلام بنفسي</span>';
        }

        return $output;
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function getQrCode(){
        return str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', (new ZakatQrCode($this))->getQrCode());
    }

    public function totalVendorOut(){
        return VendorWalletTransaction::completed()->whereHas('wallet',function($qr){
            $qr->where('vendor_id',$this->vendor_id);
        })->createdBetween()->where('operation_type','out')->sum('amount');
    }

}
