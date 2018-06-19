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

    public function all()
    {
        return $this->model->all();
    }

    public function __construct()
    {
        $model = $this->model();

        if (!$model instanceof Model) {
            throw new Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        $this->model = $model;
    }

    public function get()
    {
        return $this->model->get();
    }

    public function first()
    {
        return $this->model->first();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function where($col, $value, $operator='=')
    {
        $this->model=$this->model->where($col,$operator,$value);
        return $this;
    }

    public function orWhere($col, $value)
    {
        $this->model=$this->model->orWhere($col,$value);
        return $this;
    }

    public function whereIn($col, $values)
    {
        $this->model=$this->model->orWhere($col,$values);
        return $this;
    }

    public function whereBetween($col, $value1, $value2)
    {
        $this->model=$this->model->orWhere($col,[$value1,$value2]);
        return $this;
    }

    public function withTrashed()
    {
        $this->model=$this->model->withTrashed();
        return $this;
    }

    public function exist($col,$value,$operator='=')
    {
        return $this->model->where($col,$operator,$value)->exists();
    }

    public function count(){
        return $this->model->count();
    }

    public function save($attributes)
    {
        return $this->model->save($attributes);
    }

    public function create($attributes)
    {
        return $this->model->create($attributes);
    }

    public function update($id,$attributes)
    {
        return $this->model->find($id)->update($attributes);
    }

    public function archive($id)
    {
        return $this->model->find($id)->udpate(['is_archived'=>1]);
    }

    public function restore($id)
    {
        return $this->model->find($id)->udpate(['is_archived'=>0]);
    }

    public function forceDelete($id)
    {
        return $this->model->find($id)->forceDelete();
    }

}