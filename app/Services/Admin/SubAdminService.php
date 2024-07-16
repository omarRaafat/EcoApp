<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Enums\UserTypes;
use App\Models\RuleUser;
use App\Enums\RulesScopes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Admin\SubAdminRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SubAdminService
{
    /**
     * SubAdmin Service Constructor.
     *
     * @param SubAdminRepository $repository
     */
    public function __construct(public SubAdminRepository $repository) {}

    /**
     * Get SubAdmin.
     *
     * @return Collection
     */
    public function getAllSubAdmins() : Collection
    {
        return $this->repository->all()->subadmins()->get();
    }

    /**
     * Get SubAdmin with pagination.
     *
     * @param Request $request
     * @param integer $perPage
     * @param string $orderBy
     * @return LengthAwarePaginator
     */
    public function getAllSubAdminsWithPagination(Request $request, int $perPage = 10, string $orderBy = "DESC") : LengthAwarePaginator
    {
        $subAdmins = $this->repository
                    ->all()
                    ->subadmins()
                    ->newQuery();

        if($request->has("search")) {
            if($request->has("search") && ($request->column != "all" && !empty($request->column))) {
                if(!empty($request->column)) {
                    $subAdmins->where($request->column . $request->trans, 'LIKE', "%{$request->search}%");
                }
            }
        }

        return $subAdmins->orderBy("created_at", $orderBy)->paginate($perPage);
    }

    /**
     * Get SubAdmin using ID.
     *
     * @param integer $id
     * @return User
     */
    public function getSubAdminUsingID(int $id) : User
    {
        return $this->repository->all()->where('type', 'sub-admin')->find($id);
    }

    /**
     * Create New SubAdmin.
     *
     * @param Request $request
     * @return array
     */
    public function createSubAdmin(Request $request) : array
    {
        $request->merge([
            "type" => UserTypes::SUBADMIN,
        ]);

        $subAdmin = $this->repository->store(
            $request->except('_method', '_token', 'rules')
        );

        $subAdmin->rules()->attach($request->rules);

        if(!empty($subAdmin)) {
            return [
                "success" => true,
                "title" => trans("admin.subAdmins.messages.created_successfully_title"),
                "body" => trans("admin.subAdmins.messages.created_successfully_body"),
                "id" => $subAdmin->id
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.subAdmins.messages.created_error_title"),
            "body" => trans("admin.subAdmins.messages.created_error_body"),
        ];
    }

    /**
     * Update SubAdmin Using ID.
     *
     * @param integer $subadmin_id
     * @param Request $request
     * @return array
     */
    public function updateSubAdmin(int $subadmin_id, Request $request) : array
    {
        $subAdmin = $this->getSubAdminUsingID($subadmin_id);

        $this->repository->update($request->except('_method', '_token', "rules"), $subAdmin);
        
        $subAdmin->rules()->sync($request->rules);

        return [
            "success" => true,
            "title" => trans("admin.subAdmins.messages.updated_successfully_title"),
            "body" => trans("admin.subAdmins.messages.updated_successfully_body"),
            "id" => $subAdmin->id
        ];
    }

    /**
     * Delete SubAdmin Using.
     *
     * @param int $subadmin_id
     * @return array
     */
    public function deleteSubAdmin(int $subadmin_id) : array
    {
        $subAdmin = $this->getSubAdminUsingID($subadmin_id);
        $isDeleted = $this->repository->delete($subAdmin);
        
        if($isDeleted == true) {
            return [
                "success" => true,
                "title" => trans("admin.subAdmins.messages.deleted_successfully_title"),
                "body" => trans("admin.subAdmins.messages.deleted_successfully_message"),
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.subAdmins.messages.deleted_error_title"),
            "body" => trans("admin.subAdmins.messages.deleted_error_message"),
        ];
    }
}
