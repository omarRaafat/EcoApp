<?php

namespace App\Services\Api;

use App\Models\Qna;
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
     * @param integer $perPage
     * @return LengthAwarePaginator
     */
    public function getAllQnasWithPagination(int $perPage = 10) : LengthAwarePaginator
    {
        return $this->repository->all()->paginate($perPage);
    }

    /**
     * Get Qna using ID.
     *
     * @param integer $id
     * @return Qna
     */
    public function getQnaUsingID(int $id) : Qna
    {
        return $this->repository->getModelUsingID($id);
    }
}
