<?php

namespace App\Repositories\Vendor;

use App\Models\Certificate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;


class CertificateRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return Certificate::class;
    }

    public function getCertificatesForSelect()
    {
        return $this->model->pluck('title','id')->toArray();
    }
}