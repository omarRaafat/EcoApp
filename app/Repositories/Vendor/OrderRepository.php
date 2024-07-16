<?php

namespace App\Repositories\Vendor;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;


class OrderRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return Order::class;
    }

 

    public function getModelCollectionUsingIDs($ids)
    {
    	return $this->model->whereIn('id',$ids);
    }
}