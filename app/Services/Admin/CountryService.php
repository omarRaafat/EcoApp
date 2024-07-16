<?php

namespace App\Services\Admin;

use Exception;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Repositories\Admin\CountryRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CountryService
{
    /**
     * Country Service Constructor.
     *
     * @param CountryRepository $repository
     */
    public function __construct(public CountryRepository $repository) {}

    /**
     * Get Countries.
     *
     * @return Collection
     */
    public function getAllCountries() : Collection
    {
        return $this->repository->all()->get();
    }

    /**
     * Get Countries with pagination.
     *
     * @param Request $request
     * @param integer $perPage
     * @param string $orderBy
     * @return LengthAwarePaginator
     */
    public function getAllCountriesWithPagination(Request $request, int $perPage = 10, string $orderBy = "DESC") : LengthAwarePaginator
    {
        $countries = $this->repository
                    ->all()
                    ->newQuery();

        if($request->has("search")) {
            if($request->has("trans") && $request->trans != "all") {
                $countries->where('name->' . $request->trans, 'LIKE', "%{$request->search}%");
            }
        }

        if ($request->has("is_active") && $request->is_active !== "all") {
            $countries->where("is_active", "=", $request->is_active);
        }

        return $countries->orderBy("created_at", $orderBy)->paginate($perPage);
    }

    /**
     * Get Country using ID.
     *
     * @param integer $id
     * @return Country
     */
    public function getCountryUsingID(int $id) : Country
    {
        return $this->repository
                    ->all()
                    ->where('id',$id)
                    ->first();
    }

    /**
     * Create New Country.
     *
     * @param Request $request
     * @return array
     */
    public function createCountry(Request $request) : array
    {

        $country = $this->repository->store(
            $request->except('_method', '_token')
        );

        if($request->is_national){
            $this->makeRestCountriesNotNational($country->id);
        }

        if(!empty($country)) {
            return [
                "success" => true,
                "title" => trans("admin.countries.messages.created_successfully_title"),
                "body" => trans("admin.countries.messages.created_successfully_body"),
                "id" => $country->id
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.countries.messages.created_error_title"),
            "body" => trans("admin.countries.messages.created_error_body"),
        ];
    }

    /**
     * Update Country Using ID.
     *
     * @param integer $country_id
     * @param Request $request
     * @return array
     */
    public function updateCountry(int $country_id, Request $request) : array
    {
        $country = $this->getCountryUsingID($country_id);

        $this->repository->update($request->except('_method', '_token'), $country);

        if($request->is_national){
            $this->makeRestCountriesNotNational($country_id);
        }

        return [
            "success" => true,
            "title" => trans("admin.countries.messages.updated_successfully_title"),
            "body" => trans("admin.countries.messages.updated_successfully_body"),
        ];
    }

    /**
     * Delete Country Using.
     *
     * @param int $country_id
     * @return array
     */
    public function deleteCountry(int $country_id) : array
    {
        $country = $this->getCountryUsingID($country_id);
        $isDeleted = $this->repository->delete($country);

        if($isDeleted == true) {
            return [
                "success" => true,
                "title" => trans("admin.countries.messages.deleted_successfully_title"),
                "body" => trans("admin.countries.messages.deleted_successfully_message"),
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.countries.messages.deleted_error_title"),
            "body" => trans("admin.countries.messages.deleted_error_message"),
        ];
    }


     /**
     * .Make Rest Countries Not National
     * @param int $nationalCountryId
     * @return bool
     */
    public function makeRestCountriesNotNational(int $nationalCountryId)
    {
        return $this->repository->all()
        ->where('id','!=',$nationalCountryId)
        ->update(['is_national'=>0]);

    }
}
