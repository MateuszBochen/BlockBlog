<?php

namespace System\User;

use System\User\UserEntity\MainUser;

class ActiveUser
{
    private $user;

    public function __construct()
    {

    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    /*public function toArray() {
        $props = array();
        
        foreach ((array)$this->user as $key => $value) {
            $props[str_replace('*', '', $key)] = $value;
        }

        return $props;
    }*/
}
