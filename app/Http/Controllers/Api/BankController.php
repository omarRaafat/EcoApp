<?php

namespace App\Http\Controllers\Api;

use App\Enums\CustomHeaders;
use App\Models\Bank;
use Illuminate\Http\Response;
use App\Models\CustomerCashWithdrawRequest;
use App\Http\Requests\Api\CashWithdrawRequest;

class BankController extends ApiController
{
    public function index()
    {
        return $this->setApiResponse(
            true,
            Response::HTTP_OK,
            Bank::where("is_active", true)->get()->map(fn($e) => ['id' => $e->id, 'name' => $e->getTranslation('name', request()->header(CustomHeaders::LANG))])->toArray(),
            __('cashWithdrawRequest.messages.request-sent-to-admin')
        );
    }
}
