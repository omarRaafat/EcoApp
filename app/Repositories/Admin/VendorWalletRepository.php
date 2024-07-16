<?php

namespace App\Repositories\Admin;

use App\Models\VendorWallet;
use App\Repositories\Api\BaseRepository;

class VendorWalletRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return VendorWallet::class;
    }
}
