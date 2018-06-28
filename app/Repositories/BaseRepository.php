<?php

namespace App\Repositories;

use App\Models\Admin;
use App\Models\Employee;
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

    public function whereNotNull($col)
    {
        $this->model=$this->model->whereNotNull($col);
        return $this;
    }

    public function with($relation)
    {
        $this->model=$this->model->with($relation);
        return $this;
    }

    public function withCount($relation)
    {
        $this->model = $this->model->withCount($relation);
        return $this;
    }

    public function withTrashed()
    {
        $this->model=$this->model->withTrashed();
        return $this;
    }

    public function exists()
    {
        return $this->model->exists();
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
        $query=$this->model->find($id);
        $query->is_archived=1;
        return $query->update();

    }

    public function restore($id)
    {
        $query=$this->model->find($id);
        $query->is_archived=0;
        return $query->update();
    }

    public function forceDelete($id)
    {
        return $this->model->find($id)->forceDelete();
    }

    public function updateOrCreate(array $attributes, array $values = []){
        return $this->model->updateOrCreate($attributes,$values);
    }

    public function fillUpdate($record,$data){
        return $record->update($data);
    }

    public function getAdmin($user_id){
        $query=Admin::where('user_id',$user_id)->first();
        return isset($query) ? $query->id : null;
    }

    public function getEmployee($user_id){
        $query=Employee::where('user_id',$user_id)->first();
        return isset($query) ? $query->id : null;
    }

    public function getUser($id,$type){
        if($type=='employee'){
            $query=Employee::find($id);
        }
        else{
            $query=Admin::find($id);
        }
        return isset($query) ? $query->user_id : null;
    }

    public function deletQuery($query){
        return $query->delete();
    }

    public function forceDeleteRecord($record)
    {
        return $record->forceDelete();
    }

    public function isAdmin($user_id){
        return Admin::where('user_id',$user_id)->exists();
    }

    public function isSuperAdmin($user_id){
        return Admin::where('user_id',$user_id)->where('is_superadmin',1)->exists();
    }
}