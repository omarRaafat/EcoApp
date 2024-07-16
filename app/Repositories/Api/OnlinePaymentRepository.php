<?php

namespace App\Repositories\Api;

use App\Models\OnlinePayment;
use Illuminate\Http\Request;
use App\Repositories\Api\BaseRepository;


class OnlinePaymentRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return OnlinePayment::class;
    }
}
