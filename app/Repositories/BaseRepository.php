<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Container\Container as Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class BaseRepository
{
    /**
     * Eloquent Model
     *
     * @var Model
     */
    protected $model;

    /**
     * Service Container
     *
     * @var Application
     */
    protected $app;

    /**
     * Construct the base repository.
     *
     * @param Application $app
     * @throws \Exception
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Configure the Model
     *
     * @return string
     */
    abstract public function model() : string;

    /**
     * Create new model instance
     *
     * @throws \Exception
     * @return Model
     */
    public function makeModel() : Model
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * Retrieve all records.
     *
     * @return Collection
     */
    public function all() : Model
    {
        return $this->model;
    }

    /**
     * Get Model Instance Using id.
     *
     * @param integer $id
     * @return Model
     */
    public function getModelUsingID(int $id) : Model|null
    {
        return $this->model->where("id", $id)->first();
    }
    /**
     * Create model record
     *
     * @param Request $request
     * @return Model
     */
    public function store(Request $request) : Model
    {
        $model = $this->model->newInstance($request->toArray());
        $model->save();
        return $model;
    }

    /**
     * Update model record for given id
     *
     * @param Model $request
     * @param Request $request
     * @return Model
     */
    public function update(Request $request,Model $model) : Model
    {
        $model->update($request->all());
        return $model;
    }

    /**
     * @param Model $model
     *
     * @throws \Exception
     * @return mixed
     */
    public function delete(Model $model) : mixed
    {
        return $model->delete();
    }

    /**
     * @param int $model_id
     *
     * @throws \Exception
     * @return mixed
     */
    public function deleteUsingID(int $model_id) : mixed
    {
        return $model->delete();
    }

    /**
     * Get count of collection.
     *
     * @return int
     */
    public function count() : int
    {
        return ($this->model->newQuery())->count();
    }
}
