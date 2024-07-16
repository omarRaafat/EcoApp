<?php

namespace App\Services\Api;

use App\Http\Resources\Api\ServiceResource;
use App\Models\FavoriteService;
use App\Models\Service;
use App\Models\User;
use App\Repositories\Api\ServiceRepository;
use Illuminate\Support\Facades\DB;

class FavoriteServiceService
{
    /**
     * Vendor Service Constructor.
     *
     * @param Vendorepository $repository
     */
   public function __construct(public ServiceRepository $repository) {}


   public function getFavoriteServices()
   {
        $customer_id = auth('api_client')->user()->id;
        $favs = FavoriteService::query()->where('user_id' , $customer_id)->get('service_id')->toArray();
       $services = Service::query()->whereIn('id' , array_column($favs , 'service_id' ))->get();
       return [
            'success'=>true,
            'status'=>200 ,
            'data'=> ServiceResource::collection($services),
            'message'=>__('services.api.services_retrived')
        ];

   }

   public function addFavoriteService($service_id)
   {
        $customer_id = auth('api_client')->user()->id;
        $checkExist = DB::table('favorite_services')->where('user_id' , $customer_id)->where('service_id' , $service_id)->first();

        if(!is_null($checkExist))
            return [
                'success'=>true,
                'status'=>200 ,
                'data'=> [],
                'message'=>__('services.api.favorite.service_already_exists')
            ];

        if(empty($this->repository->getModelUsingID($service_id)))
            return [
                'success'=>false,
                'status'=>404 ,
                'data'=> [],
                'message'=>__('services.api.service_not_found')
            ];

       $services = DB::table('favorite_services')->insert(array(
           'user_id'      => $customer_id,
           'service_id'   => $service_id,
       ));

        // $services = $customer->favorite_services()->attach([$service_id]);
        return [
            'success'=>true,
            'status'=>200 ,
            'data'=> [],
            'message'=>__('services.api.favorite.service_added')
        ];

   }

   public function deleteFavoriteService($service_id)
   {
    //$services = $customer->favorite_services()->detach([$service_id]);
       $services = DB::table('favorite_services')->where(array(
           'user_id'      => auth('api_client')->user()->id,
           'service_id'   => $service_id,
       ))->delete();

        return [
            'success'=>true,
            'status'=>200 ,
            'data'=> [],
            'message'=>__('services.api.favorite.service_deleted')
        ];

   }



}
