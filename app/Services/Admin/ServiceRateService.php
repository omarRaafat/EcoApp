<?php

namespace App\Services\Admin;

use App\Enums\AdminApprovedState;
use Exception;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Database\Query\Builder;
use App\Repositories\Admin\ServiceRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Exports\ReviewExport;
use App\Exports\ServiceReviewExport;
use App\Models\ServiceReview;
use App\Repositories\Admin\ServiceRateRepository;
use Excel;

class ServiceRateService
{
    /**
     * Service Rate Service Constructor.
     *
     * @param ServiceRateRepository $repository
     */
    public function __construct(public ServiceRateRepository $repository,
    public ServiceRepository $serviceRepository) {}

    /**
     * Get Services Rates.
     *
     * @return Collection
     */
    public function getAllServiceRates() : Collection
    {
        return $this->repository->all()->get();
    }

    /**
     * Get Services Rates with pagination.
     *
     * @param Request $request
     * @param integer $perPage
     * @param string $orderBy
     * @return LengthAwarePaginator
     */
    public function getAllServiceRatesWithPagination(Request $request, int $perPage = 50, string $orderBy = "DESC")
    {
        $serviceRates = $this->repository
            ->all()
            ->newQuery()
            ->when(
                $request->has('search') &&
                $request->has('relation') &&
                in_array($request->get('relation'), ServiceReview::ALLOWED_FILTER_RELATION),
                fn ($q) => $q->whereHas(
                    $request->get('relation'),
                    fn ($relation) => $relation->where('name', 'like', "%{$request->search}%")
                )
            )
            ->when(
                $request->has("admin_approved") && $request->filled("admin_approved"), fn($q) =>
                     $q->where('admin_approved' , $request->get("admin_approved"))

            )
            ->filterPeriod()->filterAvgRating();

        if($request->action == "exportExcel"){
            $filename = date('Ymd_H').'ServiceRates.xlsx';
            return Excel::download(new ServiceReviewExport($serviceRates->orderBy("created_at", $orderBy)->get()), $filename, \Maatwebsite\Excel\Excel::XLSX);
        }

        return $serviceRates->orderBy("created_at", $orderBy)->paginate($perPage);
    }

    /**
     * Get Service Rate using ID.
     *
     * @param integer $id
     * @return ServiceReview
     */
    public function getServiceRateUsingID(int $id) : ServiceReview
    {
        return $this->repository
                    ->all()
                    ->where('id',$id)
                    ->first();
    }

    /**
     * Update ServiceRate Using ID.
     *
     * @param integer $review_id
     * @param Request $request
     * @return array
     */
    public function updateServiceRate(int $review_id, Request $request) : array
    {
        $request->merge([
            "admin_id" => auth()->user()->id,
        ]);

        $serviceRate = $this->getServiceRateUsingID($review_id);
        $this->repository->update($request->except('_method', '_token'), $serviceRate);
        $this->serviceRepository->calculateRate($serviceRate->service_id);


        return [
            "success" => true,
            "title" => trans("admin.serviceRates.messages.updated_successfully_title"),
            "body" => trans("admin.serviceRates.messages.updated_successfully_body"),
        ];
    }

    /**
     * Delete Service Rate Using.
     *
     * @param int $review_id
     * @return array
     */
    public function deleteServiceRate(int $review_id) : array
    {
        $serviceRate = $this->getServiceRateUsingID($review_id);
        $isDeleted = $this->repository->delete($serviceRate);

        if($isDeleted == true) {
            return [
                "success" => true,
                "title" => trans("admin.serviceRates.messages.deleted_successfully_title"),
                "body" => trans("admin.serviceRates.messages.deleted_successfully_message"),
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.serviceRates.messages.deleted_error_title"),
            "body" => trans("admin.serviceRates.messages.deleted_error_message"),
        ];
    }
}
