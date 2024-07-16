<?php
namespace App\Repositories\Admin;

use App\Models\CustomerCashWithdrawRequest;
use App\Repositories\Api\BaseRepository;

class CustomerCashWithdrawRequestRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return CustomerCashWithdrawRequest::class;
    }
}