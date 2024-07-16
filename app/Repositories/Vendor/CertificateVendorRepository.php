<?php

namespace App\Repositories\Vendor;

use App\Models\CertificateVendor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;

class CertificateVendorRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return CertificateVendor::class;
    }

    public function store(Request $request) : Model
    {
        $model = $this->model->newInstance($request->toArray());
        $model->vendor_id=auth()->user()->vendor_id;
        $model->save();
        return $model;
    }
}