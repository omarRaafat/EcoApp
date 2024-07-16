<?php

namespace App\Services\Admin;

use App\Enums\VendorWallet as VendorWalletEnum;
use Exception;
use App\Models\VendorWallet;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Admin\VendorWalletRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\Admin\VendorWalletTransactionRepository;
use App\Models\Order;

class VendorWalletService
{
    /**
     * Vendor Wallet Service Constructor.
     *
     * @param VendorWalletRepository $repository
     * @param VendorWalletTransactionRepository $transactionRepository
     * @param LogService $logger
     */
    public function __construct(
        public VendorWalletRepository $repository,
        public VendorWalletTransactionRepository $transactionRepository,
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
    public function getAllVendorWalletsWithPagination(int $perPage = 10, string $orderBy = "DESC", Request $request ,  $conditions = null)
    {
      
        $vendor = $request->get('search', null);
        return $this->repository->all()
            ->with(["vendor", "vendor.owner"])
            ->newQuery()
            ->when(
                $vendor,
                fn($q) => $q->where(
                    fn($subQ) => $subQ->whereHas(
                        'vendor.owner',
                        fn($ownerQ) => $ownerQ->where('name', 'LIKE', "%$vendor%")
                    )
                    ->orWhereHas(
                        'vendor',
                        fn($vendorQ) => $vendorQ->where(
                            fn ($_q) => $_q->where('name->ar', 'LIKE', "%$vendor%")->orWhere('name->en', 'LIKE', "%$vendor%")
                        )
                    )
                )
            )
            ->when($conditions , function($c) use ($conditions){
                foreach ($conditions as $condition) {
                    $c->where($condition['key'] , $condition['op'] , $condition['value']);
                }
            })
            ->orderBy("created_at", $orderBy)
            ->paginate($perPage);
    }

    /**
     * Get VendorWallet using ID.
     *
     * @param integer $id
     * @return VendorWallet
     */
    public function getVendorWalletUsingID(int $id): mixed
    {
        return $this->repository
            ->all()
            ->where('id', $id)
            ->with([
                'vendor',
                'transactions',
            ])
            ->first();
    }
    /**
     * Get VendorWallet using VendorID.
     *
     * @param integer $id
     * @return VendorWallet
     */
    public function getVendorWalletUsingVendorID(int $vendor_id): mixed
    {
        $vendorWallet = $this->repository
            ->all()
            ->where('vendor_id', $vendor_id)
            ->with([
                'vendor',
                'transactions',
            ])
            ->first();
        if(!$vendorWallet){
           $vendorWallet = VendorWallet::create(['vendor_id' => $vendor_id, 'balance' => 0]);
        }
        return $vendorWallet;
    }

    /**
     * Get VendorWallet transactions history using wallet $id.
     *
     * @param integer $id
     * @param integer $perPage
     * @param string $orderBy
     * @return LengthAwarePaginator
     */
    public function getVendorWalletTransactionsWithPagination(
        int $id,
        int $perPage = 10,
        string $orderBy = "DESC",
        Request $request,
        $conditions = null
    ): LengthAwarePaginator
    {
        $walletTransactions = $this->transactionRepository
            ->all()
            ->where("wallet_id", $id)
            ->when($conditions , function($c) use ($conditions){
                foreach ($conditions as $condition) {
                    $c->where($condition['key'] , $condition['op'] , $condition['value']);
                }
            })
            ->with([
                "wallet",
                "admin"
            ])->newQuery();
        if (isset($request->date_from)) {
            $walletTransactions=$walletTransactions->whereDate('created_at','>=',$request->date_from);
        }
        if (isset($request->date_to)) {
            $walletTransactions=$walletTransactions->whereDate('created_at','<=',$request->date_to);
        }
        if ($request->search) {
            $walletTransactions= $walletTransactions->whereHas('referenceOrder',function($qr){
                $qr->where('code',request()->get('search'));
            });
        }

        return $walletTransactions->orderBy("created_at", $orderBy)
            ->paginate($perPage);
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
        $wallet = $this->getVendorWalletUsingID($wallet_id);
        $transactionResult = $this->_subBalanceFromWallet($wallet, $request);
        // dd($transactionResult);

        return [
            "success" => $transactionResult["success"],
            "title" => $transactionResult["title"],
            "body" => $transactionResult["body"],
        ];
    }

    /**
     * Subtract balance From the wallet.
     *
     * @param VendorWallet $wallet
     * @param Request $request
     * @return array
     */
    private function _subBalanceFromWallet(VendorWallet $wallet, Request $request): array
    {
        $subtractedBalanceToHalala = $request->amount;
        $authed_user = auth()->user();
        // $is_updated = 0;
        if ($this->_checkBalanceBeforeSubtration($wallet->balance, $subtractedBalanceToHalala) == false) {
            return [
                "success" => false,
                "title" => "فشل عملية خصم الرصيد!",
                "body" => "رصيد المحقظة أقل من قيمة العملية",
            ];
        }

        $order = null;
        if(!empty($request->order_code)){
            $order = Order::where('code',$request->order_code)->first();
            if(!$order){
                return [
                    "success" => false,
                    "title" => "فشل عملية خصم الرصيد!",
                    "body" => 'يرجى تحقق من رقم الطلب الفرعي',
                ];
            }
        }

        DB::beginTransaction();
        try {
            $transactionRecorde = $this->transactionRepository->store([
                'wallet_id' => $wallet->id,
                'amount' => $subtractedBalanceToHalala,
                'operation_type' => VendorWalletEnum::OUT,
                'admin_id' => $authed_user->id,
                'reference' => ($order) ?  get_class($order) : null,
                'reference_id' => ($order) ? $order->id : null,
                'reference_num' => $request->reference_num,
                'reason' => $request->reason,
                'status' => 'completed',
            ]);

            if ($request->has("receipt")) {
                $fileName = "receipt_" . time();
                $fileExtension = $request->file('receipt')->getClientOriginalExtension();
                $transactionRecorde->addMediaFromRequest("receipt")
                    ->usingName($fileName)
                    ->setFileName($fileName . '.' . $fileExtension)
                    ->toMediaCollection("vendorWallets");
            }


            $isAmountUpdatedSuccessfully = $transactionRecorde->wallet()->update([
                "balance" => ($wallet->balance - $subtractedBalanceToHalala)
            ]);
            $is_updated = $isAmountUpdatedSuccessfully;
            DB::commit();

            // if ($isAmountUpdatedSuccessfully == true || $is_updated == 1) {
                return [
                    "success" => true,
                    "title" => "تمت العملية بنجاح",
                    "body" => "تم الخصم من محفظة التاجر",
                    "type" => "Add",
                    "new_transaction_record" => $transactionRecorde,
                ];
            // }
        } catch (Exception $e) {

            DB::rollback();
            return [
                "success" => false,
                "title" => "فشل عملية خصم الرصيد!",
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
    
}
