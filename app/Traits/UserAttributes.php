<?php

namespace App\Traits;

use App\Models\User;

trait UserAttributes
{
    private function getUser()
    {
        $user = null;

        if($this instanceof User)
            $user = $this;
        else
            $user = $this->user;

        return $user;
    }

    public function getFirstName()
    {
        $user = $this->getUser();
        return ucfirst($user->first_name);
    }

    public function getLastName()
    {
        $user = $this->getUser();
        return ucfirst($user->last_name);
    }

    public function getEmail()
    {
        $user = $this->getUser();
        return $user->email;
    }

    public function getPhone()
    {
        $user = $this->getUser();
        return $user->phone;
    }

    public function getFullName()
    {
        return $this->getFirstName() . " " . $this->getLastName();
    }

    public function getAvatar()
    {
        $user = $this->getUser();
        $avatar = $user->avatar;

        if (!$avatar)
        {
            $avatar = "https://ui-avatars.com/api/?name=" . urlencode($this->getFullName());
        }
        return $avatar;
    }
}