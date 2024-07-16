<?php
namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait TransactionScopes {
    public function scopeStatuses(Builder $query, array $statuses) : Builder {
        return $query->where(
            fn($statusQuery) => collect($statuses)->each(fn($s) => $statusQuery->orWhere('status', $s))
        );
    }

    public function scopeNotStatuses(Builder $query, array $statuses) : Builder {
        return $query->where(
            fn($statusQuery) => collect($statuses)->each(fn($s) => $statusQuery->where('status', "!=", $s))
        );
    }

    public function scopeStatus(Builder $query, string $status) : Builder {
        return $query->where("status", $status);
    }

    public function scopeCustomer(Builder $query, $customerId) : Builder {
        return $query->where('customer_id', $customerId);
    }

    public function scopeId(Builder $query, $id) : Builder {
        return $query->where('id', $id);
    }

    public function scopePayment(Builder $query, $paymentId) : Builder {
        return $query->where('payment_method', $paymentId);
    }
}
