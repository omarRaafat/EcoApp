<?php

namespace App\Services\Admin;

use App\Models\Area;
use Illuminate\Http\Request;
use App\Repositories\Admin\AreaRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AreaService
{
    /**
     * Area Service Constructor.
     *
     * @param AreaRepository $repository
     */
    public function __construct(public AreaRepository $repository) {}

    /**
     * Get Areas.
     *
     * @return Collection
     */
    public function getAllAreas() : Collection
    {
        return $this->repository->all()->get();
    }

    /**
     * Get Areas with pagination.
     *
     * @param Request $request
     * @param integer $perPage
     * @param string $orderBy
     * @return LengthAwarePaginator
     */
    public function getAllAreasWithPagination(Request $request, int $perPage = 10, string $orderBy = "DESC") : LengthAwarePaginator
    {
        $areas = $this->repository
                    ->all()
                    ->newQuery();

        if($request->has("search")) {
            if($request->has("trans") && $request->trans != "all") {
                $areas->where('name->' . $request->trans, 'LIKE', "%{$request->search}%");
            }
        }

        return $areas->orderBy("created_at", $orderBy)->paginate($perPage);
    }

    /**
     * Get Area using ID.
     *
     * @param integer $id
     * @return Area
     */
    public function getAreaUsingID(int $id) : Area
    {
        return $this->repository
                    ->all()
                    ->where('id',$id)
                    ->first();
    }

    /**
     * Create New Area.
     *
     * @param Request $request
     * @return array
     */
    public function createArea(Request $request) : array
    {


        $area = $this->repository->store(
            $request->except('_method', '_token')
        );

        if(!empty($area)) {
            return [
                "success" => true,
                "title" => trans("admin.areas.messages.created_successfully_title"),
                "body" => trans("admin.areas.messages.created_successfully_body"),
                "id" => $area->id
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.areas.messages.created_error_title"),
            "body" => trans("admin.areas.messages.created_error_body"),
        ];
    }

    /**
     * Update Area Using ID.
     *
     * @param integer $area_id
     * @param Request $request
     * @return array
     */
    public function updateArea(int $area_id, Request $request) : array
    {

        $area = $this->getAreaUsingID($area_id);

        $this->repository->update($request->except('_method', '_token'), $area);

        return [
            "success" => true,
            "title" => trans("admin.areas.messages.updated_successfully_title"),
            "body" => trans("admin.areas.messages.updated_successfully_body"),
        ];
    }

    /**
     * Delete Area Using.
     *
     * @param int $area_id
     * @return array
     */
    public function deleteArea(int $area_id) : array
    {
        $area = $this->getAreaUsingID($area_id);
        $isDeleted = $this->repository->delete($area);

        if($isDeleted == true) {
            return [
                "success" => true,
                "title" => trans("admin.areas.messages.deleted_successfully_title"),
                "body" => trans("admin.areas.messages.deleted_successfully_message"),
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.areas.messages.deleted_error_title"),
            "body" => trans("admin.areas.messages.deleted_error_message"),
        ];
    }
}
