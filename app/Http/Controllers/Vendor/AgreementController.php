<?php

namespace App\Http\Controllers\Vendor;

use Exception;
use App\Models\User;
use App\Enums\UserTypes;
use Illuminate\Support\Str;
use App\Services\VendorAgreement;
use App\Enums\VendorAgreementEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class AgreementController extends Controller
{
    public function __construct(
        private VendorAgreement $agreementService
    ) {}

    public function index() : View {
        $user = $this->getVendorUser()->load("vendor");
        $collection = $user->vendor->agreements()->descOrder()->paginate(15);
        return view("vendor.agreements.index", ['collection' => $collection]);
    }

    public function approve() : RedirectResponse {
        $user = $this->getVendorUser()->load("vendor");

        $agreement = $user->type == UserTypes::VENDOR ? $user->vendor->agreements()->pending()->first() : null;
        if (is_null($agreement)) {
            return redirect()->back()->with("error", __("vendors.no-agreement-requested"));
        }

        try {
            DB::beginTransaction();
            $agreement->status = VendorAgreementEnum::APPROVED;
            $agreement->approved_by = $user->id;
            $agreement->approved_at = now()->toDateTimeString();
            $agreement->approved_pdf = $this->agreementService->fillPdfFile($agreement->agreement_pdf_path, $user);
            $agreement->save();
            
            DB::commit();
        } catch (Exception $e) {
            $msg = $e->getMessage();
            DB::rollBack();
            Log::error("agreement_id: {$agreement->id} Vendor Agreement Exception: ". $msg);
            $error = __("vendors.cant-approved-agreement");
            if (Str::contains($msg, "FPDI")) $error .= " $msg";
            return redirect()->back()->with("error", $error);
        }

        return redirect()->back()->with("success", __("vendors.you-have-approved-agreement"));
    }

    private function getVendorUser() : User {
        return auth()->user();
    }
}
