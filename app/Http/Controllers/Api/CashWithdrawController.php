<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CashWithdrawRequest;
use App\Models\CustomerCashWithdrawRequest;
use Illuminate\Http\Response;

class CashWithdrawController extends ApiController
{
    public function store(CashWithdrawRequest $request)
    {
        $customer = auth('api')->user();
        $isSuccess = false;
        $statusCode = Response::HTTP_BAD_REQUEST;
        $msg = __('cashWithdrawRequest.messages.not-enough-balance');

        if (
            $customer->ownWallet &&
            ($customer->ownWallet->amount_with_sar ?? 0) >= $request->amount
        ) {
            CustomerCashWithdrawRequest::create([
                'customer_id' => $customer->id,
                'bank_id' => $request->get('bank_id'),
                'amount' => $request->get('amount'),
                'bank_account_name' => $request->get('bank_account_name'),
                'bank_account_iban' => $request->get('bank_account_iban'),
            ]);
            $isSuccess = true;
            $statusCode = Response::HTTP_OK;
            $msg = __('cashWithdrawRequest.messages.request-sent-to-admin');
        }

        return $this->setApiResponse($isSuccess, $statusCode, [], $msg);
    }
}
