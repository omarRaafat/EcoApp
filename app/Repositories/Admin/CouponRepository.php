<?php

namespace App\Repositories\Admin;

use App\Models\Coupon;
use App\Repositories\Api\BaseRepository;

class CouponRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return Coupon::class;
    }

      /**
     * Get List Of Countries As collection For Select Menu
     * 
     * @return Collection
     */
    public function couponsMenu() : Collection
    {
        return $this->all()->get();
    }
}
