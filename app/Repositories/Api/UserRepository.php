<?php

namespace App\Repositories\Api;

use App\Models\User;
use App\Enums\UserTypes;
use Illuminate\Http\Request;
use App\Repositories\Api\BaseRepository;


class UserRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return User::class;
    }

    public function getModelUsingPhone($phone, string $userType) : User|null
    {
        if(!$userType) {
            throw new \InvalidArgumentException("User Type Is Required");
        }

        if($userType == UserTypes::CUSTOMER) {
            return $this->model->where("type", UserTypes::CUSTOMER)->where('phone',$phone)->first();
        }

        if($userType == "VENDOR_USER") {
            return $this->model->whereIn("type", [
                UserTypes::VENDOR,
                UserTypes::SUBVENDOR,
            ])->where('phone',$phone)->first();
        }

        return null;
    }
}