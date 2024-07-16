<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\StaticContentRequest;
use App\Models\StaticContent;
use App\Repositories\StaticContentRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StaticContentService
{
    public function __construct(public StaticContentRepository $repository) {}

    /**
     * @param int $perPage = 20
     * @return LengthAwarePaginator
     */
    public function getAboutUsPaginated(int $perPage = 20, string $keyword = "") : LengthAwarePaginator
    {
        return $this->getSearchedSortedBaseQuery($keyword)->aboutUs()->paginate($perPage);
    }
    /**
     * @param int $perPage = 20
     * @return LengthAwarePaginator
     */
    public function getUsageAndAgreementPaginated(int $perPage = 20, string $keyword = "") : LengthAwarePaginator
    {
        return $this->getSearchedSortedBaseQuery($keyword)->usageAndAgreement()->paginate($perPage);
    }

    /**
     * @param int $perPage = 20
     * @return LengthAwarePaginator
     */
    public function getPrivacyPolicyPaginated(int $perPage = 20, string $keyword = "") : LengthAwarePaginator
    {
        return $this->getSearchedSortedBaseQuery($keyword)->privacyPolicy()->paginate($perPage);
    }

    private function getSearchedSortedBaseQuery(string $keyword = "") {
        return $this->repository->all()->orderBy('id', 'desc')
            ->when($keyword, function ($q) use ($keyword) {
                $q->where(function ($subQ) use ($keyword) {
                    $subQ->where("title->ar", 'like', "%$keyword%")
                        ->orWhere("title->en", 'like', "%$keyword%");
                });
            });
    }

    /**
     * @param StaticContentRequest $contentRequest
     * @return StaticContent
     */
    public function create(StaticContentRequest $contentRequest, string $type) : StaticContent
    {
        $data=$contentRequest->validated();
        $data['type']=$type;
        return $this->repository->store($data);
    }

    /**
     * @param int $contentId
     * @param StaticContentRequest $contentRequest
     * @return StaticContent
     */
    public function update(int $contentId, StaticContentRequest $contentRequest) : StaticContent
    {
        $data=$contentRequest->validated();
        return $this->repository->update($data, $this->repository->getModelUsingID($contentId));
    }

    /**
     * @param int $contentId
     * @return bool
     */
    public function delete(int $contentId) : bool
    {
        return $this->repository->delete($this->repository->getModelUsingID($contentId));
    }

    /**
     * @param int $contentId
     * @return StaticContent
     */
    public function show(int $contentId) : StaticContent
    {
        return $this->repository->getModelUsingID($contentId);
    }
}
