<?php

namespace App\Http\Controllers\Api;

use App\Services\Api\WalletService;
use App\Http\Controllers\Api\ApiController;

class WalletController extends ApiController
{
    /**
     * Wallet Controller Constructor.
     *
     * @param WalletService $service
     */
    public function __construct(public WalletService $service) {
        $this->middleware('api.auth');
    }

    public function totalAmount() {
        $response = $this->service->totalAmount(auth('api')->user());
        return $this->setApiResponse(
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }

    public function totalWithdraw() {
        $response = $this->service->getTotalWithdraw(auth('api')->user());
        return $this->setApiResponse(
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }

    public function getTransactions() {
        $response = $this->service->getAllTransactions(auth('api')->user());
        return $this->setApiResponse(
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }

    public function walletData() {
        $response = $this->service->getWalletData(auth('api')->user());
        return $this->setApiResponse(
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }
}
