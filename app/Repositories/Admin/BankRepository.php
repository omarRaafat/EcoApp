<?php

namespace App\Repositories\Admin;

use App\Models\Bank;
use Illuminate\Support\Collection;
use App\Repositories\Api\BaseRepository;

class BankRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return Bank::class;
    }

    /**
     * Get List Of banks As collection For Select Menu
     * 
     * @return Collection
     */
    public function banksMenu() : Collection
    {
        return $this->all()->get();
    }
}
