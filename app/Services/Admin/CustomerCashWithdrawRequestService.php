<?php
namespace App\Services\Admin;

use App\Enums\CustomerWithdrawRequestEnum;
use App\Http\Requests\Admin\CustomerWithdrawRequestUpdate;
use App\Models\CustomerCashWithdrawRequest;
use App\Repositories\Admin\CustomerCashWithdrawRequestRepository;
use App\Services\Wallet\CustomerWalletService;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class CustomerCashWithdrawRequestService
{
    /**
     * Country Service Constructor.
     *
     * @param CustomerCashWithdrawRequestRepository $repository
     */
    public function __construct(
        public CustomerCashWithdrawRequestRepository $repository,
    ) {}

    /**
     * @param Request $request
     * @param int $perPage=20
     * @return LengthAwarePaginator
     */
    public function getDataFiltered(Request $request, int $perPage = 20)
    {
        $customerSearch = $request->get('customer');
        $statusFilter = $request->get('status');
        return $this->repository
            ->all()
            ->when(
                $customerSearch,
                function ($query) use ($customerSearch) {
                    $query->whereHas(
                        'customer', function ($customerQuery) use ($customerSearch) {
                            $customerQuery->where('name', 'like' ,"%$customerSearch%");
                            $customerQuery->orWhere('phone', 'like' ,"%$customerSearch%");
                        }
                    );
                }
            )
            ->when($statusFilter && $statusFilter != "all", fn ($q) => $q->where('admin_action', $statusFilter))
            ->orderBy('id', 'desc')
            ->with('customer.ownWallet')
            ->paginate($perPage);
    }

    /**
     * @param int $id
     * @return CustomerCashWithdrawRequest
     */
    public function show(int $id) : CustomerCashWithdrawRequest
    {
        return $this->repository->getModelUsingID($id)->load('customer.ownWallet', 'admin');
    }

    /**
     * @param CustomerCashWithdrawRequest $model
     * @param CustomerWithdrawRequestUpdate $request
     * @return bool
     * @throws Exception
     */
    public function approve(CustomerCashWithdrawRequest $model, CustomerWithdrawRequestUpdate $request) : bool
    {
        CustomerWalletService::withdraw($model->customer, $model->amount, $request->transaction_type);
        $this->repository->update([
            'admin_action' => CustomerWithdrawRequestEnum::APPROVED,
            'bank_receipt' => $request->file('bank_receipt'),
            'admin_id' => $request->get('admin_id')
        ], $model);
        return true;
    }

    /**
     * @param CustomerCashWithdrawRequest $model
     * @param CustomerWithdrawRequestUpdate $request
     * @return bool
     * @throws Exception
     */
    public function reject(CustomerCashWithdrawRequest $model, CustomerWithdrawRequestUpdate $request) : bool
    {
        $this->repository->update(
            [
                'admin_action' => CustomerWithdrawRequestEnum::NOT_APPROVED,
                'reject_reason' => $request->get('reject_reason'),
                'admin_id' => $request->get('admin_id')
            ],
            $model
        );
        return true;
    }

    public function getModelAsArray(CustomerCashWithdrawRequest $model) : array {
        $data = [
            ['key' => 'request-id', 'value' => $model->id],
            ['key' => 'customer-name', 'value' => $model?->customer?->name],
            ['key' => 'customer-phone', 'value' => $model?->customer?->phone],
            ['key' => 'customer-balance', 'value' => $model?->customer?->ownWallet?->amount_with_sar .' '.__('translation.sar')],
            ['key' =>  'status', 'value' => __('admin.customer_finances.customer-cash-withdraw.statuses.'. $model->admin_action), 'class' => $this->getStatusClass($model->admin_action)],
            ['key' => 'request-amount', 'value' => $model->amount],
            ['key' => 'request-bank-name', 'value' => $model->bank ? $model->bank->name : trans("admin.not_found")],
            ['key' => 'request-bank-account-name', 'value' => $model->bank_account_name],
            ['key' => 'request-bank-account-iban', 'value' => $model->bank_account_iban],
        ];
        if ($model->admin_action == CustomerWithdrawRequestEnum::NOT_APPROVED) {
            $data[] = ['key' => 'reject-reason', 'value' => $model->reject_reason];
            $data[] = ['key' => 'rejected-by', 'value' => $model->admin?->name];
        }

        return $data;
    }

    private function getStatusClass($status) {
        switch($status) {
            case CustomerWithdrawRequestEnum::PENDING:
                return "badge badge-soft-info text-uppercase font-size-14";
            case CustomerWithdrawRequestEnum::APPROVED:
                return "badge badge-soft-success text-uppercase font-size-14";
            case CustomerWithdrawRequestEnum::NOT_APPROVED:
                return "badge badge-soft-danger text-uppercase font-size-14";
        }
    }
}
