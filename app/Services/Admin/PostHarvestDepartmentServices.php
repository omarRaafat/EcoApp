<?php
namespace App\Services\Admin;

use App\Http\Requests\Admin\PostHarvestServicesDepartment\Store;
use App\Models\PostHarvestServicesDepartment;
use App\Models\PostHarvestServicesDepartmentField;
use Illuminate\Http\Request;

class PostHarvestDepartmentServices{
    public function __construct(public PostHarvestServicesDepartment $postHarvestServicesDepartment){}
    public function index($per = 20)
    {
        $name = request()->has('search') ? request()->get('search') : null;
        $status = request()->has('status') ? request()->get('status') : 'all';
        $data = $this->postHarvestServicesDepartment
                ->query()
                ->when($name && $name !== null, fn ($q) => $q->where('name', 'like', "%$name%"))
                ->when($status && $status !== 'all', fn ($q) => $q->where('status',$status))
                ->orderBy('id', 'desc')
                ->paginate($per);
        return view('admin.post-harvest-services-departments.index',compact('data'));
    }
    public function create()
    {
        return view('admin.post-harvest-services-departments.create');
    }
    public function store($data)
    {
        !isset($data['status']) ? $data['status'] = 'not_active' : $data['status'] = 'active';
        if(isset($data['image'])){
            $uploadImage = uploadFile($data['image'],'uploads/postHarvestServicesDepartment');
            $data['image'] = $uploadImage;
        }
        $postHarvest = $this->postHarvestServicesDepartment->create($data);
        return redirect(route('admin.post-harvest-services-departments.index'));
    }
    public function edit($id)
    {
        $data = $this->getModelById($id);
        return view('admin.post-harvest-services-departments.edit',compact('data'));
    }
    public function show($id)
    {
        $data = $this->getModelById($id);
        return view('admin.post-harvest-services-departments.show',compact('data'));
    }
    public function update($data,$id)
    {
        $postHarvest = $this->getModelById($id);
        !isset($data['status']) ? $data['status'] = 'not_active' : $data['status'] = 'active';
        if($data['image'] !== null){
            $uploadImage = uploadFile($data['image'],'uploads/postHarvestServicesDepartment');
            $data['image'] = $uploadImage;
            $postHarvest->update(['image' => $uploadImage]);
        }else{
            $postHarvest->update([
                'name' => $data['name'],
                'status' => $data['status']
            ]);
        }
        return redirect(route('admin.post-harvest-services-departments.index'));
    }
    public function destroy($id)
    {
        $data = $this->getModelById($id);
        $data->delete();
        return redirect(route('admin.post-harvest-services-departments.index'));
    }
    public function fields($id)
    {
        $postHarvest = $this->getModelById($id);
        $data = PostHarvestServicesDepartmentField::where('post_harvest_id',$id)
        ->orderBy('id','desc')
        ->get();
        return view('admin.post-harvest-services-departments.fields',compact('data','postHarvest'));
    }
    private function getModel()
    {
        return 'App\Models\PostHarvestServicesDepartment';
    }
    private function getModelById($id)
    {
        return $this->getModel()::findOrFail($id);
    }
}
