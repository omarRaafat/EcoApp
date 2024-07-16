<?php
namespace App\Services\Vendors;

use App\Http\Requests\Vendor\TypeOfEmployee\Store;
use App\Models\TypeOfEmployee;
use Illuminate\Http\Request;

class TypeOfEmployeeServices{
    public function __construct(public TypeOfEmployee $typeOfEmployee){}
    public function index($perPage = 20)
    {
        $data = $this->typeOfEmployee
        ->where('vendor_id',auth()->user()->vendor_id)
        ->paginate($perPage);
        return view('vendor.type_of_employees.index',compact('data'));
    }
    public function create()
    {
        return view('vendor.type_of_employees.create');
    }
    public function store(Store $request)
    {
        $typeOfEmployee = $this->typeOfEmployee->create([
            'name' => $request->name,
            'level' => $request->level,
            'user_id' => auth()->user()->id,
            'vendor_id' => auth()->user()->vendor_id,
        ]);
        return redirect(route('vendor.type-of-employees.index'));
    }
    public function edit($id)
    {
        $data = $this->getModelById($id);
        return view('vendor.type_of_employees.edit',compact('data'));
    }
    public function update($id,Store $request)
    {
        $data = $this->getModelById($id);
        $data->update($request->validated());
        return redirect(route('vendor.type-of-employees.index'));
    }
    public function destroy($id)
    {
        $data = $this->getModelById($id);
        $data->delete();
        return redirect(route('vendor.type-of-employees.index'));
    }
    private function getModel()
    {
        return 'App\Models\TypeOfEmployee';
    }
    private function getModelById($id)
    {
        return $this->getModel()::findOrFail($id);
    }
}
