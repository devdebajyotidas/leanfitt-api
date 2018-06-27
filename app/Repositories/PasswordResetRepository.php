<?php

namespace App\Repositories;

use App\Models\PasswordReset;
use App\Repositories\Contracts\PasswordResetRepositoryInterface;

class PasswordResetRepository extends BaseRepository implements PasswordResetRepositoryInterface
{
    public function model()
    {
        return new PasswordReset();
    }

    public function check($otp,$request_id){
        return $this->model()->where('code',$otp)->where('request_id',$request_id)->exists();
    }
}