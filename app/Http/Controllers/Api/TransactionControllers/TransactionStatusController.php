<?php

namespace App\Http\Controllers\Api\TransactionControllers;

use App\Http\Controllers\Api\ApiController;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionStatusController extends ApiController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $transaction = Transaction::where('code', $request->code)
            ->firstOrFail('status');

        return $this->setApiResponse(
            true,
            200,
            [
                'id' => $transaction->id,
                'status' =>  $transaction->status,
                'status_text' => $transaction->status_text,
            ],
            __('order.api.retrieved')
        );
    }
}
