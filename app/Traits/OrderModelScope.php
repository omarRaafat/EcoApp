<?php
namespace App\Traits;

use App\Enums\OrderStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait OrderModelScope {
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $transactionId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTransaction(Builder $query, int $transactionId) : Builder {
        return $query->where('transaction_id', $transactionId);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTrackable(Builder $query) : Builder {
        return $query->where(
            fn($q) => $q->where('status', '!=', OrderStatus::COMPLETED)
                ->where('status', '!=', OrderStatus::CANCELED)
                ->where('status', '!=', OrderStatus::SHIPPING_DONE)
        );
    }

    public function scopeNotLinkedToInvoice(Builder $query, $period_start_at, $period_end_at): Builder
    {
        return $query->whereDate("delivered_at", ">=", $period_start_at)
            ->whereDate("delivered_at", "<=", $period_end_at)
            ->whereNull("invoice_id")
            ->where("status", "completed");
    }
}
