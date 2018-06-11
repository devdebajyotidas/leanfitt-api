<?php

namespace App\Repositories;

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
        return $this->renderJSON($this->model->all($columns));
    }

    /**
     * @inheritDoc
     */
    public function find($id, $columns = ['*'])
    {
        // TODO: Implement find() method.
    }

    /**
     * @inheritDoc
     */
    public function findBy($attribute, $value, $columns = ['*'])
    {
        // TODO: Implement findBy() method.
    }

    /**
     * @inheritDoc
     */
    public function findWhere(array $where, $columns = ['*'])
    {
        // TODO: Implement findWhere() method.
    }

    /**
     * @inheritDoc
     */
    public function findWhereIn($field, array $values, $columns = ['*'])
    {
        // TODO: Implement findWhereIn() method.
    }

    /**
     * @inheritDoc
     */
    public function findWhereNotIn($field, array $values, $columns = ['*'])
    {
        // TODO: Implement findWhereNotIn() method.
    }

    /**
     * @inheritdoc
     */
    public function first($columns = ['*'])
    {

    }

    /**
     * @inheritDoc
     */
    public function firstOrNew(array $attributes = [])
    {
        // TODO: Implement firstOrNew() method.
    }

    /**
     * @inheritDoc
     */
    public function firstOrCreate(array $attributes = [])
    {
        // TODO: Implement firstOrCreate() method.
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes)
    {
        // TODO: Implement create() method.
    }

    /**
     * @inheritDoc
     */
    public function update(array $attributes, $id)
    {
        // TODO: Implement update() method.
    }

    /**
     * @inheritDoc
     */
    public function delete($id)
    {
        // TODO: Implement delete() method.
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

    public function renderJSON()
    {

    }

    public function renderArray()
    {

    }
}