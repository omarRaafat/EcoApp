<?php

namespace App\Repositories\Api;

use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Repositories\Api\BaseRepository;


class VendorRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return Vendor::class;
    }

    public function getVendorIfAvailable($id)
    {
        return $this->model->where("id", $id)->available()->first();
    }


    public function calculateRate(int $vendor_id)
    {
        $vendor = $this->model->findOrFail($vendor_id);
        
        $rate = $vendor->approvedUserVendorRates()->avg('rate');
        $count = $vendor->approvedUserVendorRates()->count();

        $vendor->rate = round($rate);
        $vendor->ratings_count = $count;
        $vendor->save();
    }
}
