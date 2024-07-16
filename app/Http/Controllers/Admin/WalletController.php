<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\View;
use App\Enums\WalletStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\WalletService;
use App\Enums\WalletHistoryTypeStatus;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Resources\Admin\WalletResource;
use App\Http\Resources\Admin\WalletsResource;
use App\Repositories\Admin\CustomerRepository;
use App\Http\Requests\Admin\CreateWalletRequest;
use App\Http\Requests\Admin\UpdateWalletRequest;
use App\Http\Resources\Admin\WalletTransactionHistoryResource;
use App\Http\Requests\Admin\IncreaseAndDecreaseWalletBalanceRequest;
use App\Jobs\CustomerSms\BalanceWithdrawal;
use App\Jobs\CustomerSms\DepositBalance;
use App\Services\Wallet\CustomerWalletService;
use Exception;

class WalletController extends Controller
{
    /**
     * Wallets Controller Constructor.
     *
     * @param WalletService $service
     */
    public function __construct(
        public WalletService $service,
        public CustomerRepository $customerRepository
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\View
     */
    public function index(Request $request)
    {
        $result = $this->service->getAllWalletsWithPagination(
            request: $request,
            perPage: 10,
            orderBy: "desc"
        );

        $activeWalletsCount = Wallet::activeWalletsCount();
        $inactiveWalletsCount = Wallet::inactiveWalletsCount();

        return view(
            "admin.wallets.index",
            ['wallets' => $result, 'activeWalletsCount' => $activeWalletsCount, 'inactiveWalletsCount' => $inactiveWalletsCount]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\View
     */
    public function create()
    {
        return redirect(route('admin.wallets.index'));
        $statusOfWallet = WalletStatus::getStatusListWithClass();
        $customers = $this->customerRepository->getCustomersList();
        $breadcrumbParent = 'admin.wallets.index';
        $breadcrumbParentUrl = route('admin.wallets.index');
        return view(
            "admin.wallets.create",
            compact('statusOfWallet', "customers", "breadcrumbParent", "breadcrumbParentUrl")
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateWalletRequest  $request
     * @return \Illuminate\Http\View
     */
    public function store(CreateWalletRequest $request)
    {
        return redirect(route('admin.wallets.index'));
        $result = $this->service->createWallet($request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.wallets.index");
        }

        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\View
     */
    public function show($id)
    {
        $wallet = new WalletsResource($this->service->getWalletUsingID($id));
        $statusOfWallet = WalletStatus::getStatusListWithClass();
        $breadcrumbParent = 'admin.wallets.index';
        $breadcrumbParentUrl = route('admin.wallets.index');
        return view(
            "admin.wallets.show",
            compact('wallet', 'statusOfWallet', 'breadcrumbParent', 'breadcrumbParentUrl')
        );
    }

    /**
     * Update Wallet Status [Active|Inactive].
     *
     * @param  UpdateWalletRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\View
     */
    public function update(UpdateWalletRequest $request, $id)
    {
        $result = $this->service->updateWalletStatus($id, $request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.wallets.show", $id);
        }

        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }

    /**
     * Manage the wallet balance for a customer.
     *
     * @param  int  $id
     * @return \View
     */
    public function manageWalleBalance(int $id, Request $request)
    {
        $wallet = $this->service->getWalletUsingID($id)->load('customer', 'admin');

        $transactions = $this->service->getWalletTransactionsWithPagination($id, 5, "DESC", $request);

        $statusOfWalletTransactionsHistory = WalletHistoryTypeStatus::getStatusListWithClass();
        $breadcrumbParent = 'admin.wallets.manageWalleBalance';
        $breadcrumbParentUrl = route('admin.wallets.show', ['wallet' => $id]);
        return view(
            "admin.wallets.manageWalleBalance",
            compact('wallet', 'transactions', 'statusOfWalletTransactionsHistory', 'breadcrumbParent', 'breadcrumbParentUrl')
        );
    }

    /**
     * Increase And Decrease Amount in wallet transaction history.
     *
     * @param  int  $id
     * @param Request $request
     * @return \Illuminate\Http\View
     */
    public function increaseAndDecreaseAmount(int $id, IncreaseAndDecreaseWalletBalanceRequest $request)
    {
        try {
            $wallet = Wallet::findOrFail($id);
            $message = $title = "";
            $job = null;
            switch($request->get('type')) {
                case WalletHistoryTypeStatus::ADD:
                    $success = CustomerWalletService::deposit($wallet->customer, $request->get('amount'), $request->get('transaction_type'));
                    $job = new DepositBalance($wallet->customer, $request->get('amount'));
                    $title = __("admin.customer_finances.wallets.transaction.success_add_title");
                    $message = __("admin.customer_finances.wallets.transaction.success_add_message");
                    break;
                case WalletHistoryTypeStatus::SUB:
                    $success = CustomerWalletService::withdraw($wallet->customer, $request->get('amount'), $request->get('transaction_type'));
                    $job = new BalanceWithdrawal($wallet->customer, $request->get('amount'));
                    $title = __("admin.customer_finances.wallets.transaction.success_sub_title");
                    $message = __("admin.customer_finances.wallets.transaction.success_sub_message");
                    break;
                default:
                    throw new Exception("Unkown wallet operation");
            }
            if ($success) {
                Alert::success($title, $message);
                if ($job) dispatch($job)->delay(5)->onQueue("customer-sms");
            } else Alert::error($title, $message);
        } catch (Exception $e) {
            Alert::error(__("admin.warning"), $e->getMessage());
        }

        return redirect(route('admin.wallets.manageWalleBalance', ['id' => $id]));
    }
}
