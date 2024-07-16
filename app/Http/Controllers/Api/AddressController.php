<?php
namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\CountryResource;
use Illuminate\Http\JsonResponse;
use App\Services\Api\AddressService;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\StoreAddressRequest;
use App\Http\Requests\Api\UpdateAddressRequest;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AddressController extends ApiController
{
    /**
     * Address Controller Constructor.
     *
     * @param AddressService $service
     */
    public function __construct(public AddressService $service) {

    }

    /**
     * show user Address.
     *
     * @param int $addres_id
     * return JsonResponse
     */
    public function show(int $id) : JsonResponse
    {
        $response = $this->service->getCurrentAddressUsingID($id);
        return $this->setApiResponse
        (
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }


    /**
     * get currrent user addresses.
     *
     * return JsonResponse
     */
    public function currentUserAddresses() : JsonResponse
    {
        $response = $this->service->getcurrentUserAddresses();
        return $this->setApiResponse
        (
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }

    /**
     * store Address for currrent user .
     *
     * @param $request
     * @return JsonResponse
     */
    public function store(StoreAddressRequest $request) : JsonResponse
    {

        $response = $this->service->createAddress($request->toArray());
        return $this->setApiResponse
        (
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }

    /**
     * update Address for currrent user .
     *
     * @param $request
     * return JsonResponse
     */
    public function update(UpdateAddressRequest $request) : JsonResponse
    {
        $response = $this->service->updateAddress($request);
        return $this->setApiResponse
        (
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }

    /**
     * set default Address for currrent user .
     *
     * @param $addres_id
     * @return JsonResponse
     */
    public function setDefault(int $id) : JsonResponse
    {
        $response = $this->service->setDefaultAddress($id);
        return $this->setApiResponse
        (
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }


    /**
     * delete Address for currrent user .
     *
     * @param $addres_id
     * @return JsonResponse
     */
    public function delete(int $id) : JsonResponse
    {
        $response = $this->service->deleteAddress($id);
        return $this->setApiResponse
        (
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }
    /**
     * get all Active Countries to display.
     *
     * @return JsonResponse
     */
    public function GeoData() : ResourceCollection
    {
        $countries = $this->service->getActiveGeoData()->load('cities');
        return CountryResource::collection($countries)->additional([
            "success" => true,
            "status" => 200,
            "message"=> trans("address.api.retrieved_geo_data_successfully")
        ]);
    }
}
