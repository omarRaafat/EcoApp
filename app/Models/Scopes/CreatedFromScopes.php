<?php
namespace App\Models\Scopes;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Exception;

trait CreatedFromScopes {
    public function scopeCreatedTenMinutesAgo(Builder $query) : Builder {
        return $query->where("created_at", "<=", now()->subMinutes(10)->format("Y-m-d H:i:s"));
    }

    public function scopeCreatedYesterday(Builder $query) : Builder {
        $yesterday = Carbon::yesterday();
        return $query->where("created_at", ">=", $yesterday->startOfDay()->format("Y-m-d H:i:s"))
            ->where("created_at", "<=", $yesterday->endOfDay()->format("Y-m-d H:i:s"));
    }

    public function scopeCreatedBetween(Builder $query, Carbon $dateFrom, Carbon $dateTo) : Builder {
        if ($dateFrom > $dateTo) throw new Exception(__("admin.date-range-invalid"));
        return $query->where("created_at", ">=", $dateFrom->startOfDay()->toDateTimeString())
            ->where("created_at", "<=", $dateTo->endOfDay()->toDateTimeString());
    }
}
