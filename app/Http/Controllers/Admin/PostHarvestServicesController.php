<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostHarvestServicesDepartment\Store;
use App\Services\Admin\PostHarvestDepartmentServices;

class PostHarvestServicesController extends Controller
{
    public function __construct(public PostHarvestDepartmentServices $postHarvestDepartmentServices){}
    public function index()
    {
        return $this->postHarvestDepartmentServices->index();
    }
    public function create()
    {
        return $this->postHarvestDepartmentServices->create();
    }
    public function store(Store $request)
    {
        return $this->postHarvestDepartmentServices->store($request->validated());
    }
    public function edit($id)
    {
        return $this->postHarvestDepartmentServices->edit($id);
    }
    public function show($id)
    {
        return $this->postHarvestDepartmentServices->show($id);
    }
    public function update(Store $request,$id)
    {
        return $this->postHarvestDepartmentServices->update($request,$id);
    }
    public function destroy($id)
    {
        return $this->postHarvestDepartmentServices->destroy($id);
    }
    public function fields($id)
    {
        return $this->postHarvestDepartmentServices->fields($id);
    }
}
