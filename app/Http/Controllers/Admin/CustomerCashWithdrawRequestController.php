<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CustomerWithdrawRequestEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CustomerWithdrawRequestUpdate;
use App\Models\CustomerCashWithdrawRequest;
use App\Services\Admin\CustomerCashWithdrawRequestService;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CustomerCashWithdrawRequestController extends Controller
{
    public function __construct(
        private CustomerCashWithdrawRequestService $service
    ) {}

    public function index(Request $request) {
        return view(
            "admin.customer-cash-withdraw.index",
            [
                'withdrawRequestCollection' => $this->service->getDataFiltered($request),
                'statuses' => CustomerWithdrawRequestEnum::statuses()
            ]
        );
    }

    public function show($id) {
        $model = $this->service->show($id);
        $breadcrumbParent = 'admin.customer-cash-withdraw.index';
        $breadcrumbParentUrl = route('admin.customer-cash-withdraw.index');
        return view(
            "admin.customer-cash-withdraw.show",
            [
                'withdrawRequest' => $model,
                'rows' => $this->service->getModelAsArray($model),
                'statuses' => CustomerWithdrawRequestEnum::statuses(),
                'breadcrumbParent' => $breadcrumbParent,
                'breadcrumbParentUrl' => $breadcrumbParentUrl
            ]
        );
    }

    public function update( CustomerWithdrawRequestUpdate $request, CustomerCashWithdrawRequest $withdrawRequest) {
        $alertBodyMsgBase = "admin.customer_finances.customer-cash-withdraw.messages";
        $alertTitleMsgBase = "admin.static-content.messages";

        $request->merge(['admin_id' => auth()->user()->id]);

        if ($withdrawRequest->admin_action != CustomerWithdrawRequestEnum::PENDING) {
            Alert::warning(__("$alertTitleMsgBase.warning") ,__("$alertBodyMsgBase.status-not-pending"));
        }
        else if ($request->status == CustomerWithdrawRequestEnum::NOT_APPROVED) {
            $this->service->reject($withdrawRequest, $request);
            Alert::success(__("$alertTitleMsgBase.success") ,__("$alertBodyMsgBase.status-set-to-not-approved"));
        }
        else if ($request->status == CustomerWithdrawRequestEnum::APPROVED) {
            try {
                $this->service->approve($withdrawRequest, $request);
                Alert::success(__("$alertTitleMsgBase.success"), __("$alertBodyMsgBase.status-set-to-approved"));
            } catch (Exception $e) {
                Alert::error(__("$alertTitleMsgBase.error"), $e->getMessage());
            }
        }
        return redirect()->back();
    }
}
