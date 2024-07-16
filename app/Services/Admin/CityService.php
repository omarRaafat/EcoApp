<?php

namespace App\Services\Admin;

use App\Enums\CityStatus;
use Exception;
use App\Models\City;
use Illuminate\Http\Request;
use App\Repositories\Admin\CityRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CityService
{
    /**
     * City Service Constructor.
     *
     * @param CityRepository $repository
     */
    public function __construct(public CityRepository $repository) {}

    /**
     * Get Cities.
     *
     * @return Collection
     */
    public function getAllCities() : Collection
    {
        return $this->repository->all()->get();
    }

    /**
     * Get Cities with pagination.
     *
     * @param Request $request
     * @param integer $perPage
     * @param string $orderBy
     * @return LengthAwarePaginator
     */
    public function getAllCitiesWithPagination(Request $request, int $perPage = 10, string $orderBy = "DESC") : LengthAwarePaginator
    {
        $cities = $this->repository
                    ->all()
                    ->newQuery();

        if($request->has("search")) {
            if($request->has("trans") && $request->trans != "all") {
                $cities->where('name->' . $request->trans, 'LIKE', "%{$request->search}%");
            }
        }

        if ($request->has("is_active") && $request->is_active !== "all") {
            $cities->where("is_active", "=", $request->is_active);
        }

        return $cities->orderBy("created_at", $orderBy)->paginate($perPage);
    }

    /**
     * Get City using ID.
     *
     * @param integer $id
     * @return City
     */
    public function getCityUsingID(int $id) : City
    {
        return $this->repository
                    ->all()
                    ->where('id',$id)
                    ->first();
    }

    /**
     * Create New City.
     *
     * @param Request $request
     * @return array
     */
    public function createCity(Request $request) : array
    {


        if($request->is_active == null) {
            $request->merge(["is_active" => $request->is_active]);
        }

        $city = $this->repository->store(
            $request->except('_method', '_token')
        );

        if(!empty($city)) {
            return [
                "success" => true,
                "title" => trans("admin.cities.messages.created_successfully_title"),
                "body" => trans("admin.cities.messages.created_successfully_body"),
                "id" => $city->id
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.cities.messages.created_error_title"),
            "body" => trans("admin.cities.messages.created_error_body"),
        ];
    }

    /**
     * Update City Using ID.
     *
     * @param integer $city_id
     * @param Request $request
     * @return array
     */
    public function updateCity(int $city_id, Request $request) : array
    {
        $city = $this->getCityUsingID($city_id);
        // TODO: need to be refactored according to new business for domestic zone
//        if ($request->is_active == CityStatus::INACTIVE) {
//            return [
//                "success" => false,
//                "title" => trans("admin.cities.messages.updated_error_title"),
//                "body" => trans("admin.cities.messages.updated_error_body"),
//            ];
//        }

        $this->repository->update($request->except('_method', '_token'), $city);

        return [
            "success" => true,
            "title" => trans("admin.cities.messages.updated_successfully_title"),
            "body" => trans("admin.cities.messages.updated_successfully_body"),
        ];
    }

    /**
     * Delete City Using.
     *
     * @param int $city_id
     * @return array
     */
    public function deleteCity(int $city_id) : array
    {
        $city = $this->getCityUsingID($city_id);

        if(!empty($city)) {

            // TODO: need to be refactored according to new business for domestic zone
            // if(!empty($city->domesticZones)) {
            //     return [
            //         "success" => false,
            //         "title" => trans("admin.cities.messages.cannot_delete_city_title"),
            //         "body" => trans("admin.cities.messages.cannot_delete_city_body"),
            //     ];
            // }

            $isDeleted = $this->repository->delete($city);

            if($isDeleted == true) {
                return [
                    "success" => true,
                    "title" => trans("admin.cities.messages.deleted_successfully_title"),
                    "body" => trans("admin.cities.messages.deleted_successfully_message"),
                ];
            }
        }


        return [
            "success" => false,
            "title" => trans("admin.cities.messages.deleted_error_title"),
            "body" => trans("admin.cities.messages.deleted_error_message"),
        ];
    }
}
