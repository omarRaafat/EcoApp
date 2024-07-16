<?php

namespace App\Services\Admin;

use Exception;
use App\Models\Wallet;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Enums\WalletTransactionTypes;
use App\Enums\WalletHistoryTypeStatus;
use App\Http\Resources\Admin\WalletResource;
use App\Repositories\Admin\WalletRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Admin\CustomerRepository;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\Admin\WalletTransactionHistoryRepository;

class WalletService
{
    /**
     * Wallet Service Constructor.
     *
     * @param WalletRepository $repository
     * @param WalletTransactionHistoryRepository $transactionRepository
     * @param CustomerRepository $customerRepository
     * @param LogService $logger
     */
    public function __construct(
        public WalletRepository $repository,
        public WalletTransactionHistoryRepository $transactionRepository,
        public CustomerRepository $customerRepository,
        public LogService $logger
    )
    {
    }

    /**
     * Get Wallets.
     *
     * @return Collection
     */
    public function getAllWallets(): Collection
    {
        return $this->repository->all()->get();
    }

    /**
     * Get Wallets with pagination.
     *
     * @param integer $perPage
     * @return LengthAwarePaginator
     */
    public function getAllWalletsWithPagination(int $perPage = 10, string $orderBy = "DESC", Request $request): LengthAwarePaginator
    {
        return $this->repository
            ->all()
            ->with([
                "customer",
                "admin"
            ])->newQuery()
            ->when(
                $request->has('search'),
                fn($q) => $q->whereHas(
                    'customer',
                    fn ($subQ) => $subQ->where('name', 'LIKE', "%{$request->get('search')}%")
                )
            )
            ->when(
                $request->has('is_active') && in_array($request->get('is_active'), [0,1]),
                fn($q) => $q->where("is_active", "=", $request->get('is_active'))
            )
            ->orderBy("id", $orderBy)
            ->paginate($perPage);
    }

    public function search()
    {

    }

    public function filter()
    {

    }

    /**
     * Get Wallet using ID.
     *
     * @param integer $id
     * @return Wallet
     */
    public function getWalletUsingID(int $id): Wallet
    {
        return $this->repository
            ->all()
            ->where('id', $id)
            ->with([
                'customer',
                'admin',
                'transactions',
                'media'
            ])
            ->first();
    }

    /**
     * Get Wallet using ID.
     *
     * @param integer $id
     * @return Wallet
     */
    public function getTrashedWalletUsingID(int $id): Wallet
    {
        return $this->repository
            ->all()
            ->where('id', $id)
            ->with([
                'customer',
                'admin',
                'transactions',
                'media'
            ])
            ->withTrashed()
            ->first();
    }

    /**
     * Get Wallet transactions history using wallet $id.
     *
     * @param integer $id
     * @param integer $perPage
     * @param string $orderBy
     * @return LengthAwarePaginator
     */
    public function getWalletTransactionsWithPagination(
        int $id,
        int $perPage = 10,
        string $orderBy = "DESC",
        Request $request
    ): LengthAwarePaginator
    {
        // return $this->transactionRepository
        //             ->all()
        //             ->where("wallet_id", $id)
        //             ->orderBy("created_at", $orderBy)
        //             ->paginate($perPage);

        return $this->transactionRepository
            ->all()
            ->where("wallet_id", $id)
            ->with([
                "customer",
                "userDoTransaction",
                "created_by.user",
                "wallet"
            ])->newQuery()
            ->when(
                $request->has('created_at') && $request->get('created_at') != '',
                function ($q) use ($request) {
                    $date = Carbon::parse($request->get('created_at'))->format("Y-m-d");
                    $q->where('created_at', '>=', "$date 00:00:00");
                    $q->where('created_at', '<=', "$date 23:59:59");
                }
            )
            ->when(
                $request->has('type') && $request->get('type') != "all" && in_array($request->get('type'), [0,1]),
                fn($q) => $q->where("type", $request->get('type'))
            )
            ->orderBy('id', $orderBy)
            ->paginate($perPage);
    }

    /**
     * Create New Customer Wallet.
     *
     * @param Request $request
     * @return array
     */
    public function createWallet(Request $request): array
    {
        if ($walletId = $this->_isCustomerHasDeletedWallet($request->customer_id)) {
            $w = $this->getTrashedWalletUsingID($walletId);
            $w->restore();
            return $this->updateWalletStatus($walletId, $request);
        } else if ( $this->_isCustomerHasWallet($request->customer_id) ) {
            return [
                "success" => false,
                "title" => trans("admin.customer_finances.wallets.messages.customer_has_wallet_title"),
                "body" => trans("admin.customer_finances.wallets.messages.customer_has_wallet_message"),
            ];
        }

        $request->merge([
            "admin_id" => auth()->user()->id ?? null,
            "is_active" => !empty($request->is_active) ? $request->is_active : false
        ]);

        $wallet = $this->repository->store($request->except('_method', '_token', 'attachment'));

        $this->_createAttachment($wallet, $request);

        if (!empty($wallet)) {
            $this->logger->InLog([
                'user_id' => auth()->user()->id ?? null,
                'action' => "CreateCustomerWallet",
                'model_type' => "\App\Models\User",
                'model_id' => $request->customer_id,
                'object_before' => null,
                'object_after' => $wallet
            ]);

            return [
                "success" => true,
                "title" => trans("admin.customer_finances.wallets.messages.created_successfully_title"),
                "body" => trans("admin.customer_finances.wallets.messages.created_successfully_body"),
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.customer_finances.wallets.messages.created_error_title"),
            "body" => trans("admin.customer_finances.wallets.messages.created_error_body"),
        ];
    }

    /**
     * Update customer wallet status.
     *
     * @param integer $wallet_id
     * @param Request $request
     * @return array
     */
    public function updateWalletStatus(int $wallet_id, Request $request): array
    {
        $wallet = $this->getWalletUsingID($wallet_id);
        $oldWalletObject = clone $wallet;
        $isUpdated = $wallet->update($request->except('_method', '_token'));

        if ($isUpdated == true) {
            $this->logger->InLog([
                'user_id' => auth()->user()->id,
                'action' => "UpdateCustomerWallet",
                'model_type' => "\App\Models\User",
                'model_id' => $request->customer_id,
                'object_before' => $oldWalletObject,
                'object_after' => $wallet
            ]);

            return [
                "success" => true,
                "title" => trans("admin.customer_finances.wallets.messages.updated_successfully_title"),
                "body" => trans("admin.customer_finances.wallets.messages.updated_successfully_body"),
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.customer_finances.wallets.messages.updated_error_title"),
            "body" => trans("admin.customer_finances.wallets.messages.updated_error_body"),
        ];
    }

    /**
     * Create new attachment using spatie medialibrary and assossiate it to wallet.
     *
     * @param Wallet $wallet
     * @param Request $request
     * @return void
     */
    private function _createAttachment(Wallet $wallet, Request $request): void
    {
        if ($request->has("attachment")) {
            $fileName = "attachment_" . time();
            $fileExtension = $request->file('attachment')->getClientOriginalExtension();
            $wallet->addMediaFromRequest("attachment")
                ->usingName($fileName)
                ->setFileName($fileName . '.' . $fileExtension)
                ->toMediaCollection("wallets");
        }
    }

    /**
     * Increase And Decrease Amount in wallet transaction history.
     *
     * @param  int  $id
     * @param Request $request
     * @return array
     */
    public function increaseAndDecreaseAmount(int $wallet_id, Request $request): array
    {
        $wallet = $this->getWalletUsingID($wallet_id);
        $oldWalletObject = clone $wallet;
        $transactionResult = $this->_manageBalance($wallet, $request);

        if ($transactionResult["success"] == true) {
            $this->logger->InLog([
                'user_id' => auth()->user()->id ?? $wallet->custumer_id,
                'action' => $transactionResult["type"] . "WalletBalance",
                'model_type' => "\App\Models\User",
                'model_id' => $wallet->customer_id,
                'object_before' => $oldWalletObject,
                'object_after' => $wallet
            ]);
        }

        return [
            "success" => $transactionResult["success"],
            "title" => $transactionResult["title"],
            "body" => $transactionResult["body"],
        ];
    }

    /**
     * Manage Balance by add or subtract.
     *
     * @param Wallet $wallet
     * @param Request $request
     * @return array
     */
    private function _manageBalance(Wallet $wallet, Request $request): array
    {
        if ((int) $request->type == WalletHistoryTypeStatus::ADD) {
            return $this->_addBalanceToWallet($wallet, $request);
        }

        if ((int) $request->type == WalletHistoryTypeStatus::SUB) {
            return $this->_subBalanceFromWallet($wallet, $request);
        }
    }

    /**
     * Add balance to wallet transaction history if the amount not empty.
     *
     * @param Wallet $wallet
     * @param Request $request
     * @return boolean
     */
    private function _addOpeningBalanceToWalletWhenCreated(Wallet $wallet, Request $request): bool
    {
        $request->merge([
            "is_opening_balance" => true
        ]);

        if ($this->_addBalanceToWallet($wallet, $request)["success"] == true) {
            return true;
        }
        ;

        return false;
    }

    /**
     * Add balance To the wallet.
     *
     * @param Wallet $wallet
     * @param Request $request
     * @return array
     */
    private function _addBalanceToWallet(Wallet $wallet, Request $request): array
    {
        $addedBalanceToHalala = $request->amount;

        DB::beginTransaction();

        $is_opening_balance = $this->_isThisAnOpeningBalance($wallet);

        $authed_user = auth("api")->check() ? auth("api")->user() : auth()->user();

        try {
            $transactionRecorde = $this->transactionRepository->store([
                "customer_id" => $wallet->customer_id,
                "wallet_id" => $wallet->id,
                "type" => WalletHistoryTypeStatus::ADD,
                "amount" => $addedBalanceToHalala,
                "is_opening_balance" => !empty($request->is_opening_balance) || $is_opening_balance ?? true,
                "transaction_type" => (int) $request->transaction_type,
                "user_id" => $authed_user->id ?? $wallet->customer_id
            ]);


            if ($request->is_opening_balance == true) {
                $transactionRecorde->wallet()->update([
                    "amount" => $wallet->amount
                ]);
            } else {
                $transactionRecorde->wallet()->update([
                    "amount" => $wallet->amount + ($addedBalanceToHalala * 100)
                ]);
            }

            DB::commit();

            return [
                "success" => true,
                "title" => trans("admin.customer_finances.wallets.transaction.success_add_title"),
                "body" => trans("admin.customer_finances.wallets.transaction.success_add_message"),
                "type" => "Add",
                "new_transaction_record" => $transactionRecorde,
            ];
        } catch (Exception $e) {
            DB::rollback();
            return [
                "success" => true,
                "title" => trans("admin.customer_finances.wallets.transaction.fail_add_title"),
                "body" => trans("admin.customer_finances.wallets.transaction.fail_add_message"),
            ];
        }

    }

    /**
     * Subtract balance From the wallet.
     *
     * @param Wallet $wallet
     * @param Request $request
     * @return array
     */
    private function _subBalanceFromWallet(Wallet $wallet, Request $request): array
    {
        $subtractedBalanceToHalala = $request->amount;
        $authed_user = auth("api")->check() ? auth("api")->user() : auth()->user();

        if ($this->_checkBalanceBeforeSubtration($wallet->amount, $subtractedBalanceToHalala) == false) {
            return [
                "success" => false,
                "title" => trans("admin.customer_finances.wallets.transaction.fail_sub_title"),
                "body" => trans("admin.customer_finances.wallets.transaction.cannot_subtract_message"),

            ];
        }

        DB::beginTransaction();

        try {
            $transactionRecorde = $this->transactionRepository->store([
                "customer_id" => $wallet->customer_id,
                "wallet_id" => $wallet->id,
                "type" => WalletHistoryTypeStatus::SUB,
                "amount" => $subtractedBalanceToHalala,
                "is_opening_balance" => !empty($request->is_opening_balance) ?? true,
                "transaction_type" => (int) $request->transaction_type,
                "user_id" => $authed_user->id ?? $wallet->customer_id
            ]);

            $isAmountUpdatedSuccessfully = $transactionRecorde->wallet()->update([
                "amount" => ($wallet->amount - ($subtractedBalanceToHalala * 100))
            ]);

            DB::commit();

            if ($isAmountUpdatedSuccessfully == true) {
                return [
                    "success" => true,
                    "title" => trans("admin.customer_finances.wallets.transaction.success_sub_title"),
                    "body" => trans("admin.customer_finances.wallets.transaction.success_sub_message"),
                    "type" => "Add",
                    "new_transaction_record" => $transactionRecorde,
                ];
            }
        } catch (Exception $e) {
            DB::rollback();
            return [
                "success" => false,
                "title" => trans("admin.customer_finances.wallets.transaction.fail_sub_title"),
                "body" => trans("admin.customer_finances.wallets.transaction.fail_sub_message")
            ];
        }
    }

    /**
     * Check the balance Before subtraction.
     *
     * @param integer $walletAmount
     * @param integer $subtractionBalance
     * @return boolean
     */
    private function _checkBalanceBeforeSubtration(int $walletAmount, int $subtractedBalanceToHalala): bool
    {
        if ($walletAmount >= $subtractedBalanceToHalala) {
            return true;
        }

        return false;
    }

    /**
     * Check if the customer has wallet.
     *
     * @param int $customer_id
     * @return boolean
     */
    private function _isCustomerHasWallet($customer_id): bool
    {
        return Wallet::where('customer_id', $customer_id)->exists();
    }

    /**
     * Check if the customer has wallet.
     *
     * @param int $customer_id
     * @return boolean
     */
    private function _isCustomerHasDeletedWallet($customer_id)
    {
        return Wallet::withTrashed()->where('customer_id', $customer_id)->first()->id ?? null;
    }

    /**
     * Check if this transaction is opening balance.
     *
     * @param Wallet $wallet
     * @return boolean
     */
    private function _isThisAnOpeningBalance(Wallet $wallet): bool
    {
        return $wallet->transactions->count() < 1 ?? true;
    }
}