<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\TypeOfEmployee\Store;
use App\Services\Vendors\TypeOfEmployeeServices;
use Illuminate\Http\Request;

class TypeOfEmployeeController extends Controller
{
    public function __construct(public TypeOfEmployeeServices $typeOfEmployeeServices){}
    public function index()
    {
        return $this->typeOfEmployeeServices->index();
    }
    public function create()
    {
        return $this->typeOfEmployeeServices->create();
    }
    public function store(Store $request)
    {
        return $this->typeOfEmployeeServices->store($request);
    }
    public function edit($id)
    {
        return $this->typeOfEmployeeServices->edit($id);
    }
    public function update($id,Store $request)
    {
        return $this->typeOfEmployeeServices->update($id,$request);
    }
    public function destroy($id)
    {
        return $this->typeOfEmployeeServices->destroy($id);
    }
}
