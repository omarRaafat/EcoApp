<?php

namespace App\Repositories\Vendor;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


class UserRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model(): string
    {
        return User::class;
    }

    /**
     * Get Model Instance Using id.
     *
     * @param integer $id
     * @return Model
     */
    public function getUserWithRoleUsingID(int $id): Model|null
    {
        $model = $this->model->where("id", $id)->where('vendor_id', auth()->user()->vendor_id)->where('type', 'sub-vendor')->first();
        if (!isset($model)) return abort(404);
        $model->role_id = ($model->roles()->first()) ? $model->roles()->first()->id : null;
        return $model;
    }

    public function store(Request $request): Model
    {
        $data = $request->all();
        $data['vendor_id'] = auth()->user()->vendor_id;
        $data['type'] = 'sub-vendor';
        $model = $this->model->newInstance($data);
        $model->save();
        if (isset($request->role_id)) {
            $model->roles()->sync([$request->role_id]);
        }
        return $model;
    }

    public function update(Request $request, Model $model): Model
    {
        $data = $request->all();
        if (!isset($request->is_banned)) {
            $data['is_banned'] = 0;
        }
        $model->update($data);
        if (isset($request->role_id)) {
            $model->roles()->sync([$request->role_id]);
        }
        return $model;
    }
}
