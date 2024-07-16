<?php

namespace App\Services\Admin;

use App\Models\PalmLength;
use Exception;
use App\Models\PreharvestPalmLength;
use Illuminate\Support\Str;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Admin\PalmLengthRepository;
use App\Repositories\Admin\PreharvestPalmLengthRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PalmLengthService
{

    public function __construct(public PalmLengthRepository $repository) {}

    public function getAllPalmLengths() : Collection
    {
        return $this->repository->all()->get();
    }


    public function getAllPalmLengthsWithPagination(Request $request, int $perPage = 10, string $orderBy = "DESC") : LengthAwarePaginator
    {
        $palm_lengths = $this->repository
                    ->all()
                    ->newQuery();

        if ($request->has("is_active") && $request->is_active !== "all") {
            $palm_lengths->where("is_active", "=", $request->is_active);
        }

        return $palm_lengths->orderBy("created_at", $orderBy)->paginate($perPage);
    }


    public function getPalmLengthUsingID(int $id) : PalmLength
    {
        return $this->repository
                    ->all()
                    ->where('id',$id)
                    ->first();
    }

    public function createPalmLength($request) : array
    {
        if($request->is_active == null) {
            $request->merge(["is_active" => $request->is_active]);
        }

        $palm_length = $this->repository->store(
            $request->except('_method', '_token')
        );

        if(!empty($palm_length)) {
            return [
                "success" => true,
                "title" => trans("admin.palm-length.messages.created_successfully_title"),
                "body" => trans("admin.palm-length.messages.created_successfully_body"),
                "id" => $palm_length->id
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.palm-length.messages.created_error_title"),
            "body" => trans("admin.palm-length.messages.created_error_body"),
        ];
    }


    public function updatePalmLength(int $palm_length_id, $request) : array
    {
        $palm_length = $this->getPalmLengthUsingID($palm_length_id);

        $this->repository->update($request->except('_method', '_token'), $palm_length);

        return [
            "success" => true,
            "title" => trans("admin.palm-length.messages.updated_successfully_title"),
            "body" => trans("admin.palm-length.messages.updated_successfully_body"),
        ];
    }


    public function deletePalmLength(int $palm_length_id) : array
    {
        $palm_length = $this->getPalmLengthUsingID($palm_length_id);

        if(!empty($palm_length)) {

            $isDeleted = $this->repository->delete($palm_length);

            if($isDeleted == true) {
                return [
                    "success" => true,
                    "title" => trans("admin.palm-length.messages.deleted_successfully_title"),
                    "body" => trans("admin.palm-length.messages.deleted_successfully_message"),
                ];
            }
        }


        return [
            "success" => false,
            "title" => trans("admin.palm-length.messages.deleted_error_title"),
            "body" => trans("admin.palm-length.messages.deleted_error_message"),
        ];
    }
}
