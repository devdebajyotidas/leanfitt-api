<?php

namespace App\Services\Contracts;


interface AuthServiceInterface
{
    public function login($request);

    public function switchAccount($request); /*To switch between organizations or employee*/

    public function recovery($request);

    public function checkResetCode($code);

    public function updatePassword($request);

}