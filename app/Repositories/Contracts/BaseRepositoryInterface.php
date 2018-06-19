<?php

namespace App\Repositories\Contracts;

interface BaseRepositoryInterface
{
    public function all();

    public function get();

    public function first();

    public function find($id);

    public function where($col,$value,$operator);

    public function orWhere($col, $value);

    public function whereIn($col, $values);

    public function whereBetween($col, $value1, $value2);

    public function withTrashed();

    public function exist($col,$value);

    public function count();

    public function save($attributes);

    public function create($attributes);

    public function update($id,$attributes);

    public function archive($id);

    public function restore($id);

    public function forceDelete($id);

}