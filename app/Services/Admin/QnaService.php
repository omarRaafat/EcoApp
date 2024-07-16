<?php

namespace App\Services\Admin;

use App\Models\Qna;
use Illuminate\Http\Request;
use App\Repositories\Api\QnaRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class QnaService
{
    /**
     * Qna Service Constructor.
     *
     * @param QnaRepository $repository
     */
    public function __construct(public QnaRepository $repository) {}

    /**
     * Get Qnas.
     *
     * @return Collection
     */
    public function getAllQnas() : Collection
    {
        return $this->repository->all()->get();
    }

    /**
     * Get Qnas with pagination.
     *
     * @param Request $request
     * @param integer $perPage
     * @param string $orderBy
     * @return LengthAwarePaginator
     */
    public function getAllQnasWithPagination($request, int $perPage = 10, string $orderBy = "desc") : LengthAwarePaginator
    {
        $Qnas = $this->repository
        ->all()
        ->newQuery();

        if($request->has("search")) {
                if($request->has("trans") && $request->trans != "all") {
                        $Qnas->where('question->' . $request->trans, 'LIKE', "%{$request->search}%");
                    }else{
                        $Qnas->where('question->ar', 'LIKE', "%{$request->search}%")
                        ->orwhere('question->en', 'LIKE', "%{$request->search}%");

                    }

                }


        return $Qnas->orderBy("created_at", $orderBy)->paginate($perPage);
    }

    /**
     * Get Qna using ID.
     *
     * @param integer $id
     * @return Qna
     */
    public function getQnaUsingID(int $id) : Qna
    {
        return $this->repository
                    ->all()
                    ->where('id',$id)
                    ->first();
    }

    /**
     * Create New Qna.
     *
     * @param Request $request
     * @return array
     */
    public function createQna(Request $request) : array
    {
        $Qna = $this->repository->store(
            $request->except('_method', '_token')
        );

        if(!empty($Qna)) {
            return [
                "success" => true,
                "title" => trans("admin.qnas.messages.created_successfully_title"),
                "body" => trans("admin.qnas.messages.created_successfully_body"),
                "id" => $Qna->id
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.qnas.messages.created_error_title"),
            "body" => trans("admin.qnas.messages.created_error_body"),
        ];
    }

    /**
     * Update Qna Using ID.
     *
     * @param integer $Qna_id
     * @param Request $request
     * @return array
     */
    public function updateQna(int $Qna_id, Request $request) : array
    {

        $Qna = $this->getQnaUsingID($Qna_id);

        $this->repository->update($request->except('_method', '_token'), $Qna);

        return [
            "success" => true,
            "title" => trans("admin.qnas.messages.updated_successfully_title"),
            "body" => trans("admin.qnas.messages.updated_successfully_body"),
        ];
    }

    /**
     * Delete Qna Using.
     *
     * @param int $Qna_id
     * @return array
     */
    public function deleteQna(int $Qna_id) : array
    {
        $Qna = $this->getQnaUsingID($Qna_id);
        $isDeleted = $this->repository->delete($Qna);

        if($isDeleted == true) {
            return [
                "success" => true,
                "title" => trans("admin.qnas.messages.deleted_successfully_title"),
                "body" => trans("admin.qnas.messages.deleted_successfully_message"),
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.qnas.messages.deleted_error_title"),
            "body" => trans("admin.qnas.messages.deleted_error_message"),
        ];
    }
}
