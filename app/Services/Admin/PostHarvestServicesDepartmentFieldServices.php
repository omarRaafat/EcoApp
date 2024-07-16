<?php
namespace App\Services\Admin;

use App\Http\Requests\Admin\PostHarvestServicesDepartmentFeild\Store;
use App\Models\PostHarvestServicesDepartment;
use App\Models\PostHarvestServicesDepartmentField;
use RealRashid\SweetAlert\Facades\Alert;

class PostHarvestServicesDepartmentFieldServices
{
    public function __construct(public PostHarvestServicesDepartmentField $postHarvestServicesDepartmentField){}
    public function index($per = 20)
    {
        $data = $this->postHarvestServicesDepartmentField
                ->query()
                ->orderBy('id', 'desc')
                ->paginate($per);
        return view('admin.post-harvest-services-departments-fields.index',compact('data'));
    }
    public function create($id)
    {
        $postHarvestDepartment = PostHarvestServicesDepartment::findOrFail($id);
        return view('admin.post-harvest-services-departments-fields.create',compact('postHarvestDepartment'));
    }
    public function store($data)
    {
        !isset($data['status']) ? $data['status'] = 'not_active' : $data['status'] = 'active';
        isset($data['values']) ? json_encode($data['values']) :'';
        if(PostHarvestServicesDepartmentField::where('post_harvest_id',$data['post_harvest_id'])->where('name',$data['name'])->exists()){
            Alert::error('error message',trans('postHarvestServices.field_name_exists'));
            return redirect()->back();
        }
        $postHarvest = $this->postHarvestServicesDepartmentField->create($data);
        return redirect(route('admin.post-harvest-services-departments.fields',$data['post_harvest_id']));
    }
    public function edit($id)
    {
        $data = $this->getModelById($id);
        return view('admin.post-harvest-services-departments-fields.edit',compact('data'));
    }
    public function update($id,$data)
    {
        $field = $this->getModelById($id);
        !isset($data['status']) ? $data['status'] = 'not_active' : $data['status'] = 'active';
        isset($data['values']) ? json_encode($data['values']) :'';
        if(PostHarvestServicesDepartmentField::where('post_harvest_id',$field->post_harvest_id)
        ->where('id','!=',$field->id)
        ->where('name',$data['name'])->exists()){
            Alert::error('error message',trans('postHarvestServices.field_name_exists'));
            return redirect()->back();
        }
        $field->update($data);
        return redirect(route('admin.post-harvest-services-departments.fields',$field->post_harvest_id));
    }
    public function destroy($id)
    {
        $data = $this->getModelById($id);
        $data->delete();
        return redirect(route('admin.post-harvest-services-departments.fields',$data->post_harvest_id));
    }
    private function getModel()
    {
        return 'App\Models\PostHarvestServicesDepartmentField';
    }
    private function getModelById($id)
    {
        return $this->getModel()::findOrFail($id);
    }
}
