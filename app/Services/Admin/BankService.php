<?php

namespace App\Services\Admin;

use App\Enums\BankStatus;
use Exception;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Repositories\Admin\BankRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BankService
{
    /**
     * Bank Service Constructor.
     *
     * @param BankRepository $repository
     */
    public function __construct(public BankRepository $repository) {}

    /**
     * Get Banks.
     *
     * @return Collection
     */
    public function getAllBanks() : Collection
    {
        return $this->repository->all()->get();
    }

    /**
     * Get Banks with pagination.
     *
     * @param Request $request
     * @param integer $perPage
     * @param string $orderBy
     * @return LengthAwarePaginator
     */
    public function getAllBanksWithPagination(Request $request, int $perPage = 10, string $orderBy = "DESC") : LengthAwarePaginator
    {
        return $this->repository
        ->all()
        ->newQuery()
        ->when(
            $request->has("search") && $request->get("trans") && $request->get("trans") != "all",
            function ($query) use ($request) {
                $query->where("name->". $request->get('trans'), "like", "%{$request->get('search')}%");
            }
        )
        ->when(
            $request->has('is_active') && in_array($request->get('is_active'), [0,1]),
            function ($query) use ($request) {
                $query->where("is_active", "=", request("is_active"));
            }
        )
        ->orderBy("id", $orderBy)
        ->paginate($perPage);
    }
    /**
     * Get Bank using ID.
     *
     * @param integer $id
     * @return Bank
     */
    public function getBankUsingID(int $id) : Bank
    {
        return $this->repository
                    ->all()
                    ->where('id',$id)
                    ->first();
    }

    /**
     * Create New Bank.
     *
     * @param Request $request
     * @return array
     */
    public function createBank(Request $request) : array
    {
        $request->merge([
            "name" => [
                "ar" => $request->name_ar,
                "en" => $request->name_en
            ]
        ]);

        if($request->is_active == null) {
            $request->merge(["is_active" => $request->is_active]);
        }

        $bank = $this->repository->store(
            $request->except('_method', '_token')
        );

        if(!empty($bank)) {
            return [
                "success" => true,
                "title" => trans("admin.banks.messages.created_successfully_title"),
                "body" => trans("admin.banks.messages.created_successfully_body"),
                "id" => $bank->id
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.banks.messages.created_error_title"),
            "body" => trans("admin.banks.messages.created_error_body"),
        ];
    }

    /**
     * Update Bank Using ID.
     *
     * @param integer $bank_id
     * @param Request $request
     * @return array
     */
    public function updateBank(int $bank_id, Request $request) : array
    {
        $request->merge([
            "name" => [
                "ar" => $request->name_ar,
                "en" => $request->name_en
            ]
        ]);

        $bank = $this->getBankUsingID($bank_id);

        $this->repository->update($request->except('_method', '_token'), $bank);

        return [
            "success" => true,
            "title" => trans("admin.banks.messages.updated_successfully_title"),
            "body" => trans("admin.banks.messages.updated_successfully_body"),
        ];
    }

    /**
     * Delete Bank Using.
     *
     * @param int $bank_id
     * @return array
     */
    public function deleteBank(int $bank_id) : array
    {
        $bank = $this->getBankUsingID($bank_id);
        $isDeleted = $this->repository->delete($bank);

        if($isDeleted == true) {
            return [
                "success" => true,
                "title" => trans("admin.banks.messages.deleted_successfully_title"),
                "body" => trans("admin.banks.messages.deleted_successfully_message"),
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.banks.messages.deleted_error_title"),
            "body" => trans("admin.banks.messages.deleted_error_message"),
        ];
    }
}
