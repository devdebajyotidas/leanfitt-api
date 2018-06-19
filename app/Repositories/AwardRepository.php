<?php

namespace App\Repositories;

use App\Models\Award;
use App\Models\Employee;
use App\Models\Organization;
use App\Repositories\Contracts\AwardRepositoryInterface;
use Illuminate\Support\Collection;

class AwardRepository extends BaseRepository implements AwardRepositoryInterface
{

    public function model()
    {
        return new Award();
    }

    public function employee(){
        return new Employee();
    }

    public function organization(){
        return new Organization();
    }

    public function getAllAwardbyDepartment($department): Collection
    {
        $ids=$this->employee()->where('department_id',$department)->pluck('user_id')->toArray();
        $results=$this->model()->whereIn('user_id',$ids)->with('user')->get();
        return $results;
    }

    public function getAllAwardsByUser($user): Collection
    {
        $results=$this->model()->where('user_id',$user)->with('user')->get();
        return $results;
    }

    public function getAllAwardByOrganization($organization): Collection
    {
        $deps=$this->organization()->find($organization)->departments()->pluck('id')->toArray();
        $ids=$this->employee()->whereIn('department_id',$deps)->pluck('user_id')->toArray();
        $results=$this->model()->whereIn('user_id',$ids)->with('user')->get();
        return $results;

        /*This is all wrong (lol).There should be max two query, redesign the database*/
    }

    /*Add->call base*/
}