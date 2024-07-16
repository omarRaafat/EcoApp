<?php

namespace App\Repositories\Api;

use App\Models\Service;
use App\Models\Review;
use App\Models\ServiceReview;
use Illuminate\Http\Request;
use App\Repositories\Api\BaseRepository;


class ServiceRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return Service::class;
    }



    public function createReview(Service $service,Array $review)
    {
        try {
            return $service->reviews()->save(new ServiceReview($review));
        } catch (\Illuminate\Database\QueryException $ex) {
            return false;
        }
    }

    public function getServiceIfAvailable($id)
    {
        return $this->model->where("id", $id)->available()->first();
    }

    public function getServiceIfAvailableWithQuantity($id,$quantity)
    {
        return $this->model->where("id", $id)->hasStock($quantity)->available()->first();
    }
}
