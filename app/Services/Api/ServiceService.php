<?php

namespace App\Services\Api;

use App\Http\Resources\Api\ServiceReviewResource;
use App\Models\Service;
use App\Repositories\Api\ServiceRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use App\Services\Eportal\Connection;

class ServiceService
{

    /**
     * Service Service Constructor.
     *
     * @param ServiceRepository $repository
     */
    public function __construct(public ServiceRepository $repository) {

    }

    /**
     * Get Services.
     *
     * @return Collection
     */
    public function getAllServices() : Collection
    {
        return $this->repository->all()->withAvg('reviews','rate')->available()->with(['quantity_type'])
        ->withCount('reviews')->get();
    }

    /**
     * Get Services with pagination.
     *
     * @param integer $perPage
     * @return LengthAwarePaginator
     */
    public function getAllServicesWithPagination(int $perPage = 10) : LengthAwarePaginator
    {
        return $this->repository->all()->available()->with(['quantity_type'])
        ->paginate($perPage);
    }

        /**
     * Get Services with pagination.
     *
     * @param integer $perPage
     * @return array
     */
    public function getAllServicesInfinityLoad(int $perPage = 10 ) : Array
    {
        $page = (request()->page ?? 1) ;
        $offset = ($page - 1) * $perPage;

        $services = $this->repository->all()->available()
        ->when(!empty(request()->get('search')),function($qr){
            $qr->search(request()->get('search'));
        })
        ->when(!empty(request()->get('category_id')),function($qr){
            $qr->where('category_id',intval(request()->get('category_id')));
        })
        ->when(!empty(request()->get('city_id')),function($qr){
            $qr->whereHas('cities',function($qr1){
                $qr1->where('city_id',request()->get('city_id'));
            });
        });

        $count = $services->count();

        $services = $services->offset($offset)->take($perPage)->get();

        $next = ($page * $perPage) < $count;

        return [
            'services' => $services,
            'next' => $next,
        ];
    }        /**
     * Get Services with pagination.
     *
     * @param integer $perPage
     * @return array
     */
    public function site_map(int $perPage = 10 ) : Array
    {

        $services_data  = [];
        $services = $this->repository->all()->available()->with(['quantity_type'])->get();
        foreach ($services as $service)
        {
            $services_data[]=
                [
                    'name' => env('WEBSITE_BASE_URL').'/service/'. $service->getTranslation("name", "ar"),
                    'link' => env('WEBSITE_BASE_URL').'/service/'. $service->id .'/'.$service->getTranslation("name", "ar")
                ];

        }

        return [
            'services' => $services_data,
        ];
    }

    /**
     * Get Service using ID.
     *
     * @param integer $id
     * @return Service
     */
    public function getServiceUsingID(int $id) : Service|null
    {
        return $this->repository->all()->available()
        ->where('id',$id)
        ->first();

    }

    public function service_related($service)
    {
        return $this->repository->all()->available()
        ->where('id','!=',$service['id'])
            ->where(function ($query) use ($service) {
                $query->where('category_id',$service['category_id']);
            })
            ->take(7)->get();
    }
    /**
     * Get Services with pagination By category id.
     *
     * @param integer $category_id
     * @return LengthAwarePaginator
     */
    public function getServicesUsingCategoryID(int $category_id, $perPage=20)
    {
        return $this->repository->all()->available()
        ->where('category_id',$category_id)->paginate($perPage);
    }

    public function addServiceReview($request){
        $service = $this->getServiceUsingID($request['service_id']);
        if($service == null)
            return ['success'=>false, 'status'=>404 ,
                   'data'=>[],'message'=>__('services.api.service_not_found')];
        $review = $this->repository->createReview($service,[
                'user_id'=> auth('api_client')->user()?->id,
                'rate'=>$request['rate'],
                'comment'=>$request['comment'],
        ]);

         return [
            'success'=>true,
            'status'=>200 ,
            'data'=>new ServiceReviewResource($review),
            'message'=>__('services.api.service_review_created')
        ];
    }



    public function getSortedServices($vendor_id, $filter,$perPage=10)
    {
        $services = Service::available()->where('vendor_id',$vendor_id)
        ->withSum('orderServices','quantity');

        if($filter == 'best_rate'){
            $services = $services->orderBy('rate','DESC');
        }
        elseif($filter == 'best_selling'){
            $services = $services->orderBy('order_services_sum_quantity','DESC');
        }
        else{
            $services = $services->orderBy('id','DESC');
        }

        return $services->paginate($perPage);
    }

    public function checkAvilablity($id)
    {
        $vendor = $this->repository->getServiceIfAvailable($id);
        if($vendor == null)
            return false;
        return true;

    }

}
