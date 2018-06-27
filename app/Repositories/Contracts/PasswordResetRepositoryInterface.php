<?php

namespace App\Repositories\Contracts;


interface PasswordResetRepositoryInterface
{
   public function check($otp,$request_id);
}