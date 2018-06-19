<?php
namespace App\Repositories;

use App\Models\Admin;
use App\Repositories\Contracts\AdminRepositoryInterface;

class AdminRepository extends BaseRepository implements AdminRepositoryInterface
{

    public function model()
    {
        return new Admin();
    }

    /*Add -> call save function in base*/

    /*Remove-> call base functions*/
}