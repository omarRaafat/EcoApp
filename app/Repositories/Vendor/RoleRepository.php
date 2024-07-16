<?php

namespace App\Repositories\Vendor;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;


class RoleRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return Role::class;
    }

    public function store(Request $request) : Model
    {
        $data=$request->all();
        $data['permissions']=json_encode($request->permissions);
        $data['vendor_id']=auth()->user()->vendor_id;
        $model = $this->model->newInstance($data);
        $model->save();
        return $model;
    }

    public function getRolesForSelect()
    {
        return $this->model->where('vendor_id',auth()->user()->vendor_id)->pluck('name','id')->toArray();
    }

    public function find(int $id): Model|null
    {
        $model = $this->model->where('vendor_id', auth()->user()->vendor_id)->find($id);
        if (!$model) return abort(404);
        return $model;
    }

    public function deleteById($id)
	{
		$this->model->where('vendor_id',auth()->user()->vendor_id)->where('id',$id)->delete();
		return true;
	}
}