<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Contracts\BaseRepositoryInterface;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * Specify Model class name
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    abstract public function model();




    public function __construct()
    {
        $model = $this->model();

        if (!$model instanceof Model) {
            throw new Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function all($columns = ['*'])
    {
        return $this->model->all($columns);
    }

    /**
     * @inheritDoc
     */
    public function find($id, $columns = ['*'])
    {
        return $this->model->find($id)->get($columns);
    }

    /**
     * @inheritDoc
     */
    public function findBy($attribute, $value, $columns = ['*'])
    {
        return $this->model->where($attribute,$value)->get($columns);
    }

    /**
     * @inheritDoc
     */
    public function findWhere(array $where, $columns = ['*'])
    {
        return $this->model->where($where)->get($columns);
    }

    /**
     * @inheritDoc
     */
    public function findWhereIn($field, array $values, $columns = ['*'])
    {
        return $this->model->whereIn($field,$values)->get($columns);
    }

    /**
     * @inheritDoc
     */
    public function findWhereNotIn($field, array $values, $columns = ['*'])
    {
        return $this->model->whereNotIn($field,$values)->get($columns);
    }

    /**
     * @inheritdoc
     */
    public function first($columns = ['*'])
    {
        return $this->model->first($columns);
    }

    /**
     * @inheritDoc
     */
    public function firstOrNew(array $attributes = [])
    {
       return $this->model->firstOrNew($attributes);
    }

    /**
     * @inheritDoc
     */
    public function firstOrCreate(array $attributes = [])
    {
        return $this->model->firstOrCreate($attributes);
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes)
    {
        return $this->model->save($attributes);
    }

    /**
     * @inheritDoc
     */
    public function update(array $attributes, $id)
    {
        return $this->model->find($id)->update($attributes);
    }

    /**
     * @inheritDoc
     */
    public function delete($id)
    {
        return $this->model->delete($id);
    }


    /**
     * @inheritDoc
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function withCount($relations)
    {
        $this->model = $this->model->withCount($relations);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function whereHas($relation, $closure)
    {
        $this->model = $this->model->whereHas($relation, $closure);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function orderBy($column, $direction = 'asc')
    {
        $this->model = $this->model->orderBy($column, $direction);
        return $this;
    }

    public function renderJSON($data){
        return $data;
    }

    function isJson($data){
        json_decode($data);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public function renderArray($data)
    {
       if(is_array($data))
           return $data;
       else
           return array($data);
    }
}