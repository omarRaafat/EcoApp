<?php

namespace App\Models;

use App\Enums\PaymentMethods;
use App\Enums\ServiceOrderStatus;
use App\Http\Requests\Vendor\AssignServiceRequest;
use App\Models\Attributes\OrderAttributes;
use App\Models\Scopes\CreatedFromScopes;
use App\Services\Invoices\NationalTaxInvoice;
use App\Services\Order\ZakatQrServices;
use App\Traits\DbOrderScope;
use App\Traits\OrderModelScope;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class OrderService extends Model implements HasMedia
{
    use DbOrderScope, OrderModelScope, CreatedFromScopes, OrderAttributes, InteractsWithMedia, SoftDeletes;

    const REGISTERD = 'registered';
    const COMPLETED = 'completed';
    const CANCELED = 'canceled';
    protected $fillable = [
        'transaction_id',
        'vendor_id',
        'user_id',
        'order_date',
        'customer_name',
        'status',
        'sub_total',
        'total',
        'tax',
        'vat',
        'code',
        'wallet_id',
        'wallet_amount',
        'visa_amount',
        'use_wallet',
        'payment_id',
        'note',
        'receive_order_code',
        'vat_percentage',
        'service_address',
        'invoice_number',
        'company_percentage',
        'company_profit',
        'vendor_amount',
        'num_services',
    ];
    public function services()
    {
        return $this->belongsToMany(Service::class, 'order_service_details')
            ->withPivot('id', 'quantity', 'unit_price', 'total', 'updated_at');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function statusLogs()
    {
        return $this->hasMany(OrderServiceStatusLog::class, 'order_service_id');
    }
    public function assignServicesRequest()
    {
        return $this->hasMany(AssignOrderServiceRequest::class, 'order_service_id');
    }
    public function customer()
    {
        return $this->transaction?->customer;
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function steps()
    {
        return $this->hasMany(OrderLog::class, 'order_id');
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }

    public function orderServices()
    {
        return $this->hasMany(OrderServiceDetail::class, 'order_service_id');
    }

    public function scopeVendor(Builder $query, int $vendorId) : Builder {
        return $query->where("vendor_id", $vendorId);
    }

    public function scopeOwnVendor($query) {
        return $query->where("vendor_id", auth()->user()->vendor?->id);
    }

    public function scopeDelivered(Builder $query) : Builder
    {
        return $query->whereIn("status", [ServiceOrderStatus::COMPLETED]);
    }

    public function scopeNotCancelled(Builder $query) : Builder
    {
        return $query->whereNotIn("status", [ServiceOrderStatus::WAITINGPAY, ServiceOrderStatus::CANCELED]);
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

    public function statusText(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => __('translation.order_statuses.' . $this->status)
        );
    }


    public function getStatuses(): array
    {
        $statuses = collect([]);

        if(in_array($this->status, [ServiceOrderStatus::CANCELED])){
            $statuses->push([
                'name' => ServiceOrderStatus::getWebsiteStatusTranslated(ServiceOrderStatus::REGISTERD),
                'is_selected' => true,
            ]);
            $statuses->push([
                'name' => ServiceOrderStatus::getWebsiteStatusTranslated($this->status),
                'is_selected' => true,
            ]);
        }
        else{

            $statuses->push([
                'name' => ServiceOrderStatus::getWebsiteStatusTranslated(ServiceOrderStatus::REGISTERD ),
                'is_selected' => $this->status == ServiceOrderStatus::REGISTERD || $this->status == ServiceOrderStatus::PAID ||$this->status == ServiceOrderStatus::PROCESSING|| $this->status == ServiceOrderStatus::COMPLETED
            ]);

            $statuses->push([
                'name' => ServiceOrderStatus::getWebsiteStatusTranslated(ServiceOrderStatus::PROCESSING),
                'is_selected' => $this->status == ServiceOrderStatus::PROCESSING || $this->status == ServiceOrderStatus::COMPLETED
            ]);

            $statuses->push([
                'name' => ServiceOrderStatus::getWebsiteStatusTranslated(ServiceOrderStatus::COMPLETED),
                'is_selected' => $this->status ==  ServiceOrderStatus::COMPLETED
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
            $pdf = $invoiceGenerator->getServiceVendorPdf($this , true);
            $fullPath = $invoiceGenerator->getFullPath();
                $fileName = $invoiceGenerator->getFileName();
                $pdf->save($fullPath);
                $this->addMedia($fullPath)
                    ->usingName($fileName)
                    ->setFileName($fileName)
                    ->toMediaCollection('invoice');
            }
            return $this->media()?->latest()->first()?->getFullUrl();
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
        return $this->hasOne(ServiceOrderNote::class,'service_order_id','id')->withDefault();
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
        return !in_array($this->status,['completed','canceled']) && in_array($this->transaction->payment_method,[2,3]) && auth()->user()?->isAdminPermittedTo('admin.transactions.cancel');
    }

    public function isAdminCanRefund(){
        return $this->status == 'completed' && in_array($this->transaction->payment_method,[2,3]) && $this->delivered_at > now()->subDays(3) && auth()->user()?->isAdminPermittedTo('admin.transactions.cancel');
    }

    public function statusIsClosed(){
        return in_array($this->status,[ServiceOrderStatus::COMPLETED,ServiceOrderStatus::CANCELED]);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function getQrCode(){
        return str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', (new ZakatQrServices($this))->getQrCode());
    }

    public function totalVendorOut(){
        return VendorWalletTransaction::completed()->whereHas('wallet',function($qr){
            $qr->where('vendor_id',$this->vendor_id);
        })->createdBetween()->where('operation_type','out')->sum('amount');
    }

}
