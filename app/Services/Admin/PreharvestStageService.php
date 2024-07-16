<?php

namespace App\Services\Admin;

use Exception;
use App\Models\PreharvestStage;
use Illuminate\Support\Str;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Admin\StageRepository;
use App\Repositories\Admin\PreharvestStageRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PreharvestStageService
{

    public function __construct(public PreharvestStageRepository $repository) {}

    public function getAllStages() : Collection
    {
        return $this->repository->all()->get();
    }


    public function getAllStagesWithPagination(Request $request, int $perPage = 10, string $orderBy = "DESC") : LengthAwarePaginator
    {
        $stages = $this->repository
                    ->all()
                    ->newQuery();

        if($request->has("search")) {
            $stages->where('name->ar', 'LIKE', "%{$request->search}%");
        }

        if ($request->has("is_active") && $request->is_active !== "all") {
            $stages->where("is_active", "=", $request->is_active);
        }

        return $stages->orderBy("created_at", $orderBy)->paginate($perPage);
    }


    public function getStageUsingID(int $id) : PreharvestStage
    {
        return $this->repository
                    ->all()
                    ->where('id',$id)
                    ->first();
    }

    public function createStage($request) : array
    {
        if($request->is_active == null) {
            $request->merge(["is_active" => $request->is_active]);
        }

        $stage = $this->repository->store(
            $request->except('_method', '_token')
        );

        if(!empty($stage)) {
            return [
                "success" => true,
                "title" => trans("admin.stages.messages.created_successfully_title"),
                "body" => trans("admin.stages.messages.created_successfully_body"),
                "id" => $stage->id
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.stages.messages.created_error_title"),
            "body" => trans("admin.stages.messages.created_error_body"),
        ];
    }


    public function updateStage(int $stage_id, $request) : array
    {
        $stage = $this->getStageUsingID($stage_id);

        $this->repository->update($request->except('_method', '_token'), $stage);

        return [
            "success" => true,
            "title" => trans("admin.stages.messages.updated_successfully_title"),
            "body" => trans("admin.stages.messages.updated_successfully_body"),
        ];
    }


    public function deleteStage(int $stage_id) : array
    {
        $stage = $this->getStageUsingID($stage_id);

        if(!empty($stage)) {

            $isDeleted = $this->repository->delete($stage);

            if($isDeleted == true) {
                return [
                    "success" => true,
                    "title" => trans("admin.stages.messages.deleted_successfully_title"),
                    "body" => trans("admin.stages.messages.deleted_successfully_message"),
                ];
            }
        }


        return [
            "success" => false,
            "title" => trans("admin.stages.messages.deleted_error_title"),
            "body" => trans("admin.stages.messages.deleted_error_message"),
        ];
    }
}
