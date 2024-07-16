<?php

namespace App\Services\Admin;

use Illuminate\Support\Str;
use App\Models\TorodCompany;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Admin\TorodCompanyRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TorodCompanyService
{
    /**
     * Comapnie Service Constructor.
     *
     * @param TorodCompanyRepository $repository
     */
    public function __construct(public TorodCompanyRepository $repository) {}

    /**
     * Get Comapnie with pagination.
     *
     * @param Request $request
     * @param integer $perPage
     * @param string $orderBy
     * @return LengthAwarePaginator
     */
    public function getAllComapniesWithPagination(Request $request, int $perPage = 10, string $orderBy = "DESC") : LengthAwarePaginator
    {
        $companies = $this->repository->all()->newQuery();
        // Search Logic Here...
        return $companies->orderBy("created_at", $orderBy)->paginate($perPage);
    }

    /**
     * Get Company using ID.
     *
     * @param integer $id
     * @return TorodCompany
     */
    public function getCompanyUsingID(int $id) : TorodCompany
    {
        return $this->repository->all()->where('id',$id)->first();
    }

    /**
     * Create New Company.
     *
     * @param Request $request
     * @return array
     */
    public function createCompany(Request $request) : array
    {
        $request->merge([
            "name" => [
                "ar" => $request->name_ar,
                "en" => $request->name_en
            ],
            "desc" => [
                "ar" => $request->desc_ar,
                "en" => $request->desc_en
            ],
            "active_status" => $request->active_status == "on" ?? true
        ]);

        $company = $this->repository->store($request->except('_method', '_token', 'logo'));

        if(!empty($request->logo)) {
            $this->_createLogo($company, $request);
        }

        if(!empty($company)) {
            return [
                "success" => true,
                "title" => trans("admin.torodCompanies.messages.created_successfully_title"),
                "body" => trans("admin.torodCompanies.messages.created_successfully_body"),
                "id" => $company->id
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.torodCompanies.messages.created_error_title"),
            "body" => trans("admin.torodCompanies.messages.created_error_body"),
        ];
    }

    /**
     * Update Company Using ID.
     *
     * @param integer $company_id
     * @param Request $request
     * @return array
     */
    public function updateCompany(int $company_id, Request $request) : array
    {
        $company = $this->getCompanyUsingID($company_id);

        $request->merge([
            "name" => [
                "ar" => $request->name_ar,
                "en" => $request->name_en
            ],
            "desc" => [
                "ar" => $request->desc_ar,
                "en" => $request->desc_en
            ],
            "active_status" => $request->active_status == "on" ?? true
        ]);

        $this->repository->update($request->except('_method', '_token'), $company);

        if(!empty($request->logo)) {
            $this->_updateLogo($company, $request);
        }

        return [
            "success" => true,
            "title" => trans("admin.torodCompanies.messages.updated_successfully_title"),
            "body" => trans("admin.torodCompanies.messages.updated_successfully_body"),
            "id" => $company->id
        ];
    }

    /**
     * Delete Comapny Using.
     *
     * @param int $company_id
     * @return array
     */
    public function deleteComapny(int $company_id) : array
    {
        $company = $this->getCompanyUsingID($company_id);
        $isDeleted = $this->repository->delete($company);

        if($isDeleted == true) {
            return [
                "success" => true,
                "title" => trans("admin.torodCompanies.messages.deleted_successfully_title"),
                "body" => trans("admin.torodCompanies.messages.deleted_successfully_message"),
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.torodCompanies.messages.deleted_error_title"),
            "body" => trans("admin.torodCompanies.messages.deleted_error_message"),
        ];
    }

    /**
     * Create new logo using spatie medialibrary and assossiate it to Torod Company.
     *
     * @param TorodCompany $company
     * @param Request $request
     * @return void
     */
    private function _createLogo(TorodCompany $company, Request $request): void
    {
        if ($request->has("logo")) {
            $fileName = "logo_" . Str::slug($request->name_en, '-') . time();
            $fileExtension = $request->file('logo')->getClientOriginalExtension();
            $company->addMediaFromRequest("logo")
                ->usingName($fileName)
                ->setFileName($fileName . '.' . $fileExtension)
                ->toMediaCollection(TorodCompany::LOGO_MEDIA_COLLECTION);
        }
    }

    /**
     * Update Torod Company logo using spatie medialibrary and assossiate it to company.
     *
     * @param TorodCompany $company
     * @param Request $request
     * @return void
     */
    private function _updateLogo(TorodCompany $company, Request $request) : void
    {
        if($request->has("logo")) {
            $this->_deleteOldCompanyLogo($company);
            $fileName = "logo_" . Str::slug($request->name_en, '-') . time();
            $fileExtension = $request->file('logo')->getClientOriginalExtension();
            $company->addMediaFromRequest("logo")
                   ->usingName($fileName)
                   ->setFileName($fileName . '.' .  $fileExtension)
                   ->toMediaCollection(TorodCompany::LOGO_MEDIA_COLLECTION);
        }
    }

    /**
     * Delete old image media from spatie media collections.
     *
     * @param TorodCompany $company
     * @return void
     */
    private function _deleteOldCompanyLogo(TorodCompany $company) : void
    {
        $media = $company->media->first();

        if(!empty($media)) {
            $media->delete();
        }
    }
}
