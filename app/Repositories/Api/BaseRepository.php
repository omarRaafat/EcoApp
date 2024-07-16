<?php

namespace App\Repositories\Api;

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
     * @return <Model|null>
     */
    public function all() : Model|null
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
     * Find a model using a specific column.
     *
     * @param string $column
     * @param string $value
     * @return Model
     */
    public function getSingleModelWhere(string $column, string $value) : Model
    {
        return $this->model->where($column, $value)->first();
    }

    

    /**
     * Create model record
     *
     * @param array $request
     * @return Model
     */
    public function store(array $request) : Model
    {
        $model = $this->model->newInstance($request);
        $model->save();
        return $model;
    }

    /**
     * Update model record for given id
     *
     * @param Model $request
     * @param array $request
     * @return Model
     */
    public function update(array $request,Model $model) : Model
    {
        $model->update($request);
        return $model;
    }
    /**
     * Update model record for givenid
     *
     * @param array $whereData
     * @param array $updatedValues
     * @return Model
     */
    public function updateOrCreate(array $whereData,array $updatedValues) : Model
    {
        $model=$this->model->updateOrCreate($whereData,$updatedValues);
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
     * Get count of collection.
     *
     * @return int
     */
    public function count() : int
    {
        return ($this->model->newQuery())->count();
    }
}

