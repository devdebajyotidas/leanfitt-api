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

    public function getFirstNameAttribute()
    {
        $user = $this->getUser();
        return ucfirst($user->attribute['first_name']);
    }

    public function getLastNameAttribute()
    {
        $user = $this->getUser();
        return ucfirst($user->attribute['last_name']);
    }

    public function getEmailAttribute()
    {
        $user = $this->getUser();
        return $user->attribute['email'];
    }

    public function getPhoneAttribute()
    {
        $user = $this->getUser();
        return $user->attribute['phone'];
    }

    public function getFullName()
    {
        return $this->getFirstName() . " " . $this->getLastName();
    }

    public function getAvatarAttribute()
    {
        $user = $this->getUser();
        $avatar = $user->attribute['avatar'];

        if (!$avatar)
        {
            $avatar = "https://ui-avatars.com/api/?name=" . urlencode($this->getFullName());
        }
        return $avatar;
    }
}