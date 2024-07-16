<?php

namespace App\Repositories\Admin;

use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Models\WalletTransactionHistory;
use App\Repositories\Api\BaseRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;

class WalletRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return Wallet::class;
    }
}
