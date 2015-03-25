<?php

namespace System\User;

use System\User\UserEntity\UserEntity;

class UserManager
{
    private $userArray = [];
    private $crud;

    public function __construct($crud)
    {
        $this->crud = $crud;
    }

    public function getUserBy($id)
    {
        if (isset($this->userArray[$id])) {
            return $this->userArray[$id]
        }

        $user = $this->crud->read(new UserEntity(), ['id' => $id]);

        return $this->userArray[$user->getId()] = $user;
    }
    
    
}
