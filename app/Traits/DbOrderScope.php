<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait DbOrderScope {
    public function scopeAscOrder(Builder $query) {
        return $query->orderBy('id', 'asc');
    }

    public function scopeDescOrder(Builder $query) {
        return $query->orderBy('id', 'desc');
    }
}