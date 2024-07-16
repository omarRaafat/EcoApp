<?php

namespace App\Services\Api;

use App\Enums\CustomHeaders;
use App\Http\Resources\Api\AddressResource;
use App\Models\Address;
use App\Models\Country;
use App\Services\Eportal\Connection;
use Illuminate\Http\Request;
use App\Repositories\Api\AddressRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AddressService
{
    /**
     * Address Service Constructor.
     *
     * @param AddressRepository $repository
     */
    public function __construct(public AddressRepository $repository,Request  $request) {
       
    }

    /**
     * Get Addresses.
     *
     * @return Collection
     */
    public function getAllAddresses() : Collection
    {
        return $this->repository->all()->get();
    }

    /**
     * Get Categories with pagination.
     *
     * @param integer $perPage
     * @return LengthAwarePaginator
     */
    public function getAllAddressesWithPagination(int $perPage = 10) : LengthAwarePaginator
    {
        return $this->repository->all()->paginate($perPage);
    }


    /**
     * Get all addresses of the current user.
     *
     * @return array
     */
    public function  getcurrentUserAddresses() : array
    {
        $countryCode = request()->hasHeader(CustomHeaders::COUNTRY_CODE) ? request()->header(CustomHeaders::COUNTRY_CODE) : null;
        $addresses =  $this->repository->all()
            ->when($countryCode, fn($a) => $a->countryByCode($countryCode))
            ->where('user_id',auth('api_client')->user()->id)
            ->get();
        return  [
            'success'=>true,
            'status'=>200 ,
            'data'=>AddressResource::collection($addresses),
            'message'=>__('address.api.retrived_successfuly')
            ];
    }


    /**
     * Get Address using ID.
     *
     * @param integer $id
     * @return Address
     */
    public function getAddressUsingID(int $id) : Address|null
    {
        return $this->repository->getModelUsingID($id);
    }


    /**
     * Get Address using ID and check if belongs to current user.
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function getCurrentAddressUsingID(int $id) : array
    {
        $address =  $this->getAddressUsingID($id);

        if($address == null || $address->user_id != auth('api_client')->user()->id)
            return  [
                'success'=>false,
                'status'=>500 ,
                'data'=>[] ,
                'message'=>__('address.api.not_found')
            ];

        return  ['success'=>true,
            'status' => 200,
            'data' => new AddressResource($address),
            'message' => __('address.api.retrived_successfuly')
        ];
    }

    /**
     * create new address for looged in user.
     *
     * @param integer $id
     * @return array
     */
    public function createAddress(array $request) :array
    {

        $request['user_id'] = auth('api_client')->user()->id;
        if (!$this->repository->all()->where('user_id', auth('api_client')->user()->id)->exists()) {
            $request['is_default'] = 1;
        }

        $request['is_international'] = !Country::find(request()->country_id)->is_national;

        if ($request['is_international']) $request['area_id'] = null;

        $address =  $this->repository->store($request);
        if(!$address->id) {
            return [
                'success' => false,
                'status' => 500,
                'data' => new AddressResource($address),
                'message' => __('address.api.retrived_successfuly')
            ];
        }
        if($address->is_default) $this->deactiveRestAddresses($address->id);

        return [
            'success' => true,
            'status' => 200 ,
            'data' => new AddressResource($address),
            'message' => __('address.api.created_successfuly')
        ];
    }

    /**
     * update  user address.
     *
     * @param Request $request
     * @return array
     */
    public function updateAddress(Request $request) : array
    {
        $address = $this->getAddressUsingID($request->address_id);
        if($address == null || $address->user_id != auth('api_client')->user()->id)
            return  ['success'=>false, 'status'=>404 ,'data'=>[],'message'=>__('address.api.not_found')];

        if (Country::find($request->country_id)->is_national) {
            $request->merge(['international_city' => '', 'is_international' => 0]);
        } else {
            $request->merge(['is_international' => 1, 'area_id' => null]);
        }

        $request = $request->only([
            'first_name', 'last_name', 'description', 'type', 'is_default', 'phone', 'country_id', 'area_id', 'city_id', 'is_international'
        ]);

        $address = $this->repository->update($request,$address);

        return  [
            'success' => true,
            'status' => 200,
            'data' => new AddressResource($address),
            'message' => __('address.api.updated_successfuly')
        ];
    }
    /**
     * set address default
     *
     * @param int $int
     * @return array
     */
    public function setDefaultAddress(int $id)
    {
        $address = $this->getAddressUsingID($id);
        if($address == null || $address->user_id != auth('api_client')->user()->id)
            return  [
                 'success'=>false,
                 'status'=>404 ,
                 'data'=>[],
                 'message'=>__('address.api.not_found')
                ];

        $address = $this->repository->update(['is_default'=>1],$address);
        $this->deactiveRestAddresses($id);

        $address =  $this->getcurrentUserAddresses();
        $address['message'] = __('address.api.default_changed');

        return $address;

    }



    /**
     * delete address
     *
     * @param int $int
     * @return array
     *
     */
    public function deleteAddress(int $id)
    {
        $address = $this->getAddressUsingID($id);
        if($address == null || $address->user_id != auth('api_client')->user()->id)
            return  [
                    'success'=>false,
                    'status'=>404 ,
                    'data'=>[],
                    'message'=>__('address.api.not_found')
                ];
        if($address->is_default)
            return  [
                     'success'=>false,
                     'status'=>422 ,
                     'data'=>[],
                     'message'=>__('address.api.cannot_delete_dafault')
                    ];
        $this->repository->delete($address);
            return  [
                     'success'=>true,
                     'status'=>200 ,
                     'data'=>[],
                     'message'=>__('address.api.deleted_successfuly')
                    ];
    }

    /**
     * delete address
     *
     * @param int $activeAddressId
     * @return array
     */
    public function deactiveRestAddresses(int $activeAddressId)
    {
        return $this->repository->all()
        ->where('id','!=',$activeAddressId)
        ->where('user_id',auth('api_client')->user()->id)
        ->update(['is_default'=>0]);

    }

    public function getActiveGeoData()
    {
        // TODO: refactor is very important here, Related To Eng Ahmed Hesham
        return Country::with([
                "areas" => fn ($areaQ) => $areaQ->active()
                    ->whereHas('cities', fn($cityQ) => $cityQ->active())
                    ->with(['cities' => fn($cityQ) => $cityQ->active()])
            ])
            ->active()
            ->whereHas(
                'areas',
                fn($areaQ) => $areaQ->active()->whereHas(
                    'cities',
                    fn($cityQ) => $cityQ->active()
                )
            )
            ->get();
    }
}
