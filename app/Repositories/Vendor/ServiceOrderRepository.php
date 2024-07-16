<?php

namespace App\Repositories\Vendor;

use App\Models\Order;
use App\Models\OrderService;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;


class ServiceOrderRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return OrderService::class;
    }



    public function getModelCollectionUsingIDs($ids)
    {
    	return $this->model->whereIn('id',$ids);
    }
}
