<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostHarvestServicesDepartmentFeild\Store;
use App\Models\PostHarvestServicesDepartment;
use App\Services\Admin\PostHarvestServicesDepartmentFieldServices;
use Illuminate\Http\Request;

class PostHarvestServicesDepartmentFieldController extends Controller
{
    public function __construct(public PostHarvestServicesDepartmentFieldServices $postHarvestServicesDepartmentFieldServices){}
    public function index()
    {
        return $this->postHarvestServicesDepartmentFieldServices->index();
    }
    public function create($id)
    {
        return $this->postHarvestServicesDepartmentFieldServices->create($id);
    }
    public function store(Store $request)
    {
        return $this->postHarvestServicesDepartmentFieldServices->store($request->validated());
    }
    public function edit($id)
    {
        return $this->postHarvestServicesDepartmentFieldServices->edit($id);
    }
    public function update($id,Store $request)
    {
        return $this->postHarvestServicesDepartmentFieldServices->update($id,$request->validated());
    }
    public function destroy($id)
    {
        return $this->postHarvestServicesDepartmentFieldServices->destroy($id);
    }
}
