<?php

namespace App\Repositories\Api;

use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Repositories\Api\BaseRepository;


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
